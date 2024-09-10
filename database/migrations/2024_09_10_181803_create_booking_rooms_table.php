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
        Schema::create('booking_rooms', function (Blueprint $table) {
            $table->id();

            // Foreign key to bookings table
            $table->foreignId('booking_id')->constrained('bookings')->cascadeOnDelete();

            // Foreign key to rooms table
            $table->foreignId('room_number_id')->constrained('room_numbers')->onDelete('cascade');

            // Dates for the room booking
            $table->date('check_in_date')->nullable();
            $table->date('check_out_date')->nullable();

            $table->timestamps();

            // Indexes for performance
            $table->index('booking_id');
            $table->index('room_number_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_rooms');
    }
};
