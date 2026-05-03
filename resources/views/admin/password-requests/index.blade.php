@extends('layouts.app')

@section('title', 'Password Reset Requests')
@section('role', 'Administrator')

@section('menu')
    <li class="nav-item">
        <a href="{{ route('dashboard') }}" class="nav-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
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
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h18v18H3z"></path></svg>
            <span>Departments</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('positions.index') }}" class="nav-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4a2 2 0 0 0-1 1.73v11a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73z"></path></svg>
            <span>Positions</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('password-requests.index') }}" class="nav-link active">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
            <span>Password Requests</span>
            @if($requests->where('status', 'pending')->count() > 0)
            <span style="background: var(--error); color: white; border-radius: 50%; padding: 2px 8px; font-size: 0.75rem; margin-left: auto;">{{ $requests->where('status', 'pending')->count() }}</span>
            @endif
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
        <h2>Password Reset Requests</h2>
        <p>Manage employee password reset requests</p>
    </div>

    <div class="card">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Email</th>
                        <th>Employee ID</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                    <tr>
                        <td style="color: var(--text-primary); font-weight: 500;">{{ $request->name }}</td>
                        <td>{{ $request->email }}</td>
                        <td>{{ $request->matricule ?: '-' }}</td>
                        <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $request->message }}">{{ $request->message ?: '-' }}</td>
                        <td>{{ $request->created_at->format('M d, Y H:i') }}</td>
                        <td>
                            @if($request->status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                            @else
                            <span class="badge badge-success">Resolved</span>
                            @endif
                        </td>
                        <td>
                            @if($request->status == 'pending' && $request->user_id)
                            <div style="display: flex; gap: 4px; flex-wrap: wrap;">
                                <a href="{{ route('employees.edit', $request->user->employee->id ?? 0) }}" class="btn btn-primary btn-xs">Reset</a>
                                <form action="{{ route('password-requests.resolve', $request->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-secondary btn-xs">Resolve</button>
                                </form>
                            </div>
                            @elseif($request->status == 'pending')
                            <span style="color: var(--text-secondary); font-size: 0.75rem;">User not found</span>
                            @else
                            <span style="color: var(--text-secondary); font-size: 0.75rem;">Completed</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align:center; padding: 40px; color: var(--text-secondary);">No password reset requests</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($requests->hasPages())
        <div style="margin-top: 20px; display: flex; justify-content: center;">
            {{ $requests->links() }}
        </div>
        @endif
    </div>
@endsection
