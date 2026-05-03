@extends('layouts.app')

@section('title', 'Positions')
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
        <a href="{{ route('departments.index') }}" class="nav-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="18" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
            <span>Departments</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('positions.index') }}" class="nav-link active">
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
        <h2>Positions</h2>
        <p>Manage job positions</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Positions</h3>
            <button onclick="document.getElementById('addPosModal').style.display='flex'" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Add Position
            </button>
        </div>
        
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Level</th>
                        <th>Department</th>
                        <th>Base Salary</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($positions as $position)
                    <tr>
                        <td>{{ $position->id }}</td>
                        <td>{{ $position->title }}</td>
                        <td>{{ $position->level ?? '-' }}</td>
                        <td>{{ $position->departments->pluck('name')->implode(', ') ?: '-' }}</td>
                        <td>{{ number_format($position->base_salary, 2) }} DA</td>
                        <td>
                            <div style="display: flex; gap: 4px; flex-wrap: wrap;">
                                <a href="{{ route('positions.edit', $position->id) }}" class="btn btn-secondary btn-xs">Edit</a>
                                <form action="{{ route('positions.destroy', $position->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this position?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-secondary);">No positions found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Position Modal -->
    <div id="addPosModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: var(--card-bg); padding: 30px; border-radius: 12px; max-width: 500px; width: 90%; border: 1px solid var(--border-color);">
            <h3 style="margin-bottom: 20px; color: var(--text-primary);">Add Position</h3>
            <form action="{{ route('positions.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Position Title</label>
                    <input type="text" name="title" class="form-control" required placeholder="Software Engineer">
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <select name="level" class="form-control">
                        <option value="Junior">Junior</option>
                        <option value="Mid">Mid</option>
                        <option value="Senior">Senior</option>
                        <option value="Lead">Lead</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Departments</label>
                    <select name="department_ids[]" class="form-control" multiple required>
                        @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Base Salary (DA)</label>
                    <input type="number" name="base_salary" class="form-control" step="0.01" placeholder="5000">
                </div>
                <div style="display: flex; gap: 16px;">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" onclick="document.getElementById('addPosModal').style.display='none'" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection