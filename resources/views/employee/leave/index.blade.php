@extends('layouts.app')
@section('title', 'My Leave')
@section('role', 'Employee')

@section('menu')
<li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
    <span>Dashboard</span></a></li>
<li class="nav-item"><a href="{{ route('employee.leave.index') }}" class="nav-link active">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
    <span>Leave Requests</span></a></li>
<li class="nav-item"><a href="{{ route('employee.salary.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
    <span>My Salary</span></a></li>
<li class="nav-item"><a href="{{ route('employee.evaluations.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
    <span>My Evaluations</span></a></li>
@endsection

@section('content')
<div class="page-header">
    <h2>My Leave</h2>
    <p>View your leave balances and request time off</p>
</div>

<div class="stats-grid">
    @foreach($balances as $balance)
    <div class="stat-card">
        <div class="stat-icon purple">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line></svg>
        </div>
        <div class="stat-info">
            <h3>{{ $balance->total - $balance->used }} / {{ $balance->total }}</h3>
            <p>{{ $balance->leaveType->name }}</p>
        </div>
    </div>
    @endforeach
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
            Leave Requests
        </h3>
        <a href="{{ route('employee.leave.create') }}" class="btn btn-primary">+ New Request</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Days</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $request)
            <tr>
                <td>{{ $request->leaveType->name }}</td>
                <td>{{ \Carbon\Carbon::parse($request->start_date)->format('M d, Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($request->end_date)->format('M d, Y') }}</td>
                <td>{{ $request->days_requested }}</td>
                <td>
                    @if($request->status == 'pending')
                    <span class="badge badge-warning">Pending</span>
                    @elseif($request->status == 'approved')
                    <span class="badge badge-success">Approved</span>
                    @else
                    <span class="badge badge-error">Rejected</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center">No leave requests yet</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
