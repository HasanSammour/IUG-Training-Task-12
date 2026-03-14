@extends('layouts.app')

@section('title', (isset($course) ? $course->title . ' - ' : '') . 'Live Sessions')
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

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #2D3E50;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        color: #3182ce;
        background: rgba(49, 130, 206, 0.1);
        padding: 10px;
        border-radius: 12px;
    }

    .course-badge {
        background: #f1f5f9;
        color: #475569;
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
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

    .stat-icon.yellow {
        background: #fef3c7;
        color: #d97706;
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

    /* Filter Tabs */
    .filter-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        overflow-x: auto;
        padding-bottom: 5px;
        border-bottom: 1px solid #e2e8f0;
    }

    .filter-tab {
        padding: 10px 20px;
        border-radius: 30px;
        background: #f8fafc;
        color: #475569;
        font-size: 14px;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .filter-tab.active {
        background: #2D3E50;
        color: white;
        border-color: #2D3E50;
    }

    .filter-tab:hover:not(.active) {
        background: #e2e8f0;
        border-color: #94a3b8;
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

    .session-card.past {
        opacity: 0.8;
    }

    .session-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 15px;
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
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        margin-left: 8px;
    }

    .attended-yes {
        background: #dcfce7;
        color: #15803d;
    }

    .attended-no {
        background: #fee2e2;
        color: #b91c1c;
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

    .btn-primary:hover:not(:disabled) {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45,62,80,0.15);
    }

    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
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

    .btn-recording {
        background: #8b5cf6;
        color: white;
    }

    .btn-recording:hover {
        background: #7c3aed;
    }

    /* Empty State */
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

        .header-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .session-actions {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<div class="sessions-container">
    <!-- Header -->
    <div class="page-header">
        <a href="{{ route('courses.progress', $enrollment->id ?? '') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Back to Course
        </a>
        
        <div class="header-top">
            <h1 class="page-title">
                <i class="fas fa-video"></i>
                Live Sessions
            </h1>
            <div class="course-badge">
                <i class="fas fa-book"></i>
                {{ $course->title }}
            </div>
        </div>
        <p class="page-subtitle">Join live sessions and access recordings</p>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['total'] }}</span>
                <span class="stat-label">Total Sessions</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['upcoming'] }}</span>
                <span class="stat-label">Upcoming</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['attended'] }}</span>
                <span class="stat-label">Attended</span>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterSessions('all')" id="filterAll">All Sessions</button>
        <button class="filter-tab" onclick="filterSessions('upcoming')" id="filterUpcoming">Upcoming</button>
        <button class="filter-tab" onclick="filterSessions('past')" id="filterPast">Past</button>
        <button class="filter-tab" onclick="filterSessions('attended')" id="filterAttended">Attended</button>
    </div>

    <!-- Sessions Grid -->
    @if($sessions->count() > 0)
        <div class="sessions-grid" id="sessionsGrid">
            @foreach($sessions as $session)
                @php
                    $attendance = $session->attendance->first();
                    $isUpcoming = $session->start_time > now() && $session->status == 'scheduled';
                    $isPast = $session->start_time < now();
                    $isAttended = $attendance && $attendance->attended;
                    
                    $filterClass = '';
                    if ($isUpcoming) $filterClass = 'upcoming';
                    elseif ($isPast) $filterClass = 'past';
                    if ($isAttended) $filterClass .= ' attended';
                @endphp
                
                <div class="session-card {{ $isUpcoming ? 'upcoming' : 'past' }}" data-filter="{{ $filterClass }}">
                    <div>
                        <span class="session-status status-{{ $session->status }}">
                            {{ ucfirst($session->status) }}
                            @if($isAttended)
                                <span class="attended-badge attended-yes">
                                    <i class="fas fa-check-circle"></i> Attended
                                </span>
                            @elseif($isPast && $session->status == 'completed')
                                <span class="attended-badge attended-no">
                                    <i class="fas fa-times-circle"></i> Missed
                                </span>
                            @endif
                        </span>
                    </div>

                    <div class="session-time">
                        <i class="fas fa-calendar-alt"></i>
                        {{ \Carbon\Carbon::parse($session->start_time)->format('l, F d, Y') }}
                    </div>

                    <h3 class="session-title">{{ $session->title }}</h3>
                    
                    <p class="session-description">{{ Str::limit($session->description, 120) }}</p>

                    <div class="session-meta">
                        <span><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}</span>
                        @if($session->end_time)
                            <span><i class="fas fa-hourglass-end"></i> {{ \Carbon\Carbon::parse($session->end_time)->format('h:i A') }}</span>
                        @endif
                    </div>

                    <div class="session-actions">
                        @if($session->meeting_url && $isUpcoming)
                            <a href="{{ $session->meeting_url }}" target="_blank" class="btn-primary">
                                <i class="fas fa-video"></i> Join Session
                            </a>
                        @elseif($session->recording_url)
                            <a href="{{ $session->recording_url }}" target="_blank" class="btn-primary btn-recording">
                                <i class="fas fa-play-circle"></i> Watch Recording
                            </a>
                        @else
                            <a href="{{ route('courses.sessions.show', [$course->id, $session->id]) }}" class="btn-primary">
                                <i class="fas fa-info-circle"></i> View Details
                            </a>
                        @endif

                        <a href="{{ route('courses.sessions.show', [$course->id, $session->id]) }}" class="btn-secondary">
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
            <i class="fas fa-video"></i>
            <h3>No Sessions Scheduled</h3>
            <p>The instructor hasn't scheduled any live sessions for this course yet.</p>
            <a href="{{ route('courses.show', $course->slug) }}" class="btn-primary" style="display: inline-block; padding: 12px 30px;">
                <i class="fas fa-info-circle"></i> Course Details
            </a>
        </div>
    @endif
</div>

<script>
    function filterSessions(filter) {
        // Update active tab
        document.querySelectorAll('.filter-tab').forEach(btn => btn.classList.remove('active'));
        document.getElementById(`filter${filter.charAt(0).toUpperCase() + filter.slice(1)}`).classList.add('active');
        
        // Filter sessions
        const sessions = document.querySelectorAll('.session-card');
        sessions.forEach(session => {
            const filterClasses = session.dataset.filter || '';
            
            switch(filter) {
                case 'all':
                    session.style.display = 'block';
                    break;
                case 'upcoming':
                    session.style.display = filterClasses.includes('upcoming') ? 'block' : 'none';
                    break;
                case 'past':
                    session.style.display = filterClasses.includes('past') ? 'block' : 'none';
                    break;
                case 'attended':
                    session.style.display = filterClasses.includes('attended') ? 'block' : 'none';
                    break;
            }
        });
    }
</script>
@endsection