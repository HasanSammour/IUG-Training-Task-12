@extends('layouts.app')

@section('title', 'Admin Menu - Shifra')
@section('body-class', 'admin-menu')

@section('styles')
<style>
    :root {
        --primary-navy: #2d3e50;
        --secondary-blue: #3182ce;
        --accent-green: #10b981;
        --accent-orange: #f59e0b;
        --accent-red: #ef4444;
        --text-dark: #1e293b;
        --text-gray: #64748b;
        --text-light: #94a3b8;
        --bg-light: #f8fbff;
        --white: #ffffff;
        --border-color: #e2e8f0;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --radius-sm: 0.375rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
    }

    .admin-menu .main-content {
        padding: 20px;
        max-width: 100%;
        margin: 0;
        min-height: calc(100vh - 200px);
        padding-bottom: 120px; /* Added padding for bottom content */
    }

    /* Page Header */
    .page-header {
        margin-bottom: 30px;
        padding: 30px;
        background: linear-gradient(135deg, var(--primary-navy) 0%, #1a252f 100%);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-lg);
        color: var(--white);
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        color: #93c5fd;
    }

    .page-subtitle {
        color: rgba(255, 255, 255, 0.8);
        font-size: 16px;
        margin-bottom: 0;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border-radius: var(--radius-lg);
        padding: 25px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.15);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        font-size: 20px;
        background: rgba(255, 255, 255, 0.2);
        color: var(--white);
    }

    .stat-content h3 {
        font-size: 32px;
        font-weight: 700;
        color: var(--white);
        margin-bottom: 5px;
        line-height: 1;
    }

    .stat-content p {
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
        font-weight: 500;
    }

    /* Main Content Container */
    .content-container {
        background: var(--white);
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
        overflow: hidden;
        margin-bottom: 30px;
    }

    /* Content Header */
    .content-header {
        padding: 30px;
        border-bottom: 1px solid var(--border-color);
        background: var(--white);
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--primary-navy);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .header-filters {
        display: flex;
        gap: 20px;
        align-items: center;
    }

    .search-box {
        position: relative;
        width: 100%;
        max-width: 400px;
    }

    .search-input {
        width: 100%;
        padding: 12px 45px 12px 15px;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-lg);
        font-size: 14px;
        transition: all 0.3s ease;
        background: var(--white);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--secondary-blue);
        box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
    }

    .search-button {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-light);
        cursor: pointer;
        padding: 5px;
    }

    .filter-select {
        padding: 12px 20px;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-lg);
        font-size: 14px;
        background: var(--white);
        color: var(--text-dark);
        cursor: pointer;
        min-width: 200px;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--secondary-blue);
    }

    .action-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 10px 20px;
        border-radius: var(--radius-lg);
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-navy), #1a252f);
        color: var(--white);
        box-shadow: 0 4px 6px rgba(45, 62, 80, 0.1);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(45, 62, 80, 0.15);
    }

    .btn-secondary {
        background: var(--white);
        color: var(--primary-navy);
        border: 2px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: var(--primary-navy);
    }

    .btn-success {
        background: linear-gradient(135deg, var(--accent-green), #059669);
        color: var(--white);
        box-shadow: 0 4px 6px rgba(16, 185, 129, 0.1);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(16, 185, 129, 0.15);
    }

    /* Tabs Navigation */
    .tabs-container {
        background: var(--white);
        border-bottom: 1px solid var(--border-color);
    }

    .tabs {
        display: flex;
        gap: 2px;
        padding: 0 30px;
        overflow-x: auto;
        scrollbar-width: none;
    }

    .tabs::-webkit-scrollbar {
        display: none;
    }

    .tab {
        padding: 15px 20px;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-gray);
        text-decoration: none;
        border-bottom: 3px solid transparent;
        white-space: nowrap;
        transition: all 0.3s ease;
        position: relative;
    }

    .tab:hover {
        color: var(--primary-navy);
        background: rgba(45, 62, 80, 0.03);
    }

    .tab.active {
        color: var(--secondary-blue);
        border-bottom-color: var(--secondary-blue);
        background: rgba(49, 130, 206, 0.05);
    }

    .tab-badge {
        margin-left: 8px;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
        background: rgba(100, 116, 139, 0.1);
        color: var(--text-gray);
    }

    .tab.active .tab-badge {
        background: rgba(49, 130, 206, 0.2);
        color: var(--secondary-blue);
    }

    /* Rectangular Courses List - Full Width */
    .courses-list {
        padding: 0;
        margin: 0;
    }

    .course-row {
        display: grid;
        grid-template-columns: 80px 1fr auto auto 150px; /* Increased width for price column */
        gap: 20px;
        align-items: center;
        padding: 20px 30px;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .course-row:hover {
        background: rgba(49, 130, 206, 0.02);
    }

    .course-row:last-child {
        border-bottom: none;
    }

    .course-image {
        width: 80px;
        height: 60px;
        border-radius: var(--radius-md);
        overflow: hidden;
    }

    .course-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .course-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .course-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--primary-navy);
        margin: 0;
    }

    .course-description {
        font-size: 13px;
        color: var(--text-gray);
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .course-meta {
        display: flex;
        flex-direction: column;
        gap: 5px;
        min-width: 150px;
    }

    .course-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        width: fit-content;
    }

    .status-active {
        background: rgba(16, 185, 129, 0.1);
        color: var(--accent-green);
    }

    .status-draft {
        background: rgba(245, 158, 11, 0.1);
        color: var(--accent-orange);
    }

    .course-category {
        font-size: 12px;
        color: var(--text-light);
    }

    /* FIXED: Course Price with proper spacing */
    .course-price {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-navy);
        text-align: center; /* Changed from right to center */
        min-width: 150px; /* Increased width */
        margin-right: 20px; /* Added margin to separate from buttons */
    }

    .course-price .original {
        font-size: 14px;
        color: var(--text-light);
        text-decoration: line-through;
        margin-right: 5px;
    }

    /* FIXED: Course Actions with proper spacing */
    .course-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        justify-content: flex-end;
        min-width: 140px; /* Added minimum width */
    }

    .action-btn {
        padding: 8px;
        border-radius: var(--radius-md);
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
    }

    .action-btn i {
        font-size: 14px;
    }

    .action-btn.edit {
        background: rgba(49, 130, 206, 0.1);
        color: var(--secondary-blue);
        border-color: rgba(49, 130, 206, 0.2);
    }

    .action-btn.edit:hover {
        background: var(--secondary-blue);
        color: var(--white);
    }

    .action-btn.view {
        background: rgba(16, 185, 129, 0.1);
        color: var(--accent-green);
        border-color: rgba(16, 185, 129, 0.2);
    }

    .action-btn.view:hover {
        background: var(--accent-green);
        color: var(--white);
    }

    .action-btn.delete {
        background: rgba(239, 68, 68, 0.1);
        color: var(--accent-red);
        border-color: rgba(239, 68, 68, 0.2);
    }

    .action-btn.delete:hover {
        background: var(--accent-red);
        color: var(--white);
    }

    /* Empty State */
    .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: var(--text-gray);
    }

    .empty-icon {
        font-size: 64px;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .empty-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 10px;
    }

    .empty-message {
        font-size: 16px;
        margin-bottom: 30px;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Pagination */
    .pagination-container {
        padding: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
    }

    .pagination {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .page-link {
        padding: 8px 16px;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        color: var(--text-gray);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background: rgba(45, 62, 80, 0.05);
        color: var(--primary-navy);
    }

    .page-link.active {
        background: var(--primary-navy);
        color: var(--white);
        border-color: var(--primary-navy);
    }

    .page-link.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .view-more-btn {
        padding: 12px 24px;
        background: linear-gradient(135deg, var(--primary-navy), #1a252f);
        color: var(--white);
        border: none;
        border-radius: var(--radius-lg);
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .view-more-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .view-more-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    /* FIXED: Quick Actions - Bottom spacing */
    .quick-actions-container {
        margin-top: 40px;
        margin-bottom: 40px; /* Added bottom margin */
        padding-bottom: 20px; /* Added padding */
    }

    .quick-actions-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }

    @media (max-width: 1200px) {
        .quick-actions {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .quick-actions {
            grid-template-columns: 1fr;
        }
    }

    .action-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 30px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 180px;
    }

    .action-card:hover {
        transform: translateY(-5px); /* Increased hover effect */
        box-shadow: var(--shadow-lg);
    }

    .action-card i {
        font-size: 32px;
        margin-bottom: 15px;
        color: var(--secondary-blue);
    }

    .action-card h3 {
        font-size: 18px;
        font-weight: 600;
        color: var(--primary-navy);
        margin-bottom: 10px;
    }

    .action-card p {
        font-size: 14px;
        color: var(--text-gray);
        margin-bottom: 0;
        line-height: 1.5;
        max-width: 100%;
        word-wrap: break-word;
    }

    /* Mobile Responsive */
    @media (max-width: 1024px) {
        .course-row {
            grid-template-columns: 60px 1fr auto;
            gap: 15px;
        }

        .course-meta, .course-price {
            grid-column: 3;
        }

        .course-actions {
            grid-column: 1 / -1;
            justify-content: flex-start;
            padding-top: 15px;
            border-top: 1px solid var(--border-color);
            margin-top: 15px;
            min-width: auto;
        }
    }

    @media (max-width: 768px) {
        .admin-menu .main-content {
            padding: 15px;
            padding-bottom: 100px; /* Adjusted for mobile */
        }

        .page-header {
            padding: 20px;
        }

        .header-top {
            flex-direction: column;
            gap: 15px;
        }

        .header-filters {
            flex-direction: column;
            width: 100%;
        }

        .search-box, .filter-select {
            max-width: 100%;
            width: 100%;
        }

        .action-buttons {
            width: 100%;
            justify-content: center;
        }

        .tabs {
            padding: 0 15px;
        }

        .tab {
            padding: 12px 15px;
            font-size: 13px;
        }

        .course-row {
            padding: 15px;
            grid-template-columns: 50px 1fr;
            gap: 10px;
        }

        .course-image {
            width: 50px;
            height: 50px;
        }

        .course-meta, .course-price {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-direction: row;
        }

        .course-status {
            margin-bottom: 0;
        }

        .course-actions {
            grid-column: 1 / -1;
            justify-content: center;
            min-width: auto;
        }

        .quick-actions {
            gap: 20px;
        }

        .action-card {
            min-height: 160px;
            padding: 20px;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .course-row {
            grid-template-columns: 1fr;
        }

        .course-image {
            width: 100%;
            height: 120px;
            grid-column: 1 / -1;
        }

        .course-info {
            grid-column: 1 / -1;
        }

        .course-meta {
            grid-column: 1 / -1;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .course-price {
            grid-column: 1 / -1;
            text-align: left;
            margin-right: 0;
            margin-bottom: 15px;
        }

        .quick-actions {
            gap: 15px;
        }

        .action-card {
            min-height: 150px;
            padding: 15px;
        }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-bars"></i> Admin Menu
    </h1>
    <p class="page-subtitle">Complete control panel for managing your training platform</p>
    
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $totalCourses ?? 0 }}</h3>
                <p>Total Courses</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $activeCourses ?? 0 }}</h3>
                <p>Active Courses</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-edit"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $draftCourses ?? 0 }}</h3>
                <p>Draft Courses</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $featuredCourses ?? 0 }}</h3>
                <p>Featured Courses</p>
            </div>
        </div>
    </div>
