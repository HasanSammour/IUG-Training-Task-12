@extends('layouts.guest')

@section('title', 'Verify Email - Shifra')

@section('content')
<div class="auth-box">
    <div class="auth-logo-icon">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo-icon.jpeg') }}" alt="Logo">
        </a>
    </div>
    
    <h1 class="auth-heading">Verify Your Email</h1>
    
    <div class="alert" style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 12px; padding: 20px; margin-bottom: 25px; text-align: left;">
        <p style="color: #0369a1; margin-bottom: 10px; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-info-circle" style="font-size: 20px;"></i>
            <strong style="font-size: 16px;">Thanks for signing up!</strong>
        </p>
        <p style="color: #0284c7; font-size: 14px; line-height: 1.6; margin-bottom: 15px;">
            Before getting started, could you verify your email address by clicking on the link we just emailed to you? 
            If you didn't receive the email, we will gladly send you another.
        </p>
        
        @if (session('status') == 'verification-link-sent')
            <div style="background: #dcfce7; border: 1px solid #86efac; border-radius: 8px; padding: 12px; margin-top: 10px;">
                <p style="color: #166534; font-size: 13px; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-check-circle"></i>
                    A new verification link has been sent to the email address you provided during registration.
                </p>
            </div>
        @endif
    </div>

    <div style="background: #f8fafc; border-radius: 16px; padding: 25px; margin-bottom: 25px;">
        <h3 style="color: #2D3E50; font-size: 16px; margin-bottom: 15px; font-weight: 600;">
            <i class="fas fa-envelope" style="color: #3182ce; margin-right: 8px;"></i>
            Verification Email Sent To:
        </h3>
        <p style="background: white; padding: 12px; border-radius: 8px; border: 1px solid #e2e8f0; color: #2D3E50; font-weight: 500; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-user-circle" style="color: #94a3b8;"></i>
            {{ auth()->user()->email }}
        </p>
        
        <!-- Debug Info - Shows in laravel.log -->
        <div style="background: #fff3cd; border: 1px solid #ffeeba; border-radius: 8px; padding: 15px; margin-top: 20px;">
            <p style="color: #856404; font-size: 13px; margin-bottom: 8px; display: flex; align-items: center; gap: 5px;">
                <i class="fas fa-flask"></i>
                <strong>Development Mode:</strong>
            </p>
            <p style="color: #856404; font-size: 12px; line-height: 1.5;">
                📝 Check <code style="background: #fff; padding: 2px 6px; border-radius: 4px;">storage/logs/laravel.log</code> 
                for the verification link (emails are logged, not sent).
            </p>
        </div>
    </div>

    <div style="display: flex; gap: 15px; flex-direction: column;">
        <form method="POST" action="{{ route('verification.send') }}" style="width: 100%;">
            @csrf
            <button type="submit" class="btn-navy" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                <i class="fas fa-paper-plane"></i>
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
            @csrf
            <button type="submit" style="width: 100%; padding: 14px; background: white; color: #64748b; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.3s ease;">
                <i class="fas fa-sign-out-alt"></i>
                Log Out
            </button>
        </form>
    </div>

    <div class="auth-links" style="margin-top: 25px;">
        <p style="color: #94a3b8; font-size: 13px;">
            <i class="fas fa-shield-alt"></i>
            Your email is safe with us. We'll never share it with anyone.
        </p>
    </div>
</div>
@endsection