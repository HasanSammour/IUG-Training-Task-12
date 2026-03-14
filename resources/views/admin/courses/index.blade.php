@extends('layouts.app')

@section('title', 'Manage Courses')
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
        }

        .btn-add-course {
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

        .btn-add-course:hover {
            background: #1a252f;
            transform: translateY(-2px);
        }

        /* Search and Filters */
        .controls-row {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .search-container {
            position: relative;
            flex: 1;
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
            padding: 10px 10px 10px 40px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: white;
            transition: border-color 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #2D3E50;
        }

        .filter-select {
            padding: 10px 15px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: white;
            color: #2D3E50;
            min-width: 150px;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        .filter-select:focus {
            outline: none;
            border-color: #2D3E50;
        }

        /* Filter form */
        .filter-form {
            display: flex;
            gap: 15px;
            width: 100%;
            flex-wrap: wrap;
        }

        .filter-form .search-container {
            flex: 1;
        }

        /* Courses Table - FIXED SPACING */
        .courses-table-card {
            background: white;
            border-radius: 15px;
            border: 1px solid #edf2f7;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin: 0 -5px;
        }

        .table-responsive {
            overflow-x: auto;
            padding: 0 5px;
        }

        .courses-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1100px;
        }

        .courses-table th {
            text-align: left;
            padding: 15px 10px;
            font-size: 13px;
            color: #64748b;
            border-bottom: 1px solid #f1f5f9;
            background: #fafafa;
            font-weight: 600;
            white-space: nowrap;
        }

        .courses-table td {
            padding: 15px 10px;
            font-size: 13px;
            border-bottom: 1px solid #f8fbff;
            vertical-align: middle;
            line-height: 1.4;
        }

        .courses-table tr:hover {
            background-color: #f8fafc;
        }

        /* Column Widths */
        .courses-table th:nth-child(1),
        .courses-table td:nth-child(1) {
            width: 28%;
            min-width: 240px;
        }

        .courses-table th:nth-child(2),
        .courses-table td:nth-child(2) {
            width: 10%;
            min-width: 100px;
        }

        .courses-table th:nth-child(3),
        .courses-table td:nth-child(3) {
            width: 8%;
            min-width: 80px;
        }

        .courses-table th:nth-child(4),
        .courses-table td:nth-child(4) {
            width: 12%;
            min-width: 110px;
        }

        .courses-table th:nth-child(5),
        .courses-table td:nth-child(5) {
            width: 12%;
            min-width: 120px;
        }

        .courses-table th:nth-child(6),
        .courses-table td:nth-child(6) {
            width: 30%;
            min-width: 250px;
        }

        /* Course Info */
        .course-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .course-img {
            width: 70px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #f1f5f9;
            flex-shrink: 0;
        }

        .course-title {
            font-weight: 500;
            color: #2D3E50;
            line-height: 1.3;
            font-size: 14px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        /* Badges */
        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 4px;
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

        .status-featured {
            background: #dbeafe;
            color: #1e40af;
        }

        .category-badge {
            background: #f3f4f6;
            color: #4b5563;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            display: inline-block;
            white-space: nowrap;
        }

        /* Review Count Badge */
        .review-count {
            background: #fef3c7;
            color: #92400e;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            margin-left: 5px;
        }

        /* Actions - ICONS ONLY WITH TOOLTIPS */
        .action-buttons {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            min-width: 200px;
            justify-content: flex-start;
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
            background: #f8fafc;
            border-color: #cbd5e0;
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
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .btn-action[title]::after {
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
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-action:hover::after {
            opacity: 1;
        }

        /* Button specific colors */
        .btn-edit {
            color: #3182ce;
            border-color: #3182ce;
        }

        .btn-edit:hover {
            background: #3182ce;
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

        .btn-students {
            color: #10b981;
            border-color: #10b981;
        }

        .btn-students:hover {
            background: #10b981;
            color: white;
        }

        .btn-reviews {
            color: #f59e0b;
            border-color: #f59e0b;
        }

        .btn-reviews:hover {
            background: #f59e0b;
            color: white;
        }

        .btn-featured {
            color: #8b5cf6;
            border-color: #8b5cf6;
        }

        .btn-featured:hover {
            background: #8b5cf6;
            color: white;
        }

        .btn-status {
            color: #6b7280;
            border-color: #6b7280;
        }

        .btn-status:hover {
            background: #6b7280;
            color: white;
        }

        /* Filter buttons */
        .filter-button {
            padding: 10px 15px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: white;
            color: #2D3E50;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
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
        }

        .filter-button.apply:hover {
            background: #1a252f;
        }

        .filter-button.clear {
            background: #fef2f2;
            color: #dc2626;
            border-color: #dc2626;
        }

        .filter-button.clear:hover {
            background: #dc2626;
            color: white;
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
            min-width: 30px;
            height: 30px;
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
            width: 30px;
            height: 30px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .page-arrow:hover {
            background: #f8fafc;
            border-color: #2D3E50;
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

            .controls-row,
            .filter-form {
                flex-direction: column;
            }

            .action-buttons {
                flex-wrap: wrap;
                gap: 5px;
            }

            .course-cell {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .course-img {
                width: 100%;
                height: 80px;
            }

            .pagination-container {
                flex-direction: column;
                gap: 15px;
            }

            .courses-table-card {
                margin: 0;
            }

            .btn-action {
                width: 28px;
                height: 28px;
                font-size: 11px;
            }

            /* Hide tooltips on mobile */
            .btn-action[title]:hover::after,
            .btn-action[title]::after {
                display: none;
            }
        }

        @media (max-width: 1200px) {
            .admin-container {
                max-width: 100%;
                padding: 15px;
            }

            .filter-form {
                gap: 10px;
            }

            .filter-select {
                min-width: 140px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="admin-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Courses Management</h1>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.reviews.index') }}" class="btn-add-course" style="background: #f59e0b;">
                    <i class="fas fa-star"></i> Manage Reviews
                </a>
                <a href="{{ route('admin.courses.create') }}" class="btn-add-course">
                    <i class="fas fa-plus"></i> Add New Course
                </a>
            </div>
        </div>

        <!-- Search and Filters Form -->
        <form method="GET" action="{{ route('admin.courses.index') }}" class="filter-form">
            <div class="search-container">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="search-input" placeholder="Search courses..."
                    value="{{ request('search') }}">
            </div>

            <select name="category" class="filter-select">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select name="status" class="filter-select">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Featured</option>
            </select>

            <select name="sort" class="filter-select">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
            </select>

            <button type="submit" class="filter-button apply">
                <i class="fas fa-filter"></i> Apply Filters
            </button>

            @if(request()->hasAny(['search', 'category', 'status', 'sort']))
                <a href="{{ route('admin.courses.index') }}" class="filter-button clear">
                    <i class="fas fa-times"></i> Clear Filters
                </a>
            @endif
        </form>

        <!-- Courses Table -->
        <div class="courses-table-card">
            <div class="table-responsive">
                <table class="courses-table">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Category</th>
                            <th>Students</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($courses as $course)
                            @php
                                $reviewCount = \App\Models\CourseReview::where('course_id', $course->id)->count();
                                $pendingReviewCount = \App\Models\CourseReview::where('course_id', $course->id)
                                    ->where('is_approved', false)
                                    ->count();
                            @endphp
                            <tr>
                                <td>
                                    <div class="course-cell">
                                        <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="course-img">
                                        <div>
                                            <div class="course-title">{{ $course->title }}</div>
                                            <div style="font-size: 11px; color: #94a3b8;">
                                                {{ $course->instructor_name }}
                                                @if($reviewCount > 0)
                                                    <span class="review-count">
                                                        <i class="fas fa-star"></i> {{ $reviewCount }} 
                                                        @if($pendingReviewCount > 0)
                                                            ({{ $pendingReviewCount }} pending)
                                                        @endif
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="category-badge">{{ $course->category->name }}</span>
                                </td>
                                <td>
                                    <strong>{{ $course->total_students }}</strong> students
                                </td>
                                <td>
                                    <strong>${{ number_format($course->price, 2) }}</strong>
                                    @if($course->is_discounted)
                                        <br><small style="color: #10b981; font-size: 11px;">
                                            ${{ number_format($course->discounted_price, 2) }}
                                            @if($course->discount_percentage)
                                                ({{ $course->discount_percentage }}% off)
                                            @endif
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    @if($course->is_active)
                                        <span class="status-badge status-active">Active</span>
                                    @else
                                        <span class="status-badge status-inactive">Inactive</span>
                                    @endif

                                    @if($course->is_featured)
                                        <br><span class="status-badge status-featured" style="margin-top: 4px;">Featured</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <!-- Edit Button with Tooltip -->
                                        <a href="{{ route('admin.courses.edit', $course) }}" class="btn-action btn-edit"
                                            title="Edit Course">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- View Students Button with Tooltip -->
                                        <a href="{{ route('admin.courses.enrollments', $course) }}"
                                            class="btn-action btn-students" title="View Students">
                                            <i class="fas fa-users"></i>
                                        </a>

                                        <!-- View Reviews Button with Tooltip - NEW -->
                                        <a href="{{ route('admin.reviews.index', ['course_id' => $course->id]) }}" 
                                           class="btn-action btn-reviews" 
                                           title="View Reviews ({{ $reviewCount }} total, {{ $pendingReviewCount }} pending)">
                                            <i class="fas fa-star"></i>
                                            @if($pendingReviewCount > 0)
                                                <span style="position: absolute; top: -5px; right: -5px; background: #ef4444; color: white; border-radius: 50%; width: 16px; height: 16px; font-size: 10px; display: flex; align-items: center; justify-content: center;">
                                                    {{ $pendingReviewCount }}
                                                </span>
                                            @endif
                                        </a>

                                        <!-- Toggle Featured Button with Tooltip -->
                                        <form action="{{ route('admin.courses.toggle-featured', $course) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-action btn-featured"
                                                title="{{ $course->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}">
                                                @if($course->is_featured)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            </button>
                                        </form>

                                        <!-- Toggle Active Button with Tooltip -->
                                        <form action="{{ route('admin.courses.toggle-active', $course) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-action btn-status"
                                                title="{{ $course->is_active ? 'Deactivate Course' : 'Activate Course' }}">
                                                @if($course->is_active)
                                                    <i class="fas fa-toggle-on"></i>
                                                @else
                                                    <i class="fas fa-toggle-off"></i>
                                                @endif
                                            </button>
                                        </form>

                                        <!-- Delete Button with Tooltip -->
                                        <button type="button" class="btn-action btn-delete delete-course-btn"
                                            data-course-id="{{ $course->id }}" data-course-title="{{ $course->title }}"
                                            title="Delete Course">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-book-open"></i>
                                        <h3>No Courses Found</h3>
                                        <p>@if(request()->hasAny(['search', 'category', 'status']))
                                            Try different search criteria
                                        @else
                                                Start by adding your first course
                                            @endif</p>
                                        @if(!request()->hasAny(['search', 'category', 'status']))
                                            <a href="{{ route('admin.courses.create') }}" class="btn-add-course"
                                                style="display: inline-flex; margin-top: 15px;">
                                                <i class="fas fa-plus"></i> Add Course
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($courses->hasPages())
                <div class="pagination-container">
                    <div class="pagination-info">
                        Showing {{ $courses->firstItem() ?? 0 }} to {{ $courses->lastItem() ?? 0 }} of {{ $courses->total() }}
                        courses
                    </div>
                    <div class="pagination-links">
                        @if($courses->onFirstPage())
                            <span class="page-arrow" style="opacity: 0.5; cursor: not-allowed;">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <a href="{{ $courses->previousPageUrl() }}" class="page-arrow">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif

                        @php
                            $start = max(1, $courses->currentPage() - 2);
                            $end = min($courses->lastPage(), $courses->currentPage() + 2);
                        @endphp

                        @if($start > 1)
                            <a href="{{ $courses->url(1) }}" class="page-link">1</a>
                            @if($start > 2) <span style="padding: 0 5px;">...</span> @endif
                        @endif

                        @for($page = $start; $page <= $end; $page++)
                            <a href="{{ $courses->url($page) }}"
                                class="page-link {{ $courses->currentPage() == $page ? 'active' : '' }}">
                                {{ $page }}
                            </a>
                        @endfor

                        @if($end < $courses->lastPage())
                            @if($end < $courses->lastPage() - 1) <span style="padding: 0 5px;">...</span> @endif
                            <a href="{{ $courses->url($courses->lastPage()) }}" class="page-link">{{ $courses->lastPage() }}</a>
                        @endif

                        @if($courses->hasMorePages())
                            <a href="{{ $courses->nextPageUrl() }}" class="page-arrow">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="page-arrow" style="opacity: 0.5; cursor: not-allowed;">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Hidden Delete Forms -->
    @foreach($courses as $course)
        <form id="delete-form-{{ $course->id }}" action="{{ route('admin.courses.destroy', $course) }}" method="POST"
            style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-submit filters on change (optional)
            const filterSelects = document.querySelectorAll('select[name="category"], select[name="status"], select[name="sort"]');
            filterSelects.forEach(select => {
                select.addEventListener('change', function () {
                    this.closest('form').submit();
                });
            });

            // Auto-submit search on Enter key
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.addEventListener('keyup', function (e) {
                    if (e.key === 'Enter') {
                        this.closest('form').submit();
                    }
                });
            }

            // Enhanced button hover effects
            const actionButtons = document.querySelectorAll('.btn-action');
            actionButtons.forEach(button => {
                button.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-2px)';
                });
                button.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateY(0)';
                });
            });

            // SweetAlert2 Delete Confirmation
            const deleteButtons = document.querySelectorAll('.delete-course-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();

                    const courseId = this.getAttribute('data-course-id');
                    const courseTitle = this.getAttribute('data-course-title');

                    Swal.fire({
                        title: 'Delete Course',
                        text: `Are you sure you want to delete "${courseTitle}"? This action cannot be undone.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#2d3e50',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true,
                        background: 'var(--white)',
                        color: 'var(--text-dark)',
                        customClass: {
                            popup: 'shadow-lg rounded-xl'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Show loading
                            Swal.fire({
                                title: 'Deleting...',
                                text: 'Please wait while we delete the course',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });

                            // Submit the form
                            const form = document.getElementById(`delete-form-${courseId}`);
                            if (form) {
                                form.submit();
                            } else {
                                // If form doesn't exist, try direct submission
                                fetch(`/admin/courses/${courseId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json'
                                    }
                                }).then(response => {
                                    if (response.ok) {
                                        window.location.reload();
                                    }
                                });
                            }
                        }
                    });
                });
            });

            // Handle table row hover effects
            const tableRows = document.querySelectorAll('.courses-table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function () {
                    this.style.backgroundColor = '#f8fafc';
                });
                row.addEventListener('mouseleave', function () {
                    this.style.backgroundColor = '';
                });
            });
        });
    </script>
@endsection