@extends('layouts.app')

@section('title', 'Course Analytics - Admin')

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

    .export-btn.loading {
        background: #94a3b8;
        cursor: not-allowed;
    }

    .export-btn.loading i {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Stats Grid - 3 cards per row */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    @media (max-width: 1024px) {
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

    /* Charts Grid */
    .charts-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 30px;
    }

    @media (max-width: 1024px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Revenue Chart Full Width */
    .chart-full-width {
        grid-column: 1 / -1;
        margin-bottom: 30px;
    }

    .chart-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #edf2f7;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .chart-title {
        font-size: 18px;
        color: #2D3E50;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chart-container {
        height: 300px;
        position: relative;
        margin-top: 15px;
        flex: 1;
    }

    /* Table Styles */
    .table-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #edf2f7;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        min-width: 100%;
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

    .course-name {
        color: #2D3E50;
        font-weight: 600;
        max-width: 250px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .course-name a {
        color: inherit;
        text-decoration: none;
    }

    .course-name a:hover {
        color: #3182ce;
    }

    .category-badge {
        padding: 4px 10px;
        background: #e0f2fe;
        color: #0369a1;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }

    .rating-badge {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        padding: 4px 10px;
        background: #fef3c7;
        color: #92400e;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-featured {
        background: #dbeafe;
        color: #1e40af;
    }

    /* Action Buttons */
    .action-btn {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s ease;
    }

    .btn-view {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #e0f2fe;
    }

    .btn-view:hover {
        background: #0369a1;
        color: white;
    }

    .btn-edit {
        background: #f0f9ff;
        color: #1e40af;
        border: 1px solid #f0f9ff;
    }

    .btn-edit:hover {
        background: #1e40af;
        color: white;
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

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #94a3b8;
        min-width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
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

    /* Toast Notification Styles */
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

    .toast-success {
        background: #10b981;
    }

    .toast-error {
        background: #ef4444;
    }

    .toast-warning {
        background: #f59e0b;
    }

    .toast-info {
        background: #3b82f6;
    }

    .toast button {
        background: none;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
        padding: 0;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0.8;
        transition: opacity 0.2s;
    }

    .toast button:hover {
        opacity: 1;
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

    /* Responsive */
    @media (max-width: 768px) {
        .admin-header {
            flex-direction: column;
            gap: 15px;
            align-items: stretch;
        }

        .filter-section {
            width: 100%;
            justify-content: stretch;
        }

        .search-box,
        .export-btn {
            flex: 1;
            min-width: unset;
        }

        .table-header {
            flex-direction: column;
            gap: 15px;
            align-items: stretch;
        }

        .table-header h3,
        .info-text {
            text-align: center;
        }

        .search-box {
            width: 100%;
        }

        .pagination-container {
            justify-content: center;
            text-align: center;
        }

        .analytics-tabs {
            padding: 15px 0;
        }

        .toast {
            min-width: unset;
            max-width: 90%;
            left: 5%;
            right: 5%;
            top: 10px;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1 class="page-title">Course Analytics</h1>
        <div class="filter-section">
            <form method="GET" action="{{ route('admin.analytics.courses') }}" id="filterForm">
                <input type="text" name="search" class="search-box" placeholder="Search courses..." 
                       value="{{ $search ?? '' }}" id="searchInput">
                <input type="hidden" name="filter" value="{{ $filter ?? 'all' }}" id="filterInput">
                <button type="submit" style="display: none;">Search</button>
            </form>
            <form method="POST" action="{{ route('admin.analytics.export-courses') }}" id="exportForm">
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
        <a href="{{ route('admin.analytics.courses') }}" class="tab-item active">Courses</a>
        <a href="{{ route('admin.analytics.students') }}" class="tab-item">Students</a>
        <a href="{{ route('admin.analytics.revenue') }}" class="tab-item">Revenue</a>
        <a href="{{ route('admin.analytics.enrollments') }}" class="tab-item">Enrollments</a>
        <a href="{{ route('admin.analytics.peak-hours') }}" class="tab-item">Peak Hours</a>
    </nav>

    <!-- Course Statistics - 6 cards in 2 rows (3 per row) -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-book-open"></i></div>
            <span class="stat-value">{{ $courseStats['total'] ?? 0 }}</span>
            <span class="stat-label">Total Courses</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <span class="stat-value">{{ $courseStats['active'] ?? 0 }}</span>
            <span class="stat-label">Active Courses</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-star"></i></div>
            <span class="stat-value">{{ $courseStats['featured'] ?? 0 }}</span>
            <span class="stat-label">Featured</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
            <span class="stat-value">${{ number_format($courseStats['average_price'] ?? 0, 2) }}</span>
            <span class="stat-label">Avg Price</span>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-star-half-alt"></i></div>
            <span class="stat-value">{{ number_format($courseStats['average_rating'] ?? 0, 1) }}</span>
            <span class="stat-label">Avg Rating</span>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
            <span class="stat-value">${{ number_format($courseStats['total_revenue'] ?? 0, 2) }}</span>
            <span class="stat-label">Total Revenue</span>
        </div>
    </div>

    <!-- First Row: Two Charts Side by Side -->
    <div class="charts-grid">
        <!-- Rating Distribution Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title"><i class="fas fa-chart-pie"></i> Course Ratings Distribution</h3>
            </div>
            <div class="chart-container">
                <canvas id="ratingChart"></canvas>
            </div>
        </div>

        <!-- Enrollment Trends Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title"><i class="fas fa-chart-line"></i> Enrollment Trends (Last 7 Days)</h3>
            </div>
            <div class="chart-container">
                <canvas id="enrollmentTrendsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Second Row: Revenue by Category Full Width -->
    <div class="chart-full-width">
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title"><i class="fas fa-chart-bar"></i> Revenue by Category</h3>
            </div>
            <div class="chart-container">
                <canvas id="revenueByCategoryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Courses Table -->
    <div class="table-card">
        <div class="table-header">
            <h3>All Courses ({{ $courses->total() }})</h3>
            <div class="info-text">
                Showing {{ $courses->firstItem() ?? 0 }} to {{ $courses->lastItem() ?? 0 }} of {{ $courses->total() }} entries
            </div>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Category</th>
                        <th>Students</th>
                        <th>Rating</th>
                        <th>Price</th>
                        <th>Revenue</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                    @php
                        $revenue = $course->enrollments_sum_amount_paid ?? 0;
                        $reviewsCount = $course->reviews_count ?? 0;
                    @endphp
                    <tr>
                        <td>
                            <div class="course-name">
                                <a href="{{ route('courses.show', $course->slug) }}" target="_blank">
                                    {{ $course->title }}
                                </a>
                            </div>
                            <div style="font-size: 11px; color: #94a3b8; margin-top: 2px;">
                                {{ $course->instructor_name }}
                            </div>
                        </td>
                        <td>
                            <span class="category-badge">
                                {{ $course->category->name ?? 'Uncategorized' }}
                            </span>
                        </td>
                        <td>{{ $course->total_students }}</td>
                        <td>
                            <span class="rating-badge">
                                <i class="fas fa-star"></i> {{ number_format($course->rating, 1) }}
                                @if($reviewsCount > 0)
                                <span style="font-size: 10px; color: #94a3b8;">({{ $reviewsCount }})</span>
                                @endif
                            </span>
                        </td>
                        <td>${{ number_format($course->final_price, 2) }}</td>
                        <td>${{ number_format($revenue, 2) }}</td>
                        <td>
                            @if($course->is_active && $course->is_featured)
                                <span class="status-badge status-featured">Featured</span>
                            @elseif($course->is_active)
                                <span class="status-badge status-active">Active</span>
                            @else
                                <span class="status-badge status-inactive">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 5px;">
                                <a href="{{ route('courses.show', $course->slug) }}" target="_blank" 
                                   class="action-btn btn-view" title="View Course">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.courses.edit', $course) }}" 
                                   class="action-btn btn-edit" title="Edit Course">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-book-open"></i>
                                <h3>No courses found</h3>
                                <p>There are no courses available with the current filters.</p>
                                <p style="margin-top: 10px;">
                                    <a href="{{ route('admin.analytics.courses') }}" class="action-btn btn-view">
                                        <i class="fas fa-redo"></i> Clear Search
                                    </a>
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($courses->hasPages())
        <div class="pagination-container">
            <div class="pagination-links">
                {{-- Previous Page Link --}}
                @if($courses->onFirstPage())
                    <span class="page-arrow" disabled>
                        <i class="fas fa-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $courses->previousPageUrl() }}" class="page-arrow">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach($courses->getUrlRange(1, min(5, $courses->lastPage())) as $page => $url)
                    @if($page == $courses->currentPage())
                        <span class="page-link active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if($courses->hasMorePages())
                    <a href="{{ $courses->nextPageUrl() }}" class="page-arrow">
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
<script src="{{ asset('chartjs/chart.umd.js') }}"></script>
<script>
    // Global variable for toast timeout
    let toastTimeout = null;

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize charts
        initializeCharts();
        
        // Setup event listeners
        initializeEventListeners();
    });

    // Chart instances
    let ratingChart = null;
    let enrollmentTrendsChart = null;
    let revenueByCategoryChart = null;

    // Initialize all charts
    function initializeCharts() {
        initializeRatingChart();
        initializeEnrollmentTrendsChart();
        initializeRevenueByCategoryChart();
    }

    // Initialize Rating Distribution Chart
    function initializeRatingChart() {
        const ctx = document.getElementById('ratingChart').getContext('2d');
        
        if (ratingChart) {
            ratingChart.destroy();
        }
        
        const ratingData = @json($ratingDistribution);
        const labels = ratingData.map(item => item.range + '★');
        const data = ratingData.map(item => item.count);
        
        ratingChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        '#ef4444', // 0-1: Red
                        '#f59e0b', // 1-2: Orange
                        '#84cc16', // 2-3: Green
                        '#06b6d4', // 3-4: Cyan
                        '#10b981', // 4-5: Emerald
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.raw / total) * 100).toFixed(1);
                                return `${context.label}: ${context.raw} courses (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });
    }

    // Initialize Enrollment Trends Chart
    function initializeEnrollmentTrendsChart() {
        const ctx = document.getElementById('enrollmentTrendsChart').getContext('2d');
        
        if (enrollmentTrendsChart) {
            enrollmentTrendsChart.destroy();
        }
        
        const trendsData = @json($enrollmentTrends);
        const labels = trendsData.map(item => item.full_date || item.date);
        const enrollmentsData = trendsData.map(item => item.enrollments);
        const revenueData = trendsData.map(item => item.revenue);
        
        enrollmentTrendsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Enrollments',
                        data: enrollmentsData,
                        borderColor: '#2D3E50',
                        backgroundColor: 'rgba(45, 62, 80, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Revenue',
                        data: revenueData,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                if (context.dataset.label === 'Revenue') {
                                    return `Revenue: $${context.parsed.y.toLocaleString()}`;
                                }
                                return `Enrollments: ${context.parsed.y}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Enrollments'
                        },
                        grid: {
                            color: '#f1f5f9'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Revenue ($)'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Initialize Revenue by Category Chart
    function initializeRevenueByCategoryChart() {
        const ctx = document.getElementById('revenueByCategoryChart').getContext('2d');
        
        if (revenueByCategoryChart) {
            revenueByCategoryChart.destroy();
        }
        
        const categoryData = @json($revenueByCategory);
        const labels = categoryData.map(item => item.name);
        const revenueData = categoryData.map(item => item.revenue);
        
        revenueByCategoryChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue',
                    data: revenueData,
                    backgroundColor: '#3182ce',
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Revenue: $${context.parsed.y.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });
    }

    // Setup event listeners
    function initializeEventListeners() {
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

        // Action button effects
        document.querySelectorAll('.action-btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    }

    // Show toast notification
    function showToast(message, type = 'info') {
        // Clear any existing timeout
        if (toastTimeout) {
            clearTimeout(toastTimeout);
        }

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
            <button onclick="removeToast(this.parentElement)">&times;</button>
        `;
        
        // Style the toast
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : type === 'warning' ? '#f59e0b' : '#3b82f6'};
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
        toastTimeout = setTimeout(() => {
            removeToast(toast);
        }, 3000);
    }

    // Remove toast with animation
    function removeToast(toastElement) {
        if (toastElement && toastElement.parentNode) {
            toastElement.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => {
                if (toastElement.parentNode) {
                    toastElement.remove();
                }
            }, 300);
        }
    }

    // Export report as PDF using DOMPDF
    function exportReport() {
        const exportBtn = document.getElementById('exportBtn');
        const originalHtml = exportBtn.innerHTML;
        
        // Show loading state
        exportBtn.classList.add('loading');
        exportBtn.disabled = true;
        exportBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating Report...';
        
        // Show toast notification
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
</script>
@endsection