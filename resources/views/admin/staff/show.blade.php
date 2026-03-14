@extends('layouts.app')

@section('title', $staff->name . ' - Staff Details')
@section('body-class', 'admin-page')

@section('styles')
<style>
    /* Keep all your existing styles exactly as they are from student page */
    .staff-detail-container {
        padding: 20px;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Back Button */
    .back-button {
        margin-bottom: 20px;
    }

    .back-button a {
        color: #64748b;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
        width: fit-content;
    }

    .back-button a:hover {
        color: #2D3E50;
        transform: translateX(-5px);
    }

    /* Staff Header Card */
    .staff-header-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        border: 1px solid #e2e8f0;
        margin-bottom: 25px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        position: relative;
        overflow: hidden;
    }

    .staff-header-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #2D3E50, #8b5cf6);
    }

    .staff-profile-row {
        display: flex;
        gap: 30px;
        align-items: center;
    }

    @media (max-width: 768px) {
        .staff-profile-row {
            flex-direction: column;
            text-align: center;
        }
    }

    .avatar-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
        flex-shrink: 0;
    }

    .avatar-large {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2D3E50, #8b5cf6);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: bold;
        border: 4px solid white;
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
    }

    .avatar-large img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .avatar-badge {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: #10b981;
        color: white;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid white;
    }

    .staff-info-wrapper {
        flex: 1;
    }

    .staff-name-section {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .staff-name {
        font-size: 32px;
        font-weight: 700;
        color: #2D3E50;
        margin: 0;
    }

    .staff-id-badge {
        background: #f1f5f9;
        color: #64748b;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .staff-contact-info {
        display: flex;
        gap: 25px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        font-size: 14px;
    }

    .contact-item i {
        width: 16px;
        color: #94a3b8;
    }

    .staff-badges {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-verified {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-unverified {
        background: #fef3c7;
        color: #d97706;
    }

    .badge-role {
        background: #f3e8ff;
        color: #6d28d9;
    }

    .badge-role.instructor {
        background: #dcfce7;
        color: #065f46;
    }

    .badge-last {
        background: #dbeafe;
        color: #1e40af;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 12px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .btn-action-large {
        padding: 12px 24px;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .btn-edit {
        background: #8b5cf6;
        color: white;
    }

    .btn-edit:hover {
        background: #7c3aed;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
    }

    .btn-reset {
        background: #f59e0b;
        color: white;
    }

    .btn-reset:hover {
        background: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .btn-message {
        background: white;
        color: #2D3E50;
        border: 1px solid #e2e8f0;
    }

    .btn-message:hover {
        background: #f8fafc;
        border-color: #2D3E50;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .btn-delete:hover {
        background: #dc2626;
        color: white;
        border-color: #dc2626;
        transform: translateY(-2px);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-top: 30px;
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
        background: #f8fafc;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-icon.purple {
        background: #f3e8ff;
        color: #7e22ce;
    }

    .stat-icon.green {
        background: #dcfce7;
        color: #15803d;
    }

    .stat-icon.blue {
        background: #dbeafe;
        color: #1e40af;
    }

    .stat-icon.orange {
        background: #fed7aa;
        color: #9a3412;
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        display: block;
        font-size: 24px;
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

    /* Tabs */
    .tabs-container {
        background: white;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        margin-bottom: 25px;
    }

    .tabs {
        display: flex;
        gap: 5px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
        padding: 0 10px;
        overflow-x: auto;
    }

    .tab {
        padding: 16px 24px;
        background: none;
        border: none;
        color: #64748b;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        position: relative;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .tab:hover {
        color: #2D3E50;
    }

    .tab.active {
        color: #2D3E50;
    }

    .tab.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background: #2D3E50;
        border-radius: 2px 2px 0 0;
    }

    .tab-content {
        display: none;
        padding: 25px;
    }

    .tab-content.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Content Cards */
    .content-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        margin-bottom: 25px;
        overflow: hidden;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .card-title {
        font-size: 18px;
        font-weight: 600;
        color: #2D3E50;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .card-body {
        padding: 25px;
    }

    /* Courses Table */
    .table-responsive {
        overflow-x: auto;
    }

    .courses-table {
        width: 100%;
        border-collapse: collapse;
    }

    .courses-table th {
        text-align: left;
        padding: 15px 20px;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .courses-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .courses-table tr:hover td {
        background: #f8fafc;
    }

    .course-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .course-icon {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #2D3E50, #8b5cf6);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
    }

    .course-info h4 {
        font-size: 15px;
        font-weight: 600;
        color: #2D3E50;
        margin-bottom: 4px;
    }

    .course-info p {
        font-size: 12px;
        color: #64748b;
        margin: 0;
    }

    .progress-wrapper {
        min-width: 140px;
    }

    .progress-percentage {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: #64748b;
        margin-bottom: 6px;
    }

    .progress-bar-container {
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #2D3E50, #8b5cf6);
        border-radius: 4px;
        transition: width 0.5s ease;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-active {
        background: #dcfce7;
        color: #15803d;
    }

    .status-inactive {
        background: #fee2e2;
        color: #dc2626;
    }

    .status-draft {
        background: #f1f5f9;
        color: #64748b;
    }

    /* Activity Timeline */
    .activity-timeline {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .activity-item {
        display: flex;
        gap: 15px;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .activity-icon.purple {
        background: #f3e8ff;
        color: #7e22ce;
    }

    .activity-icon.green {
        background: #dcfce7;
        color: #15803d;
    }

    .activity-icon.blue {
        background: #dbeafe;
        color: #1e40af;
    }

    .activity-icon.orange {
        background: #fed7aa;
        color: #9a3412;
    }

    .activity-content {
        flex: 1;
    }

    .activity-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }

    .activity-title {
        font-weight: 600;
        color: #2D3E50;
    }

    .activity-time {
        font-size: 12px;
        color: #94a3b8;
    }

    .activity-description {
        font-size: 14px;
        color: #64748b;
        margin: 0;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
    }

    .info-item {
        padding: 15px;
        background: #f8fafc;
        border-radius: 10px;
    }

    .info-label {
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: block;
    }

    .info-value {
        font-size: 16px;
        font-weight: 600;
        color: #2D3E50;
    }

    .info-value small {
        font-size: 13px;
        font-weight: 400;
        color: #94a3b8;
        margin-left: 8px;
    }

    /* Empty States */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-state i {
        font-size: 48px;
        color: #cbd5e0;
        margin-bottom: 15px;
    }

    .empty-state h4 {
        color: #64748b;
        margin-bottom: 8px;
        font-size: 18px;
    }

    .empty-state p {
        color: #94a3b8;
        margin-bottom: 20px;
    }

    /* Admin Warning */
    .admin-warning {
        background: #fef2f2;
        border-left: 4px solid #dc2626;
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 13px;
        color: #991b1b;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .admin-warning i {
        font-size: 18px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .staff-detail-container {
            padding: 15px;
        }

        .staff-header-card {
            padding: 20px;
        }

        .staff-name {
            font-size: 24px;
        }

        .staff-contact-info {
            gap: 15px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-action-large {
            width: 100%;
        }

        .tabs {
            padding: 0;
        }

        .tab {
            padding: 12px 16px;
            font-size: 13px;
        }

        .tab i {
            display: none;
        }

        .card-header {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }

        .stats-grid {
            margin-top: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="staff-detail-container">
    
    <!-- Back Button -->
    <div class="back-button">
        <a href="{{ route('admin.staff.index') }}">
            <i class="fas fa-arrow-left"></i>
            Back to Staff
        </a>
    </div>

    <!-- Staff Header Card -->
    <div class="staff-header-card">
        <div class="staff-profile-row">
            <!-- Avatar -->
            <div class="avatar-wrapper">
                @if($staff->avatar && \Storage::disk('public')->exists($staff->avatar))
                    <img src="{{ Storage::url($staff->avatar) }}" alt="{{ $staff->name }}" class="avatar-large">
                @else
                    <div class="avatar-large">
                        {{ $staff->initials }}
                    </div>
                @endif
                @if($staff->email_verified_at)
                    <div class="avatar-badge" title="Email Verified">
                        <i class="fas fa-check"></i>
                    </div>
                @endif
            </div>

            <!-- Staff Info -->
            <div class="staff-info-wrapper">
                <div class="staff-name-section">
                    <h1 class="staff-name">{{ $staff->name }}</h1>
                    <span class="staff-id-badge">
                        ID: STF{{ str_pad($staff->id, 5, '0', STR_PAD_LEFT) }}
                    </span>
                </div>

                <div class="staff-contact-info">
                    <span class="contact-item">
                        <i class="fas fa-envelope"></i>
                        {{ $staff->email }}
                    </span>
                    <span class="contact-item">
                        <i class="fas fa-phone"></i>
                        {{ $staff->phone ?? 'No phone provided' }}
                    </span>
                    <span class="contact-item">
                        <i class="fas fa-calendar-alt"></i>
                        Joined {{ $staff->created_at->format('M d, Y') }}
                    </span>
                </div>

                <div class="staff-badges">
                    @if($staff->email_verified_at)
                        <span class="badge badge-verified">
                            <i class="fas fa-check-circle"></i>
                            Email Verified
                        </span>
                    @else
                        <span class="badge badge-unverified">
                            <i class="fas fa-clock"></i>
                            Email Unverified
                        </span>
                    @endif
                    
                    @foreach($staff->getRoleNames() as $role)
                        <span class="badge badge-role {{ $role }}">
                            <i class="fas fa-{{ $role == 'admin' ? 'shield-alt' : 'chalkboard-teacher' }}"></i>
                            {{ ucfirst($role) }}
                        </span>
                    @endforeach
                </div>

                <!-- Admin Warning (if editing last admin) -->
                @if($staff->hasRole('admin') && \App\Models\User::role('admin')->count() <= 1)
                    <div class="admin-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Warning:</strong> This is the last admin account. Be careful with modifications.
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('admin.staff.edit', $staff) }}" class="btn-action-large btn-edit">
                        <i class="fas fa-edit"></i>
                        Edit Profile
                    </a>
                    <button type="button" class="btn-action-large btn-reset reset-password-btn" 
                            data-staff-id="{{ $staff->id }}"
                            data-staff-name="{{ $staff->name }}">
                        <i class="fas fa-key"></i>
                        Reset Password
                    </button>
                    <button class="btn-action-large btn-message" onclick="sendEmail()">
                        <i class="fas fa-envelope"></i>
                        Send Message
                    </button>
                    <button class="btn-action-large btn-delete" onclick="confirmDeleteStaff({{ $staff->id }}, '{{ addslashes($staff->name) }}', '{{ $staff->roles->first()->name ?? '' }}')">
                        <i class="fas fa-trash"></i>
                        Delete Staff
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="stats-grid">
            @if($staff->hasRole('instructor'))
                <!-- Instructor Stats -->
                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $stats['total_courses'] ?? 0 }}</span>
                        <span class="stat-label">Total Courses</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-play-circle"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $stats['active_courses'] ?? 0 }}</span>
                        <span class="stat-label">Active Courses</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $stats['total_students'] ?? 0 }}</span>
                        <span class="stat-label">Total Students</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $stats['avg_rating'] ?? 0 }}</span>
                        <span class="stat-label">Avg Rating</span>
                    </div>
                </div>
            @else
                <!-- Admin Stats -->
                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $stats['total_students'] ?? 0 }}</span>
                        <span class="stat-label">Total Students</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $stats['total_courses'] ?? 0 }}</span>
                        <span class="stat-label">Total Courses</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $stats['total_enrollments'] ?? 0 }}</span>
                        <span class="stat-label">Enrollments</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $stats['total_instructors'] ?? 0 }}</span>
                        <span class="stat-label">Instructors</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="tabs-container">
        <div class="tabs">
            @if($staff->hasRole('instructor'))
                <button class="tab active" data-tab="courses">
                    <i class="fas fa-book-open"></i>
                    My Courses
                    @if($instructorCourses->count() > 0)
                        <span style="background: #2D3E50; color: white; padding: 2px 8px; border-radius: 12px; font-size: 11px; margin-left: 5px;">
                            {{ $instructorCourses->count() }}
                        </span>
                    @endif
                </button>
                <button class="tab" data-tab="students">
                    <i class="fas fa-users"></i>
                    My Students
                </button>
            @endif
            <button class="tab {{ !$staff->hasRole('instructor') ? 'active' : '' }}" data-tab="activity">
                <i class="fas fa-history"></i>
                Activity
            </button>
            <button class="tab" data-tab="profile">
                <i class="fas fa-user"></i>
                Profile Details
            </button>
            <button class="tab" data-tab="permissions">
                <i class="fas fa-shield-alt"></i>
                Permissions
            </button>
        </div>

        @if($staff->hasRole('instructor'))
            <!-- Tab Content: Courses -->
            <div class="tab-content active" id="courses-tab">
                <div class="content-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-book-open"></i>
                            Courses by {{ $staff->name }}
                        </h3>
                        <a href="{{ route('admin.courses.create') }}" class="btn-action-large btn-edit" style="padding: 10px 20px; font-size: 13px;">
                            <i class="fas fa-plus"></i>
                            Create Course
                        </a>
                    </div>
                    <div class="card-body">
                        @if($instructorCourses->count() > 0)
                            <div class="table-responsive">
                                <table class="courses-table">
                                    <thead>
                                        <tr>
                                            <th>Course</th>
                                            <th>Category</th>
                                            <th>Students</th>
                                            <th>Rating</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($instructorCourses as $course)
                                        <tr>
                                            <td>
                                                <div class="course-cell">
                                                    <div class="course-icon">
                                                        <i class="fas fa-graduation-cap"></i>
                                                    </div>
                                                    <div class="course-info">
                                                        <h4>{{ $course->title }}</h4>
                                                        <p>{{ Str::limit($course->short_description ?? 'No description', 50) }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span style="display: inline-block; padding: 4px 10px; background: #e0f2fe; color: #0369a1; border-radius: 20px; font-size: 11px;">
                                                    {{ $course->category->name ?? 'Uncategorized' }}
                                                </span>
                                            </td>
                                            <td style="font-weight: 600; color: #2D3E50;">
                                                {{ $course->total_students }}
                                            </td>
                                            <td>
                                                <span style="display: flex; align-items: center; gap: 5px;">
                                                    <i class="fas fa-star" style="color: #f59e0b;"></i>
                                                    {{ number_format($course->rating, 1) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="status-badge status-{{ $course->is_active ? 'active' : 'inactive' }}">
                                                    {{ $course->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                                @if($course->is_featured)
                                                    <span style="display: block; margin-top: 5px; font-size: 10px; color: #8b5cf6;">
                                                        <i class="fas fa-star"></i> Featured
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div style="display: flex; gap: 8px;">
                                                    <a href="{{ route('admin.courses.edit', $course) }}" 
                                                       class="btn-action-large" 
                                                       style="padding: 6px 12px; font-size: 12px; background: #f0f9ff; color: #0369a1; border: 1px solid #e0f2fe;">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('admin.courses.enrollments', $course) }}" 
                                                       class="btn-action-large" 
                                                       style="padding: 6px 12px; font-size: 12px; background: #f8fafc; color: #2D3E50; border: 1px solid #e2e8f0;">
                                                        <i class="fas fa-users"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-book-open"></i>
                                <h4>No Courses Yet</h4>
                                <p>This instructor hasn't created any courses yet.</p>
                                <a href="{{ route('admin.courses.create') }}" class="btn-action-large btn-edit" style="margin-top: 10px;">
                                    <i class="fas fa-plus"></i>
                                    Create First Course
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tab Content: My Students -->
            <div class="tab-content" id="students-tab">
                <div class="content-card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-users"></i>
                            Students Enrolled in My Courses
                        </h3>
                    </div>
                    <div class="card-body">
                        @php
                            $students = \App\Models\Enrollment::whereIn('course_id', $instructorCourses->pluck('id'))
                                ->with('user', 'course')
                                ->latest()
                                ->take(20)
                                ->get();
                        @endphp

                        @if($students->count() > 0)
                            <div class="table-responsive">
                                <table class="courses-table">
                                    <thead>
                                        <tr>
                                            <th>Student</th>
                                            <th>Course</th>
                                            <th>Enrolled</th>
                                            <th>Progress</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($students as $enrollment)
                                        <tr>
                                            <td>
                                                <div class="course-cell">
                                                    <div class="course-icon" style="background: linear-gradient(135deg, #2D3E50, #10b981);">
                                                        {{ $enrollment->user->initials }}
                                                    </div>
                                                    <div class="course-info">
                                                        <h4>{{ $enrollment->user->name }}</h4>
                                                        <p>{{ $enrollment->user->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="font-weight: 500; color: #2D3E50;">
                                                    {{ $enrollment->course->title }}
                                                </div>
                                            </td>
                                            <td>
                                                <div style="font-size: 13px; color: #64748b;">
                                                    {{ $enrollment->enrolled_at->format('M d, Y') }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="progress-wrapper">
                                                    <div class="progress-percentage">
                                                        <span>{{ $enrollment->progress_percentage }}%</span>
                                                    </div>
                                                    <div class="progress-bar-container">
                                                        <div class="progress-bar-fill" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="status-badge status-{{ $enrollment->status }}">
                                                    {{ $enrollment->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.students.show', $enrollment->user) }}" 
                                                   class="btn-action-large" 
                                                   style="padding: 6px 12px; font-size: 12px; background: #f8fafc; color: #2D3E50; border: 1px solid #e2e8f0;">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-users"></i>
                                <h4>No Students Yet</h4>
                                <p>No students are enrolled in this instructor's courses yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <!-- Tab Content: Activity -->
        <div class="tab-content {{ !$staff->hasRole('instructor') ? 'active' : '' }}" id="activity-tab">
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history"></i>
                        Recent Activity
                    </h3>
                </div>
                <div class="card-body">
                    @if($recentActivity->count() > 0)
                        <div class="activity-timeline">
                            @foreach($recentActivity as $activity)
                                <div class="activity-item">
                                    <div class="activity-icon {{ $activity['color'] }}">
                                        <i class="fas {{ $activity['icon'] }}"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-header">
                                            <span class="activity-title">{{ $activity['title'] }}</span>
                                            <span class="activity-time">{{ $activity['date']->diffForHumans() }}</span>
                                        </div>
                                        <p class="activity-description">{{ $activity['description'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-history"></i>
                            <h4>No Activity Yet</h4>
                            <p>Recent activity will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tab Content: Profile Details -->
        <div class="tab-content" id="profile-tab">
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i>
                        Profile Details
                    </h3>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Full Name</span>
                            <span class="info-value">{{ $staff->name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email Address</span>
                            <span class="info-value">{{ $staff->email }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Phone Number</span>
                            <span class="info-value">{{ $staff->phone ?? 'Not provided' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Role</span>
                            <span class="info-value">
                                @foreach($staff->roles as $role)
                                    {{ ucfirst($role->name) }}
                                @endforeach
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Account Created</span>
                            <span class="info-value">
                                {{ $staff->created_at->format('F d, Y') }}
                                <small>({{ $staff->created_at->diffForHumans() }})</small>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Last Updated</span>
                            <span class="info-value">
                                {{ $staff->updated_at->format('F d, Y') }}
                                <small>({{ $staff->updated_at->diffForHumans() }})</small>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email Verification</span>
                            <span class="info-value">
                                @if($staff->email_verified_at)
                                    <span style="color: #10b981;">
                                        <i class="fas fa-check-circle"></i> Verified on 
                                        {{ $staff->email_verified_at->format('M d, Y') }}
                                    </span>
                                @else
                                    <span style="color: #d97706;">
                                        <i class="fas fa-clock"></i> Not Verified
                                    </span>
                                @endif
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Account Status</span>
                            <span class="info-value">
                                @if($staff->email_verified_at)
                                    <span class="badge badge-verified">Active</span>
                                @else
                                    <span class="badge badge-unverified">Inactive</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    @if($staff->bio)
                        <div style="margin-top: 25px; padding-top: 25px; border-top: 1px solid #f1f5f9;">
                            <h4 style="font-size: 16px; color: #2D3E50; margin-bottom: 15px;">Bio</h4>
                            <p style="color: #4a5568; line-height: 1.6;">{{ $staff->bio }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tab Content: Permissions -->
        <div class="tab-content" id="permissions-tab">
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-shield-alt"></i>
                        Role & Permissions
                    </h3>
                    <span class="badge badge-role {{ $staff->roles->first()->name ?? '' }}" style="font-size: 14px; padding: 8px 20px;">
                        <i class="fas fa-{{ $staff->hasRole('admin') ? 'shield-alt' : 'chalkboard-teacher' }}"></i>
                        {{ $staff->hasRole('admin') ? 'Administrator' : 'Instructor' }}
                    </span>
                </div>
                <div class="card-body">
                    <div style="margin-bottom: 25px;">
                        <h4 style="font-size: 15px; color: #2D3E50; margin-bottom: 15px;">Assigned Permissions</h4>
                        <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                            @php
                                $permissions = $staff->getAllPermissions();
                            @endphp
                            @forelse($permissions as $permission)
                                <span style="display: inline-flex; align-items: center; gap: 5px; padding: 6px 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 30px; font-size: 12px; color: #2D3E50;">
                                    <i class="fas fa-check-circle" style="color: #10b981;"></i>
                                    {{ str_replace('_', ' ', ucwords($permission->name)) }}
                                </span>
                            @empty
                                <p style="color: #94a3b8;">No specific permissions assigned. Using role-based defaults.</p>
                            @endforelse
                        </div>
                    </div>

                    @if($staff->hasRole('admin'))
                        <div style="background: #f3e8ff; border-left: 4px solid #8b5cf6; padding: 15px; border-radius: 8px;">
                            <h4 style="color: #6d28d9; margin-bottom: 8px; font-size: 14px;">
                                <i class="fas fa-shield-alt"></i> Admin Privileges
                            </h4>
                            <p style="color: #4c1d95; font-size: 13px; margin: 0;">
                                Administrators have full system access including user management, course creation, analytics, and system settings.
                            </p>
                        </div>
                    @else
                        <div style="background: #dcfce7; border-left: 4px solid #10b981; padding: 15px; border-radius: 8px;">
                            <h4 style="color: #065f46; margin-bottom: 8px; font-size: 14px;">
                                <i class="fas fa-chalkboard-teacher"></i> Instructor Privileges
                            </h4>
                            <p style="color: #064e3b; font-size: 13px; margin: 0;">
                                Instructors can create and manage their own courses, track student progress, and view analytics for their courses.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Staff Form -->
<form id="delete-staff-form-{{ $staff->id }}" action="{{ route('admin.staff.destroy', $staff) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                this.classList.add('active');
                document.getElementById(`${tabId}-tab`).classList.add('active');
                
                // Save active tab to localStorage
                localStorage.setItem('activeStaffTab', tabId);
            });
        });
        
        // Restore active tab from localStorage
        const activeTab = localStorage.getItem('activeStaffTab');
        if (activeTab) {
            const tabToActivate = document.querySelector(`.tab[data-tab="${activeTab}"]`);
            if (tabToActivate) {
                tabToActivate.click();
            }
        }

        // Reset password buttons
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
    });

    // Send message button
    window.sendEmail = function() {
        const email = '{{ $staff->email }}';
        const staffName = '{{ addslashes($staff->name) }}';
        const adminName = '{{ addslashes(auth()->user()->name) }}';
        
        const subject = encodeURIComponent('Message from Shifra Training Center');
        const body = encodeURIComponent(
            `Dear ${staffName},\n\n` +
            `I hope this email finds you well.\n\n` +
            `\n\n` +
            `Best regards,\n` +
            `${adminName}\n` +
            `Shifra Training Center`
        );
        
        window.location.href = `mailto:${email}?subject=${subject}&body=${body}`;
    };

    // SWEETALERT: Delete staff confirmation
    window.confirmDeleteStaff = function(staffId, staffName, role) {
        let warning = '';
        if (role === 'admin') {
            warning = '<div style="background: #fee2e2; border-left: 4px solid #dc2626; padding: 12px; border-radius: 6px; margin-top: 15px; color: #991b1b; font-size: 13px;">' +
                      '<i class="fas fa-exclamation-triangle"></i> ' +
                      '<span style="margin-left: 5px;">This is an admin account. Make sure there is at least one other admin before deleting.</span>' +
                      '</div>';
        }

        Swal.fire({
            title: 'Delete Staff Member?',
            html: `<div style="text-align: left;">
                    <p style="margin-bottom: 15px;">Are you sure you want to delete <strong>${staffName}</strong>?</p>
                    <div style="background: #f8fafc; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                        <span style="display: inline-block; padding: 4px 12px; background: ${role === 'admin' ? '#f3e8ff' : '#dcfce7'}; color: ${role === 'admin' ? '#6d28d9' : '#065f46'}; border-radius: 30px; font-size: 11px;">
                            ${role}
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
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete permanently',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-staff-form-${staffId}`).submit();
            }
        });
    };
</script>
@endsection