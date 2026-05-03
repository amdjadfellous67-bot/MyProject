@extends('layouts.app')

@section('title', 'Employee Details')
@section('role', 'Administrator')

@section('menu')
    <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('employees.index') }}" class="nav-link active">
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
        <h2>Employee Details</h2>
        <p>View and manage employee information</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $employee->name }} {{ $employee->surname }}</h3>
            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
            <div style="padding: 14px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid var(--border-color);">
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase;">Employee ID</label>
                <span style="font-size: 1rem; font-weight: 500;">{{ $employee->matricule }}</span>
            </div>
            <div style="padding: 14px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid var(--border-color);">
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase;">Email</label>
                <span style="font-size: 1rem; font-weight: 500;">{{ $employee->email }}</span>
            </div>
            <div style="padding: 14px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid var(--border-color);">
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase;">Phone</label>
                <span style="font-size: 1rem; font-weight: 500;">{{ $employee->telephone ?? '-' }}</span>
            </div>
            <div style="padding: 14px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid var(--border-color);">
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase;">Department</label>
                <span style="font-size: 1rem; font-weight: 500;">{{ $employee->department->name ?? '-' }}</span>
            </div>
            <div style="padding: 14px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid var(--border-color);">
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase;">Position</label>
                <span style="font-size: 1rem; font-weight: 500;">{{ $employee->position->title ?? '-' }}</span>
            </div>
            <div style="padding: 14px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid var(--border-color);">
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase;">Status</label>
                <span style="font-size: 1rem; font-weight: 500;">{{ $employee->status }}</span>
            </div>
            <div style="padding: 14px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid var(--border-color);">
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase;">Date of Hire</label>
                <span style="font-size: 1rem; font-weight: 500;">{{ $employee->date_of_hire ? $employee->date_of_hire->format('d/m/Y') : '-' }}</span>
            </div>
            <div style="padding: 14px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid var(--border-color);">
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase;">Base Salary</label>
                <span style="font-size: 1rem; font-weight: 500;">{{ number_format($employee->base_salary, 2) }} DA</span>
            </div>
            <div style="padding: 14px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid var(--border-color);">
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase;">Contract Type</label>
                <span style="font-size: 1rem; font-weight: 500;">{{ strtoupper($employee->contract_type ?? '-') }}</span>
            </div>
            <div style="padding: 14px; background: rgba(255,255,255,0.02); border-radius: 8px; border: 1px solid var(--border-color);">
                <label style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase;">Experience Level</label>
                <span style="font-size: 1rem; font-weight: 500;">{{ $employee->experience_level ?? '-' }}</span>
            </div>
        </div>
    </div>
@endsection