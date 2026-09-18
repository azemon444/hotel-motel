<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('stripe_charge_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last4', 4)->nullable();
            $table->string('receipt_url')->nullable();
            $table->text('failure_message')->nullable();
            $table->string('failure_code')->nullable();
            $table->string('failure_decline_code')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_charge_id',
                'payment_method',
                'card_brand',
                'card_last4',
                'receipt_url',
                'failure_message',
                'failure_code',
                'failure_decline_code',
            ]);
        });
    }
};
