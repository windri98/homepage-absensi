@extends('layouts.app')

@section('title', 'Edit Profile - AttendanceHub')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ time() }} }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}?v={{ time() }} }}?v={{ time() }}">
@endsection
    .edit-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 2rem 1.5rem;
        position: relative;
    }

    .header-content {
        text-align: center;
    }

    .back-btn {
        position: absolute;
        left: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        color: white;
        text-decoration: none;
        font-size: 1.25rem;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .back-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .edit-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .edit-subtitle {
        font-size: 0.875rem;
        opacity: 0.9;
        margin: 0.25rem 0 0 0;
    }

    .edit-content {
        padding: 1.5rem;
        background: var(--gray-50);
        margin-top: -1rem;
        position: relative;
        z-index: 1;
        border-radius: var(--radius-xl) var(--radius-xl) 0 0;
        min-height: calc(100vh - 150px);
    }

    .edit-form {
        background: white;
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--gray-100);
    }

    .form-sections {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .form-section {
        position: relative;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid var(--gray-200);
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        transition: all 0.2s ease;
        background: white;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    }

    .form-control.is-invalid {
        border-color: var(--danger-color);
        background: rgba(239, 68, 68, 0.05);
    }

    .invalid-feedback {
        color: var(--danger-color);
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: block;
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 3rem;
    }

    .form-text {
        font-size: 0.75rem;
        color: var(--gray-600);
        margin-top: 0.25rem;
    }

    .avatar-section {
        text-align: center;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .current-avatar {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 2rem;
        color: white;
        border: 4px solid var(--gray-200);
    }

    .avatar-upload {
        position: relative;
        display: inline-block;
    }

    .upload-btn {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: var(--radius-md);
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .upload-btn:hover {
        background: var(--primary-dark);
    }

    .file-input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .form-actions {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--gray-200);
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .btn-primary {
        width: 100%;
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 0.875rem;
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
    }

    .btn-primary:disabled {
        background: var(--gray-400);
        cursor: not-allowed;
    }

    .btn-secondary {
        width: 100%;
        background: transparent;
        color: var(--gray-600);
        border: 2px solid var(--gray-300);
        padding: 0.875rem;
        border-radius: var(--radius-md);
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-secondary:hover {
        background: var(--gray-50);
        border-color: var(--gray-400);
        color: var(--gray-700);
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .loading-spinner {
        background: white;
        padding: 2rem;
        border-radius: var(--radius-xl);
        text-align: center;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid var(--gray-200);
        border-left: 4px solid var(--primary-color);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
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

