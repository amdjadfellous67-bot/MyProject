<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveRequest::with('employee', 'leaveType');
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $leaveRequests = $query->orderByDesc('created_at')->paginate(10);
        return view('admin.leave.index', compact('leaveRequests'));
    }

    public function hrIndex(Request $request)
    {
        $hrEmployee = Auth::user()->employee;
        $query = LeaveRequest::with('employee', 'leaveType')
            ->whereHas('employee', function($q) use ($hrEmployee) {
                $q->where('department_id', $hrEmployee->department_id);
            });
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $leaveRequests = $query->orderByDesc('created_at')->paginate(10);
        return view('hr.leave.index', compact('leaveRequests'));
    }

    public function employeeIndex()
    {
        $user = Auth::user();
        $employee = $user->employee;
        
        $balances = LeaveBalance::where('employee_id', $employee->id)
            ->where('year', date('Y'))
            ->get();
            
        $requests = LeaveRequest::where('employee_id', $employee->id)
            ->orderByDesc('created_at')
            ->get();
            
        return view('employee.leave.index', compact('balances', 'requests'));
    }

    public function create()
    {
        $leaveTypes = LeaveType::all();
        return view('employee.leave.create', compact('leaveTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable',
        ]);

        $employee = Auth::user()->employee;
        
        $start = \Carbon\Carbon::parse($request->start_date);
        $end = \Carbon\Carbon::parse($request->end_date);
        $days = $start->diffInDaysFiltered(function ($date) {
            return !$date->isWeekend();
        }, $end) + 1;

        LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type_id' => $request->leave_type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'days_requested' => $days,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->route('employee.leave.index')->with('success', 'Leave request submitted');
    }

    public function approve(LeaveRequest $leaveRequest)
    {
        $leaveRequest->update([
            'status' => 'approved',
            'approved_by' => Auth::user()->employee->id,
        ]);
        
        $balance = LeaveBalance::where('employee_id', $leaveRequest->employee_id)
            ->where('leave_type_id', $leaveRequest->leave_type_id)
            ->where('year', $leaveRequest->start_date->year)
            ->first();
            
        if ($balance) {
            $balance->increment('used', $leaveRequest->days_requested);
        }

        return back()->with('success', 'Leave request approved');
    }

    public function reject(Request $request, LeaveRequest $leaveRequest)
    {
        $leaveRequest->update([
            'status' => 'rejected',
            'approved_by' => Auth::user()->employee->id,
            'rejection_reason' => $request->reason,
        ]);

        return back()->with('success', 'Leave request rejected');
    }

    public function hrApprove(LeaveRequest $leaveRequest)
    {
        $leaveRequest->update([
            'status' => 'approved',
            'approved_by' => Auth::user()->employee->id,
        ]);
        
        $balance = LeaveBalance::where('employee_id', $leaveRequest->employee_id)
            ->where('leave_type_id', $leaveRequest->leave_type_id)
            ->where('year', \Carbon\Carbon::parse($leaveRequest->start_date)->year)
            ->first();
            
        if ($balance) {
            $balance->increment('used', $leaveRequest->days_requested);
        }

        return back()->with('success', 'Leave request approved');
    }

    public function hrReject(Request $request, LeaveRequest $leaveRequest)
    {
        $leaveRequest->update([
            'status' => 'rejected',
            'approved_by' => Auth::user()->employee->id,
            'rejection_reason' => $request->reason,
        ]);

        return back()->with('success', 'Leave request rejected');
    }
}