<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DesignationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('designations')->insert([
            'name' => 'Frontend Developer',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('designations')->insert([
            'name' => 'Backend Developer',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('designations')->insert([
            'name' => 'Fullstack Developer',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
