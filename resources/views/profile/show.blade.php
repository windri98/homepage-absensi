@extends('layouts.app')

@section('title', 'Profile - AttendanceHub')

@section('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, var(--gray-800) 0%, var(--gray-900) 100%);
        color: white;
        padding: 2rem 1.5rem 3rem;
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 50%);
        animation: rotate 30s linear infinite;
    }

    .header-content {
        position: relative;
        z-index: 1;
        text-align: center;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 2.5rem;
        color: white;
        position: relative;
        border: 4px solid rgba(255, 255, 255, 0.2);
        box-shadow: var(--shadow-xl);
    }

    .avatar-edit {
        position: absolute;
        bottom: -5px;
        right: -5px;
        width: 36px;
        height: 36px;
        background: var(--success-color);
        border-radius: 50%;
        border: 3px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .avatar-edit:hover {
        transform: scale(1.1);
        background: var(--secondary-dark);
    }

    .profile-name {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .profile-role {
        font-size: 0.875rem;
        opacity: 0.9;
        margin-bottom: 0.5rem;
    }

    .profile-id {
        font-size: 0.8125rem;
        opacity: 0.7;
        background: rgba(255, 255, 255, 0.1);
        padding: 0.25rem 0.75rem;
        border-radius: var(--radius-sm);
        display: inline-block;
    }

    .profile-content {
        padding: 1.5rem;
        background: var(--gray-50);
        margin-top: -1.5rem;
        position: relative;
        z-index: 1;
        border-radius: var(--radius-xl) var(--radius-xl) 0 0;
        min-height: calc(100vh - 200px);
    }

    .profile-sections {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .profile-section {
        background: white;
        border-radius: var(--radius-xl);
        padding: 1.5rem;
        box-shadow: var(--shadow);
        border: 1px solid var(--gray-100);
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
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-action {
        color: var(--primary-color);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        transition: color 0.2s ease;
    }

    .section-action:hover {
        color: var(--primary-dark);
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        background: var(--gray-50);
        border-radius: var(--radius-md);
        border: 1px solid var(--gray-200);
    }

    .info-label {
        font-size: 0.875rem;
        color: var(--gray-600);
        font-weight: 500;
    }

    .info-value {
        font-size: 0.875rem;
        color: var(--gray-900);
        font-weight: 600;
        text-align: right;
    }

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

    .action-buttons {
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }

    .action-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        background: var(--gray-50);
        border: 1px solid var(--gray-200);
        border-radius: var(--radius-md);
        text-decoration: none;
        color: var(--gray-700);
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        background: rgba(99, 102, 241, 0.05);
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    .action-btn.danger:hover {
        background: rgba(239, 68, 68, 0.05);
        border-color: var(--danger-color);
        color: var(--danger-color);
    }

    .action-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .action-icon {
        width: 40px;
        height: 40px;
        background: white;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-sm);
    }

    .action-text h4 {
        font-size: 0.875rem;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
    }

    .action-text p {
        font-size: 0.75rem;
        color: var(--gray-600);
        margin: 0;
    }

    .logout-section {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--gray-200);
    }

    .logout-btn {
        width: 100%;
        padding: 1rem;
        background: transparent;
        border: 2px solid var(--danger-color);
        border-radius: var(--radius-md);
        color: var(--danger-color);
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .logout-btn:hover {
        background: var(--danger-color);
        color: white;
    }
</style>
@endsection

@section('content')
<div class="profile-header">
    <div class="header-content">
        <div class="profile-avatar">
            <span>{{ substr($user->name, 0, 1) }}</span>
            <div class="avatar-edit">
                <i class="fas fa-camera" style="font-size: 0.875rem;"></i>
            </div>
        </div>
        <h1 class="profile-name">{{ $user->name }}</h1>
        <p class="profile-role">{{ ucfirst($user->role) }}</p>
        <span class="profile-id">ID: {{ $user->employee_id }}</span>
    </div>
</div>

<div class="profile-content">
    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 1.5rem;">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="margin-bottom: 1.5rem;">
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
                            <i class="fas fa-edit" style="color: var(--primary-color);"></i>
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
                            <i class="fas fa-history" style="color: var(--info-color);"></i>
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
                            <i class="fas fa-tasks" style="color: var(--warning-color);"></i>
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
                            <i class="fas fa-lock" style="color: var(--success-color);"></i>
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