@extends('layouts.app')

@section('title', 'Enrollment Details - Shifra Admin')
@section('body-class', 'admin-page')

@section('styles')
<style>
    .admin-container {
        padding: 20px;
        max-width: 1100px;
        margin: 0 auto;
        width: 100%;
    }

    /* Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e2e8f0;
    }

    .page-title {
        font-size: 24px;
        color: #2D3E50;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-title i {
        color: #f59e0b;
    }

    .back-btn {
        color: #64748b;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
        padding: 8px 16px;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }

    .back-btn:hover {
        color: #2D3E50;
        background: #f1f5f9;
        transform: translateX(-5px);
    }

    /* Enrollment Card */
    .enrollment-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #edf2f7;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        overflow: hidden;
        margin-bottom: 30px;
    }

    .card-header {
        background: linear-gradient(135deg, #f8fafc, #ffffff);
        padding: 25px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .enrollment-id-wrapper {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .enrollment-id-label {
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .enrollment-id {
        font-size: 22px;
        color: #2D3E50;
        font-weight: 700;
        font-family: monospace;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .enrollment-id i {
        color: #f59e0b;
        font-size: 18px;
    }

    .status-badge-large {
        padding: 8px 24px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .status-pending { background: #fef3c7; color: #92400e; }
    .status-active { background: #d1fae5; color: #065f46; }
    .status-completed { background: #dbeafe; color: #1e40af; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }

    .card-body {
        padding: 30px;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
    }

    .info-section {
        margin-bottom: 25px;
    }

    .section-title {
        font-size: 16px;
        color: #2D3E50;
        margin-bottom: 20px;
        font-weight: 600;
        padding-bottom: 10px;
        border-bottom: 2px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-title i {
        color: #f59e0b;
    }

    /* Student & Course Cards */
    .profile-card {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 20px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        margin-bottom: 20px;
    }

    .avatar-large {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2D3E50, #f59e0b);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 700;
        flex-shrink: 0;
        overflow: hidden;
    }

    .avatar-large img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-details {
        flex: 1;
    }

    .profile-details h3 {
        font-size: 18px;
        color: #2D3E50;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .profile-details .profile-meta {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 3px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .profile-details .profile-meta i {
        width: 16px;
        color: #94a3b8;
    }

    .course-card {
        display: flex;
        gap: 20px;
        padding: 20px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        margin-bottom: 20px;
    }

    .course-image {
        width: 100px;
        height: 80px;
        border-radius: 10px;
        object-fit: cover;
        background: linear-gradient(135deg, #2D3E50, #f59e0b);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        flex-shrink: 0;
    }

    .course-image img {
        width: 100%;
        height: 100%;
        border-radius: 10px;
        object-fit: cover;
    }

    .course-details {
        flex: 1;
    }

    .course-details h3 {
        font-size: 18px;
        color: #2D3E50;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .course-details .course-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 8px;
    }

    .course-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: #64748b;
    }

    .course-meta-item i {
        color: #f59e0b;
        width: 14px;
    }

    /* Info Rows */
    .info-rows {
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid #e2e8f0;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #64748b;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-label i {
        color: #f59e0b;
        width: 16px;
        font-size: 14px;
    }

    .info-value {
        color: #2D3E50;
        font-weight: 600;
        font-size: 15px;
        text-align: right;
    }

    .info-value.highlight {
        color: #f59e0b;
        font-size: 18px;
    }

    /* Progress Section */
    .progress-section {
        margin: 30px 0;
        padding: 25px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .progress-title {
        font-size: 16px;
        color: #2D3E50;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .progress-percentage-large {
        font-size: 32px;
        font-weight: 700;
        color: #2D3E50;
    }

    .progress-bar-container {
        height: 12px;
        background: #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 15px;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #2D3E50, #f59e0b);
        border-radius: 10px;
        transition: width 0.5s ease;
    }

    .progress-status {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .progress-status-text {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        font-weight: 600;
    }

    .status-not-started { color: #94a3b8; }
    .status-in-progress { color: #3182ce; }
    .status-completed { color: #10b981; }

    /* Notes Section */
    .notes-section {
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 20px;
        margin: 30px 0;
    }

    .notes-content {
        color: #4a5568;
        font-size: 14px;
        line-height: 1.6;
        white-space: pre-wrap;
    }

    /* Timeline */
    .timeline {
        margin: 30px 0;
        padding: 20px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .timeline h3 {
        font-size: 16px;
        color: #2D3E50;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .timeline h3 i {
        color: #f59e0b;
    }

    .timeline-item {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e2e8f0;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .timeline-icon {
        width: 48px;
        height: 48px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #f59e0b;
        font-size: 20px;
        border: 2px solid #f59e0b;
        flex-shrink: 0;
    }

    .timeline-icon.completed {
        background: #10b981;
        color: white;
        border-color: #10b981;
    }

    .timeline-icon.active {
        background: #3182ce;
        color: white;
        border-color: #3182ce;
    }

    .timeline-content {
        flex: 1;
    }

    .timeline-content h4 {
        font-size: 16px;
        color: #2D3E50;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .timeline-content p {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .timeline-time {
        display: inline-block;
        padding: 4px 12px;
        background: white;
        border-radius: 20px;
        font-size: 11px;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    /* Actions Section */
    .actions-section {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        padding-top: 25px;
        border-top: 2px solid #f1f5f9;
        flex-wrap: wrap;
    }

    .btn {
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        font-size: 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        flex: 1;
        min-width: 140px;
    }

    .btn i {
        font-size: 16px;
    }

    .btn-edit {
        background: #2D3E50;
        color: white;
    }

    .btn-edit:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.2);
    }

    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: white;
        border-color: #ef4444;
        transform: translateY(-2px);
    }

    .btn-back {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .btn-back:hover {
        background: #e2e8f0;
        color: #2D3E50;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-value {
        color: #94a3b8;
        font-style: italic;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-container {
            padding: 15px;
        }

        .card-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .profile-card, .course-card {
            flex-direction: column;
            text-align: center;
        }

        .avatar-large {
            margin: 0 auto;
        }

        .actions-section {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <!-- Page Header -->
    <div class="page-header">
        <a href="{{ route('admin.enrollments.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Enrollments
        </a>
        <h1 class="page-title">
            <i class="fas fa-eye"></i>
            Enrollment Details
        </h1>
    </div>

    <!-- Enrollment Card -->
    <div class="enrollment-card">
        <div class="card-header">
            <div class="enrollment-id-wrapper">
                <span class="enrollment-id-label">Enrollment ID</span>
                <div class="enrollment-id">
                    <i class="fas fa-hashtag"></i>
                    {{ $enrollment->enrollment_id }}
                </div>
            </div>
            <span class="status-badge-large status-{{ $enrollment->status }}">
                <i class="fas fa-{{ $enrollment->status == 'active' ? 'play' : ($enrollment->status == 'completed' ? 'check' : ($enrollment->status == 'pending' ? 'clock' : 'times')) }}"></i>
                {{ ucfirst($enrollment->status) }}
            </span>
        </div>

        <div class="card-body">
            <div class="info-grid">
                <!-- Left Column -->
                <div>
                    <!-- Student Information -->
                    <div class="info-section">
                        <h3 class="section-title">
                            <i class="fas fa-user-graduate"></i>
                            Student Information
                        </h3>
                        <div class="profile-card">
                            <div class="avatar-large">
                                @if($enrollment->user->avatar && \Storage::disk('public')->exists($enrollment->user->avatar))
                                    <img src="{{ Storage::url($enrollment->user->avatar) }}" alt="{{ $enrollment->user->name }}">
                                @else
                                    {{ substr($enrollment->user->name, 0, 1) }}
                                @endif
                            </div>
                            <div class="profile-details">
                                <h3>{{ $enrollment->user->name }}</h3>
                                <div class="profile-meta">
                                    <i class="fas fa-envelope"></i> {{ $enrollment->user->email }}
                                </div>
                                <div class="profile-meta">
                                    <i class="fas fa-id-card"></i> Student ID: #{{ str_pad($enrollment->user->id, 5, '0', STR_PAD_LEFT) }}
                                </div>
                                @if($enrollment->user->phone)
                                <div class="profile-meta">
                                    <i class="fas fa-phone"></i> {{ $enrollment->user->phone }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Enrollment Details -->
                    <div class="info-section">
                        <h3 class="section-title">
                            <i class="fas fa-info-circle"></i>
                            Enrollment Details
                        </h3>
                        <div class="info-rows">
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-calendar"></i> Enrolled Date</span>
                                <span class="info-value">{{ $enrollment->enrolled_at->format('M d, Y') }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-clock"></i> Enrolled Time</span>
                                <span class="info-value">{{ $enrollment->enrolled_at->format('H:i') }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-credit-card"></i> Payment Method</span>
                                <span class="info-value">{{ ucfirst(str_replace('_', ' ', $enrollment->payment_method)) }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-dollar-sign"></i> Amount Paid</span>
                                <span class="info-value highlight">${{ number_format($enrollment->amount_paid, 2) }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-sync-alt"></i> Last Updated</span>
                                <span class="info-value">{{ $enrollment->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div>
                    <!-- Course Information -->
                    <div class="info-section">
                        <h3 class="section-title">
                            <i class="fas fa-book-open"></i>
                            Course Information
                        </h3>
                        <div class="course-card">
                            <div class="course-image">
                                @if($enrollment->course->image_path)
                                    <img src="{{ $enrollment->course->image_url }}" alt="{{ $enrollment->course->title }}">
                                @else
                                    <i class="fas fa-graduation-cap"></i>
                                @endif
                            </div>
                            <div class="course-details">
                                <h3>{{ $enrollment->course->title }}</h3>
                                <div class="profile-meta">
                                    <i class="fas fa-chalkboard-teacher"></i> {{ $enrollment->course->instructor_name }}
                                </div>
                                <div class="course-meta">
                                    <span class="course-meta-item">
                                        <i class="fas fa-tag"></i> {{ $enrollment->course->category->name ?? 'Uncategorized' }}
                                    </span>
                                    <span class="course-meta-item">
                                        <i class="fas fa-signal"></i> {{ ucfirst($enrollment->course->level) }}
                                    </span>
                                    <span class="course-meta-item">
                                        <i class="fas fa-clock"></i> {{ $enrollment->course->duration }}
                                    </span>
                                </div>
                                <div class="profile-meta" style="margin-top: 8px;">
                                    <i class="fas fa-id-card"></i> Course ID: #{{ $enrollment->course->id }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Section -->
                    <div class="progress-section">
                        <div class="progress-header">
                            <span class="progress-title">
                                <i class="fas fa-chart-line"></i>
                                Course Progress
                            </span>
                            <span class="progress-percentage-large">{{ $enrollment->progress_percentage }}%</span>
                        </div>
                        <div class="progress-bar-container">
                            <div class="progress-bar-fill" style="width: {{ $enrollment->progress_percentage }}%"></div>
                        </div>
                        <div class="progress-status">
                            <span class="progress-status-text 
                                @if($enrollment->progress_percentage == 100) status-completed
                                @elseif($enrollment->progress_percentage > 0) status-in-progress
                                @else status-not-started
                                @endif">
                                <i class="fas 
                                    @if($enrollment->progress_percentage == 100) fa-check-circle
                                    @elseif($enrollment->progress_percentage > 0) fa-play-circle
                                    @else fa-clock
                                    @endif">
                                </i>
                                @if($enrollment->progress_percentage == 100)
                                    Course Completed
                                @elseif($enrollment->progress_percentage > 0)
                                    In Progress
                                @else
                                    Not Started
                                @endif
                            </span>
                            @if($enrollment->completed_at)
                                <span class="timeline-time">Completed: {{ $enrollment->completed_at->format('M d, Y') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Completion Date (if completed) -->
                    @if($enrollment->completed_at)
                        <div class="info-rows" style="margin-top: 20px;">
                            <div class="info-row">
                                <span class="info-label"><i class="fas fa-check-circle" style="color: #10b981;"></i> Completion Date</span>
                                <span class="info-value">{{ $enrollment->completed_at->format('M d, Y H:i') }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Notes Section -->
            @if($enrollment->notes)
                <div class="notes-section">
                    <h3 class="section-title" style="margin-bottom: 15px;">
                        <i class="fas fa-sticky-note"></i>
                        Additional Notes
                    </h3>
                    <div class="notes-content">
                        {{ $enrollment->notes }}
                    </div>
                </div>
            @endif

            <!-- Timeline -->
            <div class="timeline">
                <h3>
                    <i class="fas fa-history"></i>
                    Enrollment Timeline
                </h3>
                
                <!-- Enrollment Created -->
                <div class="timeline-item">
                    <div class="timeline-icon completed">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="timeline-content">
                        <h4>Enrollment Created</h4>
                        <p>Student was enrolled in the course</p>
                        <span class="timeline-time">{{ $enrollment->created_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>
                
                <!-- Status Changed to Active (if not pending) -->
                @if($enrollment->status != 'pending' && $enrollment->updated_at != $enrollment->created_at)
                    <div class="timeline-item">
                        <div class="timeline-icon active">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="timeline-content">
                            <h4>Enrollment Activated</h4>
                            <p>Status changed to {{ $enrollment->status }}</p>
                            <span class="timeline-time">{{ $enrollment->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                @endif
                
                <!-- Progress Updates (if > 0) -->
                @if($enrollment->progress_percentage > 0 && $enrollment->progress_percentage < 100)
                    <div class="timeline-item">
                        <div class="timeline-icon active">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="timeline-content">
                            <h4>Progress Updated</h4>
                            <p>Student reached {{ $enrollment->progress_percentage }}% course progress</p>
                            <span class="timeline-time">{{ $enrollment->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                @endif
                
                <!-- Course Completed -->
                @if($enrollment->completed_at)
                    <div class="timeline-item">
                        <div class="timeline-icon completed">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="timeline-content">
                            <h4>Course Completed</h4>
                            <p>Student successfully completed the course</p>
                            <span class="timeline-time">{{ $enrollment->completed_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="actions-section">
                <a href="{{ route('admin.enrollments.edit', $enrollment) }}" class="btn btn-edit">
                    <i class="fas fa-edit"></i> Edit Enrollment
                </a>
                <button type="button" class="btn btn-delete" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i> Delete
                </button>
                <a href="{{ route('admin.enrollments.index') }}" class="btn btn-back">
                    <i class="fas fa-list"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Hidden Delete Form -->
    <form id="delete-form" action="{{ route('admin.enrollments.destroy', $enrollment) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate progress bar on load
        const progressBar = document.querySelector('.progress-bar-fill');
        if (progressBar) {
            const width = progressBar.style.width;
            progressBar.style.width = '0%';
            setTimeout(() => {
                progressBar.style.transition = 'width 1s ease';
                progressBar.style.width = width;
            }, 300);
        }
    });

    // Delete confirmation with SweetAlert
    function confirmDelete() {
        Swal.fire({
            title: 'Delete Enrollment?',
            html: `<div style="text-align: left;">
                    <p style="margin-bottom: 15px;">Are you sure you want to delete this enrollment?</p>
                    <div style="background: #fee2e2; border-left: 4px solid #dc2626; padding: 12px; border-radius: 6px; color: #991b1b; font-size: 13px;">
                        <i class="fas fa-exclamation-triangle"></i> 
                        <span style="margin-left: 5px;">This action cannot be undone.</span>
                    </div>
                   </div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form').submit();
            }
        });
    }
</script>
@endsection