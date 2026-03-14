@extends('layouts.app')

@section('title', $course->title . ' - Assignments')
@section('body-class', 'auth-page')

@section('styles')
<style>
    .assignments-container {
        padding: 30px 40px;
        max-width: 1400px;
        margin: 0 auto;
        padding-bottom: 100px;
    }

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

    .assignments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .assignment-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .assignment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        border-color: #2D3E50;
    }

    .assignment-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .assignment-title {
        font-size: 18px;
        color: #2D3E50;
        font-weight: 600;
        margin: 0;
    }

    .assignment-points {
        background: #e2e8f0;
        color: #475569;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .assignment-description {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
        flex: 1;
    }

    .assignment-due {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px;
        background: #f8fafc;
        border-radius: 8px;
    }

    .assignment-due.urgent {
        background: #fee2e2;
        color: #b91c1c;
    }

    .assignment-due i {
        color: #94a3b8;
    }

    .assignment-due.urgent i {
        color: #b91c1c;
    }

    .submission-status {
        padding: 12px;
        border-radius: 8px;
        font-size: 13px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .status-not-started {
        background: #f1f5f9;
        color: #475569;
    }

    .status-submitted {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-graded {
        background: #dcfce7;
        color: #15803d;
    }

    .status-overdue {
        background: #fee2e2;
        color: #b91c1c;
    }

    .grade-display {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 16px;
        font-weight: 600;
    }

    .btn-primary {
        width: 100%;
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
    }

    .btn-view {
        width: 100%;
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

    .btn-view:hover {
        background: #e2e8f0;
        border-color: #2D3E50;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        grid-column: 1 / -1;
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

    @media (max-width: 768px) {
        .assignments-container {
            padding: 20px;
        }

        .header-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="assignments-container">
    <div class="page-header">
        <a href="{{ route('courses.progress', $enrollment->id ?? '') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Back to Course
        </a>
        
        <div class="header-top">
            <h1 class="page-title">
                <i class="fas fa-tasks"></i>
                Assignments
            </h1>
            <div class="course-badge">
                <i class="fas fa-book"></i>
                {{ $course->title }}
            </div>
        </div>
        <p class="page-subtitle">Submit your work and track your grades</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['total'] }}</span>
                <span class="stat-label">Total</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['submitted'] }}</span>
                <span class="stat-label">Submitted</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['graded'] }}</span>
                <span class="stat-label">Graded</span>
            </div>
        </div>
    </div>

    <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterAssignments('all')">All</button>
        <button class="filter-tab" onclick="filterAssignments('pending')">Pending</button>
        <button class="filter-tab" onclick="filterAssignments('submitted')">Submitted</button>
        <button class="filter-tab" onclick="filterAssignments('graded')">Graded</button>
    </div>

    @if($assignments->count() > 0)
        <div class="assignments-grid" id="assignmentsGrid">
            @foreach($assignments as $assignment)
                @php
                    $submission = $assignment->submissions->first();
                    $isSubmitted = !is_null($submission);
                    $isGraded = $isSubmitted && !is_null($submission->grade);
                    $isOverdue = $assignment->due_date && $assignment->due_date < now() && !$isSubmitted;
                    
                    $statusClass = 'not-started';
                    $statusText = 'Not Started';
                    
                    if ($isGraded) {
                        $statusClass = 'graded';
                        $statusText = 'Graded: ' . $submission->grade . '/' . $assignment->points;
                    } elseif ($isSubmitted) {
                        $statusClass = 'submitted';
                        $statusText = 'Submitted - Awaiting Grade';
                    } elseif ($isOverdue) {
                        $statusClass = 'overdue';
                        $statusText = 'Overdue';
                    }
                @endphp
                
                <div class="assignment-card" data-status="{{ $statusClass }}">
                    <div class="assignment-header">
                        <h3 class="assignment-title">{{ $assignment->title }}</h3>
                        <span class="assignment-points">{{ $assignment->points }} pts</span>
                    </div>
                    
                    <p class="assignment-description">{{ Str::limit($assignment->description, 120) }}</p>
                    
                    @if($assignment->due_date)
                        <div class="assignment-due {{ $isOverdue ? 'urgent' : '' }}">
                            <i class="fas fa-calendar-alt"></i>
                            Due: {{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') }}
                            @if($isOverdue)
                                <span>(Overdue)</span>
                            @endif
                        </div>
                    @endif
                    
                    <div class="submission-status status-{{ $statusClass }}">
                        <i class="fas fa-{{ $isGraded ? 'check-circle' : ($isSubmitted ? 'clock' : 'exclamation-circle') }}"></i>
                        {{ $statusText }}
                    </div>
                    
                    @if($isGraded)
                        <a href="{{ route('courses.assignments.show', [$course->id, $assignment->id]) }}" class="btn-view">
                            <i class="fas fa-eye"></i> View Feedback
                        </a>
                    @else
                        <a href="{{ route('courses.assignments.show', [$course->id, $assignment->id]) }}" class="btn-primary">
                            <i class="fas fa-{{ $isSubmitted ? 'edit' : 'upload' }}"></i>
                            {{ $isSubmitted ? 'Edit Submission' : 'Submit Assignment' }}
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $assignments->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-tasks"></i>
            <h3>No Assignments</h3>
            <p>The instructor hasn't created any assignments for this course yet.</p>
            <a href="{{ route('courses.show', $course->slug) }}" class="btn-primary" style="display: inline-block; padding: 12px 30px;">
                <i class="fas fa-info-circle"></i> Course Details
            </a>
        </div>
    @endif
</div>

<script>
    function filterAssignments(filter) {
        const assignments = document.querySelectorAll('.assignment-card');
        let visibleCount = 0;
        
        assignments.forEach(card => {
            const status = card.dataset.status;
            
            if (filter === 'all') {
                card.style.display = 'flex';
                visibleCount++;
            } else if (filter === 'pending' && (status === 'not-started' || status === 'overdue')) {
                card.style.display = 'flex';
                visibleCount++;
            } else if (filter === 'submitted' && status === 'submitted') {
                card.style.display = 'flex';
                visibleCount++;
            } else if (filter === 'graded' && status === 'graded') {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Update active tab
        document.querySelectorAll('.filter-tab').forEach(btn => {
            btn.classList.remove('active');
            if (btn.textContent.trim().toLowerCase() === filter) {
                btn.classList.add('active');
            }
        });
    }
</script>
@endsection