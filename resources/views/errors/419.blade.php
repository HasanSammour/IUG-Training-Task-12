@extends('layouts.app')

@section('title', 'Session Expired - Shifra')
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
    .auto-redirect {
        margin-top: 20px;
        color: #94a3b8;
        font-size: 14px;
    }
</style>
@endsection

@section('content')
<div class="error-container">
    <div>
        <div class="error-icon">
            <i class="fas fa-hourglass-half"></i>
        </div>
        <h1 class="error-code">419</h1>
        <h2 class="error-message">Session Expired</h2>
        <p>Your session has timed out. Please login again to continue.</p>
        
        <a href="{{ route('login') }}" class="btn-go-home">Login Again</a>
        <a href="{{ route('home') }}" class="btn-go-home" style="margin-left: 10px; background: #718096;">Go Home</a>
        
        <div class="auto-redirect" id="countdown">
            Redirecting to login in <span id="seconds">10</span> seconds...
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let seconds = 10;
        const countdownElement = document.getElementById('seconds');
        
        const countdown = setInterval(function() {
            seconds--;
            countdownElement.textContent = seconds;
            
            if (seconds <= 0) {
                clearInterval(countdown);
                window.location.href = '{{ route("login") }}';
            }
        }, 1000);
    });
</script>
@endsection