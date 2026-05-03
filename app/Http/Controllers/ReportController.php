<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\LeaveRequest;
use App\Models\Salary;
use App\Models\Evaluation;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));
        
        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('status', 'active')->count();
        $departments = Department::withCount('employees')->get();
        
        $leaveStats = [
            'pending' => LeaveRequest::where('status', 'pending')->count(),
            'approved' => LeaveRequest::where('status', 'approved')->count(),
            'rejected' => LeaveRequest::where('status', 'rejected')->count(),
        ];
        
        $salaryStats = Salary::where('month', $month)
            ->where('year', $year)
            ->selectRaw('SUM(gross_salary) as total_gross, SUM(net_salary) as total_net, COUNT(*) as employee_count')
            ->first() ?? (object)['total_gross' => 0, 'total_net' => 0, 'employee_count' => 0];
        
        $avgEvaluation = Evaluation::avg('rating') ?? 0;
        
        $monthlyTrends = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyTrends[] = [
                'month' => Carbon::createFromDate($year, $m)->format('M'),
                'salaries' => Salary::where('month', str_pad($m, 2, '0', STR_PAD_LEFT))->where('year', $year)->sum('net_salary'),
                'leave_requests' => LeaveRequest::whereYear('created_at', $year)->whereMonth('created_at', $m)->count(),
            ];
        }
        
        return view('admin.reports.index', compact(
            'totalEmployees', 'activeEmployees', 'departments', 
            'leaveStats', 'salaryStats', 'avgEvaluation', 'monthlyTrends',
            'month', 'year'
        ));
    }
    
    public function export(Request $request)
    {
        $month = $request->get('month', date('m'));
        $year = $request->get('year', date('Y'));
        $format = $request->get('format', 'csv');
        
        $employees = Employee::with('department', 'position')->get();
        $salaries = Salary::where('month', $month)->where('year', $year)->get();
        
        if ($format === 'pdf') {
            $totalGross = $salaries->sum('gross_salary');
            $totalNet = $salaries->sum('net_salary');
            return view('admin.reports.export-pdf', compact('employees', 'salaries', 'month', 'year', 'totalGross', 'totalNet'));
        }
        
        $csv = "Employee ID,Name,Department,Position,Base Salary,Gross,Net\n";
        
        foreach ($employees as $emp) {
            $salary = $salaries->firstWhere('employee_id', $emp->id);
            $deptName = $emp->department ? $emp->department->name : '';
            $posTitle = $emp->position ? $emp->position->title : '';
            $csv .= "{$emp->matricule},{$emp->first_name} {$emp->last_name},";
            $csv .= "{$deptName},{$posTitle},";
            $csv .= "{$emp->base_salary},";
            $csv .= ($salary ? "{$salary->gross_salary},{$salary->net_salary}" : "0,0");
            $csv .= "\n";
        }
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=hr_report_{$month}_{$year}.csv",
        ];
        
        return response($csv, 200, $headers);
    }
}