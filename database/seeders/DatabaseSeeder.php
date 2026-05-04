<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Engineering', 'description' => 'Engineering Department'],
            ['name' => 'Human Resources', 'description' => 'HR Department'],
            ['name' => 'Finance', 'description' => 'Finance Department'],
            ['name' => 'Marketing', 'description' => 'Marketing Department'],
        ];

        foreach ($departments as $dept) {
            DB::table('departments')->updateOrInsert(['name' => $dept['name']], $dept);
        }

        $positions = [
            ['title' => 'HR Manager', 'level' => 'Senior', 'department_id' => 2, 'base_salary' => 12000],
            ['title' => 'Software Engineer', 'level' => 'Junior', 'department_id' => 1, 'base_salary' => 8000],
            ['title' => 'Accountant', 'level' => 'Mid', 'department_id' => 3, 'base_salary' => 7000],
        ];

        foreach ($positions as $pos) {
            DB::table('positions')->updateOrInsert(['title' => $pos['title']], $pos);
        }

        $leaveTypes = [
            ['name' => 'annual', 'display_name' => 'Annual Leave', 'days_allowed' => 20],
            ['name' => 'sick', 'display_name' => 'Sick Leave', 'days_allowed' => 14],
            ['name' => 'maternity', 'display_name' => 'Maternity/Paternity', 'days_allowed' => 90],
            ['name' => 'unpaid', 'display_name' => 'Unpaid Leave', 'days_allowed' => 0],
            ['name' => 'exceptional', 'display_name' => 'Exceptional Leave', 'days_allowed' => 5],
        ];

        foreach ($leaveTypes as $lt) {
            DB::table('leave_types')->updateOrInsert(['name' => $lt['name']], $lt);
        }

        // Admin employee
        if (!DB::table('employees')->where('matricule', 'EMP001')->exists()) {
            DB::table('employees')->insert([
                'matricule' => 'EMP001',
                'name' => 'Admin',
                'surname' => 'User',
                'email' => 'admin@hrflow.com',
                'telephone' => '0612345678',
                'date_of_hire' => '2024-01-01',
                'department_id' => 1,
                'position_id' => 1,
                'base_salary' => 10000,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // HR Manager employee
        if (!DB::table('employees')->where('matricule', 'EMP002')->exists()) {
            DB::table('employees')->insert([
                'matricule' => 'EMP002',
                'name' => 'HR',
                'surname' => 'Manager',
                'email' => 'hr@hrflow.com',
                'telephone' => '0612345679',
                'date_of_hire' => '2024-01-01',
                'department_id' => 2,
                'position_id' => 1,
                'base_salary' => 12000,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Regular employee
        if (!DB::table('employees')->where('matricule', 'EMP003')->exists()) {
            DB::table('employees')->insert([
                'matricule' => 'EMP003',
                'name' => 'John',
                'surname' => 'Employee',
                'email' => 'employee@hrflow.com',
                'telephone' => '0612345680',
                'date_of_hire' => '2024-06-01',
                'department_id' => 1,
                'position_id' => 2,
                'base_salary' => 8000,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Admin user
        if (!DB::table('users')->where('email', 'admin@hrflow.com')->exists()) {
            $employeeId = DB::table('employees')->where('matricule', 'EMP001')->value('id');
            DB::table('users')->insert([
                'name' => 'Admin User',
                'email' => 'admin@hrflow.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'employee_id' => $employeeId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // HR Manager user
        if (!DB::table('users')->where('email', 'hr@hrflow.com')->exists()) {
            $employeeId = DB::table('employees')->where('matricule', 'EMP002')->value('id');
            DB::table('users')->insert([
                'name' => 'HR Manager',
                'email' => 'hr@hrflow.com',
                'password' => Hash::make('hr123'),
                'role' => 'hr_manager',
                'employee_id' => $employeeId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Employee user
        if (!DB::table('users')->where('email', 'employee@hrflow.com')->exists()) {
            $employeeId = DB::table('employees')->where('matricule', 'EMP003')->value('id');
            DB::table('users')->insert([
                'name' => 'John Employee',
                'email' => 'employee@hrflow.com',
                'password' => Hash::make('employee123'),
                'role' => 'employee',
                'employee_id' => $employeeId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Leave balances for admin
        $adminEmployeeId = DB::table('employees')->where('matricule', 'EMP001')->value('id');
        if ($adminEmployeeId) {
            $balances = [
                ['employee_id' => $adminEmployeeId, 'leave_type_id' => 1, 'balance' => 20, 'used' => 0, 'year' => 2026],
                ['employee_id' => $adminEmployeeId, 'leave_type_id' => 2, 'balance' => 14, 'used' => 0, 'year' => 2026],
                ['employee_id' => $adminEmployeeId, 'leave_type_id' => 3, 'balance' => 90, 'used' => 0, 'year' => 2026],
            ];

            foreach ($balances as $bal) {
                DB::table('leave_balances')->updateOrInsert(
                    ['employee_id' => $bal['employee_id'], 'leave_type_id' => $bal['leave_type_id'], 'year' => $bal['year']],
                    $bal
                );
            }
        }
    }
}
