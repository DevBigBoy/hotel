<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('rooms_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();


            $table->date('check_in_date')->nullable();
            $table->date('check_out_date')->nullable();
            $table->integer('number_of_persons')->default(0);
            $table->unsignedInteger('number_of_rooms')->default(0);
            $table->unsignedInteger('total_night')->default(0);

            $table->decimal('actual_price', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2)->default(0);

            $table->string('payment_type')->nullable();
            $table->string('transaction_id')->nullable();
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->nullable()->default('pending');

            $table->enum('status', ['confirmed', 'cancelled', 'pending'])->default('pending');
            $table->timestamps();

            $table->index('rooms_id');
            $table->index('user_id');
            $table->index('check_in_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
