@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('role', 'Administrator')

@section('menu')
    <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link active">
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
        <h2>System Dashboard</h2>
        <p>Overview of your HR Management System</p>
    </div>

    @php $pendingRequests = \App\Models\PasswordResetRequest::where('status', 'pending')->get(); @endphp
    @if($pendingRequests->count() > 0)
    <div class="card" style="border: 2px solid var(--warning);">
        <div class="card-header">
            <h3 class="card-title" style="color: var(--warning);">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                Pending Password Reset Requests ({{ $pendingRequests->count() }})
            </h3>
        </div>
        @foreach($pendingRequests as $req)
        <div style="padding: 16px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid var(--border-color); margin-bottom: 12px;">
            <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 12px;">
                <div style="flex: 1; min-width: 0;">
                    <p style="color: var(--text-primary); font-weight: 600; margin-bottom: 4px;">{{ $req->name }}</p>
                    <p style="color: var(--text-secondary); font-size: 0.85rem;">{{ $req->email }}</p>
                    @if($req->message)
                    <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 6px; font-style: italic;">"{{ $req->message }}"</p>
                    @endif
                    <p style="color: var(--text-secondary); font-size: 0.75rem; margin-top: 6px;">{{ $req->created_at->diffForHumans() }}</p>
                </div>
                <a href="{{ route('employees.edit', $req->user->employee->id ?? 0) }}" class="btn btn-primary btn-sm" style="flex-shrink: 0;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    Reset Password
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
            </div>
            <div class="stat-info">
                <h3>{{ $totalUsers }}</h3>
                <p>System Users</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            </div>
            <div class="stat-info">
                <h3>{{ $totalEmployees }}</h3>
                <p>Employees</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h18v18H3z"></path></svg>
            </div>
            <div class="stat-info">
                <h3>{{ $totalDepartments }}</h3>
                <p>Departments</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4a2 2 0 0 0-1 1.73v11a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73z"></path></svg>
            </div>
            <div class="stat-info">
                <h3>{{ $totalPositions }}</h3>
                <p>Positions</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path></svg>
                Quick Actions
            </h3>
        </div>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <a href="{{ route('employees.create') }}" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Add Employee
            </a>
            <a href="{{ route('departments.index') }}" class="btn btn-secondary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M3 3h18v18H3z"></path></svg>
                Manage Departments
            </a>
            <a href="{{ route('backup.index') }}" class="btn btn-secondary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path></svg>
                Database Backup
            </a>
        </div>
    </div>
@endsection