@extends('layouts.app')

@section('title', 'Employee Dashboard')
@section('role', 'Employee')

@section('menu')
<li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link active">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
    <span>Dashboard</span></a></li>
<li class="nav-item"><a href="{{ route('employee.leave.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
    <span>Leave Requests</span></a></li>
<li class="nav-item"><a href="{{ route('employee.salary.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
    <span>My Salary</span></a></li>
<li class="nav-item"><a href="{{ route('employee.evaluations.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
    <span>My Evaluations</span></a></li>
@endsection

@section('content')
    <div class="page-header">
        <h2>My Profile</h2>
        <p>View and manage your personal information</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                Employee Information
            </h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
            <div style="padding: 16px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid var(--border-color);">
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase;">Employee ID</label>
                <span style="font-size: 1rem; font-weight: 500;">{{ $profile->matricule }}</span>
            </div>
            <div style="padding: 16px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid var(--border-color);">
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase;">Name</label>
                <span style="font-size: 1rem; font-weight: 500;">{{ $profile->name }} {{ $profile->surname }}</span>
            </div>
            <div style="padding: 16px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid var(--border-color);">
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase;">Email</label>
                <span style="font-size: 1rem; font-weight: 500;">{{ $profile->email }}</span>
            </div>
            <div style="padding: 16px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid var(--border-color);">
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase;">Department</label>
                <span style="font-size: 1rem; font-weight: 500;">{{ $profile->department->name ?? '-' }}</span>
            </div>
            <div style="padding: 16px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid var(--border-color);">
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase;">Position</label>
                <span style="font-size: 1rem; font-weight: 500;">{{ $profile->position->title ?? '-' }}</span>
            </div>
            <div style="padding: 16px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid var(--border-color);">
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase;">Date of Hire</label>
                <span style="font-size: 1rem; font-weight: 500;">{{ $profile->date_of_hire ? $profile->date_of_hire->format('d/m/Y') : '-' }}</span>
            </div>
        </div>
    </div>
@endsection