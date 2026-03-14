@extends('layouts.app')

@section('title', 'My Courses - Instructor')
@section('body-class', 'instructor-courses')

@section('styles')
<style>
    /* Instructor Courses Specific Styles */
    .instructor-courses {
        background-color: #f8fbff;
        min-height: 100vh;
    }

    .courses-content {
        padding: 20px;
        max-width: 1300px;
        margin: 0 auto;
    }

    /* Header Section */
    .header-section {
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 28px;
        color: #2D3E50;
        margin-bottom: 10px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-subtitle {
        color: #718096;
        font-size: 16px;
        margin-bottom: 20px;
    }

    /* Stats Bar */
    .stats-bar {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    @media (max-width: 768px) {
        .stats-bar {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .stats-bar {
            grid-template-columns: 1fr;
        }
    }

    .stat-item {
        background: white;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #edf2f7;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        border-color: #2D3E50;
    }

    .stat-number {
        display: block;
        font-size: 28px;
        font-weight: 700;
        color: #2D3E50;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Actions Bar */
    .actions-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding: 15px 0;
        border-bottom: 1px solid #edf2f7;
    }

    .search-container {
        position: relative;
        flex: 1;
        max-width: 400px;
    }

    .search-container i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
    }

    .search-input {
        width: 100%;
        padding: 12px 12px 12px 40px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: white;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #2D3E50;
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    /* Filter Tabs */
    .filter-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        padding-bottom: 10px;
        overflow-x: auto;
        scrollbar-width: none;
    }

    .filter-tabs::-webkit-scrollbar {
        display: none;
    }

    .tab-btn {
        padding: 8px 20px;
        border-radius: 30px;
        background: #f1f5f9;
        color: #64748b;
        font-size: 13px;
        border: none;
        white-space: nowrap;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .tab-btn.active {
        background: #2D3E50;
        color: white;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.2);
    }

    .tab-btn:hover:not(.active) {
        background: #e2e8f0;
        color: #2D3E50;
    }

    /* Courses Table */
    .courses-table-container {
        background: white;
        border-radius: 16px;
        border: 1px solid #edf2f7;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1100px;
    }

    th {
        text-align: left;
        padding: 18px 16px;
        font-size: 12px;
        color: #64748b;
        border-bottom: 1px solid #f1f5f9;
        background: #fafafa;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    td {
        padding: 16px;
        font-size: 14px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover td {
        background: #f8fafc;
    }

    /* Inactive Course Row */
    tr.inactive-course {
        opacity: 0.7;
        background: #fff5f5;
        border-left: 4px solid #dc2626;
    }

    tr.inactive-course:hover td {
        background: #fee;
    }

    .inactive-badge {
        background: #fee2e2;
        color: #b91c1c;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 600;
        margin-left: 8px;
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }

    .course-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .course-thumb {
        width: 60px;
        height: 45px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
        border: 1px solid #edf2f7;
    }

    .course-details {
        min-width: 220px;
    }

    .course-title {
        font-weight: 600;
        color: #2D3E50;
        font-size: 15px;
        margin-bottom: 4px;
        line-height: 1.3;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .course-meta {
        font-size: 11px;
        color: #94a3b8;
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    .course-meta i {
        margin-right: 3px;
    }

    .course-category {
        font-size: 11px;
        color: #2D3E50;
        background: #f1f5f9;
        padding: 3px 10px;
        border-radius: 20px;
        display: inline-block;
        font-weight: 500;
        white-space: nowrap;
    }

    /* Status Badges */
    .status-wrapper {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: nowrap;
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
        min-width: 80px;
    }

    .status-active {
        background: #dcfce7;
        color: #15803d;
    }

    .status-inactive {
        background: #fee2e2;
        color: #dc2626;
    }

    .featured-star {
        color: #f59e0b;
        background: #fef3c7;
        padding: 3px 10px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    /* Rating */
    .rating-wrapper {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: nowrap;
    }

    .rating {
        color: #f59e0b;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 2px;
        white-space: nowrap;
    }

    .rating-value {
        color: #2D3E50;
        font-weight: 600;
        margin-left: 4px;
        font-size: 13px;
    }

    .rating-count {
        color: #94a3b8;
        font-size: 11px;
        white-space: nowrap;
    }

    .price {
        font-weight: 700;
        color: #2D3E50;
        font-size: 16px;
    }

    .discount-badge {
        background: #e53e3e;
        color: white;
        padding: 2px 8px;
        border-radius: 30px;
        font-size: 10px;
        font-weight: 600;
        display: inline-block;
        margin-left: 5px;
        white-space: nowrap;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: nowrap;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-icon:hover {
        background: #2D3E50;
        color: white;
        border-color: #2D3E50;
        transform: translateY(-2px);
    }

    .btn-icon.view:hover {
        background: #3182ce;
        border-color: #3182ce;
    }

    .btn-icon.students:hover {
        background: #065f46;
        border-color: #065f46;
    }

    .btn-icon.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
        background: #f1f5f9;
    }

    .btn-icon.disabled:hover {
        transform: none;
        background: #f1f5f9;
        color: #94a3b8;
    }

    /* Progress Bar */
    .progress-container {
        display: flex;
        flex-direction: column;
        gap: 5px;
        min-width: 100px;
    }

    .progress-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .progress-percent {
        font-size: 13px;
        font-weight: 600;
        color: #2D3E50;
        white-space: nowrap;
    }

    .progress-bar-bg {
        width: 80px;
        height: 6px;
        background: #f1f5f9;
        border-radius: 3px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: #2D3E50;
        border-radius: 3px;
    }

    .completed-count {
        font-size: 10px;
        color: #94a3b8;
        white-space: nowrap;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #64748b;
    }

    .empty-state-icon {
        font-size: 64px;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: #2D3E50;
        margin-bottom: 15px;
        font-size: 22px;
        font-weight: 600;
    }

    .empty-state p {
        margin-bottom: 25px;
        max-width: 450px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
        color: #64748b;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        background: white;
        border-radius: 16px;
        border: 1px solid #edf2f7;
    }

    .info-text {
        font-size: 13px;
        color: #64748b;
    }

    .page-numbers {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .page-link {
        min-width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        color: #64748b;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .page-link.active {
        background: #2D3E50;
        color: white;
        font-weight: 600;
        border-color: #2D3E50;
    }

    .page-link:hover:not(.active) {
        background: #f1f5f9;
        border-color: #2D3E50;
        color: #2D3E50;
    }

    .page-arrow {
        color: #2D3E50;
        font-size: 14px;
        text-decoration: none;
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .page-arrow:hover {
        background: #f1f5f9;
        border-color: #2D3E50;
    }

    .page-arrow.disabled {
        opacity: 0.3;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* Assignment Info */
    .assignment-info {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #0369a1;
    }

    .assignment-info i {
        font-size: 20px;
    }

    .assignment-info span {
        font-size: 14px;
        line-height: 1.5;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .courses-content {
            padding: 15px;
        }
        
        .actions-bar {
            flex-direction: column;
            gap: 15px;
            align-items: stretch;
        }
        
        .search-container {
            max-width: 100%;
            width: 100%;
        }
        
        .pagination-container {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
        
        .page-numbers {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="courses-content">
    
    <!-- Header Section -->
    <div class="header-section">
        <h1 class="page-title">
            <i class="fas fa-chalkboard-teacher" style="color: #2D3E50;"></i>
            My Assigned Courses
        </h1>
        
        <p class="page-subtitle">View and manage students enrolled in your assigned courses</p>
        
        <!-- Stats Bar -->
        <div class="stats-bar">
            <div class="stat-item">
                <span class="stat-number">{{ $courses->total() }}</span>
                <span class="stat-label">Assigned Courses</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $stats['active_courses'] ?? 0 }}</span>
                <span class="stat-label">Active Courses</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $stats['total_students'] ?? 0 }}</span>
                <span class="stat-label">Total Students</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">{{ $stats['avg_progress'] ?? 0 }}%</span>
                <span class="stat-label">Avg. Progress</span>
            </div>
        </div>
        
        <!-- Assignment Info for empty state -->
        @if($courses->count() == 0)
        <div class="assignment-info">
            <i class="fas fa-envelope-open-text"></i>
            <span>No courses have been assigned to you yet. Once an administrator assigns courses to you, they will appear here.</span>
        </div>
        @endif
    </div>

    <!-- Actions Bar - Search Only (No Create Button) -->
    <div class="actions-bar">
        <div class="search-container">
            <i class="fas fa-search"></i>
            <input type="text" class="search-input" placeholder="Search your assigned courses..." id="courseSearch" value="{{ request('search') }}">
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <button class="tab-btn {{ !request('status') ? 'active' : '' }}" data-filter="all">
            <i class="fas fa-th-large"></i> All Courses
        </button>
        <button class="tab-btn {{ request('status') == 'active' ? 'active' : '' }}" data-filter="active">
            <i class="fas fa-check-circle"></i> Active
        </button>
        <button class="tab-btn {{ request('status') == 'inactive' ? 'active' : '' }}" data-filter="inactive">
            <i class="fas fa-times-circle"></i> Inactive
        </button>
        <button class="tab-btn {{ request('status') == 'featured' ? 'active' : '' }}" data-filter="featured">
            <i class="fas fa-star"></i> Featured
        </button>
    </div>

    <!-- Courses Table -->
    <div class="courses-table-container">
        <div class="table-wrapper">
            @if($courses->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th style="width: 60px;"></th>
                            <th>Course</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Students</th>
                            <th>Rating</th>
                            <th>Progress</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr class="{{ !$course->is_active ? 'inactive-course' : '' }}">
                                <td style="width: 60px;">
                                    <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="course-thumb">
                                </td>
                                <td>
                                    <div class="course-details">
                                        <div class="course-title">
                                            {{ Str::limit($course->title, 45) }}
                                            @if(!$course->is_active)
                                                <span class="inactive-badge">
                                                    <i class="fas fa-exclamation-triangle"></i> Inactive
                                                </span>
                                            @endif
                                        </div>
                                        <div class="course-meta">
                                            <span><i class="fas fa-clock"></i> {{ $course->duration ?? '4 weeks' }}</span>
                                            <span><i class="fas fa-level-up-alt"></i> {{ ucfirst($course->level) }}</span>
                                            <span><i class="fas fa-calendar"></i> {{ $course->created_at->format('M Y') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="course-category">
                                        <i class="fas fa-folder"></i> {{ $course->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="status-wrapper">
                                        <span class="status-badge {{ $course->is_active ? 'status-active' : 'status-inactive' }}">
                                            {{ $course->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        @if($course->is_featured)
                                            <span class="featured-star">
                                                <i class="fas fa-star"></i> Featured
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span style="font-weight: 600; color: #2D3E50; font-size: 16px;">
                                        {{ $course->enrollments_count ?? $course->total_students }}
                                    </span>
                                    <span style="font-size: 11px; color: #94a3b8; display: block;">
                                        enrolled
                                    </span>
                                </td>
                                <td>
                                    <div class="rating-wrapper">
                                        <span class="rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($course->rating))
                                                    <i class="fas fa-star"></i>
                                                @elseif($i - 0.5 <= $course->rating)
                                                    <i class="fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </span>
                                        <span class="rating-value">{{ number_format($course->rating, 1) }}</span>
                                        <span class="rating-count">({{ $course->reviews_count ?? 0 }})</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress-row">
                                            <span class="progress-percent">{{ round($course->average_progress ?? 0) }}%</span>
                                            <div class="progress-bar-bg">
                                                <div class="progress-bar-fill" style="width: {{ $course->average_progress ?? 0 }}%;"></div>
                                            </div>
                                        </div>
                                        <span class="completed-count">
                                            {{ $course->enrollments()->where('status', 'completed')->count() ?? 0 }} completed
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <!-- View Course - Always Available (Read Only) -->
                                        <a href="{{ route('courses.show', $course->slug) }}" class="btn-icon view" title="View Course" target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <!-- View Students - Only if course is active -->
                                        @if($course->is_active)
                                            <a href="{{ route('instructor.course-students', $course) }}" class="btn-icon students" title="View Enrolled Students">
                                                <i class="fas fa-users"></i>
                                            </a>
                                        @else
                                            <button class="btn-icon students disabled" onclick="showInactiveAlert('{{ $course->title }}')" title="Course inactive - Cannot manage students">
                                                <i class="fas fa-users-slash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h3>No Courses Assigned</h3>
                    <p>You haven't been assigned any courses yet. When an administrator assigns courses to you, they will appear here for you to manage students and track progress.</p>
                    <div style="color: #64748b; font-size: 14px; margin-top: 20px;">
                        <i class="fas fa-info-circle"></i> Contact your administrator for course assignments
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    @if($courses->hasPages())
        <div class="pagination-container">
            <div class="info-text">
                Showing <strong>{{ $courses->firstItem() }}</strong> to <strong>{{ $courses->lastItem() }}</strong> of 
                <strong>{{ $courses->total() }}</strong> assigned courses
            </div>
            
            <div class="page-numbers">
                @if($courses->onFirstPage())
                    <span class="page-arrow disabled">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $courses->previousPageUrl() }}" class="page-arrow">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                @endif
                
                @php
                    $start = max($courses->currentPage() - 2, 1);
                    $end = min($start + 4, $courses->lastPage());
                    $start = max($end - 4, 1);
                @endphp
                
                @if($start > 1)
                    <a href="{{ $courses->url(1) }}" class="page-link">1</a>
                    @if($start > 2)
                        <span style="color: #94a3b8;">...</span>
                    @endif
                @endif
                
                @foreach(range($start, $end) as $page)
                    <a href="{{ $courses->url($page) }}" class="page-link {{ $courses->currentPage() == $page ? 'active' : '' }}">
                        {{ $page }}
                    </a>
                @endforeach
                
                @if($end < $courses->lastPage())
                    @if($end < $courses->lastPage() - 1)
                        <span style="color: #94a3b8;">...</span>
                    @endif
                    <a href="{{ $courses->url($courses->lastPage()) }}" class="page-link">{{ $courses->lastPage() }}</a>
                @endif
                
                @if($courses->hasMorePages())
                    <a href="{{ $courses->nextPageUrl() }}" class="page-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <span class="page-arrow disabled">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                @endif
            </div>
        </div>
    @endif

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality with debounce
        const searchInput = document.getElementById('courseSearch');
        let searchTimeout;
        
        if (searchInput) {
            searchInput.addEventListener('keyup', function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    const searchTerm = e.target.value.toLowerCase();
                    const rows = document.querySelectorAll('tbody tr');
                    
                    rows.forEach(row => {
                        const title = row.querySelector('.course-title')?.textContent.toLowerCase() || '';
                        const category = row.querySelector('.course-category')?.textContent.toLowerCase() || '';
                        const meta = row.querySelector('.course-meta')?.textContent.toLowerCase() || '';
                        
                        if (title.includes(searchTerm) || category.includes(searchTerm) || meta.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                    
                    // Show empty state if no results
                    const visibleRows = document.querySelectorAll('tbody tr:not([style*="display: none"])');
                    const table = document.querySelector('table');
                    
                    if (table && visibleRows.length === 0) {
                        const noResults = document.querySelector('.empty-state-search');
                        if (!noResults) {
                            const emptySearch = document.createElement('div');
                            emptySearch.className = 'empty-state empty-state-search';
                            emptySearch.innerHTML = `
                                <div class="empty-state-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                                <h3>No Results Found</h3>
                                <p>No courses match your search "${searchTerm}". Try different keywords.</p>
                            `;
                            document.querySelector('.table-wrapper').appendChild(emptySearch);
                        }
                        if (table) table.style.display = 'none';
                    } else {
                        const emptySearch = document.querySelector('.empty-state-search');
                        if (emptySearch) emptySearch.remove();
                        if (table) table.style.display = '';
                    }
                }, 300);
            });
        }
        
        // Filter tabs with URL parameters
        const tabs = document.querySelectorAll('.tab-btn');
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const filter = this.dataset.filter;
                const url = new URL(window.location.href);
                
                if (filter === 'all') {
                    url.searchParams.delete('status');
                } else {
                    url.searchParams.set('status', filter);
                }
                
                window.location.href = url.toString();
            });
        });
        
        // Row hover effects
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8fafc';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
    });

    // Function to show inactive course alert
    function showInactiveAlert(courseTitle) {
        Swal.fire({
            icon: 'warning',
            title: 'Course Inactive',
            html: `<strong>"${courseTitle}"</strong> is currently inactive.<br><br>
                   You can view course details but cannot manage students.<br>
                   Please contact an administrator to activate it.`,
            confirmButtonColor: '#2d3e50',
            confirmButtonText: 'OK'
        });
    }
</script>
@endsection