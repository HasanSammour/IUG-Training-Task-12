@extends('layouts.app')

@section('title', 'Enrollments Analytics - Admin')
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
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
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

        /* Charts Grid - 2 charts per row */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        @media (max-width: 768px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }
        }

        .chart-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            border: 1px solid #edf2f7;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .chart-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .chart-header h3 {
            font-size: 18px;
            color: #2D3E50;
            font-weight: 600;
        }

        .chart-placeholder {
            height: 300px;
            background: #f8fafc;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 14px;
        }

        /* Status Distribution Cards */
        .status-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .status-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .status-card {
            text-align: center;
            padding: 15px;
            border-radius: 10px;
            background: #f8fafc;
        }

        .status-value {
            display: block;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .status-label {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending .status-value {
            color: #f59e0b;
        }

        .status-pending .status-label {
            color: #92400e;
        }

        .status-active .status-value {
            color: #10b981;
        }

        .status-active .status-label {
            color: #065f46;
        }

        .status-completed .status-value {
            color: #3b82f6;
        }

        .status-completed .status-label {
            color: #1e40af;
        }

        .status-cancelled .status-value {
            color: #ef4444;
        }

        .status-cancelled .status-label {
            color: #991b1b;
        }

        /* Students Table */
        .table-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            border: 1px solid #edf2f7;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
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

        /* Status Badges */
        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-active {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-completed {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Progress Bar */
        .progress-container {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 120px;
        }

        .progress-bar {
            flex: 1;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: #2D3E50;
            border-radius: 3px;
        }

        /* Amount Badge */
        .amount-badge {
            background: #f0f9ff;
            color: #0369a1;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        /* Action Buttons */
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

        .btn-edit {
            background: #f59e0b;
        }

        .btn-edit:hover {
            background: #d97706;
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
            <h1 class="page-title">Enrollments Analytics</h1>
            <div class="filter-section">
                <form method="GET" action="{{ route('admin.analytics.enrollments') }}" id="filterForm">
                    <input type="text" name="search" class="search-box" placeholder="Search enrollments..."
                        value="{{ request('search') ?? '' }}" id="searchInput">
                    <button type="submit" style="display: none;">Search</button>
                </form>
                <form method="POST" action="{{ route('admin.analytics.export-enrollments') }}" id="exportForm">
                    @csrf
                    <input type="hidden" name="search" value="{{ request('search') ?? '' }}">
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
            <a href="{{ route('admin.analytics.students') }}" class="tab-item">Students</a>
            <a href="{{ route('admin.analytics.revenue') }}" class="tab-item">Revenue</a>
            <a href="{{ route('admin.analytics.enrollments') }}" class="tab-item active">Enrollments</a>
            <a href="{{ route('admin.analytics.peak-hours') }}" class="tab-item">Peak Hours</a>
        </nav>

        <!-- Enrollment Statistics - 3 cards per row -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-user-plus"></i></div>
                <span class="stat-value">{{ $enrollmentStats['total'] ?? 0 }}</span>
                <span class="stat-label">Total Enrollments</span>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-play-circle"></i></div>
                <span class="stat-value">{{ $enrollmentStats['active'] ?? 0 }}</span>
                <span class="stat-label">Active Enrollments</span>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                <span class="stat-value">{{ $enrollmentStats['completed'] ?? 0 }}</span>
                <span class="stat-label">Completed</span>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                <span class="stat-value">{{ $enrollmentStats['pending'] ?? 0 }}</span>
                <span class="stat-label">Pending</span>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
                <span class="stat-value">{{ $enrollmentStats['cancelled'] ?? 0 }}</span>
                <span class="stat-label">Cancelled</span>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
                <span class="stat-value">{{ $enrollmentStats['average_progress'] ?? 0 }}%</span>
                <span class="stat-label">Avg Progress</span>
            </div>
        </div>

        <!-- Charts Section - 2 charts per row -->
        <div class="charts-grid">
            <!-- Enrollment Trend Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <h3>Enrollment Trends - Last 30 Days</h3>
                </div>

                @if(isset($dailyEnrollments) && count($dailyEnrollments) > 0)
                    <div class="chart-placeholder" id="trendChartPlaceholder">
                        <canvas id="trendChart" height="280"></canvas>
                    </div>
                    <div style="text-align: center; margin-top: 15px; color: #64748b; font-size: 12px;">
                        Showing enrollment data for the last 30 days
                    </div>
                @else
                    <div class="chart-placeholder">
                        <i class="fas fa-chart-line"></i><br>
                        No enrollment trend data available
                    </div>
                @endif
            </div>

            <!-- Status Distribution Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <h3>Enrollments by Status</h3>
                </div>

                @if(isset($enrollmentsByStatus) && count($enrollmentsByStatus) > 0)
                    <div class="chart-placeholder" id="statusChartPlaceholder">
                        <canvas id="statusChart" height="280"></canvas>
                    </div>

                    <div class="status-grid">
                        @foreach($enrollmentsByStatus as $status)
                            <div class="status-card status-{{ $status->status }}">
                                <span class="status-value">{{ $status->count }}</span>
                                <span class="status-label">{{ ucfirst($status->status) }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="chart-placeholder">
                        <i class="fas fa-chart-pie"></i><br>
                        No status distribution data available
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Enrollments Table -->
        <div class="table-card">
            <div class="table-header">
                <h3>Recent Enrollments ({{ $enrollments->total() }})</h3>
                <div class="info-text">
                    Showing {{ $enrollments->firstItem() ?? 0 }} to {{ $enrollments->lastItem() ?? 0 }} of
                    {{ $enrollments->total() }} entries
                </div>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th style="min-width: 180px;">Enrollment ID</th>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Enrolled Date</th>
                            <th>Status</th>
                            <th>Progress</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($enrollments as $enrollment)
                            <tr>
                                <td>
                                    <strong style="color: #3182ce;">{{ $enrollment->enrollment_id }}</strong>
                                </td>
                                <td>
                                    <div class="student-name">
                                        <div class="student-avatar">{{ $enrollment->user->initials }}</div>
                                        <div class="student-info">
                                            <h4>{{ $enrollment->user->name }}</h4>
                                            <p>{{ $enrollment->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="min-width: 300px;">
                                        <div style="font-weight: 600; color: #2D3E50;">{{ $enrollment->course->title }}</div>
                                        <div style="font-size: 12px; color: #94a3b8;">
                                            {{ $enrollment->course->category->name ?? 'Uncategorized' }}
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $enrollment->enrolled_at->format('M d, Y') }}</td>
                                <td>
                                    <span class="status-badge badge-{{ $enrollment->status }}">
                                        {{ ucfirst($enrollment->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="progress-container">
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ $enrollment->progress_percentage }}%">
                                            </div>
                                        </div>
                                        <span
                                            style="font-size: 12px; font-weight: 600; min-width: 30px;">{{ $enrollment->progress_percentage }}%</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="amount-badge">${{ number_format($enrollment->amount_paid, 2) }}</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.enrollments.show', $enrollment) }}" class="action-btn btn-view"
                                            title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.enrollments.edit', $enrollment) }}" class="action-btn btn-edit"
                                            title="Edit Enrollment">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox"></i>
                                        <h3>No enrollments found</h3>
                                        <p>There are no enrollments available with the current filters.</p>
                                        <a href="{{ route('admin.analytics.enrollments') }}" class="btn-clear-search">
                                            <i class="fas fa-redo"></i> Clear Search
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($enrollments->hasPages())
                <div class="pagination-container">
                    <div class="info-text">
                        Page {{ $enrollments->currentPage() }} of {{ $enrollments->lastPage() }}
                    </div>
                    <div class="pagination-links">
                        {{-- Previous Page Link --}}
                        @if($enrollments->onFirstPage())
                            <span class="page-arrow" disabled>
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $enrollments->previousPageUrl() }}" class="page-arrow">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @for($i = 1; $i <= min(5, $enrollments->lastPage()); $i++)
                            @if($i == $enrollments->currentPage())
                                <span class="page-link active">{{ $i }}</span>
                            @else
                                <a href="{{ $enrollments->url($i) }}" class="page-link">{{ $i }}</a>
                            @endif
                        @endfor

                        {{-- Next Page Link --}}
                        @if($enrollments->hasMorePages())
                            <a href="{{ $enrollments->nextPageUrl() }}" class="page-arrow">
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
        document.addEventListener('DOMContentLoaded', function () {
            // Setup event listeners
            initializeEventListeners();

            // Initialize charts
            initializeCharts();
        });

        // Setup event listeners
        function initializeEventListeners() {
            // Search input with debounce
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                let searchTimeout;
                searchInput.addEventListener('input', function () {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        document.getElementById('filterForm').submit();
                    }, 500);
                });
            }

            // Hover effects for stat cards
            document.querySelectorAll('.stat-card').forEach(card => {
                card.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.05)';
                });

                card.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 4px 6px rgba(0,0,0,0.02)';
                });
            });

            // Hover effects for chart cards
            document.querySelectorAll('.chart-card').forEach(card => {
                card.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-3px)';
                    this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.05)';
                });

                card.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 4px 6px rgba(0,0,0,0.02)';
                });
            });

            // Hover effects for action buttons
            document.querySelectorAll('.action-btn').forEach(btn => {
                btn.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-2px)';
                });

                btn.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Table row click for details
            document.querySelectorAll('table tbody tr').forEach(row => {
                if (row.querySelector('.action-btn.btn-view')) {
                    row.addEventListener('click', function (e) {
                        // Don't trigger if clicking on action buttons
                        if (!e.target.closest('.action-btn')) {
                            const viewBtn = this.querySelector('.btn-view');
                            if (viewBtn) {
                                window.location.href = viewBtn.href;
                            }
                        }
                    });
                    row.style.cursor = 'pointer';
                }
            });
        }

        // Initialize charts
        function initializeCharts() {
            // Enrollment Trend Chart
            @if(isset($dailyEnrollments) && count($dailyEnrollments) > 0)
                const trendCtx = document.getElementById('trendChart').getContext('2d');
                const dates = @json(array_column($dailyEnrollments, 'date'));
                const counts = @json(array_column($dailyEnrollments, 'count'));

                new Chart(trendCtx, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Daily Enrollments',
                            data: counts,
                            borderColor: '#2D3E50',
                            backgroundColor: 'rgba(45, 62, 80, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.3,
                            pointBackgroundColor: '#2D3E50',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4
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
                                backgroundColor: '#2D3E50',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                cornerRadius: 6,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                },
                                ticks: {
                                    stepSize: Math.ceil(Math.max(...counts) / 5)
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
            @endif

                // Status Distribution Chart
                @if(isset($enrollmentsByStatus) && count($enrollmentsByStatus) > 0)
                    const statusCtx = document.getElementById('statusChart').getContext('2d');
                    const statusLabels = @json($enrollmentsByStatus->pluck('status')->map(fn($s) => ucfirst($s)));
                    const statusCounts = @json($enrollmentsByStatus->pluck('count'));
                    const statusColors = {
                        'Pending': '#f59e0b',
                        'Active': '#10b981',
                        'Completed': '#3b82f6',
                        'Cancelled': '#ef4444'
                    };

                    new Chart(statusCtx, {
                        type: 'doughnut',
                        data: {
                            labels: statusLabels,
                            datasets: [{
                                data: statusCounts,
                                backgroundColor: statusLabels.map(label => statusColors[label]),
                                borderWidth: 0,
                                hoverOffset: 15
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '65%',
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        usePointStyle: true,
                                        pointStyle: 'circle'
                                    }
                                }
                            }
                        }
                    });
                @endif
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
                <button onclick="this.parentElement.remove()">&times;</button>
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
