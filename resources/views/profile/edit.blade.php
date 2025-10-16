@extends('layouts.app')

@section('title', 'Edit Profile - AttendanceHub')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}?v={{ time() }}">
@endsection

@section('content')
<div class="edit-header">
    <a href="{{ route('profile.show') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div class="header-content">
        <h1 class="edit-title">Edit Profile</h1>
        <p class="edit-subtitle">Update your personal information</p>
    </div>
</div>

<div class="edit-content">
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="edit-form" id="profileForm">
        @csrf
        @method('PATCH')
        
        @if(session('success'))
            <div class="alert alert-success mb-3">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="fas fa-exclamation-circle"></i>
                Please correct the errors below.
            </div>
        @endif

        <!-- Avatar Section -->
        <div class="avatar-section">
            <div class="current-avatar" id="avatarPreview">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div class="avatar-upload">
                <button type="button" class="upload-btn">
                    <i class="fas fa-camera"></i> Change Photo
                </button>
                <input type="file" name="avatar" class="file-input" id="avatarInput" accept="image/*">
            </div>
            <div class="form-text">JPG, PNG or GIF (Max 2MB)</div>
        </div>

        <div class="form-sections">
            <!-- Basic Information -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-user"></i>
                    Basic Information
                </h3>
                
                <div class="form-group">
                    <label for="name" class="form-label">Full Name *</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address *</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                           value="{{ old('phone', $user->phone) }}" placeholder="Enter your phone number">
                    @error('phone')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Work Information -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-briefcase"></i>
                    Work Information
                </h3>
                
                <div class="form-group">
                    <label for="employee_id" class="form-label">Employee ID</label>
                    <input type="text" id="employee_id" name="employee_id" class="form-control" 
                           value="{{ $user->employee_id }}" readonly>
                    <div class="form-text">This field cannot be changed</div>
                </div>

                <div class="form-group">
                    <label for="position" class="form-label">Position</label>
                    <input type="text" id="position" name="position" class="form-control @error('position') is-invalid @enderror" 
                           value="{{ old('position', $user->position) }}" placeholder="e.g. Software Developer">
                    @error('position')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                @if(auth()->user()->role === 'admin')
                <div class="form-group">
                    <label for="department_id" class="form-label">Department</label>
                    <select id="department_id" name="department_id" class="form-control form-select @error('department_id') is-invalid @enderror">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" 
                                {{ old('department_id', $user->department_id) == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Role</label>
                    <select id="role" name="role" class="form-control form-select @error('role') is-invalid @enderror">
                        <option value="employee" {{ old('role', $user->role) === 'employee' ? 'selected' : '' }}>Employee</option>
                        <option value="manager" {{ old('role', $user->role) === 'manager' ? 'selected' : '' }}>Manager</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="hire_date" class="form-label">Hire Date</label>
                    <input type="date" id="hire_date" name="hire_date" class="form-control @error('hire_date') is-invalid @enderror" 
                           value="{{ old('hire_date', $user->hire_date?->format('Y-m-d')) }}">
                    @error('hire_date')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                @else
                <div class="form-group">
                    <label class="form-label">Department</label>
                    <input type="text" class="form-control" value="{{ $user->department->name ?? 'Not assigned' }}" readonly>
                    <div class="form-text">Contact admin to change department</div>
                </div>

                <div class="form-group">
                    <label class="form-label">Role</label>
                    <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" readonly>
                    <div class="form-text">Contact admin to change role</div>
                </div>
                @endif
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary" id="submitBtn">
                <i class="fas fa-save"></i>
                Save Changes
            </button>
            <a href="{{ route('profile.show') }}" class="btn-secondary">
                <i class="fas fa-times"></i>
                Cancel
            </a>
        </div>
    </form>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner"></div>
        <p>Updating profile...</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('profileForm');
    const submitBtn = document.getElementById('submitBtn');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const avatarInput = document.getElementById('avatarInput');
    const avatarPreview = document.getElementById('avatarPreview');

    // Avatar preview
    avatarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                window.showToast('File size must be less than 2MB', 'error');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                avatarPreview.style.backgroundImage = `url(${e.target.result})`;
                avatarPreview.style.backgroundSize = 'cover';
                avatarPreview.style.backgroundPosition = 'center';
                avatarPreview.textContent = '';
            };
            reader.readAsDataURL(file);
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate required fields
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        
        if (!name || !email) {
            window.showToast('Please fill in all required fields', 'error');
            return;
        }

        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            window.showToast('Please enter a valid email address', 'error');
            return;
        }

        // Phone validation (if provided)
        const phone = document.getElementById('phone').value.trim();
        if (phone && !/^[\d\s\-\+\(\)]+$/.test(phone)) {
            window.showToast('Please enter a valid phone number', 'error');
            return;
        }

        // Show loading
        submitBtn.disabled = true;
        loadingOverlay.style.display = 'flex';
        
        // Submit form
        setTimeout(() => {
            this.submit();
        }, 500);
    });

    // Auto-format phone number
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0) {
            value = value.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
        }
        e.target.value = value;
    });

    // Name formatting
    const nameInput = document.getElementById('name');
    nameInput.addEventListener('blur', function(e) {
        // Capitalize each word
        const words = e.target.value.toLowerCase().split(' ');
        const capitalizedWords = words.map(word => 
            word.charAt(0).toUpperCase() + word.slice(1)
        );
        e.target.value = capitalizedWords.join(' ');
    });
});
</script>
@endpush

