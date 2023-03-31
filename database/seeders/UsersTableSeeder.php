<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'zubair ali',
            'email' => 'raeenzubair1@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin1234'),
            'mobile' => '1234567890',
            'user_occ' => '2',
            'user_r' => '1',
            'user_image' => '',
        ]);
        DB::table('users')->insert([
            'name' => 'Anish Qureshi',
            'email' => 'noshiabsit@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin1234'),
            'mobile' => '1234567890',
            'user_occ' => '1',
            'user_r' => '1',
            'user_image' => '',
        ]);

        DB::table('users')->insert([
            'name' => 'Manager',
            'email' => 'admin@abssoftech.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin1234'),
            'mobile' => '1234567890',
            'user_occ' => '1',
            'user_r' => '1',
            'user_image' => '',
        ]);
    }
}
