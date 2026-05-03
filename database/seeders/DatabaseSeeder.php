<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departments')->insert([
            ['name' => 'Engineering', 'description' => 'Engineering Department'],
            ['name' => 'Human Resources', 'description' => 'HR Department'],
            ['name' => 'Finance', 'description' => 'Finance Department'],
            ['name' => 'Marketing', 'description' => 'Marketing Department'],
        ]);

        DB::table('positions')->insert([
            ['title' => 'HR Manager', 'level' => 'Senior', 'department_id' => 2, 'base_salary' => 12000],
            ['title' => 'Software Engineer', 'level' => 'Junior', 'department_id' => 1, 'base_salary' => 8000],
            ['title' => 'Accountant', 'level' => 'Mid', 'department_id' => 3, 'base_salary' => 7000],
        ]);

        DB::table('leave_types')->insert([
            ['name' => 'annual', 'display_name' => 'Annual Leave', 'days_allowed' => 20],
            ['name' => 'sick', 'display_name' => 'Sick Leave', 'days_allowed' => 14],
            ['name' => 'maternity', 'display_name' => 'Maternity/Paternity', 'days_allowed' => 90],
            ['name' => 'unpaid', 'display_name' => 'Unpaid Leave', 'days_allowed' => 0],
            ['name' => 'exceptional', 'display_name' => 'Exceptional Leave', 'days_allowed' => 5],
        ]);

        DB::table('employees')->insert([
            'matricule' => 'EMP001',
            'name' => 'Admin',
            'surname' => 'User',
            'email' => 'admin@hrflow.com',
            'telephone' => '0612345678',
            'date_of_hire' => '2024-01-01',
            'department_id' => 2,
            'position_id' => 1,
            'base_salary' => 10000,
            'status' => 'active',
        ]);

        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@hrflow.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'employee_id' => 1,
        ]);

        DB::table('leave_balances')->insert([
            ['employee_id' => 1, 'leave_type_id' => 1, 'balance' => 20, 'used' => 0, 'year' => 2026],
            ['employee_id' => 1, 'leave_type_id' => 2, 'balance' => 14, 'used' => 0, 'year' => 2026],
            ['employee_id' => 1, 'leave_type_id' => 3, 'balance' => 90, 'used' => 0, 'year' => 2026],
        ]);
    }
}