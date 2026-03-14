@extends('layouts.guest')

@section('title', 'Shifra - Login')

@section('content')
    <div class="auth-box" id="loginSection">
        <div class="auth-logo-icon">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo-icon.jpeg') }}" alt="Logo">
            </a>
        </div>
        <h1 class="auth-heading">Welcome Back</h1>
        <p class="auth-subheading">Sign in to continue your learning</p>

        <form method="POST" action="{{ route('login') }}" id="loginForm" class="auth-form">
            @csrf
            
            <div class="input-field">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                       placeholder="Enter your email" required autofocus>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="input-field">
                <label>Password</label>
                <input type="password" name="password" 
                       placeholder="Enter your password" required>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        
            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember">
                    Remember me
                </label>
                <a href="{{ route('password.request') }}" class="forgot-pass">Forgot Password?</a>
            </div>
        
            <button type="submit" class="btn-navy">Login</button>
        </form>

        <div class="social-auth">
            <button type="button" class="social-btn google" onclick="alert('Google login coming soon!')">
                <i class="fab fa-google"></i> Continue With Google
            </button>
            <button type="button" class="social-btn facebook" onclick="alert('Facebook login coming soon!')">
                <i class="fab fa-facebook-f"></i> Continue With Facebook
            </button>
        </div>

        <div class="auth-links">
            <p>Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p>
        </div>
    </div>
@endsection