</div>

<div class="content-container">
    <div class="content-header">
        <div class="header-top">
            <h2 class="section-title">
                <i class="fas fa-th-list"></i> Courses Management
            </h2>
            
            <div class="action-buttons">
                <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> New Course
                </a>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                    <i class="fas fa-tags"></i> Categories
                </a>
            </div>
        </div>

        <div class="header-filters">
            <form method="GET" action="{{ route('admin.menu') }}" class="search-box" id="searchForm">
                <input type="text" class="search-input" name="search" placeholder="Search courses..." 
                       value="{{ request('search') }}">
                <button type="button" class="search-button" id="searchButton">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <select name="category_id" class="filter-select" onchange="this.form.submit()" form="searchForm">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="tabs-container">
            <nav class="tabs">
                <a href="{{ route('admin.menu') }}" class="tab {{ !request('is_active') && !request('search') ? 'active' : '' }}">
                    All Courses
                    <span class="tab-badge">{{ $totalCourses ?? 0 }}</span>
                </a>
                <a href="{{ route('admin.menu') }}?is_active=1" class="tab {{ request('is_active') == '1' ? 'active' : '' }}">
                    Active
                    <span class="tab-badge">{{ $activeCourses ?? 0 }}</span>
                </a>
                <a href="{{ route('admin.menu') }}?is_active=0" class="tab {{ request('is_active') == '0' ? 'active' : '' }}">
                    Draft
                    <span class="tab-badge">{{ $draftCourses ?? 0 }}</span>
                </a>
            </nav>
        </div>
    </div>

    @if($courses->count() > 0)
        <div class="courses-list">
            @foreach($courses as $course)
                <div class="course-row">
                    <div class="course-image">
                        @if($course->image_path)
                            <img src="{{ asset('storage/' . $course->image_path) }}" alt="{{ $course->title }}">
                        @else
                            <img src="{{ asset('images/course-placeholder.jpg') }}" alt="{{ $course->title }}">
                        @endif
                    </div>
                    
                    <div class="course-info">
                        <h3 class="course-title">{{ $course->title }}</h3>
                        <p class="course-description">{{ Str::limit($course->short_description, 80) }}</p>
                    </div>
                    
                    <div class="course-meta">
                        <span class="course-status status-{{ $course->is_active ? 'active' : 'draft' }}">
                            <i class="fas fa-circle"></i>
                            {{ $course->is_active ? 'Active' : 'Draft' }}
                        </span>
                        @if($course->category)
                            <span class="course-category">{{ $course->category->name }}</span>
                        @endif
                    </div>
                    
                    <div class="course-price">
                        @if($course->discount_percentage > 0)
                            <span class="original">${{ number_format($course->price, 2) }}</span>
                            ${{ number_format($course->price * (1 - $course->discount_percentage/100), 2) }}
                        @else
                            ${{ number_format($course->price, 2) }}
                        @endif
                    </div>
                    
                    <div class="course-actions">
                        <a href="{{ route('admin.courses.edit', $course) }}" class="action-btn edit" title="Edit Course">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('courses.show', $course->slug) }}" target="_blank" class="action-btn view" title="View Course">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button type="button" class="action-btn delete" title="Delete Course" onclick="deleteCourse({{ $course->id }}, '{{ $course->title }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            @if($courses->hasPages())
                <div class="pagination">
                    {{-- Previous Page Link --}}
                    @if($courses->onFirstPage())
                        <span class="page-link disabled">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $courses->previousPageUrl() }}" class="page-link">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif
        
                    {{-- Pagination Elements - Show 5 pages with dots --}}
                    @php
                        $currentPage = $courses->currentPage();
                        $lastPage = $courses->lastPage();
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
                        <a href="{{ $courses->url(1) }}" class="page-link">1</a>
                        @if($start > 2)
                            <span class="page-link disabled">...</span>
                        @endif
                    @endif
        
                    {{-- Page numbers --}}
                    @for($page = $start; $page <= $end; $page++)
                        @if($page == $currentPage)
                            <span class="page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $courses->url($page) }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endfor
        
                    {{-- Last page link with dots --}}
                    @if($end < $lastPage)
                        @if($end < $lastPage - 1)
                            <span class="page-link disabled">...</span>
                        @endif
                        <a href="{{ $courses->url($lastPage) }}" class="page-link">{{ $lastPage }}</a>
                    @endif
        
                    {{-- Next Page Link --}}
                    @if($courses->hasMorePages())
                        <a href="{{ $courses->nextPageUrl() }}" class="page-link">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="page-link disabled">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
            @endif
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <h3 class="empty-title">No Courses Found</h3>
            <p class="empty-message">
                @if(request('search') || request('category_id') || request('is_active'))
                    No courses match your search criteria. Try different filters.
                @else
                    Get started by creating your first course.
                @endif
            </p>
            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create First Course
            </a>
        </div>
    @endif
