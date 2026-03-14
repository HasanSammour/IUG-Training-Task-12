@extends('layouts.guest')

@section('title', 'Shifra - Forgot Password')

@section('content')
    <div class="auth-box" id="forgotSection">
        <div class="auth-logo-icon">
            <img src="{{ asset('images/logo-icon.jpeg') }}" alt="Logo">
        </div>
        <h1 class="auth-heading">Forgot Password</h1>
        <p class="auth-subheading" style="color:#666; margin-bottom: 20px;">Enter your email address and we'll send you a link to reset your password</p>

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf
            <div class="input-field">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email address" required autofocus>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn-navy">Reset Password</button>
        </form>

        <div class="auth-links">
            <p><a href="{{ route('login') }}">← Back to Login</a></p>
        </div>
    </div>
@endsection