@extends('layouts.app')

@section('title', 'Unauthorized Access - Shifra')
@section('body-class', 'error-page')

@section('styles')
<style>
    .error-container {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px 20px;
    }
    .error-icon {
        font-size: 80px;
        color: #f59e0b;
        margin-bottom: 20px;
    }
    .error-code {
        font-size: 48px;
        font-weight: 700;
        color: #2D3E50;
        margin-bottom: 10px;
    }
    .error-message {
        font-size: 20px;
        color: #718096;
        margin-bottom: 30px;
    }
    .btn-go-home {
        background: #2D3E50;
        color: white;
        padding: 12px 30px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-block;
    }
    .btn-go-home:hover {
        background: #1a252f;
        transform: translateY(-2px);
    }
</style>
@endsection

@section('content')
<div class="error-container">
    <div>
        <div class="error-icon">
            <i class="fas fa-lock"></i>
        </div>
        <h1 class="error-code">401</h1>
        <h2 class="error-message">Unauthorized Access</h2>
        <p>You don't have permission to access this page. Please login with appropriate credentials.</p>
        @auth
            <a href="{{ auth()->user()->hasRole('admin') ? route('admin.dashboard') : (auth()->user()->hasRole('instructor') ? route('instructor.dashboard') : route('dashboard')) }}" class="btn-go-home">
                Go to Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="btn-go-home">Login</a>
            <a href="{{ route('home') }}" class="btn-go-home" style="margin-left: 10px; background: #718096;">Go Home</a>
        @endauth
    </div>
</div>
@endsection