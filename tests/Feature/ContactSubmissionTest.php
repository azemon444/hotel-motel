<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ContactSubmissionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_requires_a_name_email_and_message(): void
    {
        $this->postJson(route('api.contact'), [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['firstName', 'email', 'message']);
    }

    #[Test]
    public function it_stores_a_valid_contact_message(): void
    {
        $this->postJson(route('api.contact'), [
            'firstName' => 'Ada',
            'lastName' => 'Lovelace',
            'email' => 'ada@example.com',
            'message' => 'Do you have availability in July?',
            'source' => 'contact',
        ])->assertStatus(201)->assertJson(['ok' => true]);

        $this->assertDatabaseHas('contact_messages', [
            'first_name' => 'Ada',
            'email' => 'ada@example.com',
        ]);
    }

    #[Test]
    public function it_silently_drops_honeypot_submissions(): void
    {
        $this->postJson(route('api.contact'), [
            'firstName' => 'Bot',
            'email' => 'bot@example.com',
            'message' => 'Buy cheap links',
            'website' => 'http://spam.example',
        ])->assertStatus(201)->assertJson(['ok' => true]);

        $this->assertDatabaseCount('contact_messages', 0);
    }
}
