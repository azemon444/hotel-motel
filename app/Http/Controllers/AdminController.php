<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\PaymentSync;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(private PaymentSync $payments) {}

    public function bookings(Request $request): JsonResponse
    {
        if ($request->isMethod('get')) {
            if (! $request->session()->get('admin_authenticated')) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }

            $this->payments->syncPendingBookings();

            return response()->json(
                Booking::latest()
                    ->get()
                    ->map(fn (Booking $b) => $this->present($b))
                    ->values()
            );
        }

        if ($request->input('logout')) {
            $request->session()->invalidate();

            return response()->json(['ok' => true]);
        }

        if ($request->filled('password')) {
            $expected = (string) config('admin.password');

            if ($expected !== '' && hash_equals($expected, (string) $request->input('password'))) {
                $request->session()->migrate(true);
                $request->session()->put('admin_authenticated', true);

                return response()->json(['ok' => true, 'token' => csrf_token()]);
            }

            return response()->json(['error' => 'Invalid password'], 401);
        }

        return response()->json(['error' => 'Bad request'], 400);
    }

    /**
     * @return array<string, mixed>
     */
    private function present(Booking $booking): array
    {
        return [
            'id' => $booking->booking_id ?: $booking->id,
            'date' => $booking->created_at?->toDateTimeString(),
            'customer' => [
                'name' => $booking->name,
                'email' => $booking->email,
                'phone' => $booking->phone,
            ],
            'booking' => [
                'roomName' => $booking->room_name,
                'checkin' => $booking->checkin?->toDateString(),
                'checkout' => $booking->checkout?->toDateString(),
                'nights' => $booking->nights,
                'guests' => $booking->guests,
                'requests' => $booking->requests,
            ],
            'payment' => [
                'status' => $booking->status,
                'amount' => (float) $booking->amount,
                'currency' => strtoupper((string) $booking->currency),
                'subtotal' => (float) $booking->subtotal,
                'tax' => (float) $booking->tax,
                'payment_intent' => $booking->payment_intent,
                'stripe_status' => $booking->stripe_status,
                'stripe_charge_id' => $booking->stripe_charge_id,
                'payment_method' => $booking->payment_method,
                'card_brand' => $booking->card_brand,
                'card_last4' => $booking->card_last4,
                'receipt_url' => $booking->receipt_url,
                'amount_received' => $booking->amount_received !== null ? (float) $booking->amount_received : null,
                'stripe_fee' => $booking->stripe_fee !== null ? (float) $booking->stripe_fee : null,
                'net_amount' => $booking->net_amount !== null ? (float) $booking->net_amount : null,
                'refunded_amount' => (float) $booking->refunded_amount,
                'refund_status' => $booking->refund_status,
                'refunds' => $booking->refunds ?: [],
                'created' => $booking->created_at?->toDateTimeString(),
                'updated' => $booking->updated_at?->toDateTimeString(),
                'failure_message' => $booking->failure_message,
                'failure_code' => $booking->failure_code,
                'failure_decline_code' => $booking->failure_decline_code,
                'dashboard_url' => $this->stripeDashboardUrl($booking->payment_intent),
            ],
            'payment_history' => $booking->payment_history ?: [],
        ];
    }

    private function stripeDashboardUrl(?string $paymentIntent): ?string
    {
        if (! $paymentIntent) {
            return null;
        }

        $testMode = ! str_starts_with((string) config('services.stripe.secret'), 'sk_live');

        return 'https://dashboard.stripe.com/'.($testMode ? 'test/' : '').'payments/'.$paymentIntent;
    }
}
