@extends('layouts.app')

@section('title', 'Edit Task - AttendanceHub')

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

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-danger:hover {
    background: #c82333;
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

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    margin-left: 0.5rem;
}

.status-pending { background: #ffeaa7; color: #2d3436; }
.status-in_progress { background: #74b9ff; color: white; }
.status-completed { background: #00b894; color: white; }
.status-cancelled { background: #636e72; color: white; }

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.task-info {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    border-left: 4px solid #007bff;
}

.task-info h4 {
    margin: 0 0 0.5rem 0;
    color: #007bff;
}

.task-info p {
    margin: 0;
    color: #6c757d;
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .btn-group {
        flex-direction: column;
    }
}
</style>
@endsection

@section('content')
<div class="tasks-header">
    <div class="header-content">
        <div class="header-text">
            <h1>Edit Task</h1>
            <p>Update task details and assignments</p>
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
        <div class="task-info">
            <h4>Task Information</h4>
            <p>Created by {{ $task->creator->name }} on {{ $task->created_at->format('M j, Y \a\t g:i A') }}</p>
        </div>

        <form action="{{ route('tasks.update', $task) }}" method="POST" id="taskForm">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="title">Task Title <span class="text-danger">*</span></label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       class="form-control @error('title') is-invalid @enderror" 
                       value="{{ old('title', $task->title) }}" 
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
                          placeholder="Enter task description">{{ old('description', $task->description) }}</textarea>
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
                        <option value="individual" {{ old('type', $task->type) == 'individual' ? 'selected' : '' }}>Individual</option>
                        <option value="group" {{ old('type', $task->type) == 'group' ? 'selected' : '' }}>Group</option>
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
                        <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
                        <option value="urgent" {{ old('priority', $task->priority) == 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                    @error('priority')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="status">Status <span class="text-danger">*</span></label>
                    <select id="status" 
                            name="status" 
                            class="form-control @error('status') is-invalid @enderror" 
                            required>
                        <option value="">Select status</option>
                        <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $task->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="department_id">Department</label>
                    <select id="department_id" 
                            name="department_id" 
                            class="form-control @error('department_id') is-invalid @enderror">
                        <option value="">Select department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('department_id', $task->department_id) == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="due_date">Due Date</label>
                    <input type="datetime-local" 
                           id="due_date" 
                           name="due_date" 
                           class="form-control @error('due_date') is-invalid @enderror" 
                           value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d\TH:i') : '') }}">
                    @error('due_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="estimated_hours">Estimated Hours</label>
                    <input type="number" 
                           id="estimated_hours" 
                           name="estimated_hours" 
                           class="form-control @error('estimated_hours') is-invalid @enderror" 
                           value="{{ old('estimated_hours', $task->estimated_hours) }}" 
                           min="0" 
                           step="0.5" 
                           placeholder="e.g. 2.5">
                    @error('estimated_hours')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
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
                                {{ in_array($user->id, old('assigned_users', $assignedUsers)) ? 'selected' : '' }}>
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
                    <i class="fas fa-save"></i> Update Task
                </button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                @if(auth()->user()->role === 'admin' || $task->created_by === auth()->id())
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                        <i class="fas fa-trash"></i> Delete Task
                    </button>
                @endif
            </div>
        </form>

        @if(auth()->user()->role === 'admin' || $task->created_by === auth()->id())
            <form id="deleteForm" action="{{ route('tasks.destroy', $task) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Priority preview
    const prioritySelect = document.getElementById('priority');
    function updatePriorityBadge() {
        const label = prioritySelect.parentElement.querySelector('label');
        const existingBadge = label.querySelector('.priority-badge');
        if (existingBadge) {
            existingBadge.remove();
        }
        
        if (prioritySelect.value) {
            const badge = document.createElement('span');
            badge.className = `priority-badge priority-${prioritySelect.value}`;
            badge.textContent = prioritySelect.value.toUpperCase();
            label.appendChild(badge);
        }
    }
    
    // Initialize priority badge
    updatePriorityBadge();
    prioritySelect.addEventListener('change', updatePriorityBadge);

    // Status preview
    const statusSelect = document.getElementById('status');
    function updateStatusBadge() {
        const label = statusSelect.parentElement.querySelector('label');
        const existingBadge = label.querySelector('.status-badge');
        if (existingBadge) {
            existingBadge.remove();
        }
        
        if (statusSelect.value) {
            const badge = document.createElement('span');
            badge.className = `status-badge status-${statusSelect.value}`;
            badge.textContent = statusSelect.value.replace('_', ' ').toUpperCase();
            label.appendChild(badge);
        }
    }
    
    // Initialize status badge
    updateStatusBadge();
    statusSelect.addEventListener('change', updateStatusBadge);

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
});

function confirmDelete() {
    if (confirm('Are you sure you want to delete this task? This action cannot be undone and will also delete all task assignments.')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endsection