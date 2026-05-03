@extends('layouts.app')
@section('title', 'Absences')
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
    <h2>Absences</h2>
    <p>Track employee absences</p>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Record Absence</h3>
    </div>
    <form action="{{ route('hr.absences.store') }}" method="POST">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label>Employee</label>
                <select name="employee_id" class="form-control" required>
                    <option value="">Select employee</option>
                    @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->matricule }} - {{ $emp->first_name }} {{ $emp->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date" class="form-control" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Type</label>
                <select name="type" class="form-control" required>
                    <option value="unauthorized">Unauthorized</option>
                    <option value="sick">Sick</option>
                    <option value="personal">Personal</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Deduction (Hours)</label>
                <input type="number" name="deduction_hours" class="form-control" value="8" min="0">
            </div>
        </div>
        <div class="form-group">
            <label>Reason</label>
            <textarea name="reason" class="form-control" rows="2" placeholder="Reason for absence"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Record Absence</button>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Absence Records</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Date</th>
                <th>Type</th>
                <th>Hours</th>
                <th>Reason</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absences as $absence)
            <tr>
                <td>{{ $absence->employee->first_name }} {{ $absence->employee->last_name }}</td>
                <td>{{ \Carbon\Carbon::parse($absence->date)->format('M d, Y') }}</td>
                <td>
                    @if($absence->type == 'unauthorized')
                    <span class="badge badge-error">{{ ucfirst($absence->type) }}</span>
                    @elseif($absence->type == 'sick')
                    <span class="badge badge-warning">{{ ucfirst($absence->type) }}</span>
                    @else
                    <span class="badge badge-success">{{ ucfirst($absence->type) }}</span>
                    @endif
                </td>
                <td>{{ $absence->deduction_hours }}h</td>
                <td>{{ $absence->reason ?? '-' }}</td>
                <td>
                    <form action="{{ route('hr.absences.destroy', $absence->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center">No absences recorded</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $absences->links() }}
</div>
@endsection