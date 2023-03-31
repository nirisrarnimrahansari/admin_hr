<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_permissions')->insert([
            'name' => 'List Desingation',
            'slug' => 'list_designation',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Create Designation',
            'slug' => 'create_designation',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Update Designation',
            'slug' => 'update_designation',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Delete Designation',
            'slug' => 'delete_designation',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'List Shift',
            'slug' => 'list_shift',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Create Shift',
            'slug' => 'create_shift',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Update Shift',
            'slug' => 'update_shift',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Delete Shift',
            'slug' => 'delete_shift',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'list Employee',
            'slug' => 'list_employee',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Create Employee',
            'slug' => 'create_employee',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Update Employee',
            'slug' => 'update_employee',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Delete Employee',
            'slug' => 'delete_employee',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'List Leave Management',
            'slug' => 'list_leave_management',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Create Leave Management',
            'slug' => 'create_leave_management',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Update Leave Management',
            'slug' => 'update_leave_management',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Delete Leave Management',
            'slug' => 'delete_leave_management',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'List Holidays',
            'slug' => 'list_holidays',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Create Holidays',
            'slug' => 'create_holidays',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Update Holidays',
            'slug' => 'update_holidays',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Delete Holidays',
            'slug' => 'delete_holidays',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'List User',
            'slug' => 'list_user',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Create User',
            'slug' => 'create_user',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Update User',
            'slug' => 'update_user',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Delete User',
            'slug' => 'delete_user',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'List Genetate Salary',
            'slug' => 'list_generate_salary',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Create Generate Salary',
            'slug' => 'create_generate_salary',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Create Leave Status',
            'slug' => 'create_leave_status',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Update Leave Status',
            'slug' => 'update_leave_status',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Delete Leave Status',
            'slug' => 'delete_leave_status',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'List User Role',
            'slug' => 'list_user_role',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Create User Role',
            'slug' => 'create_user_role',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Update User Role',
            'slug' => 'update_user_role',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Delete User Role',
            'slug' => 'delete_user_role',
        ]);
       
        DB::table('user_permissions')->insert([
            'name' => 'List Department',
            'slug' => 'list_department',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Create Department',
            'slug' => 'create_department',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Update Department',
            'slug' => 'update_department',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Delete Department',
            'slug' => 'delete_department',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'List User Permission',
            'slug' => 'list_user_permission',
        ]);
         DB::table('user_permissions')->insert([
            'name' => 'Create User Permission',
            'slug' => 'create_user_permission',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Update User Permission',
            'slug' => 'update_user_permission',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Delete User Permission',
            'slug' => 'delete_user_permission',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'List Profile',
            'slug' => 'list_profile',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Create Profile',
            'slug' => 'create_profile',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Update Profile',
            'slug' => 'update_profile',
        ]);
       
        DB::table('user_permissions')->insert([
            'name' => 'List Manager Access',
            'slug' => 'list_manager_access',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Create Manager Access',
            'slug' => 'create_manager_access',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Update Manager Access',
            'slug' => 'update_manager_access',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Delete Manager Access',
            'slug' => 'delete_manager_access',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'View Employee',
            'slug' => 'view_employee',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'List Email Format',
            'slug' => 'list_email_format',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'List Import Export',
            'slug' => 'list_import_export',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Create Email Format',
            'slug' => 'create_email_format',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Update Email Format',
            'slug' => 'update_email_format',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'Delete Email Format',
            'slug' => 'delete_email_format',
        ]);
        DB::table('user_permissions')->insert([
            'name' => 'List Leave Status',
            'slug' => 'list_leave_status',
        ]);

    }
}
