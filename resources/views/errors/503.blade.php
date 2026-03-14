<!-- resources/views/errors/503.blade.php -->
@extends('layouts.app')

@section('title', 'Maintenance Mode - Shifra')
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
        animation: wrench 2s infinite;
    }
    @keyframes wrench {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(-15deg); }
        75% { transform: rotate(15deg); }
    }
    .maintenance-info {
        background: #fffbeb;
        border: 1px solid #fde68a;
        padding: 20px;
        border-radius: 10px;
        margin: 20px auto;
        max-width: 500px;
    }
    .countdown {
        font-size: 24px;
        font-weight: 700;
        color: #d97706;
        margin: 10px 0;
    }
</style>
@endsection

@section('content')
<div class="error-container">
    <div>
        <div class="error-icon">
            <i class="fas fa-tools"></i>
        </div>
        <h1 class="error-code">503</h1>
        <h2 class="error-message">Under Maintenance</h2>
        
        <div class="maintenance-info">
            <p><i class="fas fa-clock"></i> <strong>Scheduled Maintenance</strong></p>
            <p>We're performing scheduled maintenance to improve your experience.</p>
            <div class="countdown" id="countdown">
                Estimated time: <span id="hours">02</span>:<span id="minutes">00</span>
            </div>
            <p style="font-size: 12px; margin-top: 5px;">Check back soon!</p>
        </div>
        
        <a href="{{ route('home') }}" class="btn-go-home" style="background: #f59e0b;">Refresh Status</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Simulated countdown
        let hours = 2;
        let minutes = 0;
        
        const updateCountdown = () => {
            const hoursEl = document.getElementById('hours');
            const minutesEl = document.getElementById('minutes');
            
            hoursEl.textContent = hours.toString().padStart(2, '0');
            minutesEl.textContent = minutes.toString().padStart(2, '0');
        };
        
        updateCountdown();
        
        // Auto-refresh every 5 minutes
        setTimeout(() => {
            window.location.reload();
        }, 300000); // 5 minutes
    });
</script>
@endsection