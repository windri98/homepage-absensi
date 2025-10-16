@extends('layouts.app')

@section('title', 'Register - Sistem Absensi')

@php
    $includePopup = true;
@endphp

@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}?v={{ time() }} }}?v={{ time() }}">
<link rel="stylesheet" href="{{ asset('assets/css/register.css') }}?v={{ time() }} }}?v={{ time() }}">
@endsection

@section('content')
<div class="header">
    <h1>SISTEM ABSENSI<br>KARYAWAN</h1>
    <div class="illustration register-bg"></div>
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

