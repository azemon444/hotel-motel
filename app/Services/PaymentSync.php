<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

class PaymentSync
{
    private ?StripeClient $stripe = null;

    private ?object $intents = null;

    public function __construct(?StripeClient $stripe = null, ?object $intents = null)
    {
        $this->stripe = $stripe;
        $this->intents = $intents;
    }

    /**
     * Reconcile every pending booking against its live Stripe intent so the
     * admin never shows stale state (e.g. pending after a decline or cancel).
     */
    public function syncPendingBookings(): int
    {
        $synced = 0;

        foreach (Booking::where('status', 'pending')->whereNotNull('payment_intent')->get() as $booking) {
            if ($this->sync($booking)) {
                $synced++;
            }
        }

        return $synced;
    }

    /**
     * Bring a single booking in line with its Stripe PaymentIntent.
     *
     * @return bool true when the booking changed state
     */
    public function sync(Booking $booking): bool
    {
        $intentId = $booking->payment_intent;

        if (! $intentId || ! $this->hasRealStripeKey(config('services.stripe.secret'))) {
            return false;
        }

        try {
            $intent = $this->intents()->retrieve($intentId, [
                'expand' => ['latest_charge'],
            ]);
        } catch (\Exception $e) {
            Log::warning('Stripe booking sync failed', [
                'payment_intent' => $intentId,
                'error' => $e->getMessage(),
            ]);

            return false;
        }

        $status = $intent->status ?? null;

        if ($status === 'succeeded') {
            $this->markPaid($booking, $intent);

            return true;
        }

        if ($status === 'canceled') {
            $this->markCancelled($booking);

            return true;
        }

        if (($intent->last_payment_error ?? null) !== null) {
            $this->recordFailure($booking, $intent);

            return true;
        }

        if ($booking->stripe_status !== $status) {
            $booking->update(['stripe_status' => $status]);
        }

        return false;
    }

    public function markPaid(Booking $booking, ?object $intent = null): void
    {
        if ($booking->status === 'paid') {
            $booking->update($this->extractPaymentDetails($intent));

            return;
        }

        $history = $booking->payment_history ?: [];
        $history[] = [
            'status' => 'paid',
            'message' => 'Payment confirmed',
            'timestamp' => now()->toDateTimeString(),
            'stripe_event' => 'payment_intent.succeeded',
        ];

        $booking->update(array_merge([
            'status' => 'paid',
            'stripe_status' => 'succeeded',
            'failure_message' => null,
            'failure_code' => null,
            'failure_decline_code' => null,
            'payment_history' => $history,
        ], $this->extractPaymentDetails($intent)));
    }

    public function markCancelled(Booking $booking): void
    {
        if ($booking->status === 'cancelled') {
            return;
        }

        $history = $booking->payment_history ?: [];
        $history[] = [
            'status' => 'cancelled',
            'message' => 'Payment was canceled',
            'timestamp' => now()->toDateTimeString(),
            'stripe_event' => 'payment_intent.canceled',
        ];

        $booking->update([
            'status' => 'cancelled',
            'stripe_status' => 'canceled',
            'payment_history' => $history,
        ]);
    }

    public function recordFailure(Booking $booking, object $intent): void
    {
        $error = $intent->last_payment_error ?? null;

        if (! $error) {
            return;
        }

        $history = $booking->payment_history ?: [];
        $history[] = [
            'status' => 'failed',
            'message' => $error->message ?? 'Payment failed',
            'code' => $error->code ?? null,
            'decline_code' => $error->decline_code ?? null,
            'timestamp' => now()->toDateTimeString(),
            'stripe_event' => 'payment_intent.payment_failed',
        ];

        $update = [
            'status' => 'failed',
            'stripe_status' => $intent->status ?? 'failed',
            'failure_message' => $error->message ?? 'Payment failed',
            'failure_code' => $error->code ?? null,
            'failure_decline_code' => $error->decline_code ?? null,
            'payment_history' => $history,
        ];

        $paymentMethod = $error->payment_method ?? null;

        if (is_object($paymentMethod)) {
            if (isset($paymentMethod->type)) {
                $update['payment_method'] = $paymentMethod->type;
            }

            $card = $paymentMethod->card ?? null;

            if ($card) {
                $update['card_brand'] = $card->brand ?? null;
                $update['card_last4'] = $card->last4 ?? null;
            }
        }

        $booking->update($update);
    }

