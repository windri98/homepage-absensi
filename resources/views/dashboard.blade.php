@extends('layouts.app')

@section('title', 'Dashboard - AttendanceHub')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ time() }} }}?v={{ time() }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}?v={{ time() }} }}?v={{ time() }}?v={{ time() }}">

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
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
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
        `<a href="${action.url}" class="quick-action-link">
            <i class="${action.icon} quick-action-icon"></i>
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
        <div class="quick-action-popup">
            <div class="quick-action-popup-header">Quick Actions</div>
            ${actionList}
            <button onclick="this.closest('div').parentElement.remove()" class="quick-action-popup-close">Close</button>
        </div>
    `;
    
    modal.onclick = function(e) {
        if (e.target === modal) modal.remove();
    };
    
    document.body.appendChild(modal);
}
</script>
@endpush

