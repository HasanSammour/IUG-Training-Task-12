@extends('layouts.app')

@section('title', 'Server Error - Shifra')
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
        color: #dc2626;
        margin-bottom: 20px;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    .error-code {
        font-size: 48px;
        font-weight: 700;
        color: #2D3E50;
        margin-bottom: 10px;
    }
    .contact-support {
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
            <i class="fas fa-server"></i>
        </div>
        <h1 class="error-code">500</h1>
        <h2 class="error-message">Internal Server Error</h2>
        <p>Something went wrong on our end. We're working to fix it.</p>
        
        <div class="contact-support">
            <p><i class="fas fa-life-ring"></i> <strong>Need Help?</strong></p>
            <p>Contact support at: <a href="mailto:support@shifra.com">support@shifra.com</a></p>
        </div>
        
        <a href="{{ route('home') }}" class="btn-go-home">Go Home</a>
        <button onclick="window.location.reload()" class="btn-go-home" style="margin-left: 10px; background: #718096;">
            <i class="fas fa-redo"></i> Refresh
        </button>
    </div>
</div>
@endsection