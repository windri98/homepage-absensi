@extends('layouts.app')

@section('title', 'Clock In - AttendanceHub')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('assets/css/attendance.css') }}?v={{ time() }}">
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
            <div class="alert alert-info m-0">
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
                    <i class="fas fa-briefcase mr-1"></i>
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
                    <i class="fas fa-camera mr-1"></i>
                    Photo
                </label>
                <div class="photo-upload-area" onclick="document.getElementById('photo').click()">
                    <div class="upload-icon">
                        <i class="fas fa-camera"></i>
                    </div>
                    <div class="upload-text">Take or Upload Photo</div>
                    <div class="upload-hint">Tap to capture your check-in photo</div>
                </div>
                <input type="file" id="photo" name="photo" class="d-none" accept="image/*" capture="camera">
                <div class="photo-preview" id="photo-preview"></div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-sticky-note mr-1"></i>
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
                <div class="upload-icon success">
                    <i class="fas fa-check"></i>
                </div>
                <div class="upload-text success">Photo Selected</div>
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

