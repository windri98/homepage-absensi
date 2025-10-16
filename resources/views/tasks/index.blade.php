@extends('layouts.app')

@section('title', 'Tasks - AttendanceHub')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ time() }} }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('assets/css/tasks.css') }}?v={{ time() }} }}?v={{ time() }}">
@endsection

@section('content')
<div class="tasks-header">
    <div class="header-content">
        <div class="header-text">
            <h1>My Tasks</h1>
            <p>Manage your daily activities</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('dashboard') }}" class="header-btn" title="Back to Dashboard">
                <i class="fas fa-arrow-left"></i>
            </a>
            <button class="header-btn" onclick="window.location.reload()" title="Refresh">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>
</div>

<!-- Tabs -->
<div class="tab-container">
    <div class="tab-buttons">
        <button class="tab-btn active" onclick="showTab('my-tasks')">
            <i class="fas fa-clipboard-list"></i> My Tasks
        </button>
        @if(auth()->user()->isManager() || auth()->user()->isAdmin())
            <button class="tab-btn" onclick="showTab('created-tasks')">
                <i class="fas fa-plus-circle"></i> Created Tasks
            </button>
        @endif
    </div>
</div>

<div class="tasks-content">
    <!-- My Tasks Tab -->
    <div id="my-tasks" class="tab-content active">
        @if(isset($myTasks) && $myTasks->count() > 0)
            <div class="task-list">
                @foreach($myTasks as $assignment)
                    <div class="task-card priority-{{ $assignment->task->priority }}">
                        <div class="task-header">
                            <div class="task-title">{{ $assignment->task->title }}</div>
                            <span class="priority-badge priority-{{ $assignment->task->priority }}">
                                {{ ucfirst($assignment->task->priority) }}
                            </span>
                        </div>

                        @if($assignment->task->description)
                            <div class="task-description">
                                {{ Str::limit($assignment->task->description, 120) }}
                            </div>
                        @endif

                        <div class="task-meta">
                            @if($assignment->task->due_date)
                                <div class="task-meta-item">
                                    <i class="fas fa-calendar"></i>
                                    <span>Due {{ $assignment->task->due_date->format('M j, Y') }}</span>
                                </div>
                            @endif
                            
                            @if($assignment->task->type === 'group')
                                <div class="task-meta-item">
                                    <i class="fas fa-users"></i>
                                    <span>Group Task</span>
                                </div>
                            @endif

                            <div class="task-meta-item">
                                <i class="fas fa-user"></i>
                                <span>{{ $assignment->task->createdBy->name }}</span>
                            </div>
                        </div>

                        <div class="task-footer">
                            <span class="status-badge status-{{ $assignment->status }}">
                                {{ ucfirst(str_replace('_', ' ', $assignment->status)) }}
                            </span>
                            
                            <div class="action-buttons">
                                <a href="{{ route('tasks.show', $assignment->task) }}" class="btn btn-outline">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                
                                @if($assignment->status === 'assigned')
                                    <button onclick="updateStatus({{ $assignment->id }}, 'in_progress')" class="btn btn-warning">
                                        <i class="fas fa-play"></i> Start
                                    </button>
                                @endif
                                
                                @if($assignment->status === 'in_progress')
                                    <button onclick="updateStatus({{ $assignment->id }}, 'completed')" class="btn btn-success">
                                        <i class="fas fa-check"></i> Complete
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="pagination">
                {{ $myTasks->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-clipboard-list"></i>
                <h3>No Tasks Assigned</h3>
                <p>Your assigned tasks will appear here</p>
            </div>
        @endif
    </div>

    <!-- Created Tasks Tab -->
    @if(auth()->user()->isManager() || auth()->user()->isAdmin())
        <div id="created-tasks" class="tab-content">
            @if(isset($createdTasks) && $createdTasks->count() > 0)
                <div class="task-list">
                    @foreach($createdTasks as $task)
                        <div class="task-card priority-{{ $task->priority }}">
                            <div class="task-header">
                                <div class="task-title">{{ $task->title }}</div>
                                <span class="priority-badge priority-{{ $task->priority }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </div>

                            @if($task->description)
                                <div class="task-description">
                                    {{ Str::limit($task->description, 120) }}
                                </div>
                            @endif

                            <div class="task-meta">
                                @if($task->due_date)
                                    <div class="task-meta-item">
                                        <i class="fas fa-calendar"></i>
                                        <span>Due {{ $task->due_date->format('M j, Y') }}</span>
                                    </div>
                                @endif
                                
                                <div class="task-meta-item">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $task->assignments->count() }} assigned</span>
                                </div>

                                @if($task->type === 'group')
                                    <div class="task-meta-item">
                                        <i class="fas fa-layer-group"></i>
                                        <span>Group Task</span>
                                    </div>
                                @endif
                            </div>

                            <div class="task-footer">
                                <span class="status-badge status-{{ $task->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                                
                                <div class="action-buttons">
                                    <a href="{{ route('tasks.show', $task) }}" class="btn btn-primary">
                                        <i class="fas fa-eye"></i> View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="pagination">
                    {{ $createdTasks->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h3>No Tasks Created</h3>
                    <p>Tasks you create will appear here</p>
                </div>
            @endif
        </div>
    @endif
</div>

<!-- Floating Create Button -->
@if(auth()->user()->isManager() || auth()->user()->isAdmin())
    <a href="{{ route('tasks.create') }}" class="create-btn" title="Create New Task">
        <i class="fas fa-plus"></i>
    </a>
@endif
@endsection

@push('scripts')
<script>
// Tab switching
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected tab content
    document.getElementById(tabName).classList.add('active');
    
    // Add active class to clicked button
    event.target.classList.add('active');
}

// Update task status
function updateStatus(assignmentId, status) {
    const statusText = status === 'in_progress' ? 'start' : 'complete';
    
    if (!confirm(`Are you sure you want to ${statusText} this task?`)) {
        return;
    }
    
    // Show loading state
    const button = event.target;
    const originalHTML = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
    
    fetch(`/tasks/assignments/${assignmentId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification('Task status updated successfully!', 'success');
            
            // Reload page after short delay
            setTimeout(() => {
                window.location.reload();
            }, 500);
        } else {
            showNotification('Error: ' + (data.message || 'Failed to update status'), 'error');
            button.disabled = false;
            button.innerHTML = originalHTML;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while updating the task status', 'error');
        button.disabled = false;
        button.innerHTML = originalHTML;
    });
}

// Simple notification function
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: ${type === 'success' ? 'var(--success-color)' : type === 'error' ? 'var(--danger-color)' : 'var(--info-color)'};
        color: white;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-xl);
        z-index: 1000;
        animation: slideIn 0.3s ease;
    `;
    notification.innerHTML = `
        <div class="d-flex align-items-center gap-1">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add slide animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush

