@extends('layouts.app')

@section('title', 'Students Analytics - Admin')
@section('body-class', 'admin-page')

@section('styles')
<style>
    .admin-container {
        padding: 20px;
        max-width: 1100px;
        margin: 0 auto;
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 0;
        border-bottom: 1px solid #eee;
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 28px;
        color: #2D3E50;
        font-weight: bold;
    }

    .filter-section {
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-select {
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 14px;
        background: white;
        cursor: pointer;
        transition: border-color 0.3s ease;
    }

    .filter-select:focus {
        outline: none;
        border-color: #2D3E50;
    }

    .search-box {
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 14px;
        width: 250px;
        transition: border-color 0.3s ease;
    }

    .search-box:focus {
        outline: none;
        border-color: #2D3E50;
    }

    .export-btn {
        padding: 8px 16px;
        background: #10b981;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .export-btn:hover {
        background: #059669;
        transform: translateY(-2px);
    }

    /* Stats Grid - 3 cards per row */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #edf2f7;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        background: #f0f7ff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        color: #2D3E50;
        font-size: 20px;
    }

    .stat-value {
        display: block;
        font-size: 28px;
        font-weight: 700;
        color: #2D3E50;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 14px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Tabs */
    .analytics-tabs {
        display: flex;
        gap: 10px;
        padding: 20px 0;
        border-bottom: 1px solid #eee;
        margin-bottom: 30px;
        overflow-x: auto;
    }

    .analytics-tabs::-webkit-scrollbar {
        display: none;
    }

    .tab-item {
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        color: #64748b;
        font-weight: 500;
        font-size: 14px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .tab-item:hover {
        background: #f1f5f9;
        color: #2D3E50;
    }

    .tab-item.active {
        background: #2D3E50;
        color: white;
        font-weight: 600;
    }

    /* Active Students Grid - 2 cards per row */
    .active-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    /* Make last odd card full width */
    .active-grid .active-card:last-child:nth-child(odd) {
        grid-column: 1 / -1;
        max-width: calc(50% - 10px);
        margin: 0 auto;
    }

    @media (max-width: 768px) {
        .active-grid {
            grid-template-columns: 1fr;
        }
        
        .active-grid .active-card:last-child:nth-child(odd) {
            grid-column: 1;
            max-width: 100%;
        }
    }

    .active-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        border: 1px solid #edf2f7;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .active-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    .active-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2D3E50, #3182ce);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: bold;
        flex-shrink: 0;
    }

    .active-info {
        flex: 1;
        min-width: 0;
    }

    .active-info h4 {
        font-size: 15px;
        color: #2D3E50;
        margin-bottom: 3px;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .active-info p {
        font-size: 12px;
        color: #94a3b8;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .active-courses {
        background: #f0f9ff;
        color: #0369a1;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    /* Students Table */
    .table-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #edf2f7;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .table-header h3 {
        font-size: 18px;
        color: #2D3E50;
        font-weight: 600;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1000px;
    }

    th {
        text-align: left;
        padding: 15px;
        font-size: 13px;
        color: #64748b;
        border-bottom: 1px solid #f1f5f9;
        background: #fafafa;
        font-weight: 600;
        white-space: nowrap;
    }

    td {
        padding: 15px;
        font-size: 13px;
        border-bottom: 1px solid #f8fbff;
        vertical-align: middle;
    }

    tr:hover {
        background: #f8fafc;
    }

    .student-name {
        color: #2D3E50;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .student-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2D3E50, #3182ce);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: bold;
        flex-shrink: 0;
    }

    .student-info {
        min-width: 0;
    }

    .student-info h4 {
        margin: 0;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .student-info p {
        margin: 2px 0 0;
        font-size: 12px;
        color: #94a3b8;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .enrollment-badge {
        background: #d1fae5;
        color: #065f46;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .revenue-badge {
        background: #dbeafe;
        color: #1e40af;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    /* Action Buttons - NEW: Replaced progress column */
    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: white;
        font-size: 12px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    .btn-view {
        background: #10b981;
    }

    .btn-view:hover {
        background: #059669;
    }

    .btn-message {
        background: #f59e0b;
    }

    .btn-message:hover {
        background: #d97706;
    }

    .btn-enrollments {
        background: #3b82f6;
    }

    .btn-enrollments:hover {
        background: #2563eb;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
        margin-top: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .info-text {
        font-size: 13px;
        color: #64748b;
    }

    .pagination-links {
        display: flex;
        gap: 5px;
        align-items: center;
    }

    .page-link {
        min-width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        color: #64748b;
        background: #f8fafc;
        transition: all 0.3s ease;
    }

    .page-link:hover:not(.active) {
        background: #e2e8f0;
        color: #2D3E50;
    }

    .page-link.active {
        background: #2D3E50;
        color: white;
        font-weight: 600;
    }

    .page-arrow {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        text-decoration: none;
        color: #2D3E50;
        background: #f8fafc;
        font-size: 12px;
        transition: all 0.3s ease;
    }

    .page-arrow:hover:not(:disabled) {
        background: #e2e8f0;
    }

    .page-arrow:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Toast Styling */
    .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        background: #2D3E50;
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        min-width: 300px;
        animation: slideInRight 0.3s ease;
    }

    .toast-info {
        background: #2D3E50;
    }

    .toast-success {
        background: #10b981;
    }

    .toast-error {
        background: #ef4444;
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(100%);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideOutRight {
        from {
            opacity: 1;
            transform: translateX(0);
        }
        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #94a3b8;
        grid-column: 1 / -1;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 18px;
        margin-bottom: 10px;
        color: #64748b;
    }

    .empty-state p {
        margin-bottom: 20px;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-clear-search {
        display: inline-block;
        padding: 10px 20px;
        background: #2D3E50;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid #2D3E50;
        margin-top: 10px;
    }

    .btn-clear-search:hover {
        background: transparent;
        color: #2D3E50;
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-header {
            flex-direction: column;
            gap: 15px;
            align-items: stretch;
        }

        .filter-section {
            width: 100%;
        }

        .filter-select {
            width: 100%;
        }

        .search-box {
            width: 100%;
        }

        .table-header {
            flex-direction: column;
            gap: 15px;
            align-items: stretch;
        }

        .pagination-container {
            justify-content: center;
            text-align: center;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1 class="page-title">Students Analytics</h1>
        <div class="filter-section">
            <form method="GET" action="{{ route('admin.analytics.students') }}" id="filterForm">
                <select name="filter" class="filter-select" id="filterSelect">
                    <option value="all" {{ ($filter ?? 'all') == 'all' ? 'selected' : '' }}>All Time</option>
                    <option value="week" {{ ($filter ?? 'all') == 'week' ? 'selected' : '' }}>Last Week</option>
                    <option value="month" {{ ($filter ?? 'all') == 'month' ? 'selected' : '' }}>Last Month</option>
                    <option value="year" {{ ($filter ?? 'all') == 'year' ? 'selected' : '' }}>Last Year</option>
                </select>
                <input type="text" name="search" class="search-box" placeholder="Search students..." 
                       value="{{ $search ?? '' }}" id="searchInput">
                <button type="submit" style="display: none;">Search</button>
            </form>
            <form method="POST" action="{{ route('admin.analytics.export-students') }}" id="exportForm">
                @csrf
                <input type="hidden" name="search" value="{{ $search ?? '' }}">
                <input type="hidden" name="filter" value="{{ $filter ?? 'all' }}">
                <button type="button" class="export-btn" onclick="exportReport()" id="exportBtn">
                    <i class="fas fa-file-export"></i> Export Report
                </button>
            </form>
        </div>
    </div>

    <!-- Analytics Tabs -->
    <nav class="analytics-tabs">
        <a href="{{ route('admin.analytics.index') }}" class="tab-item">Overview</a>
        <a href="{{ route('admin.analytics.courses') }}" class="tab-item">Courses</a>
        <a href="{{ route('admin.analytics.students') }}" class="tab-item active">Students</a>
        <a href="{{ route('admin.analytics.revenue') }}" class="tab-item">Revenue</a>
        <a href="{{ route('admin.analytics.enrollments') }}" class="tab-item">Enrollments</a>
        <a href="{{ route('admin.analytics.peak-hours') }}" class="tab-item">Peak Hours</a>
    </nav>

    <!-- Student Statistics - 3 cards per row -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <span class="stat-value">{{ $studentStats['total'] ?? 0 }}</span>
            <span class="stat-label">Total Students</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-user-check"></i></div>
            <span class="stat-value">{{ $studentStats['active'] ?? 0 }}</span>
            <span class="stat-label">Active Students</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-graduation-cap"></i></div>
            <span class="stat-value">{{ $studentStats['completed_courses'] ?? 0 }}</span>
            <span class="stat-label">Completed Courses</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
            <span class="stat-value">{{ number_format($studentStats['average_enrollments'] ?? 0, 1) }}</span>
            <span class="stat-label">Avg Enrollments</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
            <span class="stat-value">${{ number_format($studentStats['total_revenue'] ?? 0, 2) }}</span>
            <span class="stat-label">Total Revenue</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-user-tag"></i></div>
            <span class="stat-value">${{ number_format($studentStats['average_revenue_per_student'] ?? 0, 2) }}</span>
            <span class="stat-label">Avg per Student</span>
        </div>
    </div>

    <!-- Active Students Widget -->
    <div class="table-card">
        <div class="table-header">
            <h3>Most Active Students</h3>
            <div class="info-text">
                Filtered by: {{ $filter == 'all' ? 'All Time' : ucfirst($filter) }}
            </div>
        </div>
        
        <div class="active-grid">
            @forelse($activeStudents as $student)
            <div class="active-card">
                <div class="active-avatar">{{ $student->initials }}</div>
                <div class="active-info">
                    <h4>{{ $student->name }}</h4>
                    <p>{{ $student->email }}</p>
                </div>
                <div class="active-courses">{{ $student->enrollments_count ?? 0 }} enrollments</div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-users-slash"></i>
                <h3>No active students found</h3>
                <p>There are no active students with the current filters.</p>
                @if(!empty($search) || $filter != 'all')
                <a href="{{ route('admin.analytics.students') }}" class="btn-clear-search">
                    <i class="fas fa-redo"></i> Clear Filters
                </a>
                @endif
            </div>
            @endforelse
        </div>
    </div>

    <!-- Students Table -->
    <div class="table-card">
        <div class="table-header">
            <h3>All Students ({{ $students->total() }})</h3>
            <div class="info-text">
                Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} of {{ $students->total() }} entries
                @if($filter != 'all')
                <br>Filtered by: {{ ucfirst($filter) }}
                @endif
            </div>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Enrollments</th>
                        <th>Learning Paths</th>
                        <th>Reviews</th>
                        <th>Total Spent</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                    @php
                        $totalSpent = $student->enrollments_sum_amount_paid ?? 0;
                        $enrollmentsCount = $student->enrollments_count ?? 0;
                        $learningPathsCount = $student->learning_paths_count ?? 0;
                        $reviewsCount = $student->reviews_count ?? 0;
                    @endphp
                    <tr>
                        <td>
                            <div class="student-name">
                                <div class="student-avatar">{{ $student->initials }}</div>
                                <div class="student-info">
                                    <h4>{{ $student->name }}</h4>
                                    <p>{{ $student->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="enrollment-badge">{{ $enrollmentsCount }}</span>
                        </td>
                        <td>{{ $learningPathsCount }}</td>
                        <td>{{ $reviewsCount }}</td>
                        <td>
                            <span class="revenue-badge">${{ number_format($totalSpent, 2) }}</span>
                        </td>
                        <td>
                            @if($enrollmentsCount > 0)
                                <span style="color: #10b981; font-size: 12px; font-weight: 600;">
                                    <i class="fas fa-check-circle"></i> Active
                                </span>
                            @else
                                <span style="color: #94a3b8; font-size: 12px;">
                                    <i class="fas fa-user-clock"></i> Inactive
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.students.show', $student) }}" class="action-btn btn-view" 
                                   title="View Student">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="mailto:{{ $student->email }}" class="action-btn btn-message" 
                                   title="Send Message">
                                    <i class="fas fa-envelope"></i>
                                </a>
                                @if($enrollmentsCount > 0)
                                <a href="{{ route('admin.students.enrollments', $student) }}" class="action-btn btn-enrollments" 
                                   title="View Enrollments">
                                    <i class="fas fa-list"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-user-slash"></i>
                                <h3>No students found</h3>
                                <p>There are no students available with the current filters.</p>
                                <a href="{{ route('admin.analytics.students') }}" class="btn-clear-search">
                                    <i class="fas fa-redo"></i> Clear Filters
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
        <div class="pagination-container">
            <div class="info-text">
                Page {{ $students->currentPage() }} of {{ $students->lastPage() }}
            </div>
            <div class="pagination-links">
                {{-- Previous Page Link --}}
                @if($students->onFirstPage())
                    <span class="page-arrow" disabled>
                        <i class="fas fa-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $students->previousPageUrl() }}" class="page-arrow">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @php
                    $start = max(1, $students->currentPage() - 2);
                    $end = min($students->lastPage(), $students->currentPage() + 2);
                @endphp

                @for($page = $start; $page <= $end; $page++)
                    @if($page == $students->currentPage())
                        <span class="page-link active">{{ $page }}</span>
                    @else
                        <a href="{{ $students->url($page) }}" class="page-link">{{ $page }}</a>
                    @endif
                @endfor

                {{-- Next Page Link --}}
                @if($students->hasMorePages())
                    <a href="{{ $students->nextPageUrl() }}" class="page-arrow">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <span class="page-arrow" disabled>
                        <i class="fas fa-chevron-right"></i>
                    </span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup event listeners
        initializeEventListeners();
    });

    // Setup event listeners
    function initializeEventListeners() {
        // Filter select change
        const filterSelect = document.getElementById('filterSelect');
        if (filterSelect) {
            filterSelect.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        }

        // Search input with debounce
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    document.getElementById('filterForm').submit();
                }, 500);
            });
        }

        // Hover effects for stat cards
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.05)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 4px 6px rgba(0,0,0,0.02)';
            });
        });

        // Hover effects for active cards
        document.querySelectorAll('.active-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
                this.style.boxShadow = '0 8px 16px rgba(0,0,0,0.05)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 4px 6px rgba(0,0,0,0.02)';
            });
        });

        // Hover effects for action buttons
        document.querySelectorAll('.action-btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    }

    // Export report as PDF
    function exportReport() {
        const exportBtn = document.getElementById('exportBtn');
        const originalHtml = exportBtn.innerHTML;
        
        // Show loading state
        exportBtn.classList.add('loading');
        exportBtn.disabled = true;
        exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating Report...';
        
        // Show toast
        showToast('Generating PDF report...', 'info');
        
        // Submit the export form
        document.getElementById('exportForm').submit();
        
        // Reset button after submission
        setTimeout(() => {
            exportBtn.classList.remove('loading');
            exportBtn.disabled = false;
            exportBtn.innerHTML = originalHtml;
        }, 2000);
    }

    // Show toast notification
    function showToast(message, type = 'info') {
        // Remove existing toasts
        document.querySelectorAll('.toast').forEach(toast => toast.remove());
        
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                <span>${message}</span>
            </div>
            <button onclick="this.parentElement.remove()" style="background: none; border: none; color: white; font-size: 16px; cursor: pointer;">&times;</button>
        `;
        
        // Style the toast
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#2D3E50'};
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            min-width: 300px;
            animation: slideInRight 0.3s ease;
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.remove();
                    }
                }, 300);
            }
        }, 3000);
    }
</script>
@endsection