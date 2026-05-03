@extends('layouts.app')
@section('title', 'Edit Evaluation')
@section('role', 'Admin')

@section('menu')
<li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
    <span>Dashboard</span></a></li>
<li class="nav-item"><a href="{{ route('evaluations.index') }}" class="nav-link">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
    <span>Evaluations</span></a></li>
@endsection

@section('content')
<div class="page-header">
    <h2>Edit Evaluation</h2>
    <p>Update employee evaluation</p>
</div>

<div class="card">
    <form action="{{ route('evaluations.update', $evaluation->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Employee</label>
            <input type="text" class="form-control" value="{{ $evaluation->employee->first_name }} {{ $evaluation->employee->last_name }}" disabled>
        </div>
        
        <h4 style="margin: 24px 0 16px; color: var(--accent);">Performance Indicators (1-5)</h4>
        
        <div class="form-row">
            <div class="form-group">
                <label>Overall Rating</label>
                <select name="rating" class="form-control" required>
                    <option value="1" {{ $evaluation->rating == 1 ? 'selected' : '' }}>1 - Poor</option>
                    <option value="2" {{ $evaluation->rating == 2 ? 'selected' : '' }}>2 - Fair</option>
                    <option value="3" {{ $evaluation->rating == 3 ? 'selected' : '' }}>3 - Good</option>
                    <option value="4" {{ $evaluation->rating == 4 ? 'selected' : '' }}>4 - Very Good</option>
                    <option value="5" {{ $evaluation->rating == 5 ? 'selected' : '' }}>5 - Excellent</option>
                </select>
            </div>
            <div class="form-group">
                <label>Punctuality</label>
                <select name="punctuality" class="form-control" required>
                    <option value="1" {{ $evaluation->punctuality == 1 ? 'selected' : '' }}>1 - Poor</option>
                    <option value="2" {{ $evaluation->punctuality == 2 ? 'selected' : '' }}>2 - Fair</option>
                    <option value="3" {{ $evaluation->punctuality == 3 ? 'selected' : '' }}>3 - Good</option>
                    <option value="4" {{ $evaluation->punctuality == 4 ? 'selected' : '' }}>4 - Very Good</option>
                    <option value="5" {{ $evaluation->punctuality == 5 ? 'selected' : '' }}>5 - Excellent</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Work Quality</label>
                <select name="work_quality" class="form-control" required>
                    <option value="1" {{ $evaluation->work_quality == 1 ? 'selected' : '' }}>1 - Poor</option>
                    <option value="2" {{ $evaluation->work_quality == 2 ? 'selected' : '' }}>2 - Fair</option>
                    <option value="3" {{ $evaluation->work_quality == 3 ? 'selected' : '' }}>3 - Good</option>
                    <option value="4" {{ $evaluation->work_quality == 4 ? 'selected' : '' }}>4 - Very Good</option>
                    <option value="5" {{ $evaluation->work_quality == 5 ? 'selected' : '' }}>5 - Excellent</option>
                </select>
            </div>
            <div class="form-group">
                <label>Teamwork</label>
                <select name="teamwork" class="form-control" required>
                    <option value="1" {{ $evaluation->teamwork == 1 ? 'selected' : '' }}>1 - Poor</option>
                    employee->last_name - <option value="2" {{ $evaluation->teamwork == 2 ? 'selected' : '' }}>2 - Fair</option>
                    <option value="3" {{ $evaluation->teamwork == 3 ? 'selected' : '' }}>3 - Good</option>
                    <option value="4" {{ $evaluation->teamwork == 4 ? 'selected' : '' }}>4 - Very Good</option>
                    <option value="5" {{ $evaluation->teamwork == 5 ? 'selected' : '' }}>5 - Excellent</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label>Initiative</label>
            <select name="initiative" class="form-control" required>
                <option value="1" {{ $evaluation->initiative == 1 ? 'selected' : '' }}>1 - Poor</option>
                <option value="2" {{ $evaluation->initiative == 2 ? 'selected' : '' }}>2 - Fair</option>
                <option value="3" {{ $evaluation->initiative == 3 ? 'selected' : '' }}>3 - Good</option>
                <option value="4" {{ $evaluation->initiative == 4 ? 'selected' : '' }}>4 - Very Good</option>
                <option value="5" {{ $evaluation->initiative == 5 ? 'selected' : '' }}>5 - Excellent</option>
            </select>
        </div>
        <div class="form-group">
            <label>Comments</label>
            <textarea name="comments" class="form-control" rows="4">{{ $evaluation->comments }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Evaluation</button>
        <a href="{{ route('evaluations.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection