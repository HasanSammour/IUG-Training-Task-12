@extends('layouts.app')

@section('title', 'Assignments - ' . $course->title)
@section('body-class', 'instructor-page')

@section('styles')
<style>
    .assignments-container {
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

    .course-badge i {
        color: #2D3E50;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 16px;
        max-width: 600px;
    }

    .btn-create {
        background: #2D3E50;
        color: white;
        padding: 12px 25px;
        border-radius: 30px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
    }

    .btn-create:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(45, 62, 80, 0.2);
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

    .filter-tab i {
        font-size: 14px;
    }

    .filter-badge {
        background: rgba(255,255,255,0.2);
        color: white;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 11px;
        margin-left: 5px;
    }

    .filter-tab:not(.active) .filter-badge {
        background: #2D3E50;
        color: white;
    }

    /* Assignments Grid */
    .assignments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .assignment-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
    }

    .assignment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        border-color: #2D3E50;
    }

    .assignment-header {
        padding: 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .assignment-title {
        font-size: 18px;
        color: #2D3E50;
        font-weight: 600;
        margin: 0;
        line-height: 1.4;
    }

    .assignment-points {
        background: #e2e8f0;
        color: #475569;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        margin-left: 10px;
    }

    .assignment-body {
        padding: 20px;
        flex: 1;
    }

    .assignment-description {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .assignment-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        font-size: 13px;
        color: #64748b;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .meta-item i {
        color: #94a3b8;
    }

    .due-date {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .due-date.overdue {
        color: #dc2626;
    }

    .due-date.overdue i {
        color: #dc2626;
    }

    .submission-stats {
        background: #f1f5f9;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .submission-count {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .submission-count .count {
        font-size: 18px;
        font-weight: 700;
        color: #2D3E50;
    }

    .submission-count .label {
        font-size: 12px;
        color: #64748b;
    }

    .graded-count {
        font-size: 13px;
        color: #10b981;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .assignment-footer {
        padding: 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 10px;
    }

    .btn-view {
        flex: 1;
        padding: 10px;
        background: #2D3E50;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-view:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45,62,80,0.15);
    }

    .btn-edit {
        padding: 10px 15px;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-edit:hover {
        background: #e2e8f0;
        border-color: #2D3E50;
        color: #2D3E50;
    }

    .btn-delete {
        padding: 10px 15px;
        background: #fee2e2;
        color: #b91c1c;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-delete:hover {
        background: #fecaca;
        transform: translateY(-2px);
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
        font-weight: 600;
    }

    .empty-state p {
        color: #64748b;
        margin-bottom: 25px;
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 30px;
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
        .assignments-container {
            padding: 20px;
        }

        .header-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-create {
            width: 100%;
            justify-content: center;
        }

        .assignment-footer {
            flex-direction: column;
        }

        .btn-view, .btn-edit, .btn-delete {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="assignments-container">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Header -->
    <div class="page-header">
        <a href="{{ route('instructor.course-students', $course->id) }}" class="back-link">
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
        <p class="page-subtitle">Create and manage assignments for your students</p>
    </div>

    <!-- Stats -->
    @php
        $totalAssignments = $assignments->count();
        $totalSubmissions = $assignments->sum(function($a) { return $a->submissions_count ?? 0; });
        $pendingGrading = $assignments->sum(function($a) { 
            return $a->submissions->where('grade', null)->count() ?? 0; 
        });
        $avgSubmissions = $totalAssignments > 0 ? round($totalSubmissions / $totalAssignments) : 0;
    @endphp

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $totalAssignments }}</span>
                <span class="stat-label">Total Assignments</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-file-upload"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $totalSubmissions }}</span>
                <span class="stat-label">Total Submissions</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $pendingGrading }}</span>
                <span class="stat-label">Pending Grading</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $avgSubmissions }}</span>
                <span class="stat-label">Avg Submissions</span>
            </div>
        </div>
    </div>

    <!-- Action Button -->
    <div style="margin-bottom: 25px;">
        <a href="{{ route('instructor.course.assignments.create', $course) }}" class="btn-create">
            <i class="fas fa-plus"></i>
            Create New Assignment
        </a>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterAssignments('all')" id="filterAll">
            <i class="fas fa-th-large"></i>
            All
            <span class="filter-badge">{{ $totalAssignments }}</span>
        </button>
        <button class="filter-tab" onclick="filterAssignments('active')" id="filterActive">
            <i class="fas fa-play-circle"></i>
            Active
        </button>
        <button class="filter-tab" onclick="filterAssignments('past')" id="filterPast">
            <i class="fas fa-history"></i>
            Past Due
        </button>
        <button class="filter-tab" onclick="filterAssignments('has-submissions')" id="filterSubmissions">
            <i class="fas fa-file-upload"></i>
            Has Submissions
        </button>
    </div>

    <!-- Assignments Grid -->
    @if($assignments->count() > 0)
        <div class="assignments-grid" id="assignmentsGrid">
            @foreach($assignments as $assignment)
                @php
                    $submittedCount = $assignment->submissions_count ?? 0;
                    $gradedCount = $assignment->submissions->where('grade', '!=', null)->count() ?? 0;
                    $isOverdue = $assignment->due_date && $assignment->due_date < now();
                @endphp
                
                <div class="assignment-card" 
                     data-status="{{ $isOverdue ? 'past' : 'active' }}"
                     data-has-submissions="{{ $submittedCount > 0 ? 'yes' : 'no' }}">
                    
                    <div class="assignment-header">
                        <h3 class="assignment-title">{{ $assignment->title }}</h3>
                        <span class="assignment-points">{{ $assignment->points }} pts</span>
                    </div>

                    <div class="assignment-body">
                        <p class="assignment-description">{{ Str::limit($assignment->description, 120) }}</p>

                        <div class="assignment-meta">
                            <span class="meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                Created: {{ $assignment->created_at->format('M d, Y') }}
                            </span>
                            @if($assignment->due_date)
                                <span class="due-date {{ $isOverdue ? 'overdue' : '' }}">
                                    <i class="fas fa-clock"></i>
                                    Due: {{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') }}
                                    @if($isOverdue)
                                        <span style="color: #dc2626;">(Overdue)</span>
                                    @endif
                                </span>
                            @endif
                        </div>

                        <div class="submission-stats">
                            <div class="submission-count">
                                <span class="count">{{ $submittedCount }}</span>
                                <span class="label">Submissions</span>
                            </div>
                            @if($submittedCount > 0)
                                <div class="graded-count">
                                    <i class="fas fa-check-circle"></i>
                                    {{ $gradedCount }} Graded
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="assignment-footer">
                        <a href="{{ route('instructor.course.assignments.submissions', [$course, $assignment]) }}" 
                           class="btn-view">
                            <i class="fas fa-users"></i>
                            View Submissions
                            @if($submittedCount > 0)
                                <span style="background: rgba(255,255,255,0.2); padding: 2px 6px; border-radius: 10px; font-size: 10px;">
                                    {{ $submittedCount }}
                                </span>
                            @endif
                        </a>
                        <a href="{{ route('instructor.course.assignments.edit', [$course, $assignment]) }}" 
                           class="btn-edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn-delete" onclick="deleteAssignment({{ $assignment->id }}, '{{ $assignment->title }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                        <form id="delete-form-{{ $assignment->id }}" 
                              action="{{ route('instructor.course.assignments.destroy', [$course, $assignment]) }}" 
                              method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if(method_exists($assignments, 'links'))
            <div class="pagination-wrapper">
                {{ $assignments->links() }}
            </div>
        @endif
    @else
        <div class="empty-state">
            <i class="fas fa-tasks"></i>
            <h3>No Assignments Yet</h3>
            <p>Create your first assignment to get started with your students.</p>
            <a href="{{ route('instructor.course.assignments.create', $course) }}" class="btn-create" style="display: inline-block; padding: 12px 30px;">
                <i class="fas fa-plus"></i>
                Create First Assignment
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

    function filterAssignments(filter) {
        const assignments = document.querySelectorAll('.assignment-card');
        let visibleCount = 0;
        
        assignments.forEach(card => {
            const status = card.dataset.status;
            const hasSubmissions = card.dataset.hasSubmissions;
            let show = false;
            
            switch(filter) {
                case 'all':
                    show = true;
                    break;
                case 'active':
                    show = status === 'active';
                    break;
                case 'past':
                    show = status === 'past';
                    break;
                case 'has-submissions':
                    show = hasSubmissions === 'yes';
                    break;
            }
            
            if (show) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Update active tab
        document.querySelectorAll('.filter-tab').forEach(btn => {
            btn.classList.remove('active');
        });
        document.getElementById(`filter${filter.charAt(0).toUpperCase() + filter.slice(1)}`).classList.add('active');

        // Show empty state if no visible items
        const emptyFilter = document.getElementById('filterEmptyState');
        if (visibleCount === 0 && assignments.length > 0) {
            if (!emptyFilter) {
                const grid = document.getElementById('assignmentsGrid');
                const emptyDiv = document.createElement('div');
                emptyDiv.id = 'filterEmptyState';
                emptyDiv.className = 'empty-state';
                emptyDiv.style.gridColumn = '1 / -1';
                emptyDiv.innerHTML = `
                    <i class="fas fa-filter"></i>
                    <h3>No Assignments Found</h3>
                    <p>No assignments match the selected filter.</p>
                    <button onclick="filterAssignments('all')" class="btn-create" style="padding: 10px 20px;">
                        <i class="fas fa-times"></i>
                        Clear Filter
                    </button>
                `;
                grid.appendChild(emptyDiv);
            }
        } else if (emptyFilter) {
            emptyFilter.remove();
        }
    }

    function deleteAssignment(assignmentId, assignmentTitle) {
        Swal.fire({
            title: 'Delete Assignment?',
            html: `Are you sure you want to delete <strong>"${assignmentTitle}"</strong>?<br><br>
                   <small style="color: #64748b;">This action cannot be undone. All student submissions will also be deleted.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                document.getElementById(`delete-form-${assignmentId}`).submit();
            }
        });
    }

    // Auto-hide success messages
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });
    });
</script>
@endsection