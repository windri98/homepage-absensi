@extends('layouts.app')

@section('title', 'Create Task - AttendanceHub')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('assets/css/tasks.css') }}?v={{ time() }}">
<style>
.form-container {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #333;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
}

.form-control.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.select2-container--default .select2-selection--multiple {
    border: 2px solid #e1e5e9;
    border-radius: 8px;
    min-height: 48px;
}

.btn-group {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

.priority-badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    margin-left: 0.5rem;
}

.priority-low { background: #d4edda; color: #155724; }
.priority-medium { background: #fff3cd; color: #856404; }
.priority-high { background: #f8d7da; color: #721c24; }
.priority-urgent { background: #721c24; color: white; }

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<div class="tasks-header">
    <div class="header-content">
        <div class="header-text">
            <h1>Create New Task</h1>
            <p>Add a new task for your team</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('tasks.index') }}" class="header-btn" title="Back to Tasks">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </div>
</div>

<div class="tasks-content">
    <div class="form-container">
        <form action="{{ route('tasks.store') }}" method="POST" id="taskForm">
            @csrf
            
            <div class="form-group">
                <label for="title">Task Title <span class="text-danger">*</span></label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       class="form-control @error('title') is-invalid @enderror" 
                       value="{{ old('title') }}" 
                       placeholder="Enter task title"
                       required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" 
                          name="description" 
                          class="form-control @error('description') is-invalid @enderror" 
                          rows="4" 
                          placeholder="Enter task description">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="type">Task Type <span class="text-danger">*</span></label>
                    <select id="type" 
                            name="type" 
                            class="form-control @error('type') is-invalid @enderror" 
                            required>
                        <option value="">Select task type</option>
                        <option value="individual" {{ old('type') == 'individual' ? 'selected' : '' }}>Individual</option>
                        <option value="group" {{ old('type') == 'group' ? 'selected' : '' }}>Group</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="priority">Priority <span class="text-danger">*</span></label>
                    <select id="priority" 
                            name="priority" 
                            class="form-control @error('priority') is-invalid @enderror" 
                            required>
                        <option value="">Select priority</option>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                    @error('priority')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="department_id">Department</label>
                    <select id="department_id" 
                            name="department_id" 
                            class="form-control @error('department_id') is-invalid @enderror">
                        <option value="">Select department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="due_date">Due Date</label>
                    <input type="datetime-local" 
                           id="due_date" 
                           name="due_date" 
                           class="form-control @error('due_date') is-invalid @enderror" 
                           value="{{ old('due_date') }}">
                    @error('due_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="estimated_hours">Estimated Hours</label>
                <input type="number" 
                       id="estimated_hours" 
                       name="estimated_hours" 
                       class="form-control @error('estimated_hours') is-invalid @enderror" 
                       value="{{ old('estimated_hours') }}" 
                       min="0" 
                       step="0.5" 
                       placeholder="e.g. 2.5">
                @error('estimated_hours')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="assigned_users">Assign to Users <span class="text-danger">*</span></label>
                <select id="assigned_users" 
                        name="assigned_users[]" 
                        class="form-control @error('assigned_users') is-invalid @enderror" 
                        multiple 
                        required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" 
                                {{ in_array($user->id, old('assigned_users', [])) ? 'selected' : '' }}>
                            {{ $user->name }} ({{ ucfirst($user->role) }})
                            @if($user->department)
                                - {{ $user->department->name }}
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('assigned_users')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple users</small>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Task
                </button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Priority preview
    const prioritySelect = document.getElementById('priority');
    prioritySelect.addEventListener('change', function() {
        const label = this.parentElement.querySelector('label');
        const existingBadge = label.querySelector('.priority-badge');
        if (existingBadge) {
            existingBadge.remove();
        }
        
        if (this.value) {
            const badge = document.createElement('span');
            badge.className = `priority-badge priority-${this.value}`;
            badge.textContent = this.value.toUpperCase();
            label.appendChild(badge);
        }
    });

    // Form validation
    const form = document.getElementById('taskForm');
    form.addEventListener('submit', function(e) {
        const assignedUsers = document.getElementById('assigned_users');
        if (assignedUsers.selectedOptions.length === 0) {
            e.preventDefault();
            alert('Please select at least one user to assign the task to.');
            assignedUsers.focus();
        }
    });

    // Set minimum date for due date
    const dueDateInput = document.getElementById('due_date');
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    dueDateInput.min = now.toISOString().slice(0, 16);
});
</script>
@endsection