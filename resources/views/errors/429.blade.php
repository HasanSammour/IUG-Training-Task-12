@extends('layouts.app')

@section('title', 'Too Many Requests - Shifra')
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
    .timer-info {
        background: #fef2f2;
        padding: 15px;
        border-radius: 8px;
        margin: 20px auto;
        max-width: 400px;
    }
</style>
@endsection

@section('content')
<div class="error-container">
    <div>
        <div class="error-icon">
            <i class="fas fa-tachometer-alt"></i>
        </div>
        <h1 class="error-code">429</h1>
        <h2 class="error-message">Too Many Requests</h2>
        <p>You've sent too many requests in a short time. Please wait and try again.</p>
        
        <div class="timer-info">
            <p><i class="fas fa-clock"></i> Try again in <strong>1-2 minutes</strong></p>
            <p style="font-size: 12px; margin-top: 5px;">This protects our platform from abuse.</p>
        </div>
        
        <a href="{{ route('home') }}" class="btn-go-home">Go Home</a>
        <button onclick="window.location.reload()" class="btn-go-home" style="margin-left: 10px; background: #718096;">
            <i class="fas fa-redo"></i> Try Again
        </button>
    </div>
</div>
@endsection