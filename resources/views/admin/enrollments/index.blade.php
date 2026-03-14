@extends('layouts.app')

@section('title', 'Enrollments Management - Shifra Admin')
@section('body-class', 'admin-page')

@section('styles')
<style>
    .admin-container {
        padding: 20px;
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
    }

    /* Page Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e2e8f0;
    }

    .page-title {
        font-size: 24px;
        color: #2D3E50;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-title i {
        color: #f59e0b;
    }

    .btn-create {
        background: #2D3E50;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .btn-create:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
        color: white;
    }

    /* Alert Messages */
    .alert {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .alert-success {
        background: #dcfce7;
        border-left: 4px solid #15803d;
        color: #166534;
    }

    .alert-error {
        background: #fee2e2;
        border-left: 4px solid #b91c1c;
        color: #991b1b;
    }

    /* Stats Cards */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #edf2f7;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .stat-card.total::before { background: linear-gradient(90deg, #2D3E50, #4a5568); }
    .stat-card.active::before { background: linear-gradient(90deg, #10b981, #34d399); }
    .stat-card.completed::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
    .stat-card.pending::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
    .stat-card.cancelled::before { background: linear-gradient(90deg, #ef4444, #f87171); }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #2D3E50;
        display: block;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-sub {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 8px;
        padding-top: 8px;
        border-top: 1px solid #e2e8f0;
    }

    /* Filters Card */
    .filters-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        border: 1px solid #edf2f7;
        margin-bottom: 30px;
        width: 100%;
    }

    .filters-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
    }

    .filters-row:last-child {
        margin-bottom: 0;
    }

    .search-group {
        flex: 3;
        min-width: 300px;
    }

    .status-group {
        flex: 1;
        min-width: 150px;
    }

    .date-from-group {
        flex: 1;
        min-width: 150px;
    }

    .date-to-group {
        flex: 1;
        min-width: 150px;
    }

    .per-page-group {
        flex: 1;
        min-width: 120px;
    }

    .sort-group {
        flex: 1;
        min-width: 150px;
    }

    .filter-actions-group {
        flex: 2;
        display: flex;
        gap: 10px;
        align-items: flex-end;
        min-width: 280px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-input, .filter-select {
        width: 100%;
        padding: 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        background: white;
        transition: all 0.3s ease;
    }

    .filter-input:focus, .filter-select:focus {
        border-color: #2D3E50;
        outline: none;
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    .btn-filter {
        padding: 12px 24px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        flex: 1;
        white-space: nowrap;
    }

    .btn-apply {
        background: #2D3E50;
        color: white;
    }

    .btn-apply:hover {
        background: #1a252f;
        transform: translateY(-2px);
    }

    .btn-reset {
        background: #f1f5f9;
        color: #64748b;
        text-decoration: none;
        border: 1px solid #e2e8f0;
    }

    .btn-reset:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

    /* Enrollments Table */
    .enrollments-table {
        background: white;
        border-radius: 12px;
        border: 1px solid #edf2f7;
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        width: 100%;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1400px;
    }

    th {
        background: #f8fafc;
        padding: 15px;
        text-align: left;
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    td {
        padding: 15px;
        font-size: 14px;
        border-bottom: 1px solid #f8fafc;
        vertical-align: middle;
    }

    tr:hover td {
        background: #f8fafc;
    }

    .checkbox-cell {
        width: 40px;
        text-align: center;
    }

    input[type="checkbox"] {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    /* Student Info */
    .student-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .student-avatar-small {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        overflow: hidden;
        flex-shrink: 0;
    }

    .student-avatar-small.has-image {
        background: none;
    }

    .student-avatar-small img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .student-avatar-small.no-image {
        background: linear-gradient(135deg, #2D3E50, #f59e0b);
        color: white;
    }

    .student-details {
        line-height: 1.3;
    }

    .student-name {
        color: #2D3E50;
        font-weight: 600;
        font-size: 14px;
        white-space: nowrap;
    }

    .student-email {
        font-size: 11px;
        color: #94a3b8;
        white-space: nowrap;
    }

    .course-info {
        max-width: 250px;
    }

    .course-title {
        color: #2D3E50;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 2px;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .course-instructor {
        font-size: 11px;
        color: #94a3b8;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .enrollment-id {
        color: #f59e0b;
        font-weight: 700;
        text-decoration: none;
        font-size: 12px;
        font-family: monospace;
        display: inline-block;
        white-space: nowrap;
        max-width: 160px;
        overflow: hidden;
        text-overflow: ellipsis;
        vertical-align: middle;
    }

    .enrollment-id i {
        margin-right: 2px;
        font-size: 10px;
    }

    .enrollment-id:hover {
        text-decoration: underline;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .status-active {
        background: #dcfce7;
        color: #15803d;
    }

    .status-completed {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-pending {
        background: #fef3c7;
        color: #d97706;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #dc2626;
    }

    .progress-cell {
        min-width: 140px;
    }

    .progress-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .progress-bar {
        flex: 1;
        height: 6px;
        background: #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #2D3E50, #f59e0b);
        border-radius: 10px;
        transition: width 0.5s ease;
    }

    .progress-text {
        font-size: 12px;
        color: #64748b;
        min-width: 40px;
        font-weight: 600;
        white-space: nowrap;
    }

    .amount-paid {
        font-weight: 700;
        color: #2D3E50;
        white-space: nowrap;
    }

    .amount-paid small {
        font-size: 10px;
        color: #94a3b8;
        display: block;
        white-space: nowrap;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #64748b;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 14px;
        flex-shrink: 0;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    .btn-view:hover {
        background: #f59e0b;
        color: white;
        border-color: #f59e0b;
    }

    .btn-edit:hover {
        background: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: white;
        border-color: #ef4444;
    }

    /* Bulk Actions - FIXED to show properly */
    .bulk-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 25px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        flex-wrap: wrap;
        gap: 15px;
        width: 100%;
    }

    .bulk-select {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 0 0 auto;
    }

    .bulk-select label {
        font-size: 13px;
        color: #2D3E50;
        font-weight: 500;
        white-space: nowrap;
        cursor: pointer;
    }

    .selected-count {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        white-space: nowrap;
        background: white;
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
    }

    .bulk-controls {
        display: flex;
        gap: 12px;
        align-items: center;
        flex: 0 1 auto;
        min-width: 300px;
    }

    .bulk-controls .filter-select {
        flex: 1;
        min-width: 160px;
        height: 42px;
        padding: 0 12px;
        font-size: 13px;
        background: white;
    }

    .btn-bulk {
        padding: 10px 28px;
        height: 42px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #2D3E50;
        background: #2D3E50;
        color: white;
        cursor: pointer;
        transition: all 0.3s;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 100px;
    }

    .btn-bulk:hover {
        background: #1a252f;
        border-color: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        background: white;
        border-top: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 15px;
    }

    .info-text {
        font-size: 13px;
        color: #94a3b8;
        white-space: nowrap;
    }

    .pagination {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
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
        transition: all 0.3s;
        background: white;
    }

    .page-link:hover {
        background: #f1f5f9;
        border-color: #2D3E50;
        color: #2D3E50;
    }

    .page-link.active {
        background: #2D3E50;
        color: white;
        border-color: #2D3E50;
    }

    .page-link.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        width: 100%;
        background: white;
        border-radius: 12px;
        border: 1px solid #edf2f7;
    }

    .empty-icon {
        font-size: 64px;
        color: #e2e8f0;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: #2D3E50;
        margin-bottom: 10px;
        font-size: 20px;
    }

    .empty-state p {
        color: #94a3b8;
        margin-bottom: 25px;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        table {
            min-width: 1300px;
        }
        
        .bulk-controls {
            min-width: 280px;
        }
    }

    @media (max-width: 768px) {
        .admin-container {
            padding: 15px;
        }
        
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .btn-create {
            width: 100%;
            justify-content: center;
        }
        
        .filters-row {
            flex-direction: column;
        }
        
        .filter-actions-group {
            flex-direction: column;
            width: 100%;
        }
        
        .btn-filter {
            width: 100%;
        }
        
        .bulk-actions {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .bulk-select {
            width: 100%;
            justify-content: space-between;
        }
        
        .bulk-controls {
            width: 100%;
            flex-direction: column;
            gap: 10px;
        }
        
        .bulk-controls .filter-select,
        .btn-bulk {
            width: 100%;
        }
        
        .pagination-container {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .info-text {
            width: 100%;
        }
        
        .pagination {
            width: 100%;
            justify-content: center;
        }
        
        .action-buttons {
            flex-wrap: wrap;
        }
        
        .enrollment-id {
            max-width: 120px;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-book-open"></i>
            Enrollments Management
        </h1>
        <a href="{{ route('admin.enrollments.create') }}" class="btn-create">
            <i class="fas fa-plus"></i> New Enrollment
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="stats-row">
        <div class="stat-card total" onclick="filterByStatus('')">
            <span class="stat-value">{{ $stats['total'] }}</span>
            <span class="stat-label">Total Enrollments</span>
            <div class="stat-sub">
                <i class="fas fa-dollar-sign"></i> ${{ number_format($stats['revenue'], 2) }}
            </div>
        </div>
        <div class="stat-card active" onclick="filterByStatus('active')">
            <span class="stat-value">{{ $stats['active'] }}</span>
            <span class="stat-label">Active</span>
            <div class="stat-sub">
                <i class="fas fa-chart-line"></i> Avg Progress: {{ $stats['average_progress'] }}%
            </div>
        </div>
        <div class="stat-card completed" onclick="filterByStatus('completed')">
            <span class="stat-value">{{ $stats['completed'] }}</span>
            <span class="stat-label">Completed</span>
            <div class="stat-sub">
                <i class="fas fa-check-circle"></i> Success Rate: {{ $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100) : 0 }}%
            </div>
        </div>
        <div class="stat-card pending" onclick="filterByStatus('pending')">
            <span class="stat-value">{{ $stats['pending'] }}</span>
            <span class="stat-label">Pending</span>
        </div>
        <div class="stat-card cancelled" onclick="filterByStatus('cancelled')">
            <span class="stat-value">{{ $stats['cancelled'] }}</span>
            <span class="stat-label">Cancelled</span>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-card">
        <form method="GET" action="{{ route('admin.enrollments.index') }}" id="filterForm">
            <!-- Row 1: Search + Status + Date From + Date To -->
            <div class="filters-row">
                <div class="filter-group search-group">
                    <label class="filter-label">Search</label>
                    <input type="text" name="search" class="filter-input" 
                           placeholder="ID, Student, Course..." 
                           value="{{ request('search') }}">
                </div>
                
                <div class="filter-group status-group">
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-select">
                        <option value="">All Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group date-from-group">
                    <label class="filter-label">Date From</label>
                    <input type="date" name="date_from" class="filter-input" value="{{ request('date_from') }}">
                </div>
                
                <div class="filter-group date-to-group">
                    <label class="filter-label">Date To</label>
                    <input type="date" name="date_to" class="filter-input" value="{{ request('date_to') }}">
                </div>
            </div>

            <!-- Row 2: Per Page + Sort + Buttons -->
            <div class="filters-row">
                <div class="filter-group per-page-group">
                    <label class="filter-label">Per Page</label>
                    <select name="per_page" class="filter-select">
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20 per page</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per page</option>
                    </select>
                </div>
                
                <div class="filter-group sort-group">
                    <label class="filter-label">Sort By</label>
                    <select name="sort" class="filter-select">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Enrollment Date</option>
                        <option value="progress_percentage" {{ request('sort') == 'progress_percentage' ? 'selected' : '' }}>Progress</option>
                        <option value="amount_paid" {{ request('sort') == 'amount_paid' ? 'selected' : '' }}>Amount</option>
                    </select>
                </div>
                
                <div class="filter-actions-group">
                    <button type="submit" class="btn-filter btn-apply">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                    @if(request()->hasAny(['search', 'status', 'date_from', 'date_to', 'per_page', 'sort']))
                        <a href="{{ route('admin.enrollments.index') }}" class="btn-filter btn-reset">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Enrollments Table -->
    @if($enrollments->count() > 0)
        <div class="enrollments-table">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th class="checkbox-cell">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th>Enrollment ID</th>
                            <th>Student</th>
                            <th>Course</th>
                            <th>Enrolled</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Progress</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollments as $enrollment)
                            <tr data-id="{{ $enrollment->id }}">
                                <td class="checkbox-cell">
                                    <input type="checkbox" class="row-checkbox" value="{{ $enrollment->id }}">
                                </td>
                                <td>
                                    <a href="{{ route('admin.enrollments.show', $enrollment) }}" class="enrollment-id" title="{{ $enrollment->enrollment_id }}">
                                        <i class="fas fa-hashtag" style="font-size: 10px;"></i>
                                        {{ $enrollment->enrollment_id }}
                                    </a>
                                </td>
                                <td>
                                    <div class="student-info">
                                        @if($enrollment->user->avatar && \Storage::disk('public')->exists($enrollment->user->avatar))
                                            <div class="student-avatar-small has-image">
                                                <img src="{{ Storage::url($enrollment->user->avatar) }}" alt="{{ $enrollment->user->name }}">
                                            </div>
                                        @else
                                            <div class="student-avatar-small no-image">
                                                {{ substr($enrollment->user->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="student-details">
                                            <div class="student-name">{{ $enrollment->user->name }}</div>
                                            <div class="student-email">{{ $enrollment->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="course-info">
                                        <div class="course-title" title="{{ $enrollment->course->title }}">
                                            {{ $enrollment->course->title }}
                                        </div>
                                        <div class="course-instructor" title="{{ $enrollment->course->instructor_name }}">
                                            <i class="fas fa-chalkboard-teacher"></i> {{ $enrollment->course->instructor_name }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 500; color: #2D3E50; white-space: nowrap;">{{ $enrollment->enrolled_at->format('M d, Y') }}</div>
                                    <div style="font-size: 11px; color: #94a3b8; white-space: nowrap;">{{ $enrollment->enrolled_at->diffForHumans() }}</div>
                                </td>
                                <td>
                                    <span class="amount-paid">${{ number_format($enrollment->amount_paid, 2) }}</span>
                                    <small style="display: block; font-size: 10px; color: #94a3b8;">{{ ucfirst($enrollment->payment_method) }}</small>
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $enrollment->status }}" id="status-{{ $enrollment->id }}">
                                        {{ ucfirst($enrollment->status) }}
                                    </span>
                                </td>
                                <td class="progress-cell">
                                    <div class="progress-container">
                                        <div class="progress-bar">
                                            <div class="progress-fill" id="progress-{{ $enrollment->id }}" 
                                                 style="width: {{ $enrollment->progress_percentage }}%"></div>
                                        </div>
                                        <span class="progress-text" id="progress-text-{{ $enrollment->id }}">
                                            {{ $enrollment->progress_percentage }}%
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.enrollments.show', $enrollment) }}" 
                                           class="btn-action btn-view" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.enrollments.edit', $enrollment) }}" 
                                           class="btn-action btn-edit" title="Edit Enrollment">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn-action btn-delete" 
                                                onclick="confirmDelete({{ $enrollment->id }})" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Hidden Delete Form -->
                                    <form id="delete-form-{{ $enrollment->id }}" 
                                          action="{{ route('admin.enrollments.destroy', $enrollment) }}" 
                                          method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Bulk Actions - FIXED and visible -->
            <div class="bulk-actions">
                <div class="bulk-select">
                    <input type="checkbox" id="bulkSelectAll">
                    <label for="bulkSelectAll">Select All</label>
                    <span id="selectedCount" class="selected-count">0 selected</span>
                </div>
                <div class="bulk-controls">
                    <select id="bulkAction" class="filter-select">
                        <option value="">Bulk Actions</option>
                        <option value="activate">Activate</option>
                        <option value="complete">Mark as Completed</option>
                        <option value="cancel">Cancel</option>
                        <option value="delete">Delete</option>
                    </select>
                    <button type="button" class="btn-bulk" onclick="applyBulkAction()">
                        Apply
                    </button>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="pagination-container">
                <div class="info-text">
                    Showing {{ $enrollments->firstItem() }} to {{ $enrollments->lastItem() }} 
                    of {{ $enrollments->total() }} enrollments
                </div>
                <div class="pagination">
                    {{-- Previous Page Link --}}
                    @if($enrollments->onFirstPage())
                        <span class="page-link disabled">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $enrollments->previousPageUrl() }}" class="page-link">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements - Show 5 pages with dots --}}
                    @php
                        $currentPage = $enrollments->currentPage();
                        $lastPage = $enrollments->lastPage();
                        $start = max(1, $currentPage - 2);
                        $end = min($lastPage, $currentPage + 2);

                        // Adjust start and end to always show 5 pages when possible
                        if ($end - $start < 4) {
                            if ($start == 1) {
                                $end = min($lastPage, $start + 4);
                            } elseif ($end == $lastPage) {
                                $start = max(1, $end - 4);
                            }
                        }
                    @endphp

                    {{-- First page link with dots --}}
                    @if($start > 1)
                        <a href="{{ $enrollments->url(1) }}" class="page-link">1</a>
                        @if($start > 2)
                            <span class="page-link disabled">...</span>
                        @endif
                    @endif

                    {{-- Page numbers --}}
                    @for($page = $start; $page <= $end; $page++)
                        @if($page == $currentPage)
                            <span class="page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $enrollments->url($page) }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endfor

                    {{-- Last page link with dots --}}
                    @if($end < $lastPage)
                        @if($end < $lastPage - 1)
                            <span class="page-link disabled">...</span>
                        @endif
                        <a href="{{ $enrollments->url($lastPage) }}" class="page-link">{{ $lastPage }}</a>
                    @endif

                    {{-- Next Page Link --}}
                    @if($enrollments->hasMorePages())
                        <a href="{{ $enrollments->nextPageUrl() }}" class="page-link">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="page-link disabled">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <h3>No Enrollments Found</h3>
            <p>
                @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                    No enrollments match your search criteria.
                @else
                    Start by adding your first enrollment.
                @endif
            </p>
            @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                <a href="{{ route('admin.enrollments.index') }}" class="btn-filter btn-reset" style="display: inline-flex;">
                    <i class="fas fa-times"></i> Clear Filters
                </a>
            @else
                <a href="{{ route('admin.enrollments.create') }}" class="btn-create" style="display: inline-flex;">
                    <i class="fas fa-plus"></i> Add First Enrollment
                </a>
            @endif
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide flash messages after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Select All functionality
        const selectAll = document.getElementById('selectAll');
        const bulkSelectAll = document.getElementById('bulkSelectAll');
        const checkboxes = document.querySelectorAll('.row-checkbox');
        const selectedCount = document.getElementById('selectedCount');

        function updateSelectedCount() {
            const checked = document.querySelectorAll('.row-checkbox:checked').length;
            if (selectedCount) {
                selectedCount.textContent = checked + ' selected';
            }
        }

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
                if (bulkSelectAll) bulkSelectAll.checked = this.checked;
                updateSelectedCount();
            });
        }

        if (bulkSelectAll) {
            bulkSelectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
                if (selectAll) selectAll.checked = this.checked;
                updateSelectedCount();
            });
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const allChecked = Array.from(checkboxes).every(c => c.checked);
                if (selectAll) selectAll.checked = allChecked;
                if (bulkSelectAll) bulkSelectAll.checked = allChecked;
                updateSelectedCount();
            });
        });

        // Auto-submit per_page on change
        const perPageSelect = document.querySelector('select[name="per_page"]');
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        }

        // Progress bar animation
        document.querySelectorAll('.progress-fill').forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.transition = 'width 0.5s ease';
                bar.style.width = width;
            }, 100);
        });
    });

    // Filter by status
    function filterByStatus(status) {
        const url = new URL(window.location.href);
        if (status) {
            url.searchParams.set('status', status);
        } else {
            url.searchParams.delete('status');
        }
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }

    // Confirm delete
    function confirmDelete(id) {
        Swal.fire({
            title: 'Delete Enrollment?',
            html: `<div style="text-align: left;">
                    <p style="margin-bottom: 15px;">Are you sure you want to delete this enrollment?</p>
                    <div style="background: #fee2e2; border-left: 4px solid #dc2626; padding: 12px; border-radius: 6px; color: #991b1b; font-size: 13px;">
                        <i class="fas fa-exclamation-triangle"></i> 
                        <span style="margin-left: 5px;">This action cannot be undone.</span>
                    </div>
                   </div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // Bulk action
    function applyBulkAction() {
        const action = document.getElementById('bulkAction').value;
        const selectedIds = Array.from(document.querySelectorAll('.row-checkbox:checked'))
            .map(cb => cb.value);

        if (selectedIds.length === 0) {
            Swal.fire({
                title: 'No Selection',
                text: 'Please select at least one enrollment',
                icon: 'warning',
                confirmButtonColor: '#2D3E50'
            });
            return;
        }

        if (!action) {
            Swal.fire({
                title: 'No Action Selected',
                text: 'Please select an action',
                icon: 'warning',
                confirmButtonColor: '#2D3E50'
            });
            return;
        }

        let title, text, confirmColor;
        switch(action) {
            case 'activate':
                title = 'Activate Enrollments';
                text = `Activate ${selectedIds.length} enrollment(s)?`;
                confirmColor = '#10b981';
                break;
            case 'complete':
                title = 'Complete Enrollments';
                text = `Mark ${selectedIds.length} enrollment(s) as completed?`;
                confirmColor = '#3b82f6';
                break;
            case 'cancel':
                title = 'Cancel Enrollments';
                text = `Cancel ${selectedIds.length} enrollment(s)?`;
                confirmColor = '#f59e0b';
                break;
            case 'delete':
                title = 'Delete Enrollments';
                text = `Delete ${selectedIds.length} enrollment(s)? This cannot be undone.`;
                confirmColor = '#dc2626';
                break;
        }

        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: confirmColor,
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, proceed',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch('{{ route("admin.enrollments.bulk-action") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        action: action,
                        ids: selectedIds
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonColor: '#2D3E50'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.error || 'An error occurred',
                            icon: 'error',
                            confirmButtonColor: '#2D3E50'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to process request',
                        icon: 'error',
                        confirmButtonColor: '#2D3E50'
                    });
                });
            }
        });
    }
</script>
@endsection