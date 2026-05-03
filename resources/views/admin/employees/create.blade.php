@extends('layouts.app')

@section('title', 'Add Employee')
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
        <h2>Add Employee</h2>
        <p>Create a new employee record</p>
    </div>

    <div class="card">
        <form action="{{ route('employees.store') }}" method="POST">
            @csrf
            
            <div class="form-row">
                <div class="form-group">
                    <label>Employee ID (Auto-generated)</label>
                    <input type="text" class="form-control" value="Auto-generated on save" readonly>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required placeholder="employee@company.com">
                    @error('email')
                        <span style="color: var(--error); font-size: 0.75rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="name" class="form-control" required placeholder="John">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="surname" class="form-control" required placeholder="Doe">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="telephone" class="form-control" placeholder="0612345678">
                </div>
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Date of Hire</label>
                    <input type="date" name="date_of_hire" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label>Department</label>
                    <select name="department_id" class="form-control" required>
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Position</label>
                    <select name="position_id" class="form-control" required>
                        <option value="">Select Position</option>
                        @foreach($positions as $position)
                        <option value="{{ $position->id }}">{{ $position->title }} ({{ $position->departments->pluck('name')->implode(', ') }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Base Salary</label>
                    <input type="number" name="base_salary" class="form-control" step="0.01" placeholder="5000">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Contract Type</label>
                    <select name="contract_type" class="form-control">
                        <option value="cdi">CDI (Permanent)</option>
                        <option value="cdd">CDD (Contract)</option>
                        <option value="internship">Internship</option>
                        <option value="part-time">Part Time</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Experience Level</label>
                    <select name="experience_level" class="form-control">
                        <option value="">Select Level</option>
                        <option value="Junior">Junior</option>
                        <option value="Mid">Mid</option>
                        <option value="Senior">Senior</option>
                        <option value="Lead">Lead</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Password (for login)</label>
                    <input type="password" name="password" class="form-control" required minlength="6" placeholder="Min 6 characters">
                    @error('password')
                        <span style="color: var(--error); font-size: 0.75rem;">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="user_role" class="form-control">
                        <option value="employee">Employee</option>
                        <option value="hr_manager">HR Manager</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; gap: 16px; margin-top: 24px;">
                <button type="submit" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Save Employee
                </button>
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection