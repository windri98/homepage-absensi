@extends('layouts.app')

@section('title', 'Register - Sistem Absensi')

@php
    $includePopup = true;
@endphp

@section('styles')
.header {
    background: linear-gradient(135deg, #1ec7e6, #0ea5e9);
    color: white;
    text-align: center;
    padding: 50px 20px 30px 20px;
    position: relative;
}

.header h1 {
    font-size: 18px;
    font-weight: normal;
    letter-spacing: 1px;
    margin-top: 20px;
    line-height: 1.2;
}
.illustration {
    width: 100%;
    height: 180px;
    background-image: url('{{ asset('assets/image/register.png') }}');
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    margin: 20px 0;
}
.register-container {
    flex: 1;
    padding: 20px;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
}
.register-title {
    font-size: 32px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
    margin-top: 10px;
}
.input-group {
    position: relative;
    margin-bottom: 15px;
}
.input-group input {
    width: 100%;
    padding: 15px 45px 15px 15px;
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
.register-button {
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
.register-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(30, 199, 230, 0.4);
}
.login-link {
    text-align: center;
    color: #666;
    font-size: 14px;
    margin-top: 10px;
}
.login-link a {
    color: #1ec7e6;
    text-decoration: none;
    font-weight: 500;
}
.alert {
    background-color: #f8d7da;
    color: #721c24;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 15px;
    font-size: 14px;
}
.alert.success {
    background-color: #d4edda;
    color: #155724;
}
body {
    height: auto;
    min-height: 100vh;
}
@endsection

@section('content')
<div class="header">
    <h1>SISTEM ABSENSI<br>KARYAWAN</h1>
    <div class="illustration"></div>
</div>

<div class="register-container">
    <h2 class="register-title">Register</h2>
    
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

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="input-group">
            <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
            <div class="icon">👤</div>
        </div>
        
        <div class="input-group">
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <div class="icon">📧</div>
        </div>
        
        <div class="input-group">
            <input type="text" name="employee_id" placeholder="ID Karyawan (opsional)" value="{{ old('employee_id') }}">
            <div class="icon">🆔</div>
        </div>
        
        <div class="input-group">
            <input type="text" name="phone" placeholder="No. Telepon (opsional)" value="{{ old('phone') }}">
            <div class="icon">📞</div>
        </div>
        
        <div class="input-group">
            <input type="text" name="position" placeholder="Jabatan (opsional)" value="{{ old('position') }}">
            <div class="icon">💼</div>
        </div>
        
        <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
            <div class="icon">🔒</div>
        </div>
        
        <div class="input-group">
            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
            <div class="icon">🔐</div>
        </div>
        
        <button type="submit" class="register-button">Register</button>
    </form>
    
    <div class="login-link">
        Sudah punya akun? <a href="{{ route('login') }}">Login disini</a>
    </div>
</div>
@endsection