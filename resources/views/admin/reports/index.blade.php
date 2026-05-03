@extends('layouts.app')
@section('title', 'HR Reports')
@section('role', 'Admin')

@section('menu')
<li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
    <span>Dashboard</span></a></li>
<li class="nav-item"><a href="{{ route('employees.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
    <span>Employees</span></a></li>
<li class="nav-item"><a href="{{ route('departments.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
    <span>Departments</span></a></li>
<li class="nav-item"><a href="{{ route('positions.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4a2 2 0 0 0-1 1.73v11a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73z"></path></svg>
    <span>Positions</span></a></li>
<li class="nav-item"><a href="{{ route('backup.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path></svg>
    <span>Backup</span></a></li>
@endsection

@section('content')
<div class="page-header">
    <h2>HR Reports</h2>
    <p>Monthly statistics and analytics</p>
</div>

<div class="card" style="margin-bottom: 24px;">
    <form method="GET" style="display: flex; gap: 16px; align-items: flex-end;">
        <div class="form-group" style="margin-bottom: 0;">
            <label>Month</label>
            <select name="month" class="form-control">
                @foreach(range(1, 12) as $m)
                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ $month == $m ? 'selected' : '' }}>
                    {{ Carbon\Carbon::createFromDate(2026, $m)->format('F') }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label>Year</label>
            <select name="year" class="form-control">
                <option value="2024" {{ $year == 2024 ? 'selected' : '' }}>2024</option>
                <option value="2025" {{ $year == 2025 ? 'selected' : '' }}>2025</option>
                <option value="2026" {{ $year == 2026 ? 'selected' : '' }}>2026</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="{{ route('reports.export', ['month' => $month, 'year' => $year, 'format' => 'csv']) }}" class="btn btn-secondary">Export CSV</a>
        <a href="{{ route('reports.export', ['month' => $month, 'year' => $year, 'format' => 'pdf']) }}" class="btn btn-secondary" onclick="window.print()">Export PDF</a>
    </form>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
        </div>
        <div class="stat-info">
            <h3>{{ $totalEmployees }}</h3>
            <p>Total Employees</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        </div>
        <div class="stat-info">
            <h3>{{ $activeEmployees }}</h3>
            <p>Active Employees</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
        </div>
        <div class="stat-info">
            <h3>{{ number_format($salaryStats->total_gross, 0) }} DA</h3>
            <p>Total Gross Salary</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        </div>
        <div class="stat-info">
            <h3>{{ number_format($avgEvaluation, 1) }}</h3>
            <p>Avg Performance</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Leave Status</h3>
    </div>
    <table>
        <tr>
            <td style="color: var(--warning); font-weight: 600;">Pending</td>
            <td>{{ $leaveStats['pending'] }}</td>
        </tr>
        <tr>
            <td style="color: var(--success); font-weight: 600;">Approved</td>
            <td>{{ $leaveStats['approved'] }}</td>
        </tr>
        <tr>
            <td style="color: var(--error); font-weight: 600;">Rejected</td>
            <td>{{ $leaveStats['rejected'] }}</td>
        </tr>
    </table>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Departments</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>Department</th>
                <th>Employees</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $dept)
            <tr>
                <td>{{ $dept->name }}</td>
                <td>{{ $dept->employees_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection