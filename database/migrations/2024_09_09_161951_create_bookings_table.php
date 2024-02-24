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

            $table->foreignId('room_type_id')->nullable()->constrained('room_types')->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();


            $table->date('check_in_date')->nullable();
            $table->date('check_out_date')->nullable();
            $table->integer('number_of_persons')->default(1);
            $table->unsignedInteger('number_of_rooms')->default(1);
            $table->unsignedInteger('total_night')->default(1);

            $table->decimal('actual_price', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2)->default(0);

            $table->string('payment_type')->nullable();
            $table->string('transaction_id')->nullable();
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->nullable()->default('pending');

            $table->enum('status', ['confirmed', 'cancelled', 'pending'])->default('pending');
            $table->timestamps();

            $table->index('user_id');
            $table->index('room_type_id');
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
