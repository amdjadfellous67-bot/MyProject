@extends('layouts.app')
@section('title', 'Performance Evaluations')
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
<li class="nav-item"><a href="{{ route('hr.evaluations.index') }}" class="nav-link active">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
    <span>Evaluations</span></a></li>
@endsection

@section('content')
<div class="page-header">
    <h2>Performance Evaluations</h2>
    <p>Evaluate department employees</p>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Evaluations</h3>
        <button onclick="showForm()" class="btn btn-primary">+ New Evaluation</button>
    </div>
    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Period</th>
                <th>Punctuality</th>
                <th>Quality</th>
                <th>Teamwork</th>
                <th>Initiative</th>
            </tr>
        </thead>
        <tbody>
            @forelse($evaluations as $eval)
            <tr>
                <td>{{ $eval->employee->name }} {{ $eval->employee->surname }}</td>
                <td>{{ $eval->period }}</td>
                <td>{{ ['Poor','Fair','Good','Very Good','Excellent'][$eval->score_punctuality - 1] ?? $eval->score_punctuality }}</td>
                <td>{{ ['Poor','Fair','Good','Very Good','Excellent'][$eval->score_technical - 1] ?? $eval->score_technical }}</td>
                <td>{{ ['Poor','Fair','Good','Very Good','Excellent'][$eval->score_behavior - 1] ?? $eval->score_behavior }}</td>
                <td>{{ ['Poor','Fair','Good','Very Good','Excellent'][$eval->score_objectives - 1] ?? $eval->score_objectives }}</td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center">No evaluations yet</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $evaluations->links() }}
</div>

<div class="card" id="create-form" style="display:none;">
    <div class="card-header">
        <h3 class="card-title">New Evaluation</h3>
        <button onclick="hideForm()" class="btn btn-secondary">Cancel</button>
    </div>
    <form action="{{ route('hr.evaluations.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Employee</label>
            <select name="employee_id" class="form-control" id="employee-select" required>
                <option value="">Select employee by name</option>
                @foreach($employees as $emp)
                <option value="{{ $emp->id }}" data-matricule="{{ $emp->matricule }}">{{ $emp->name }} {{ $emp->surname }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Employee Code</label>
            <input type="text" id="employee-code" class="form-control" readonly>
        </div>
        <div class="form-group">
            <label>Evaluation Period</label>
            <input type="month" name="period" class="form-control" required>
        </div>
        
        <h4 style="margin: 24px 0 16px; color: var(--accent);">Performance Indicators (1-5)</h4>
        
        <div class="form-row">
            <div class="form-group">
                <label>Overall Rating</label>
                <select name="rating" class="form-control" required>
                    <option value="">Select rating</option>
                    <option value="1">1 - Poor</option>
                    <option value="2">2 - Fair</option>
                    <option value="3">3 - Good</option>
                    <option value="4">4 - Very Good</option>
                    <option value="5">5 - Excellent</option>
                </select>
            </div>
            <div class="form-group">
                <label>Punctuality</label>
                <select name="punctuality" class="form-control" required>
                    <option value="">Select rating</option>
                    <option value="1">1 - Poor</option>
                    <option value="2">2 - Fair</option>
                    <option value="3">3 - Good</option>
                    <option value="4">4 - Very Good</option>
                    <option value="5">5 - Excellent</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Work Quality</label>
                <select name="work_quality" class="form-control" required>
                    <option value="">Select rating</option>
                    <option value="1">1 - Poor</option>
                    <option value="2">2 - Fair</option>
                    <option value="3">3 - Good</option>
                    <option value="4">4 - Very Good</option>
                    <option value="5">5 - Excellent</option>
                </select>
            </div>
            <div class="form-group">
                <label>Teamwork</label>
                <select name="teamwork" class="form-control" required>
                    <option value="">Select rating</option>
                    <option value="1">1 - Poor</option>
                    <option value="2">2 - Fair</option>
                    <option value="3">3 - Good</option>
                    <option value="4">4 - Very Good</option>
                    <option value="5">5 - Excellent</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label>Initiative</label>
            <select name="initiative" class="form-control" required>
                <option value="">Select rating</option>
                <option value="1">1 - Poor</option>
                <option value="2">2 - Fair</option>
                <option value="3">3 - Good</option>
                <option value="4">4 - Very Good</option>
                <option value="5">5 - Excellent</option>
            </select>
        </div>
        <div class="form-group">
            <label>Comments</label>
            <textarea name="comments" class="form-control" rows="4" placeholder="Additional comments..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Evaluation</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
function showForm() {
    document.getElementById('create-form').style.display = 'block';
    document.querySelector('#create-form').scrollIntoView({ behavior: 'smooth' });
}
function hideForm() {
    document.getElementById('create-form').style.display = 'none';
}
document.addEventListener('DOMContentLoaded', function() {
    var select = document.getElementById('employee-select');
    if (select) {
        select.addEventListener('change', function() {
            var selected = this.options[this.selectedIndex];
            var code = selected.getAttribute('data-matricule') || '';
            document.getElementById('employee-code').value = code;
        });
    }
});
</script>
@endsection