@extends('layouts.app')

@section('title', 'Attendance History - AttendanceHub')

@section('styles')
<style>
    .history-header {
        background: linear-gradient(135deg, var(--info-color) 0%, #1d4ed8 100%);
        color: white;
        padding: 2rem 1.5rem;
        position: relative;
    }

    .header-content {
        position: relative;
        z-index: 1;
        text-align: center;
    }

    .back-btn {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .history-content {
        padding: 1.5rem;
        background: var(--gray-50);
        min-height: calc(100vh - 200px);
    }

    .filter-tabs {
        display: flex;
        background: white;
        border-radius: var(--radius-lg);
        padding: 0.25rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow);
    }

    .filter-tab {
        flex: 1;
        padding: 0.75rem;
        text-align: center;
        border-radius: var(--radius-md);
        background: transparent;
        border: none;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--gray-600);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .filter-tab.active {
        background: var(--primary-color);
        color: white;
        box-shadow: var(--shadow);
    }

    .attendance-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .attendance-card {
        background: white;
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--gray-100);
        transition: all 0.2s ease;
    }

    .attendance-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .date-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .date-icon {
        width: 40px;
        height: 40px;
        background: var(--gray-100);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
        color: var(--gray-600);
    }

    .date-text {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-900);
    }

    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: var(--radius-sm);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .status-present {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .status-late {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    .status-absent {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }

    .time-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .time-item {
        text-align: center;
        padding: 0.75rem;
        background: var(--gray-50);
        border-radius: var(--radius-md);
        border: 1px solid var(--gray-200);
    }

    .time-label {
        font-size: 0.75rem;
        color: var(--gray-600);
        margin-bottom: 0.25rem;
    }

    .time-value {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-900);
    }

    .summary-stats {
        background: white;
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--gray-100);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
        background: var(--gray-50);
        border-radius: var(--radius-md);
        border: 1px solid var(--gray-200);
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stat-number.present {
        color: var(--success-color);
    }

    .stat-number.late {
        color: var(--warning-color);
    }

    .stat-number.absent {
        color: var(--danger-color);
    }

    .stat-label {
        font-size: 0.75rem;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

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
</style>
@endsection

@section('content')
<div class="history-header">
    <div class="header-content">
        <button class="back-btn" onclick="window.location.href='{{ route('dashboard') }}'">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h1 class="header-title">Attendance History</h1>
    </div>
</div>

<div class="history-content">
    <!-- Summary Stats -->
    <div class="summary-stats">
        <h3 style="margin-bottom: 1rem; color: var(--gray-900);">This Month Summary</h3>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number present">{{ $presentDays ?? 0 }}</div>
                <div class="stat-label">Present</div>
            </div>
            <div class="stat-item">
                <div class="stat-number late">{{ $lateDays ?? 0 }}</div>
                <div class="stat-label">Late</div>
            </div>
            <div class="stat-item">
                <div class="stat-number absent">{{ $absentDays ?? 0 }}</div>
                <div class="stat-label">Absent</div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterAttendance('all')">All</button>
        <button class="filter-tab" onclick="filterAttendance('present')">Present</button>
        <button class="filter-tab" onclick="filterAttendance('late')">Late</button>
        <button class="filter-tab" onclick="filterAttendance('absent')">Absent</button>
    </div>

    <!-- Attendance List -->
    <div class="attendance-list" id="attendance-list">
        @forelse($attendances ?? [] as $attendance)
            <div class="attendance-card" data-status="{{ $attendance->status }}">
                <div class="card-header">
                    <div class="date-info">
                        <div class="date-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="date-text">
                            {{ $attendance->date->format('D, M j') }}
                        </div>
                    </div>
                    <span class="status-badge status-{{ $attendance->status }}">
                        {{ ucfirst($attendance->status) }}
                    </span>
                </div>

                @if($attendance->clock_in_time || $attendance->clock_out_time)
                    <div class="time-details">
                        <div class="time-item">
                            <div class="time-label">Clock In</div>
                            <div class="time-value">
                                {{ $attendance->clock_in_time ? $attendance->clock_in_time->format('H:i') : '--:--' }}
                            </div>
                        </div>
                        <div class="time-item">
                            <div class="time-label">Clock Out</div>
                            <div class="time-value">
                                {{ $attendance->clock_out_time ? $attendance->clock_out_time->format('H:i') : '--:--' }}
                            </div>
                        </div>
                    </div>

                    @if($attendance->total_hours > 0)
                        <div class="time-item" style="margin-top: 0.5rem;">
                            <div class="time-label">Total Hours</div>
                            <div class="time-value">{{ number_format($attendance->total_hours, 1) }}h</div>
                        </div>
                    @endif

                    @if($attendance->work_type)
                        <div style="margin-top: 0.5rem; font-size: 0.875rem; color: var(--gray-600);">
                            <i class="fas fa-briefcase"></i> {{ ucfirst($attendance->work_type) }} Work
                        </div>
                    @endif
                @endif
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <h3>No Attendance Records</h3>
                <p>Your attendance history will appear here</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
function filterAttendance(status) {
    // Update active tab
    document.querySelectorAll('.filter-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    event.target.classList.add('active');

    // Filter cards
    const cards = document.querySelectorAll('.attendance-card');
    cards.forEach(card => {
        if (status === 'all' || card.dataset.status === status) {
            card.style.display = 'block';
            card.style.animation = 'fadeIn 0.3s ease';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
@endpush