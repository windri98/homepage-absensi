@extends('layouts.app')

@section('title', 'Dashboard - AttendanceHub')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
@endsection
    :root {
        --primary-color: #6366f1;
        --primary-dark: #4f46e5;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #3b82f6;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
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

    /* Dashboard Container */
    .dashboard-container {
        min-height: 100vh;
        background: var(--gray-50);
    }

    /* Header Section */
    .dashboard-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 2rem 1.5rem 3rem;
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
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
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
    }

    .greeting-time {
        font-size: 0.875rem;
        opacity: 0.9;
        margin-bottom: 0.25rem;
    }

    .greeting-name {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
    }

    .header-btn {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .header-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.1);
    }

    /* Time Widget */
    .time-widget {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        text-align: center;
    }

    .current-time {
        font-size: 2.5rem;
        font-weight: 300;
        margin-bottom: 0.25rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .current-date {
        font-size: 0.875rem;
        opacity: 0.9;
    }

    /* Main Content */
    .dashboard-content {
        padding: 1.5rem;
        margin-top: -1.5rem;
        position: relative;
        z-index: 1;
        border-radius: var(--radius-xl) var(--radius-xl) 0 0;
        background: var(--gray-50);
        min-height: calc(100vh - 200px);
    }

    /* Section Card */
    .section-card {
        background: white;
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--gray-100);
        margin-bottom: 1.5rem;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-900);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-link {
        color: var(--primary-color);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        transition: color 0.2s ease;
    }

    .section-link:hover {
        color: var(--primary-dark);
    }

    /* Attendance Status */
    .attendance-status {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        border-radius: var(--radius-md);
        color: white;
        margin-bottom: 1rem;
    }

    .attendance-status.present {
        background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
    }

    .attendance-status.late {
        background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%);
    }

    .attendance-status.absent {
        background: linear-gradient(135deg, var(--danger-color) 0%, #dc2626 100%);
    }

    .status-info {
        flex: 1;
    }

    .status-time {
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .status-label {
        font-size: 0.875rem;
        opacity: 0.9;
    }

    .status-icon {
        font-size: 1.5rem;
    }

    /* Quick Actions */
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .action-card {
        display: block;
        padding: 1.25rem;
        background: white;
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-md);
        text-decoration: none;
        text-align: center;
        transition: all 0.2s ease;
        color: inherit;
    }

    .action-card:hover {
        border-color: var(--primary-color);
        background: rgba(99, 102, 241, 0.05);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .action-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        color: white;
        font-size: 1.25rem;
    }

    .action-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.25rem;
    }

    .action-subtitle {
        font-size: 0.75rem;
        color: var(--gray-600);
    }

    /* Statistics */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .stat-card {
        text-align: center;
        padding: 1.25rem;
        background: var(--gray-50);
        border-radius: var(--radius-md);
        border: 1px solid var(--gray-200);
        transition: all 0.2s ease;
    }

    .stat-card:hover {
        background: rgba(99, 102, 241, 0.05);
        border-color: var(--primary-color);
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stat-number.present { color: var(--success-color); }
    .stat-number.late { color: var(--warning-color); }
    .stat-number.absent { color: var(--danger-color); }
    .stat-number.tasks { color: var(--info-color); }

    .stat-label {
        font-size: 0.75rem;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    /* Task List */
    .task-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .task-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        background: var(--gray-50);
        border-radius: var(--radius-md);
        border: 1px solid var(--gray-200);
        transition: all 0.2s ease;
        text-decoration: none;
        color: inherit;
    }

    .task-item:hover {
        background: rgba(99, 102, 241, 0.05);
        border-color: var(--primary-color);
    }

    .task-content {
        flex: 1;
    }

    .task-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.25rem;
    }

    .task-meta {
        font-size: 0.75rem;
        color: var(--gray-600);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .priority-badge {
        padding: 0.125rem 0.5rem;
        border-radius: var(--radius-sm);
        font-size: 0.625rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .priority-high {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }

    .priority-medium {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    .priority-low {
        background: rgba(34, 197, 94, 0.1);
        color: var(--success-color);
    }

    .task-chevron {
        color: var(--gray-400);
        font-size: 0.875rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: var(--gray-600);
    }

    .empty-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state h3 {
        margin-bottom: 0.5rem;
        color: var(--gray-900);
    }

    /* Floating Action Button */
    .floating-action {
        position: fixed;
        bottom: 6rem;
        right: 1.5rem;
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        border: none;
        border-radius: 50%;
        color: white;
        font-size: 1.25rem;
        cursor: pointer;
        box-shadow: var(--shadow-xl);
        transition: all 0.2s ease;
        z-index: 1000;
    }

    .floating-action:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 25px rgba(99, 102, 241, 0.3);
    }

    /* Animations */
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (min-width: 640px) {
        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
        }
        
        .actions-grid {
            grid-template-columns: repeat(4, 1fr);
@endsection

@section('content')
<div class="dashboard-container">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div class="header-content">
            <div class="header-top">
                <div class="greeting">
                    <div class="greeting-time" id="greeting-text">Good morning,</div>
                    <h1 class="greeting-name">{{ $user->name }}</h1>
                </div>
                <div class="header-actions">
                    <a href="{{ route('profile.show') }}" class="header-btn">
                        <i class="fas fa-user"></i>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="header-btn">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="time-widget">
                <div class="current-time" id="current-time">{{ date('H:i') }}</div>
                <div class="current-date" id="current-date">{{ date('l, F j, Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="dashboard-content">
        <!-- Today's Attendance -->
        @if(isset($todayAttendance) && $todayAttendance)
            <div class="section-card">
                <div class="attendance-status {{ $todayAttendance->status }}">
                    <div class="status-info">
                        <div class="status-time">
                            @if($todayAttendance->clock_in)
                                {{ date('H:i', strtotime($todayAttendance->clock_in)) }}
                                @if($todayAttendance->clock_out)
                                    - {{ date('H:i', strtotime($todayAttendance->clock_out)) }}
                                @endif
                            @else
                                Not clocked in yet
                            @endif
                        </div>
                        <div class="status-label">
                            Today's Attendance - {{ ucfirst($todayAttendance->status) }}
                        </div>
                    </div>
                    <div class="status-icon">
                        @if($todayAttendance->status === 'present')
                            <i class="fas fa-check-circle"></i>
                        @elseif($todayAttendance->status === 'late')
                            <i class="fas fa-exclamation-triangle"></i>
                        @else
                            <i class="fas fa-times-circle"></i>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Quick Actions -->
        <div class="section-card">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-bolt"></i>
                    Quick Actions
                </h3>
            </div>
            
            <div class="actions-grid">
                @if(!isset($todayAttendance) || !$todayAttendance || !$todayAttendance->clock_in)
                    <a href="{{ route('attendance.clock-in') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <div class="action-title">Clock In</div>
                        <div class="action-subtitle">Start your day</div>
                    </a>
                @elseif(!$todayAttendance->clock_out)
                    <a href="{{ route('attendance.clock-out') }}" class="action-card">
                        <div class="action-icon">
                            <i class="fas fa-sign-out-alt"></i>
                        </div>
                        <div class="action-title">Clock Out</div>
                        <div class="action-subtitle">End your day</div>
                    </a>
                @endif
                
                <a href="{{ route('tasks.index') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="action-title">My Tasks</div>
                    <div class="action-subtitle">View assignments</div>
                </a>
                
                <a href="{{ route('attendance.history') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <div class="action-title">History</div>
                    <div class="action-subtitle">View records</div>
                </a>
                
                <a href="{{ route('profile.show') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="action-title">Profile</div>
                    <div class="action-subtitle">Manage account</div>
                </a>
            </div>
        </div>

        <!-- Monthly Statistics -->
        <div class="section-card">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-chart-bar"></i>
                    This Month
                </h3>
                <a href="{{ route('attendance.history') }}" class="section-link">
                    View All <i class="fas fa-chevron-right"></i>
                </a>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number present">{{ $monthlyStats['present'] ?? 0 }}</div>
                    <div class="stat-label">Present</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number late">{{ $monthlyStats['late'] ?? 0 }}</div>
                    <div class="stat-label">Late</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number absent">{{ $monthlyStats['absent'] ?? 0 }}</div>
                    <div class="stat-label">Absent</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number tasks">{{ $monthlyStats['tasks'] ?? 0 }}</div>
                    <div class="stat-label">Tasks Done</div>
                </div>
            </div>
        </div>

        <!-- Pending Tasks -->
        @if(isset($pendingTasks) && $pendingTasks && $pendingTasks->count() > 0)
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-clock"></i>
                        Pending Tasks
                    </h3>
                    <a href="{{ route('tasks.index') }}" class="section-link">
                        View All <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
                
                <div class="task-list">
                    @foreach($pendingTasks->take(3) as $assignment)
                        <a href="{{ route('tasks.show', $assignment->task) }}" class="task-item">
                            <div class="task-content">
                                <div class="task-title">{{ $assignment->task->title }}</div>
                                <div class="task-meta">
                                    <span class="priority-badge priority-{{ $assignment->task->priority }}">
                                        {{ $assignment->task->priority }}
                                    </span>
                                    @if($assignment->task->due_date)
                                        <span>Due: {{ $assignment->task->due_date->format('M d') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="task-chevron">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <div class="section-card">
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3>All caught up!</h3>
                    <p>You have no pending tasks at the moment.</p>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Floating Action Button -->
<button class="floating-action" onclick="showQuickActions()">
    <i class="fas fa-plus"></i>
</button>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update greeting based on time
    function updateGreeting() {
        const hour = new Date().getHours();
        const greetingElement = document.getElementById('greeting-text');
        
        if (hour < 12) {
            greetingElement.textContent = 'Good morning,';
        } else if (hour < 18) {
            greetingElement.textContent = 'Good afternoon,';
        } else {
            greetingElement.textContent = 'Good evening,';
        }
    }
    
    // Update current time
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('en-US', { 
            hour12: false, 
            hour: '2-digit', 
            minute: '2-digit' 
        });
        const dateString = now.toLocaleDateString('en-US', { 
            weekday: 'long',
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        
        document.getElementById('current-time').textContent = timeString;
        document.getElementById('current-date').textContent = dateString;
    }
    
    // Initialize
    updateGreeting();
    updateTime();
    
    // Update time every second
    setInterval(updateTime, 1000);
    
    // Update greeting every minute
    setInterval(updateGreeting, 60000);
});

function showQuickActions() {
    const actions = [
        { name: 'Clock In', url: '{{ route("attendance.clock-in") }}', icon: 'fas fa-sign-in-alt' },
        { name: 'Clock Out', url: '{{ route("attendance.clock-out") }}', icon: 'fas fa-sign-out-alt' },
        { name: 'View Tasks', url: '{{ route("tasks.index") }}', icon: 'fas fa-tasks' },
        { name: 'View Profile', url: '{{ route("profile.show") }}', icon: 'fas fa-user' }
    ];
    
    let actionList = actions.map(action => 
        `<a href="${action.url}" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; text-decoration: none; color: #333; border-bottom: 1px solid #eee; transition: background 0.2s;">
            <i class="${action.icon}" style="width: 24px; color: var(--primary-color);"></i>
            <span>${action.name}</span>
        </a>`
    ).join('');
    
    const modal = document.createElement('div');
    modal.style.cssText = `
        position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
        background: rgba(0,0,0,0.5); z-index: 1001; display: flex; 
        align-items: center; justify-content: center; padding: 1rem;
    `;
    
    modal.innerHTML = `
        <div style="background: white; border-radius: 1rem; max-width: 320px; width: 100%; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
            <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb; font-weight: 600; font-size: 1.125rem;">Quick Actions</div>
            ${actionList}
            <button onclick="this.closest('div').parentElement.remove()" style="width: 100%; padding: 1rem; border: none; background: var(--gray-50); color: var(--gray-700); cursor: pointer; font-weight: 500;">Close</button>
        </div>
    `;
    
    modal.onclick = function(e) {
        if (e.target === modal) modal.remove();
    };
    
    document.body.appendChild(modal);
}
</script>
@endpush