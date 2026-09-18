<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('amount_received', 10, 2)->nullable();
            $table->decimal('stripe_fee', 10, 2)->nullable();
            $table->decimal('net_amount', 10, 2)->nullable();
            $table->decimal('refunded_amount', 10, 2)->default(0);
            $table->string('refund_status')->nullable();
            $table->json('refunds')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'amount_received',
                'stripe_fee',
                'net_amount',
                'refunded_amount',
                'refund_status',
                'refunds',
            ]);
        });
    }
};
