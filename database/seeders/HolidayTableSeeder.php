<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class HolidayTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('holidays')->insert([
            'holiday_name' => 'Independence Day',
            'holiday_date' => '2022-08-15',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('holidays')->insert([
            'holiday_name' => 'republic Day',
            'holiday_date' => '2022-01-26',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
