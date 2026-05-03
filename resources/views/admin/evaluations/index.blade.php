@extends('layouts.app')
@section('title', 'Performance Evaluations')
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
    <h2>Performance Evaluations</h2>
    <p>Review and manage employee performance</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
        </div>
        <div class="stat-info">
            <h3>{{ $evaluations->total() }}</h3>
            <p>Total Evaluations</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        </div>
        <div class="stat-info">
            <h3>{{ number_format($evaluations->avg('rating'), 1) }}</h3>
            <p>Average Rating</p>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Evaluations</h3>
        <a href="{{ route('evaluations.create') }}" class="btn btn-primary">+ New Evaluation</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Period</th>
                <th>Rating</th>
                <th>Punctuality</th>
                <th>Quality</th>
                <th>Teamwork</th>
                <th>Initiative</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($evaluations as $eval)
            <tr>
                <td>{{ $eval->employee->first_name }} {{ $eval->employee->last_name }}</td>
                <td>{{ $eval->period }}</td>
                <td><span class="badge {{ $eval->rating >= 4 ? 'badge-success' : ($eval->rating >= 3 ? 'badge-warning' : 'badge-error') }}">{{ $eval->rating }}/5</span></td>
                <td>{{ $eval->punctuality }}/5</td>
                <td>{{ $eval->work_quality }}/5</td>
                <td>{{ $eval->teamwork }}/5</td>
                <td>{{ $eval->initiative }}/5</td>
                <td>
                    <a href="{{ route('evaluations.edit', $eval->id) }}" class="btn btn-secondary" style="padding:6px 12px;font-size:0.8rem">Edit</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center">No evaluations yet</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $evaluations->links() }}
</div>
@endsection