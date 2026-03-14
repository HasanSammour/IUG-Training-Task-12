@extends('layouts.app')

@section('title', 'Profile - Shifra')
@section('body-class', 'profile-page')

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
    }

    .profile-page {
        background-color: var(--bg-light);
        min-height: 100vh;
        width: 100%;
    }

    /* Full width container */
    .profile-container {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 40px;
        padding-bottom: 100px;
    }

    /* Ensure all sections take full width */
    .profile-header-card,
    .stats-grid,
    .content-grid,
    .card {
        width: 100%;
    }

    /* Profile Header Card */
    .profile-header-card {
        background: linear-gradient(135deg, var(--primary-navy) 0%, #1a252f 100%);
        border-radius: 24px;
        padding: 35px 40px;
        margin-bottom: 30px;
        color: white;
        position: relative;
        overflow: hidden;
        width: 100%;
        box-shadow: 0 10px 30px rgba(45, 62, 80, 0.15);
    }

    .profile-header-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .profile-header-content {
        display: flex;
        align-items: center;
        gap: 35px;
        position: relative;
        z-index: 2;
        flex-wrap: wrap;
    }

    .avatar-wrapper {
        position: relative;
        flex-shrink: 0;
    }

    .profile-avatar {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        border: 4px solid rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 52px;
        font-weight: bold;
        color: white;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-avatar:hover {
        transform: scale(1.05);
        border-color: white;
        box-shadow: 0 12px 30px rgba(0,0,0,0.3);
    }

    .avatar-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
        color: white;
        text-align: center;
        padding: 15px 8px 8px;
        font-size: 13px;
        border-radius: 0 0 65px 65px;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .avatar-wrapper:hover .avatar-overlay {
        opacity: 1;
    }

    .profile-info {
        flex: 1;
    }

    .profile-info h1 {
        font-size: 36px;
        margin-bottom: 8px;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .profile-info .email {
        font-size: 16px;
        opacity: 0.9;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .role-badge {
        display: inline-block;
        padding: 5px 18px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .role-badge.admin {
        background: linear-gradient(135deg, #1e40af, #3730a3);
        color: white;
    }

    .role-badge.instructor {
        background: linear-gradient(135deg, #065f46, #047857);
        color: white;
    }

    .role-badge.student {
        background: linear-gradient(135deg, #7c3aed, #6d28d9);
        color: white;
    }

    .profile-meta {
        display: flex;
        gap: 20px;
        margin-top: 15px;
        flex-wrap: wrap;
    }

    .profile-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        background: rgba(255,255,255,0.12);
        padding: 8px 18px;
        border-radius: 40px;
        backdrop-filter: blur(5px);
    }

    .edit-profile-btn {
        padding: 12px 35px;
        background: white;
        color: var(--primary-navy);
        border: none;
        border-radius: 40px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        white-space: nowrap;
    }

    .edit-profile-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }

    /* Stats Grid - grid with 4 columns */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin-bottom: 35px;
        width: 100%;
    }

    @media (max-width: 1100px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .stat-card {
        background: var(--white);
        border-radius: 20px;
        padding: 28px 20px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        border-color: var(--primary-navy);
    }

    .stat-icon {
        width: 65px;
        height: 65px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        font-size: 28px;
    }

    .stat-icon.blue {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
    }

    .stat-icon.green {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #15803d;
    }

    .stat-icon.purple {
        background: linear-gradient(135deg, #f3e8ff, #e9d5ff);
        color: #7c3aed;
    }

    .stat-icon.orange {
        background: linear-gradient(135deg, #fed7aa, #fde68a);
        color: #b45309;
    }

    .stat-value {
        display: block;
        font-size: 34px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 6px;
        line-height: 1.2;
    }

    .stat-label {
        font-size: 14px;
        color: var(--text-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        width: 100%;
    }

    @media (max-width: 992px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Cards */
    .card {
        background: var(--white);
        border-radius: 24px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        margin-bottom: 30px;
        width: 100%;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }

    .card-header {
        padding: 22px 25px;
        border-bottom: 1px solid var(--border-color);
        background: linear-gradient(to right, #fafafa, #ffffff);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h3 {
        font-size: 18px;
        color: var(--primary-navy);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .card-header h3 i {
        color: var(--secondary-blue);
    }

    .card-body {
        padding: 25px;
    }

    .view-all {
        color: var(--secondary-blue);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.3s ease;
    }

    .view-all:hover {
        color: var(--primary-navy);
        transform: translateX(3px);
    }

    /* Activities List */
    .activities-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 18px;
        padding: 18px;
        background: #f8fafc;
        border-radius: 16px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .activity-item:hover {
        background: #f1f5f9;
        border-color: var(--border-color);
        transform: translateX(5px);
    }

    .activity-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .activity-icon.enrollment {
        background: #dbeafe;
        color: #1e40af;
    }

    .activity-icon.completion {
        background: #dcfce7;
        color: #15803d;
    }

    .activity-icon.notification {
        background: #fef3c7;
        color: #b45309;
    }

    .activity-icon.message {
        background: #e0f2fe;
        color: #0369a1;
    }

    .activity-content {
        flex: 1;
    }

    .activity-content h4 {
        font-size: 15px;
        color: var(--primary-navy);
        margin-bottom: 5px;
        font-weight: 600;
    }

    .activity-content p {
        font-size: 13px;
        color: var(--text-gray);
        margin-bottom: 6px;
        line-height: 1.5;
    }

    .activity-time {
        font-size: 11px;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Course Grid */
    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }

    .course-card {
        background: white;
        border-radius: 18px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
    }

    .course-image {
        height: 150px;
        background-size: cover;
        background-position: center;
    }

    .course-body {
        padding: 18px;
    }

    .course-body h4 {
        font-size: 16px;
        color: var(--primary-navy);
        margin-bottom: 10px;
        font-weight: 600;
        line-height: 1.4;
    }

    .course-progress {
        height: 6px;
        background: #e2e8f0;
        border-radius: 3px;
        overflow: hidden;
        margin: 12px 0;
    }

    .course-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-navy), var(--secondary-blue));
        border-radius: 3px;
        transition: width 0.5s ease;
    }

    .course-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }

    .course-price {
        font-weight: 700;
        color: var(--primary-navy);
        font-size: 15px;
    }

    .btn-continue {
        padding: 8px 16px;
        background: #f1f5f9;
        color: var(--primary-navy);
        border: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-continue:hover {
        background: var(--primary-navy);
        color: white;
        transform: translateY(-2px);
    }

    /* Student Row */
    .student-row {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 16px;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .student-row:last-child {
        border-bottom: none;
    }

    .student-row:hover {
        background: #f8fafc;
    }

    .student-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-navy), var(--secondary-blue));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
        flex-shrink: 0;
    }

    .student-info {
        flex: 1;
    }

    .student-info h4 {
        font-size: 15px;
        color: var(--primary-navy);
        margin-bottom: 4px;
        font-weight: 600;
    }

    .student-info p {
        font-size: 12px;
        color: var(--text-gray);
    }

    .student-course {
        font-size: 12px;
        color: var(--text-light);
        padding: 4px 12px;
        background: #f1f5f9;
        border-radius: 20px;
        white-space: nowrap;
    }

    .btn-message {
        padding: 8px 14px;
        background: #f1f5f9;
        border: none;
        border-radius: 8px;
        color: var(--text-gray);
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 500;
        white-space: nowrap;
    }

    .btn-message:hover {
        background: var(--secondary-blue);
        color: white;
    }

    /* Menu Items */
    .settings-menu {
        margin-top: 25px;
    }

    .menu-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 18px 22px;
        background: var(--white);
        border: 1px solid var(--border-color);
        border-radius: 14px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
    }

    .menu-item:hover {
        background: #f8fafc;
        transform: translateX(5px);
        border-color: var(--primary-navy);
    }

    .menu-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .menu-left i {
        font-size: 18px;
        color: var(--text-gray);
        width: 24px;
    }

    .menu-left span {
        font-size: 15px;
        color: var(--primary-navy);
        font-weight: 500;
    }

    .menu-item.logout .menu-left i,
    .menu-item.logout .menu-left span {
        color: var(--accent-red);
    }

    /* Badge for unread count */
    .badge {
        background: #ef4444;
        color: white;
        padding: 3px 10px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        margin-left: 8px;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: var(--text-light);
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
    }

    /* Modal */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.6);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        backdrop-filter: blur(5px);
    }

    .modal-content {
        background: var(--white);
        border-radius: 30px;
        padding: 35px;
        max-width: 450px;
        width: 90%;
        box-shadow: 0 25px 50px rgba(0,0,0,0.2);
    }

    .modal-content h3 {
        font-size: 24px;
        color: var(--primary-navy);
        margin-bottom: 20px;
        font-weight: 700;
    }

    .avatar-preview {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        margin: 0 auto 25px;
        border: 5px solid var(--border-color);
        background-size: cover;
        background-position: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .modal-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .modal-btn {
        padding: 14px 35px;
        border: none;
        border-radius: 40px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .modal-btn.primary {
        background: var(--primary-navy);
        color: white;
    }

    .modal-btn.primary:hover {
        background: #1a252f;
        transform: translateY(-2px);
    }

    .modal-btn.secondary {
        background: #f1f5f9;
        color: var(--text-gray);
    }

    .modal-btn.secondary:hover {
        background: #e2e8f0;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .profile-container {
            padding: 25px 30px;
        }
        
        .profile-header-card {
            padding: 30px;
        }
    }

    @media (max-width: 992px) {
        .profile-header-content {
            flex-direction: column;
            text-align: center;
        }
        
        .profile-meta {
            justify-content: center;
        }
        
        .edit-profile-btn {
            width: 100%;
            justify-content: center;
        }
        
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .student-row {
            flex-wrap: wrap;
        }
        
        .student-course {
            width: 100%;
            text-align: center;
        }
        
        .btn-message {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .profile-container {
            padding: 20px;
        }
        
        .profile-header-card {
            padding: 25px;
        }
        
        .profile-info h1 {
            font-size: 28px;
        }
        
        .stats-grid {
            gap: 15px;
        }
        
        .stat-card {
            padding: 20px;
        }
        
        .stat-icon {
            width: 55px;
            height: 55px;
            font-size: 24px;
        }
        
        .stat-value {
            font-size: 28px;
        }
        
        .courses-grid {
            grid-template-columns: 1fr;
        }
        
        .student-row {
            flex-direction: column;
            text-align: center;
        }
        
        .student-avatar {
            margin: 0 auto;
        }
    }

    @media (max-width: 480px) {
        .profile-container {
            padding: 15px;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .profile-meta-item {
            width: 100%;
            justify-content: center;
        }
        
        .menu-item {
            padding: 15px;
        }
        
        .modal-content {
            padding: 25px;
        }
        
        .modal-actions {
            flex-direction: column;
        }
        
        .avatar-preview {
            width: 150px;
            height: 150px;
        }
    }
</style>
@endsection

@section('content')
<div class="profile-container">
    
    <!-- Profile Header Card -->
    <div class="profile-header-card">
        <div class="profile-header-content">
            <div class="avatar-wrapper" onclick="document.getElementById('avatarInput').click()">
                <div class="profile-avatar">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}">
                    @else
                        {{ $user->initials }}
                    @endif
                </div>
                <div class="avatar-overlay">
                    <i class="fas fa-camera"></i> Change Photo
                </div>
            </div>
            
            <div class="profile-info">
                <h1>{{ $user->name }}</h1>
                <div class="email">
                    <i class="fas fa-envelope"></i> {{ $user->email }}
                    @if($user->hasRole('admin'))
                        <span class="role-badge admin">Admin</span>
                    @elseif($user->hasRole('instructor'))
                        <span class="role-badge instructor">Instructor</span>
                    @else
                        <span class="role-badge student">Student</span>
                    @endif
                </div>
                
                <div class="profile-meta">
                    @if($user->phone)
                        <span class="profile-meta-item">
                            <i class="fas fa-phone"></i> {{ $user->phone }}
                        </span>
                    @endif
                    @if($user->company)
                        <span class="profile-meta-item">
                            <i class="fas fa-building"></i> {{ $user->company }}
                        </span>
                    @endif
                    @if($user->job_title)
                        <span class="profile-meta-item">
                            <i class="fas fa-briefcase"></i> {{ $user->job_title }}
                        </span>
                    @endif
                </div>
            </div>
            
            <a href="{{ route('profile.settings') }}" class="edit-profile-btn">
                <i class="fas fa-cog"></i> Settings
            </a>
        </div>
    </div>

    <!-- Avatar Upload Form -->
    <form id="avatarForm" action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" style="display: none;">
        @csrf
        <input type="file" name="avatar" id="avatarInput" accept="image/*">
    </form>

    <!-- Stats Grid - Role Based -->
    <div class="stats-grid">
        @if($user->hasRole('admin'))
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-book"></i>
                </div>
                <span class="stat-value">{{ $totalCourses }}</span>
                <span class="stat-label">Total Courses</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-users"></i>
                </div>
                <span class="stat-value">{{ $totalStudents }}</span>
                <span class="stat-label">Students</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <span class="stat-value">{{ $totalInstructors }}</span>
                <span class="stat-label">Instructors</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <span class="stat-value">{{ $totalEnrollments }}</span>
                <span class="stat-label">Enrollments</span>
            </div>
            
        @elseif($user->hasRole('instructor'))
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-book"></i>
                </div>
                <span class="stat-value">{{ $courses->count() }}</span>
                <span class="stat-label">My Courses</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-users"></i>
                </div>
                <span class="stat-value">{{ $totalStudents }}</span>
                <span class="stat-label">Students</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-star"></i>
                </div>
                <span class="stat-value">{{ $averageRating }}</span>
                <span class="stat-label">Avg Rating</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <span class="stat-value">${{ number_format($totalRevenue, 0) }}</span>
                <span class="stat-label">Revenue</span>
            </div>
            
        @else {{-- Student --}}
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-book-open"></i>
                </div>
                <span class="stat-value">{{ $totalCourses }}</span>
                <span class="stat-label">Enrolled</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <span class="stat-value">{{ $completedCourses }}</span>
                <span class="stat-label">Completed</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-clock"></i>
                </div>
                <span class="stat-value">{{ $learningPath->progress_percentage ?? 0 }}%</span>
                <span class="stat-label">Path Progress</span>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <span class="stat-value">${{ number_format($totalSpent, 0) }}</span>
                <span class="stat-label">Total Spent</span>
            </div>
        @endif
    </div>

    <!-- Main Content Grid -->
    <div class="content-grid">
        <!-- Left Column - Activities & Courses -->
        <div>
            <!-- Recent Activities -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-history"></i> Recent Activities</h3>
                    <span class="badge">{{ count($recentActivities) }} items</span>
                </div>
                <div class="card-body">
                    @if(!empty($recentActivities))
                        <div class="activities-list">
                            @foreach($recentActivities as $activity)
                                <div class="activity-item">
                                    <div class="activity-icon {{ $activity['type'] }}">
                                        <i class="fas fa-{{ $activity['icon'] }}"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h4>{{ $activity['title'] }}</h4>
                                        <p>{{ $activity['description'] }}</p>
                                        <span class="activity-time">
                                            <i class="fas fa-clock"></i> {{ $activity['time'] }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-history"></i>
                            <p>No recent activities</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Role-specific content -->
            @if($user->hasRole('admin'))
                <!-- Recent Enrollments for Admin -->
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-user-plus"></i> Recent Enrollments</h3>
                        <a href="{{ route('admin.enrollments.index') }}" class="view-all">View All →</a>
                    </div>
                    <div class="card-body">
                        @foreach($recentEnrollments as $enrollment)
                            <div class="student-row">
                                <div class="student-avatar">
                                    {{ $enrollment->user->initials }}
                                </div>
                                <div class="student-info">
                                    <h4>{{ $enrollment->user->name }}</h4>
                                    <p>{{ $enrollment->user->email }}</p>
                                </div>
                                <div class="student-course">
                                    {{ Str::limit($enrollment->course->title, 25) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            @elseif($user->hasRole('instructor'))
                <!-- My Courses for Instructor -->
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-book"></i> My Courses</h3>
                        <a href="{{ route('instructor.courses') }}" class="view-all">View All →</a>
                    </div>
                    <div class="card-body">
                        <div class="courses-grid">
                            @foreach($courses->take(3) as $course)
                                <div class="course-card">
                                    <div class="course-image" style="background-image: url('{{ $course->image_url }}')"></div>
                                    <div class="course-body">
                                        <h4>{{ Str::limit($course->title, 25) }}</h4>
                                        <div>{{ $course->enrollments_count }} students</div>
                                        <div class="course-footer">
                                            <span class="course-price">${{ number_format($course->price, 0) }}</span>
                                            <a href="{{ route('instructor.course-students', $course) }}" class="btn-continue">
                                                <i class="fas fa-users"></i> View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Recent Students for Instructor -->
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-user-graduate"></i> Recent Students</h3>
                    </div>
                    <div class="card-body">
                        @foreach($recentStudents as $enrollment)
                            <div class="student-row">
                                <div class="student-avatar">
                                    {{ $enrollment->user->initials }}
                                </div>
                                <div class="student-info">
                                    <h4>{{ $enrollment->user->name }}</h4>
                                    <p>{{ $enrollment->user->email }}</p>
                                </div>
                                <a href="{{ route('messages.conversation', $enrollment->user->id) }}" class="btn-message">
                                    <i class="fas fa-envelope"></i> Message
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

            @else {{-- Student --}}
                <!-- Current Courses for Student -->
                @if($enrollments->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-play-circle"></i> Continue Learning</h3>
                            <a href="{{ route('courses.my-courses') }}" class="view-all">View All →</a>
                        </div>
                        <div class="card-body">
                            <div class="courses-grid">
                                @foreach($enrollments as $enrollment)
                                    <div class="course-card">
                                        <div class="course-image" style="background-image: url('{{ $enrollment->course->image_url }}')"></div>
                                        <div class="course-body">
                                            <h4>{{ Str::limit($enrollment->course->title, 25) }}</h4>
                                            <div class="course-progress">
                                                <div class="course-progress-fill" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                            </div>
                                            <div class="course-footer">
                                                <span class="course-price">{{ $enrollment->progress_percentage }}%</span>
                                                <a href="{{ route('courses.progress', $enrollment) }}" class="btn-continue">
                                                    Continue <i class="fas fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Learning Path for Student -->
                @if($learningPath)
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-route"></i> My Learning Path</h3>
                            <a href="{{ route('learning-path.index') }}" class="view-all">View Path →</a>
                        </div>
                        <div class="card-body">
                            <h4 style="margin-bottom: 15px; color: var(--primary-navy);">{{ $learningPath->title }}</h4>
                            <div class="course-progress" style="height: 8px;">
                                <div class="course-progress-fill" style="width: {{ $learningPath->progress_percentage }}%"></div>
                            </div>
                            <p style="text-align: right; margin-top: 12px; color: var(--text-gray); font-size: 14px;">
                                {{ $learningPath->progress_percentage }}% Complete
                            </p>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <!-- Right Column - Quick Actions & Settings -->
        <div>
            <!-- Unread Messages Card -->
            @if($unreadMessages > 0)
                <div class="card" style="border-left: 4px solid var(--secondary-blue);">
                    <div class="card-body" style="display: flex; align-items: center; gap: 18px;">
                        <div style="width: 55px; height: 55px; background: #dbeafe; border-radius: 16px; display: flex; align-items: center; justify-content: center; color: #1e40af; font-size: 24px;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div style="flex: 1;">
                            <h4 style="margin-bottom: 5px; font-size: 16px;">{{ $unreadMessages }} Unread Message{{ $unreadMessages > 1 ? 's' : '' }}</h4>
                            <p style="color: var(--text-gray); font-size: 13px;">You have new messages waiting</p>
                        </div>
                        <a href="{{ route('messages.inbox') }}" class="btn-continue" style="padding: 10px 20px;">
                            View <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @endif

            <!-- Quick Actions Menu -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                </div>
                <div class="card-body" style="padding: 0;">
                    @if($user->hasRole('admin'))
                        <a href="{{ route('admin.courses.create') }}" class="menu-item">
                            <div class="menu-left">
                                <i class="fas fa-plus-circle"></i>
                                <span>Create New Course</span>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('admin.students.index') }}" class="menu-item">
                            <div class="menu-left">
                                <i class="fas fa-users"></i>
                                <span>Manage Students</span>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('admin.analytics.index') }}" class="menu-item">
                            <div class="menu-left">
                                <i class="fas fa-chart-line"></i>
                                <span>View Analytics</span>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        
                    @elseif($user->hasRole('instructor'))
                        <a href="{{ route('instructor.courses.create') }}" class="menu-item">
                            <div class="menu-left">
                                <i class="fas fa-plus-circle"></i>
                                <span>Create New Course</span>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('instructor.courses') }}" class="menu-item">
                            <div class="menu-left">
                                <i class="fas fa-book"></i>
                                <span>My Courses</span>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('messages.inbox') }}" class="menu-item">
                            <div class="menu-left">
                                <i class="fas fa-envelope"></i>
                                <span>Messages</span>
                                @if($unreadMessages > 0)
                                    <span class="badge">{{ $unreadMessages }}</span>
                                @endif
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        
                    @else {{-- Student --}}
                        <a href="{{ route('courses.public') }}" class="menu-item">
                            <div class="menu-left">
                                <i class="fas fa-search"></i>
                                <span>Browse Courses</span>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('learning-path.index') }}" class="menu-item">
                            <div class="menu-left">
                                <i class="fas fa-route"></i>
                                <span>My Learning Path</span>
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('messages.inbox') }}" class="menu-item">
                            <div class="menu-left">
                                <i class="fas fa-envelope"></i>
                                <span>Messages</span>
                                @if($unreadMessages > 0)
                                    <span class="badge">{{ $unreadMessages }}</span>
                                @endif
                            </div>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Settings Menu -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-cog"></i> Settings</h3>
                </div>
                <div class="card-body" style="padding: 0;">
                    <a href="{{ route('profile.settings') }}" class="menu-item">
                        <div class="menu-left">
                            <i class="fas fa-sliders-h"></i>
                            <span>App Settings</span>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <div class="menu-item logout" onclick="logoutUser()">
                        <div class="menu-left">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </div>
                        <i class="fas fa-chevron-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Avatar Preview Modal -->
<div class="modal-overlay" id="avatarModal">
    <div class="modal-content">
        <h3>Preview New Avatar</h3>
        <div class="avatar-preview" id="avatarPreview"></div>
        <div class="modal-actions">
            <button class="modal-btn primary" onclick="uploadAvatar()">Upload</button>
            <button class="modal-btn secondary" onclick="closeAvatarModal()">Cancel</button>
        </div>
    </div>
</div>

<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endsection

@section('scripts')
<script>
    // Avatar upload handling
    document.getElementById('avatarInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').style.backgroundImage = `url(${e.target.result})`;
                document.getElementById('avatarModal').style.display = 'flex';
            };
            reader.readAsDataURL(file);
        }
    });

    function uploadAvatar() {
        document.getElementById('avatarForm').submit();
    }

    function closeAvatarModal() {
        document.getElementById('avatarModal').style.display = 'none';
        document.getElementById('avatarInput').value = '';
    }

    // Logout function
    function logoutUser() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out of your account",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2d3e50',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, logout!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }

    // Progress bar animations
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.course-progress-fill').forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.transition = 'width 1s ease';
                bar.style.width = width;
            }, 300);
        });
    });
</script>
@endsection