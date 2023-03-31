<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            'name'          => 'neha',
            'father_name'   => 'ranglal meena',
            'select_id'     => 'passport',
            'id_proof'      => '',
            'upload_pan_card' => '',
            'pan_number'      => '222222',
            'designation_id'  => '2',
            'email_id'        => 'neha@gmail.com',
            'whatsapp_no'     => '7654321765',
            'dob'             => '2022-08-24',
            'joining_date'    => '2022-08-14 ',
            'basic_salary'    => '56565',
            'basic_salary_ed' => '2022-08-02',
            'shift_id'        => '3',
            'shift_ed'        => '2022-12-24',
            'type'            => 'Permanent',
            'permanent_date'  => '2022-12-21',
            'casual_leave'    => '12',
            'earn_leave'      => '65',
            'department_id'   => '3',
            'biometric_id'    => '12',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('employees')->insert([
            'name'          => 'neyan',
            'father_name'   => 'om puri goswami',
            'select_id'     => 'passport',
            'id_proof'      => '',
            'upload_pan_card' => '',
            'pan_number'      => '334343',
            'designation_id'  => '3',
            'email_id'        => 'nayan@gmail.com',
            'whatsapp_no'     => '7654121765',
            'dob'             => '2022-08-21',
            'joining_date'    => '2022-08-24 ',
            'basic_salary'    => '56235',
            'basic_salary_ed' => '2022-09-02',
            'shift_id'        => '1',
            'shift_ed'        => '2022-11-24',
            'type'            => 'Permanent',
            'permanent_date'  => '2022-11-21',
            'casual_leave'    => '1',
            'earn_leave'      => '5',
            'department_id'   => '1',
            'biometric_id'    => '11',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
