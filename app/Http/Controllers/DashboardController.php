<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\LeaveRequest;
use App\Models\LeaveType;

class DashboardController extends Controller
{
    public function admin()
    {
        $stats = [
            'totalUsers' => \App\Models\User::count(),
            'totalEmployees' => Employee::count(),
            'totalDepartments' => Department::count(),
            'totalPositions' => Position::count(),
        ];
        
        return view('admin.dashboard', $stats);
    }

    public function hr()
    {
        $hrEmployee = Auth::user()->employee;
        
        $stats = [
            'totalEmployees' => Employee::where('department_id', $hrEmployee->department_id)->count(),
            'pendingLeave' => LeaveRequest::where('status', 'pending')
                ->whereHas('employee', function($q) use ($hrEmployee) {
                    $q->where('department_id', $hrEmployee->department_id);
                })->count(),
            'totalDepartments' => Department::count(),
        ];
        
        $recentLeave = LeaveRequest::with('employee', 'leaveType')
            ->where('status', 'pending')
            ->whereHas('employee', function($q) use ($hrEmployee) {
                $q->where('department_id', $hrEmployee->department_id);
            })
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
            
        return view('hr.dashboard', compact('stats', 'recentLeave'));
    }

    public function employee()
    {
        $user = Auth::user();
        $employee = $user->employee;
        
        $balances = \DB::table('leave_balances')
            ->join('leave_types', 'leave_balances.leave_type_id', '=', 'leave_types.id')
            ->select('leave_balances.balance', 'leave_balances.used', 'leave_types.display_name')
            ->where('leave_balances.employee_id', $employee->id)
            ->where('leave_balances.year', date('Y'))
            ->get();
            
        $leaveTypes = LeaveType::all();
        
        $requests = LeaveRequest::where('employee_id', $employee->id)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();
            
        $profile = Employee::where('id', $employee->id)->first();
        
        return view('employee.dashboard', compact('balances', 'leaveTypes', 'requests', 'profile'));
    }
}