@extends('layouts.app')

@section('title', 'Profile - AttendanceHub')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ time() }} }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}?v={{ time() }} }}?v={{ time() }}">
@endsection

@section('content')
<div class="profile-header">
    <div class="header-content">
        <div class="profile-avatar">
            <span>{{ substr($user->name, 0, 1) }}</span>
            <div class="avatar-edit">
                <i class="fas fa-camera text-sm"></i>
            </div>
        </div>
        <h1 class="profile-name">{{ $user->name }}</h1>
        <p class="profile-role">{{ ucfirst($user->role) }}</p>
        <span class="profile-id">ID: {{ $user->employee_id }}</span>
    </div>
</div>

<div class="profile-content">
    @if(session('success'))
        <div class="alert alert-success mb-3">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mb-3">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="profile-sections">
        <!-- Personal Information -->
        <div class="profile-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-user"></i>
                    Personal Information
                </h2>
                <a href="{{ route('profile.edit') }}" class="section-action">
                    Edit <i class="fas fa-chevron-right"></i>
                </a>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Phone</span>
                    <span class="info-value">{{ $user->phone ?? 'Not set' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Position</span>
                    <span class="info-value">{{ $user->position ?? 'Not set' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Department</span>
                    <span class="info-value">{{ $user->department->name ?? 'Not assigned' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Hire Date</span>
                    <span class="info-value">{{ $user->hire_date ? $user->hire_date->format('M d, Y') : 'Not set' }}</span>
                </div>
            </div>
        </div>

        <!-- Monthly Statistics -->
        <div class="profile-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-chart-bar"></i>
                    This Month Stats
                </h2>
                <a href="{{ route('attendance.history') }}" class="section-action">
                    View All <i class="fas fa-chevron-right"></i>
                </a>
            </div>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number present">{{ $monthlyStats['present'] ?? 0 }}</div>
                    <div class="stat-label">Present Days</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number late">{{ $monthlyStats['late'] ?? 0 }}</div>
                    <div class="stat-label">Late Days</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number absent">{{ $monthlyStats['absent'] ?? 0 }}</div>
                    <div class="stat-label">Absent Days</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number tasks">{{ $monthlyStats['tasks'] ?? 0 }}</div>
                    <div class="stat-label">Tasks Done</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="profile-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-bolt"></i>
                    Quick Actions
                </h2>
            </div>
            <div class="action-buttons">
                <a href="{{ route('profile.edit') }}" class="action-btn">
                    <div class="action-left">
                        <div class="action-icon">
                            <i class="fas fa-edit text-primary"></i>
                        </div>
                        <div class="action-text">
                            <h4>Edit Profile</h4>
                            <p>Update your personal information</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right"></i>
                </a>
                
                <a href="{{ route('attendance.history') }}" class="action-btn">
                    <div class="action-left">
                        <div class="action-icon">
                            <i class="fas fa-history text-info"></i>
                        </div>
                        <div class="action-text">
                            <h4>Attendance History</h4>
                            <p>View your attendance records</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right"></i>
                </a>
                
                <a href="{{ route('tasks.index') }}" class="action-btn">
                    <div class="action-left">
                        <div class="action-icon">
                            <i class="fas fa-tasks text-warning"></i>
                        </div>
                        <div class="action-text">
                            <h4>My Tasks</h4>
                            <p>View assigned tasks</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right"></i>
                </a>

                <button onclick="changePassword()" class="action-btn">
                    <div class="action-left">
                        <div class="action-icon">
                            <i class="fas fa-lock text-success"></i>
                        </div>
                        <div class="action-text">
                            <h4>Change Password</h4>
                            <p>Update your account password</p>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <!-- Logout Section -->
        <div class="logout-section">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn" onclick="return confirm('Are you sure you want to logout?')">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function changePassword() {
    // Simple password change modal
    const currentPassword = prompt('Enter your current password:');
    if (!currentPassword) return;
    
    const newPassword = prompt('Enter your new password:');
    if (!newPassword) return;
    
    const confirmPassword = prompt('Confirm your new password:');
    if (newPassword !== confirmPassword) {
        alert('Passwords do not match!');
        return;
    }
    
    if (newPassword.length < 6) {
        alert('Password must be at least 6 characters long!');
        return;
    }
    
    // Send password change request
    fetch('{{ route("profile.password.update") }}', {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            current_password: currentPassword,
            password: newPassword,
            password_confirmation: confirmPassword
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.showToast('Password updated successfully');
        } else {
            window.showToast(data.message || 'Failed to update password', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        window.showToast('An error occurred', 'error');
    });
}
</script>
@endpush

