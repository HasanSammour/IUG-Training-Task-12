@extends('layouts.app')

@section('title', 'Course Enrollments - Shifra Admin')
@section('body-class', 'admin-page')

@section('styles')
<style>
    .admin-page {
        background-color: #f8fbff;
        min-height: 100vh;
        padding-bottom: 70px;
    }

    .admin-container {
        padding: 20px;
        max-width: 1300px;
        margin: 0 auto;
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: #fff;
        border-radius: 15px;
        border: 1px solid #f1f5f9;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .header-left {
        flex: 1;
    }

    .admin-title {
        font-size: 24px;
        font-weight: bold;
        color: #2D3E50;
        margin-bottom: 5px;
    }

    .course-subtitle {
        color: #64748b;
        font-size: 14px;
        margin: 0;
    }

    .btn-back {
        padding: 10px 20px;
        background: #f7fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .btn-back:hover {
        background: #e2e8f0;
        color: #2D3E50;
    }

    .course-info-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        border: 1px solid #edf2f7;
        margin-bottom: 20px;
        display: flex;
        gap: 20px;
        align-items: center;
        flex-wrap: wrap;
    }

    .course-image {
        width: 120px;
        height: 90px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid #f1f5f9;
    }

    .course-details {
        flex: 1;
        min-width: 300px;
    }

    .course-details h3 {
        font-size: 18px;
        color: #2D3E50;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .course-meta {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .meta-item {
        font-size: 13px;
        color: #64748b;
    }

    .meta-item strong {
        color: #2D3E50;
        margin-right: 5px;
    }

    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #edf2f7;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .stat-value {
        font-size: 28px;
        font-weight: bold;
        color: #2D3E50;
        margin-bottom: 8px;
        display: block;
    }

    .stat-label {
        font-size: 12px;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
    }

    .filters-section {
        background: white;
        border-radius: 15px;
        padding: 20px;
        border: 1px solid #edf2f7;
        margin-bottom: 20px;
    }

    .filters-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 8px;
    }

    .filter-input, .filter-select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        color: #2D3E50;
        background: white;
        transition: border-color 0.3s ease;
    }

    .filter-input:focus, .filter-select:focus {
        outline: none;
        border-color: #2D3E50;
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    .btn-apply {
        background: #2D3E50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-apply:hover {
        background: #1a252f;
        transform: translateY(-2px);
    }

    .btn-clear {
        background: #f7fafc;
        color: #64748b;
        padding: 10px 20px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-clear:hover {
        background: #e2e8f0;
        color: #2D3E50;
    }

    .enrollments-table {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid #edf2f7;
        margin-bottom: 20px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .enrollments-table table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1000px;
    }

    .enrollments-table th {
        text-align: left;
        padding: 15px;
        font-size: 13px;
        color: #64748b;
        border-bottom: 1px solid #f1f5f9;
        background: #fafafa;
        font-weight: 600;
        white-space: nowrap;
    }

    .enrollments-table td {
        padding: 15px;
        font-size: 13px;
        border-bottom: 1px solid #f8fbff;
        vertical-align: middle;
    }

    .enrollments-table tr:hover {
        background-color: #f8fafc;
    }

    .enrollments-table tr:last-child td {
        border-bottom: none;
    }

    /* Student info */
    .student-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .student-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2D3E50, #3182ce);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 12px;
        flex-shrink: 0;
    }

    .student-name {
        font-weight: 600;
        color: #2D3E50;
        font-size: 14px;
    }

    .student-email {
        font-size: 12px;
        color: #94a3b8;
    }

    /* Progress bar */
    .progress-container {
        min-width: 120px;
    }

    .progress-bar {
        width: 100%;
        height: 6px;
        background: #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 5px;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #3182ce, #2D3E50);
        border-radius: 10px;
        transition: width 0.5s ease;
    }

    .progress-text {
        font-size: 12px;
        color: #64748b;
        text-align: center;
        font-weight: 600;
    }

    /* Status badges */
    .status-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
        min-width: 80px;
        text-align: center;
    }

    .status-pending {
        background: #fff3e0;
        color: #f57c00;
    }

    .status-active {
        background: #e8f5e9;
        color: #388e3c;
    }

    .status-completed {
        background: #e3f2fd;
        color: #1976d2;
    }

    .status-cancelled {
        background: #ffebee;
        color: #d32f2f;
    }

    /* Actions */
    .action-btn {
        background: #f7fafc;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 12px;
        color: #64748b;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .action-btn:hover {
        background: #2D3E50;
        color: white;
        border-color: #2D3E50;
        transform: translateY(-2px);
    }

    /* Empty state */
    .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: #94a3b8;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        color: #cbd5e0;
    }

    .empty-state h4 {
        color: #64748b;
        margin-bottom: 10px;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: white;
        border-radius: 15px;
        border: 1px solid #edf2f7;
    }

    .pagination-info {
        font-size: 13px;
        color: #94a3b8;
    }

    .pagination-links {
        display: flex;
        gap: 5px;
        align-items: center;
    }

    .page-link {
        min-width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        color: #64748b;
        background: white;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background: #f8fafc;
        border-color: #2D3E50;
    }

    .page-link.active {
        background: #2D3E50;
        color: white;
        border-color: #2D3E50;
    }

    .page-arrow {
        color: #2D3E50;
        font-size: 14px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .page-arrow:hover {
        background: #f8fafc;
        border-color: #2D3E50;
    }

    @media (max-width: 768px) {
        .admin-container {
            padding: 15px;
        }

        .admin-header {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-back {
            width: 100%;
            justify-content: center;
        }

        .course-info-card {
            flex-direction: column;
            text-align: center;
        }

        .course-image {
            width: 100%;
            height: 150px;
        }

        .course-details {
            min-width: unset;
        }

        .course-meta {
            justify-content: center;
        }

        .filters-form {
            grid-template-columns: 1fr;
        }

        .pagination-container {
            flex-direction: column;
            gap: 15px;
        }

        .table-responsive {
            margin: 0 -15px;
            padding: 0 15px;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <div class="header-left">
            <h1 class="admin-title">Course Enrollments</h1>
            <p class="course-subtitle">{{ $course->title }}</p>
        </div>
        <a href="{{ route('admin.courses.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to Courses
        </a>
    </div>

    <!-- Course Info -->
    <div class="course-info-card">
        <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="course-image">
        <div class="course-details">
            <h3>{{ $course->title }}</h3>
            <p style="color: #64748b; margin-bottom: 10px;">{{ Str::limit($course->short_description, 100) }}</p>
            <div class="course-meta">
                <div class="meta-item">
                    <strong>Instructor:</strong> {{ $course->instructor_name }}
                </div>
                <div class="meta-item">
                    <strong>Duration:</strong> {{ $course->duration }}
                </div>
                <div class="meta-item">
                    <strong>Level:</strong> {{ ucfirst($course->level) }}
                </div>
                <div class="meta-item">
                    <strong>Format:</strong> {{ ucfirst($course->format) }}
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-cards">
        <div class="stat-card">
            <span class="stat-value">{{ $totalEnrollments }}</span>
            <span class="stat-label">Total Enrollments</span>
        </div>
        <div class="stat-card">
            <span class="stat-value">{{ $activeEnrollments }}</span>
            <span class="stat-label">Active</span>
        </div>
        <div class="stat-card">
            <span class="stat-value">{{ $completedEnrollments }}</span>
            <span class="stat-label">Completed</span>
        </div>
        <div class="stat-card">
            <span class="stat-value">{{ $averageProgress }}%</span>
            <span class="stat-label">Average Progress</span>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-section">
        <form method="GET" class="filters-form">
            <div class="filter-group">
                <label class="filter-label">Status</label>
                <select name="status" class="filter-select">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label class="filter-label">Search Student</label>
                <input type="text" name="search" class="filter-input" placeholder="Name or email" value="{{ request('search') }}">
            </div>
            
            <div class="filter-group">
                <label class="filter-label">Date From</label>
                <input type="date" name="date_from" class="filter-input" value="{{ request('date_from') }}">
            </div>
            
            <div class="filter-group">
                <label class="filter-label">Date To</label>
                <input type="date" name="date_to" class="filter-input" value="{{ request('date_to') }}">
            </div>
            
            <button type="submit" class="btn-apply">
                <i class="fas fa-filter"></i> Apply Filters
            </button>
            
            @if(request()->hasAny(['status', 'search', 'date_from', 'date_to']))
                <a href="{{ route('admin.courses.enrollments', $course) }}" class="btn-clear">
                    <i class="fas fa-times"></i> Clear Filters
                </a>
            @endif
        </form>
    </div>

    <!-- Enrollments Table -->
    <div class="enrollments-table">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Enrollment ID</th>
                        <th>Enrolled Date</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($enrollments as $enrollment)
                        <tr>
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar" style="background: none; padding: 0; overflow: hidden;">
                                        <img src="{{ $enrollment->user->avatar_url }}" alt="{{ $enrollment->user->name }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                    </div>
                                    <div>
                                        <div class="student-name">{{ $enrollment->user->name }}</div>
                                        <div class="student-email">{{ $enrollment->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="font-family: monospace; color: #3182ce; font-weight: 600;">
                                    {{ $enrollment->enrollment_id }}
                                </span>
                            </td>
                            <td>
                                <div style="font-size: 12px; color: #64748b;">
                                    {{ $enrollment->enrolled_at->format('M d, Y') }}
                                </div>
                                <div style="font-size: 11px; color: #94a3b8;">
                                    {{ $enrollment->enrolled_at->diffForHumans() }}
                                </div>
                            </td>
                            <td>
                                <div class="progress-container">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                    </div>
                                    <div class="progress-text">{{ $enrollment->progress_percentage }}%</div>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $enrollment->status }}">
                                    {{ ucfirst($enrollment->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.enrollments.show', $enrollment) }}" class="action-btn">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-user-graduate"></i>
                                    <h4>No Enrollments Found</h4>
                                    <p>@if(request()->hasAny(['status', 'search', 'date_from', 'date_to']))
                                        Try adjusting your filters
                                    @else
                                        No students have enrolled in this course yet
                                    @endif</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($enrollments->hasPages())
        <div class="pagination-container">
            <div class="pagination-info">
                Showing {{ $enrollments->firstItem() ?? 0 }} to {{ $enrollments->lastItem() ?? 0 }} 
                of {{ $enrollments->total() }} enrollments
            </div>
            <div class="pagination-links">
                @if($enrollments->onFirstPage())
                    <span class="page-arrow" style="opacity: 0.5; cursor: not-allowed;">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $enrollments->previousPageUrl() }}" class="page-arrow">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                @endif

                @php
                    $start = max(1, $enrollments->currentPage() - 2);
                    $end = min($enrollments->lastPage(), $enrollments->currentPage() + 2);
                @endphp

                @if($start > 1)
                    <a href="{{ $enrollments->url(1) }}" class="page-link">1</a>
                    @if($start > 2) <span style="padding: 0 5px; color: #cbd5e0;">...</span> @endif
                @endif

                @for($page = $start; $page <= $end; $page++)
                    <a href="{{ $enrollments->url($page) }}"
                        class="page-link {{ $enrollments->currentPage() == $page ? 'active' : '' }}">
                        {{ $page }}
                    </a>
                @endfor

                @if($end < $enrollments->lastPage())
                    @if($end < $enrollments->lastPage() - 1) <span style="padding: 0 5px; color: #cbd5e0;">...</span> @endif
                    <a href="{{ $enrollments->url($enrollments->lastPage()) }}" class="page-link">{{ $enrollments->lastPage() }}</a>
                @endif

                @if($enrollments->hasMorePages())
                    <a href="{{ $enrollments->nextPageUrl() }}" class="page-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <span class="page-arrow" style="opacity: 0.5; cursor: not-allowed;">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-submit filters on change
        const filterSelects = document.querySelectorAll('select[name="status"]');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });

        // Date inputs auto-submit on change
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (this.value) {
                    this.closest('form').submit();
                }
            });
        });

        // Add loading animation to progress bars
        document.querySelectorAll('.progress-fill').forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.transition = 'width 1s ease';
                bar.style.width = width;
            }, 300);
        });

        // Enhanced row hover effects
        const tableRows = document.querySelectorAll('.enrollments-table tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8fafc';
            });
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });

        // Search input debounce
        const searchInput = document.querySelector('input[name="search"]');
        let searchTimeout;
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    if (this.value.length === 0 || this.value.length >= 3) {
                        this.closest('form').submit();
                    }
                }, 500);
            });
        }
    });
</script>
@endsection