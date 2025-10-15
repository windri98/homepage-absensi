@extends('layouts.app')

@section('title', 'Clock Out - Sistem Absensi')

@section('styles')
<style>
    .header {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        color: white;
        padding: 20px;
        text-align: center;
        position: relative;
    }
    
    .back-btn {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
    }
    
    .container {
        flex: 1;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .time-display {
        background: white;
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .current-time {
        font-size: 28px;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }
    
    .current-date {
        font-size: 16px;
        color: #666;
    }
    
    .attendance-info {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .info-row:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: bold;
        color: #333;
    }
    
    .info-value {
        color: #666;
    }
    
    .attendance-form {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: bold;
        color: #333;
        margin-bottom: 8px;
    }
    
    .form-textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        min-height: 80px;
        resize: vertical;
    }
    
    .clock-out-btn {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: transform 0.2s;
    }
    
    .clock-out-btn:hover {
        transform: translateY(-2px);
    }
    
    .clock-out-btn:disabled {
        background: #ccc;
        cursor: not-allowed;
        transform: none;
    }
    
    .alert {
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 15px;
    }
    
    .alert-success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .alert-danger {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .alert-warning {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }
    
    .work-summary {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
    }
    
    .work-summary h4 {
        color: #333;
        margin-bottom: 10px;
    }
</style>
@endsection

@section('content')
<div class="header">
    <button class="back-btn" onclick="window.location.href='{{ route('dashboard') }}'">
        ← 
    </button>
    <h1>Clock Out</h1>
</div>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Current Time Display -->
    <div class="time-display">
        <div class="current-time" id="current-time">--:--:--</div>
        <div class="current-date" id="current-date">-- --- ----</div>
    </div>

    @if(!$todayAttendance)
        <div class="alert alert-warning">
            You haven't clocked in today. Please clock in first.
        </div>
        <button onclick="window.location.href='{{ route('attendance.clock-in') }}'" class="clock-out-btn">
            Go to Clock In
        </button>
    @elseif($todayAttendance->clock_out_time)
        <div class="alert alert-success">
            You have already clocked out today at {{ $todayAttendance->clock_out_time->format('H:i:s') }}
        </div>
        
        <!-- Today's Work Summary -->
        <div class="attendance-info">
            <h4 style="margin-bottom: 15px; color: #333;">Today's Work Summary</h4>
            <div class="info-row">
                <span class="info-label">Clock In:</span>
                <span class="info-value">{{ $todayAttendance->clock_in_time->format('H:i:s') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Clock Out:</span>
                <span class="info-value">{{ $todayAttendance->clock_out_time->format('H:i:s') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Work Duration:</span>
                <span class="info-value">
                    @php
                        $duration = $todayAttendance->clock_out_time->diff($todayAttendance->clock_in_time);
                        echo $duration->format('%H:%I:%S');
                    @endphp
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value">{{ ucfirst($todayAttendance->status) }}</span>
            </div>
        </div>
    @else
        <!-- Today's Attendance Info -->
        <div class="attendance-info">
            <h4 style="margin-bottom: 15px; color: #333;">Today's Attendance</h4>
            <div class="info-row">
                <span class="info-label">Clock In Time:</span>
                <span class="info-value">{{ $todayAttendance->clock_in_time->format('H:i:s') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Work Type:</span>
                <span class="info-value">{{ ucfirst($todayAttendance->work_type) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value">{{ ucfirst($todayAttendance->status) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Work Duration:</span>
                <span class="info-value" id="work-duration">--:--:--</span>
            </div>
        </div>

        <!-- Clock Out Form -->
        <form action="{{ route('attendance.clock-out.store') }}" method="POST" class="attendance-form">
            @csrf
            
            <div class="work-summary">
                <h4>Work Summary</h4>
                <p style="font-size: 14px; color: #666; margin: 0;">
                    Please provide a brief summary of your work today before clocking out.
                </p>
            </div>

            <div class="form-group">
                <label class="form-label">Work Summary</label>
                <textarea name="work_summary" class="form-textarea" placeholder="Describe what you accomplished today..." required>{{ old('work_summary') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Additional Notes (Optional)</label>
                <textarea name="notes" class="form-textarea" placeholder="Any additional notes...">{{ old('notes') }}</textarea>
            </div>

            <button type="submit" class="clock-out-btn">
                🕐 Clock Out Now
            </button>
        </form>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Update time display
function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID');
    const dateString = now.toLocaleDateString('id-ID', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
    
    document.getElementById('current-time').textContent = timeString;
    document.getElementById('current-date').textContent = dateString;
}

// Update work duration
function updateWorkDuration() {
    @if($todayAttendance && $todayAttendance->clock_in_time && !$todayAttendance->clock_out_time)
        const clockInTime = new Date('{{ $todayAttendance->clock_in_time->format('Y-m-d H:i:s') }}');
        const now = new Date();
        const diff = now - clockInTime;
        
        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);
        
        const durationElement = document.getElementById('work-duration');
        if (durationElement) {
            durationElement.textContent = 
                String(hours).padStart(2, '0') + ':' + 
                String(minutes).padStart(2, '0') + ':' + 
                String(seconds).padStart(2, '0');
        }
    @endif
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateTime();
    updateWorkDuration();
    setInterval(updateTime, 1000);
    setInterval(updateWorkDuration, 1000);
});
</script>
@endpush