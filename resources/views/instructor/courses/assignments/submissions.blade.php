@extends('layouts.app')

@section('title', $assignment->title . ' - Submissions')
@section('body-class', 'instructor-page')

@section('styles')
<style>
    .submissions-container {
        padding: 30px 40px;
        max-width: 1200px;
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
        margin-bottom: 20px;
        transition: color 0.3s ease;
        padding: 8px 16px;
        background: white;
        border-radius: 30px;
        border: 1px solid #e2e8f0;
    }

    .back-link:hover {
        color: #2D3E50;
        border-color: #2D3E50;
        transform: translateX(-3px);
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
        margin: 0;
    }

    .page-title i {
        color: #3182ce;
        background: rgba(49, 130, 206, 0.1);
        padding: 10px;
        border-radius: 12px;
    }

    .assignment-badge {
        background: #f1f5f9;
        color: #475569;
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .assignment-badge i {
        color: #d97706;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 16px;
        max-width: 600px;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
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

    /* Assignment Info */
    .assignment-info {
        background: linear-gradient(135deg, #f0f9ff 0%, #e6f0fa 100%);
        border: 1px solid #bae6fd;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .assignment-icon {
        width: 60px;
        height: 60px;
        background: #0284c7;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
    }

    .assignment-details {
        flex: 1;
    }

    .assignment-name {
        font-size: 18px;
        font-weight: 600;
        color: #0369a1;
        margin-bottom: 5px;
    }

    .assignment-meta {
        display: flex;
        gap: 20px;
        color: #0c4a6e;
        font-size: 14px;
        flex-wrap: wrap;
    }

    .assignment-meta i {
        margin-right: 5px;
    }

    .grading-progress {
        background: white;
        border-radius: 30px;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .grading-progress .progress-bar {
        width: 100px;
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
    }

    .grading-progress .progress-fill {
        height: 100%;
        background: #10b981;
        border-radius: 4px;
    }

    /* Submissions Grid */
    .submissions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(500px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    @media (max-width: 768px) {
        .submissions-grid {
            grid-template-columns: 1fr;
        }
    }

    .submission-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }

    .submission-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        border-color: #2D3E50;
    }

    .submission-card.graded {
        border-left: 4px solid #10b981;
    }

    .submission-header {
        padding: 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .student-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2D3E50, #1a252f);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 18px;
        overflow: hidden;
    }

    .student-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .student-details h4 {
        font-size: 16px;
        color: #2D3E50;
        margin-bottom: 4px;
        font-weight: 600;
    }

    .student-details .student-email {
        font-size: 12px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .submission-status {
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        background: #fef3c7;
        color: #92400e;
    }

    .submission-status.graded {
        background: #dcfce7;
        color: #15803d;
    }

    .submission-body {
        padding: 20px;
    }

    .submission-time {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #64748b;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px dashed #e2e8f0;
        flex-wrap: wrap;
    }

    .submission-time i {
        color: #94a3b8;
    }

    .submission-time span {
        margin-left: auto;
    }

    .submission-text {
        background: #f8fafc;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
        color: #475569;
        font-size: 14px;
        line-height: 1.6;
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #e2e8f0;
        white-space: pre-wrap;
    }

    .submission-card.late {
        border-left: 4px solid #dc2626;
        background: #fff5f5;
    }
    
    .submission-card.late:hover {
        background: #fee;
    }
    
    .late-badge {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.8;
            background: #fecaca;
        }
    }

    .file-attachment {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        background: #f1f5f9;
        border-radius: 10px;
        text-decoration: none;
        color: inherit;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .file-attachment:hover {
        background: #e2e8f0;
        border-color: #3182ce;
    }

    .file-icon {
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        font-size: 16px;
    }

    .file-info {
        flex: 1;
    }

    .file-name {
        font-size: 14px;
        font-weight: 500;
        color: #2D3E50;
        margin-bottom: 2px;
        word-break: break-all;
    }

    .file-size {
        font-size: 11px;
        color: #64748b;
    }

    .file-download {
        color: #64748b;
        transition: color 0.3s ease;
    }

    .file-attachment:hover .file-download {
        color: #3182ce;
    }

    /* Grading Section */
    .grading-section {
        padding: 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }

    .grade-label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .grade-controls {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    .grade-input-wrapper {
        position: relative;
        flex: 1;
        min-width: 150px;
    }

    .grade-input {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .grade-input:focus {
        outline: none;
        border-color: #2D3E50;
        box-shadow: 0 0 0 3px rgba(45,62,80,0.1);
    }

    .grade-input.error {
        border-color: #ef4444;
    }

    .grade-input:disabled {
        background: #f1f5f9;
        cursor: not-allowed;
        opacity: 0.7;
    }

    .max-grade {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        font-weight: 500;
    }

    .btn-grade {
        padding: 12px 25px;
        background: #2D3E50;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-width: 140px;
    }

    .btn-grade:hover:not(:disabled) {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45,62,80,0.15);
    }

    .btn-grade:disabled {
        background: #94a3b8;
        cursor: not-allowed;
    }

    .grade-display {
        display: flex;
        align-items: center;
        gap: 15px;
        background: white;
        padding: 12px 20px;
        border-radius: 12px;
        border: 1px solid #10b981;
        flex-wrap: wrap;
    }

    .grade-display .grade-value {
        display: flex;
        align-items: baseline;
        gap: 5px;
    }

    .grade-display .grade-value span {
        font-size: 24px;
        font-weight: 700;
        color: #15803d;
    }

    .grade-display .grade-value small {
        color: #64748b;
        font-size: 14px;
    }

    .grade-display .feedback-toggle {
        margin-left: auto;
        background: #f1f5f9;
        color: #475569;
        border: none;
        padding: 8px 15px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .grade-display .feedback-toggle:hover {
        background: #e2e8f0;
    }

    .feedback-box {
        margin-top: 15px;
        padding: 15px;
        background: white;
        border-radius: 10px;
        border-left: 3px solid #2D3E50;
        display: none;
    }

    .feedback-box.show {
        display: block;
    }

    .feedback-box strong {
        color: #2D3E50;
        display: block;
        margin-bottom: 8px;
    }

    .feedback-box p {
        color: #475569;
        margin: 0;
        line-height: 1.6;
        white-space: pre-wrap;
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

    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.9);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid #f1f5f9;
        border-top-color: #2D3E50;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .submissions-container {
            padding: 20px;
        }

        .header-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .assignment-info {
            flex-direction: column;
            text-align: center;
        }

        .grading-progress {
            width: 100%;
            justify-content: center;
        }

        .grade-controls {
            flex-direction: column;
        }

        .btn-grade {
            width: 100%;
        }

        .grade-display {
            flex-direction: column;
            align-items: flex-start;
        }

        .grade-display .feedback-toggle {
            margin-left: 0;
            width: 100%;
            justify-content: center;
        }

        .submission-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endsection

@section('content')
<div class="submissions-container">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Header -->
    <div class="page-header">
        <a href="{{ route('instructor.course.assignments.index', $course->id) }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Back to Assignments
        </a>

        <div class="header-top">
            <h1 class="page-title">
                <i class="fas fa-tasks"></i>
                Submissions
            </h1>
            <div class="assignment-badge">
                <i class="fas fa-star"></i>
                {{ $assignment->points }} Points
            </div>
        </div>
        <p class="page-subtitle">{{ $assignment->title }}</p>
    </div>

    <!-- Stats -->
    @php
        $totalSubmissions = $submissions->count();
        $gradedCount = $submissions->where('grade', '!=', null)->count();
        $pendingCount = $totalSubmissions - $gradedCount;
        $averageGrade = $gradedCount > 0 ? round($submissions->where('grade', '!=', null)->avg('grade')) : 0;
    @endphp

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $totalSubmissions }}</span>
                <span class="stat-label">Total Submissions</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $gradedCount }}</span>
                <span class="stat-label">Graded</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $pendingCount }}</span>
                <span class="stat-label">Pending</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $averageGrade }}</span>
                <span class="stat-label">Average Grade</span>
            </div>
        </div>
    </div>

    <!-- Assignment Info -->
    <div class="assignment-info">
        <div class="assignment-icon">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="assignment-details">
            <div class="assignment-name">{{ $assignment->title }}</div>
            <div class="assignment-meta">
                <span><i class="fas fa-calendar-alt"></i> Due: {{ $assignment->due_date ? \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') : 'No due date' }}</span>
                <span><i class="fas fa-star"></i> Max Points: {{ $assignment->points }}</span>
            </div>
        </div>
        <div class="grading-progress">
            <span>{{ $gradedCount }}/{{ $totalSubmissions }} Graded</span>
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ $totalSubmissions > 0 ? ($gradedCount / $totalSubmissions) * 100 : 0 }}%"></div>
            </div>
        </div>
    </div>

    <!-- Submissions Grid -->
    @if($submissions->count() > 0)
        <div class="submissions-grid">
            @foreach($submissions as $submission)
                @php
                    $isGraded = !is_null($submission->grade);
                    $student = $submission->user;
                    $isLate = $assignment->due_date && $submission->submitted_at > $assignment->due_date;
                @endphp

                <div class="submission-card {{ $isGraded ? 'graded' : '' }} {{ $isLate ? 'late' : '' }}" id="submission-{{ $submission->id }}">
                    <div class="submission-header">
                        <div class="student-info">
                            <div class="student-avatar">
                                @if($student->avatar)
                                    <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}">
                                @else
                                    {{ $student->initials }}
                                @endif
                            </div>
                            <div class="student-details">
                                <h4>{{ $student->name }}</h4>
                                <div class="student-email">
                                    <i class="fas fa-envelope"></i>
                                    {{ $student->email }}
                                </div>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <!-- LATE BADGE - Placed here prominently -->
                            @if($isLate)
                                <span class="late-badge" style="background: #fee2e2; color: #b91c1c; padding: 6px 15px; border-radius: 30px; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fas fa-exclamation-triangle"></i> Late Submission
                                </span>
                            @endif
                            <span class="submission-status {{ $isGraded ? 'graded' : '' }}">
                                @if($isGraded)
                                    <i class="fas fa-check-circle"></i> Graded
                                @else
                                    <i class="fas fa-clock"></i> Pending
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="submission-body">
                        <div class="submission-time">
                            <i class="fas fa-calendar-alt"></i>
                            Submitted: {{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y - h:i A') : 'Not submitted' }}
                            <span>({{ $submission->submitted_at ? $submission->submitted_at->diffForHumans() : 'Not submitted' }})</span>
                        </div>

                        @if($submission->submission_text)
                            <div class="submission-text">
                                {{ $submission->submission_text }}
                            </div>
                        @endif

                        @if($submission->file_path)
                            @php
                                $fileName = basename($submission->file_path);
                                $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                                $fileSize = Storage::disk('public')->exists($submission->file_path) 
                                    ? round(Storage::disk('public')->size($submission->file_path) / 1024, 2) . ' KB'
                                    : 'Unknown size';
                            @endphp
                            <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="file-attachment">
                                <div class="file-icon">
                                    <i class="fas fa-{{ $extension == 'pdf' ? 'file-pdf' : ($extension == 'docx' || $extension == 'doc' ? 'file-word' : 'file-alt') }}"></i>
                                </div>
                                <div class="file-info">
                                    <div class="file-name">{{ $fileName }}</div>
                                    <div class="file-size">{{ $fileSize }}</div>
                                </div>
                                <i class="fas fa-download file-download"></i>
                            </a>
                        @endif
                    </div>

                    <div class="grading-section">
                        <div class="grade-label">
                            <i class="fas fa-star"></i>
                            Grade (0 - {{ $assignment->points }})

                            <!-- Small late indicator in grading section as reminder -->
                            @if($isLate && !$isGraded)
                                <span style="color: #b91c1c; font-size: 12px; margin-left: 10px;">
                                    <i class="fas fa-exclamation-triangle"></i> Consider late penalty
                                </span>
                            @endif
                        </div>

                        @if($isGraded)
                            <div class="grade-display">
                                <div class="grade-value">
                                    <span>{{ $submission->grade }}</span>
                                    <small>/ {{ $assignment->points }}</small>
                                </div>
                                @if($submission->feedback)
                                    <button class="feedback-toggle" onclick="toggleFeedback({{ $submission->id }})">
                                        <i class="fas fa-comment"></i>
                                        {{ isset($showFeedback) && $showFeedback == $submission->id ? 'Hide Feedback' : 'View Feedback' }}
                                    </button>
                                @endif
                            </div>
                            @if($submission->feedback)
                                <div id="feedback-{{ $submission->id }}" class="feedback-box {{ isset($showFeedback) && $showFeedback == $submission->id ? 'show' : '' }}">
                                    <strong>Feedback:</strong>
                                    <p>{{ $submission->feedback }}</p>
                                </div>
                            @endif
                        @else
                            <div class="grade-controls">
                                <div class="grade-input-wrapper">
                                    <input type="number" 
                                           class="grade-input" 
                                           id="grade-{{ $submission->id }}" 
                                           placeholder="Enter grade"
                                           min="0" 
                                           max="{{ $assignment->points }}"
                                           step="0.5"
                                           value="{{ old('grade', $submission->grade) }}">
                                    <span class="max-grade">/ {{ $assignment->points }}</span>
                                </div>
                                <button class="btn-grade" onclick="gradeSubmission({{ $submission->id }})" id="btn-{{ $submission->id }}">
                                    <i class="fas fa-check"></i>
                                    Submit Grade
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if(method_exists($submissions, 'links'))
            <div class="pagination-wrapper">
                {{ $submissions->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <i class="fas fa-tasks"></i>
            <h3>No Submissions Yet</h3>
            <p>No students have submitted this assignment yet.</p>
            <a href="{{ route('instructor.course.assignments.index', $course->id) }}" class="btn-grade" style="display: inline-block; padding: 12px 30px; text-decoration: none;">
                <i class="fas fa-arrow-left"></i>
                Back to Assignments
            </a>
        </div>
    @endif
</div>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function showLoading() {
        document.getElementById('loadingOverlay').style.display = 'flex';
    }

    function hideLoading() {
        document.getElementById('loadingOverlay').style.display = 'none';
    }

    function toggleFeedback(submissionId) {
        const feedbackDiv = document.getElementById('feedback-' + submissionId);
        const button = event.currentTarget;
        
        if (feedbackDiv) {
            feedbackDiv.classList.toggle('show');
            button.innerHTML = feedbackDiv.classList.contains('show') 
                ? '<i class="fas fa-comment"></i> Hide Feedback' 
                : '<i class="fas fa-comment"></i> View Feedback';
        }
    }

    function validateGrade(grade, maxPoints) {
        if (grade === '' || isNaN(grade)) {
            Swal.fire('Error', 'Please enter a valid grade', 'error');
            return false;
        }
        
        grade = parseFloat(grade);
        if (grade < 0 || grade > maxPoints) {
            Swal.fire('Error', `Grade must be between 0 and ${maxPoints}`, 'error');
            return false;
        }
        return true;
    }

    function gradeSubmission(submissionId) {
        const gradeInput = document.getElementById('grade-' + submissionId);
        const grade = gradeInput.value;
        const maxPoints = {{ $assignment->points }};
        const button = document.getElementById('btn-' + submissionId);
        const originalText = button.innerHTML;

        if (!validateGrade(grade, maxPoints)) {
            gradeInput.classList.add('error');
            setTimeout(() => gradeInput.classList.remove('error'), 3000);
            return;
        }

        // Ask for feedback
        Swal.fire({
            title: 'Grade Submission',
            html: `
                <div style="text-align: left;">
                    <p style="margin-bottom: 10px;">Grade: <strong>${grade}/${maxPoints}</strong></p>
                    <label style="display: block; margin-bottom: 5px;">Feedback (optional):</label>
                    <textarea id="feedback-text" class="form-control" rows="3" placeholder="Add feedback for the student..." style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;"></textarea>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Submit Grade',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#2d3e50',
            cancelButtonColor: '#6c757d',
            reverseButtons: true,
            preConfirm: () => {
                const feedback = document.getElementById('feedback-text').value;
                return { feedback };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                showLoading();
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

                fetch(`/instructor/course/{{ $course->id }}/assignments/{{ $assignment->id }}/submissions/${submissionId}/grade`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        grade: grade,
                        feedback: result.value.feedback 
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    hideLoading();
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Grade submitted successfully',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message || 'Failed to submit grade', 'error');
                        button.disabled = false;
                        button.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    hideLoading();
                    console.error('Error:', error);
                    Swal.fire('Error', error.message || 'Something went wrong', 'error');
                    button.disabled = false;
                    button.innerHTML = originalText;
                });
            }
        });
    }

    // Auto-save grade on Enter key
    document.querySelectorAll('.grade-input').forEach(input => {
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const submissionId = this.id.split('-')[1];
                gradeSubmission(submissionId);
            }
        });
    });
</script>
@endsection