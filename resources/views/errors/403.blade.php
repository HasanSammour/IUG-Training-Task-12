@extends('layouts.app')

@section('title', 'Forbidden - Shifra')
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
        color: #ef4444;
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
    .role-info {
        background: #f8fafc;
        padding: 20px;
        border-radius: 10px;
        margin: 20px auto;
        max-width: 500px;
    }
</style>
@endsection

@section('content')
<div class="error-container">
    <div>
        <div class="error-icon">
            <i class="fas fa-ban"></i>
        </div>
        <h1 class="error-code">403</h1>
        <h2 class="error-message">Access Forbidden</h2>
        <p>You don't have permission to access this page.</p>
        
        @auth
            <div class="role-info">
                <p><strong>Your Role:</strong> 
                    @if(auth()->user()->hasRole('admin'))
                        <span class="badge bg-primary">Administrator</span>
                    @elseif(auth()->user()->hasRole('instructor'))
                        <span class="badge bg-success">Instructor</span>
                    @else
                        <span class="badge bg-purple">Student</span>
                    @endif
                </p>
                <p><strong>Action Required:</strong> Contact administrator for access.</p>
            </div>
            
            <a href="{{ auth()->user()->hasRole('admin') ? route('admin.dashboard') : (auth()->user()->hasRole('instructor') ? route('instructor.dashboard') : route('dashboard')) }}" class="btn-go-home">
                Go to Dashboard
            </a>
        @else
            <a href="{{ route('home') }}" class="btn-go-home">Go Home</a>
        @endauth
    </div>
</div>
@endsection