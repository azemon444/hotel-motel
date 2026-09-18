<?php

namespace App\Models;

use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use HasFactory;

    /** Nightly rates in EUR, keyed by room type. */
    public const ROOM_PRICES = [
        'studio' => 89,
        'onebed' => 119,
        'twobed' => 159,
    ];

    /** Promo code => discount rate. */
    public const PROMO_CODES = [
        'ADVANCE20' => 0.20,
        'STAY7' => 0.15,
        'WELCOME10' => 0.10,
        'SAVE15' => 0.15,
    ];

    public const CITY_TAX_RATE = 0.07;

    protected $fillable = [
        'booking_id', 'name', 'email', 'phone', 'room_type', 'room_name',
        'checkin', 'checkout', 'nights', 'guests', 'requests', 'amount',
        'subtotal', 'tax', 'currency', 'status', 'payment_intent',
        'stripe_status', 'stripe_charge_id', 'payment_method', 'card_brand',
        'card_last4', 'receipt_url', 'failure_message', 'failure_code',
        'failure_decline_code', 'amount_received', 'stripe_fee', 'net_amount',
        'refunded_amount', 'refund_status', 'refunds', 'payment_history',
    ];

    protected $casts = [
        'payment_history' => 'array',
        'refunds' => 'array',
        'checkin' => 'date',
        'checkout' => 'date',
    ];

    /**
     * Calculate the authoritative price for a booking.
     *
     * @return array{subtotal: float, tax: float, total: float, discount: float}
     */
    public static function quote(string $roomType, int $nights, ?string $promo = null, float $customAmount = 0.0): array
    {
        $discountRate = self::PROMO_CODES[strtoupper((string) $promo)] ?? 0.0;

        $base = $roomType === 'custom'
            ? max(0.0, $customAmount)
            : (self::ROOM_PRICES[$roomType] ?? 0.0) * max(1, $nights);

        $discount = round($base * $discountRate, 2);
        $subtotal = round($base - $discount, 2);
        $tax = round($subtotal * self::CITY_TAX_RATE, 2);

        return [
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => round($subtotal + $tax, 2),
            'discount' => $discount,
        ];
    }
}
