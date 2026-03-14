@extends('layouts.app')

@section('title', 'Upcoming Sessions')
@section('body-class', 'auth-page')

@section('styles')
<style>
    .sessions-container {
        padding: 30px 40px;
        max-width: 1400px;
        margin: 0 auto;
        padding-bottom: 100px;
    }

    /* Header */
    .page-header {
        margin-bottom: 30px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 15px;
        transition: color 0.3s ease;
    }

    .back-link:hover {
        color: #2D3E50;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #2D3E50;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
    }

    .page-title i {
        color: #3182ce;
        background: rgba(49, 130, 206, 0.1);
        padding: 10px;
        border-radius: 12px;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 16px;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border-color: #2D3E50;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-icon.blue {
        background: #dbeafe;
        color: #2563eb;
    }

    .stat-icon.green {
        background: #dcfce7;
        color: #16a34a;
    }

    .stat-icon.purple {
        background: #f3e8ff;
        color: #9333ea;
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        display: block;
        font-size: 28px;
        font-weight: 700;
        color: #2D3E50;
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Sessions Grid */
    .sessions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .session-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .session-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        border-color: #2D3E50;
    }

    .session-card.upcoming {
        border-left: 4px solid #0284c7;
    }

    .session-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .session-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
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

    .course-badge-small {
        background: #e2e8f0;
        color: #475569;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .course-badge-small i {
        font-size: 10px;
        color: #64748b;
    }

    .session-time {
        font-size: 14px;
        color: #2D3E50;
        font-weight: 600;
        margin: 15px 0 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .session-time i {
        color: #64748b;
    }

    .session-title {
        font-size: 18px;
        color: #2D3E50;
        margin-bottom: 10px;
        font-weight: 600;
        line-height: 1.4;
    }

    .session-description {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .session-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        font-size: 12px;
        color: #64748b;
    }

    .session-meta i {
        margin-right: 5px;
        color: #94a3b8;
    }

    .session-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-primary {
        flex: 1;
        padding: 12px;
        background: #2D3E50;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-primary:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45,62,80,0.15);
    }

    .btn-secondary {
        flex: 1;
        padding: 12px;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
        border-color: #2D3E50;
        color: #2D3E50;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 20px;
        color: #2D3E50;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #64748b;
        margin-bottom: 25px;
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 30px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sessions-container {
            padding: 20px;
        }

        .session-actions {
            flex-direction: column;
        }

        .session-header {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<div class="sessions-container">
    <div class="page-header">
        <a href="{{ route('learning-path.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Back to Learning Path
        </a>
        
        <h1 class="page-title">
            <i class="fas fa-calendar-alt"></i>
            Upcoming Sessions
        </h1>
        <p class="page-subtitle">All your upcoming live sessions across all courses</p>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $sessions->total() }}</span>
                <span class="stat-label">Total Upcoming</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $sessions->count() }}</span>
                <span class="stat-label">This Page</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-video"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $sessions->where('meeting_url', '!=', null)->count() }}</span>
                <span class="stat-label">With Meeting</span>
            </div>
        </div>
    </div>

    <!-- Sessions Grid -->
    @if($sessions->count() > 0)
        <div class="sessions-grid">
            @foreach($sessions as $session)
                @php
                    $isUpcoming = $session->start_time > now();
                @endphp
                
                <div class="session-card {{ $isUpcoming ? 'upcoming' : '' }}">
                    <div class="session-header">
                        <span class="session-status status-{{ $session->status }}">
                            {{ ucfirst($session->status) }}
                        </span>
                        <span class="course-badge-small">
                            <i class="fas fa-book"></i>
                            {{ $session->course->title }}
                        </span>
                    </div>

                    <div class="session-time">
                        <i class="fas fa-calendar-alt"></i>
                        {{ \Carbon\Carbon::parse($session->start_time)->format('l, F d, Y - h:i A') }}
                    </div>

                    <h3 class="session-title">{{ $session->title }}</h3>
                    
                    <p class="session-description">{{ Str::limit($session->description, 100) }}</p>

                    <div class="session-meta">
                        <span><i class="fas fa-clock"></i> Duration: 
                            @if($session->end_time)
                                {{ \Carbon\Carbon::parse($session->start_time)->diffInMinutes($session->end_time) }} min
                            @else
                                60 min
                            @endif
                        </span>
                        @if($session->meeting_url)
                            <span><i class="fas fa-video"></i> Live Session</span>
                        @endif
                    </div>

                    <div class="session-actions">
                        @if($session->meeting_url && $isUpcoming)
                            <a href="{{ $session->meeting_url }}" target="_blank" class="btn-primary">
                                <i class="fas fa-video"></i> Join Now
                            </a>
                        @endif
                        <a href="{{ route('courses.sessions.show', [$session->course_id, $session->id]) }}" class="btn-secondary">
                            <i class="fas fa-info-circle"></i> Details
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $sessions->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-calendar-times"></i>
            <h3>No Upcoming Sessions</h3>
            <p>You don't have any upcoming live sessions at the moment.</p>
            <a href="{{ route('learning-path.index') }}" class="btn-primary" style="display: inline-block; padding: 12px 30px;">
                <i class="fas fa-arrow-left"></i>
                Back to Learning Path
            </a>
        </div>
    @endif
</div>
@endsection