@extends('layouts.app')

@section('title', 'Contacts')
@section('body-class', 'contacts-page')

@section('styles')
    <style>
        .contacts-page {
            background-color: #f8fbff;
        }

        .contacts-wrapper {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 40px;
            padding-bottom: 100px;
        }

        /* Header Section */
        .contacts-header {
            margin-bottom: 30px;
        }

        .header-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
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

        .total-count {
            background: #f1f5f9;
            color: #475569;
            padding: 6px 15px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .total-count span {
            background: #2D3E50;
            color: white;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Filter Section */
        .filter-section {
            background: white;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            border: 1px solid #e2e8f0;
        }

        .filter-title {
            font-size: 16px;
            font-weight: 600;
            color: #2D3E50;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .filter-title i {
            color: #3182ce;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: 1fr 300px auto;
            gap: 20px;
            align-items: end;
        }

        @media (max-width: 992px) {
            .filter-grid {
                grid-template-columns: 1fr;
            }
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-label {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .filter-label i {
            color: #3182ce;
            font-size: 14px;
        }

        .filter-input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
        }

        .filter-input:focus {
            outline: none;
            border-color: #2D3E50;
            box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
        }

        .filter-select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            background: white;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
        }

        .filter-select:focus {
            outline: none;
            border-color: #2D3E50;
        }

        .search-wrapper {
            position: relative;
            width: 100%;
        }

        .search-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            z-index: 1;
            font-size: 16px;
        }

        .btn-reset {
            padding: 12px 25px;
            background: #f1f5f9;
            color: #475569;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            height: 48px;
            white-space: nowrap;
        }

        .btn-reset:hover {
            background: #e2e8f0;
            color: #2D3E50;
        }

        .btn-reset i {
            font-size: 14px;
        }

        /* Active Filters */
        .active-filters {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
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
            margin-left: 5px;
        }

        .remove-filter:hover {
            background: #2D3E50;
        }

        /* Stats Cards - Role Based */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
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
            background: #f0f7ff;
            color: #2D3E50;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-content {
            flex: 1;
        }

        .stat-value {
            display: block;
            font-size: 24px;
            font-weight: 700;
            color: #2D3E50;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Contacts Grid */
        .contacts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .contact-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            position: relative;
            overflow: hidden;
            min-width: 0;
            /* Important for flex children to respect text overflow */
        }

        .contact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #2D3E50, #3182ce);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .contact-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            border-color: transparent;
        }

        .contact-card:hover::before {
            opacity: 1;
        }

        .contact-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2D3E50, #3182ce);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 28px;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(45, 62, 80, 0.15);
        }

        .contact-info {
            flex: 1;
            min-width: 0;
            /* Allows text truncation to work */
        }

        .contact-name {
            font-size: 18px;
            font-weight: 600;
            color: #2D3E50;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .role-badge {
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 600;
            color: white;
            display: inline-block;
            flex-shrink: 0;
        }

        .role-badge.admin {
            background: #1e40af;
        }

        .role-badge.instructor {
            background: #065f46;
        }

        .role-badge.student {
            background: #7c3aed;
        }

        .contact-detail {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            font-size: 13px;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        .contact-detail i {
            color: #94a3b8;
            font-size: 12px;
            width: 16px;
            flex-shrink: 0;
        }

        .contact-detail span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .message-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: #f1f5f9;
            color: #2D3E50;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 18px;
            flex-shrink: 0;
        }

        .contact-card:hover .message-btn {
            background: #2D3E50;
            color: white;
            transform: scale(1.1);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 30px;
            border: 1px solid #e2e8f0;
            grid-column: 1 / -1;
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
            flex-wrap: wrap;
            justify-content: center;
        }

        .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 10px;
            border: 1px solid var(--border-color, #e2e8f0);
            border-radius: var(--radius-md, 0.5rem);
            background: var(--white, #ffffff);
            color: var(--text-gray, #64748b);
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background: rgba(45, 62, 80, 0.05);
            color: var(--primary-navy, #2d3e50);
            border-color: var(--primary-navy, #2d3e50);
            transform: translateY(-2px);
        }

        .page-link.active {
            background: var(--primary-navy, #2d3e50);
            color: var(--white, #ffffff);
            border-color: var(--primary-navy, #2d3e50);
            font-weight: 600;
        }

        .page-link.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
            background: var(--bg-light, #f8fbff);
            border-color: var(--border-color, #e2e8f0);
        }

        .page-link i {
            font-size: 12px;
        }

        /* Remove any conflicting pagination styles */
        .pagination a,
        .pagination span {
            /* These will be overridden by .page-link */
        }

        .contacts-grid {
            margin-bottom: 20px;
        }

        /* Loading Spinner */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
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
            .contacts-wrapper {
                padding: 20px;
            }

            .header-top {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .contact-card {
                padding: 20px;
            }

            .contact-avatar {
                width: 60px;
                height: 60px;
                font-size: 24px;
            }

            .contact-name {
                font-size: 16px;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $user = auth()->user();
        $totalCount = $contacts instanceof \Illuminate\Pagination\LengthAwarePaginator ? $contacts->total() : $contacts->count();

        // Role-based counts - only show counts for roles the user can actually contact
        if ($user->hasRole('admin')) {
            $adminCount = $allContacts->filter(function ($c) {
                return $c->hasRole('admin');
            })->count();
            $instructorCount = $allContacts->filter(function ($c) {
                return $c->hasRole('instructor');
            })->count();
            $studentCount = $allContacts->filter(function ($c) {
                return $c->hasRole('student');
            })->count();
        } elseif ($user->hasRole('instructor')) {
            $adminCount = $allContacts->filter(function ($c) {
                return $c->hasRole('admin');
            })->count();
            $studentCount = $allContacts->filter(function ($c) {
                return $c->hasRole('student');
            })->count();
            $instructorCount = 0; // Instructors cannot contact other instructors
        } else {
            $adminCount = $allContacts->filter(function ($c) {
                return $c->hasRole('admin');
            })->count();
            $instructorCount = $allContacts->filter(function ($c) {
                return $c->hasRole('instructor');
            })->count();
            $studentCount = 0; // Students cannot contact other students
        }
    @endphp

    <div class="contacts-wrapper">
        <!-- Header -->
        <div class="contacts-header">
            <div class="header-top">
                <h1 class="page-title">
                    <i class="fas fa-address-book"></i>
                    Contacts
                </h1>
                <div class="total-count">
                    <i class="fas fa-users"></i>
                    Total Contacts
                    <span>{{ $totalCount }}</span>
                </div>
            </div>

            <!-- Stats Cards - Role Based -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $totalCount }}</span>
                        <span class="stat-label">Total Contacts</span>
                    </div>
                </div>

                @if($user->hasRole('admin'))
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-value">{{ $adminCount }}</span>
                            <span class="stat-label">Admins</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-value">{{ $instructorCount }}</span>
                            <span class="stat-label">Instructors</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-value">{{ $studentCount }}</span>
                            <span class="stat-label">Students</span>
                        </div>
                    </div>
                @elseif($user->hasRole('instructor'))
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-value">{{ $studentCount }}</span>
                            <span class="stat-label">My Students</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-value">{{ $adminCount }}</span>
                            <span class="stat-label">Admins</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-value">{{ $totalCount }}</span>
                            <span class="stat-label">Total</span>
                        </div>
                    </div>
                @else
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-value">{{ $instructorCount }}</span>
                            <span class="stat-label">My Instructors</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-value">{{ $adminCount }}</span>
                            <span class="stat-label">Admins</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-value">{{ $totalCount }}</span>
                            <span class="stat-label">Total</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-title">
                <i class="fas fa-filter"></i>
                Filter Contacts
            </div>

            <form method="GET" action="{{ route('contacts.index') }}" id="filterForm">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-search"></i>
                            Search
                        </label>
                        <div class="search-wrapper">
                            <i class="fas fa-search"></i>
                            <input type="text" name="search" class="filter-input" placeholder="Search by name or email..."
                                value="{{ $search ?? '' }}" style="padding-left: 45px;">
                        </div>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fas fa-user-tag"></i>
                            Role
                        </label>
                        <select name="role" class="filter-select">
                            <option value="all" {{ !$role || $role == 'all' ? 'selected' : '' }}>All Roles</option>
                            @if($user->hasRole('admin'))
                                <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admins</option>
                                <option value="instructor" {{ $role == 'instructor' ? 'selected' : '' }}>Instructors</option>
                                <option value="student" {{ $role == 'student' ? 'selected' : '' }}>Students</option>
                            @elseif($user->hasRole('instructor'))
                                <option value="student" {{ $role == 'student' ? 'selected' : '' }}>My Students</option>
                                <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admins</option>
                            @else
                                <option value="instructor" {{ $role == 'instructor' ? 'selected' : '' }}>My Instructors</option>
                                <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admins</option>
                            @endif
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">&nbsp;</label>
                        <button type="submit" class="btn-reset" style="background: #2D3E50; color: white;">
                            <i class="fas fa-filter"></i>
                            Apply Filters
                        </button>
                    </div>
                </div>

                <!-- Active Filters -->
                @if($search || ($role && $role != 'all'))
                    <div class="active-filters">
                        <span class="filter-label">
                            <i class="fas fa-check-circle" style="color: #10b981;"></i>
                            Active Filters:
                        </span>

                        @if($search)
                            <span class="filter-tag">
                                <i class="fas fa-search"></i>
                                Search: "{{ $search }}"
                                <a href="{{ route('contacts.index', array_merge(request()->except('search'), ['role' => $role])) }}"
                                    class="remove-filter">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        @endif

                        @if($role && $role != 'all')
                            <span class="filter-tag">
                                <i class="fas fa-user-tag"></i>
                                Role: {{ ucfirst($role) }}
                                <a href="{{ route('contacts.index', array_merge(request()->except('role'), ['search' => $search])) }}"
                                    class="remove-filter">
                                    <i class="fas fa-times"></i>
                                </a>
                            </span>
                        @endif

                        <a href="{{ route('contacts.index') }}" class="btn-reset" style="padding: 6px 15px; height: auto;">
                            <i class="fas fa-times"></i>
                            Clear All
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Contacts Grid -->
        @if($contacts->count() > 0)
            <div class="contacts-grid" id="contactsGrid">
                @foreach($contacts as $contact)
                    <a href="{{ route('messages.conversation', $contact->id) }}" class="contact-card">
                        <div class="contact-avatar">
                            {{ substr($contact->name, 0, 1) }}
                        </div>
                        <div class="contact-info">
                            <div class="contact-name">
                                {{ $contact->name }}
                                @if($contact->hasRole('admin'))
                                    <span class="role-badge admin">Admin</span>
                                @elseif($contact->hasRole('instructor'))
                                    <span class="role-badge instructor">Instructor</span>
                                @elseif($contact->hasRole('student'))
                                    <span class="role-badge student">Student</span>
                                @endif
                            </div>
                            <div class="contact-detail">
                                <i class="fas fa-envelope"></i>
                                <span>{{ $contact->email }}</span>
                            </div>
                            @if($contact->courses_count ?? false)
                                <div class="contact-detail">
                                    <i class="fas fa-book"></i>
                                    <span>{{ $contact->courses_count }} courses</span>
                                </div>
                            @endif
                        </div>
                        <div class="message-btn">
                            <i class="fas fa-comment"></i>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            @if(method_exists($contacts, 'links') && $contacts->hasPages())
                <div class="pagination-container">
                    <div class="pagination">
                        {{-- Previous Page Link --}}
                        @if($contacts->onFirstPage())
                            <span class="page-link disabled">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $contacts->previousPageUrl() }}" class="page-link">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif
            
                        {{-- Pagination Elements - Show 5 pages with dots --}}
                        @php
                            $currentPage = $contacts->currentPage();
                            $lastPage = $contacts->lastPage();
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
                            <a href="{{ $contacts->url(1) }}" class="page-link">1</a>
                            @if($start > 2)
                                <span class="page-link disabled">...</span>
                            @endif
                        @endif
            
                        {{-- Page numbers --}}
                        @for($page = $start; $page <= $end; $page++)
                            @if($page == $currentPage)
                                <span class="page-link active">{{ $page }}</span>
                            @else
                                <a href="{{ $contacts->url($page) }}" class="page-link">{{ $page }}</a>
                            @endif
                        @endfor
            
                        {{-- Last page link with dots --}}
                        @if($end < $lastPage)
                            @if($end < $lastPage - 1)
                                <span class="page-link disabled">...</span>
                            @endif
                            <a href="{{ $contacts->url($lastPage) }}" class="page-link">{{ $lastPage }}</a>
                        @endif
            
                        {{-- Next Page Link --}}
                        @if($contacts->hasMorePages())
                            <a href="{{ $contacts->nextPageUrl() }}" class="page-link">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="page-link disabled">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                </div>
            @endif
            
            {{-- Show page info below pagination --}}
            @if(method_exists($contacts, 'links') && $contacts->hasPages())
                <div style="text-align: center; margin-top: 15px; color: var(--text-gray); font-size: 13px;">
                    Showing <strong style="color: var(--primary-navy);">{{ $contacts->firstItem() }}</strong> 
                    to <strong style="color: var(--primary-navy);">{{ $contacts->lastItem() }}</strong> 
                    of <strong style="color: var(--primary-navy);">{{ $contacts->total() }}</strong> contacts
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-users-slash"></i>
                </div>
                <h3 class="empty-title">No Contacts Found</h3>
                <p class="empty-text">
                    @if($search || ($role && $role != 'all'))
                        No contacts match your search criteria. Try adjusting your filters.
                    @else
                        @if($user->hasRole('admin'))
                            You don't have any contacts yet. Users will appear here when they join the platform.
                        @elseif($user->hasRole('instructor'))
                            You don't have any contacts yet. Students will appear here when they enroll in your courses.
                        @else
                            You don't have any contacts yet. Instructors will appear here when you enroll in their courses.
                        @endif
                    @endif
                </p>
                @if($search || ($role && $role != 'all'))
                    <a href="{{ route('contacts.index') }}" class="btn-primary">
                        <i class="fas fa-times"></i> Clear Filters
                    </a>
                @else
                    <a href="{{ route('courses.public') }}" class="btn-primary">
                        <i class="fas fa-book-open"></i> Browse Courses
                    </a>
                @endif
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
        let searchTimeout;
        const searchInput = document.querySelector('input[name="search"]');
        const roleSelect = document.querySelector('select[name="role"]');
        const filterForm = document.getElementById('filterForm');
        const loadingOverlay = document.getElementById('loadingOverlay');

        // Show loading on form submit
        filterForm.addEventListener('submit', function () {
            loadingOverlay.style.display = 'flex';
        });

        // Real-time search with debounce
        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                clearTimeout(searchTimeout);

                searchTimeout = setTimeout(() => {
                    if (this.value.length >= 2 || this.value.length === 0) {
                        loadingOverlay.style.display = 'flex';
                        filterForm.submit();
                    }
                }, 500);
            });
        }

        // Role filter change
        if (roleSelect) {
            roleSelect.addEventListener('change', function () {
                loadingOverlay.style.display = 'flex';
                filterForm.submit();
            });
        }
    </script>
@endsection