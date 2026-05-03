@extends('layouts.app')

@section('title', 'Departments')
@section('role', 'Administrator')

@section('menu')
    <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link">
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
        <a href="{{ route('departments.index') }}" class="nav-link active">
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
        <h2>Departments</h2>
        <p>Manage organization departments</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Departments</h3>
            <button onclick="document.getElementById('addDeptModal').style.display='flex'" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Add Department
            </button>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px;">
            @forelse($departments as $department)
            <div style="padding: 16px; background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px solid var(--border-color);">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div style="flex: 1; min-width: 0;">
                        <h4 style="color: var(--accent); margin-bottom: 6px; font-size: 0.95rem;">{{ $department->name }}</h4>
                        <p style="color: var(--text-secondary); font-size: 0.8rem;">{{ $department->description ?? 'No description' }}</p>
                        <p style="color: var(--text-secondary); font-size: 0.8rem; margin-top: 6px;">
                            <strong>{{ $department->employees_count ?? 0 }}</strong> employees
                        </p>
                    </div>
                    <div style="display: flex; gap: 4px; flex-shrink: 0; margin-left: 8px;">
                        <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-secondary btn-xs">Edit</a>
                        <form action="{{ route('departments.destroy', $department->id) }}" method="POST" onsubmit="return confirm('Delete this department?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <p style="color: var(--text-secondary);">No departments found</p>
            @endforelse
        </div>
    </div>

    <!-- Add Department Modal -->
    <div id="addDeptModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: var(--card-bg); padding: 30px; border-radius: 12px; max-width: 500px; width: 90%; border: 1px solid var(--border-color);">
            <h3 style="margin-bottom: 20px; color: var(--text-primary);">Add Department</h3>
            <form action="{{ route('departments.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Department Name</label>
                    <input type="text" name="name" class="form-control" required placeholder="Engineering">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Department description..."></textarea>
                </div>
                <div style="display: flex; gap: 16px;">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" onclick="document.getElementById('addDeptModal').style.display='none'" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection