@extends('layouts.app')

@section('title', 'Manage Reviews')
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
        color: #f59e0b;
    }

    /* Stats Cards */
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
        padding: 25px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 18px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
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

    .stat-content {
        flex: 1;
    }

    .stat-value {
        display: block;
        font-size: 32px;
        font-weight: 700;
        color: #2D3E50;
        line-height: 1.2;
        margin-bottom: 6px;
    }

    .stat-label {
        font-size: 13px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Filter Form */
    .filter-form {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
        flex-wrap: wrap;
        background: white;
        padding: 20px;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
    }

    .filter-group {
        flex: 1;
        min-width: 150px;
    }

    .filter-select, .filter-input {
        width: 100%;
        padding: 12px 15px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #2D3E50;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .filter-select:focus, .filter-input:focus {
        outline: none;
        border-color: #2D3E50;
    }

    .filter-button {
        padding: 12px 20px;
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
    }

    .filter-button:hover {
        background: #f8fafc;
        border-color: #2D3E50;
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

    /* Bulk Actions Bar */
    .bulk-actions-bar {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .bulk-select-all {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #0369a1;
        font-weight: 500;
    }

    .bulk-select-all input {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #2D3E50;
    }

    .btn-apply-bulk {
        background: #2D3E50;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-apply-bulk:hover {
        background: #1a252f;
        transform: translateY(-2px);
    }

    /* Reviews Table */
    .reviews-table-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #edf2f7;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .table-responsive {
        overflow-x: auto;
    }

    .reviews-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1300px;
    }

    .reviews-table th {
        text-align: left;
        padding: 15px 20px;
        font-size: 12px;
        color: #64748b;
        background: #fafafa;
        font-weight: 600;
        text-transform: uppercase;
        border-bottom: 1px solid #f1f5f9;
    }

    .reviews-table td {
        padding: 15px 20px;
        font-size: 13px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .reviews-table tr:hover td {
        background: #f8fafc;
    }

    .checkbox-cell {
        width: 40px;
        text-align: center;
    }

    .checkbox-cell input {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #2D3E50;
    }

    /* User Info */
    .user-cell {
        min-width: 200px;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #2D3E50, #1a252f);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        flex-shrink: 0;
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .user-details {
        flex: 1;
    }

    .user-name {
        color: #2D3E50;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 2px;
    }

    .user-email {
        font-size: 11px;
        color: #64748b;
    }

    /* Course Info */
    .course-cell {
        min-width: 250px;
    }

    .course-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .course-thumb {
        width: 50px;
        height: 40px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
    }

    .course-details {
        flex: 1;
    }

    .course-title {
        font-weight: 600;
        color: #2D3E50;
        font-size: 13px;
        margin-bottom: 2px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 180px;
    }

    .course-instructor {
        font-size: 11px;
        color: #64748b;
    }

    /* Rating Stars */
    .rating-stars {
        display: flex;
        gap: 2px;
        color: #fbbf24;
        margin-bottom: 4px;
    }

    .rating-stars i {
        font-size: 14px;
    }

    .rating-stars i.empty {
        color: #cbd5e1;
    }

    .rating-value {
        font-size: 12px;
        color: #64748b;
    }

    /* Review Content */
    .review-content {
        max-width: 300px;
    }

    .review-title {
        font-weight: 600;
        color: #2D3E50;
        margin-bottom: 4px;
        font-size: 14px;
    }

    .review-comment {
        color: #4b5563;
        font-size: 12px;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .review-meta {
        display: flex;
        gap: 10px;
        margin-top: 5px;
        font-size: 10px;
        color: #94a3b8;
    }

    /* Status Badge */
    .status-badge {
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        white-space: nowrap;
    }

    .status-approved {
        background: #dcfce7;
        color: #15803d;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    /* Date Cell */
    .date-cell {
        min-width: 100px;
    }

    .date-cell .main-date {
        font-weight: 500;
        color: #2D3E50;
        margin-bottom: 2px;
    }

    .date-cell .time-ago {
        font-size: 11px;
        color: #94a3b8;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        min-width: 140px;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #4b5563;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .btn-action:hover {
        background: #f8fafc;
        border-color: #cbd5e0;
        transform: translateY(-2px);
    }

    .btn-approve {
        color: #10b981;
        border-color: #10b981;
    }

    .btn-approve:hover {
        background: #10b981;
        color: white;
    }

    .btn-view {
        color: #3182ce;
        border-color: #3182ce;
    }

    .btn-view:hover {
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

    /* Tooltip */
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

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        border-top: 1px solid #f1f5f9;
    }

    .pagination-info {
        font-size: 13px;
        color: #64748b;
    }

    .pagination-links {
        display: flex;
        gap: 5px;
        align-items: center;
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
        color: #475569;
        background: white;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background: #f1f5f9;
        border-color: #2D3E50;
    }

    .page-link.active {
        background: #2D3E50;
        color: white;
        border-color: #2D3E50;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        grid-column: 1 / -1;
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 20px;
        color: #2D3E50;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #64748b;
        margin-bottom: 25px;
    }

    .btn-primary {
        display: inline-block;
        padding: 12px 30px;
        background: #2D3E50;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #1a252f;
        transform: translateY(-2px);
    }

    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.9);
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
        to { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-container {
            padding: 15px;
        }

        .page-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .filter-form {
            flex-direction: column;
        }

        .bulk-actions-bar {
            flex-direction: column;
            align-items: flex-start;
        }

        .pagination-container {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }

        .action-buttons {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-star"></i>
            Course Reviews Management
        </h1>
        <a href="{{ route('admin.courses.index') }}" class="filter-button" style="background: #2D3E50; color: white;">
            <i class="fas fa-arrow-left"></i> Back to Courses
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['total'] }}</span>
                <span class="stat-label">Total Reviews</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['approved'] }}</span>
                <span class="stat-label">Approved</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['pending'] }}</span>
                <span class="stat-label">Pending</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['avg_rating'] }}</span>
                <span class="stat-label">Avg Rating</span>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('admin.reviews.index') }}" class="filter-form">
        <div class="filter-group">
            <select name="status" class="filter-select">
                <option value="">All Status</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>

        <div class="filter-group">
            <select name="course_id" class="filter-select">
                <option value="">All Courses</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                        {{ Str::limit($course->title, 40) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <select name="rating" class="filter-select">
                <option value="">All Ratings</option>
                <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star</option>
            </select>
        </div>

        <div class="filter-group" style="flex: 2;">
            <input type="text" name="search" class="filter-input" placeholder="Search by user name, email, or review content..." value="{{ request('search') }}">
        </div>

        <button type="submit" class="filter-button apply">
            <i class="fas fa-filter"></i> Apply Filters
        </button>

        @if(request()->hasAny(['status', 'course_id', 'rating', 'search']))
            <a href="{{ route('admin.reviews.index') }}" class="filter-button clear">
                <i class="fas fa-times"></i> Clear Filters
            </a>
        @endif
    </form>

    <!-- Bulk Actions Bar -->
    @if($reviews->count() > 0)
    <div class="bulk-actions-bar">
        <div class="bulk-select-all">
            <input type="checkbox" id="selectAll" onclick="toggleSelectAll()">
            <label for="selectAll">Select All</label>
        </div>
        <button class="btn-apply-bulk" onclick="bulkApprove()">
            <i class="fas fa-check-circle"></i> Approve Selected
        </button>
        <span style="color: #64748b; font-size: 13px; margin-left: auto;">
            {{ $reviews->total() }} reviews found
        </span>
    </div>
    @endif

    <!-- Reviews Table -->
    <div class="reviews-table-card">
        <div class="table-responsive">
            <table class="reviews-table">
                <thead>
                    <tr>
                        <th class="checkbox-cell">
                            <input type="checkbox" id="selectAllHeader" onclick="toggleSelectAll()">
                        </th>
                        <th>User</th>
                        <th>Course</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td class="checkbox-cell">
                                <input type="checkbox" class="review-checkbox" value="{{ $review->id }}">
                            </td>
                            <td class="user-cell">
                                <div class="user-info">
                                    <div class="user-avatar">
                                        @if($review->user->avatar)
                                            <img src="{{ $review->user->avatar_url }}" alt="{{ $review->user->name }}">
                                        @else
                                            {{ $review->user->initials }}
                                        @endif
                                    </div>
                                    <div class="user-details">
                                        <div class="user-name">{{ $review->user->name }}</div>
                                        <div class="user-email">{{ $review->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="course-cell">
                                <div class="course-info">
                                    <img src="{{ $review->course->image_url }}" alt="" class="course-thumb">
                                    <div class="course-details">
                                        <div class="course-title" title="{{ $review->course->title }}">
                                            {{ Str::limit($review->course->title, 30) }}
                                        </div>
                                        <div class="course-instructor">
                                            <i class="fas fa-user"></i> {{ $review->course->instructor_name }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="rating-stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star empty"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="rating-value">{{ $review->rating }}.0</span>
                            </td>
                            <td>
                                <div class="review-content">
                                    @if($review->title)
                                        <div class="review-title">{{ $review->title }}</div>
                                    @endif
                                    <div class="review-comment">{{ $review->comment }}</div>
                                    <div class="review-meta">
                                        <span><i class="fas fa-thumbs-up"></i> {{ $review->helpful_count }}</span>
                                        <span><i class="fas fa-thumbs-down"></i> {{ $review->not_helpful_count }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge {{ $review->is_approved ? 'status-approved' : 'status-pending' }}">
                                    {{ $review->is_approved ? 'Approved' : 'Pending' }}
                                </span>
                            </td>
                            <td class="date-cell">
                                <div class="main-date">{{ $review->created_at->format('M d, Y') }}</div>
                                <div class="time-ago">{{ $review->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @if(!$review->is_approved)
                                        <button type="button" class="btn-action btn-approve" 
                                                onclick="toggleApproval({{ $review->id }})"
                                                title="Approve Review">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                    
                                    <a href="{{ route('admin.reviews.show', $review) }}" class="btn-action btn-view" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <button type="button" class="btn-action btn-delete" 
                                            onclick="deleteReview({{ $review->id }})"
                                            title="Delete Review">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-star"></i>
                                    <h3>No Reviews Found</h3>
                                    <p>No reviews match your current filters.</p>
                                    @if(request()->hasAny(['status', 'course_id', 'rating', 'search']))
                                        <a href="{{ route('admin.reviews.index') }}" class="btn-primary" style="display: inline-block;">
                                            <i class="fas fa-times"></i> Clear Filters
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
        @if($reviews->hasPages())
            <div class="pagination-container">
                <div class="pagination-info">
                    Showing {{ $reviews->firstItem() ?? 0 }} to {{ $reviews->lastItem() ?? 0 }} of {{ $reviews->total() }} reviews
                </div>
                <div class="pagination-links">
                    {{ $reviews->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Hidden Forms -->
@foreach($reviews as $review)
    <form id="approve-form-{{ $review->id }}" action="{{ route('admin.reviews.toggle-approval', $review) }}" method="POST" style="display: none;">
        @csrf
    </form>
    
    <form id="delete-form-{{ $review->id }}" action="{{ route('admin.reviews.destroy', $review) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endforeach

<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let selectedReviews = [];

    // Toggle select all
    function toggleSelectAll() {
        const selectAll = document.getElementById('selectAll');
        const selectAllHeader = document.getElementById('selectAllHeader');
        const checkboxes = document.querySelectorAll('.review-checkbox');
        const isChecked = selectAll ? selectAll.checked : (selectAllHeader ? selectAllHeader.checked : false);
        
        checkboxes.forEach(cb => cb.checked = isChecked);
        
        if (selectAllHeader) selectAllHeader.checked = isChecked;
        if (selectAll) selectAll.checked = isChecked;
        
        updateSelectedReviews();
    }

    function updateSelectedReviews() {
        selectedReviews = [];
        document.querySelectorAll('.review-checkbox:checked').forEach(cb => {
            selectedReviews.push(cb.value);
        });
    }

    // Toggle approval
    function toggleApproval(reviewId) {
        Swal.fire({
            title: 'Approve Review?',
            text: 'This review will become visible on the course page.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, approve it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('loadingOverlay').style.display = 'flex';
                document.getElementById(`approve-form-${reviewId}`).submit();
            }
        });
    }

    // Delete review
    function deleteReview(reviewId) {
        Swal.fire({
            title: 'Delete Review?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e53e3e',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('loadingOverlay').style.display = 'flex';
                document.getElementById(`delete-form-${reviewId}`).submit();
            }
        });
    }

    // Bulk approve
    function bulkApprove() {
        updateSelectedReviews();
        
        if (selectedReviews.length === 0) {
            Swal.fire('No Reviews Selected', 'Please select at least one review', 'warning');
            return;
        }

        Swal.fire({
            title: 'Approve Selected Reviews?',
            text: `${selectedReviews.length} reviews will be approved and become visible.`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, approve all',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('loadingOverlay').style.display = 'flex';
                
                fetch('{{ route("admin.reviews.bulk-approve") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ review_ids: selectedReviews })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message || 'Failed to approve reviews', 'error');
                    }
                })
                .catch(error => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    Swal.fire('Error', 'Something went wrong', 'error');
                });
            }
        });
    }

    // Auto-hide alerts
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });
    });
</script>
@endsection