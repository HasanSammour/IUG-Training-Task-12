@extends('layouts.app')

@section('title', 'Revenue Analytics - Admin')
@section('body-class', 'admin-page')

@section('styles')
<style>
    /* Revenue Analytics Page Styles */
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
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-title {
        font-size: 28px;
        color: #2D3E50;
        font-weight: bold;
        margin: 0;
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

    /* Export button with proper form */
    .export-form {
        display: inline;
        margin: 0;
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
        text-decoration: none;
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

    /* Charts Container - UPDATED: Stacked on mobile */
    .charts-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }

    @media (min-width: 768px) {
        .charts-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .chart-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #edf2f7;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .chart-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .chart-header h3 {
        font-size: 18px;
        color: #2D3E50;
        font-weight: 600;
        margin: 0;
    }

    /* Real Chart Container */
    .chart-container {
        width: 100%;
        height: 280px;
        position: relative;
        margin-top: 20px;
    }

    /* Revenue Table */
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
        margin: 0;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
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

    .month-name {
        color: #2D3E50;
        font-weight: 500;
        min-width: 100px;
    }

    .revenue-amount {
        font-weight: 600;
        color: #2D3E50;
        white-space: nowrap;
    }

    .enrollment-count {
        background: #d1fae5;
        color: #065f46;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }

    .growth-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 12px;
        display: inline-block;
        min-width: 70px;
        text-align: center;
    }

    .growth-positive {
        background: #d1fae5;
        color: #065f46;
    }

    .growth-negative {
        background: #fee2e2;
        color: #991b1b;
    }

    .growth-neutral {
        background: #f3f4f6;
        color: #6b7280;
    }

    /* Payment Methods Section */
    .payment-methods-section {
        background: white;
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #edf2f7;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .payment-methods-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    @media (max-width: 640px) {
        .payment-methods-grid {
            grid-template-columns: 1fr;
        }
    }

    .payment-method-card {
        background: #f8fafc;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid #edf2f7;
    }

    .payment-method-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.05);
    }

    .payment-icon {
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 20px;
        border: 2px solid #e2e8f0;
    }

    .payment-amount {
        font-size: 20px;
        font-weight: 700;
        color: #2D3E50;
        margin-bottom: 5px;
    }

    .payment-label {
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: block;
    }

    .payment-transactions {
        font-size: 11px;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }

    /* Category Revenue Section */
    .category-revenue-section {
        background: white;
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #edf2f7;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .category-list {
        margin-top: 20px;
    }

    .category-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .category-item:last-child {
        border-bottom: none;
    }

    .category-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
        min-width: 0;
    }

    .category-icon {
        width: 40px;
        height: 40px;
        background: #f0f9ff;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #3182ce;
        font-size: 16px;
        flex-shrink: 0;
    }

    .category-details {
        min-width: 0;
    }

    .category-name {
        font-weight: 600;
        color: #2D3E50;
        margin-bottom: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .category-meta {
        font-size: 11px;
        color: #94a3b8;
        display: flex;
        gap: 10px;
    }

    .category-stats {
        text-align: right;
        flex-shrink: 0;
    }

    .category-revenue {
        font-weight: 700;
        color: #2D3E50;
        margin-bottom: 3px;
        white-space: nowrap;
    }

    .category-percentage {
        font-size: 11px;
        color: #10b981;
        font-weight: 600;
    }

    /* Loading States */
    .loading {
        opacity: 0.7;
        pointer-events: none;
    }

    /* Clear Search Button */
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

    /* Toast Styles */
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
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.3s ease;
    }

    .toast.show {
        opacity: 1;
        transform: translateX(0);
    }

    .toast.toast-success {
        background: #10b981;
    }

    .toast.toast-error {
        background: #ef4444;
    }

    .toast.toast-info {
        background: #2D3E50;
    }

    .toast.toast-warning {
        background: #f59e0b;
    }

    .toast-content {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
    }

    .toast-close {
        background: none;
        border: none;
        color: white;
        font-size: 18px;
        cursor: pointer;
        padding: 0;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0.8;
        transition: opacity 0.3s ease;
    }

    .toast-close:hover {
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

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #94a3b8;
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

        .chart-header {
            flex-direction: column;
            gap: 10px;
            align-items: stretch;
        }

        .category-item {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }

        .category-stats {
            text-align: left;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1 class="page-title">Revenue Analytics</h1>
        <div class="filter-section">
            <!-- Search Box -->
            <form method="GET" action="{{ route('admin.analytics.revenue') }}" id="filterForm">
                <input type="hidden" name="filter" value="{{ request('filter', 'all') }}">
                <input type="text" name="search" class="search-box" placeholder="Search courses/instructors..."
                    value="{{ request('search') ?? '' }}" id="searchInput">
                <button type="submit" style="display: none;">Search</button>
            </form>
            
            <!-- Export form -->
            <form method="POST" action="{{ route('admin.analytics.export-revenue') }}" id="exportForm" class="export-form">
                @csrf
                <!-- Pass search and filter parameters -->
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                @if(request('filter'))
                    <input type="hidden" name="filter" value="{{ request('filter') }}">
                @endif
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
        <a href="{{ route('admin.analytics.revenue') }}?filter={{ request('filter', 'all') }}{{ request('search') ? '&search=' . request('search') : '' }}" 
           class="tab-item active">Revenue</a>
        <a href="{{ route('admin.analytics.enrollments') }}" class="tab-item">Enrollments</a>
        <a href="{{ route('admin.analytics.peak-hours') }}" class="tab-item">Peak Hours</a>
    </nav>

    <!-- Revenue Statistics - 3 cards per row, 2 rows -->
    <div class="stats-grid">
        <!-- Row 1 -->
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-dollar-sign"></i></div>
            <span class="stat-value">${{ number_format($revenueStats['total_revenue'] ?? 0, 2) }}</span>
            <span class="stat-label">Total Revenue</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
            <span class="stat-value">{{ number_format($revenueStats['total_enrollments'] ?? 0) }}</span>
            <span class="stat-label">Total Enrollments</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
            <span class="stat-value">${{ number_format($revenueStats['current_month_revenue'] ?? 0, 2) }}</span>
            <span class="stat-label">This Month</span>
        </div>
        
        <!-- Row 2 -->
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
            <span class="stat-value">{{ number_format($revenueStats['growth_rate'] ?? 0, 1) }}%</span>
            <span class="stat-label">Growth Rate</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-ticket-alt"></i></div>
            <span class="stat-value">${{ number_format($revenueStats['average_ticket_size'] ?? 0, 2) }}</span>
            <span class="stat-label">Avg. Ticket</span>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-calendar-day"></i></div>
            <span class="stat-value">${{ number_format($revenueStats['today_revenue'] ?? 0, 2) }}</span>
            <span class="stat-label">Today</span>
        </div>
    </div>

    <!-- Charts Container - Stacked on mobile -->
    <div class="charts-container">
        <!-- Monthly Revenue Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3>Monthly Revenue Trend</h3>
                <div style="font-size: 14px; color: #64748b;">
                    Last 12 months revenue data
                </div>
            </div>
            
            <div class="chart-container">
                <canvas id="monthlyRevenueChart"></canvas>
            </div>
        </div>

        <!-- Daily Revenue Trend Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3>Daily Revenue Trend (Last 30 Days)</h3>
                <div style="font-size: 14px; color: #64748b;">
                    Daily revenue and enrollments
                </div>
            </div>
            
            <div class="chart-container">
                <canvas id="dailyRevenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue Table -->
    <div class="table-card">
        <div class="table-header">
            <h3>Monthly Revenue Breakdown</h3>
            <div style="font-size: 14px; color: #64748b;">
                Showing {{ count($monthlyRevenue) }} months of revenue data
                @if(request('search'))
                    <span style="color: #f59e0b; margin-left: 10px;">
                        <i class="fas fa-filter"></i> Filtered by: "{{ request('search') }}"
                    </span>
                @endif
            </div>
        </div>
        
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Revenue</th>
                        <th>Enrollments</th>
                        <th>Avg. Ticket</th>
                        <th>Growth</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($monthlyRevenue as $month)
                    @php
                        $avgTicket = $month['enrollments'] > 0 ? $month['revenue'] / $month['enrollments'] : 0;
                        
                        // Calculate growth from previous month
                        $prevIndex = $loop->index - 1;
                        $prevMonthRevenue = isset($monthlyRevenue[$prevIndex]) ? $monthlyRevenue[$prevIndex]['revenue'] : 0;
                        $growth = $prevMonthRevenue > 0 
                            ? (($month['revenue'] - $prevMonthRevenue) / $prevMonthRevenue) * 100 
                            : ($month['revenue'] > 0 ? 100 : 0);
                    @endphp
                    <tr>
                        <td class="month-name">{{ $month['month'] }}</td>
                        <td class="revenue-amount">${{ number_format($month['revenue'], 2) }}</td>
                        <td>
                            <span class="enrollment-count">{{ $month['enrollments'] }} enrollments</span>
                        </td>
                        <td>${{ number_format($avgTicket, 2) }}</td>
                        <td>
                            <span class="growth-badge {{ $growth > 0 ? 'growth-positive' : ($growth < 0 ? 'growth-negative' : 'growth-neutral') }}">
                                {{ $growth > 0 ? '+' : '' }}{{ number_format($growth, 1) }}%
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: #94a3b8;">
                            <i class="fas fa-chart-bar" style="font-size: 48px; margin-bottom: 15px; display: block; opacity: 0.3;"></i>
                            <h4>No revenue data available</h4>
                            <p>Start enrolling students to see revenue analytics</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Payment Methods Section -->
    @if($paymentMethods->count() > 0)
    <div class="payment-methods-section">
        <div class="table-header">
            <h3>Revenue by Payment Method</h3>
            <div style="font-size: 14px; color: #64748b;">
                {{ $paymentMethods->sum('count') }} total transactions
            </div>
        </div>
        
        <div class="payment-methods-grid">
            @foreach($paymentMethods as $method)
            @php
                $totalRevenue = $revenueStats['total_revenue'] ?? 1;
                $percentage = $totalRevenue > 0 ? ($method['total'] / $totalRevenue) * 100 : 0;
            @endphp
            <div class="payment-method-card">
                <div class="payment-icon">
                    @switch($method['payment_method'])
                        @case('credit_card')
                            <i class="fas fa-credit-card" style="color: #6366f1;"></i>
                            @break
                        @case('paypal')
                            <i class="fab fa-paypal" style="color: #003087;"></i>
                            @break
                        @case('bank_transfer')
                            <i class="fas fa-university" style="color: #059669;"></i>
                            @break
                        @case('manual')
                            <i class="fas fa-hand-holding-usd" style="color: #d97706;"></i>
                            @break
                        @case('free')
                            <i class="fas fa-gift" style="color: #7c3aed;"></i>
                            @break
                        @default
                            <i class="fas fa-money-bill-wave" style="color: #10b981;"></i>
                    @endswitch
                </div>
                <div class="payment-amount">${{ number_format($method['total'], 2) }}</div>
                <span class="payment-label">{{ ucfirst(str_replace('_', ' ', $method['payment_method'])) }}</span>
                <div class="payment-transactions">
                    <i class="fas fa-exchange-alt"></i>
                    {{ $method['count'] }} transactions
                </div>
                <div style="margin-top: 10px; font-size: 11px; color: #64748b;">
                    {{ number_format($percentage, 1) }}% of total
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Category Revenue Section -->
    @if($revenueByCategory->count() > 0)
    <div class="category-revenue-section">
        <div class="table-header">
            <h3>Revenue by Category</h3>
            <div style="font-size: 14px; color: #64748b;">
                {{ $revenueByCategory->sum('courses') }} courses across all categories
            </div>
        </div>
        
        <div class="category-list">
            @foreach($revenueByCategory as $category)
            @php
                $totalRevenue = $revenueStats['total_revenue'] ?? 1;
                $percentage = $totalRevenue > 0 ? ($category['revenue'] / $totalRevenue) * 100 : 0;
            @endphp
            <div class="category-item">
                <div class="category-info">
                    <div class="category-icon">
                        <i class="fas fa-folder"></i>
                    </div>
                    <div class="category-details">
                        <div class="category-name">{{ $category['category'] }}</div>
                        <div class="category-meta">
                            <span>{{ $category['courses'] }} courses</span>
                            <span>•</span>
                            <span>{{ $category['enrollments'] }} enrollments</span>
                        </div>
                    </div>
                </div>
                <div class="category-stats">
                    <div class="category-revenue">${{ number_format($category['revenue'], 2) }}</div>
                    <div class="category-percentage">{{ number_format($percentage, 1) }}% of total</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Clear Search Button -->
    @if(request('search'))
    <div style="text-align: center; margin-top: 20px; margin-bottom: 30px;">
        <a href="{{ route('admin.analytics.revenue') }}?filter={{ request('filter', 'all') }}" class="btn-clear-search">
            <i class="fas fa-times"></i> Clear Search
        </a>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="{{ asset('chartjs/chart.umd.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup real charts with Chart.js using REAL data from database
        setupRevenueCharts();
        
        // Setup search with debounce
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

        // Card hover effects
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

        // Chart card hover effects
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

        // Payment method card hover effects
        document.querySelectorAll('.payment-method-card').forEach(card => {
            card.addEventListener('mouseenter', function () {
                this.style.transform = 'translateY(-3px)';
                this.style.boxShadow = '0 6px 12px rgba(0,0,0,0.05)';
            });

            card.addEventListener('mouseleave', function () {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 2px 4px rgba(0,0,0,0.02)';
            });
        });
    });

    // Setup real charts with Chart.js using REAL data
    function setupRevenueCharts() {
        // Monthly Revenue Bar Chart
        const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart');
        if (monthlyRevenueCtx) {
            try {
                // Prepare data from PHP controller
                const monthlyData = @json($monthlyRevenue);
                const months = monthlyData.map(item => item.month);
                const revenues = monthlyData.map(item => item.revenue);
                const enrollments = monthlyData.map(item => item.enrollments);
                
                new Chart(monthlyRevenueCtx, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [
                            {
                                label: 'Revenue ($)',
                                data: revenues,
                                backgroundColor: 'rgba(49, 130, 206, 0.7)',
                                borderColor: '#3182ce',
                                borderWidth: 1,
                                borderRadius: 4,
                                yAxisID: 'y',
                            },
                            {
                                label: 'Enrollments',
                                data: enrollments,
                                backgroundColor: 'rgba(16, 185, 129, 0.7)',
                                borderColor: '#10b981',
                                borderWidth: 1,
                                borderRadius: 4,
                                yAxisID: 'y1',
                                type: 'line',
                                order: 0
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
                                        let label = context.dataset.label || '';
                                        if (label === 'Revenue ($)') {
                                            return `${label}: $${context.raw.toLocaleString('en-US', {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })}`;
                                        } else {
                                            return `${label}: ${context.raw.toLocaleString()}`;
                                        }
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45
                                }
                            },
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Revenue ($)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return '$' + value.toLocaleString();
                                    }
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Enrollments'
                                },
                                grid: {
                                    drawOnChartArea: false,
                                },
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating monthly revenue chart:', error);
                // Show error message
                monthlyRevenueCtx.parentElement.innerHTML = `
                    <div style="text-align: center; padding: 40px; color: #94a3b8;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 48px; margin-bottom: 15px; display: block; opacity: 0.3;"></i>
                        <h4>Unable to load chart data</h4>
                        <p>Please check your data configuration</p>
                    </div>
                `;
            }
        }

        // Daily Revenue Line Chart
        const dailyRevenueCtx = document.getElementById('dailyRevenueChart');
        if (dailyRevenueCtx) {
            try {
                // Prepare data from PHP controller
                const dailyData = @json($dailyRevenueTrend);
                const dates = dailyData.map(item => item.date);
                const dailyRevenues = dailyData.map(item => item.revenue);
                const dailyEnrollments = dailyData.map(item => item.enrollments);
                
                new Chart(dailyRevenueCtx, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [
                            {
                                label: 'Revenue ($)',
                                data: dailyRevenues,
                                borderColor: '#3182ce',
                                backgroundColor: 'rgba(49, 130, 206, 0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                                yAxisID: 'y'
                            },
                            {
                                label: 'Enrollments',
                                data: dailyEnrollments,
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                borderWidth: 2,
                                borderDash: [5, 5],
                                fill: false,
                                tension: 0.4,
                                pointRadius: 2,
                                pointHoverRadius: 4,
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
                                        let label = context.dataset.label || '';
                                        if (label === 'Revenue ($)') {
                                            return `${label}: $${context.raw.toLocaleString('en-US', {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })}`;
                                        } else {
                                            return `${label}: ${context.raw.toLocaleString()}`;
                                        }
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45
                                }
                            },
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                title: {
                                    display: true,
                                    text: 'Revenue ($)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return '$' + value.toLocaleString();
                                    }
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                title: {
                                    display: true,
                                    text: 'Enrollments'
                                },
                                grid: {
                                    drawOnChartArea: false,
                                },
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating daily revenue chart:', error);
                // Show error message
                dailyRevenueCtx.parentElement.innerHTML = `
                    <div style="text-align: center; padding: 40px; color: #94a3b8;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 48px; margin-bottom: 15px; display: block; opacity: 0.3;"></i>
                        <h4>Unable to load chart data</h4>
                        <p>Please check your data configuration</p>
                    </div>
                `;
            }
        }
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
            <div class="toast-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                <span>${message}</span>
            </div>
            <button class="toast-close" onclick="this.parentElement.remove()">&times;</button>
        `;

        document.body.appendChild(toast);

        // Show toast with animation
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);

        // Auto remove after 3 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.classList.remove('show');
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