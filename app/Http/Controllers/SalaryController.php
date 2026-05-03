<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        $query = Salary::with('employee');
        
        if ($request->has('month') && $request->month) {
            $query->where('month', $request->month);
        }
        
        $salaries = $query->orderByDesc('year')->orderByDesc('month')->paginate(10);
        return view('admin.salary.index', compact('salaries'));
    }

    public function employeeIndex()
    {
        $employee = Auth::user()->employee;
        $salaries = Salary::where('employee_id', $employee->id)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();
            
        return view('employee.salary.index', compact('salaries'));
    }

    public function show(Salary $salary)
    {
        return view('admin.salary.show', compact('salary'));
    }

    public function employeeShow(Salary $salary)
    {
        $employee = Auth::user()->employee;
        if ($salary->employee_id !== $employee->id) {
            abort(403);
        }
        return view('employee.salary.show', compact('salary'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'month' => 'required',
            'year' => 'required',
        ]);

        $employees = Employee::where('status', 'active')->get();
        
        foreach ($employees as $employee) {
            $gross = $employee->base_salary;
            $cnss = $gross * 0.15;
            $bonuses = 0;
            $deductions = $request->input('deductions_' . $employee->id, 0);
            $net = $gross + $bonuses - $cnss - $deductions;

            Salary::updateOrCreate(
                ['employee_id' => $employee->id, 'month' => $request->month, 'year' => $request->year],
                [
                    'gross_salary' => $gross,
                    'bonus_seniority' => 0,
                    'bonus_performance' => 0,
                    'bonus_attendance' => 0,
                    'deduction_cnss' => $cnss,
                    'deduction_advances' => 0,
                    'deduction_absences' => $deductions,
                    'net_salary' => $net,
                ]
            );
        }

        return back()->with('success', 'Payroll processed successfully');
    }

    public function hrIndex(Request $request)
    {
        $hrEmployee = Auth::user()->employee;
        $query = Salary::with('employee')
            ->whereHas('employee', function($q) use ($hrEmployee) {
                $q->where('department_id', $hrEmployee->department_id);
            });
        
        if ($request->has('month') && $request->month) {
            $query->where('month', $request->month);
        }
        
        $salaries = $query->orderByDesc('year')->orderByDesc('month')->paginate(10);
        return view('hr.salary.index', compact('salaries'));
    }

    public function hrForm(Request $request)
    {
        $hrEmployee = Auth::user()->employee;
        $employees = Employee::where('status', 'active')
            ->where('department_id', $hrEmployee->department_id)
            ->select('id', 'name', 'surname', 'base_salary')
            ->get();

        return response()->json(['employees' => $employees]);
    }

    public function hrShow(Salary $salary)
    {
        $hrEmployee = Auth::user()->employee;
        if ($salary->employee->department_id !== $hrEmployee->department_id) {
            abort(403);
        }
        return view('hr.salary.show', compact('salary'));
    }

    public function hrProcess(Request $request)
    {
        $request->validate([
            'month' => 'required',
            'year' => 'required',
            'employees' => 'required|array',
        ]);

        $hrEmployee = Auth::user()->employee;

        foreach ($request->employees as $empId) {
            $employee = Employee::find($empId);
            if (!$employee || $employee->department_id !== $hrEmployee->department_id) {
                continue;
            }

            $gross = $employee->base_salary;
            $cnss = $gross * 0.15;
            $bonusSeniority = $request->input("bonus_seniority_{$empId}", 0);
            $bonusPerformance = $request->input("bonus_performance_{$empId}", 0);
            $bonusAttendance = $request->input("bonus_attendance_{$empId}", 0);
            $deductionAdvances = $request->input("deduction_advances_{$empId}", 0);
            $deductionAbsences = $request->input("deduction_absences_{$empId}", 0);

            $totalBonuses = $bonusSeniority + $bonusPerformance + $bonusAttendance;
            $totalDeductions = $cnss + $deductionAdvances + $deductionAbsences;
            $net = $gross + $totalBonuses - $totalDeductions;

            Salary::updateOrCreate(
                ['employee_id' => $empId, 'month' => $request->month, 'year' => $request->year],
                [
                    'gross_salary' => $gross,
                    'bonus_seniority' => $bonusSeniority,
                    'bonus_performance' => $bonusPerformance,
                    'bonus_attendance' => $bonusAttendance,
                    'deduction_cnss' => $cnss,
                    'deduction_advances' => $deductionAdvances,
                    'deduction_absences' => $deductionAbsences,
                    'net_salary' => $net,
                ]
            );
        }

        return back()->with('success', 'Payroll processed successfully');
    }

    public function hrPrint(Request $request)
    {
        $hrEmployee = Auth::user()->employee;
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));

        $salaries = Salary::with('employee.department', 'employee.position')
            ->where('month', $month)
            ->where('year', $year)
            ->whereHas('employee', function($q) use ($hrEmployee) {
                $q->where('department_id', $hrEmployee->department_id);
            })
            ->get();

        return view('hr.salary.print-all', compact('salaries', 'month', 'year'));
    }
}