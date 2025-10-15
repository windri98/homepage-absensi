@extends('layouts.app')

@section('title', 'Clock In - AttendanceHub')

@section('styles')
<style>
    .attendance-header {
        background: linear-gradient(135deg, var(--secondary-color) 0%, var(--secondary-dark) 100%);
        color: white;
        padding: 2rem 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .attendance-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 50%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
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

    .back-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-50%) scale(1.05);
    }

    .header-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .header-subtitle {
        font-size: 0.875rem;
        opacity: 0.9;
        margin-top: 0.25rem;
    }

    .attendance-content {
        padding: 1.5rem;
        background: var(--gray-50);
        min-height: calc(100vh - 200px);
    }

    .time-display {
        background: white;
        border-radius: var(--radius-xl);
        padding: 2rem;
        text-align: center;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--gray-100);
        position: relative;
        overflow: hidden;
    }

    .time-display::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    }

    .current-time {
        font-size: 3rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .current-date {
        font-size: 1rem;
        color: var(--gray-600);
        font-weight: 500;
    }

    .location-card {
        background: white;
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--gray-100);
    }

    .location-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .location-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--info-color) 0%, #1d4ed8 100%);
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.125rem;
    }

    .location-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-900);
    }

    .location-address {
        font-size: 0.875rem;
        color: var(--gray-600);
        line-height: 1.5;
        padding: 0.75rem;
        background: var(--gray-50);
        border-radius: var(--radius-md);
        border: 1px solid var(--gray-200);
    }

    .clock-in-form {
        background: white;
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--gray-100);
        margin-bottom: 6rem;
    }

    .form-header {
        text-align: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .form-header h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
    }

    .form-header p {
        font-size: 0.875rem;
        color: var(--gray-600);
        margin: 0;
    }

    .photo-upload-area {
        border: 2px dashed var(--gray-300);
        border-radius: var(--radius-md);
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: var(--gray-50);
        margin-bottom: 1.5rem;
    }

    .photo-upload-area:hover {
        border-color: var(--primary-color);
        background: rgba(99, 102, 241, 0.05);
    }

    .photo-upload-area.has-file {
        border-color: var(--success-color);
        background: rgba(16, 185, 129, 0.05);
    }

    .upload-icon {
        width: 60px;
        height: 60px;
        background: var(--gray-200);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        color: var(--gray-500);
        transition: all 0.3s ease;
    }

    .photo-upload-area:hover .upload-icon {
        background: var(--primary-color);
        color: white;
        transform: scale(1.1);
    }

    .upload-text {
        font-size: 0.875rem;
        color: var(--gray-600);
        margin-bottom: 0.5rem;
    }

    .upload-hint {
        font-size: 0.75rem;
        color: var(--gray-500);
    }

    .photo-preview {
        margin-top: 1rem;
        text-align: center;
    }

    .photo-preview img {
        max-width: 100%;
        max-height: 200px;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow);
    }

    .status-card {
        background: white;
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--gray-100);
    }

    .status-card.success {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%);
        border-color: var(--success-color);
    }

    .clock-in-button {
        width: 100%;
        height: 60px;
        background: linear-gradient(135deg, var(--secondary-color) 0%, var(--secondary-dark) 100%);
        color: white;
        border: none;
        border-radius: var(--radius-lg);
        font-size: 1.125rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .clock-in-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .clock-in-button:hover::before {
        left: 100%;
    }

    .clock-in-button:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-xl);
    }

    .clock-in-button:active {
        transform: translateY(0);
    }

    .clock-in-button:disabled {
        background: var(--gray-400);
        cursor: not-allowed;
        transform: none;
    }

    .button-icon {
        font-size: 1.25rem;
    }

    .pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
        }
    }
</style>
@endsection

@section('content')
<div class="attendance-header">
    <div class="header-content">
        <button class="back-btn" onclick="window.location.href='{{ route('dashboard') }}'">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h1 class="header-title">Clock In</h1>
        <p class="header-subtitle">Start your productive day</p>
    </div>
</div>

