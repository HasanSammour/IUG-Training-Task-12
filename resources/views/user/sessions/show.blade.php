@extends('layouts.app')

@section('title', $session->title . ' - Session Details')
@section('body-class', 'auth-page')

@section('styles')
<style>
    .session-detail-container {
        padding: 30px 40px;
        max-width: 1000px;
        margin: 0 auto;
        padding-bottom: 100px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 20px;
        transition: color 0.3s ease;
    }

    .back-link:hover {
        color: #2D3E50;
    }

    .session-card {
        background: white;
        border-radius: 24px;
        padding: 40px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .session-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .session-status {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-scheduled {
        background: #fef3c7;
        color: #92400e;
    }

    .status-ongoing {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-completed {
        background: #dcfce7;
        color: #15803d;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #b91c1c;
    }

    .attended-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        margin-left: 10px;
    }

    .attended-yes {
        background: #dcfce7;
        color: #15803d;
    }

    .attended-no {
        background: #fee2e2;
        color: #b91c1c;
    }

    .session-title {
        font-size: 32px;
        color: #2D3E50;
        margin-bottom: 20px;
        font-weight: 700;
    }

    .session-meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
        padding: 25px;
        background: #f8fafc;
        border-radius: 16px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .meta-icon {
        width: 45px;
        height: 45px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2D3E50;
        font-size: 18px;
    }

    .meta-content {
        flex: 1;
    }

    .meta-label {
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .meta-value {
        font-size: 16px;
        font-weight: 600;
        color: #2D3E50;
    }

    .session-description {
        margin-bottom: 30px;
        padding: 25px;
        background: #f8fafc;
        border-radius: 16px;
        border-left: 4px solid #3182ce;
    }

    .description-title {
        font-size: 16px;
        font-weight: 600;
        color: #2D3E50;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .description-title i {
        color: #3182ce;
    }

    .description-text {
        color: #475569;
        font-size: 15px;
        line-height: 1.7;
        white-space: pre-wrap;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }

    .btn-primary {
        flex: 1;
        padding: 14px 25px;
        background: #2D3E50;
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-primary:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45,62,80,0.15);
    }

    .btn-recording {
        background: #8b5cf6;
    }

    .btn-recording:hover {
        background: #7c3aed;
    }

    .btn-secondary {
        flex: 1;
        padding: 14px 25px;
        background: white;
        color: #475569;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #2D3E50;
        color: #2D3E50;
    }

    .attendance-note {
        margin-top: 25px;
        padding: 15px;
        background: #f0f9ff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #0369a1;
        font-size: 14px;
    }

    .attendance-note i {
        font-size: 18px;
    }

    @media (max-width: 768px) {
        .session-detail-container {
            padding: 20px;
        }

        .session-card {
            padding: 25px;
        }

        .session-title {
            font-size: 24px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .session-meta-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="session-detail-container">
    <a href="{{ route('courses.sessions.index', $course->id) }}" class="back-link">
        <i class="fas fa-arrow-left"></i>
        Back to All Sessions
    </a>

    <div class="session-card">
        <div class="session-header">
            <div>
                <span class="session-status status-{{ $session->status }}">
                    {{ ucfirst($session->status) }}
                </span>
                @if($attendance && $attendance->attended)
                    <span class="attended-badge attended-yes">
                        <i class="fas fa-check-circle"></i> You Attended This Session
                    </span>
                @elseif($session->start_time < now() && $session->status == 'completed')
                    <span class="attended-badge attended-no">
                        <i class="fas fa-times-circle"></i> You Missed This Session
                    </span>
                @endif
            </div>
            
            @if($session->status == 'cancelled')
                <span style="background: #fee2e2; color: #b91c1c; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                    This session was cancelled
                </span>
            @endif
        </div>

        <h1 class="session-title">{{ $session->title }}</h1>

        <div class="session-meta-grid">
            <div class="meta-item">
                <div class="meta-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="meta-content">
                    <div class="meta-label">Date</div>
                    <div class="meta-value">{{ \Carbon\Carbon::parse($session->start_time)->format('l, F d, Y') }}</div>
                </div>
            </div>

            <div class="meta-item">
                <div class="meta-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="meta-content">
                    <div class="meta-label">Time</div>
                    <div class="meta-value">
                        {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}
                        @if($session->end_time)
                            - {{ \Carbon\Carbon::parse($session->end_time)->format('h:i A') }}
                        @endif
                    </div>
                </div>
            </div>

            @if($session->meeting_url)
                <div class="meta-item">
                    <div class="meta-icon">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="meta-content">
                        <div class="meta-label">Platform</div>
                        <div class="meta-value">
                            @if(str_contains($session->meeting_url, 'zoom'))
                                Zoom Meeting
                            @elseif(str_contains($session->meeting_url, 'meet.google'))
                                Google Meet
                            @else
                                Online Meeting
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if($session->recording_url)
                <div class="meta-item">
                    <div class="meta-icon">
                        <i class="fas fa-play-circle"></i>
                    </div>
                    <div class="meta-content">
                        <div class="meta-label">Recording</div>
                        <div class="meta-value">Available</div>
                    </div>
                </div>
            @endif
        </div>

        @if($session->description)
            <div class="session-description">
                <h3 class="description-title">
                    <i class="fas fa-align-left"></i>
                    Session Description
                </h3>
                <div class="description-text">{{ $session->description }}</div>
            </div>
        @endif

        <div class="action-buttons">
            @if($canJoin)
                <a href="{{ $session->meeting_url }}" target="_blank" class="btn-primary">
                    <i class="fas fa-video"></i>
                    Join Session Now
                </a>
            @elseif($session->recording_url)
                <a href="{{ $session->recording_url }}" target="_blank" class="btn-primary btn-recording">
                    <i class="fas fa-play-circle"></i>
                    Watch Recording
                </a>
            @elseif($session->status == 'cancelled')
                <button class="btn-primary" disabled style="opacity: 0.5;">
                    <i class="fas fa-times-circle"></i>
                    Session Cancelled
                </button>
            @elseif($attendance && $attendance->attended)
                <button class="btn-primary" disabled style="background: #10b981;">
                    <i class="fas fa-check-circle"></i>
                    You Attended This Session
                </button>
            @elseif($session->start_time < now())
                <button class="btn-primary" disabled>
                    <i class="fas fa-clock"></i>
                    Session Ended
                </button>
            @endif

            <a href="{{ route('courses.show', $course->slug) }}" class="btn-secondary">
                <i class="fas fa-book"></i>
                Course Page
            </a>
        </div>

        @if($attendance && $attendance->instructor_notes)
            <div class="attendance-note">
                <i class="fas fa-sticky-note"></i>
                <strong>Instructor Note:</strong> {{ $attendance->instructor_notes }}
            </div>
        @endif

        @if($canJoin)
            <div class="attendance-note">
                <i class="fas fa-info-circle"></i>
                <strong>Note:</strong> Attendance will be marked automatically when you join the session.
            </div>
        @endif
    </div>
</div>
@endsection