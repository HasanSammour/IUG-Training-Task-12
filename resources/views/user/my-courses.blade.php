@extends('layouts.app')

@section('title', 'My Courses')
@section('body-class', 'auth-page')

@section('styles')
    <style>
        /* My Courses Page Styles */
        .my-courses-container {
            padding: 30px 40px;
            max-width: 100%;
            margin: 0 auto;
            padding-bottom: 100px;
            width: 100%;
        }

        /* Header */
        .page-header {
            margin-bottom: 30px;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #2D3E50;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-title i {
            color: #3182ce;
            background: rgba(49, 130, 206, 0.1);
            padding: 10px;
            border-radius: 12px;
        }

        .browse-link {
            background: #f1f5f9;
            color: #475569;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .browse-link:hover {
            background: #2D3E50;
            color: white;
            transform: translateY(-2px);
        }

        .page-subtitle {
            color: #64748b;
            font-size: 16px;
            max-width: 600px;
            line-height: 1.6;
        }

        /* Statistics Cards - 3 per row */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }

        @media (max-width: 992px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border-color: #2D3E50;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-icon.blue {
            background: #dbeafe;
            color: #2563eb;
        }

        .stat-icon.green {
            background: #dcfce7;
            color: #16a34a;
        }

        .stat-icon.yellow {
            background: #fef3c7;
            color: #d97706;
        }

        .stat-icon.purple {
            background: #f3e8ff;
            color: #9333ea;
        }

        .stat-icon.orange {
            background: #fed7aa;
            color: #c2410c;
        }

        .stat-content {
            flex: 1;
        }

        .stat-value {
            display: block;
            font-size: 28px;
            font-weight: 700;
            color: #2D3E50;
            line-height: 1.2;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Today's Sessions Banner */
        .today-sessions-banner {
            background: linear-gradient(135deg, #f0f9ff 0%, #e6f0fa 100%);
            border: 1px solid #bae6fd;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 25px;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }

        .today-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .today-title {
            font-size: 16px;
            font-weight: 600;
            color: #0369a1;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .today-title i {
            color: #0284c7;
        }

        .today-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .today-session-item {
            background: white;
            border-radius: 12px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .today-session-item:hover {
            transform: translateX(5px);
            border-color: #0284c7;
            box-shadow: 0 5px 15px rgba(2, 132, 199, 0.1);
        }

        .session-time {
            background: #0284c7;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            min-width: 100px;
            text-align: center;
        }

        .session-info {
            flex: 1;
        }

        .session-info h4 {
            font-size: 15px;
            color: #2D3E50;
            margin-bottom: 4px;
            font-weight: 600;
        }

        .session-info p {
            font-size: 12px;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .session-info p i {
            color: #94a3b8;
        }

        .session-action {
            background: #0284c7;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .session-action:hover {
            background: #0369a1;
            transform: translateY(-2px);
        }

        /* Filter Tabs */
        .filter-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
            overflow-x: auto;
            padding-bottom: 5px;
            border-bottom: 1px solid #e2e8f0;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }

        .filter-tab {
            padding: 10px 20px;
            border-radius: 30px;
            background: #f8fafc;
            color: #475569;
            font-size: 14px;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .filter-tab.active {
            background: #2D3E50;
            color: white;
            border-color: #2D3E50;
        }

        .filter-tab:hover:not(.active) {
            background: #e2e8f0;
            border-color: #94a3b8;
        }

        .filter-tab i {
            font-size: 14px;
        }

        .filter-badge {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 11px;
            margin-left: 5px;
        }

        .filter-tab:not(.active) .filter-badge {
            background: #2D3E50;
            color: white;
        }

        /* Active Filters */
        .active-filters {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
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
            border: 1px solid #bae6fd;
        }

        .filter-tag i {
            color: #0284c7;
            font-size: 12px;
        }

        .remove-filter {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #cbd5e0;
            color: white;
            font-size: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .remove-filter:hover {
            background: #2D3E50;
        }

        /* Course Grid */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }

        @media (max-width: 768px) {
            .courses-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Course Card */
        .course-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            height: 100%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.08);
            border-color: #2D3E50;
        }

        .course-image-wrapper {
            position: relative;
            height: 180px;
            overflow: hidden;
        }

        .course-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .course-card:hover .course-image {
            transform: scale(1.05);
        }

        .course-level-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .course-level-badge.beginner {
            color: #2e7d32;
        }

        .course-level-badge.intermediate {
            color: #f57c00;
        }

        .course-level-badge.advanced {
            color: #c62828;
        }

        .course-content {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .course-title {
            font-size: 18px;
            color: #2D3E50;
            margin-bottom: 10px;
            font-weight: 600;
            line-height: 1.4;
        }

        .course-meta {
            display: flex;
            gap: 15px;
            font-size: 12px;
            color: #64748b;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .course-instructor {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .course-instructor i {
            color: #94a3b8;
        }

        .course-rating {
            display: flex;
            align-items: center;
            gap: 3px;
            color: #fbbf24;
        }

        .course-rating span {
            color: #64748b;
            margin-left: 2px;
        }

        .course-category {
            background: #f1f5f9;
            color: #475569;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            display: inline-block;
            margin-bottom: 10px;
        }

        /* Course Stats Row */
        .course-stats-row {
            display: flex;
            gap: 15px;
            margin: 10px 0;
            padding: 10px 0;
            border-top: 1px dashed #e2e8f0;
            border-bottom: 1px dashed #e2e8f0;
        }

        .stat-item {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #475569;
        }

        .stat-item i {
            color: #3182ce;
            font-size: 14px;
        }

        .stat-item span {
            font-weight: 600;
            margin-right: 3px;
            color: #2D3E50;
        }

        /* Progress Section */
        .progress-section {
            margin: 15px 0;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: #64748b;
            margin-bottom: 8px;
        }

        .progress-label {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .progress-percentage {
            font-weight: 600;
            color: #2D3E50;
        }

        .progress-bar-container {
            height: 8px;
            background: #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #2D3E50, #3182ce);
            border-radius: 10px;
            transition: width 0.5s ease;
        }

        .course-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            margin-top: 5px;
        }

        .status-active {
            background: #d1fae5;
            color: #065f46;
        }

        .status-completed {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }
        
        .status-cancelled {
            background: #fee2e2;
            color: #b91c1c;
        }
        
        .btn-disabled {
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #e2e8f0;
            cursor: not-allowed;
            pointer-events: none;
        }
        
        .btn-reenroll {
            background: #2D3E50;
            color: white;
        }
        
        .btn-reenroll:hover {
            background: #1a252f;
        }

        /* Upcoming Session Badge */
        .upcoming-session-badge {
            margin-top: 10px;
            padding: 8px 12px;
            background: #f0f9ff;
            border-radius: 8px;
            border-left: 3px solid #0284c7;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
        }

        .upcoming-session-badge i {
            color: #0284c7;
            font-size: 14px;
        }

        .upcoming-session-badge span {
            color: #0369a1;
            font-weight: 500;
        }

        .upcoming-session-badge small {
            color: #64748b;
            margin-left: auto;
        }

        /* Enrollment Date */
        .enrollment-date {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .enrollment-date i {
            font-size: 10px;
        }

        /* Action Buttons */
        .course-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
        }

        .btn-action {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            border: none;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-continue {
            background: #2D3E50;
            color: white;
        }

        .btn-continue:hover {
            background: #1a252f;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
        }

        .btn-review {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .btn-review:hover {
            background: #e2e8f0;
            transform: translateY(-2px);
        }

        .btn-details {
            background: white;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .btn-details:hover {
            background: #f8fafc;
            border-color: #2D3E50;
            color: #2D3E50;
        }

        /* Pagination */
        .pagination-wrapper {
            margin-top: 40px;
            padding: 20px 0;
            border-top: 1px solid #e2e8f0;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }

        .pagination-info {
            text-align: center;
            color: #64748b;
            font-size: 13px;
            margin-bottom: 15px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            display: inline-block;
            margin: 0 2px;
        }

        .pagination li a,
        .pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 10px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: white;
            color: #475569;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
        }

        .pagination li a:hover {
            background: #2D3E50;
            color: white;
            border-color: #2D3E50;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
        }

        .pagination li.active span {
            background: #2D3E50;
            color: white;
            border-color: #2D3E50;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
        }

        .pagination li.disabled span {
            background: #f1f5f9;
            color: #94a3b8;
            border-color: #e2e8f0;
            cursor: not-allowed;
        }

        /* Empty State - Full Width */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 30px;
            border: 1px solid #e2e8f0;
            grid-column: 1 / -1;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
            width: 100%;
        }

        .empty-icon {
            font-size: 64px;
            color: #cbd5e1;
            margin-bottom: 20px;
        }

        .empty-title {
            font-size: 22px;
            color: #2D3E50;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .empty-text {
            color: #64748b;
            font-size: 15px;
            margin-bottom: 25px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-primary {
            display: inline-block;
            padding: 12px 30px;
            background: #2D3E50;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #1a252f;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(45, 62, 80, 0.15);
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
            width: 50px;
            height: 50px;
            border: 4px solid #f1f5f9;
            border-top-color: #2D3E50;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .my-courses-container {
                padding: 20px;
            }

            .header-top {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .browse-link {
                width: 100%;
                justify-content: center;
            }

            .filter-tabs {
                flex-wrap: nowrap;
                overflow-x: auto;
            }

            .course-actions {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
            }

            .pagination {
                gap: 5px;
            }

            .pagination li a,
            .pagination li span {
                min-width: 36px;
                height: 36px;
                font-size: 13px;
            }

            .today-session-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .session-time {
                width: 100%;
            }

            .session-action {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection

@section('content')
    <div class="my-courses-container">
        <!-- Header -->
        <div class="page-header">
            <div class="header-top">
                <h1 class="page-title">
                    <i class="fas fa-graduation-cap"></i>
                    My Courses
                </h1>
                <a href="{{ route('courses.public') }}" class="browse-link">
                    <i class="fas fa-search"></i>
                    Browse More Courses
                </a>
            </div>
            <p class="page-subtitle">
                Track your learning progress and continue where you left off
            </p>
        </div>

        <!-- Statistics - 3 per row -->
        <div class="stats-grid">
            <div class="stat-card" onclick="filterCourses('all')">
                <div class="stat-icon blue">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-value">{{ $stats['total'] }}</span>
                    <span class="stat-label">Total Courses</span>
                </div>
            </div>
            <div class="stat-card" onclick="filterCourses('active')">
                <div class="stat-icon green">
                    <i class="fas fa-play-circle"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-value">{{ $stats['active'] ?? 0 }}</span>
                    <span class="stat-label">Active</span>
                </div>
            </div>
            <div class="stat-card" onclick="filterCourses('completed')">
                <div class="stat-icon blue">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-value">{{ $stats['completed'] }}</span>
                    <span class="stat-label">Completed</span>
                </div>
            </div>
            <div class="stat-card" onclick="filterCourses('pending')">
                <div class="stat-icon yellow">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-value">{{ $stats['pending'] ?? 0 }}</span>
                    <span class="stat-label">Pending</span>
                </div>
            </div>
            <div class="stat-card" onclick="filterCourses('cancelled')">
                <div class="stat-icon orange">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-value">{{ $stats['cancelled'] ?? 0 }}</span>
                    <span class="stat-label">Cancelled</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-value">{{ $stats['total_hours'] }}h</span>
                    <span class="stat-label">Hours Learned</span>
                </div>
            </div>
        </div>

        <!-- Today's Live Sessions -->
        @php
            $todaySessions = \App\Models\CourseSession::whereIn('course_id', $enrollments->pluck('course_id'))
                ->with('course')
                ->whereDate('start_time', today())
                ->where('start_time', '>', now())
                ->orderBy('start_time')
                ->get();
        @endphp

        @if($todaySessions->count() > 0)
            <div class="today-sessions-banner">
                <div class="today-header">
                    <h3 class="today-title">
                        <i class="fas fa-calendar-day"></i>
                        Today's Live Sessions
                    </h3>
                    <span>{{ $todaySessions->count() }} session{{ $todaySessions->count() > 1 ? 's' : '' }}</span>
                </div>
                <div class="today-list">
                    @foreach($todaySessions as $session)
                        <div class="today-session-item">
                            <div class="session-time">
                                {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}
                            </div>
                            <div class="session-info">
                                <h4>{{ $session->title }}</h4>
                                <p>
                                    <i class="fas fa-book"></i> {{ $session->course->title }}
                                    @if($session->meeting_url)
                                        <i class="fas fa-video" style="margin-left: 10px; color: #0284c7;"></i> Live Now
                                    @endif
                                </p>
                            </div>
                            @if($session->meeting_url)
                                <a href="{{ $session->meeting_url }}" target="_blank" class="session-action">
                                    <i class="fas fa-video"></i> Join
                                </a>
                            @else
                                <a href="{{ route('courses.sessions.show', [$session->course_id, $session->id]) }}"
                                    class="session-action">
                                    <i class="fas fa-info-circle"></i> Details
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <button class="filter-tab active" onclick="filterCourses('all')" id="filterAll">
                <i class="fas fa-th-large"></i>
                All Courses
                <span class="filter-badge">{{ $stats['total'] }}</span>
            </button>
            <button class="filter-tab" onclick="filterCourses('active')" id="filterActive">
                <i class="fas fa-play-circle"></i>
                Active
                <span class="filter-badge">{{ $stats['active'] ?? 0 }}</span>
            </button>
            <button class="filter-tab" onclick="filterCourses('completed')" id="filterCompleted">
                <i class="fas fa-check-circle"></i>
                Completed
                <span class="filter-badge">{{ $stats['completed'] }}</span>
            </button>
            <button class="filter-tab" onclick="filterCourses('pending')" id="filterPending">
                <i class="fas fa-clock"></i>
                Pending
                <span class="filter-badge">{{ $stats['pending'] ?? 0 }}</span>
            </button>
            <button class="filter-tab" onclick="filterCourses('cancelled')" id="filterCancelled">
                <i class="fas fa-times-circle"></i>
                Cancelled
                <span class="filter-badge">{{ $stats['cancelled'] ?? 0 }}</span>
            </button>
        </div>

        <!-- Active Filters -->
        <div class="active-filters" id="activeFilters" style="display: none;">
            <span class="filter-tag" id="activeFilterTag">
                <i class="fas fa-filter"></i>
                <span id="filterLabel">Showing: Active courses</span>
                <a href="#" class="remove-filter" onclick="clearFilter(); return false;">
                    <i class="fas fa-times"></i>
                </a>
            </span>
        </div>

        <!-- Courses Grid -->
        @if($enrollments->count() > 0)
            <div class="courses-grid" id="coursesGrid">
                @foreach($enrollments as $enrollment)
                    @php
                        $course = $enrollment->course;
                        $upcomingSession = \App\Models\CourseSession::where('course_id', $course->id)
                            ->where('start_time', '>', now())
                            ->where('status', 'scheduled')
                            ->orderBy('start_time')
                            ->first();

                        $pendingAssignments = \App\Models\CourseAssignment::where('course_id', $course->id)
                            ->whereDoesntHave('submissions', function ($q) use ($enrollment) {
                                $q->where('user_id', $enrollment->user_id);
                            })
                            ->count();

                        $materialsCount = \App\Models\CourseMaterial::where('course_id', $course->id)->count();
                    @endphp

                    <div class="course-card" data-status="{{ $enrollment->status }}" data-enrollment-id="{{ $enrollment->id }}"
                        onclick="window.location.href='{{ route('courses.progress', $enrollment->id) }}'">

                        <div class="course-image-wrapper">
                            <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="course-image">
                            <span class="course-level-badge {{ $course->level }}">
                                <i class="fas fa-signal"></i>
                                {{ ucfirst($course->level ?? 'beginner') }}
                            </span>
                        </div>

                        <div class="course-content">
                            <h3 class="course-title">{{ $course->title }}</h3>

                            <div class="course-meta">
                                <span class="course-instructor">
                                    <i class="fas fa-user"></i>
                                    {{ $course->instructor_name }}
                                </span>
                                <span class="course-rating">
                                    <i class="fas fa-star"></i>
                                    {{ number_format($course->rating ?? 4.5, 1) }}
                                    <span>({{ $course->reviews_count ?? 0 }})</span>
                                </span>
                            </div>

                            @if($course->category)
                                <span class="course-category">
                                    <i class="fas fa-folder"></i>
                                    {{ $course->category->name }}
                                </span>
                            @endif

                            <!-- Course Stats Row -->
                            <div class="course-stats-row">
                                <div class="stat-item" title="Live Sessions">
                                    <i class="fas fa-video"></i>
                                    <span>{{ $course->sessions_count ?? 0 }}</span> Sessions
                                </div>
                                <div class="stat-item" title="Assignments">
                                    <i class="fas fa-tasks"></i>
                                    <span>{{ $course->assignments_count ?? 0 }}</span> Tasks
                                </div>
                                <div class="stat-item" title="Materials">
                                    <i class="fas fa-file-alt"></i>
                                    <span>{{ $materialsCount }}</span> Files
                                </div>
                            </div>

                            <!-- Pending Assignment Alert -->
                            @if($pendingAssignments > 0)
                                <div
                                    style="margin: 8px 0; padding: 5px 10px; background: #fef3c7; border-radius: 20px; font-size: 11px; color: #92400e; display: inline-flex; align-items: center; gap: 5px;">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    {{ $pendingAssignments }} pending assignment{{ $pendingAssignments > 1 ? 's' : '' }}
                                </div>
                            @endif

                            <!-- Upcoming Session Badge -->
                            @if($upcomingSession)
                                <div class="upcoming-session-badge">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>Upcoming: {{ $upcomingSession->title }}</span>
                                    <small>{{ \Carbon\Carbon::parse($upcomingSession->start_time)->format('M d, h:i A') }}</small>
                                </div>
                            @endif

                            <div class="progress-section">
                                <div class="progress-header">
                                    <span class="progress-label">
                                        <i class="fas fa-chart-line"></i>
                                        Progress
                                    </span>
                                    <span class="progress-percentage">{{ $enrollment->progress_percentage }}%</span>
                                </div>
                                <div class="progress-bar-container">
                                    <div class="progress-fill" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                   <span class="course-status 
                                        @switch($enrollment->status)
                                            @case('active') status-active @break
                                            @case('completed') status-completed @break
                                            @case('pending') status-pending @break
                                            @case('cancelled') status-cancelled @break
                                        @endswitch
                                    ">
                                        @switch($enrollment->status)
                                            @case('active')
                                                <i class="fas fa-play"></i> Active
                                                @break
                                            @case('completed')
                                                <i class="fas fa-check-circle"></i> Completed
                                                @break
                                            @case('pending')
                                                <i class="fas fa-clock"></i> Pending Approval
                                                @break
                                            @case('cancelled')
                                                <i class="fas fa-times-circle"></i> Cancelled
                                                @break
                                        @endswitch
                                    </span>

                                    <span class="enrollment-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        Enrolled {{ $enrollment->enrolled_at->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>

                            <div class="course-actions" onclick="event.stopPropagation()">
                                @switch($enrollment->status)
                                    @case('active')
                                        @if($enrollment->progress_percentage < 100)
                                            <a href="{{ route('courses.progress', $enrollment->id) }}" class="btn-action btn-continue">
                                                <i class="fas fa-play"></i> Continue
                                            </a>
                                        @else
                                            <a href="{{ route('courses.show', $course->slug) }}" class="btn-action btn-review">
                                                <i class="fas fa-redo"></i> Review
                                            </a>
                                        @endif
                                        <a href="{{ route('courses.show', $course->slug) }}" class="btn-action btn-details">
                                            <i class="fas fa-info-circle"></i> Details
                                        </a>
                                        @break

                                    @case('completed')
                                        <a href="{{ route('courses.show', $course->slug) }}" class="btn-action btn-review">
                                            <i class="fas fa-redo"></i> Review
                                        </a>
                                        <a href="{{ route('courses.progress', $enrollment->id) }}" class="btn-action btn-details">
                                            <i class="fas fa-chart-line"></i> Progress
                                        </a>
                                        @break

                                    @case('pending')
                                        <span class="btn-action" style="background: #fef3c7; color: #92400e; cursor: default;">
                                            <i class="fas fa-clock"></i> Awaiting Approval
                                        </span>
                                        <a href="{{ route('courses.show', $course->slug) }}" class="btn-action btn-details">
                                            <i class="fas fa-info-circle"></i> Details
                                        </a>
                                        @break

                                    @case('cancelled')
                                        <a href="{{ route('courses.show', $course->slug) }}" class="btn-action btn-continue">
                                            <i class="fas fa-redo"></i> Re-enroll
                                        </a>
                                        <a href="{{ route('courses.show', $course->slug) }}" class="btn-action btn-details">
                                            <i class="fas fa-info-circle"></i> Details
                                        </a>
                                        @break
                                @endswitch
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if(method_exists($enrollments, 'links'))
                <div class="pagination-wrapper">
                    <div class="pagination-info">
                        Showing {{ $enrollments->firstItem() }} to {{ $enrollments->lastItem() }} of {{ $enrollments->total() }}
                        courses
                    </div>
                    {{ $enrollments->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        @else
            <!-- Empty State - Full Width -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 class="empty-title">No Courses Yet</h3>
                <p class="empty-text">
                    You haven't enrolled in any courses yet. Start your learning journey by exploring our course catalog.
                </p>
                <a href="{{ route('courses.public') }}" class="btn-primary">
                    <i class="fas fa-search"></i> Browse Courses
                </a>
            </div>
        @endif
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Animate progress bars
            document.querySelectorAll('.progress-fill').forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.transition = 'width 1s ease';
                    bar.style.width = width;
                }, 300);
            });

            // Card hover effects
            document.querySelectorAll('.course-card').forEach(card => {
                card.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-5px)';
                });

                card.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Initialize filter functionality
            window.currentFilter = 'all';
        });

        // Filter courses by status
        function filterCourses(status) {
            // Update active tab
            document.querySelectorAll('.filter-tab').forEach(btn => {
                btn.classList.remove('active');
            });
            document.getElementById(`filter${status.charAt(0).toUpperCase() + status.slice(1)}`).classList.add('active');

            // Update current filter
            window.currentFilter = status;

            // Show/hide courses
            const courses = document.querySelectorAll('.course-card');
            let visibleCount = 0;

            courses.forEach(course => {
                const courseStatus = course.dataset.status;

                if (status === 'all' || courseStatus === status) {
                    course.style.display = 'flex';
                    visibleCount++;
                } else {
                    course.style.display = 'none';
                }
            });

            // Show/hide active filters indicator
            const activeFilters = document.getElementById('activeFilters');
            const filterLabel = document.getElementById('filterLabel');

            if (status !== 'all') {
                activeFilters.style.display = 'flex';
                filterLabel.textContent = `Showing: ${status.charAt(0).toUpperCase() + status.slice(1)} courses`;
            } else {
                activeFilters.style.display = 'none';
            }

            // Show empty state if no visible courses
            if (visibleCount === 0 && courses.length > 0) {
                if (!document.getElementById('filterEmptyState')) {
                    showFilterEmptyState(status);
                }
            } else {
                const filterEmpty = document.getElementById('filterEmptyState');
                if (filterEmpty) filterEmpty.remove();
            }
        }

        // Clear active filter
        function clearFilter() {
            filterCourses('all');
        }

        // Show empty state for filter
        function showFilterEmptyState(filter) {
            const container = document.querySelector('.courses-grid');
            if (!container) return;

            const emptyState = document.createElement('div');
            emptyState.id = 'filterEmptyState';
            emptyState.className = 'empty-state';
            emptyState.style.gridColumn = '1 / -1';

            let icon, title, text;
            switch (filter) {
                case 'active':
                    icon = 'fa-play-circle';
                    title = 'No Active Courses';
                    text = "You don't have any active courses at the moment. Start a new course to see it here.";
                    break;
                case 'completed':
                    icon = 'fa-check-circle';
                    title = 'No Completed Courses';
                    text = "You haven't completed any courses yet. Keep learning to earn completions!";
                    break;
                case 'pending':
                    icon = 'fa-clock';
                    title = 'No Pending Courses';
                    text = "You don't have any pending courses. All your courses are either active or completed.";
                    break;
                case 'cancelled':
                    icon = 'fa-times-circle';
                    title = 'No Cancelled Courses';
                    text = "You don't have any cancelled courses.";
                    break;
                default:
                    return;
            }

            emptyState.innerHTML = `
                <div class="empty-icon">
                    <i class="fas ${icon}"></i>
                </div>
                <h3 class="empty-title">${title}</h3>
                <p class="empty-text">${text}</p>
                <button onclick="clearFilter()" class="btn-primary">
                    <i class="fas fa-times"></i> Clear Filter
                </button>
            `;

            container.appendChild(emptyState);
        }
    </script>
@endsection