    public function recordRefund(Booking $booking, object $charge): void
    {
        $amountCents = (int) ($charge->amount_refunded ?? 0);
        $refunded = round($amountCents / 100, 2);
        $chargeAmount = (int) ($charge->amount ?? 0);

        $refunds = $booking->refunds ?: [];

        $refundsObject = $charge->refunds ?? null;
        $refundList = is_object($refundsObject) ? ($refundsObject->data ?? []) : [];

        foreach ($refundList as $refund) {
            $refunds[] = [
                'id' => $refund->id ?? null,
                'amount' => round(((int) ($refund->amount ?? 0)) / 100, 2),
                'currency' => $refund->currency ?? null,
                'status' => $refund->status ?? null,
                'reason' => $refund->reason ?? null,
                'created' => isset($refund->created) ? now()->createFromTimestamp($refund->created)->toDateTimeString() : null,
            ];
        }

        if (empty($refundList)) {
            $refunds[] = [
                'id' => null,
                'amount' => $refunded,
                'currency' => $charge->currency ?? null,
                'status' => 'succeeded',
                'reason' => null,
                'created' => now()->toDateTimeString(),
            ];
        }

        $history = $booking->payment_history ?: [];
        $history[] = [
            'status' => 'refunded',
            'message' => 'Refund of '.number_format($refunded, 2).' '.strtoupper((string) $charge->currency).' processed',
            'timestamp' => now()->toDateTimeString(),
            'stripe_event' => 'charge.refunded',
        ];

        $booking->update([
            'status' => $chargeAmount > 0 && $amountCents >= $chargeAmount ? 'refunded' : 'paid',
            'refunded_amount' => $refunded,
            'refund_status' => $amountCents <= 0 ? null : ($chargeAmount > 0 && $amountCents >= $chargeAmount ? 'full' : 'partial'),
            'refunds' => $refunds,
            'stripe_charge_id' => $charge->id ?? $booking->stripe_charge_id,
            'payment_history' => $history,
        ]);
    }

    public function retrieveIntent(?string $intentId): ?object
    {
        if (! $intentId || ! $this->hasRealStripeKey(config('services.stripe.secret'))) {
            return null;
        }

        try {
            return $this->intents()->retrieve($intentId, [
                'expand' => ['latest_charge'],
            ]);
        } catch (\Exception $e) {
            Log::warning('Stripe payment intent retrieve failed', [
                'payment_intent' => $intentId,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    public function hasRealStripeKey(?string $secret): bool
    {
        return is_string($secret) && $secret !== '' && ! str_contains($secret, 'replace_me');
    }

    /**
     * Pull charge, card, fee and receipt metadata off a PaymentIntent.
     *
     * @return array<string, string|null>
     */
    private function extractPaymentDetails(?object $intent): array
    {
        if (! $intent) {
            return [];
        }

        $details = [];

        if (isset($intent->payment_method_types[0])) {
            $details['payment_method'] = $intent->payment_method_types[0];
        }

        $charge = $intent->latest_charge ?? null;

        if (is_object($charge)) {
            $charge = $charge->id ?? null;
        }

        if (is_string($charge) && $charge !== '') {
            $charge = $this->retrieveCharge($charge);
        }

        if (is_object($charge)) {
            $details['stripe_charge_id'] = $charge->id ?? null;
            $details['receipt_url'] = $charge->receipt_url ?? null;
            $details['amount_received'] = isset($charge->amount_received)
                ? round(((int) $charge->amount_received) / 100, 2)
                : (isset($charge->amount) ? round(((int) $charge->amount) / 100, 2) : null);

            if (isset($charge->amount_refunded)) {
                $details['refunded_amount'] = round(((int) $charge->amount_refunded) / 100, 2);
            }

            $balanceTransaction = $charge->balance_transaction ?? null;

            if (is_object($balanceTransaction)) {
                $details['stripe_fee'] = round(((int) ($balanceTransaction->fee ?? 0)) / 100, 2);
                $details['net_amount'] = round(((int) ($balanceTransaction->net ?? 0)) / 100, 2);
            }

            $card = $charge->payment_method_details->card ?? null;

            if ($card) {
                $details['card_brand'] = $card->brand ?? null;
                $details['card_last4'] = $card->last4 ?? null;
            }
        }

        return array_filter($details, fn ($value) => $value !== null && $value !== '');
    }

    private function retrieveCharge(string $chargeId): ?object
    {
        if (! $this->hasRealStripeKey(config('services.stripe.secret'))) {
            return null;
        }

        try {
            return $this->client()->charges->retrieve($chargeId, [
                'expand' => ['balance_transaction'],
            ]);
        } catch (\Exception $e) {
            Log::warning('Stripe charge retrieve failed', [
                'charge' => $chargeId,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    private function client(): StripeClient
    {
        if ($this->stripe === null) {
            $this->stripe = new StripeClient((string) config('services.stripe.secret'));
        }

        return $this->stripe;
    }

    private function intents(): object
    {
        return $this->intents ?? $this->client()->paymentIntents;
    }
}
