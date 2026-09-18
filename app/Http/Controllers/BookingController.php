<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\PaymentSync;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;
use Stripe\Webhook;

class BookingController extends Controller
{
    public function __construct(private PaymentSync $payments) {}

    public function show()
    {
        return view('booking');
    }

    public function pay()
    {
        return view('pay');
    }

    public function createIntent(Request $request): JsonResponse
    {
        $data = $request->validate([
            'roomType' => ['required', 'string', 'in:studio,onebed,twobed,custom'],
            'roomName' => ['nullable', 'string', 'max:255'],
            'checkin' => ['nullable', 'required_unless:roomType,custom', 'date', 'after_or_equal:today'],
            'checkout' => ['nullable', 'required_unless:roomType,custom', 'date', 'after:checkin'],
            'guests' => ['nullable', 'integer', 'min:1', 'max:10'],
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'requests' => ['nullable', 'string', 'max:2000'],
            'promo' => ['nullable', 'string', 'max:50'],
            'amount' => ['nullable', 'numeric', 'min:0.5', 'max:10000'],
        ]);

        $roomType = $data['roomType'];
        $promo = $data['promo'] ?? null;

        if ($roomType === 'custom') {
            $nights = 1;
            $guests = 1;
            $checkin = null;
            $checkout = null;
            $quote = Booking::quote('custom', 1, $promo, (float) ($data['amount'] ?? 0));
        } else {
            $checkin = $data['checkin'];
            $checkout = $data['checkout'];
            $nights = max(1, (int) Carbon::parse($checkin)->diffInDays(Carbon::parse($checkout)));
            $guests = (int) ($data['guests'] ?? 1);
            $quote = Booking::quote($roomType, $nights, $promo);
        }

        $amountCents = (int) round($quote['total'] * 100);
        $secret = config('services.stripe.secret');

        if (! $this->payments->hasRealStripeKey($secret)) {
            return response()->json(['error' => 'Payment is not available at the moment.'], 503);
        }

        $bookingId = 'booking_'.bin2hex(random_bytes(16));

        try {
            $stripe = new StripeClient($secret);
            $intent = $stripe->paymentIntents->create([
                'amount' => $amountCents,
                'currency' => 'eur',
                'payment_method_types' => ['card'],
                'metadata' => [
                    'booking_id' => $bookingId,
                    'customer_name' => $data['firstName'].' '.$data['lastName'],
                    'customer_email' => $data['email'],
                    'room_type' => $roomType,
                ],
            ]);

            Booking::create([
                'booking_id' => $bookingId,
                'name' => $data['firstName'].' '.$data['lastName'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? null,
                'room_type' => $roomType,
                'room_name' => $data['roomName'] ?? '',
                'checkin' => $checkin,
                'checkout' => $checkout,
                'nights' => $nights,
                'guests' => $guests,
                'requests' => $data['requests'] ?? null,
                'amount' => $quote['total'],
                'subtotal' => $quote['subtotal'],
                'tax' => $quote['tax'],
                'currency' => 'EUR',
                'status' => 'pending',
                'payment_intent' => $intent->id,
                'stripe_status' => $intent->status,
                'payment_history' => [[
                    'status' => 'pending',
                    'message' => 'Payment initiated',
                    'timestamp' => now()->toDateTimeString(),
                    'ip' => $request->ip(),
                ]],
            ]);

            return response()->json([
                'clientSecret' => $intent->client_secret,
                'paymentIntentId' => $intent->id,
                'bookingId' => $bookingId,
                'amount' => $quote['total'],
                'subtotal' => $quote['subtotal'],
                'tax' => $quote['tax'],
                'nights' => $nights,
                'guests' => $guests,
            ]);
        } catch (\Exception $e) {
            Log::error('Stripe payment intent creation failed', [
                'error' => $e->getMessage(),
            ]);

            return response()->json(['error' => 'Unable to start the payment. Please try again.'], 502);
        }
    }

    public function confirm(Request $request): JsonResponse
    {
        $intentId = $request->input('payment_intent') ?? $request->query('payment_intent');

        if (! $intentId) {
            return response()->json(['error' => 'payment_intent required'], 422);
        }

        $booking = Booking::where('payment_intent', $intentId)->first();

        if (! $booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $secret = config('services.stripe.secret');

        if (! $this->payments->hasRealStripeKey($secret)) {
            // Without real Stripe credentials we cannot verify a payment. Allow
            // the development flow only; never mark bookings paid in production.
            if (! app()->environment(['local', 'testing'])) {
                return response()->json(['error' => 'Payment verification unavailable'], 503);
            }

            $alreadyConfirmed = $booking->status === 'paid';
            $this->payments->markPaid($booking);

            return response()->json($alreadyConfirmed
                ? ['ok' => true, 'already_confirmed' => true]
                : ['ok' => true]);
        }

        $paymentIntent = $this->payments->retrieveIntent($intentId);

        if (! $paymentIntent) {
            return response()->json(['error' => 'Could not verify payment'], 502);
        }

        if (($paymentIntent->status ?? null) === 'succeeded') {
            $alreadyConfirmed = $booking->status === 'paid';
            $this->payments->markPaid($booking, $paymentIntent);

            return response()->json($alreadyConfirmed
                ? ['ok' => true, 'already_confirmed' => true]
                : ['ok' => true]);
        }

        if ($paymentIntent->last_payment_error ?? null) {
            $this->payments->recordFailure($booking, $paymentIntent);
        }

        return response()->json([
            'error' => 'Payment has not succeeded',
            'status' => $paymentIntent->status ?? null,
        ], 409);
    }

    public function webhook(Request $request): JsonResponse
    {
        $secret = config('services.stripe.webhook_secret');

        if (! $secret) {
            return response()->json(['error' => 'Webhook not configured'], 503);
        }

        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                (string) $request->header('Stripe-Signature'),
                $secret,
            );
        } catch (\Exception $e) {
            Log::warning('Stripe webhook signature verification failed', ['error' => $e->getMessage()]);

            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $object = $event->data->object ?? null;

        if (! $object) {
            return response()->json(['received' => true]);
        }

        if ($event->type === 'charge.refunded') {
            $booking = Booking::where('stripe_charge_id', $object->id)
                ->orWhere('payment_intent', $object->payment_intent ?? null)
                ->first();

            if ($booking) {
                $this->payments->recordRefund($booking, $object);
            }

            return response()->json(['received' => true]);
        }

        $intentId = $object->id ?? null;
        $booking = $intentId ? Booking::where('payment_intent', $intentId)->first() : null;

        if ($booking) {
            if ($event->type === 'payment_intent.succeeded') {
                $this->payments->markPaid($booking, $this->payments->retrieveIntent($intentId));
            } elseif ($event->type === 'payment_intent.payment_failed') {
                $this->payments->recordFailure($booking, $object);
            } elseif ($event->type === 'payment_intent.canceled') {
                $this->payments->markCancelled($booking);
            }
        }

        return response()->json(['received' => true]);
    }
}