</div>

<!-- FIXED: Quick Actions with proper container -->
<div class="quick-actions-container">
    <h2 class="quick-actions-title">
        <i class="fas fa-bolt"></i> Quick Actions
    </h2>
    <div class="quick-actions">
        <a href="{{ route('admin.courses.create') }}" class="action-card">
            <i class="fas fa-plus-circle"></i>
            <h3>Add New Course</h3>
            <p>Create a new training course with detailed content</p>
        </a>
        
        <a href="{{ route('admin.categories.index') }}" class="action-card">
            <i class="fas fa-tags"></i>
            <h3>Manage Categories</h3>
            <p>Organize courses into categories for better navigation</p>
        </a>
        
        <a href="{{ route('admin.analytics.index') }}" class="action-card">
            <i class="fas fa-chart-line"></i>
            <h3>View Analytics</h3>
            <p>Monitor platform performance and user statistics</p>
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.querySelector('.search-input');
        const searchButton = document.getElementById('searchButton');
        const searchForm = document.getElementById('searchForm');
        
        function performSearch() {
            const query = searchInput.value.trim();
            if (query.length >= 2 || query.length === 0) {
                searchForm.submit();
            }
        }
        
        searchButton.addEventListener('click', performSearch);
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch();
            }
        });

        // Tab activation
        const tabs = document.querySelectorAll('.tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Course row hover effects
        const courseRows = document.querySelectorAll('.course-row');
        courseRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.backgroundColor = 'rgba(49, 130, 206, 0.02)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.backgroundColor = '';
            });
        });

        // Action buttons hover effects
        const actionButtons = document.querySelectorAll('.action-btn');
        actionButtons.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Action cards hover effects
        const actionCards = document.querySelectorAll('.action-card');
        actionCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });

    // Delete course with SweetAlert2 confirmation
    function deleteCourse(courseId, courseTitle) {
        Swal.fire({
            title: 'Delete Course?',
            html: `Are you sure you want to delete <strong>"${courseTitle}"</strong>?<br><br>
                   <small class="text-muted">This action cannot be undone. All course data will be permanently deleted.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch(`/admin/courses/${courseId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.json();
                })
                .catch(error => {
                    Swal.showValidationMessage(
                        `Request failed: ${error}`
                    );
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'The course has been deleted successfully.',
                    icon: 'success',
                    confirmButtonColor: '#10b981',
                    timer: 2000,
                    timerProgressBar: true,
                    willClose: () => {
                        window.location.reload();
                    }
                });
            }
        });
    }
</script>
@endsection