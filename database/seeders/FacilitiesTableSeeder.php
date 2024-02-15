<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FacilitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            ['name' => 'Free WiFi'],
            ['name' => 'Swimming Pool'],
            ['name' => 'Parking'],
            ['name' => 'Gym'],
            ['name' => 'Spa'],
            ['name' => 'Restaurant'],
            ['name' => 'Air Conditioning'],
            ['name' => 'Laundry Service']
        ];

        foreach ($facilities as $facility) {
            DB::table('facilities')->insert([
                'name' => $facility['name'],
                'slug' => Str::slug($facility['name']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // DB::table('facilities')->insert([
        //     ['name' => 'WiFi', 'description' => 'High-speed wireless internet access'],
        //     ['name' => 'Air Conditioning', 'description' => 'Air conditioning system'],
        //     ['name' => 'TV', 'description' => 'Flat-screen TV with cable channels'],
        //     ['name' => 'Mini Bar', 'description' => 'Mini bar with refreshments'],
        //     ['name' => 'Safe', 'description' => 'In-room safe for valuables'],
        //     ['name' => 'Lunch Facility', 'description' => 'Provides lunch options for guests.'],
        //     ['name' => 'Breakfast Facility', 'description' => 'Provides breakfast options for guests.'],
        //     ['name' => 'Dinner Facility', 'description' => 'Provides dinner options for guests.'],
        //     ['name' => 'Outdoor Kitchen', 'description' => 'Includes access to an outdoor kitchen area.'],
        //     ['name' => 'Shampoo and Soap', 'description' => 'Complimentary shampoo and soap provided.'],
        //     ['name' => 'Double Bed', 'description' => 'Includes a double bed for comfortable sleep.'],
        //     ['name' => '5 Star Food Favor', 'description' => 'Access to 5-star food services and specialties.'],
        // ]);
    }
}

/**
 *
 *
 */