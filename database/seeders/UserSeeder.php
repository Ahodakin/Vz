<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'email' => '',
                'password' => Hash::make(''),
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
