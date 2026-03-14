@extends('layouts.guest')

@section('title', 'Shifra - Reset Password')

@section('content')
    <div class="auth-box">
        <div class="auth-logo-icon">
            <img src="{{ asset('images/logo-icon.jpeg') }}" alt="Logo">
        </div>
        <h1 class="auth-heading">Reset Password</h1>
        <p class="auth-subheading">Enter your new password below</p>

        <form method="POST" action="{{ route('password.store') }}" class="auth-form">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            
            <div class="input-field">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="input-field">
                <label>New Password</label>
                <input type="password" name="password" placeholder="Enter new password" required>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="input-field">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Confirm new password" required>
            </div>
            
            <button type="submit" class="btn-navy">Reset Password</button>
        </form>

        <div class="auth-links">
            <p><a href="{{ route('login') }}">← Back to Login</a></p>
        </div>
    </div>
@endsection