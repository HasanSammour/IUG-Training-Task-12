@extends('layouts.app')

@section('title', 'Analytics Dashboard - Admin')

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

    .date-filter {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .filter-select {
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #475569;
        font-size: 14px;
        cursor: pointer;
        min-width: 150px;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #edf2f7;
        text-align: center;
        transition: all 0.3s ease;
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

    .stat-change {
        font-size: 12px;
        margin-top: 5px;
    }

    .change-up { color: #10b981; }
    .change-down { color: #ef4444; }

    /* Chart Cards */
    .chart-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #edf2f7;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .chart-title {
        font-size: 18px;
        color: #2D3E50;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chart-filters {
        display: flex;
        background: #f1f5f9;
        border-radius: 8px;
        padding: 3px;
    }

    .chart-filter-btn {
        padding: 6px 12px;
        font-size: 12px;
        border: none;
        border-radius: 6px;
        background: transparent;
        color: #64748b;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .chart-filter-btn:hover {
        background: rgba(45, 62, 80, 0.1);
    }

    .chart-filter-btn.active {
        background: white;
        color: #2D3E50;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        font-weight: 600;
    }

    /* Chart Containers */
    .chart-container {
        height: 300px;
        position: relative;
        margin-top: 20px;
    }

    /* Quick Links */
    .quick-links {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-top: 30px;
    }

    .quick-link-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #edf2f7;
        text-align: center;
        text-decoration: none;
        color: #2D3E50;
        transition: all 0.3s ease;
    }

    .quick-link-card:hover {
        transform: translateY(-3px);
        border-color: #2D3E50;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .quick-link-icon {
        font-size: 24px;
        color: #3182ce;
        margin-bottom: 10px;
        display: block;
    }

    /* Table Styles */
    .table-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #edf2f7;
        margin-bottom: 30px;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        text-align: left;
        padding: 15px;
        font-size: 13px;
        color: #64748b;
        border-bottom: 1px solid #f1f5f9;
        background: #fafafa;
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

    /* Loading Spinner */
    .loading-spinner {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 100;
    }

    .loading-spinner.active {
        display: block;
    }

    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #2D3E50;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Category Distribution Container */
    .category-distribution-container {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .category-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
        justify-content: center;
        max-height: 100px;
        overflow-y: auto;
        padding: 10px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        padding: 4px 8px;
        background: #f8fafc;
        border-radius: 4px;
        max-width: 150px;
    }

    .legend-color {
        width: 12px;
        height: 12px;
        border-radius: 3px;
        flex-shrink: 0;
    }

    .legend-text {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Chart Canvas Container */
    .chart-canvas-container {
        position: relative;
        height: 240px;
    }

    /* Empty State */
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 200px;
        color: #94a3b8;
        font-size: 14px;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.5;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .quick-links {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .chart-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .admin-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1 class="page-title">Analytics Dashboard</h1>
        <div class="date-filter">
            <form method="GET" action="{{ route('admin.analytics.index') }}" id="dateRangeForm">
                <select name="date_range" id="globalDateFilter" class="filter-select" onchange="this.form.submit()">
                    <option value="7" {{ $dateRange == 7 ? 'selected' : '' }}>Last 7 days</option>
                    <option value="30" {{ $dateRange == 30 ? 'selected' : '' }}>Last 30 days</option>
                    <option value="90" {{ $dateRange == 90 ? 'selected' : '' }}>Last 90 days</option>
                    <option value="365" {{ $dateRange == 365 ? 'selected' : '' }}>Last year</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Loading Spinner -->
    <div id="loadingSpinner" class="loading-spinner">
        <div class="spinner"></div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <span class="stat-value">{{ number_format($stats['total_students']) }}</span>
            <span class="stat-label">Total Students</span>
            <div class="stat-change {{ $growthStats['student_growth'] >= 0 ? 'change-up' : 'change-down' }}">
                <i class="fas fa-arrow-{{ $growthStats['student_growth'] >= 0 ? 'up' : 'down' }}"></i>
                {{ abs($growthStats['student_growth']) }}% from last period
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-book-open"></i></div>
            <span class="stat-value">{{ number_format($stats['total_courses']) }}</span>
            <span class="stat-label">Total Courses</span>
            <div class="stat-change {{ $growthStats['course_growth'] >= 0 ? 'change-up' : 'change-down' }}">
                <i class="fas fa-arrow-{{ $growthStats['course_growth'] >= 0 ? 'up' : 'down' }}"></i>
                {{ abs($growthStats['course_growth']) }}% from last period
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
            <span class="stat-value">${{ number_format($stats['total_revenue']) }}</span>
            <span class="stat-label">Total Revenue</span>
            <div class="stat-change {{ $growthStats['revenue_growth'] >= 0 ? 'change-up' : 'change-down' }}">
                <i class="fas fa-arrow-{{ $growthStats['revenue_growth'] >= 0 ? 'up' : 'down' }}"></i>
                {{ abs($growthStats['revenue_growth']) }}% from last period
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-graduation-cap"></i></div>
            <span class="stat-value">{{ number_format($stats['total_enrollments']) }}</span>
            <span class="stat-label">Total Enrollments</span>
            <div class="stat-change {{ $growthStats['enrollment_growth'] >= 0 ? 'change-up' : 'change-down' }}">
                <i class="fas fa-arrow-{{ $growthStats['enrollment_growth'] >= 0 ? 'up' : 'down' }}"></i>
                {{ abs($growthStats['enrollment_growth']) }}% from last period
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="chart-row" style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-bottom: 30px;">
        <!-- Revenue Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title"><i class="fas fa-dollar-sign"></i> Revenue Overview (Last {{ $dateRange }} days)</h3>
                <div class="chart-filters" id="revenueChartFilters">
                    <button class="chart-filter-btn active" data-period="{{ $dateRange <= 30 ? 'daily' : ($dateRange <= 90 ? 'weekly' : 'monthly') }}">
                        {{ $dateRange <= 30 ? 'Daily' : ($dateRange <= 90 ? 'Weekly' : 'Monthly') }}
                    </button>
                </div>
            </div>
            <div class="chart-container">
                <div class="chart-canvas-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Category Distribution -->
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title" style="font-size: smaller;"><i class="fas fa-chart-pie"></i> Category Distribution (Last {{ $dateRange }} days)</h3>
            </div>
            <div class="chart-container">
                <div class="category-distribution-container">
                    <div class="chart-canvas-container">
                        <canvas id="categoryChart"></canvas>
                    </div>
                    <div class="category-legend" id="categoryLegend"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enrollments Chart -->
    <div class="chart-card">
        <div class="chart-header">
            <h3 class="chart-title"><i class="fas fa-sign-in-alt"></i> Enrollments Trend (Last {{ $dateRange }} days)</h3>
            <div class="chart-filters" id="enrollmentChartFilters">
                <button class="chart-filter-btn active" data-period="{{ $dateRange <= 7 ? 'daily' : ($dateRange <= 30 ? 'weekly' : 'monthly') }}">
                    {{ $dateRange <= 7 ? 'Last 7 days' : ($dateRange <= 30 ? 'Last 30 days' : 'Monthly') }}
                </button>
            </div>
        </div>
        <div class="chart-container">
            <div class="chart-canvas-container">
                <canvas id="enrollmentChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Analytics Links -->
    <div class="quick-links">
        <a href="{{ route('admin.analytics.courses') }}" class="quick-link-card">
            <i class="fas fa-book quick-link-icon"></i>
            <div>Course Analytics</div>
        </a>
        <a href="{{ route('admin.analytics.students') }}" class="quick-link-card">
            <i class="fas fa-users quick-link-icon"></i>
            <div>Student Analytics</div>
        </a>
        <a href="{{ route('admin.analytics.revenue') }}" class="quick-link-card">
            <i class="fas fa-dollar-sign quick-link-icon"></i>
            <div>Revenue Analytics</div>
        </a>
        <a href="{{ route('admin.analytics.enrollments') }}" class="quick-link-card">
            <i class="fas fa-chart-line quick-link-icon"></i>
            <div>Enrollment Analytics</div>
        </a>
        <a href="{{ route('admin.analytics.peak-hours') }}" class="quick-link-card">
            <i class="fas fa-clock quick-link-icon"></i>
            <div>Peak Hours</div>
        </a>
    </div>

    <!-- Recent Activity Tables -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 30px;">
        <!-- Popular Courses -->
        <div class="table-card">
            <div class="chart-header">
                <h3 style="color: #2D3E50; font-size: 22px;">Most Popular Courses (Last {{ $dateRange }} days)</h3>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Enrollments</th>
                            <th>Rating</th>
                        </tr>
                    </thead>
                    <tbody id="popularCoursesTable">
                        @forelse($popularCourses as $course)
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: #2D3E50;">{{ $course->title }}</div>
                                <div style="font-size: 12px; color: #94a3b8;">{{ $course->category->name ?? 'Uncategorized' }}</div>
                            </td>
                            <td>{{ number_format($course->enrollments_count) }}</td>
                            <td>
                                <div style="color: #f59e0b;">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($course->rating))
                                            ★
                                        @elseif($i == ceil($course->rating) && fmod($course->rating, 1) >= 0.5)
                                            ☆
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                    <span style="color: #64748b; margin-left: 5px;">{{ $course->rating }}</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 20px; color: #94a3b8;">
                                No popular courses found for the selected period
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Active Students -->
        <div class="table-card">
            <div class="chart-header">
                <h3 style="color: #2D3E50; font-size: 22px;">Most Active Students (Last {{ $dateRange }} days)</h3>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Enrollments</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody id="activeStudentsTable">
                        @forelse($activeStudents as $student)
                        @php
                            $enrollmentProgress = $student->enrollments()
                                ->where('enrolled_at', '>=', now()->subDays($dateRange))
                                ->avg('progress_percentage') ?? 0;
                        @endphp
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: #2D3E50;">{{ $student->name }}</div>
                                <div style="font-size: 12px; color: #94a3b8;">{{ $student->email }}</div>
                            </td>
                            <td>{{ $student->enrollments_count ?? 0 }}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 60px; height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden;">
                                        <div style="width: {{ $enrollmentProgress }}%; height: 100%; background: #2D3E50;"></div>
                                    </div>
                                    <span style="font-size: 12px; color: #64748b;">{{ round($enrollmentProgress) }}%</span>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align: center; padding: 20px; color: #94a3b8;">
                                No active students found for the selected period
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('chartjs/chart.umd.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Global variables
        let revenueChart = null;
        let categoryChart = null;
        let enrollmentChart = null;
        
        // Color palette for charts
        const chartColors = [
            '#2D3E50', '#3182ce', '#10b981', '#f59e0b', 
            '#8b5cf6', '#ec4899', '#14b8a6', '#f97316',
            '#6366f1', '#84cc16', '#ef4444', '#06b6d4'
        ];

        // Initialize all charts with real data
        function initializeCharts() {
            initializeRevenueChart();
            initializeCategoryChart();
            initializeEnrollmentChart();
        }

        // Initialize Revenue Chart with real data
        function initializeRevenueChart() {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            
            if (revenueChart) {
                revenueChart.destroy();
            }
            
            const revenueData = @json($revenueChart);
            const labels = revenueData.map(item => item.date);
            const data = revenueData.map(item => item.revenue);
            
            revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Revenue',
                        data: data,
                        borderColor: '#2D3E50',
                        backgroundColor: 'rgba(45, 62, 80, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
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
                            grid: { color: '#f1f5f9' },
                            ticks: { 
                                callback: function(value) { return '$' + value.toLocaleString(); }
                            }
                        },
                        x: { 
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // Initialize Category Chart with real data
        function initializeCategoryChart() {
            const ctx = document.getElementById('categoryChart').getContext('2d');
            
            if (categoryChart) {
                categoryChart.destroy();
            }
            
            const categoryData = @json($categoryDistribution);
            const labels = categoryData.map(item => item.name);
            const data = categoryData.map(item => item.count);
            
            // Sort categories by count for better display
            const sortedIndices = data.map((_, index) => index)
                .sort((a, b) => data[b] - data[a])
                .slice(0, 8); // Limit to top 8 categories
            
            const sortedLabels = sortedIndices.map(i => labels[i]);
            const sortedData = sortedIndices.map(i => data[i]);
            const sortedColors = sortedIndices.map(i => chartColors[i % chartColors.length]);
            
            categoryChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: sortedLabels,
                    datasets: [{
                        data: sortedData,
                        backgroundColor: sortedColors,
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    cutout: '60%'
                }
            });
            
            // Update legend with real data
            updateCategoryLegend(sortedLabels, sortedColors, sortedData);
        }

        // Update category legend
        function updateCategoryLegend(labels, colors, data) {
            const legendContainer = document.getElementById('categoryLegend');
            legendContainer.innerHTML = '';
            
            const total = data.reduce((sum, val) => sum + val, 0);
            
            labels.forEach((label, index) => {
                const percentage = total > 0 
                    ? ((data[index] / total) * 100).toFixed(1)
                    : 0;
                
                const legendItem = document.createElement('div');
                legendItem.className = 'legend-item';
                legendItem.innerHTML = `
                    <div class="legend-color" style="background: ${colors[index]}"></div>
                    <span class="legend-text" title="${label}">${label}</span>
                    <span style="font-weight: 600; margin-left: auto; font-size: 11px;">${percentage}%</span>
                `;
                legendContainer.appendChild(legendItem);
            });
        }

        // Initialize Enrollment Chart with real data
        function initializeEnrollmentChart() {
            const ctx = document.getElementById('enrollmentChart').getContext('2d');
            
            if (enrollmentChart) {
                enrollmentChart.destroy();
            }
            
            const enrollmentData = @json($enrollmentChart);
            const labels = enrollmentData.map(item => item.date);
            const data = enrollmentData.map(item => item.count);
            
            enrollmentChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Enrollments',
                        data: data,
                        backgroundColor: '#3182ce',
                        borderRadius: 6,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `Enrollments: ${context.parsed.y}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            ticks: { stepSize: Math.ceil(Math.max(...data) / 5) || 1 }
                        },
                        x: { 
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        // Show loading state
        function showLoading(show) {
            const loadingSpinner = document.getElementById('loadingSpinner');
            if (show) {
                loadingSpinner.classList.add('active');
            } else {
                loadingSpinner.classList.remove('active');
            }
        }

        // Handle date range filter change
        document.getElementById('globalDateFilter').addEventListener('change', function() {
            showLoading(true);
            
            // Form will auto-submit via onchange attribute
            // We just need to show loading spinner
            setTimeout(() => {
                showLoading(false);
            }, 2000);
        });

        // Handle chart filter buttons
        function setupChartFilters(containerId, chartType) {
            const container = document.getElementById(containerId);
            const buttons = container.querySelectorAll('.chart-filter-btn');
            
            buttons.forEach(button => {
                button.addEventListener('click', async function() {
                    buttons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    const period = this.dataset.period;
                    showLoading(true);
                    
                    try {
                        const response = await fetch(`/admin/analytics/chart-data?days={{ $dateRange }}&period=${period}`);
                        const data = await response.json();
                        
                        if (chartType === 'revenue') {
                            updateRevenueChart(data.revenue);
                        } else if (chartType === 'enrollment') {
                            updateEnrollmentChart(data.enrollments);
                        }
                        
                        updateCategoryChart(data.categories);
                    } catch (error) {
                        console.error('Error fetching chart data:', error);
                    } finally {
                        showLoading(false);
                    }
                });
            });
        }

        // Update revenue chart with new data
        function updateRevenueChart(revenueData) {
            const labels = revenueData.map(item => item.date);
            const data = revenueData.map(item => item.revenue);
            
            revenueChart.data.labels = labels;
            revenueChart.data.datasets[0].data = data;
            revenueChart.update();
        }

        // Update enrollment chart with new data
        function updateEnrollmentChart(enrollmentData) {
            const labels = enrollmentData.map(item => item.date);
            const data = enrollmentData.map(item => item.count);
            
            enrollmentChart.data.labels = labels;
            enrollmentChart.data.datasets[0].data = data;
            enrollmentChart.update();
        }

        // Update category chart with new data
        function updateCategoryChart(categoryData) {
            const labels = categoryData.map(item => item.name);
            const data = categoryData.map(item => item.count);
            
            // Sort categories by count for better display
            const sortedIndices = data.map((_, index) => index)
                .sort((a, b) => data[b] - data[a])
                .slice(0, 8);
            
            const sortedLabels = sortedIndices.map(i => labels[i]);
            const sortedData = sortedIndices.map(i => data[i]);
            const sortedColors = sortedIndices.map(i => chartColors[i % chartColors.length]);
            
            categoryChart.data.labels = sortedLabels;
            categoryChart.data.datasets[0].data = sortedData;
            categoryChart.data.datasets[0].backgroundColor = sortedColors;
            categoryChart.update();
            
            updateCategoryLegend(sortedLabels, sortedColors, sortedData);
        }

        // Fetch quick stats on page load
        async function fetchQuickStats() {
            try {
                const response = await fetch('/admin/analytics/quick-stats?days={{ $dateRange }}');
                const data = await response.json();
                
                // Update stats if needed
                document.getElementById('totalStudents').textContent = data.total_students.toLocaleString();
                document.getElementById('totalCourses').textContent = data.total_courses.toLocaleString();
                document.getElementById('totalRevenue').textContent = '$' + data.total_revenue.toLocaleString();
                document.getElementById('totalEnrollments').textContent = data.total_enrollments.toLocaleString();
                
            } catch (error) {
                console.error('Error fetching quick stats:', error);
            }
        }

        // Initialize everything
        initializeCharts();
        
        // Fetch quick stats
        fetchQuickStats();

        // Add smooth animations
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Add click animation to quick links
        document.querySelectorAll('.quick-link-card').forEach(link => {
            link.addEventListener('click', function(e) {
                if (!this.getAttribute('href')) {
                    e.preventDefault();
                }
                // Add ripple effect
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(45, 62, 80, 0.1);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                `;
                
                this.appendChild(ripple);
                setTimeout(() => ripple.remove(), 600);
            });
        });

        // Add CSS for ripple effect
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endsection