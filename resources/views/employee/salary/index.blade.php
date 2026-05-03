@extends('layouts.app')
@section('title', 'My Salary')
@section('role', 'Employee')

@section('menu')
<li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
    <span>Dashboard</span></a></li>
<li class="nav-item"><a href="{{ route('employee.leave.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
    <span>Leave Requests</span></a></li>
<li class="nav-item"><a href="{{ route('employee.salary.index') }}" class="nav-link active">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
    <span>My Salary</span></a></li>
<li class="nav-item"><a href="{{ route('employee.evaluations.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
    <span>My Evaluations</span></a></li>
@endsection

@section('content')
<div class="page-header">
    <h2>My Salary</h2>
    <p>View your salary slips</p>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
            Salary History
        </h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>Period</th>
                <th>Gross</th>
                <th>Deductions</th>
                <th>Net</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($salaries as $salary)
            <tr>
                <td>{{ \Carbon\Carbon::createFromDate($salary->year, $salary->month)->format('F Y') }}</td>
                <td>${{ number_format($salary->gross_salary, 2) }}</td>
                <td>${{ number_format($salary->deduction_cnss + $salary->deduction_absences, 2) }}</td>
                <td>${{ number_format($salary->net_salary, 2) }}</td>
                <td><a href="{{ route('employee.salary.show', $salary->id) }}" class="btn btn-primary" style="padding:6px 12px;font-size:0.8rem">View Slip</a></td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center">No salary records yet</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection