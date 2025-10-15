@extends('layouts.app')

@section('title', 'Tasks - AttendanceHub')

@section('styles')
<style>
    :root {
        --primary-color: #6366f1;
        --primary-dark: #4f46e5;
        --accent-color: #f59e0b;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #3b82f6;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-900: #111827;
        --radius-sm: 0.375rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    /* Header */
    .tasks-header {
        background: linear-gradient(135deg, var(--accent-color) 0%, #d97706 100%);
        color: white;
        padding: 2rem 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .tasks-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 50%);
        animation: rotate 30s linear infinite;
    }

    .header-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-text h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.25rem 0;
    }

    .header-text p {
        font-size: 0.875rem;
        opacity: 0.9;
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: 0.5rem;
    }

    .header-btn {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: var(--radius-md);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .header-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.05);
    }

    /* Tabs */
    .tab-container {
        padding: 1rem 1.5rem 0;
        background: var(--gray-50);
    }

    .tab-buttons {
        display: flex;
        background: white;
        border-radius: var(--radius-xl);
        padding: 0.375rem;
        box-shadow: var(--shadow);
        margin-bottom: 1.5rem;
    }

    .tab-btn {
        flex: 1;
        padding: 0.75rem 1rem;
        text-align: center;
        border: none;
        background: transparent;
        border-radius: var(--radius-lg);
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        color: var(--gray-600);
    }

    .tab-btn.active {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
    }

    /* Content */
    .tasks-content {
        padding: 0 1.5rem 1.5rem;
        background: var(--gray-50);
        min-height: calc(100vh - 200px);
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Task List */
    .task-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .task-card {
        background: white;
        border-radius: var(--radius-xl);
        padding: 1.25rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--gray-100);
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .task-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--gray-300);
    }

    .task-card.priority-urgent::before { background: var(--danger-color); }
    .task-card.priority-high::before { background: var(--warning-color); }
    .task-card.priority-medium::before { background: var(--info-color); }
    .task-card.priority-low::before { background: var(--success-color); }

    .task-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .task-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
        gap: 1rem;
    }

    .task-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-900);
        line-height: 1.4;
        flex: 1;
    }

    .task-description {
        color: var(--gray-700);
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .task-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.75rem;
        font-size: 0.8125rem;
        color: var(--gray-600);
        margin-bottom: 0.75rem;
    }

    .task-meta-item {
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .task-meta-item i {
        opacity: 0.7;
    }

    .task-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 0.75rem;
        border-top: 1px solid var(--gray-100);
    }

    /* Badges */
    .priority-badge {
        padding: 0.25rem 0.625rem;
        border-radius: var(--radius-sm);
        font-size: 0.6875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        white-space: nowrap;
    }

    .priority-urgent {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }

    .priority-high {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    .priority-medium {
        background: rgba(59, 130, 246, 0.1);
        color: var(--info-color);
    }

    .priority-low {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: var(--radius-sm);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-assigned {
        background: rgba(59, 130, 246, 0.1);
        color: var(--info-color);
    }

    .status-in_progress {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    .status-completed {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: var(--radius-md);
        border: none;
        font-size: 0.8125rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-md);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
    }

    .btn-success {
        background: var(--success-color);
        color: white;
    }

    .btn-warning {
        background: var(--warning-color);
        color: white;
    }

    .btn-outline {
        background: transparent;
        border: 1px solid var(--gray-300);
        color: var(--gray-700);
    }

    .btn-outline:hover {
        background: var(--gray-50);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: var(--gray-500);
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        font-size: 0.875rem;
        color: var(--gray-600);
    }

    /* Floating Action Button */
    .create-btn {
        position: fixed;
        bottom: 2rem;
        right: 1.5rem;
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 1.5rem;
        cursor: pointer;
        box-shadow: var(--shadow-xl);
        transition: all 0.2s ease;
        z-index: 100;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .create-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 30px rgba(99, 102, 241, 0.4);
    }

    /* Task Type Badge */
    .task-type {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.75rem;
        color: var(--gray-600);
        padding: 0.25rem 0.625rem;
        background: var(--gray-100);
        border-radius: var(--radius-sm);
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1.5rem;
    }

    /* Animations */
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (min-width: 640px) {
        .task-card {
            padding: 1.5rem;
        }
        
        .action-buttons {
            gap: 0.75rem;
        }
    }
</style>
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
        <div style="display: flex; align-items: center; gap: 0.5rem;">
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