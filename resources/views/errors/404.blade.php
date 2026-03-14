@extends('layouts.app')

@section('title', 'Page Not Found - Shifra')
@section('body-class', 'public-page')

@section('styles')
<style>
    .error-container {
        min-height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        text-align: center;
    }

    .error-content {
        max-width: 600px;
        margin: 0 auto;
    }

    .error-code {
        font-size: 120px;
        font-weight: 900;
        color: #2D3E50;
        line-height: 1;
        margin-bottom: 20px;
        opacity: 0.1;
        position: relative;
    }

    .error-code::after {
        content: '404';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        font-size: 60px;
        color: #ef4444;
        opacity: 1;
        z-index: 1;
    }

    .error-title {
        font-size: 32px;
        color: #2D3E50;
        margin-bottom: 15px;
        font-weight: 700;
    }

    .error-message {
        font-size: 16px;
        color: #718096;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .error-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 30px;
    }

    .btn-error {
        padding: 12px 28px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-error-primary {
        background: #2D3E50;
        color: white;
        border: 2px solid #2D3E50;
    }

    .btn-error-primary:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
    }

    .btn-error-secondary {
        background: transparent;
        color: #2D3E50;
        border: 2px solid #e2e8f0;
    }

    .btn-error-secondary:hover {
        background: #f8fafc;
        border-color: #2D3E50;
        transform: translateY(-2px);
    }

    @media (max-width: 640px) {
        .error-code {
            font-size: 80px;
        }
        
        .error-code::after {
            font-size: 40px;
        }
        
        .error-title {
            font-size: 24px;
        }
        
        .error-actions {
            flex-direction: column;
        }
        
        .btn-error {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
    <div class="error-container">
        <div class="error-content">
            <div class="error-code">404</div>
            
            <h1 class="error-title">Page Not Found</h1>
            
            <p class="error-message">
                Oops! The page you're looking for doesn't exist or has been moved.
                @auth
                    @if(auth()->user()->hasRole('admin'))
                        You can return to the admin dashboard or browse available courses.
                    @elseif(auth()->user()->hasRole('instructor'))
                        You can return to your instructor dashboard or browse available courses.
                    @else
                        You can return to your dashboard or browse available courses.
                    @endif
                @else
                    You can return to the homepage or browse our available courses.
                @endauth
            </p>
            
            <div class="error-actions">
                @auth
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="btn-error btn-error-primary">
                            <i class="fas fa-tachometer-alt"></i> Admin Dashboard
                        </a>
                    @elseif(auth()->user()->hasRole('instructor'))
                        <a href="{{ route('instructor.dashboard') }}" class="btn-error btn-error-primary">
                            <i class="fas fa-chalkboard-teacher"></i> Instructor Dashboard
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn-error btn-error-primary">
                            <i class="fas fa-home"></i> Student Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('home') }}" class="btn-error btn-error-primary">
                        <i class="fas fa-home"></i> Back to Home
                    </a>
                @endauth
                
                <a href="{{ route('courses.public') }}" class="btn-error btn-error-secondary">
                    <i class="fas fa-book-open"></i> Browse Courses
                </a>
                
                @auth
                    @if(!auth()->user()->hasRole(['admin', 'instructor']))
                        <a href="{{ route('learning-path.index') }}" class="btn-error btn-error-secondary">
                            <i class="fas fa-route"></i> My Learning Path
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
@endsection