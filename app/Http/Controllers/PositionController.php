<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\Department;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::with('departments')->paginate(10);
        $departments = Department::all();
        return view('admin.positions.index', compact('positions', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.positions.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'department_id' => 'required',
        ]);

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
        $request->validate([
            'title' => 'required',
            'department_id' => 'required',
        ]);

        $position->update($request->all());

        return redirect()->route('positions.index')->with('success', 'Position updated');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return back()->with('success', 'Position deleted');
    }
}