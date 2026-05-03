@extends('layouts.app')
@section('title', 'Payslip')
@section('role', 'Admin')

@section('menu')
<li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
    <span>Dashboard</span></a></li>
<li class="nav-item"><a href="{{ route('employees.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
    <span>Employees</span></a></li>
<li class="nav-item"><a href="{{ route('departments.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h18v18H3z"></path></svg>
    <span>Departments</span></a></li>
<li class="nav-item"><a href="{{ route('positions.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
    <span>Positions</span></a></li>
<li class="nav-item"><a href="{{ route('backup.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
    <span>Backup</span></a></li>
@endsection

@section('content')
<div class="page-header">
    <h2>Payslip - {{ \Carbon\Carbon::createFromDate($salary->year, $salary->month)->format('F Y') }}</h2>
    <button onclick="window.print()" class="btn btn-primary" style="margin-left: 16px;">Print PDF</button>
</div>

<div class="card" id="payslip" style="max-width: 800px; margin: 0 auto;">
    <div style="text-align: center; border-bottom: 2px solid var(--accent); padding-bottom: 20px; margin-bottom: 20px;">
        <h1 style="color: var(--accent); margin-bottom: 8px;">PAYSLIP</h1>
        <p>Period: {{ \Carbon\Carbon::createFromDate($salary->year, $salary->month)->format('F Y') }}</p>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 30px;">
        <div>
            <h4 style="color: var(--accent); margin-bottom: 12px;">Employee Details</h4>
            <p><strong>ID:</strong> {{ $salary->employee->matricule }}</p>
            <p><strong>Name:</strong> {{ $salary->employee->first_name }} {{ $salary->employee->last_name }}</p>
            <p><strong>Department:</strong> {{ $salary->employee->department->name ?? 'N/A' }}</p>
            <p><strong>Position:</strong> {{ $salary->employee->position->title ?? 'N/A' }}</p>
        </div>
        <div>
            <h4 style="color: var(--accent); margin-bottom: 12px;">Payment Details</h4>
            <p><strong>Payment Date:</strong> {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
            <p><strong>Bank:</strong> BNA</p>
            <p><strong>Account:</strong> ****1234</p>
        </div>
    </div>
    
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: rgba(212, 175, 55, 0.1);">
                <th style="padding: 12px; text-align: left;">Earnings</th>
                <th style="padding: 12px; text-align: right;">Amount (DA)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 12px;">Base Salary</td>
                <td style="padding: 12px; text-align: right;">{{ number_format($salary->gross_salary, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 12px;">Seniority Bonus</td>
                <td style="padding: 12px; text-align: right;">{{ number_format($salary->bonus_seniority, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 12px;">Performance Bonus</td>
                <td style="padding: 12px; text-align: right;">{{ number_format($salary->bonus_performance, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 12px;">Attendance Bonus</td>
                <td style="padding: 12px; text-align: right;">{{ number_format($salary->bonus_attendance, 2) }}</td>
            </tr>
            <tr style="font-weight: 700; border-top: 2px solid var(--accent);">
                <td style="padding: 12px;">Gross Salary</td>
                <td style="padding: 12px; text-align: right;">{{ number_format($salary->gross_salary + $salary->bonus_seniority + $salary->bonus_performance + $salary->bonus_attendance, 2) }}</td>
            </tr>
        </tbody>
    </table>
    
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background: rgba(220, 38, 38, 0.1);">
                <th style="padding: 12px; text-align: left;">Deductions</th>
                <th style="padding: 12px; text-align: right;">Amount (DA)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 12px;">CNSS (Social Security)</td>
                <td style="padding: 12px; text-align: right;">{{ number_format($salary->deduction_cnss, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 12px;">Advance Deductions</td>
                <td style="padding: 12px; text-align: right;">{{ number_format($salary->deduction_advances, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 12px;">Absence Deductions</td>
                <td style="padding: 12px; text-align: right;">{{ number_format($salary->deduction_absences, 2) }}</td>
            </tr>
            <tr style="font-weight: 700; border-top: 2px solid var(--error);">
                <td style="padding: 12px;">Total Deductions</td>
                <td style="padding: 12px; text-align: right;">{{ number_format($salary->deduction_cnss + $salary->deduction_advances + $salary->deduction_absences, 2) }}</td>
            </tr>
        </tbody>
    </table>
    
    <div style="background: var(--accent); color: var(--primary-dark); padding: 20px; border-radius: 8px; margin-top: 20px; text-align: center;">
        <h3 style="margin-bottom: 8px;">NET SALARY</h3>
        <h1 style="font-size: 2rem;">{{ number_format($salary->net_salary, 2) }} DA</h1>
    </div>
    
    <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between;">
        <div>
            <p style="color: var(--text-secondary); font-size: 0.8rem;">Employee Signature</p>
            <div style="width: 150px; height: 50px; border-bottom: 1px solid var(--border-color);"></div>
        </div>
        <div>
            <p style="color: var(--text-secondary); font-size: 0.8rem;">HR Manager Signature</p>
            <div style="width: 150px; height: 50px; border-bottom: 1px solid var(--border-color);"></div>
        </div>
    </div>
</div>

<style>
@media print {
    body { background: white; }
    .sidebar, .theme-toggle, .toast, .page-header button { display: none !important; }
    .main-content { margin: 0; padding: 20px; }
    .card { box-shadow: none; border: 1px solid #ccc; }
}
</style>
@endsection