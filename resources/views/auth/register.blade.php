@extends('layouts.guest')

@section('title', 'Shifra - Register')

@section('content')
    <div class="auth-box" id="signupSection">
        <div class="auth-logo-icon">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logo-icon.jpeg') }}" alt="Logo">
            </a>
        </div>
        <h1 class="auth-heading">Create Account</h1>
        <p class="auth-subheading">Join Shifra and start your learning journey</p>

        <form method="POST" action="{{ route('register') }}" id="registerForm" class="auth-form">
            @csrf

            <div class="input-row">
                <div class="input-field">
                    <label>First Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="First Name" required autofocus>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-field">
                    <label>Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" required>
                    @error('last_name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="input-field">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-field">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="input-field">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Confirm your password" required>
            </div>

            <div class="terms-check">
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">I agree to the Terms and Privacy Policy</label>
                @error('terms')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-navy">Sign Up</button>
        </form>

        <div class="divider"><span>Or sign up with</span></div>

        <div class="social-auth-row">
            <button type="button" class="social-btn-small" onclick="alert('Google signup coming soon!')">
                <i class="fab fa-google"></i> Google
            </button>
            <button type="button" class="social-btn-small" onclick="alert('Facebook signup coming soon!')">
                <i class="fab fa-facebook-f"></i> Facebook
            </button>
        </div>

        <div class="auth-links">
            <p>Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>
        </div>
    </div>
@endsection