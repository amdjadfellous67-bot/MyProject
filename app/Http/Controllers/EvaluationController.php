<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    public function index(Request $request)
    {
        $query = Evaluation::with('employee');
        
        if ($request->has('employee_id') && $request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }
        if ($request->has('period') && $request->period) {
            $query->where('period', $request->period);
        }
        
        $evaluations = $query->orderByDesc('period')->orderByDesc('created_at')->paginate(10);
        $employees = Employee::where('status', 'active')->get();
        
        return view('admin.evaluations.index', compact('evaluations', 'employees'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        return view('admin.evaluations.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'period' => 'required',
            'rating' => 'required|min:1|max:5',
            'punctuality' => 'required|min:1|max:5',
            'work_quality' => 'required|min:1|max:5',
            'teamwork' => 'required|min:1|max:5',
            'initiative' => 'required|min:1|max:5',
            'comments' => 'nullable',
        ]);

        Evaluation::create([
            'employee_id' => $request->employee_id,
            'period' => $request->period,
            'rating' => $request->rating,
            'punctuality' => $request->punctuality,
            'work_quality' => $request->work_quality,
            'teamwork' => $request->teamwork,
            'initiative' => $request->initiative,
            'comments' => $request->comments,
            'evaluated_by' => auth()->user()->employee->id ?? 1,
        ]);

        return redirect()->route('evaluations.index')->with('success', 'Evaluation submitted');
    }

    public function edit(Evaluation $evaluation)
    {
        $employees = Employee::where('status', 'active')->get();
        return view('admin.evaluations.edit', compact('evaluation', 'employees'));
    }

    public function update(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'rating' => 'required|min:1|max:5',
            'punctuality' => 'required|min:1|max:5',
            'work_quality' => 'required|min:1|max:5',
            'teamwork' => 'required|min:1|max:5',
            'initiative' => 'required|min:1|max:5',
            'comments' => 'nullable',
        ]);

        $evaluation->update($request->all());

        return redirect()->route('evaluations.index')->with('success', 'Evaluation updated');
    }

    public function hrIndex(Request $request)
    {
        $hrEmployee = Auth::user()->employee;
        $query = Evaluation::with('employee')
            ->whereHas('employee', function($q) use ($hrEmployee) {
                $q->where('department_id', $hrEmployee->department_id);
            });

        if ($request->has('employee_id') && $request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }
        if ($request->has('period') && $request->period) {
            $query->where('period', $request->period);
        }

        $evaluations = $query->orderByDesc('period')->orderByDesc('created_at')->paginate(10);
        $employees = Employee::where('status', 'active')
            ->where('department_id', $hrEmployee->department_id)
            ->get();

        return view('hr.evaluations.index', compact('evaluations', 'employees'));
    }

    public function hrCreate()
    {
        $hrEmployee = Auth::user()->employee;
        $employees = Employee::where('status', 'active')
            ->where('department_id', $hrEmployee->department_id)
            ->get();
        return view('hr.evaluations.create', compact('employees'));
    }

    public function hrStore(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'period' => 'required',
            'rating' => 'required|min:1|max:5',
            'punctuality' => 'required|min:1|max:5',
            'work_quality' => 'required|min:1|max:5',
            'teamwork' => 'required|min:1|max:5',
            'initiative' => 'required|min:1|max:5',
            'comments' => 'nullable',
        ]);

        Evaluation::create([
            'employee_id' => $request->employee_id,
            'period' => $request->period,
            'evaluation_date' => now()->toDateString(),
            'score_technical' => $request->work_quality,
            'comment_technical' => $request->comments,
            'score_behavior' => $request->teamwork,
            'comment_behavior' => $request->comments,
            'score_objectives' => $request->initiative,
            'comment_objectives' => $request->comments,
            'score_punctuality' => $request->punctuality,
            'overall_score' => $request->rating,
            'evaluator_id' => Auth::user()->employee->id,
        ]);

        return redirect()->route('hr.evaluations.index')->with('success', 'Evaluation submitted');
    }

    public function employeeIndex()
    {
        $employee = Auth::user()->employee;
        $evaluations = Evaluation::where('employee_id', $employee->id)
            ->orderByDesc('evaluation_date')
            ->paginate(10);
        return view('employee.evaluations.index', compact('evaluations'));
    }
}