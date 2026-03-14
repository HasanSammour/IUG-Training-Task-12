@extends('layouts.app')

@section('title', 'All Courses - Shifra')
@section('body-class', 'public-page')

@section('styles')
<style>
    :root {
        --primary-navy: #2d3e50;
        --secondary-blue: #3182ce;
        --success-green: #10b981;
        --warning-orange: #f59e0b;
        --danger-red: #ef4444;
        --text-dark: #1e293b;
        --text-gray: #64748b;
        --text-light: #94a3b8;
        --bg-light: #f8fbff;
        --white: #ffffff;
        --border-color: #e2e8f0;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .public-page {
        background-color: var(--bg-light);
    }

    .courses-container {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 20px;
        padding-bottom: 100px;
    }

    /* Header Section */
    .page-header {
        margin-bottom: 40px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-left h1 {
        font-size: 36px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 10px;
    }

    .header-left p {
        color: var(--text-gray);
        font-size: 16px;
        max-width: 500px;
        line-height: 1.6;
    }

    .header-right {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Wishlist Button */
    .btn-wishlist-header {
        background: white;
        color: var(--primary-navy);
        border: 2px solid var(--border-color);
        padding: 12px 24px;
        border-radius: 40px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        position: relative;
    }

    .btn-wishlist-header:hover {
        border-color: var(--danger-red);
        color: var(--danger-red);
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .wishlist-count {
        background: var(--danger-red);
        color: white;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        position: absolute;
        top: -8px;
        right: -8px;
    }

    /* Admin/Instructor Action Buttons */
    .action-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-admin {
        background: linear-gradient(135deg, #1e40af, #3730a3);
        color: white;
        padding: 12px 24px;
        border-radius: 40px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-md);
    }

    .btn-admin:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-xl);
    }

    .btn-instructor {
        background: linear-gradient(135deg, #065f46, #047857);
        color: white;
        padding: 12px 24px;
        border-radius: 40px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-md);
    }

    .btn-instructor:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-xl);
    }

    /* Search Bar */
    .search-container {
        margin-bottom: 25px;
    }

    .search-wrapper {
        position: relative;
        max-width: 500px;
    }

    .search-input {
        width: 100%;
        padding: 15px 20px 15px 50px;
        border: 2px solid var(--border-color);
        border-radius: 50px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: var(--white);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary-navy);
        box-shadow: 0 0 0 4px rgba(45, 62, 80, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
        font-size: 18px;
    }

    .search-clear {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-light);
        cursor: pointer;
        font-size: 14px;
        display: none;
    }

    .search-input:not(:placeholder-shown)+.search-clear {
        display: block;
    }

    /* Filters Container */
    .filters-section {
        background: white;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 35px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
    }

    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 15px;
        margin-bottom: 15px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-group label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        background: white;
        color: var(--text-dark);
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        padding-right: 40px;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--primary-navy);
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    .active-filters {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid var(--border-color);
    }

    .filter-tag {
        background: #f0f9ff;
        color: #0369a1;
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .filter-tag i {
        color: #0284c7;
    }

    .remove-filter {
        color: var(--text-gray);
        text-decoration: none;
        font-size: 12px;
        transition: color 0.3s ease;
    }

    .remove-filter:hover {
        color: var(--danger-red);
    }

    .clear-all {
        background: #fee2e2;
        color: var(--danger-red);
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .clear-all:hover {
        background: #fecaca;
    }

    /* Results Count */
    .results-count {
        margin-bottom: 20px;
        font-size: 15px;
        color: var(--text-gray);
    }

    .results-count strong {
        color: var(--primary-navy);
        font-size: 18px;
    }

    /* Courses Grid */
    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }

    @media (max-width: 768px) {
        .courses-grid {
            grid-template-columns: 1fr;
        }
    }

    .course-card {
        background: white;
        border-radius: 24px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: var(--shadow-md);
        position: relative;
    }

    .course-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
        border-color: var(--primary-navy);
    }

    .card-image {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .course-card:hover .card-image img {
        transform: scale(1.08);
    }

    /* Wishlist Heart Button */
    .wishlist-btn {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 45px;
        height: 45px;
        background: white;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        box-shadow: var(--shadow-md);
        color: var(--text-gray);
        font-size: 20px;
    }

    .wishlist-btn:hover {
        transform: scale(1.1);
        box-shadow: var(--shadow-lg);
    }

    .wishlist-btn.active {
        background: #fee2e2;
        color: var(--danger-red);
    }

    .wishlist-btn.active i {
        font-weight: 900;
    }

    .wishlist-btn i {
        transition: all 0.3s ease;
    }

    .wishlist-btn.loading {
        pointer-events: none;
        opacity: 0.7;
    }

    .wishlist-btn.loading i {
        animation: spin 1s linear infinite;
    }

    /* Badges */
    .badge {
        position: absolute;
        top: 15px;
        left: 15px;
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        z-index: 2;
        box-shadow: var(--shadow-sm);
    }

    .badge.featured {
        background: #fef3c7;
        color: #d97706;
    }

    .badge.inactive {
        background: #fee2e2;
        color: #dc2626;
    }

    .badge.new {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge.free {
        background: #dcfce7;
        color: #15803d;
    }

    .rating-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(255, 255, 255, 0.95);
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 6px;
        box-shadow: var(--shadow-sm);
        z-index: 2;
    }

    .rating-badge i {
        color: #f59e0b;
    }

    .card-content {
        padding: 25px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 10px;
        line-height: 1.4;
        padding-right: 40px;
    }

    .card-description {
        color: var(--text-gray);
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
        flex: 1;
    }

    .instructor-info {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 15px;
        font-size: 13px;
        color: var(--text-gray);
    }

    .instructor-info i {
        color: var(--secondary-blue);
    }

    .instructor-info strong {
        color: var(--primary-navy);
    }

    /* Course Stats */
    .course-stats {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        padding: 15px;
        background: #f8fafc;
        border-radius: 16px;
    }

    .stat-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .stat-icon {
        color: var(--secondary-blue);
        font-size: 16px;
        margin-bottom: 4px;
    }

    .stat-value {
        font-size: 14px;
        font-weight: 700;
        color: var(--primary-navy);
        line-height: 1.2;
    }

    .stat-label {
        font-size: 11px;
        color: var(--text-gray);
        text-transform: uppercase;
    }

    .price-section {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .current-price {
        font-size: 24px;
        font-weight: 700;
        color: var(--primary-navy);
    }

    .original-price {
        font-size: 16px;
        color: var(--text-light);
        text-decoration: line-through;
    }

    .discount-badge {
        background: #dcfce7;
        color: #15803d;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
    }

    .free-badge {
        background: #dcfce7;
        color: #15803d;
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .tags {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .tag {
        padding: 5px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .tag.level {
        background: #e0f2fe;
        color: #0369a1;
    }

    .tag.format {
        background: #f1f5f9;
        color: #475569;
    }

    .card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: auto;
    }

    .btn {
        padding: 12px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: none;
    }

    .btn-details {
        background: #f8fafc;
        color: var(--primary-navy);
        border: 2px solid var(--border-color);
    }

    .btn-details:hover {
        background: var(--primary-navy);
        color: white;
        border-color: var(--primary-navy);
        transform: translateY(-2px);
    }

    .btn-register {
        background: var(--primary-navy);
        color: white;
        box-shadow: var(--shadow-md);
    }

    .btn-register:hover {
        background: #1a252f;
        transform: translateY(-3px);
        box-shadow: var(--shadow-xl);
    }

    .btn-continue {
        background: var(--success-green);
        color: white;
    }

    .btn-continue:hover {
        background: #0f9e6a;
        transform: translateY(-3px);
    }

    .btn-edit {
        background: var(--secondary-blue);
        color: white;
    }

    .btn-edit:hover {
        background: #2563eb;
        transform: translateY(-3px);
    }

    .btn-manage {
        background: #1e40af;
        color: white;
    }

    .btn-manage:hover {
        background: #3730a3;
        transform: translateY(-3px);
    }

    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 5px solid #f1f5f9;
        border-top-color: var(--primary-navy);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Toast Notifications */
    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        border-radius: 12px;
        padding: 16px 20px;
        box-shadow: var(--shadow-xl);
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 10000;
        transform: translateX(120%);
        transition: transform 0.3s ease;
        max-width: 350px;
        border-left: 4px solid var(--success-green);
    }

    .toast-notification.show {
        transform: translateX(0);
    }

    .toast-notification.error {
        border-left-color: var(--danger-red);
    }

    .toast-icon {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #dcfce7;
        color: var(--success-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .toast-notification.error .toast-icon {
        background: #fee2e2;
        color: var(--danger-red);
    }

    .toast-content {
        flex: 1;
    }

    .toast-title {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 2px;
    }

    .toast-message {
        font-size: 13px;
        color: var(--text-gray);
    }

    .toast-close {
        color: var(--text-light);
        cursor: pointer;
        background: none;
        border: none;
        font-size: 14px;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .page-link {
        min-width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        border: 2px solid var(--border-color);
        background: white;
        color: var(--text-gray);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background: var(--primary-navy);
        color: white;
        border-color: var(--primary-navy);
        transform: translateY(-2px);
    }

    .page-link.active {
        background: var(--primary-navy);
        color: white;
        border-color: var(--primary-navy);
    }

    .page-link.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .page-arrow {
        width: 45px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 30px;
        border: 1px solid var(--border-color);
        grid-column: 1 / -1;
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 24px;
        color: var(--primary-navy);
        margin-bottom: 10px;
        font-weight: 700;
    }

    .empty-state p {
        color: var(--text-gray);
        margin-bottom: 25px;
    }

    .btn-reset {
        background: var(--primary-navy);
        color: white;
        padding: 12px 30px;
        border-radius: 40px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-reset:hover {
        background: #1a252f;
        transform: translateY(-3px);
        box-shadow: var(--shadow-xl);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .courses-container {
            padding: 20px 15px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-right {
            width: 100%;
        }

        .action-buttons {
            width: 100%;
        }

        .btn-admin,
        .btn-instructor,
        .btn-wishlist-header {
            flex: 1;
            justify-content: center;
        }

        .filters-grid {
            grid-template-columns: 1fr;
        }

        .card-actions {
            grid-template-columns: 1fr;
        }

        .toast-notification {
            left: 20px;
            right: 20px;
            max-width: none;
        }
    }
</style>
@endsection

@section('content')
<div class="courses-container">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-notification" id="toastNotification">
        <div class="toast-icon">
            <i class="fas fa-check"></i>
        </div>
        <div class="toast-content">
            <div class="toast-title" id="toastTitle">Success</div>
            <div class="toast-message" id="toastMessage">Course added to wishlist</div>
        </div>
        <button class="toast-close" onclick="hideToast()">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div class="header-left">
            <h1>All Courses</h1>
            <p>Discover the perfect course to advance your career</p>
        </div>

        <div class="header-right">
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <div class="action-buttons">
                        <a href="{{ route('admin.courses.create') }}" class="btn-admin">
                            <i class="fas fa-plus"></i> New Course
                        </a>
                        <a href="{{ route('admin.courses.index') }}" class="btn-admin">
                            <i class="fas fa-cog"></i> Manage
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="btn-admin">
                            <i class="fas fa-chart-line"></i> Analytics
                        </a>
                    </div>
                @elseif(auth()->user()->hasRole('instructor'))
                    <div class="action-buttons">
                        <a href="{{ route('instructor.courses.create') }}" class="btn-instructor">
                            <i class="fas fa-plus"></i> New Course
                        </a>
                        <a href="{{ route('instructor.courses') }}" class="btn-instructor">
                            <i class="fas fa-book"></i> My Courses
                        </a>
                    </div>
                @else
                    <a href="{{ route('wishlist.index') }}" class="btn-wishlist-header">
                        <i class="fas fa-heart"></i> My Wishlist
                        <span class="wishlist-count" id="wishlistCount">{{ $wishlistCount ?? 0 }}</span>
                    </a>
                @endif
            @endauth
        </div>
    </div>

    <!-- Search Bar -->
    <div class="search-container">
        <div class="search-wrapper">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="search-input" id="searchInput"
                placeholder="Search courses by title, description, or instructor..." value="{{ request('search') }}">
            <button class="search-clear" id="clearSearch" onclick="clearSearch()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <div class="filters-grid">
            <div class="filter-group">
                <label>Category</label>
                <select class="filter-select" id="categoryFilter">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label>Level</label>
                <select class="filter-select" id="levelFilter">
                    <option value="">All Levels</option>
                    @foreach($levels as $level)
                        <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>
                            {{ ucfirst($level) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label>Format</label>
                <select class="filter-select" id="formatFilter">
                    <option value="">All Formats</option>
                    @foreach($formats as $format)
                        <option value="{{ $format }}" {{ request('format') == $format ? 'selected' : '' }}>
                            {{ ucfirst($format) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label>Sort By</label>
                <select class="filter-select" id="sortFilter">
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                </select>
            </div>

            @auth
                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('instructor'))
                    <div class="filter-group">
                        <label>Status</label>
                        <select class="filter-select" id="statusFilter">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active Only</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                        </select>
                    </div>
                @endif
            @endauth
        </div>

        <!-- Active Filters -->
        @php
            $activeFilters = [];
            if (request('category')) {
                $category = $categories->firstWhere('id', request('category'));
                if ($category)
                    $activeFilters[] = ['type' => 'category', 'label' => 'Category: ' . $category->name];
            }
            if (request('level'))
                $activeFilters[] = ['type' => 'level', 'label' => 'Level: ' . ucfirst(request('level'))];
            if (request('format'))
                $activeFilters[] = ['type' => 'format', 'label' => 'Format: ' . ucfirst(request('format'))];
            if (request('search'))
                $activeFilters[] = ['type' => 'search', 'label' => 'Search: "' . request('search') . '"'];
            if (request('status'))
                $activeFilters[] = ['type' => 'status', 'label' => 'Status: ' . ucfirst(request('status'))];
        @endphp

        @if(!empty($activeFilters) || request('sort'))
            <div class="active-filters">
                @foreach($activeFilters as $filter)
                    <span class="filter-tag">
                        <i class="fas fa-filter"></i> {{ $filter['label'] }}
                        <a href="{{ route('courses.public', request()->except($filter['type'])) }}" class="remove-filter">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endforeach

                @if(request('sort'))
                    <span class="filter-tag">
                        <i class="fas fa-sort"></i> Sort: {{ ucfirst(str_replace('_', ' ', request('sort'))) }}
                        <a href="{{ route('courses.public', request()->except('sort')) }}" class="remove-filter">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif

                <a href="{{ route('courses.public') }}" class="clear-all">
                    <i class="fas fa-times-circle"></i> Clear All
                </a>
            </div>
        @endif
    </div>

    <!-- Results Count -->
    <div class="results-count">
        <strong>{{ $courses->total() }}</strong> courses found
    </div>

    <!-- Courses Grid -->
    <div class="courses-grid">
        @forelse($courses as $course)
        @php
            $isNew = $course->created_at->gt(now()->subDays(7));
            $isFree = $course->price == 0;
            $enrollment = Auth::check() ? Auth::user()->enrollments()->where('course_id', $course->id)->first() : null;
            $isEnrolled = $enrollment !== null;
            $inWishlist = Auth::check() && !auth()->user()->hasRole('admin') && !auth()->user()->hasRole('instructor') 
                ? (isset($wishlistItems) && in_array($course->id, $wishlistItems)) 
                : false;

            // Use counts loaded from controller
            $sessionsCount = $course->sessions_count ?? 0;
            $assignmentsCount = $course->assignments_count ?? 0;
            $materialsCount = $course->materials_count ?? 0;
        @endphp

        <div class="course-card" data-course-id="{{ $course->id }}">
            <div class="card-image">
                <img src="{{ $course->image_url }}" alt="{{ $course->title }}">

                <!-- Wishlist Button (only for students) -->
                @auth
                    @if(!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('instructor'))
                        <button class="wishlist-btn {{ $inWishlist ? 'active' : '' }}" 
                                onclick="toggleWishlist({{ $course->id }}, this)"
                                title="{{ $inWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}">
                            <i class="{{ $inWishlist ? 'fas' : 'far' }} fa-heart"></i>
                        </button>
                    @endif
                @endauth

                <!-- Badges -->
                @auth
                    @if(auth()->user()?->hasRole('admin') || auth()->user()?->hasRole('instructor'))
                        @if(!$course->is_active)
                            <div class="badge inactive">
                                <i class="fas fa-eye-slash"></i> Inactive
                            </div>
                        @elseif($course->is_featured)
                            <div class="badge featured">
                                <i class="fas fa-star"></i> Featured
                            </div>
                        @elseif($isFree)
                            <div class="badge free">
                                <i class="fas fa-gift"></i> Free
                            </div>
                        @endif
                    @else
                        @if($isNew)
                            <div class="badge new">
                                <i class="fas fa-fire"></i> New
                            </div>
                        @elseif($course->is_featured)
                            <div class="badge featured">
                                <i class="fas fa-star"></i> Featured
                            </div>
                        @elseif($isFree)
                            <div class="badge free">
                                <i class="fas fa-gift"></i> Free
                            </div>
                        @endif
                    @endauth
                @else
                    @if($isNew)
                        <div class="badge new">
                            <i class="fas fa-fire"></i> New
                        </div>
                    @elseif($course->is_featured)
                        <div class="badge featured">
                            <i class="fas fa-star"></i> Featured
                        </div>
                    @elseif($isFree)
                        <div class="badge free">
                            <i class="fas fa-gift"></i> Free
                        </div>
                    @endif
                @endauth

                @if($course->rating > 0)
                    <div class="rating-badge">
                        <i class="fas fa-star"></i> {{ number_format($course->rating, 1) }}
                    </div>
                @endif
            </div>

            <div class="card-content">
                <h3 class="card-title">{{ $course->title }}</h3>
                <p class="card-description">{{ Str::limit($course->short_description, 100) }}</p>

                <div class="instructor-info">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Instructor: <strong>{{ $course->instructor_name }}</strong></span>
                </div>

                <!-- Course Stats -->
                <div class="course-stats">
                    <div class="stat-item">
                        <i class="fas fa-video stat-icon"></i>
                        <span class="stat-value">{{ $sessionsCount }}</span>
                        <span class="stat-label">Sessions</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-tasks stat-icon"></i>
                        <span class="stat-value">{{ $assignmentsCount }}</span>
                        <span class="stat-label">Tasks</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-file-alt stat-icon"></i>
                        <span class="stat-value">{{ $materialsCount }}</span>
                        <span class="stat-label">Materials</span>
                    </div>
                </div>

                <div class="price-section">
                    @if($isFree)
                        <span class="free-badge">
                            <i class="fas fa-gift"></i> FREE
                        </span>
                    @else
                        <span class="current-price">${{ number_format($course->final_price, 2) }}</span>
                        @if($course->is_discounted)
                            <span class="original-price">${{ number_format($course->price, 2) }}</span>
                            <span class="discount-badge">
                                -{{ $course->discount_percentage ?? round((($course->price - $course->discounted_price) / $course->price) * 100) }}%
                            </span>
                        @endif
                    @endif
                </div>

                <div class="tags">
                    <span class="tag level"><i class="fas fa-signal"></i> {{ ucfirst($course->level) }}</span>
                    <span class="tag format"><i class="fas fa-video"></i> {{ ucfirst($course->format) }}</span>
                </div>

                <!-- Action Buttons -->
                <div class="card-actions">
                    <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-details">
                        <i class="fas fa-info-circle"></i> Details
                    </a>

                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-manage">
                                <i class="fas fa-cog"></i> Manage
                            </a>
                        @elseif(auth()->user()->hasRole('instructor'))
                            @if($course->instructor_name == auth()->user()->name)
                                <a href="{{ route('instructor.courses.edit', $course) }}" class="btn btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @else
                                <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-details">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            @endif
                        @else
                            @if($isEnrolled)
                                <a href="{{ route('courses.progress', $enrollment->id) }}" class="btn btn-continue">
                                    <i class="fas fa-play"></i> Continue
                                </a>
                            @else
                                <a href="{{ route('courses.registration', $course->slug) }}" class="btn btn-register">
                                    <i class="fas fa-{{ $isFree ? 'gift' : 'shopping-cart' }}"></i>
                                    {{ $isFree ? 'Get Free' : 'Register Now' }}
                                </a>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}?redirect={{ urlencode(route('courses.registration', $course->slug)) }}"
                            class="btn btn-register">
                            <i class="fas fa-{{ $isFree ? 'gift' : 'shopping-cart' }}"></i>
                            {{ $isFree ? 'Get Free' : 'Register Now' }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-book-open"></i>
            <h3>No Courses Found</h3>
            <p>Try adjusting your search or filters to find what you're looking for.</p>
            <a href="{{ route('courses.public') }}" class="btn-reset">
                <i class="fas fa-redo"></i> Reset All Filters
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($courses->hasPages())
        <div class="pagination">
            @if($courses->onFirstPage())
                <span class="page-link page-arrow disabled">
                    <i class="fas fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $courses->previousPageUrl() }}" class="page-link page-arrow">
                    <i class="fas fa-chevron-left"></i>
                </a>
            @endif

            @foreach($courses->getUrlRange(max(1, $courses->currentPage() - 2), min($courses->lastPage(), $courses->currentPage() + 2)) as $page => $url)
                <a href="{{ $url }}" class="page-link {{ $courses->currentPage() == $page ? 'active' : '' }}">
                    {{ $page }}
                </a>
            @endforeach

            @if($courses->hasMorePages())
                <a href="{{ $courses->nextPageUrl() }}" class="page-link page-arrow">
                    <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="page-link page-arrow disabled">
                    <i class="fas fa-chevron-right"></i>
                </span>
            @endif
        </div>
    @endif
</div>

<!-- CSRF Token for AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Wishlist functions
    let wishlistTimeout;
    let wishlistCount = {{ $wishlistCount ?? 0 }};

    function toggleWishlist(courseId, button) {
        // Prevent double clicks
        if (button.classList.contains('loading')) return;
        
        const isActive = button.classList.contains('active');
        const action = isActive ? 'remove' : 'add';
        
        // Show loading
        button.classList.add('loading');
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        
        fetch(`/wishlist/${action}/${courseId}`, {
            method: action === 'add' ? 'POST' : 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            button.classList.remove('loading');
            
            if (data.success) {
                // Update button state
                if (action === 'add') {
                    button.classList.add('active');
                    button.innerHTML = '<i class="fas fa-heart"></i>';
                    button.title = 'Remove from wishlist';
                    wishlistCount = data.wishlist_count || wishlistCount + 1;
                    showToast('Added to Wishlist', 'Course has been added to your wishlist', 'success');
                } else {
                    button.classList.remove('active');
                    button.innerHTML = '<i class="far fa-heart"></i>';
                    button.title = 'Add to wishlist';
                    wishlistCount = data.wishlist_count || wishlistCount - 1;
                    showToast('Removed from Wishlist', 'Course has been removed from your wishlist', 'info');
                }
                
                // Update header count
                updateWishlistCount();
            } else {
                button.innerHTML = isActive ? '<i class="fas fa-heart"></i>' : '<i class="far fa-heart"></i>';
                showToast('Error', data.message || 'Failed to update wishlist', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            button.classList.remove('loading');
            button.innerHTML = isActive ? '<i class="fas fa-heart"></i>' : '<i class="far fa-heart"></i>';
            showToast('Error', 'Something went wrong', 'error');
        });
    }

    function updateWishlistCount() {
        const countElement = document.getElementById('wishlistCount');
        if (countElement) {
            countElement.textContent = wishlistCount;
            
            // Animate count change
            countElement.style.transform = 'scale(1.3)';
            setTimeout(() => {
                countElement.style.transform = 'scale(1)';
            }, 200);
        }
    }

    // Toast notification
    function showToast(title, message, type = 'success') {
        const toast = document.getElementById('toastNotification');
        const icon = toast.querySelector('.toast-icon i');
        const toastTitle = document.getElementById('toastTitle');
        const toastMessage = document.getElementById('toastMessage');
        
        // Clear previous timeout
        if (wishlistTimeout) clearTimeout(wishlistTimeout);
        
        // Update content
        toastTitle.textContent = title;
        toastMessage.textContent = message;
        
        // Update icon and color
        if (type === 'success') {
            toast.classList.remove('error');
            icon.className = 'fas fa-check';
        } else if (type === 'error') {
            toast.classList.add('error');
            icon.className = 'fas fa-exclamation-circle';
        } else {
            toast.classList.remove('error');
            icon.className = 'fas fa-info-circle';
        }
        
        // Show toast
        toast.classList.add('show');
        
        // Auto hide after 3 seconds
        wishlistTimeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }

    function hideToast() {
        const toast = document.getElementById('toastNotification');
        toast.classList.remove('show');
        if (wishlistTimeout) clearTimeout(wishlistTimeout);
    }

    // Filter functions
    document.addEventListener('DOMContentLoaded', function () {
        // Filter change handlers
        const filters = ['category', 'level', 'format', 'sort', 'status'];
        filters.forEach(filter => {
            const element = document.getElementById(filter + 'Filter');
            if (element) {
                element.addEventListener('change', function () {
                    applyFilters();
                });
            }
        });

        // Search with debounce
        const searchInput = document.getElementById('searchInput');
        let searchTimeout;

        if (searchInput) {
            searchInput.addEventListener('keyup', function (e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    applyFilters();
                }, 500);
            });
        }

        // Clear search
        window.clearSearch = function () {
            if (searchInput) {
                searchInput.value = '';
                applyFilters();
            }
        };
    });

    function applyFilters() {
        document.getElementById('loadingOverlay').style.display = 'flex';

        const params = new URLSearchParams(window.location.search);

        // Get filter values
        const category = document.getElementById('categoryFilter')?.value;
        const level = document.getElementById('levelFilter')?.value;
        const format = document.getElementById('formatFilter')?.value;
        const sort = document.getElementById('sortFilter')?.value;
        const status = document.getElementById('statusFilter')?.value;
        const search = document.getElementById('searchInput')?.value;

        // Set params
        if (category) params.set('category', category);
        else params.delete('category');

        if (level) params.set('level', level);
        else params.delete('level');

        if (format) params.set('format', format);
        else params.delete('format');

        if (sort) params.set('sort', sort);
        else params.delete('sort');

        if (status) params.set('status', status);
        else params.delete('status');

        if (search) params.set('search', search);
        else params.delete('search');

        // Reset to page 1
        params.delete('page');

        window.location.href = `${window.location.pathname}?${params.toString()}`;
    }
</script>
@endsection