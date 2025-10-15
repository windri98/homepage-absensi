@extends('layouts.app')

@section('title', 'Sign In - AttendanceHub')

@section('styles')
<style>
    .auth-container {
        padding: 2rem 1.5rem;
        min-height: calc(100vh - 44px);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .auth-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .auth-logo {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        border-radius: var(--radius-xl);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: var(--shadow-lg);
    }

    .auth-logo i {
        font-size: 2rem;
        color: white;
    }

    .auth-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
    }

    .auth-subtitle {
        font-size: 1rem;
        color: var(--gray-600);
        font-weight: 400;
    }

    .auth-form {
        background: white;
        border-radius: var(--radius-xl);
        padding: 2rem;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--gray-100);
    }

    .form-group {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .form-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-400);
        z-index: 1;
    }

    .form-input {
        padding-left: 3rem;
        height: 3rem;
        border: 2px solid var(--gray-200);
        transition: all 0.3s ease;
    }

    .form-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        transform: translateY(-1px);
    }

    .auth-button {
        width: 100%;
        height: 3rem;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .auth-button:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .auth-button:active {
        transform: translateY(0);
    }

    .auth-link {
        text-align: center;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--gray-200);
    }

    .auth-link a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .auth-link a:hover {
        color: var(--primary-dark);
    }

    .demo-accounts {
        background: var(--gray-50);
        border-radius: var(--radius-md);
        padding: 1rem;
        margin-top: 1.5rem;
        border: 1px solid var(--gray-200);
    }

    .demo-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.75rem;
        text-align: center;
    }

    .demo-account {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem;
        background: white;
        border-radius: var(--radius-sm);
        margin-bottom: 0.5rem;
        font-size: 0.8125rem;
        border: 1px solid var(--gray-200);
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .demo-account:hover {
        background: var(--primary-color);
        color: white;
        transform: translateX(4px);
    }

    .demo-account:last-child {
        margin-bottom: 0;
    }

    .demo-role {
        font-weight: 600;
    }

    .demo-email {
        color: var(--gray-600);
        font-size: 0.75rem;
    }

    .demo-account:hover .demo-email {
        color: rgba(255, 255, 255, 0.8);
    }

    .floating-shapes {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: -1;
    }

    .shape {
        position: absolute;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(79, 70, 229, 0.1) 100%);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .shape:nth-child(1) {
        width: 100px;
        height: 100px;
        top: 10%;
        left: 10%;
        animation-delay: 0s;
    }

    .shape:nth-child(2) {
        width: 150px;
        height: 150px;
        top: 70%;
        right: 10%;
        animation-delay: 2s;
    }

    .shape:nth-child(3) {
        width: 80px;
        height: 80px;
        top: 40%;
        left: 80%;
        animation-delay: 4s;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }
</style>
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