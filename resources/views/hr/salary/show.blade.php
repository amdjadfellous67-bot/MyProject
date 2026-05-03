@extends('layouts.app')
@section('title', 'Payslip')
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
    <span>Leave Requests</span></a></li>
<li class="nav-item"><a href="{{ route('hr.salary.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
    <span>Payroll</span></a></li>
<li class="nav-item"><a href="{{ route('hr.evaluations.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
    <span>Evaluations</span></a></li>
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
            <p><strong>Name:</strong> {{ $salary->employee->name }} {{ $salary->employee->surname }}</p>
            <p><strong>Department:</strong> {{ $salary->employee->department->name ?? 'N/A' }}</p>
        </div>
        <div>
            <h4 style="color: var(--accent); margin-bottom: 12px;">Payment Details</h4>
            <p><strong>Payment Date:</strong> {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
            <p><strong>Bank:</strong> BNA</p>
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
                <td style="padding: 12px;">CNSS</td>
                <td style="padding: 12px; text-align: right;">{{ number_format($salary->deduction_cnss, 2) }}</td>
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