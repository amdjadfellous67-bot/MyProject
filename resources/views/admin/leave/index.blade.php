@extends('layouts.app')
@section('title', 'Leave Requests')
@section('role', 'Admin')

@section('menu')
    <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('employees.index') }}" class="nav-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
            <span>Employees</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('departments.index') }}" class="nav-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="18" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
            <span>Departments</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('positions.index') }}" class="nav-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
            <span>Positions</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('backup.index') }}" class="nav-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            <span>Backup</span>
        </a>
    </li>
@endsection

@section('content')
<div class="page-header">
    <h2>Leave Requests</h2>
    <p>Review and manage employee leave requests</p>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
            Pending Requests
        </h3>
    </div>
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
                    <form action="{{ route('leave.approve', $request->id) }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-primary" style="padding:6px 12px;font-size:0.8rem">Approve</button>
                    </form>
                    <form action="{{ route('leave.reject', $request->id) }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-danger" style="padding:6px 12px;font-size:0.8rem" onclick="return confirm('Reject this request?')">Reject</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center">No pending leave requests</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $leaveRequests->links() }}
</div>
@endsection