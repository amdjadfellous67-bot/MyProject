@extends('layouts.app')

@section('title', 'Payroll')
@section('role', 'Administrator')

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
        <h2>Payroll</h2>
        <p>Process and manage employee salaries</p>
    </div>

    <!-- Process Payroll Form -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Process Payroll</h3>
        </div>
        <form action="{{ route('salary.process') }}" method="POST" style="display: flex; gap: 16px; align-items: flex-end;">
            @csrf
            <div class="form-group" style="margin-bottom: 0;">
                <label>Month</label>
                <select name="month" class="form-control">
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label>Year</label>
                <select name="year" class="form-control">
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026" selected>2026</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Process Payroll</button>
        </form>
    </div>

    <!-- Salary Records -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Salary Records</h3>
        </div>
        
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Month</th>
                        <th>Gross Salary</th>
                        <th>Bonuses</th>
                        <th>Deductions</th>
                        <th>Net Salary</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salaries as $salary)
                    <tr>
                        <td>{{ $salary->employee->name ?? 'N/A' }} {{ $salary->employee->surname ?? '' }}</td>
                        <td>{{ $salary->month }}/{{ $salary->year }}</td>
                        <td>{{ number_format($salary->gross_salary, 2) }} DA</td>
                        <td style="color: var(--success);">+{{ number_format($salary->bonus_seniority + $salary->bonus_performance + $salary->bonus_attendance, 2) }} DA</td>
                        <td style="color: var(--error);">-{{ number_format($salary->deduction_cnss + $salary->deduction_advances + $salary->deduction_absences, 2) }} DA</td>
                        <td style="color: var(--accent); font-weight: 700;">{{ number_format($salary->net_salary, 2) }} DA</td>
                        <td>
                            <a href="{{ route('salary.show', $salary->id) }}" class="btn btn-secondary btn-sm">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-secondary);">No salary records found. Process payroll first.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div style="margin-top: 20px;">
            {{ $salaries->links() }}
        </div>
    </div>
@endsection