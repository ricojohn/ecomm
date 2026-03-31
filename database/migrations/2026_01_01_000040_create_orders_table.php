<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_number')->unique();
            $table->string('status')->default('pending');
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->string('checkout_token')->unique();

            // Traveler information
            $table->string('traveler_full_name');
            $table->string('passport_number');
            $table->string('nationality');
            $table->string('flight_number');
            $table->date('departure_date');
            $table->string('destination');

            // Eligibility result
            $table->string('eligibility_status')->default('pending');
            $table->text('eligibility_message')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
