@extends('layouts.app')
@section('title', 'Payroll')
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
    <h2>Payroll</h2>
    <p>Process department salaries</p>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Process Payroll</h3>
        <div style="display: flex; gap: 10px; align-items: center;">
            <select name="month" id="payroll-month" class="form-control" style="width: auto;">
                @for($m=1; $m<=12; $m++)
                <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ $m == date('n') ? 'selected' : '' }}>{{ \Carbon\Carbon::createFromDate(2026, $m)->format('F') }}</option>
                @endfor
            </select>
            <select name="year" id="payroll-year" class="form-control" style="width: auto;">
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026" selected>2026</option>
            </select>
        </div>
    </div>
    <form id="payroll-form" action="{{ route('hr.salary.process') }}" method="POST" style="display:none">
        @csrf
        <input type="hidden" name="month" id="hidden-month">
        <input type="hidden" name="year" id="hidden-year">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Base Salary</th>
                        <th>Bonus Seniority</th>
                        <th>Bonus Performance</th>
                        <th>Bonus Attendance</th>
                        <th>Deduction Advances</th>
                        <th>Deduction Absences</th>
                        <th>Net Salary</th>
                    </tr>
                </thead>
                <tbody id="payroll-body">
                </tbody>
            </table>
        </div>
        <div style="margin-top: 20px; display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary">Process Payroll</button>
            <a href="{{ route('hr.salary.print', ['month' => date('m'), 'year' => date('Y')]) }}" target="_blank" class="btn btn-secondary">Print All Payslips</a>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Salary Records</h3>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Period</th>
                    <th>Gross</th>
                    <th>Bonuses</th>
                    <th>Deductions</th>
                    <th>Net</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salaries as $salary)
                <tr>
                    <td>{{ $salary->employee->name }} {{ $salary->employee->surname }}</td>
                    <td>{{ $salary->month }}/{{ $salary->year }}</td>
                    <td>{{ number_format($salary->gross_salary, 2) }} DA</td>
                    <td style="color: var(--success);">+{{ number_format($salary->bonus_seniority + $salary->bonus_performance + $salary->bonus_attendance, 2) }} DA</td>
                    <td style="color: var(--error);">-{{ number_format($salary->deduction_cnss + $salary->deduction_advances + $salary->deduction_absences, 2) }} DA</td>
                    <td style="color: var(--accent); font-weight: 700;">{{ number_format($salary->net_salary, 2) }} DA</td>
                    <td><a href="{{ route('hr.salary.show', $salary->id) }}" class="btn btn-secondary btn-sm">View Slip</a></td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center">No salary records</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top: 20px;">
        {{ $salaries->links() }}
    </div>
</div>

<style>
.payroll-input {
    width: 100px;
    padding: 6px 8px;
    background: var(--input-bg);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-sm);
    color: var(--input-text);
    font-size: 0.85rem;
    text-align: right;
}
.payroll-input:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
}
.net-cell {
    color: var(--accent);
    font-weight: 700;
    text-align: right;
    padding-right: 16px;
}
</style>

<script>
function loadPayrollForm() {
    const month = document.getElementById('payroll-month').value;
    const year = document.getElementById('payroll-year').value;

    document.getElementById('hidden-month').value = month;
    document.getElementById('hidden-year').value = year;

    fetch(`{{ url('/hr/salary/form') }}?month=${month}&year=${year}`)
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('payroll-body');
            tbody.innerHTML = '';
            data.employees.forEach(emp => {
                const cnss = (emp.base_salary * 0.15).toFixed(2);
                const netInputId = `net-${emp.id}`;
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${emp.name} ${emp.surname}</td>
                    <td>${Number(emp.base_salary).toLocaleString('en', {minimumFractionDigits: 2})} DA</td>
                    <td><input type="number" name="bonus_seniority_${emp.id}" class="payroll-input bonus" data-emp="${emp.id}" value="0" min="0" step="0.01"></td>
                    <td><input type="number" name="bonus_performance_${emp.id}" class="payroll-input bonus" data-emp="${emp.id}" value="0" min="0" step="0.01"></td>
                    <td><input type="number" name="bonus_attendance_${emp.id}" class="payroll-input bonus" data-emp="${emp.id}" value="0" min="0" step="0.01"></td>
                    <td><input type="number" name="deduction_advances_${emp.id}" class="payroll-input deduction" data-emp="${emp.id}" value="0" min="0" step="0.01"></td>
                    <td><input type="number" name="deduction_absences_${emp.id}" class="payroll-input deduction" data-emp="${emp.id}" value="0" min="0" step="0.01"></td>
                    <td class="net-cell" id="${netInputId}">${(emp.base_salary - cnss).toLocaleString('en', {minimumFractionDigits: 2})} DA</td>
                    <input type="hidden" name="employees[]" value="${emp.id}">
                `;
                tbody.appendChild(tr);
            });

            document.querySelectorAll('.bonus, .deduction').forEach(input => {
                input.addEventListener('input', function() {
                    const empId = this.dataset.emp;
                    updateNet(empId);
                });
            });

            document.getElementById('payroll-form').style.display = 'block';
        });
}

function updateNet(empId) {
    const bonuses = document.querySelectorAll(`.bonus[data-emp="${empId}"]`);
    const deductions = document.querySelectorAll(`.deduction[data-emp="${empId}"]`);
    const row = bonuses[0].closest('tr');
    const baseSalary = parseFloat(row.cells[1].textContent.replace(/[^0-9.]/g, '')) || 0;
    const cnss = baseSalary * 0.15;

    let totalBonus = 0, totalDeduction = 0;
    bonuses.forEach(b => totalBonus += parseFloat(b.value) || 0);
    deductions.forEach(d => totalDeduction += parseFloat(d.value) || 0);

    const net = baseSalary - cnss + totalBonus - totalDeduction;
    document.getElementById(`net-${empId}`).textContent = net.toLocaleString('en', {minimumFractionDigits: 2}) + ' DA';
}

window.addEventListener('DOMContentLoaded', function() {
    loadPayrollForm();
    document.getElementById('payroll-month').addEventListener('change', loadPayrollForm);
    document.getElementById('payroll-year').addEventListener('change', loadPayrollForm);
});
</script>
@endsection
