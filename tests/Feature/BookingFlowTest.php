<?php

namespace Tests\Feature;

use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BookingFlowTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'roomType' => 'studio',
            'roomName' => 'Studio Suite',
            'checkin' => now()->addDays(5)->toDateString(),
            'checkout' => now()->addDays(8)->toDateString(),
            'guests' => 2,
            'firstName' => 'Ada',
            'lastName' => 'Lovelace',
            'email' => 'ada@example.com',
            'phone' => '+31612345678',
        ], $overrides);
    }

    #[Test]
    public function it_requires_the_customer_details(): void
    {
        $this->postJson(route('api.createIntent'), [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['roomType', 'firstName', 'lastName', 'email']);
    }

    #[Test]
    public function it_rejects_an_unknown_room_type(): void
    {
        $this->postJson(route('api.createIntent'), $this->validPayload(['roomType' => 'penthouse']))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['roomType']);
    }

    #[Test]
    public function it_requires_checkout_after_checkin(): void
    {
        $this->postJson(route('api.createIntent'), $this->validPayload([
            'checkin' => now()->addDays(10)->toDateString(),
            'checkout' => now()->addDays(8)->toDateString(),
        ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['checkout']);
    }

    #[Test]
    public function it_does_not_require_dates_for_a_custom_rate(): void
    {
        config(['services.stripe.secret' => 'sk_test_replace_me']);

        $this->postJson(route('api.createIntent'), [
            'roomType' => 'custom',
            'firstName' => 'Ada',
            'lastName' => 'Lovelace',
            'email' => 'ada@example.com',
            'amount' => 500,
        ])->assertStatus(503);
    }

    #[Test]
    public function it_refuses_to_start_payment_without_a_real_stripe_key(): void
    {
        config(['services.stripe.secret' => 'sk_test_replace_me']);

        $this->postJson(route('api.createIntent'), $this->validPayload())
            ->assertStatus(503)
            ->assertJson(['error' => 'Payment is not available at the moment.']);
    }

    #[Test]
    public function it_requires_a_payment_intent_to_confirm(): void
    {
        $this->getJson(route('api.confirmBooking'))
            ->assertStatus(422)
            ->assertJson(['error' => 'payment_intent required']);
    }

    #[Test]
    public function it_returns_not_found_for_an_unknown_payment_intent(): void
    {
        $this->getJson(route('api.confirmBooking', ['payment_intent' => 'pi_missing']))
            ->assertStatus(404);
    }

    #[Test]
    public function it_confirms_a_booking_after_payment(): void
    {
        config(['services.stripe.secret' => 'sk_test_replace_me']);

        $booking = Booking::factory()->create([
            'payment_intent' => 'pi_test_success',
            'status' => 'pending',
        ]);

        $this->getJson(route('api.confirmBooking', ['payment_intent' => 'pi_test_success']))
            ->assertOk()
            ->assertJson(['ok' => true]);

        $booking->refresh();
        $this->assertSame('paid', $booking->status);
        $this->assertSame('succeeded', $booking->stripe_status);
        $this->assertNotEmpty($booking->payment_history);
    }

    #[Test]
    public function confirming_an_already_paid_booking_is_idempotent(): void
    {
        config(['services.stripe.secret' => 'sk_test_replace_me']);

        Booking::factory()->paid()->create(['payment_intent' => 'pi_test_paid']);

        $this->getJson(route('api.confirmBooking', ['payment_intent' => 'pi_test_paid']))
            ->assertOk()
            ->assertJson(['ok' => true, 'already_confirmed' => true]);
    }
}
