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
            $table->foreignId('room_type_id')->unique()->constrained('room_types')->cascadeOnDelete();
            $table->unsignedTinyInteger('total_adults')->default(0);
            $table->unsignedTinyInteger('total_children')->default(0);
            $table->unsignedTinyInteger('capacity')->default(0);
            $table->string('image')->nullable();
            $table->decimal('price_per_night', 8, 2);
            $table->string('size', 50)->nullable();
            $table->enum('view', ['see', 'hill']);
            $table->enum('bed_style', ['queen', 'twin', 'king']);
            $table->unsignedTinyInteger('discount')->default(0);
            $table->text('short_desc')->nullable();
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
