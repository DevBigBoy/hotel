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
        Schema::create('room_booked_dates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('booking_id')->nullable()->constrained('bookings')->nullOnDelete();

            $table->foreignId('room_number_id')->nullable()->constrained('room_numbers')->nullOnDelete();

            $table->date('book_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_booked_dates');
    }
};
