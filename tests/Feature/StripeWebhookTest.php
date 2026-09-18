<?php

namespace Tests\Feature;

use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class StripeWebhookTest extends TestCase
{
    use RefreshDatabase;

    private const SECRET = 'whsec_test_secret';

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.stripe.webhook_secret' => self::SECRET]);
    }

    private function signedPost(string $payload): TestResponse
    {
        $timestamp = time();
        $signature = hash_hmac('sha256', $timestamp.'.'.$payload, self::SECRET);

        return $this->call(
            'POST',
            route('api.stripe.webhook'),
            [],
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_STRIPE_SIGNATURE' => "t={$timestamp},v1={$signature}",
            ],
            $payload,
        );
    }

    #[Test]
    public function it_rejects_a_webhook_without_a_valid_signature(): void
    {
        $this->postJson(route('api.stripe.webhook'), ['type' => 'payment_intent.succeeded'])
            ->assertStatus(400)
            ->assertJson(['error' => 'Invalid signature']);
    }

    #[Test]
    public function it_records_the_failure_reason_when_a_payment_fails(): void
    {
        $booking = Booking::factory()->create([
            'payment_intent' => 'pi_failed',
            'status' => 'pending',
        ]);

        $payload = json_encode([
            'id' => 'evt_failed',
            'type' => 'payment_intent.payment_failed',
            'data' => [
                'object' => [
                    'id' => 'pi_failed',
                    'object' => 'payment_intent',
                    'status' => 'requires_payment_method',
                    'last_payment_error' => [
                        'message' => 'Your card was declined.',
                        'code' => 'card_declined',
                        'decline_code' => 'generic_decline',
                        'payment_method' => [
                            'type' => 'card',
                            'card' => ['brand' => 'visa', 'last4' => '0002'],
                        ],
                    ],
                ],
            ],
        ]);

        $this->signedPost($payload)->assertOk()->assertJson(['received' => true]);

        $booking->refresh();
        $this->assertSame('failed', $booking->status);
        $this->assertSame('Your card was declined.', $booking->failure_message);
        $this->assertSame('card_declined', $booking->failure_code);
        $this->assertSame('generic_decline', $booking->failure_decline_code);
        $this->assertSame('visa', $booking->card_brand);
        $this->assertSame('0002', $booking->card_last4);
        $this->assertSame('failed', $booking->payment_history[array_key_last($booking->payment_history)]['status']);
    }

    #[Test]
    public function it_marks_a_booking_paid_on_a_successful_event(): void
    {
        $booking = Booking::factory()->create([
            'payment_intent' => 'pi_success',
            'status' => 'pending',
        ]);

        $payload = json_encode([
            'id' => 'evt_success',
            'type' => 'payment_intent.succeeded',
            'data' => [
                'object' => [
                    'id' => 'pi_success',
                    'object' => 'payment_intent',
                    'status' => 'succeeded',
                ],
            ],
        ]);

        $this->signedPost($payload)->assertOk();

        $this->assertSame('paid', $booking->refresh()->status);
    }

    #[Test]
    public function it_records_a_full_refund(): void
    {
        $booking = Booking::factory()->paid()->create([
            'amount' => 267.00,
            'stripe_charge_id' => 'ch_refund_me',
            'payment_intent' => 'pi_refund_me',
            'refunded_amount' => 0,
            'refund_status' => null,
            'refunds' => null,
        ]);

        $payload = json_encode([
            'id' => 'evt_refund',
            'type' => 'charge.refunded',
            'data' => [
                'object' => [
                    'id' => 'ch_refund_me',
                    'object' => 'charge',
                    'payment_intent' => 'pi_refund_me',
                    'amount' => 26700,
                    'amount_refunded' => 26700,
                    'currency' => 'eur',
                    'refunds' => [
                        'data' => [[
                            'id' => 're_test_1',
                            'amount' => 26700,
                            'currency' => 'eur',
                            'status' => 'succeeded',
                            'reason' => 'requested_by_customer',
                            'created' => time(),
                        ]],
                    ],
                ],
            ],
        ]);

        $this->signedPost($payload)->assertOk();

        $booking->refresh();
        $this->assertSame('refunded', $booking->status);
        $this->assertSame('full', $booking->refund_status);
        $this->assertSame(267.0, (float) $booking->refunded_amount);
        $this->assertCount(1, $booking->refunds);
        $this->assertSame('re_test_1', $booking->refunds[0]['id']);
        $this->assertSame('refunded', $booking->payment_history[array_key_last($booking->payment_history)]['status']);
    }

    #[Test]
    public function it_records_a_partial_refund(): void
    {
        $booking = Booking::factory()->paid()->create([
            'amount' => 267.00,
            'stripe_charge_id' => 'ch_partial_refund',
            'payment_intent' => 'pi_partial_refund',
            'refunded_amount' => 0,
            'refund_status' => null,
            'refunds' => null,
        ]);

        $payload = json_encode([
            'id' => 'evt_partial_refund',
            'type' => 'charge.refunded',
            'data' => [
                'object' => [
                    'id' => 'ch_partial_refund',
                    'object' => 'charge',
                    'payment_intent' => 'pi_partial_refund',
                    'amount' => 26700,
                    'amount_refunded' => 8900,
                    'currency' => 'eur',
                    'refunds' => ['data' => []],
                ],
            ],
        ]);

        $this->signedPost($payload)->assertOk();

        $booking->refresh();
        $this->assertSame('paid', $booking->status);
        $this->assertSame('partial', $booking->refund_status);
        $this->assertSame(89.0, (float) $booking->refunded_amount);
    }
}
