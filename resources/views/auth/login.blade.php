@extends('layouts.app')

@section('title', 'Sign In - AttendanceHub')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ time() }} }}?v={{ time() }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}?v={{ time() }} }}?v={{ time() }}?v={{ time() }}">
@endsection

@section('content')
<div class="auth-container animate-fade-in">
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="auth-header">
        <div class="auth-logo animate-bounce">
            <i class="fas fa-clock"></i>
        </div>
        <h1 class="auth-title">Welcome Back</h1>
        <p class="auth-subtitle">Sign in to your AttendanceHub account</p>
    </div>

    <form action="{{ route('login') }}" method="POST" class="auth-form animate-slide-in">
        @csrf
        
        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ $errors->first() }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="form-group">
            <i class="form-icon fas fa-envelope"></i>
            <input 
                type="email" 
                name="email" 
                class="form-input" 
                placeholder="Enter your email"
                value="{{ old('email') }}"
                required
            >
        </div>

        <div class="form-group">
            <i class="form-icon fas fa-lock"></i>
            <input 
                type="password" 
                name="password" 
                class="form-input" 
                placeholder="Enter your password"
                required
            >
        </div>

        <button type="submit" class="auth-button">
            <span>Sign In</span>
        </button>

        <div class="demo-accounts">
            <div class="demo-title">Demo Accounts</div>
            <div class="demo-account" onclick="fillDemo('admin@example.com', 'password')">
                <div>
                    <div class="demo-role">Admin</div>
                    <div class="demo-email">admin@example.com</div>
                </div>
                <i class="fas fa-arrow-right"></i>
            </div>
            <div class="demo-account" onclick="fillDemo('manager@example.com', 'password')">
                <div>
                    <div class="demo-role">Manager</div>
                    <div class="demo-email">manager@example.com</div>
                </div>
                <i class="fas fa-arrow-right"></i>
            </div>
            <div class="demo-account" onclick="fillDemo('employee@example.com', 'password')">
                <div>
                    <div class="demo-role">Employee</div>
                    <div class="demo-email">employee@example.com</div>
                </div>
                <i class="fas fa-arrow-right"></i>
            </div>
        </div>

        <div class="auth-link">
            <span>Don't have an account? </span>
            <a href="{{ route('register') }}">Sign up here</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function fillDemo(email, password) {
    document.querySelector('input[name="email"]').value = email;
    document.querySelector('input[name="password"]').value = password;
    
    // Add visual feedback
    const button = document.querySelector('.auth-button');
    button.style.background = 'linear-gradient(135deg, var(--success-color) 0%, var(--secondary-dark) 100%)';
    button.innerHTML = '<i class="fas fa-check"></i> Ready to Sign In';
    
    setTimeout(() => {
        button.style.background = 'linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%)';
        button.innerHTML = '<span>Sign In</span>';
    }, 2000);
}

// Enhanced form submission
document.querySelector('.auth-form').addEventListener('submit', function(e) {
    const button = this.querySelector('.auth-button');
    button.innerHTML = '<div class="spinner"></div> Signing In...';
    button.disabled = true;
});
</script>
@endpush

