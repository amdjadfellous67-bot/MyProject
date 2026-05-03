@extends('layouts.app')
@section('title', 'My Evaluations')
@section('role', 'Employee')

@section('menu')
<li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
    <span>Dashboard</span></a></li>
<li class="nav-item"><a href="{{ route('employee.leave.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect></svg>
    <span>Leave Requests</span></a></li>
<li class="nav-item"><a href="{{ route('employee.salary.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
    <span>My Salary</span></a></li>
<li class="nav-item"><a href="{{ route('employee.evaluations.index') }}" class="nav-link active">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
    <span>My Evaluations</span></a></li>
@endsection

@section('content')
<div class="page-header">
    <h2>My Evaluations</h2>
    <p>View your performance evaluations by HR Manager</p>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Period</th>
                <th>Date</th>
                <th>Overall</th>
                <th>Technical</th>
                <th>Behavior</th>
                <th>Punctuality</th>
                <th>Objectives</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($evaluations as $eval)
            <tr>
                <td>{{ $eval->period }}</td>
                <td>{{ $eval->evaluation_date->format('Y-m-d') }}</td>
                <td>{{ ['Poor','Fair','Good','Very Good','Excellent'][$eval->overall_score - 1] ?? '-' }}</td>
                <td>{{ ['Poor','Fair','Good','Very Good','Excellent'][$eval->score_technical - 1] ?? '-' }}</td>
                <td>{{ ['Poor','Fair','Good','Very Good','Excellent'][$eval->score_behavior - 1] ?? '-' }}</td>
                <td>{{ ['Poor','Fair','Good','Very Good','Excellent'][$eval->score_punctuality - 1] ?? '-' }}</td>
                <td>{{ ['Poor','Fair','Good','Very Good','Excellent'][$eval->score_objectives - 1] ?? '-' }}</td>
                <td><button onclick="showDetails({{ $eval->id }})" class="btn btn-sm btn-primary">View Details</button></td>
            </tr>
            @endforeach
            @if($evaluations->isEmpty())
            <tr><td colspan="8" style="text-align:center">No evaluations yet</td></tr>
            @endif
        </tbody>
    </table>
    {{ $evaluations->links() }}
</div>

@foreach($evaluations as $eval)
<div class="card" id="details-{{ $eval->id }}" style="display:none;">
    <div class="card-header">
        <h3 class="card-title">Evaluation Details - {{ $eval->period }}</h3>
        <button onclick="hideDetails({{ $eval->id }})" class="btn btn-secondary">Close</button>
    </div>
    <div style="padding: 16px;">
        <div class="form-row">
            <div>
                <p><strong>Overall Rating:</strong> {{ ['Poor','Fair','Good','Very Good','Excellent'][$eval->overall_score - 1] ?? '-' }}</p>
                <p><strong>Technical Quality:</strong> {{ ['Poor','Fair','Good','Very Good','Excellent'][$eval->score_technical - 1] ?? '-' }}</p>
                <p><strong>Comment:</strong> {{ $eval->comment_technical ?: 'No comment' }}</p>
            </div>
            <div>
                <p><strong>Behavior/Teamwork:</strong> {{ ['Poor','Fair','Good','Very Good','Excellent'][$eval->score_behavior - 1] ?? '-' }}</p>
                <p><strong>Punctuality:</strong> {{ ['Poor','Fair','Good','Very Good','Excellent'][$eval->score_punctuality - 1] ?? '-' }}</p>
                <p><strong>Objectives/Initiative:</strong> {{ ['Poor','Fair','Good','Very Good','Excellent'][$eval->score_objectives - 1] ?? '-' }}</p>
            </div>
        </div>
        <p style="margin-top: 16px;"><strong>Evaluated by:</strong> {{ $eval->evaluator->name ?? 'HR Manager' }} {{ $eval->evaluator->surname ?? '' }}</p>
    </div>
</div>
@endforeach
@endsection

@section('scripts')
<script>
function showDetails(id) {
    document.getElementById('details-' + id).style.display = 'block';
    document.getElementById('details-' + id).scrollIntoView({ behavior: 'smooth' });
}
function hideDetails(id) {
    document.getElementById('details-' + id).style.display = 'none';
}
</script>
@endsection
