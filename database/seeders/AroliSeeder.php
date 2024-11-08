<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AroliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'firstname' => 'TechAroli',
                'lastname' => 'TechAroli',
                'gender' => 'M',
                'dob' => '2024-05-27',
                'contact' => '0700000000',
                'job_id' => 14, 
                'date_pc' => '2024-09-27',
                'email' => 'arolisuperadmin@gmail.com',
                'password' => Hash::make('123456789'),
                'avatar' => 'default.png',
                'status' => 1,
                'usertype' => 99,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
