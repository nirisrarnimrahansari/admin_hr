<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'department_name' => 'IT Department',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('departments')->insert([
            'department_name' => 'Sells',
            'created_at' => now(),
            'updated_at' => now()
        ]);
          DB::table('departments')->insert([
            'department_name' => 'Marketing Department',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
