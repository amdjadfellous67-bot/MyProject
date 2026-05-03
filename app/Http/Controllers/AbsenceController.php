<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absence;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class AbsenceController extends Controller
{
    public function hrIndex(Request $request)
    {
        $hrEmployee = Auth::user()->employee;
        $query = Absence::with('employee')
            ->whereHas('employee', function($q) use ($hrEmployee) {
                $q->where('department_id', $hrEmployee->department_id);
            });
        
        if ($request->has('month') && $request->month) {
            $query->whereRaw("strftime('%m', date) = ?", [$request->month]);
        }
        
        $absences = $query->orderByDesc('date')->paginate(10);
        $employees = Employee::where('status', 'active')
            ->where('department_id', $hrEmployee->department_id)
            ->get();
        
        return view('hr.absences.index', compact('absences', 'employees'));
    }

    public function hrStore(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'date' => 'required|date',
            'type' => 'required',
            'reason' => 'nullable',
            'deduction_hours' => 'required|min:0',
        ]);

        Absence::create([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'type' => $request->type,
            'reason' => $request->reason,
            'deduction_hours' => $request->deduction_hours,
            'recorded_by' => Auth::user()->employee->id,
        ]);

        return back()->with('success', 'Absence recorded');
    }

    public function hrDestroy(Absence $absence)
    {
        $absence->delete();
        return back()->with('success', 'Absence deleted');
    }
}