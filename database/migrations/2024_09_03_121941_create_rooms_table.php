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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_type_id')->constrained('room_types');

            $table->unsignedTinyInteger('total_adults')->default(0);
            $table->unsignedTinyInteger('total_children')->default(0);
            $table->unsignedTinyInteger('capacity')->default(0);

            $table->string('image')->nullable();

            $table->decimal('price_per_night', 8, 2);
            $table->decimal('discount', 8, 2)->nullable();

            $table->string('bed_type');              // 'Single', 'Double', 'Queen', 'King'
            $table->string('view_type')->nullable(); // 'Ocean view', 'City view'
            $table->integer('room_size')->nullable(); // Room size in square feet/meters

            $table->string('short_desc')->nullable();
            $table->text('description')->nullable();

            $table->enum('status', ['available', 'archived'])->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
