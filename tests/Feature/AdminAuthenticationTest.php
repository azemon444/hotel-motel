<?php

namespace Tests\Feature;

use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['admin.password' => 'correct-horse']);
    }

    #[Test]
    public function it_hides_bookings_from_unauthenticated_visitors(): void
    {
        $this->getJson(route('admin.bookings'))
            ->assertStatus(401)
            ->assertJson(['error' => 'Unauthenticated']);
    }

    #[Test]
    public function it_rejects_a_wrong_password(): void
    {
        $this->postJson(route('admin.bookings'), ['password' => 'wrong'])
            ->assertStatus(401)
            ->assertJson(['error' => 'Invalid password']);

        $this->getJson(route('admin.bookings'))->assertStatus(401);
    }

    #[Test]
    public function it_lists_bookings_after_a_successful_login(): void
    {
        Booking::factory()->create(['name' => 'Ada Lovelace']);

        $this->postJson(route('admin.bookings'), ['password' => 'correct-horse'])
            ->assertOk()
            ->assertJson(['ok' => true]);

        $this->getJson(route('admin.bookings'))
            ->assertOk()
            ->assertJsonPath('0.customer.name', 'Ada Lovelace');
    }

    #[Test]
    public function it_logs_the_admin_out(): void
    {
        $this->postJson(route('admin.bookings'), ['password' => 'correct-horse'])->assertOk();
        $this->postJson(route('admin.bookings'), ['logout' => true])->assertOk();

        $this->getJson(route('admin.bookings'))->assertStatus(401);
    }

    #[Test]
    public function it_exposes_card_and_failure_metadata_to_the_admin(): void
    {
        Booking::factory()->paid()->create([
            'payment_intent' => 'pi_paid_meta',
            'amount' => 267.00,
            'amount_received' => 267.00,
        ]);
        Booking::factory()->failed()->create(['payment_intent' => 'pi_failed_meta']);
        Booking::factory()->refunded()->create([
            'payment_intent' => 'pi_refunded_meta',
            'amount' => 267.00,
            'refunded_amount' => 267.00,
        ]);

        $this->postJson(route('admin.bookings'), ['password' => 'correct-horse'])->assertOk();

        $response = $this->getJson(route('admin.bookings'))->assertOk();

        $paid = collect($response->json())->firstWhere('payment.payment_intent', 'pi_paid_meta');
        $this->assertSame('visa', $paid['payment']['card_brand']);
        $this->assertSame('4242', $paid['payment']['card_last4']);
        $this->assertNotNull($paid['payment']['receipt_url']);
        $this->assertEquals(267.0, $paid['payment']['amount_received']);
        $this->assertSame(8.01, $paid['payment']['stripe_fee']);
        $this->assertSame(258.99, $paid['payment']['net_amount']);

        $failed = collect($response->json())->firstWhere('payment.payment_intent', 'pi_failed_meta');
        $this->assertSame('Your card was declined.', $failed['payment']['failure_message']);
        $this->assertSame('card_declined', $failed['payment']['failure_code']);
        $this->assertSame('generic_decline', $failed['payment']['failure_decline_code']);

        $refunded = collect($response->json())->firstWhere('payment.payment_intent', 'pi_refunded_meta');
        $this->assertSame('full', $refunded['payment']['refund_status']);
        $this->assertEquals(267.0, $refunded['payment']['refunded_amount']);
        $this->assertCount(1, $refunded['payment']['refunds']);
    }
}
