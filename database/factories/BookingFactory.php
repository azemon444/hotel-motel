<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkin = fake()->dateTimeBetween('+1 day', '+30 days');
        $nights = fake()->numberBetween(1, 10);
        $checkout = (clone $checkin)->modify("+{$nights} days");
        $roomType = fake()->randomElement(array_keys(Booking::ROOM_PRICES));
        $quote = Booking::quote($roomType, $nights);

        return [
            'booking_id' => 'booking_'.Str::random(32),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'room_type' => $roomType,
            'room_name' => ucfirst($roomType).' Suite',
            'checkin' => $checkin->format('Y-m-d'),
            'checkout' => $checkout->format('Y-m-d'),
            'nights' => $nights,
            'guests' => fake()->numberBetween(1, 4),
            'requests' => null,
            'amount' => $quote['total'],
            'subtotal' => $quote['subtotal'],
            'tax' => $quote['tax'],
            'currency' => 'EUR',
            'status' => 'pending',
            'payment_intent' => 'pi_'.Str::random(24),
            'stripe_status' => 'requires_payment_method',
            'payment_history' => [],
        ];
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
            'stripe_status' => 'succeeded',
            'stripe_charge_id' => 'ch_'.Str::random(24),
            'payment_method' => 'card',
            'card_brand' => 'visa',
            'card_last4' => '4242',
            'receipt_url' => 'https://pay.stripe.com/receipts/'.Str::random(12),
            'amount_received' => $attributes['amount'] ?? 267.0,
            'stripe_fee' => 8.01,
            'net_amount' => 258.99,
        ]);
    }

    public function refunded(): static
    {
        return $this->paid()->state(fn (array $attributes) => [
            'status' => 'refunded',
            'refunded_amount' => $attributes['amount'] ?? 267.0,
            'refund_status' => 'full',
            'refunds' => [[
                'id' => 're_'.Str::random(24),
                'amount' => $attributes['amount'] ?? 267.0,
                'currency' => 'eur',
                'status' => 'succeeded',
                'reason' => 'requested_by_customer',
                'created' => now()->toDateTimeString(),
            ]],
        ]);
    }

    public function failed(): static
    {
        return $this->state(fn () => [
            'status' => 'failed',
            'stripe_status' => 'requires_payment_method',
            'payment_method' => 'card',
            'failure_message' => 'Your card was declined.',
            'failure_code' => 'card_declined',
            'failure_decline_code' => 'generic_decline',
        ]);
    }
}
