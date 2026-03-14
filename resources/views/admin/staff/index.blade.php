@extends('layouts.app')

@section('title', 'Staff Management')
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

    /* Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 0;
        margin-bottom: 20px;
    }

    .page-title {
        font-size: 24px;
        font-weight: bold;
        color: #2D3E50;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-title i {
        color: #8b5cf6;
    }

    .btn-add-staff {
        background: #2D3E50;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-add-staff:hover {
        background: #1a252f;
        transform: translateY(-2px);
        color: white;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
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
        padding: 20px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .stat-icon.admins {
        background: rgba(139, 92, 246, 0.1);
        color: #8b5cf6;
    }

    .stat-icon.instructors {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .stat-icon.active {
        background: rgba(49, 130, 206, 0.1);
        color: #3182ce;
    }

    .stat-icon.pending {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        display: block;
        font-size: 24px;
        font-weight: 700;
        color: #2D3E50;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 13px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Search and Filters Form */
    .filter-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
        width: 100%;
        margin-bottom: 25px;
    }

    .filters-row {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }

    .search-container {
        position: relative;
        flex: 2;
        min-width: 250px;
    }

    .search-container i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .search-input {
        width: 100%;
        padding: 12px 12px 12px 40px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: white;
        transition: border-color 0.3s ease;
        font-size: 14px;
    }

    .search-input:focus {
        outline: none;
        border-color: #2D3E50;
    }

    .filter-select {
        padding: 12px 15px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #2D3E50;
        min-width: 160px;
        cursor: pointer;
        transition: border-color 0.3s ease;
        font-size: 14px;
        flex: 1;
    }

    .filter-select:focus {
        outline: none;
        border-color: #2D3E50;
    }

    .actions-row {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        width: 100%;
    }

    .filter-button {
        padding: 12px 25px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #2D3E50;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        font-size: 14px;
    }

    .filter-button:hover {
        background: #f8fafc;
        border-color: #2D3E50;
        transform: translateY(-1px);
    }

    .filter-button.apply {
        background: #2D3E50;
        color: white;
        border-color: #2D3E50;
        min-width: 140px;
        justify-content: center;
    }

    .filter-button.apply:hover {
        background: #1a252f;
    }

    .filter-button.clear {
        background: #fef2f2;
        color: #dc2626;
        border-color: #dc2626;
        min-width: 140px;
        justify-content: center;
    }

    .filter-button.clear:hover {
        background: #dc2626;
        color: white;
    }

    /* Staff Table Card */
    .staff-table-card {
        background: white;
        border-radius: 15px;
        border: 1px solid #edf2f7;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .table-responsive {
        overflow-x: auto;
    }

    .staff-table {
        width: 100%;
        border-collapse: collapse;
    }

    .staff-table th {
        text-align: left;
        padding: 16px 12px;
        font-size: 12px;
        color: #64748b;
        border-bottom: 1px solid #f1f5f9;
        background: #fafafa;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .staff-table td {
        padding: 16px 12px;
        font-size: 13px;
        border-bottom: 1px solid #f8fbff;
        vertical-align: middle;
    }

    .staff-table tr:hover {
        background-color: #f8fafc;
    }

    /* Column Widths */
    .staff-table th:nth-child(1),
    .staff-table td:nth-child(1) {
        width: 40px;
        text-align: center;
        padding-left: 15px;
        padding-right: 5px;
    }

    .staff-table th:nth-child(2),
    .staff-table td:nth-child(2) {
        min-width: 250px;
    }

    .staff-table th:nth-child(3),
    .staff-table td:nth-child(3) {
        min-width: 130px;
    }

    .staff-table th:nth-child(4),
    .staff-table td:nth-child(4) {
        min-width: 150px;
    }

    .staff-table th:nth-child(5),
    .staff-table td:nth-child(5) {
        min-width: 100px;
    }

    .staff-table th:nth-child(6),
    .staff-table td:nth-child(6) {
        min-width: 120px;
    }

    .staff-table th:nth-child(7),
    .staff-table td:nth-child(7) {
        min-width: 160px;
    }

    /* Staff Cell */
    .staff-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .staff-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2D3E50, #8b5cf6);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
        flex-shrink: 0;
        overflow: hidden;
    }

    .staff-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .staff-info {
        flex: 1;
    }

    .staff-name {
        font-weight: 600;
        color: #2D3E50;
        font-size: 14px;
        margin-bottom: 2px;
        display: block;
    }

    .staff-email {
        font-size: 11px;
        color: #64748b;
        display: block;
    }

    /* Role Badges */
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .role-badge.admin {
        background: #f3e8ff;
        color: #6d28d9;
    }

    .role-badge.instructor {
        background: #dcfce7;
        color: #065f46;
    }

    /* Contact Info */
    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .contact-phone {
        font-size: 12px;
        color: #2D3E50;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .contact-phone i {
        color: #64748b;
        font-size: 10px;
    }

    .contact-empty {
        color: #94a3b8;
        font-size: 11px;
        font-style: italic;
    }

    /* Status Badge */
    .status-container {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }

    .status-active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    /* Joined Date */
    .joined-date {
        font-size: 12px;
        color: #2D3E50;
        font-weight: 500;
    }

    .joined-date small {
        display: block;
        color: #94a3b8;
        font-size: 10px;
        margin-top: 2px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #4b5563;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: relative;
        flex-shrink: 0;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    /* Tooltip styles */
    .btn-action[title]:hover::after {
        content: attr(title);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        padding: 5px 10px;
        background: #2D3E50;
        color: white;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
        white-space: nowrap;
        z-index: 100;
        margin-bottom: 5px;
        pointer-events: none;
    }

    /* Button specific colors */
    .btn-view {
        color: #3182ce;
        border-color: #3182ce;
    }

    .btn-view:hover {
        background: #3182ce;
        color: white;
    }

    .btn-edit {
        color: #8b5cf6;
        border-color: #8b5cf6;
    }

    .btn-edit:hover {
        background: #8b5cf6;
        color: white;
    }

    .btn-reset {
        color: #f59e0b;
        border-color: #f59e0b;
    }

    .btn-reset:hover {
        background: #f59e0b;
        color: white;
    }

    .btn-toggle {
        color: #10b981;
        border-color: #10b981;
    }

    .btn-toggle:hover {
        background: #10b981;
        color: white;
    }

    .btn-delete {
        color: #e53e3e;
        border-color: #e53e3e;
    }

    .btn-delete:hover {
        background: #e53e3e;
        color: white;
    }

    /* Bulk Actions */
    .bulk-actions {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 16px 20px;
        border-bottom: 1px solid #edf2f7;
        flex-wrap: wrap;
    }

    .bulk-select {
        padding: 10px 15px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #2D3E50;
        font-size: 13px;
        min-width: 150px;
    }

    .btn-bulk {
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-bulk.verify {
        background: #dbeafe;
        color: #1e40af;
    }

    .btn-bulk.verify:hover {
        background: #1e40af;
        color: white;
    }

    .btn-bulk.activate {
        background: #dcfce7;
        color: #15803d;
    }

    .btn-bulk.activate:hover {
        background: #15803d;
        color: white;
    }

    .btn-bulk.deactivate {
        background: #fef3c7;
        color: #d97706;
    }

    .btn-bulk.deactivate:hover {
        background: #d97706;
        color: white;
    }

    .btn-bulk.delete {
        background: #fee2e2;
        color: #b91c1c;
    }

    .btn-bulk.delete:hover {
        background: #b91c1c;
        color: white;
    }

    .selected-count {
        font-size: 13px;
        color: #64748b;
        margin-left: auto;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        border-top: 1px solid #f1f5f9;
    }

    .pagination-info {
        font-size: 12px;
        color: #94a3b8;
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
        font-size: 12px;
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
        width: 32px;
        height: 32px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .page-arrow:hover {
        background: #f8fafc;
        border-color: #2D3E50;
    }

    .page-arrow.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #64748b;
    }

    .empty-state i {
        font-size: 48px;
        color: #cbd5e0;
        margin-bottom: 15px;
    }

    .empty-state h3 {
        color: #4b5563;
        margin-bottom: 10px;
        font-size: 18px;
    }

    .empty-state p {
        color: #94a3b8;
        margin-bottom: 20px;
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

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .admin-container {
            padding: 15px;
        }

        .page-header {
            flex-direction: column;
            gap: 15px;
            align-items: stretch;
        }

        .filters-row {
            flex-direction: column;
            gap: 10px;
        }

        .search-container,
        .filter-select {
            width: 100%;
        }

        .actions-row {
            flex-direction: column;
            gap: 10px;
        }

        .filter-button {
            width: 100%;
            justify-content: center;
        }

        .bulk-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .selected-count {
            margin-left: 0;
            text-align: center;
        }

        .pagination-container {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .btn-action[title]:hover::after {
            display: none;
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
            <i class="fas fa-users-cog"></i>
            Staff Management
        </h1>
        <a href="{{ route('admin.staff.create') }}" class="btn-add-staff">
            <i class="fas fa-user-plus"></i>
            Add New Staff
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon admins">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['total_admins'] ?? 0 }}</span>
                <span class="stat-label">Total Admins</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon instructors">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['total_instructors'] ?? 0 }}</span>
                <span class="stat-label">Instructors</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon active">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['active_today'] ?? 0 }}</span>
                <span class="stat-label">Active Today</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pending">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['pending_verification'] ?? 0 }}</span>
                <span class="stat-label">Pending Verification</span>
            </div>
        </div>
    </div>

    <!-- Search and Filters Form -->
    <form method="GET" action="{{ route('admin.staff.index') }}" class="filter-form" id="filterForm">
        <!-- First Row: Filters -->
        <div class="filters-row">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="search-input" 
                       placeholder="Search by name, email or phone..."
                       value="{{ request('search') }}">
            </div>

            <select name="role" class="filter-select" id="roleFilter">
                <option value="">All Roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>

            <select name="status" class="filter-select" id="statusFilter">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>

            <select name="sort" class="filter-select" id="sortFilter">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
            </select>

            <select name="per_page" class="filter-select" id="perPageFilter">
                <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20 per page</option>
                <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 per page</option>
                <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 per page</option>
            </select>
        </div>

        <!-- Second Row: Action Buttons -->
        <div class="actions-row">
            <button type="submit" class="filter-button apply">
                <i class="fas fa-filter"></i> Apply Filters
            </button>

            @if(request()->hasAny(['search', 'role', 'status', 'sort', 'per_page']))
                <a href="{{ route('admin.staff.index') }}" class="filter-button clear">
                    <i class="fas fa-times"></i> Clear Filters
                </a>
            @endif
        </div>
    </form>

    <!-- Staff Table Card -->
    <div class="staff-table-card">
        @if($staff->count() > 0)
            <!-- Bulk Actions -->
            <div class="bulk-actions">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <input type="checkbox" id="selectAll" style="width: 18px; height: 18px; cursor: pointer;">
                    <label for="selectAll" style="font-size: 14px; color: #2D3E50; font-weight: 500;">
                        Select All
                    </label>
                </div>

                <select id="bulkActionSelect" class="bulk-select">
                    <option value="">Bulk Actions</option>
                    <option value="verify">Verify Email</option>
                    <option value="activate">Activate</option>
                    <option value="deactivate">Deactivate</option>
                    <option value="delete">Delete</option>
                </select>

                <button type="button" id="applyBulkAction" class="btn-bulk verify">
                    <i class="fas fa-check"></i>
                    Apply to Selected
                </button>

                <span id="selectedCount" class="selected-count">0 selected</span>
            </div>

            <div class="table-responsive">
                <table class="staff-table">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAllHeader" style="width: 16px; height: 16px;">
                            </th>
                            <th>Staff Member</th>
                            <th>Role</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staff as $member)
                        <tr data-id="{{ $member->id }}">
                            <td style="text-align: center;">
                                <input type="checkbox" class="staff-checkbox" value="{{ $member->id }}" 
                                       style="width: 16px; height: 16px; cursor: pointer;">
                            </td>
                            <td>
                                <div class="staff-cell">
                                    <div class="staff-avatar">
                                        @if($member->avatar && \Storage::disk('public')->exists($member->avatar))
                                            <img src="{{ Storage::url($member->avatar) }}" alt="{{ $member->name }}">
                                        @else
                                            {{ $member->initials }}
                                        @endif
                                    </div>
                                    <div class="staff-info">
                                        <span class="staff-name">{{ $member->name }}</span>
                                        <span class="staff-email">{{ $member->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @foreach($member->roles as $role)
                                    <span class="role-badge {{ $role->name }}">
                                        <i class="fas fa-{{ $role->name == 'admin' ? 'shield-alt' : 'chalkboard-teacher' }}"></i>
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            </td>
                            <td>
                                <div class="contact-info">
                                    @if($member->phone)
                                        <span class="contact-phone">
                                            <i class="fas fa-phone"></i> {{ $member->phone }}
                                        </span>
                                    @else
                                        <span class="contact-empty">No phone</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="status-container">
                                    @if($member->email_verified_at)
                                        <span class="status-badge status-active">
                                            <i class="fas fa-check-circle"></i> Active
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive">
                                            <i class="fas fa-times-circle"></i> Inactive
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="joined-date">
                                    {{ $member->created_at->format('M d, Y') }}
                                    <small>{{ $member->created_at->diffForHumans() }}</small>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <!-- View Button -->
                                    <a href="{{ route('admin.staff.show', $member) }}" class="btn-action btn-view" 
                                       title="View Staff Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.staff.edit', $member) }}" class="btn-action btn-edit" 
                                       title="Edit Staff">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- Reset Password Button -->
                                    <button type="button" class="btn-action btn-reset reset-password-btn" 
                                            data-staff-id="{{ $member->id }}"
                                            data-staff-name="{{ $member->name }}"
                                            title="Send Password Reset">
                                        <i class="fas fa-key"></i>
                                    </button>
                                    
                                    <!-- Toggle Status Button -->
                                    <button type="button" class="btn-action btn-toggle toggle-status-btn" 
                                            data-staff-id="{{ $member->id }}"
                                            data-staff-name="{{ $member->name }}"
                                            data-staff-active="{{ $member->email_verified_at ? 'true' : 'false' }}"
                                            data-staff-role="{{ $member->roles->first()->name ?? '' }}"
                                            title="{{ $member->email_verified_at ? 'Deactivate' : 'Activate' }}">
                                        <i class="fas fa-{{ $member->email_verified_at ? 'ban' : 'check-circle' }}"></i>
                                    </button>
                                    
                                    <!-- Delete Button -->
                                    <button type="button" class="btn-action btn-delete delete-staff-btn" 
                                            data-staff-id="{{ $member->id }}"
                                            data-staff-name="{{ $member->name }}"
                                            data-staff-role="{{ $member->roles->first()->name ?? '' }}"
                                            title="Delete Staff">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Hidden Forms -->
                                <form id="reset-form-{{ $member->id }}" 
                                      action="{{ route('admin.staff.reset-password', $member) }}" 
                                      method="POST" style="display: none;">
                                    @csrf
                                </form>
                                
                                <form id="toggle-form-{{ $member->id }}" 
                                      action="{{ route('admin.staff.toggle-status', $member) }}" 
                                      method="POST" style="display: none;">
                                    @csrf
                                </form>
                                
                                <form id="delete-form-{{ $member->id }}" 
                                      action="{{ route('admin.staff.destroy', $member) }}" 
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

            <!-- Pagination -->
            <div class="pagination-container">
                <div class="pagination-info">
                    Showing {{ $staff->firstItem() ?? 0 }} to {{ $staff->lastItem() ?? 0 }} 
                    of {{ $staff->total() }} staff members
                </div>
                <div class="pagination-links">
                    {{-- Previous Page Link --}}
                    @if($staff->onFirstPage())
                        <span class="page-arrow disabled">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $staff->previousPageUrl() }}" class="page-arrow">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements - Show 5 pages with dots --}}
                    @php
                        $currentPage = $staff->currentPage();
                        $lastPage = $staff->lastPage();
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
                        <a href="{{ $staff->url(1) }}" class="page-link">1</a>
                        @if($start > 2)
                            <span style="padding: 0 5px; color: #94a3b8;">...</span>
                        @endif
                    @endif

                    {{-- Page numbers --}}
                    @for($page = $start; $page <= $end; $page++)
                        <a href="{{ $staff->url($page) }}" 
                           class="page-link {{ $staff->currentPage() == $page ? 'active' : '' }}">
                            {{ $page }}
                        </a>
                    @endfor

                    {{-- Last page link with dots --}}
                    @if($end < $lastPage)
                        @if($end < $lastPage - 1)
                            <span style="padding: 0 5px; color: #94a3b8;">...</span>
                        @endif
                        <a href="{{ $staff->url($lastPage) }}" class="page-link">
                            {{ $lastPage }}
                        </a>
                    @endif

                    {{-- Next Page Link --}}
                    @if($staff->hasMorePages())
                        <a href="{{ $staff->nextPageUrl() }}" class="page-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="page-arrow disabled">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <i class="fas fa-users-cog"></i>
                <h3>No Staff Members Found</h3>
                <p>
                    @if(request()->hasAny(['search', 'role', 'status']))
                        Try adjusting your search criteria
                    @else
                        Start by adding your first staff member
                    @endif
                </p>
                @if(!request()->hasAny(['search', 'role', 'status']))
                    <a href="{{ route('admin.staff.create') }}" class="btn-add-staff" style="display: inline-flex;">
                        <i class="fas fa-user-plus"></i> Add Your First Staff
                    </a>
                @else
                    <a href="{{ route('admin.staff.index') }}" class="filter-button clear" style="display: inline-flex;">
                        <i class="fas fa-times"></i> Clear Filters
                    </a>
                @endif
            </div>
        @endif
    </div>
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

        // Auto-submit per_page on change
        const perPageSelect = document.getElementById('perPageFilter');
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        }

        // Enter key for search
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('filterForm').submit();
                }
            });
        }

        // ===================================
        // SELECT ALL CHECKBOXES
        // ===================================
        const selectAllHeader = document.getElementById('selectAllHeader');
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.staff-checkbox');
        const selectedCount = document.getElementById('selectedCount');

        function updateSelectedCount() {
            const checked = document.querySelectorAll('.staff-checkbox:checked').length;
            if (selectedCount) {
                selectedCount.textContent = checked + ' selected';
            }
        }

        if (selectAllHeader) {
            selectAllHeader.addEventListener('change', function() {
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
                if (selectAll) selectAll.checked = this.checked;
                updateSelectedCount();
            });
        }

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
                if (selectAllHeader) selectAllHeader.checked = this.checked;
                updateSelectedCount();
            });
        }

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                const allChecked = Array.from(checkboxes).every(c => c.checked);
                if (selectAllHeader) selectAllHeader.checked = allChecked;
                if (selectAll) selectAll.checked = allChecked;
                updateSelectedCount();
            });
        });

        // ===================================
        // BULK ACTIONS
        // ===================================
        const applyBulkAction = document.getElementById('applyBulkAction');
        
        if (applyBulkAction) {
            applyBulkAction.addEventListener('click', function() {
                const action = document.getElementById('bulkActionSelect').value;
                const selectedIds = Array.from(document.querySelectorAll('.staff-checkbox:checked'))
                    .map(cb => cb.value);
                
                if (selectedIds.length === 0) {
                    Swal.fire({
                        title: 'No Selection',
                        text: 'Please select at least one staff member',
                        icon: 'warning',
                        confirmButtonColor: '#2D3E50'
                    });
                    return;
                }

                if (!action) {
                    Swal.fire({
                        title: 'No Action Selected',
                        text: 'Please select an action to perform',
                        icon: 'warning',
                        confirmButtonColor: '#2D3E50'
                    });
                    return;
                }

                let title, text, confirmButtonColor, confirmText;
                
                switch(action) {
                    case 'verify':
                        title = 'Verify Email';
                        text = `Verify email for ${selectedIds.length} staff member(s)?`;
                        confirmButtonColor = '#3182ce';
                        confirmText = 'Yes, verify';
                        break;
                    case 'activate':
                        title = 'Activate Staff';
                        text = `Activate ${selectedIds.length} staff member(s)? They will gain access to the system.`;
                        confirmButtonColor = '#10b981';
                        confirmText = 'Yes, activate';
                        break;
                    case 'deactivate':
                        title = 'Deactivate Staff';
                        text = `Deactivate ${selectedIds.length} staff member(s)? They will lose access to the system.`;
                        confirmButtonColor = '#f59e0b';
                        confirmText = 'Yes, deactivate';
                        break;
                    case 'delete':
                        title = 'Delete Staff';
                        text = `Delete ${selectedIds.length} staff member(s)? This action cannot be undone.`;
                        confirmButtonColor = '#e53e3e';
                        confirmText = 'Yes, delete permanently';
                        break;
                }

                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: confirmButtonColor,
                    cancelButtonColor: '#64748b',
                    confirmButtonText: confirmText,
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('{{ route("admin.staff.bulk-action") }}', {
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
            });
        }

        // ===================================
        // RESET PASSWORD FUNCTION
        // ===================================
        document.querySelectorAll('.reset-password-btn').forEach(button => {
            button.addEventListener('click', function() {
                const staffId = this.getAttribute('data-staff-id');
                const staffName = this.getAttribute('data-staff-name');

                Swal.fire({
                    title: 'Send Password Reset?',
                    html: `<p style="margin-bottom: 10px;">Send password reset link to:</p>
                           <strong style="color: #2D3E50;">${staffName}</strong>`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#f59e0b',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fas fa-paper-plane"></i> Send Link',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Sending...',
                            text: 'Please wait',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        fetch(`/admin/staff/${staffId}/reset-password`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Link Sent!',
                                    text: data.message,
                                    icon: 'success',
                                    confirmButtonColor: '#2D3E50'
                                });
                            } else {
                                Swal.fire({
                                    title: 'Failed',
                                    text: data.error || 'Could not send reset link',
                                    icon: 'error',
                                    confirmButtonColor: '#2D3E50'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                title: 'Error',
                                text: 'An error occurred',
                                icon: 'error',
                                confirmButtonColor: '#2D3E50'
                            });
                        });
                    }
                });
            });
        });

        // ===================================
        // TOGGLE STATUS FUNCTION
        // ===================================
        document.querySelectorAll('.toggle-status-btn').forEach(button => {
            button.addEventListener('click', function() {
                const staffId = this.getAttribute('data-staff-id');
                const staffName = this.getAttribute('data-staff-name');
                const isActive = this.getAttribute('data-staff-active') === 'true';
                const staffRole = this.getAttribute('data-staff-role');

                const action = isActive ? 'deactivate' : 'activate';
                const title = isActive ? 'Deactivate Staff?' : 'Activate Staff?';
                const text = isActive 
                    ? `Are you sure you want to deactivate ${staffName}? They will lose access to the system.`
                    : `Are you sure you want to activate ${staffName}? They will gain access to the system.`;
                
                // Special warning for admins
                if (staffRole === 'admin' && isActive) {
                    Swal.fire({
                        title: 'Deactivate Admin?',
                        html: `<div style="text-align: left;">
                                <p>Are you sure you want to deactivate <strong>${staffName}</strong>?</p>
                                <div style="background: #fee2e2; border-left: 4px solid #dc2626; padding: 12px; border-radius: 6px; margin-top: 15px; color: #991b1b; font-size: 13px;">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span style="margin-left: 5px;">This is an admin account. Make sure there is at least one other active admin.</span>
                                </div>
                               </div>`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d97706',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Yes, deactivate',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            submitToggleStatus(staffId);
                        }
                    });
                } else {
                    Swal.fire({
                        title: title,
                        text: text,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: isActive ? '#d97706' : '#10b981',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: `Yes, ${action}`,
                        cancelButtonText: 'Cancel',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            submitToggleStatus(staffId);
                        }
                    });
                }
            });
        });

        function submitToggleStatus(staffId) {
            // Show loading
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`/admin/staff/${staffId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
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
                        title: 'Failed',
                        text: data.error || 'Could not update status',
                        icon: 'error',
                        confirmButtonColor: '#2D3E50'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error',
                    text: 'An error occurred',
                    icon: 'error',
                    confirmButtonColor: '#2D3E50'
                });
            });
        }

        // ===================================
        // DELETE STAFF FUNCTION
        // ===================================
        document.querySelectorAll('.delete-staff-btn').forEach(button => {
            button.addEventListener('click', function() {
                const staffId = this.getAttribute('data-staff-id');
                const staffName = this.getAttribute('data-staff-name');
                const staffRole = this.getAttribute('data-staff-role');

                let warning = '';
                if (staffRole === 'admin') {
                    warning = '<div style="background: #fee2e2; border-left: 4px solid #dc2626; padding: 12px; border-radius: 6px; margin-top: 15px; color: #991b1b; font-size: 13px;">' +
                              '<i class="fas fa-exclamation-triangle"></i> ' +
                              '<span style="margin-left: 5px;">This is an admin account. Make sure there is at least one other admin before deleting.</span>' +
                              '</div>';
                }

                Swal.fire({
                    title: 'Delete Staff Member?',
                    html: `<div style="text-align: left;">
                            <p style="margin-bottom: 15px;">Are you sure you want to delete:</p>
                            <div style="background: #f8fafc; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                                <strong style="color: #2D3E50; font-size: 16px;">${staffName}</strong>
                                <span style="display: inline-block; margin-left: 10px; padding: 4px 12px; background: ${staffRole === 'admin' ? '#f3e8ff' : '#dcfce7'}; color: ${staffRole === 'admin' ? '#6d28d9' : '#065f46'}; border-radius: 30px; font-size: 11px;">
                                    ${staffRole}
                                </span>
                            </div>
                            <div style="background: #fee2e2; border-left: 4px solid #dc2626; padding: 12px; border-radius: 6px; color: #991b1b; font-size: 13px;">
                                <i class="fas fa-exclamation-triangle"></i> 
                                <span style="margin-left: 5px;">This action cannot be undone. All data associated with this staff member will be permanently deleted.</span>
                            </div>
                            ${warning}
                           </div>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e53e3e',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fas fa-trash"></i> Yes, delete permanently',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${staffId}`).submit();
                    }
                });
            });
        });

        // Table row hover effect
        const tableRows = document.querySelectorAll('.staff-table tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = '#f8fafc';
            });
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });
    });
</script>
@endsection