@extends('layouts.app')

@section('title', 'Login - Perpustakaan')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Login</h2>
            <p>Masuk ke akun perpustakaan Anda</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="form-control @error('email') is-invalid @enderror">
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember">
                    <span>Ingat saya</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>

        <div class="auth-footer">
            <p class="text-muted">Demo Accounts:</p>
            <p class="text-small">Admin: admin@library.com / admin123</p>
            <p class="text-small">Member: member@library.com / member123</p>
        </div>
    </div>
</div>
@endsection
