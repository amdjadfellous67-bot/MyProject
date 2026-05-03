<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('employees')->get();
        return view('admin.departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Department::create($request->all());
        return redirect()->route('departments.index')->with('success', 'Department created');
    }

    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate(['name' => 'required']);
        $department->update($request->all());
        return redirect()->route('departments.index')->with('success', 'Department updated');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted');
    }
}

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::with('department')->get();
        $departments = Department::all();
        return view('admin.positions.index', compact('positions', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required', 'department_id' => 'required']);
        Position::create($request->all());
        return redirect()->route('positions.index')->with('success', 'Position created');
    }

    public function edit(Position $position)
    {
        $departments = Department::all();
        return view('admin.positions.edit', compact('position', 'departments'));
    }

    public function update(Request $request, Position $position)
    {
        $request->validate(['title' => 'required', 'department_id' => 'required']);
        $position->update($request->all());
        return redirect()->route('positions.index')->with('success', 'Position updated');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return redirect()->route('positions.index')->with('success', 'Position deleted');
    }
}