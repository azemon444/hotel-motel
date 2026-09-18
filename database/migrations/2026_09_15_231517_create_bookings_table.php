<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('room_type');
            $table->string('room_name')->nullable();
            $table->date('checkin')->nullable();
            $table->date('checkout')->nullable();
            $table->integer('nights')->default(1);
            $table->integer('guests')->default(1);
            $table->text('requests')->nullable();
            $table->decimal('amount', 8, 2);
            $table->decimal('subtotal', 8, 2)->nullable();
            $table->decimal('tax', 8, 2)->nullable();
            $table->string('currency', 10)->default('EUR');
            $table->string('status')->default('pending');
            $table->string('payment_intent')->nullable();
            $table->string('stripe_status')->nullable();
            $table->json('payment_history')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
