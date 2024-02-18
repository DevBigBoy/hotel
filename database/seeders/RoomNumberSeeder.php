<?php

namespace Database\Seeders;

use App\Models\RoomNumber;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoomNumber::create([
            'room_id' => 1,  // Assume you have a room with ID 1
            'room_number' => '101',
            'status' => 'available',
        ]);

        RoomNumber::create([
            'room_id' => 1,
            'room_number' => '102',
            'status' => 'occupied',
        ]);
    }
}