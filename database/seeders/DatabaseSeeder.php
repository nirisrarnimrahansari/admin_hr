<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([DesignationTableSeeder::class]);
        $this->call([DepartmentTableSeeder::class]);
        $this->call([ShiftTableSeeder::class]);
        $this->call([UserPermissionTableSeeder::class]);
        $this->call([UserRoleTableSeeder::class]);
        $this->call([UsersTableSeeder::class]);
        $this->call([HolidayTableSeeder::class]);
        $this->call([EmployeesTableSeeder::class]);
        $this->call([PermissionTableSeeder::class]);
        $this->call([LeaveStatusTableSeeder::class]);
    }
}
