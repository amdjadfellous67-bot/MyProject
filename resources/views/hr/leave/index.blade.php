@extends('layouts.app')
@section('title', 'Leave Requests')
@section('role', 'HR Manager')

@section('menu')
<li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
    <span>Dashboard</span></a></li>
<li class="nav-item"><a href="{{ route('hr.employees.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
    <span>Employees</span></a></li>
<li class="nav-item"><a href="{{ route('hr.leave.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect></svg>
    <span>Leave Requests</span>
    @if($pendingLeaveCount > 0)
    <span style="background: var(--error); color: white; border-radius: 50%; padding: 2px 8px; font-size: 0.75rem; margin-left: auto;">{{ $pendingLeaveCount }}</span>
    @endif
</a></li>
<li class="nav-item"><a href="{{ route('hr.salary.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
    <span>Payroll</span></a></li>
<li class="nav-item"><a href="{{ route('hr.evaluations.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
    <span>Evaluations</span></a></li>
@endsection

@section('content')
<div class="page-header">
    <h2>Leave Requests</h2>
    <p>Pending requests from your department</p>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Days</th>
                <th>Reason</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaveRequests as $request)
            <tr>
                <td>{{ $request->employee->first_name }} {{ $request->employee->last_name }}</td>
                <td>{{ $request->leaveType->name }}</td>
                <td>{{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}</td>
                <td>{{ $request->days_requested }}</td>
                <td>{{ Str::limit($request->reason, 30) }}</td>
                <td>
                    @if($request->status == 'pending')
                    <form action="{{ route('hr.leave.approve', $request->id) }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-primary" style="padding:6px 12px;font-size:0.8rem">Approve</button>
                    </form>
                    <form action="{{ route('hr.leave.reject', $request->id) }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-danger" style="padding:6px 12px;font-size:0.8rem" onclick="return confirm('Reject?')">Reject</button>
                    </form>
                    @elseif($request->status == 'approved')
                    <span class="badge badge-success">Approved</span>
                    @else
                    <span class="badge badge-error">Rejected</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center">No pending requests</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $leaveRequests->links() }}
</div>
@endsection