@extends('layouts.app')

@section('title', 'My Wishlist - Shifra')
@section('body-class', 'wishlist-page')

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

    .wishlist-page {
        background-color: var(--bg-light);
        min-height: 100vh;
    }

    .wishlist-container {
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
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-left h1 {
        font-size: 36px;
        font-weight: 700;
        color: var(--primary-navy);
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
    }

    .header-left h1 i {
        color: var(--danger-red);
        background: rgba(239, 68, 68, 0.1);
        padding: 12px;
        border-radius: 16px;
    }

    .header-left p {
        color: var(--text-gray);
        font-size: 16px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--text-gray);
        text-decoration: none;
        padding: 12px 24px;
        border-radius: 40px;
        border: 2px solid var(--border-color);
        background: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .back-link:hover {
        border-color: var(--primary-navy);
        color: var(--primary-navy);
        transform: translateX(-5px);
        box-shadow: var(--shadow-md);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 35px;
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
        border-radius: 20px;
        padding: 25px;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 18px;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-navy);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .stat-icon.red {
        background: #fee2e2;
        color: var(--danger-red);
    }

    .stat-icon.yellow {
        background: #fef3c7;
        color: var(--warning-orange);
    }

    .stat-icon.blue {
        background: #dbeafe;
        color: var(--secondary-blue);
    }

    .stat-icon.green {
        background: #dcfce7;
        color: var(--success-green);
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        display: block;
        font-size: 32px;
        font-weight: 700;
        color: var(--primary-navy);
        line-height: 1.2;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 13px;
        color: var(--text-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Filter Tabs */
    .filter-section {
        background: white;
        border-radius: 60px;
        padding: 10px;
        border: 1px solid var(--border-color);
        display: inline-flex;
        margin-bottom: 35px;
        box-shadow: var(--shadow-sm);
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 12px 28px;
        border-radius: 40px;
        background: transparent;
        color: var(--text-gray);
        border: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .filter-tab i {
        font-size: 16px;
    }

    .filter-tab.active {
        background: var(--primary-navy);
        color: white;
        box-shadow: var(--shadow-md);
    }

    .filter-tab .count {
        background: rgba(255,255,255,0.2);
        padding: 2px 10px;
        border-radius: 30px;
        font-size: 12px;
        margin-left: 5px;
    }

    .filter-tab:not(.active) .count {
        background: #e2e8f0;
        color: var(--text-gray);
    }

    /* Wishlist Grid */
    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
        margin-bottom: 50px;
    }

    @media (max-width: 768px) {
        .wishlist-grid {
            grid-template-columns: 1fr;
        }
    }

    .wishlist-card {
        background: white;
        border-radius: 24px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-md);
        display: flex;
        flex-direction: column;
        position: relative;
        height: 100%;
    }

    .wishlist-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
        border-color: var(--primary-navy);
    }

    .card-image {
        position: relative;
        height: 180px;
        overflow: hidden;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .wishlist-card:hover .card-image img {
        transform: scale(1.05);
    }

    /* Priority Badge */
    .priority-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
        color: white;
        box-shadow: var(--shadow-md);
        z-index: 2;
    }

    .priority-badge.priority-1 {
        background: linear-gradient(135deg, #94a3b8, #64748b);
    }

    .priority-badge.priority-2 {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
    }

    .priority-badge.priority-3 {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .priority-badge.priority-4 {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    /* Reminder Badge */
    .reminder-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: var(--shadow-md);
        z-index: 2;
    }

    .reminder-badge.normal {
        background: #fef3c7;
        color: #92400e;
    }

    .reminder-badge.due {
        background: #fee2e2;
        color: #b91c1c;
    }

    .reminder-badge i {
        font-size: 12px;
    }

    /* Card Content */
    .card-content {
        padding: 20px;
        flex: 1;
    }

    .course-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 8px;
        line-height: 1.4;
    }

    .instructor {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: var(--text-gray);
        margin-bottom: 12px;
    }

    .instructor i {
        color: var(--secondary-blue);
    }

    .instructor strong {
        color: var(--primary-navy);
    }

    /* Course Stats Mini */
    .course-stats-mini {
        display: flex;
        gap: 10px;
        padding: 10px;
        background: #f8fafc;
        border-radius: 12px;
        margin-bottom: 15px;
    }

    .stat-mini {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        font-size: 11px;
    }

    .stat-mini i {
        color: var(--secondary-blue);
        font-size: 14px;
        margin-bottom: 2px;
    }

    .stat-mini span {
        font-size: 14px;
        font-weight: 700;
        color: var(--primary-navy);
        line-height: 1.2;
    }

    .stat-mini small {
        color: var(--text-gray);
        text-transform: uppercase;
    }

    .price-section {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .current-price {
        font-size: 20px;
        font-weight: 700;
        color: var(--primary-navy);
    }

    .original-price {
        font-size: 14px;
        color: var(--text-light);
        text-decoration: line-through;
    }

    .free-badge {
        background: #dcfce7;
        color: #15803d;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Priority Selector */
    .priority-selector {
        margin-bottom: 15px;
    }

    .priority-label {
        display: block;
        font-size: 11px;
        font-weight: 600;
        color: var(--text-gray);
        margin-bottom: 6px;
        text-transform: uppercase;
    }

    .priority-select {
        width: 100%;
        padding: 10px 12px;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        background: white;
        color: var(--text-dark);
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 35px;
    }

    .priority-select:focus {
        outline: none;
        border-color: var(--primary-navy);
    }

    /* Card Actions */
    .card-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 8px;
        padding: 20px;
        background: #f8fafc;
        border-top: 1px solid var(--border-color);
    }

    .btn {
        padding: 10px;
        border-radius: 10px;
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
        border: none;
    }

    .btn-primary {
        background: var(--primary-navy);
        color: white;
    }

    .btn-primary:hover {
        background: #1a252f;
        transform: translateY(-2px);
    }

    .btn-success {
        background: var(--success-green);
        color: white;
    }

    .btn-success:hover {
        background: #0f9e6a;
        transform: translateY(-2px);
    }

    .btn-outline {
        background: white;
        color: var(--text-gray);
        border: 1px solid var(--border-color);
    }

    .btn-outline:hover {
        background: #f1f5f9;
        border-color: var(--primary-navy);
        color: var(--primary-navy);
    }

    .btn-danger {
        background: #fee2e2;
        color: var(--danger-red);
    }

    .btn-danger:hover {
        background: #fecaca;
    }

    .btn-reminder {
        background: #fef3c7;
        color: #92400e;
    }

    .btn-reminder:hover {
        background: #fde68a;
    }

    .btn-reminder.active {
        background: #f59e0b;
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 30px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-lg);
    }

    .empty-icon {
        font-size: 70px;
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
        font-size: 15px;
        margin-bottom: 25px;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-browse {
        background: var(--primary-navy);
        color: white;
        padding: 12px 30px;
        border-radius: 40px;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-browse:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(5px);
    }

    .modal-content {
        background: white;
        border-radius: 30px;
        padding: 35px;
        max-width: 450px;
        width: 90%;
        box-shadow: var(--shadow-xl);
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from {
            transform: translateY(-30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .modal-header h3 {
        font-size: 22px;
        color: var(--primary-navy);
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-header h3 i {
        color: var(--warning-orange);
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 28px;
        cursor: pointer;
        color: var(--text-light);
        transition: color 0.3s ease;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .close-btn:hover {
        background: #f1f5f9;
        color: var(--primary-navy);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-navy);
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    .modal-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 25px;
    }

    .btn-modal-primary {
        padding: 12px 25px;
        background: var(--primary-navy);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-modal-primary:hover {
        background: #1a252f;
        transform: translateY(-2px);
    }

    .btn-modal-secondary {
        padding: 12px 25px;
        background: #f1f5f9;
        color: var(--text-gray);
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-modal-secondary:hover {
        background: #e2e8f0;
    }

    .btn-clear-reminder {
        width: 100%;
        padding: 12px;
        margin-top: 15px;
        background: #fee2e2;
        color: #b91c1c;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-clear-reminder:hover {
        background: #fecaca;
    }

    /* Toast Notification */
    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        border-radius: 16px;
        padding: 15px 20px;
        box-shadow: var(--shadow-xl);
        display: flex;
        align-items: center;
        gap: 15px;
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
        width: 32px;
        height: 32px;
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
        font-size: 14px;
    }

    .toast-message {
        font-size: 12px;
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
        gap: 8px;
        margin-top: 30px;
    }

    .page-link {
        min-width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        border: 2px solid var(--border-color);
        background: white;
        color: var(--text-gray);
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background: var(--primary-navy);
        color: white;
        border-color: var(--primary-navy);
    }

    .page-link.active {
        background: var(--primary-navy);
        color: white;
        border-color: var(--primary-navy);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .wishlist-container {
            padding: 20px 15px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .filter-section {
            width: 100%;
            overflow-x: auto;
            padding: 8px;
        }

        .filter-tab {
            padding: 8px 16px;
            font-size: 13px;
        }

        .card-actions {
            grid-template-columns: 1fr;
        }

        .modal-actions {
            flex-direction: column;
        }

        .btn-modal-primary,
        .btn-modal-secondary {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="wishlist-container">
    <!-- Toast Notification -->
    <div class="toast-notification" id="toastNotification">
        <div class="toast-icon">
            <i class="fas fa-check"></i>
        </div>
        <div class="toast-content">
            <div class="toast-title" id="toastTitle">Success</div>
            <div class="toast-message" id="toastMessage">Action completed successfully</div>
        </div>
        <button class="toast-close" onclick="hideToast()">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Header -->
    <div class="page-header">
        <div class="header-left">
            <h1>
                <i class="fas fa-heart"></i>
                My Wishlist
            </h1>
            <p>Save courses you're interested in and set reminders</p>
        </div>
        <a href="{{ route('courses.public') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Browse All Courses
        </a>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon red">
                <i class="fas fa-heart"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['total'] }}</span>
                <span class="stat-label">Saved Courses</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['high_priority'] }}</span>
                <span class="stat-label">High Priority</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['with_reminders'] }}</span>
                <span class="stat-label">With Reminders</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-bell"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['due_reminders'] }}</span>
                <span class="stat-label">Due Soon</span>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-section">
        <button class="filter-tab active" onclick="filterWishlist('all', this)">
            <i class="fas fa-th-large"></i>
            All Items
            <span class="count">{{ $stats['total'] }}</span>
        </button>
        <button class="filter-tab" onclick="filterWishlist('high', this)">
            <i class="fas fa-exclamation-triangle"></i>
            High Priority
            <span class="count">{{ $stats['high_priority'] }}</span>
        </button>
        <button class="filter-tab" onclick="filterWishlist('reminders', this)">
            <i class="fas fa-clock"></i>
            With Reminders
            <span class="count">{{ $stats['with_reminders'] }}</span>
        </button>
        <button class="filter-tab" onclick="filterWishlist('due', this)">
            <i class="fas fa-bell"></i>
            Due Soon
            <span class="count">{{ $stats['due_reminders'] }}</span>
        </button>
    </div>

    <!-- Wishlist Grid -->
    @if($wishlistItems->count() > 0)
        <div class="wishlist-grid" id="wishlistGrid">
            @foreach($wishlistItems as $item)
                @php
                    $course = $item->course;
                    $isFree = $course->price == 0;
                    $enrollment = Auth::user()->enrollments()->where('course_id', $course->id)->first();
                    $isEnrolled = $enrollment !== null;
                    
                    $sessionsCount = $course->sessions_count ?? 0;
                    $assignmentsCount = $course->assignments_count ?? 0;
                    $materialsCount = $course->materials_count ?? 0;
                    
                    $hasReminder = !is_null($item->reminder_date);
                    $isDue = $hasReminder && \Carbon\Carbon::parse($item->reminder_date)->isPast();
                @endphp
                
                <div class="wishlist-card" 
                     data-priority="{{ $item->priority }}" 
                     data-reminder="{{ $hasReminder ? 'yes' : 'no' }}"
                     data-due="{{ $isDue ? 'yes' : 'no' }}">
                    
                    <div class="card-image">
                        <img src="{{ $course->image_url }}" alt="{{ $course->title }}">
                        
                        <div class="priority-badge priority-{{ $item->priority }}">
                            @switch($item->priority)
                                @case(1) Low @break
                                @case(2) Medium @break
                                @case(3) High @break
                                @case(4) Urgent @break
                                @default Medium
                            @endswitch
                        </div>

                        @if($hasReminder)
                            <div class="reminder-badge {{ $isDue ? 'due' : 'normal' }}">
                                <i class="fas fa-clock"></i>
                                {{ \Carbon\Carbon::parse($item->reminder_date)->format('M d, Y') }}
                                @if($isDue)
                                    <span style="margin-left: 4px;">Due!</span>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="card-content">
                        <h3 class="course-title">{{ $course->title }}</h3>
                        
                        <div class="instructor">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>by <strong>{{ $course->instructor_name }}</strong></span>
                        </div>

                        <!-- Course Stats Mini -->
                        <div class="course-stats-mini">
                            <div class="stat-mini">
                                <i class="fas fa-video"></i>
                                <span>{{ $sessionsCount }}</span>
                                <small>Sessions</small>
                            </div>
                            <div class="stat-mini">
                                <i class="fas fa-tasks"></i>
                                <span>{{ $assignmentsCount }}</span>
                                <small>Tasks</small>
                            </div>
                            <div class="stat-mini">
                                <i class="fas fa-file-alt"></i>
                                <span>{{ $materialsCount }}</span>
                                <small>Files</small>
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
                                @endif
                            @endif
                        </div>

                        <!-- Priority Selector -->
                        <div class="priority-selector">
                            <label class="priority-label">Priority Level</label>
                            <select class="priority-select" onchange="updatePriority({{ $item->id }}, this.value, this)">
                                <option value="1" {{ $item->priority == 1 ? 'selected' : '' }}>Low Priority</option>
                                <option value="2" {{ $item->priority == 2 ? 'selected' : '' }}>Medium Priority</option>
                                <option value="3" {{ $item->priority == 3 ? 'selected' : '' }}>High Priority</option>
                                <option value="4" {{ $item->priority == 4 ? 'selected' : '' }}>Urgent Priority</option>
                            </select>
                        </div>
                    </div>

                    <!-- Card Actions -->
                    <div class="card-actions">
                        <a href="{{ route('courses.show', $course->slug) }}" class="btn btn-outline">
                            <i class="fas fa-eye"></i> Details
                        </a>

                        @if($isEnrolled)
                            <a href="{{ route('courses.progress', $enrollment->id) }}" class="btn btn-success">
                                <i class="fas fa-play"></i> Continue
                            </a>
                        @else
                            <a href="{{ route('courses.registration', $course->slug) }}" class="btn btn-primary">
                                <i class="fas fa-shopping-cart"></i> Enroll
                            </a>
                        @endif

                        <button class="btn btn-reminder {{ $hasReminder ? 'active' : '' }}" 
                                onclick="openReminderModal({{ $item->id }}, {{ $hasReminder ? 'true' : 'false' }}, '{{ $item->reminder_date }}')">
                            <i class="fas fa-clock"></i>
                        </button>

                        <button class="btn btn-danger" onclick="removeFromWishlist({{ $item->course->id }})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($wishlistItems->hasPages())
            <div class="pagination">
                {{ $wishlistItems->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-heart-broken"></i>
            </div>
            <h3>Your Wishlist is Empty</h3>
            <p>Start adding courses you're interested in to save them for later.</p>
            <a href="{{ route('courses.public') }}" class="btn-browse">
                <i class="fas fa-search"></i> Browse Courses
            </a>
        </div>
    @endif
</div>

<!-- Reminder Modal -->
<div class="modal" id="reminderModal" onclick="if(event.target === this) closeReminderModal()">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-clock"></i> Set Reminder</h3>
            <button class="close-btn" onclick="closeReminderModal()">&times;</button>
        </div>
        <input type="hidden" id="currentWishlistId" value="">
        <div class="form-group">
            <label>Reminder Date</label>
            <input type="date" id="reminderDate" class="form-control" min="{{ now()->format('Y-m-d') }}" value="{{ now()->addDays(1)->format('Y-m-d') }}">
        </div>
        <div class="modal-actions">
            <button class="btn-modal-primary" onclick="saveReminder()">
                <i class="fas fa-check"></i> Set Reminder
            </button>
            <button class="btn-modal-secondary" onclick="closeReminderModal()">
                <i class="fas fa-times"></i> Cancel
            </button>
        </div>
        <button class="btn-clear-reminder" id="clearReminderBtn" onclick="clearReminder()" style="display: none;">
            <i class="fas fa-trash"></i> Clear Reminder
        </button>
    </div>
</div>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let currentWishlistId = null;
    let toastTimeout;

    // Filter Function
    function filterWishlist(filter, element) {
        const items = document.querySelectorAll('.wishlist-card');
        
        items.forEach(item => {
            const priority = parseInt(item.dataset.priority);
            const hasReminder = item.dataset.reminder === 'yes';
            const isDue = item.dataset.due === 'yes';
            
            let show = false;
            switch(filter) {
                case 'all': show = true; break;
                case 'high': show = priority >= 3; break;
                case 'reminders': show = hasReminder; break;
                case 'due': show = isDue; break;
            }
            
            item.style.display = show ? 'flex' : 'none';
        });

        document.querySelectorAll('.filter-tab').forEach(btn => btn.classList.remove('active'));
        element.classList.add('active');
    }

    // Toast Notification
    function showToast(title, message, type = 'success') {
        const toast = document.getElementById('toastNotification');
        const icon = toast.querySelector('.toast-icon i');
        const toastTitle = document.getElementById('toastTitle');
        const toastMessage = document.getElementById('toastMessage');
        
        if (toastTimeout) clearTimeout(toastTimeout);
        
        toastTitle.textContent = title;
        toastMessage.textContent = message;
        
        if (type === 'success') {
            toast.classList.remove('error');
            icon.className = 'fas fa-check';
        } else {
            toast.classList.add('error');
            icon.className = 'fas fa-exclamation-circle';
        }
        
        toast.classList.add('show');
        
        toastTimeout = setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }

    function hideToast() {
        document.getElementById('toastNotification').classList.remove('show');
        if (toastTimeout) clearTimeout(toastTimeout);
    }

    // Update Priority - FIXED
    function updatePriority(wishlistId, priority, selectElement) {
        fetch(`/wishlist/${wishlistId}/priority`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ priority: priority })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showToast('Priority Updated', 'Priority changed successfully', 'success');
                
                const card = selectElement.closest('.wishlist-card');
                const badge = card.querySelector('.priority-badge');
                badge.className = `priority-badge priority-${priority}`;
                
                const priorityText = {1: 'Low', 2: 'Medium', 3: 'High', 4: 'Urgent'}[priority] || 'Medium';
                badge.textContent = priorityText;
                
                card.dataset.priority = priority;
            } else {
                showToast('Error', data.message || 'Failed to update priority', 'error');
                selectElement.value = selectElement.querySelector(`[value="${selectElement.value}"]`)?.value || '2';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Error', 'Something went wrong', 'error');
            selectElement.value = selectElement.querySelector(`[value="${selectElement.value}"]`)?.value || '2';
        });
    }

    // Remove from Wishlist - FIXED with correct route (uses course ID)
    function removeFromWishlist(courseId) {
        Swal.fire({
            title: 'Remove from Wishlist?',
            text: 'This course will be removed from your saved items.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, remove',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/wishlist/remove/${courseId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Removed!',
                            text: 'Course removed from wishlist',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message || 'Failed to remove', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', error.message || 'Something went wrong', 'error');
                });
            }
        });
    }

    // Reminder Modal - FIXED with auto-close
    function openReminderModal(wishlistId, hasReminder, reminderDate) {
        currentWishlistId = wishlistId;
        document.getElementById('currentWishlistId').value = wishlistId;
        
        if (hasReminder && reminderDate && reminderDate !== '') {
            document.getElementById('clearReminderBtn').style.display = 'block';
            // Parse and set the existing reminder date
            const date = new Date(reminderDate);
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            document.getElementById('reminderDate').value = `${year}-${month}-${day}`;
        } else {
            document.getElementById('clearReminderBtn').style.display = 'none';
            // Set default to tomorrow
            const tomorrow = new Date();
            tomorrow.setDate(tomorrow.getDate() + 1);
            const year = tomorrow.getFullYear();
            const month = String(tomorrow.getMonth() + 1).padStart(2, '0');
            const day = String(tomorrow.getDate()).padStart(2, '0');
            document.getElementById('reminderDate').value = `${year}-${month}-${day}`;
        }
        
        document.getElementById('reminderModal').style.display = 'flex';
    }

    function closeReminderModal() {
        document.getElementById('reminderModal').style.display = 'none';
        currentWishlistId = null;
    }

    function saveReminder() {
        const wishlistId = document.getElementById('currentWishlistId').value;
        const date = document.getElementById('reminderDate').value;
        
        if (!date) {
            Swal.fire('Error', 'Please select a date', 'error');
            return;
        }

        fetch(`/wishlist/${wishlistId}/reminder`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ reminder_date: date })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                closeReminderModal(); // AUTO CLOSE
                Swal.fire({
                    icon: 'success',
                    title: 'Reminder Set!',
                    text: data.message || 'You will be notified on ' + new Date(date).toLocaleDateString(),
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', data.message || 'Failed to set reminder', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', error.message || 'Something went wrong', 'error');
        });
    }

    function clearReminder() {
        const wishlistId = document.getElementById('currentWishlistId').value;
        
        Swal.fire({
            title: 'Clear Reminder?',
            text: 'This reminder will be removed.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, clear'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/wishlist/${wishlistId}/reminder`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        closeReminderModal(); // AUTO CLOSE
                        Swal.fire('Cleared!', 'Reminder removed', 'success')
                            .then(() => {
                                location.reload();
                            });
                    } else {
                        Swal.fire('Error', data.message || 'Failed to clear reminder', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', error.message || 'Something went wrong', 'error');
                });
            }
        });
    }
</script>
@endsection