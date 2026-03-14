@extends('layouts.app')

@section('title', 'Peak Hours Analytics - Admin')
@section('body-class', 'admin-page')

@section('styles')
<style>
    .admin-container {
        padding: 20px;
        max-width: 1400px;
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
        font-size: 32px;
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
        background: #64748b;
        cursor: not-allowed;
    }

    /* Analytics Tabs */
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

    /* Stats Grid - Wider 4 cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin-bottom: 30px;
    }

    @media (max-width: 1200px) {
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
        padding: 30px 25px;
        border: 1px solid #edf2f7;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        min-height: 180px;
        min-width: 250px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        background: #f0f7ff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: #2D3E50;
        font-size: 24px;
    }

    .stat-value {
        display: block;
        font-size: 32px;
        font-weight: 700;
        color: #2D3E50;
        margin-bottom: 8px;
        line-height: 1.2;
    }

    .stat-label {
        font-size: 15px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .stat-change {
        font-size: 13px;
        margin-top: 5px;
        font-weight: 500;
        padding: 4px 10px;
        border-radius: 20px;
        background: #f8fafc;
        display: inline-block;
    }

    .stat-change.positive {
        color: #10b981;
        background: #f0fdf4;
    }

    .stat-change.negative {
        color: #ef4444;
        background: #fef2f2;
    }

    /* Card Layout - Matching student page */
    .card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #edf2f7;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .card-header h3 {
        font-size: 18px;
        color: #2D3E50;
        font-weight: 600;
    }

    /* Charts Container - 2 charts per row */
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

    .chart-container {
        height: 300px;
        background: #f8fafc;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
    }

    /* Bar Chart Styling */
    .bar-chart {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        height: calc(100% - 40px);
        padding: 20px;
        gap: 8px;
    }

    .bar-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
        flex: 1;
        position: relative;
    }

    .bar {
        width: 80%;
        background: #2D3E50;
        border-radius: 4px 4px 0 0;
        transition: all 0.3s ease;
        position: relative;
        min-height: 10px;
    }

    .bar.peak {
        background: linear-gradient(to top, #10b981, #059669);
    }

    .bar-label {
        margin-top: 8px;
        font-size: 11px;
        color: #64748b;
        text-align: center;
        font-weight: 500;
    }

    .bar-value {
        position: absolute;
        top: -20px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 10px;
        font-weight: 600;
        color: #2D3E50;
        background: white;
        padding: 2px 5px;
        border-radius: 3px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        display: none;
        white-space: nowrap;
        z-index: 10;
    }

    .bar-wrapper:hover .bar-value {
        display: block;
    }

    .bar-wrapper:hover .bar {
        opacity: 0.9;
        transform: scale(1.05);
    }

    .chart-legend {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 11px;
        color: #94a3b8;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        padding: 10px 20px;
    }

    /* Peak Highlight */
    .peak-highlight {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: #f0f7ff;
        border-radius: 10px;
        border: 1px solid #dbeafe;
        margin-top: 15px;
    }

    .peak-icon {
        width: 50px;
        height: 50px;
        background: #2D3E50;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        flex-shrink: 0;
    }

    .peak-info {
        flex: 1;
    }

    .peak-title {
        font-size: 14px;
        color: #64748b;
        margin-bottom: 5px;
    }

    .peak-value {
        font-size: 18px;
        font-weight: bold;
        color: #2D3E50;
    }

    /* Course Format Grid */
    .format-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .format-grid {
            grid-template-columns: 1fr;
        }
    }

    .format-card {
        text-align: center;
        padding: 20px;
        border-radius: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }

    .format-card.active {
        background: linear-gradient(135deg, #f0f7ff, #dbeafe);
        border-color: #60a5fa;
    }

    .format-icon {
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        color: #2D3E50;
        font-size: 18px;
    }

    .format-value {
        display: block;
        font-size: 24px;
        font-weight: bold;
        color: #2D3E50;
        margin-bottom: 5px;
    }

    .format-label {
        font-size: 13px;
        color: #64748b;
    }

    /* Recommendations */
    .recommendations {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #fcd34d;
    }

    .rec-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .rec-header i {
        color: #92400e;
        font-size: 20px;
    }

    .rec-header h4 {
        color: #92400e;
        margin: 0;
        font-size: 16px;
    }

    .rec-content {
        color: #92400e;
    }

    .rec-item {
        margin-bottom: 10px;
        padding-left: 15px;
        position: relative;
        font-size: 14px;
        line-height: 1.5;
    }

    .rec-item:before {
        content: "•";
        position: absolute;
        left: 0;
        color: #92400e;
        font-size: 18px;
    }

    /* Time Range */
    .time-range {
        text-align: center;
        font-size: 13px;
        color: #64748b;
        margin-top: 10px;
        font-style: italic;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #94a3b8;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 200px;
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
    }

    /* Toast */
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
        background: #10b981 !important;
    }

    .toast-error {
        background: #ef4444 !important;
    }

    .toast-info {
        background: #2D3E50 !important;
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
        }

        .filter-select {
            width: 100%;
        }

        .chart-container {
            height: 250px;
        }

        .peak-highlight {
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }
        
        .page-title {
            font-size: 24px;
            text-align: center;
        }
        
        .toast {
            min-width: 250px;
            left: 20px;
            right: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <div>
            <h1 class="page-title">Peak Hours Analytics</h1>
        </div>
        <div class="filter-section">
            <form method="GET" action="{{ route('admin.analytics.peak-hours') }}" id="filterForm">
                <select name="filter" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="all" {{ request('filter', 'all') == 'all' ? 'selected' : '' }}>All Time</option>
                    <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>Last Week</option>
                    <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>Last Month</option>
                    <option value="year" {{ request('filter') == 'year' ? 'selected' : '' }}>Last Year</option>
                </select>
            </form>
            <form method="POST" action="{{ route('admin.analytics.export-peak-hours') }}" id="exportForm">
                @csrf
                <input type="hidden" name="filter" value="{{ request('filter', 'all') }}">
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
        <a href="{{ route('admin.analytics.enrollments') }}" class="tab-item">Enrollments</a>
        <a href="{{ route('admin.analytics.peak-hours') }}" class="tab-item active">Peak Hours</a>
    </nav>

    <!-- Statistics - Wider 4 cards in one line -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <span class="stat-value">{{ $stats['peak_hour'] ?? '3:00 PM' }}</span>
            <span class="stat-label">Peak Hour</span>
            <div class="stat-change positive">Most Active</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-calendar"></i></div>
            <span class="stat-value">{{ $stats['peak_day'] ?? 'Friday' }}</span>
            <span class="stat-label">Busiest Day</span>
            <div class="stat-change positive">+15% Activity</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-sign-in-alt"></i></div>
            <span class="stat-value">{{ $stats['avg_daily_logins'] ?? 89 }}</span>
            <span class="stat-label">Avg Daily Logins</span>
            <div class="stat-change positive">+7.3%</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <span class="stat-value">{{ $stats['avg_enrollments_per_hour'] ?? 42 }}</span>
            <span class="stat-label">Enrollments/Hour</span>
            <div class="stat-change positive">+5.2%</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-grid">
        <!-- Hourly Activity Chart -->
        <div class="card">
            <div class="card-header">
                <h3>Hourly Activity Pattern</h3>
                <span class="time-range">
                    Showing data for {{ $filter == 'all' ? 'all time' : 'last ' . $filter }}
                </span>
            </div>

            <div class="chart-container">
                @if($peakHoursCollection->count() > 0)
                    <div class="bar-chart">
                        @foreach($peakHoursCollection as $hour)
                            @php
                                $maxCount = $peakHoursCollection->max('count') ?: 1;
                                $percentage = $hour['count'] > 0 ? ($hour['count'] / $maxCount) * 100 : 0;
                                $isPeak = $hour['count'] == $maxCount;
                                $hourLabel = $hour['hour_12'] ?? date('h A', strtotime($hour['hour'] . ':00'));
                            @endphp
                            <div class="bar-wrapper">
                                <div class="bar {{ $isPeak ? 'peak' : '' }}" 
                                     style="height: {{ $percentage }}%;"
                                     title="{{ $hourLabel }}: {{ $hour['count'] }} activities">
                                    <div class="bar-value">{{ $hour['count'] }}</div>
                                </div>
                                <div class="bar-label">{{ $hourLabel }}</div>
                            </div>
                        @endforeach
                    </div>
                    <div class="chart-legend">
                        <span>12 AM</span>
                        <span>6 AM</span>
                        <span>12 PM</span>
                        <span>6 PM</span>
                        <span>12 AM</span>
                    </div>

                    @php
                        $peakHourData = $peakHoursCollection->sortByDesc('count')->first();
                    @endphp
                    <div class="peak-highlight">
                        <div class="peak-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <div class="peak-info">
                            <div class="peak-title">Peak Activity Time</div>
                            <div class="peak-value">{{ $peakHourData['hour_12'] ?? '3:00 PM' }}</div>
                        </div>
                        <div>
                            <div style="font-size: 14px; color: #64748b;">
                                {{ $peakHourData['count'] ?? 0 }} activities
                            </div>
                            <div style="font-size: 12px; color: #10b981; font-weight: 500;">
                                Best time for engagement
                            </div>
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-chart-line"></i>
                        <h3>No hourly data available</h3>
                        <p>No activity recorded for the selected period.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Daily Activity Chart -->
        <div class="card">
            <div class="card-header">
                <h3>Daily Activity Pattern</h3>
                <span class="time-range">
                    Showing data for {{ $filter == 'all' ? 'all time' : 'last ' . $filter }}
                </span>
            </div>

            <div class="chart-container">
                @if($enrollmentsByDayCollection->count() > 0)
                    <div class="bar-chart">
                        @foreach($enrollmentsByDayCollection as $day)
                            @php
                                $maxCount = $enrollmentsByDayCollection->max('count') ?: 1;
                                $percentage = $day['count'] > 0 ? ($day['count'] / $maxCount) * 100 : 0;
                                $isPeak = $day['count'] == $maxCount;
                            @endphp
                            <div class="bar-wrapper">
                                <div class="bar {{ $isPeak ? 'peak' : '' }}" 
                                     style="height: {{ $percentage }}%;"
                                     title="{{ $day['day'] }}: {{ $day['count'] }} enrollments">
                                    <div class="bar-value">{{ $day['count'] }}</div>
                                </div>
                                <div class="bar-label">{{ $day['short_day'] ?? substr($day['day'], 0, 3) }}</div>
                            </div>
                        @endforeach
                    </div>

                    @php
                        $peakDayData = $enrollmentsByDayCollection->sortByDesc('count')->first();
                    @endphp
                    <div style="text-align: center; margin-top: 20px; padding: 15px; background: #f0f7ff; border-radius: 10px;">
                        <div style="font-size: 14px; color: #64748b; margin-bottom: 5px;">
                            Most Active Day
                        </div>
                        <div style="font-size: 18px; font-weight: bold; color: #2D3E50;">
                            {{ $peakDayData['day'] ?? 'Friday' }}
                        </div>
                        <div style="font-size: 13px; color: #10b981; margin-top: 5px;">
                            {{ $peakDayData['count'] ?? 0 }} enrollments
                        </div>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-calendar-alt"></i>
                        <h3>No daily data available</h3>
                        <p>No enrollment data for the selected period.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Course Format Activity -->
    <div class="card">
        <div class="card-header">
            <h3>Activity by Course Format</h3>
            <form method="GET" action="{{ route('admin.analytics.peak-hours') }}" id="formatFilterForm">
                <select name="filter" class="filter-select" onchange="document.getElementById('formatFilterForm').submit()">
                    <option value="all" {{ request('filter', 'all') == 'all' ? 'selected' : '' }}>All Time</option>
                    <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>Last Week</option>
                    <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>Last Month</option>
                </select>
            </form>
        </div>

        <div class="format-grid">
            @php
                $maxFormat = array_keys($courseFormatActivity ?? [], max($courseFormatActivity ?? []))[0] ?? 'online';
            @endphp
            <div class="format-card {{ $maxFormat == 'online' ? 'active' : '' }}">
                <div class="format-icon"><i class="fas fa-laptop"></i></div>
                <span class="format-value">{{ $courseFormatActivity['online'] ?? 0 }}%</span>
                <span class="format-label">Online Courses</span>
            </div>
            <div class="format-card {{ $maxFormat == 'in-person' ? 'active' : '' }}">
                <div class="format-icon"><i class="fas fa-users"></i></div>
                <span class="format-value">{{ $courseFormatActivity['in-person'] ?? 0 }}%</span>
                <span class="format-label">In-Person Courses</span>
            </div>
            <div class="format-card {{ $maxFormat == 'hybrid' ? 'active' : '' }}">
                <div class="format-icon"><i class="fas fa-blend"></i></div>
                <span class="format-value">{{ $courseFormatActivity['hybrid'] ?? 0 }}%</span>
                <span class="format-label">Hybrid Courses</span>
            </div>
        </div>

        @php
            $formatText = [
                'online' => 'Online courses receive the most engagement during peak hours',
                'in-person' => 'In-person courses are most popular during peak times',
                'hybrid' => 'Hybrid courses see the highest activity during peak hours'
            ][$maxFormat] ?? 'Online courses receive the most engagement';
        @endphp
        <div style="text-align: center; margin-top: 20px; padding-top: 15px; border-top: 1px solid #e2e8f0; color: #64748b; font-size: 14px;">
            <i class="fas fa-info-circle" style="margin-right: 8px;"></i>
            {{ $formatText }}
        </div>
    </div>

    <!-- AI Recommendations -->
    <div class="recommendations">
        <div class="rec-header">
            <i class="fas fa-lightbulb"></i>
            <h4>AI-Powered Recommendations</h4>
        </div>
        <div class="rec-content">
            <div class="rec-item">
                <strong>Schedule Announcements:</strong> Post new course releases around <strong>{{ $stats['peak_hour'] ?? '3:00 PM' }}</strong> for maximum visibility
            </div>
            <div class="rec-item">
                <strong>Live Sessions:</strong> Schedule on <strong>{{ $stats['peak_day'] ?? 'Friday' }}s</strong> at <strong>{{ $stats['peak_hour'] ?? '3:00 PM' }}</strong> for highest attendance
            </div>
            <div class="rec-item">
                <strong>Marketing Campaigns:</strong> Send email campaigns on <strong>Thursday afternoons</strong> when users are most active
            </div>
            <div class="rec-item">
                <strong>Support Coverage:</strong> Ensure maximum support staff availability during peak hours
            </div>
        </div>
    </div>

    <!-- Period Information -->
    <div style="text-align: center; padding: 15px; background: #f8fafc; border-radius: 10px; margin-top: 20px; color: #64748b; font-size: 13px;">
        <i class="fas fa-calendar-alt" style="margin-right: 8px;"></i>
        Showing analytics from <strong>{{ $stats['period_start'] ?? Carbon::now()->subMonth()->format('M d, Y') }}</strong> 
        to <strong>{{ $stats['period_end'] ?? Carbon::now()->format('M d, Y') }}</strong>
        • Total Activity: <strong>{{ $stats['total_activity'] ?? 0 }}</strong> enrollments
        • Growth: <strong class="{{ strpos($stats['activity_growth'] ?? '+0%', '-') === false ? 'positive' : 'negative' }}" 
                   style="font-weight: 600;">
                   {{ $stats['activity_growth'] ?? '+0%' }}
                 </strong>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initializeEventListeners();
        animateBars();
    });

    function initializeEventListeners() {
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

        // Hover effects for cards
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
                this.style.boxShadow = '0 10px 20px rgba(0,0,0,0.05)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 4px 6px rgba(0,0,0,0.02)';
            });
        });

        // Bar hover effects
        document.querySelectorAll('.bar').forEach(bar => {
            bar.addEventListener('mouseenter', function() {
                this.style.opacity = '0.9';
                this.style.transform = 'scale(1.05)';
            });
            
            bar.addEventListener('mouseleave', function() {
                this.style.opacity = '1';
                this.style.transform = 'scale(1)';
            });
        });
    }

    function animateBars() {
        setTimeout(() => {
            document.querySelectorAll('.bar').forEach((bar, index) => {
                const originalHeight = bar.style.height;
                bar.style.height = '0%';
                setTimeout(() => {
                    bar.style.transition = 'height 1s ease';
                    bar.style.height = originalHeight;
                }, index * 50);
            });
        }, 500);
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
            <button onclick="this.parentElement.remove()" style="background: none; border: none; color: white; font-size: 16px; cursor: pointer; padding: 0; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center;">&times;</button>
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