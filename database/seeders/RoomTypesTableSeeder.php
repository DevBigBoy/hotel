<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoomTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('room_types')->insert([
            ['name' => 'Single', 'description' => 'A single room for one person.', 'status' => 'active'],
            ['name' => 'Double', 'description' => 'A double room for two people.', 'status' => 'active'],
            ['name' => 'Suite', 'description' => 'A luxury suite with a separate living area.', 'status' => 'active'],
            ['name' => 'Family', 'description' => 'A larger room suitable for families.', 'status' => 'active'], // Example inactive room type
            ['name' => 'Deluxe', 'description' => 'A deluxe room with additional amenities.', 'status' => 'active']
        ]);
    }
}