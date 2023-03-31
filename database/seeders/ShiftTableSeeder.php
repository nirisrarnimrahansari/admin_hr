<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class ShiftTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shifts')->insert([
            'name' => 'Morninig Shift',
            'login_time' => '09:00:00',
            'logout_time' => '05:00:00',
            'buffer_time' => '10',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('shifts')->insert([
            'name' => 'Noon Shift',
            'login_time' => '12:00:00',
            'logout_time' => '07:00:00',
            'buffer_time' => '10',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('shifts')->insert([
            'name' => 'Night Shift',
            'login_time' => '07:00:00',
            'logout_time' => '12:00:00',
            'buffer_time' => '10',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
