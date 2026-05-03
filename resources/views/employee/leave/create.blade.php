@extends('layouts.app')
@section('title', 'Request Leave')
@section('role', 'Employee')

@section('menu')
<li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
    <span>Dashboard</span></a></li>
<li class="nav-item"><a href="{{ route('employee.leave.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
    <span>Leave Requests</span></a></li>
<li class="nav-item"><a href="{{ route('employee.salary.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
    <span>My Salary</span></a></li>
@endsection

@section('content')
<div class="page-header">
    <h2>Request Leave</h2>
    <p>Submit a new leave request</p>
</div>

<div class="card">
    <form action="{{ route('employee.leave.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Leave Type</label>
            <select name="leave_type_id" class="form-control" required>
                <option value="">Select leave type</option>
                @foreach($leaveTypes as $type)
                <option value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="form-group">
                <label>End Date</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label>Reason</label>
            <textarea name="reason" class="form-control" rows="4" placeholder="Reason for leave request"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Request</button>
        <a href="{{ route('employee.leave.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection