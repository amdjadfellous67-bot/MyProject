@extends('layouts.app')

@section('title', 'Edit Employee')
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
        <h2>Edit Employee</h2>
        <p>Update employee information</p>
    </div>

    <div class="card">
        <form action="{{ route('employees.update', $employee->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <div class="form-group">
                    <label>Employee ID</label>
                    <input type="text" class="form-control" value="{{ $employee->matricule }}" readonly>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $employee->email }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $employee->name }}" required>
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="surname" class="form-control" value="{{ $employee->surname }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="telephone" class="form-control" value="{{ $employee->telephone }}">
                </div>
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control" value="{{ $employee->date_of_birth }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Date of Hire</label>
                    <input type="date" name="date_of_hire" class="form-control" value="{{ $employee->date_of_hire }}">
                </div>
                <div class="form-group">
                    <label>Department</label>
                    <select name="department_id" class="form-control">
                        @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ $employee->department_id == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Position</label>
                    <select name="position_id" class="form-control">
                        @foreach($positions as $pos)
                        <option value="{{ $pos->id }}" {{ $employee->position_id == $pos->id ? 'selected' : '' }}>{{ $pos->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Base Salary</label>
                    <input type="number" name="base_salary" class="form-control" step="0.01" value="{{ $employee->base_salary }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Contract Type</label>
                    <select name="contract_type" class="form-control">
                        <option value="cdi" {{ $employee->contract_type == 'cdi' ? 'selected' : '' }}>CDI (Permanent)</option>
                        <option value="cdd" {{ $employee->contract_type == 'cdd' ? 'selected' : '' }}>CDD (Contract)</option>
                        <option value="internship" {{ $employee->contract_type == 'internship' ? 'selected' : '' }}>Internship</option>
                        <option value="part-time" {{ $employee->contract_type == 'part-time' ? 'selected' : '' }}>Part Time</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Experience Level</label>
                    <select name="experience_level" class="form-control">
                        <option value="">Select Level</option>
                        <option value="Junior" {{ $employee->experience_level == 'Junior' ? 'selected' : '' }}>Junior</option>
                        <option value="Mid" {{ $employee->experience_level == 'Mid' ? 'selected' : '' }}>Mid</option>
                        <option value="Senior" {{ $employee->experience_level == 'Senior' ? 'selected' : '' }}>Senior</option>
                        <option value="Lead" {{ $employee->experience_level == 'Lead' ? 'selected' : '' }}>Lead</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $employee->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $employee->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="form-group"></div>
            </div>

            <div style="display: flex; gap: 16px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary">Update Employee</button>
                <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    @if($employee->user)
    <div class="card" style="margin-top: 24px; border: 2px solid var(--accent);">
        <div class="card-header">
            <h3 class="card-title">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                Reset Password
            </h3>
        </div>
        <form action="{{ route('password-reset.reset') }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{ $employee->user->id ?? '' }}">
            <div class="form-row">
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter new password" minlength="6">
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password" minlength="6">
                </div>
            </div>
            @if(session('success'))
            <div style="padding: 12px 16px; background: rgba(16, 185, 129, 0.15); border: 1px solid var(--success); border-radius: var(--radius-sm); color: var(--success); margin-bottom: 16px;">{{ session('success') }}</div>
            @endif
            @error('password')
            <div style="padding: 12px 16px; background: rgba(220, 38, 38, 0.15); border: 1px solid var(--error); border-radius: var(--radius-sm); color: var(--error); margin-bottom: 16px;">{{ $message }}</div>
            @enderror
            <button type="submit" class="btn btn-primary" style="max-width: 250px;">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
                Reset Password
            </button>
        </form>
    </div>
    @endif
@endsection