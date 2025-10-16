@extends('layouts.app')

@section('title', 'Attendance History - AttendanceHub')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('assets/css/attendance.css') }}?v={{ time() }}">
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
        <h3 class="mb-3 text-dark">This Month Summary</h3>
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
                        <div class="time-item mt-2">
                            <div class="time-label">Total Hours</div>
                            <div class="time-value">{{ number_format($attendance->total_hours, 1) }}h</div>
                        </div>
                    @endif

                    @if($attendance->work_type)
                        <div class="mt-2 text-small text-muted">
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

