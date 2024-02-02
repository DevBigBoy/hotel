<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            [

                // admin
                [
                    'name' => 'almasa admin',
                    'email' => 'admin@gmail.com',
                    'password' => Hash::make('shezo123'),
                    'role' => 'admin',
                    'status' => 'active',
                ],
                // user
                [
                    'name' => 'almasa user',
                    'email' => 'user@gmail.com',
                    'password' => Hash::make('shezo123'),
                    'role' => 'user',
                    'status' => 'active',
                ],
            ]
        );
    }
}
