@extends('layouts.app')

@section('title', 'Sign In - AttendanceHub')

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
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
    background-position: center;
    margin: 20px 0;
}
.login-container {
    flex: 1;
    padding: 20px;
    display: flex;
    flex-direction: column;
}
.login-title {
    font-size: 32px;
    font-weight: bold;
    color: #333;
    margin-bottom: 30px;
    margin-top: 10px;
}
.input-group {
    position: relative;
    margin-bottom: 20px;
}
.input-group input {
    width: 100%;
    padding: 18px 50px 18px 18px;
    border: none;
    border-radius: 25px;
    background-color: #e5e5e5;
    font-size: 16px;
    color: #666;
}
.input-group input::placeholder {
    color: #999;
}
.input-group input:focus {
    outline: none;
    background-color: #ddd;
}
.input-group .icon {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    opacity: 0.6;
}
.login-button {
    background: linear-gradient(135deg, #1ec7e6, #0ea5e9);
    color: white;
    border: none;
    padding: 18px;
    border-radius: 25px;
    font-size: 18px;
    font-weight: 500;
    cursor: pointer;
    margin: 20px 0;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(30, 199, 230, 0.3);
}
.login-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(30, 199, 230, 0.4);
}
.register-link {
    text-align: center;
    color: #666;
    font-size: 14px;
    margin-top: 20px;
}
.register-link a {
    color: #1ec7e6;
    text-decoration: none;
    font-weight: 500;
}
.alert {
    background-color: #f8d7da;
    color: #721c24;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 14px;
}
.alert.success {
    background-color: #d4edda;
    color: #155724;
}
@endsection

@section('content')
<div class="header">
    <h1>SISTEM ABSENSI<br>KARYAWAN</h1>
    <div class="illustration"></div>
</div>

<div class="login-container">
    <h2 class="login-title">Login</h2>
    
    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert">
            @foreach($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="input-group">
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <div class="icon">📧</div>
        </div>
        
        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
            <div class="icon">🔒</div>
        </div>
        
        <button type="submit" class="login-button">Login</button>
    </form>
    
    <div class="register-link">
        Belum punya akun? <a href="{{ route('register') }}">Daftar disini</a>
    </div>
</div>
@endsection