<div class="attendance-content">
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <!-- Current Time Display -->
    <div class="time-display animate-fade-in">
        <div class="current-time" id="current-time">{{ now()->format('H:i:s') }}</div>
        <div class="current-date" id="current-date">{{ now()->format('l, d F Y') }}</div>
    </div>

    @if(isset($todayAttendance) && $todayAttendance && $todayAttendance->clock_in_time)
        <!-- Already Clocked In Status -->
        <div class="status-card success animate-slide-in">
            <div class="alert alert-info" style="margin: 0;">
                <i class="fas fa-check-circle"></i>
                <div>
                    <strong>Already Clocked In!</strong><br>
                    You clocked in today at {{ $todayAttendance->clock_in_time->format('H:i:s') }}
                </div>
            </div>
            <button class="clock-in-button" onclick="window.location.href='{{ route('dashboard') }}'">
                <i class="button-icon fas fa-home"></i>
                Back to Dashboard
            </button>
        </div>
    @else
        <!-- Location Info -->
        <div class="location-card animate-slide-in">
            <div class="location-header">
                <div class="location-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="location-title">Current Location</div>
            </div>
            <div class="location-address" id="location-address">
                <i class="fas fa-spinner fa-spin"></i> Getting your location...
            </div>
        </div>

        <!-- Clock In Form -->
        <form action="{{ route('attendance.clock-in.store') }}" method="POST" enctype="multipart/form-data" class="clock-in-form animate-fade-in">
            @csrf
            
            <div class="form-header">
                <h3>Ready to Clock In?</h3>
                <p>Please fill in the required information below</p>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-briefcase" style="margin-right: 0.5rem;"></i>
                    Work Type
                </label>
                <select name="work_type" class="form-select" required>
                    <option value="">Select your work type</option>
                    <option value="office" {{ old('work_type') == 'office' ? 'selected' : '' }}>🏢 Office Work</option>
                    <option value="remote" {{ old('work_type') == 'remote' ? 'selected' : '' }}>🏠 Remote Work</option>
                    <option value="field" {{ old('work_type') == 'field' ? 'selected' : '' }}>🚗 Field Work</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-camera" style="margin-right: 0.5rem;"></i>
                    Photo
                </label>
                <div class="photo-upload-area" onclick="document.getElementById('photo').click()">
                    <div class="upload-icon">
                        <i class="fas fa-camera"></i>
                    </div>
                    <div class="upload-text">Take or Upload Photo</div>
                    <div class="upload-hint">Tap to capture your check-in photo</div>
                </div>
                <input type="file" id="photo" name="photo" style="display: none;" accept="image/*" capture="camera">
                <div class="photo-preview" id="photo-preview"></div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-sticky-note" style="margin-right: 0.5rem;"></i>
                    Notes (Optional)
                </label>
                <textarea name="notes" class="form-textarea" rows="3" placeholder="Any additional notes for today...">{{ old('notes') }}</textarea>
            </div>

            <!-- Hidden fields for location -->
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">
            <input type="hidden" name="location_address" id="location_address_input">

            <button type="submit" class="clock-in-button pulse" id="clock-in-btn">
                <i class="button-icon fas fa-play"></i>
                Clock In Now
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

// Get user location
function getLocation() {
    const locationElement = document.getElementById('location-address');
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
                
                // Show coordinates as fallback
                const locationText = `📍 ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                locationElement.innerHTML = locationText;
                document.getElementById('location_address_input').value = locationText;

                // Try to get readable address (simplified)
                if ('serviceWorker' in navigator) {
                    // In a real app, you'd use a geocoding service
                    setTimeout(() => {
                        locationElement.innerHTML = `📍 Workplace Location<br><small class="text-muted">Lat: ${lat.toFixed(4)}, Lng: ${lng.toFixed(4)}</small>`;
                    }, 1000);
                }
            },
            function(error) {
                locationElement.innerHTML = `<i class="fas fa-exclamation-triangle"></i> Location access denied or unavailable`;
                console.error('Geolocation error:', error);
            }
        );
    } else {
        locationElement.innerHTML = `<i class="fas fa-times-circle"></i> Geolocation not supported by your browser`;
    }
}

// Photo preview functionality
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const uploadArea = document.querySelector('.photo-upload-area');
    const preview = document.getElementById('photo-preview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            uploadArea.classList.add('has-file');
            uploadArea.innerHTML = `
                <div class="upload-icon" style="background: var(--success-color);">
                    <i class="fas fa-check"></i>
                </div>
                <div class="upload-text" style="color: var(--success-color);">Photo Selected</div>
                <div class="upload-hint">Tap to change photo</div>
            `;
            preview.innerHTML = `<img src="${e.target.result}" alt="Photo preview">`;
        };
        reader.readAsDataURL(file);
    }
});

// Enhanced form submission
document.querySelector('.clock-in-form').addEventListener('submit', function(e) {
    const button = document.getElementById('clock-in-btn');
    button.innerHTML = '<div class="spinner"></div> Clocking In...';
    button.disabled = true;
    button.classList.remove('pulse');
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateTime();
    setInterval(updateTime, 1000);
    getLocation();
    
    // Add loading animation delay
    setTimeout(() => {
        document.querySelector('.time-display').style.opacity = '1';
        document.querySelector('.location-card').style.opacity = '1';
        document.querySelector('.clock-in-form').style.opacity = '1';
    }, 300);
});
</script>
@endpush