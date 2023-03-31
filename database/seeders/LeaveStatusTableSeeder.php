<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class LeaveStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('leave_statuses')->insert([
            'name' => 'leave',
            'value' => '-1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('leave_statuses')->insert([
            'name' => 'Half Day',
            'value' => '-0.5',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('leave_statuses')->insert([
            'name' => 'Un Approved Leave',
            'value' => '-2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('leave_statuses')->insert([
            'name' => 'Un Approved Half Day',
            'value' => '-1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('leave_statuses')->insert([
            'name' => 'Overtime',
            'value' => '+0.5',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
