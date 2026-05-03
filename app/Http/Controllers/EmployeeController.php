<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\User;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with('department', 'position')->paginate(10);
        return view('admin.employees.index', compact('employees'));
    }

    public function hrIndex()
    {
        $hrEmployee = Auth::user()->employee;
        $employees = Employee::with('department', 'position')
            ->where('department_id', $hrEmployee->department_id)
            ->paginate(10);
        return view('hr.employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::all();
        $positions = Position::all();
        return view('admin.employees.create', compact('departments', 'positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email|unique:employees',
            'password' => 'required|min:6',
        ], [
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required for login access.',
        ]);

        $employee = Employee::create($request->all());

        User::create([
            'name' => $employee->name . ' ' . $employee->surname,
            'email' => $employee->email,
            'password' => Hash::make($request->password),
            'role' => $request->user_role ?? 'employee',
            'employee_id' => $employee->id,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully! Login credentials have been set.');
    }

    public function show(Employee $employee)
    {
        return view('admin.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $positions = Position::with('departments')->get();
        return view('admin.employees.edit', compact('employee', 'departments', 'positions'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'email' => 'required|email|unique:employees,email,' . $employee->id,
        ]);

        $employee->update($request->all());
        return redirect()->route('employees.show', $employee)->with('success', 'Employee updated successfully');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->user) {
            $employee->user->delete();
        }
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully');
    }
}