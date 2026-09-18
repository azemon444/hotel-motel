<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Services\PaymentSync;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PaymentStatusSyncTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['admin.password' => 'correct-horse']);
        config(['services.stripe.secret' => 'sk_live_test']);
    }

    private function bindIntents(object $intents): void
    {
        $this->app->instance(PaymentSync::class, new PaymentSync(intents: $intents));
    }

    private function adminList()
    {
        $this->postJson(route('admin.bookings'), ['password' => 'correct-horse'])->assertOk();

        return $this->getJson(route('admin.bookings'))->assertOk();
    }

    #[Test]
    public function a_declined_intent_is_synced_to_failed_with_failure_details(): void
    {
        $booking = Booking::factory()->create([
            'payment_intent' => 'pi_declined_sync',
            'status' => 'pending',
            'stripe_status' => 'requires_payment_method',
        ]);

        $intents = new class
        {
            public function retrieve(string $id, array $opts = []): object
            {
                return (object) [
                    'id' => $id,
                    'status' => 'requires_payment_method',
                    'last_payment_error' => (object) [
                        'message' => 'Your card was declined.',
                        'code' => 'card_declined',
                        'decline_code' => 'generic_decline',
                        'payment_method' => (object) [
                            'type' => 'card',
                            'card' => (object) ['brand' => 'visa', 'last4' => '0002'],
                        ],
                    ],
                ];
            }
        };

        $this->bindIntents($intents);

        $response = $this->adminList();

        $this->assertSame('failed', $booking->refresh()->status);
        $this->assertSame('card_declined', $booking->failure_code);
        $this->assertSame('generic_decline', $booking->failure_decline_code);
        $this->assertSame('0002', $booking->card_last4);

        $row = collect($response->json())->firstWhere('payment.payment_intent', 'pi_declined_sync');
        $this->assertSame('failed', $row['payment']['status']);
        $this->assertSame('Your card was declined.', $row['payment']['failure_message']);
    }

    #[Test]
    public function a_canceled_intent_is_synced_to_cancelled(): void
    {
        $booking = Booking::factory()->create([
            'payment_intent' => 'pi_canceled_sync',
            'status' => 'pending',
            'stripe_status' => 'requires_payment_method',
        ]);

        $intents = new class
        {
            public function retrieve(string $id, array $opts = []): object
            {
                return (object) [
                    'id' => $id,
                    'status' => 'canceled',
                    'last_payment_error' => null,
                ];
            }
        };

        $this->bindIntents($intents);

        $response = $this->adminList();

        $this->assertSame('cancelled', $booking->refresh()->status);
        $this->assertSame('canceled', $booking->stripe_status);

        $row = collect($response->json())->firstWhere('payment.payment_intent', 'pi_canceled_sync');
        $this->assertSame('cancelled', $row['payment']['status']);
    }

    #[Test]
    public function a_succeeded_intent_is_synced_to_paid(): void
    {
        $booking = Booking::factory()->create([
            'payment_intent' => 'pi_succeeded_sync',
            'status' => 'pending',
            'stripe_status' => 'requires_payment_method',
        ]);

        $intents = new class
        {
            public function retrieve(string $id, array $opts = []): object
            {
                return (object) [
                    'id' => $id,
                    'status' => 'succeeded',
                    'last_payment_error' => null,
                    'payment_method_types' => ['card'],
                    'latest_charge' => null,
                ];
            }
        };

        $this->bindIntents($intents);

        $response = $this->adminList();

        $this->assertSame('paid', $booking->refresh()->status);
        $this->assertSame('succeeded', $booking->stripe_status);
        $this->assertSame('card', $booking->payment_method);

        $row = collect($response->json())->firstWhere('payment.payment_intent', 'pi_succeeded_sync');
        $this->assertSame('paid', $row['payment']['status']);
    }

    #[Test]
    public function a_pending_intent_without_an_outcome_stays_pending(): void
    {
        $booking = Booking::factory()->create([
            'payment_intent' => 'pi_open_sync',
            'status' => 'pending',
            'stripe_status' => 'requires_payment_method',
        ]);

        $intents = new class
        {
            public function retrieve(string $id, array $opts = []): object
            {
                return (object) [
                    'id' => $id,
                    'status' => 'requires_payment_method',
                    'last_payment_error' => null,
                ];
            }
        };

        $this->bindIntents($intents);

        $this->adminList();

        $this->assertSame('pending', $booking->refresh()->status);
    }

    #[Test]
    public function sync_never_runs_without_a_real_stripe_key(): void
    {
        config(['services.stripe.secret' => 'sk_test_replace_me']);

        $booking = Booking::factory()->create([
            'payment_intent' => 'pi_never_looked_up',
            'status' => 'pending',
        ]);

        $sync = new PaymentSync;
        $this->assertFalse($sync->sync($booking));
        $this->assertSame('pending', $booking->refresh()->status);
    }
}
