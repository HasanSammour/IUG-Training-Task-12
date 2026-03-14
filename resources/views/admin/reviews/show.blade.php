@extends('layouts.app')

@section('title', 'Review Details')
@section('body-class', 'admin-page')

@section('styles')
<style>
    .admin-page {
        background-color: #f8fbff;
        min-height: 100vh;
        padding-bottom: 70px;
    }

    .review-container {
        padding: 30px 40px;
        max-width: 1000px;
        margin: 0 auto;
    }

    /* Header */
    .page-header {
        margin-bottom: 25px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 15px;
        transition: color 0.3s ease;
        padding: 8px 16px;
        background: white;
        border-radius: 30px;
        border: 1px solid #e2e8f0;
    }

    .back-link:hover {
        color: #2D3E50;
        border-color: #2D3E50;
        transform: translateX(-3px);
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #2D3E50;
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0 0 5px 0;
    }

    .page-title i {
        color: #f59e0b;
        background: rgba(245, 158, 11, 0.1);
        padding: 10px;
        border-radius: 12px;
    }

    /* Status Badge */
    .status-badge {
        display: inline-block;
        padding: 8px 20px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        margin-left: 15px;
    }

    .status-approved {
        background: #dcfce7;
        color: #15803d;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    /* Review Card */
    .review-card {
        background: white;
        border-radius: 24px;
        padding: 40px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    /* User Info Section */
    .user-section {
        display: flex;
        align-items: center;
        gap: 25px;
        margin-bottom: 30px;
        padding-bottom: 25px;
        border-bottom: 1px solid #f1f5f9;
        flex-wrap: wrap;
    }

    .user-avatar-large {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #2D3E50, #1a252f);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 600;
        box-shadow: 0 10px 25px rgba(45,62,80,0.2);
        border: 4px solid white;
    }

    .user-avatar-large img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .user-details {
        flex: 1;
    }

    .user-details h2 {
        font-size: 24px;
        color: #2D3E50;
        margin-bottom: 6px;
        font-weight: 700;
    }

    .user-details .email {
        color: #64748b;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 5px;
    }

    .user-meta {
        display: flex;
        gap: 15px;
        color: #64748b;
        font-size: 13px;
    }

    .user-meta i {
        color: #3182ce;
        margin-right: 4px;
    }

    /* Course Info Card */
    .course-info-card {
        background: linear-gradient(135deg, #f0f9ff 0%, #e6f0fa 100%);
        border: 1px solid #bae6fd;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .course-image {
        width: 120px;
        height: 90px;
        border-radius: 12px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .course-details {
        flex: 1;
    }

    .course-title {
        font-size: 20px;
        font-weight: 700;
        color: #0369a1;
        margin-bottom: 8px;
    }

    .course-meta {
        display: flex;
        gap: 20px;
        color: #0c4a6e;
        font-size: 14px;
        flex-wrap: wrap;
    }

    .course-meta i {
        margin-right: 5px;
    }

    .course-link {
        background: white;
        color: #0369a1;
        padding: 10px 25px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid #bae6fd;
        white-space: nowrap;
    }

    .course-link:hover {
        background: #0284c7;
        color: white;
        border-color: #0284c7;
        transform: translateY(-2px);
    }

    /* Rating Section */
    .rating-section {
        background: #f8fafc;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 25px;
        flex-wrap: wrap;
    }

    .rating-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        font-weight: 700;
        color: white;
    }

    .rating-5 { background: #10b981; }
    .rating-4 { background: #34d399; }
    .rating-3 { background: #fbbf24; }
    .rating-2 { background: #f97316; }
    .rating-1 { background: #ef4444; }

    .rating-stars-large {
        flex: 1;
    }

    .stars-display {
        display: flex;
        gap: 8px;
        margin-bottom: 10px;
    }

    .stars-display i {
        font-size: 32px;
        color: #f59e0b;
    }

    .stars-display i.empty {
        color: #cbd5e1;
    }

    .rating-text {
        font-size: 18px;
        font-weight: 600;
        color: #2D3E50;
    }

    .rating-text small {
        font-size: 14px;
        color: #64748b;
        font-weight: normal;
    }

    /* Review Content */
    .review-content-section {
        background: #f8fafc;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        border-left: 4px solid #3182ce;
    }

    .review-title-large {
        font-size: 22px;
        font-weight: 700;
        color: #2D3E50;
        margin-bottom: 15px;
    }

    .review-text-large {
        color: #475569;
        font-size: 16px;
        line-height: 1.8;
        white-space: pre-wrap;
    }

    /* Metadata Grid */
    .metadata-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .metadata-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        background: #f8fafc;
        border-radius: 16px;
    }

    .metadata-icon {
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2D3E50;
        font-size: 20px;
    }

    .metadata-content {
        flex: 1;
    }

    .metadata-label {
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .metadata-value {
        font-size: 16px;
        font-weight: 600;
        color: #2D3E50;
    }

    /* Helpful Stats */
    .helpful-stats {
        margin-bottom: 30px;
    }

    .helpful-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .helpful-title {
        font-size: 16px;
        font-weight: 600;
        color: #2D3E50;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .helpful-numbers {
        font-size: 14px;
        color: #64748b;
    }

    .helpful-bar-container {
        height: 12px;
        background: #e2e8f0;
        border-radius: 6px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .helpful-bar-fill {
        height: 100%;
        background: #10b981;
        border-radius: 6px;
    }

    .helpful-percentage {
        text-align: right;
        font-size: 14px;
        font-weight: 600;
        color: #10b981;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #e2e8f0;
    }

    .btn-primary {
        flex: 1;
        padding: 14px 25px;
        background: #2D3E50;
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-primary:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45,62,80,0.15);
    }

    .btn-success {
        flex: 1;
        padding: 14px 25px;
        background: #10b981;
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-success:hover {
        background: #0f9e6a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }

    .btn-danger {
        flex: 1;
        padding: 14px 25px;
        background: #fee2e2;
        color: #b91c1c;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-danger:hover {
        background: #fecaca;
        transform: translateY(-2px);
    }

    .btn-secondary {
        flex: 1;
        padding: 14px 25px;
        background: white;
        color: #475569;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #2D3E50;
        color: #2D3E50;
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
        .review-container {
            padding: 20px;
        }

        .review-card {
            padding: 25px;
        }

        .user-section {
            flex-direction: column;
            text-align: center;
        }

        .user-details {
            text-align: center;
        }

        .user-meta {
            justify-content: center;
        }

        .course-info-card {
            flex-direction: column;
            text-align: center;
        }

        .rating-section {
            flex-direction: column;
            text-align: center;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<div class="review-container">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Header -->
    <div class="page-header">
        <a href="{{ route('admin.reviews.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Back to All Reviews
        </a>
        <div style="display: flex; align-items: center; flex-wrap: wrap; gap: 15px;">
            <h1 class="page-title">
                <i class="fas fa-star"></i>
                Review Details
            </h1>
            <span class="status-badge {{ $review->is_approved ? 'status-approved' : 'status-pending' }}">
                {{ $review->is_approved ? 'Approved' : 'Pending Approval' }}
            </span>
        </div>
    </div>

    <!-- Main Review Card -->
    <div class="review-card">
        <!-- User Info -->
        <div class="user-section">
            <div class="user-avatar-large">
                @if($review->user->avatar)
                    <img src="{{ $review->user->avatar_url }}" alt="{{ $review->user->name }}">
                @else
                    {{ $review->user->initials }}
                @endif
            </div>
            <div class="user-details">
                <h2>{{ $review->user->name }}</h2>
                <div class="email">
                    <i class="fas fa-envelope"></i> {{ $review->user->email }}
                </div>
                <div class="user-meta">
                    <span><i class="fas fa-calendar-alt"></i> Joined {{ $review->user->created_at->format('M Y') }}</span>
                    <span><i class="fas fa-graduation-cap"></i> {{ $review->user->enrollments_count ?? 0 }} courses</span>
                </div>
            </div>
        </div>

        <!-- Course Info -->
        <div class="course-info-card">
            <img src="{{ $review->course->image_url }}" alt="{{ $review->course->title }}" class="course-image">
            <div class="course-details">
                <h3 class="course-title">{{ $review->course->title }}</h3>
                <div class="course-meta">
                    <span><i class="fas fa-chalkboard-teacher"></i> {{ $review->course->instructor_name }}</span>
                    <span><i class="fas fa-clock"></i> {{ $review->course->duration }}</span>
                    <span><i class="fas fa-signal"></i> {{ ucfirst($review->course->level) }}</span>
                </div>
            </div>
            <a href="{{ route('courses.show', $review->course->slug) }}" class="course-link" target="_blank">
                <i class="fas fa-external-link-alt"></i> View Course
            </a>
        </div>

        <!-- Rating -->
        <div class="rating-section">
            <div class="rating-circle rating-{{ $review->rating }}">
                {{ $review->rating }}.0
            </div>
            <div class="rating-stars-large">
                <div class="stars-display">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)
                            <i class="fas fa-star"></i>
                        @else
                            <i class="far fa-star empty"></i>
                        @endif
                    @endfor
                </div>
                <div class="rating-text">
                    {{ $review->rating }} out of 5 stars
                    <small>({{ $review->helpful_count }} found helpful)</small>
                </div>
            </div>
        </div>

        <!-- Review Title & Content -->
        <div class="review-content-section">
            @if($review->title)
                <h3 class="review-title-large">{{ $review->title }}</h3>
            @endif
            <div class="review-text-large">{{ $review->comment }}</div>
        </div>

        <!-- Metadata -->
        <div class="metadata-grid">
            <div class="metadata-item">
                <div class="metadata-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="metadata-content">
                    <div class="metadata-label">Submitted On</div>
                    <div class="metadata-value">{{ $review->created_at->format('F d, Y') }}</div>
                    <small style="color: #94a3b8;">{{ $review->created_at->diffForHumans() }}</small>
                </div>
            </div>

            <div class="metadata-item">
                <div class="metadata-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="metadata-content">
                    <div class="metadata-label">Last Updated</div>
                    <div class="metadata-value">{{ $review->updated_at->format('F d, Y') }}</div>
                    <small style="color: #94a3b8;">{{ $review->updated_at->diffForHumans() }}</small>
                </div>
            </div>

            <div class="metadata-item">
                <div class="metadata-icon">
                    <i class="fas fa-id-card"></i>
                </div>
                <div class="metadata-content">
                    <div class="metadata-label">Review ID</div>
                    <div class="metadata-value">#{{ $review->id }}</div>
                </div>
            </div>

            <div class="metadata-item">
                <div class="metadata-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="metadata-content">
                    <div class="metadata-label">Status</div>
                    <div class="metadata-value">{{ $review->is_approved ? 'Approved' : 'Pending' }}</div>
                </div>
            </div>
        </div>

        <!-- Helpful Stats -->
        <div class="helpful-stats">
            <div class="helpful-header">
                <h4 class="helpful-title">
                    <i class="fas fa-thumbs-up"></i>
                    Helpfulness Score
                </h4>
                <span class="helpful-numbers">
                    {{ $review->helpful_count }} helpful · {{ $review->not_helpful_count }} not helpful
                </span>
            </div>
            <div class="helpful-bar-container">
                @php
                    $total = $review->helpful_count + $review->not_helpful_count;
                    $percentage = $total > 0 ? round(($review->helpful_count / $total) * 100) : 0;
                @endphp
                <div class="helpful-bar-fill" style="width: {{ $percentage }}%"></div>
            </div>
            <div class="helpful-percentage">{{ $percentage }}% found this review helpful</div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            @if(!$review->is_approved)
                <form action="{{ route('admin.reviews.toggle-approval', $review) }}" method="POST" style="flex: 1;" id="approveForm">
                    @csrf
                    <button type="submit" class="btn-success">
                        <i class="fas fa-check-circle"></i>
                        Approve Review
                    </button>
                </form>
            @else
                <form action="{{ route('admin.reviews.toggle-approval', $review) }}" method="POST" style="flex: 1;" id="unapproveForm">
                    @csrf
                    <button type="submit" class="btn-secondary">
                        <i class="fas fa-times-circle"></i>
                        Unapprove Review
                    </button>
                </form>
            @endif

            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" style="flex: 1;" id="deleteForm">
                @csrf
                @method('DELETE')
                <button type="button" class="btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i>
                    Delete Review
                </button>
            </form>

            <a href="{{ route('admin.reviews.index') }}" class="btn-secondary" style="flex: 1; text-align: center;">
                <i class="fas fa-arrow-left"></i>
                Back to List
            </a>
        </div>
    </div>
</div>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Delete Review?',
            text: 'Are you sure you want to delete this review? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e53e3e',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('loadingOverlay').style.display = 'flex';
                document.getElementById('deleteForm').submit();
            }
        });
    }

    // Show loading on form submit
    document.getElementById('approveForm')?.addEventListener('submit', function() {
        document.getElementById('loadingOverlay').style.display = 'flex';
    });

    document.getElementById('unapproveForm')?.addEventListener('submit', function() {
        document.getElementById('loadingOverlay').style.display = 'flex';
    });

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