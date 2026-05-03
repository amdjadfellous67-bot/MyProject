@extends('layouts.app')
@section('title', 'HR Manager Dashboard')
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
    <h2>HR Manager Dashboard</h2>
    <p>Overview of your department</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
        </div>
        <div class="stat-info">
            <h3>{{ $stats['totalEmployees'] }}</h3>
            <p>My Employees</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect></svg>
        </div>
        <div class="stat-info">
            <h3>{{ $stats['pendingLeave'] }}</h3>
            <p>Pending Leave</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
        </div>
        <div class="stat-info">
            <h3>{{ $stats['totalDepartments'] }}</h3>
            <p>Departments</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Recent Leave Requests</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Type</th>
                <th>Dates</th>
                <th>Days</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recentLeave as $leave)
            <tr>
                <td>{{ $leave->employee->first_name ?? '' }} {{ $leave->employee->last_name ?? '' }}</td>
                <td>{{ $leave->leaveType->name ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('M d') }}</td>
                <td>{{ $leave->days_requested }}</td>
                <td>
                    @if($leave->status == 'pending')
                    <span class="badge badge-warning">Pending</span>
                    @elseif($leave->status == 'approved')
                    <span class="badge badge-success">Approved</span>
                    @else
                    <span class="badge badge-error">Rejected</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center">No pending requests</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection