<?php

namespace Tests\Unit;

use App\Models\Booking;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BookingQuoteTest extends TestCase
{
    #[Test]
    public function it_prices_a_room_by_nightly_rate_and_nights(): void
    {
        $quote = Booking::quote('studio', 3);

        $this->assertSame(267.0, $quote['subtotal']);
        $this->assertSame(18.69, $quote['tax']);
        $this->assertSame(285.69, $quote['total']);
        $this->assertSame(0.0, $quote['discount']);
    }

    #[Test]
    public function it_applies_a_promo_code_before_tax(): void
    {
        $quote = Booking::quote('onebed', 2, 'advance20');

        $this->assertSame(47.6, $quote['discount']);
        $this->assertSame(190.4, $quote['subtotal']);
        $this->assertSame(13.33, $quote['tax']);
        $this->assertSame(203.73, $quote['total']);
    }

    #[Test]
    public function it_ignores_unknown_promo_codes(): void
    {
        $quote = Booking::quote('twobed', 1, 'NOTREAL');

        $this->assertSame(0.0, $quote['discount']);
        $this->assertSame(159.0, $quote['subtotal']);
    }

    #[Test]
    public function it_uses_the_custom_amount_for_custom_rooms(): void
    {
        $quote = Booking::quote('custom', 5, 'STAY7', 1000.0);

        $this->assertSame(150.0, $quote['discount']);
        $this->assertSame(850.0, $quote['subtotal']);
        $this->assertSame(59.5, $quote['tax']);
        $this->assertSame(909.5, $quote['total']);
    }

    #[Test]
    public function it_treats_each_room_as_at_least_one_night(): void
    {
        $quote = Booking::quote('studio', 0);

        $this->assertSame(89.0, $quote['subtotal']);
    }
}
