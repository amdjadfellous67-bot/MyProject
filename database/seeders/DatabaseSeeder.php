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
            DB::table('departments')->updateOrInsert($dept, $dept);
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

        $employeeExists = DB::table('employees')->where('matricule', 'EMP001')->exists();

        if (!$employeeExists) {
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

        $userExists = DB::table('users')->where('email', 'admin@hrflow.com')->exists();

        if (!$userExists) {
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

        $employeeId = DB::table('employees')->where('matricule', 'EMP001')->value('id');

        $balances = [
            ['employee_id' => $employeeId, 'leave_type_id' => 1, 'balance' => 20, 'used' => 0, 'year' => 2026],
            ['employee_id' => $employeeId, 'leave_type_id' => 2, 'balance' => 14, 'used' => 0, 'year' => 2026],
            ['employee_id' => $employeeId, 'leave_type_id' => 3, 'balance' => 90, 'used' => 0, 'year' => 2026],
        ];

        foreach ($balances as $bal) {
            DB::table('leave_balances')->updateOrInsert(
                ['employee_id' => $bal['employee_id'], 'leave_type_id' => $bal['leave_type_id'], 'year' => $bal['year']],
                $bal
            );
        }
    }
}

        $positions = [
            ['title' => 'HR Manager', 'level' => 'Senior', 'department_id' => 2, 'base_salary' => 12000],
            ['title' => 'Software Engineer', 'level' => 'Junior', 'department_id' => 1, 'base_salary' => 8000],
            ['title' => 'Accountant', 'level' => 'Mid', 'department_id' => 3, 'base_salary' => 7000],
        ];

        foreach ($positions as $pos) {
            DB::table('positions')->firstOrInsert(['title' => $pos['title']], $pos);
        }

        $leaveTypes = [
            ['name' => 'annual', 'display_name' => 'Annual Leave', 'days_allowed' => 20],
            ['name' => 'sick', 'display_name' => 'Sick Leave', 'days_allowed' => 14],
            ['name' => 'maternity', 'display_name' => 'Maternity/Paternity', 'days_allowed' => 90],
            ['name' => 'unpaid', 'display_name' => 'Unpaid Leave', 'days_allowed' => 0],
            ['name' => 'exceptional', 'display_name' => 'Exceptional Leave', 'days_allowed' => 5],
        ];

        foreach ($leaveTypes as $lt) {
            DB::table('leave_types')->firstOrInsert(['name' => $lt['name']], $lt);
        }

        DB::table('employees')->firstOrInsert(
            ['matricule' => 'EMP001'],
            [
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
            ]
        );

        DB::table('users')->firstOrInsert(
            ['email' => 'admin@hrflow.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@hrflow.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'employee_id' => DB::table('employees')->where('matricule', 'EMP001')->value('id'),
            ]
        );

        $employeeId = DB::table('employees')->where('matricule', 'EMP001')->value('id');
        $balances = [
            ['employee_id' => $employeeId, 'leave_type_id' => 1, 'balance' => 20, 'used' => 0, 'year' => 2026],
            ['employee_id' => $employeeId, 'leave_type_id' => 2, 'balance' => 14, 'used' => 0, 'year' => 2026],
            ['employee_id' => $employeeId, 'leave_type_id' => 3, 'balance' => 90, 'used' => 0, 'year' => 2026],
        ];

        foreach ($balances as $bal) {
            DB::table('leave_balances')->firstOrInsert(
                ['employee_id' => $bal['employee_id'], 'leave_type_id' => $bal['leave_type_id'], 'year' => $bal['year']],
                $bal
            );
        }
    }
}