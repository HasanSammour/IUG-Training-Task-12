@extends('layouts.app')

@section('title', $learningPath->title . ' - Learning Path Details')
@section('body-class', 'learning-path-page')

@section('styles')
<style>
    .learning-path-page {
        background-color: #f8fbff;
    }

    .path-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 40px;
        padding-bottom: 100px;
    }

    /* Header */
    .path-header {
        margin-bottom: 30px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 20px;
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

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .path-title {
        font-size: 32px;
        font-weight: 700;
        color: #2D3E50;
        margin: 0;
        line-height: 1.2;
    }

    .ai-badge {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 8px 20px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .ai-badge i {
        font-size: 16px;
    }

    .path-description {
        color: #64748b;
        font-size: 16px;
        max-width: 800px;
        line-height: 1.6;
        margin-bottom: 25px;
        padding: 15px 20px;
        background: #f8fafc;
        border-radius: 12px;
        border-left: 4px solid #3182ce;
    }

    /* Stats Grid */
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
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
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

    /* Goals Section */
    .goals-section {
        background: white;
        border-radius: 20px;
        padding: 25px;
        border: 1px solid #e2e8f0;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }

    .goals-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .goals-header i {
        font-size: 24px;
        color: #f59e0b;
        background: #fef3c7;
        padding: 10px;
        border-radius: 12px;
    }

    .goals-header h3 {
        font-size: 18px;
        color: #2D3E50;
        font-weight: 600;
        margin: 0;
    }

    .goals-list {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .goal-item {
        background: #f8fafc;
        padding: 8px 18px;
        border-radius: 30px;
        border: 1px solid #e2e8f0;
        font-size: 14px;
        color: #2D3E50;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .goal-item:hover {
        background: #f1f5f9;
        border-color: #f59e0b;
    }

    .goal-item i {
        color: #10b981;
        font-size: 12px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .btn-primary {
        padding: 12px 25px;
        background: #2D3E50;
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45,62,80,0.15);
    }

    .btn-secondary {
        padding: 12px 25px;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
        border-color: #2D3E50;
        color: #2D3E50;
    }

    .btn-danger {
        padding: 12px 25px;
        background: #fee2e2;
        color: #b91c1c;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-danger:hover {
        background: #fecaca;
        transform: translateY(-2px);
    }

    /* Timeline Wrapper */
    .timeline-wrapper {
        background: white;
        border-radius: 20px;
        padding: 30px;
        border: 1px solid #e2e8f0;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }

    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .timeline-header h3 {
        font-size: 18px;
        color: #2D3E50;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }

    .timeline-header h3 i {
        color: #3182ce;
    }

    .progress-badge {
        background: #e2e8f0;
        color: #475569;
        padding: 6px 16px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
    }

    .progress-badge span {
        color: #2D3E50;
        font-weight: 700;
        margin-left: 5px;
    }

    /* Milestone Section */
    .milestone-section {
        margin-top: 25px;
        padding: 20px;
        background: #f0f9ff;
        border-radius: 12px;
        border: 1px solid #bae6fd;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .milestone-icon {
        width: 45px;
        height: 45px;
        background: #0284c7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
    }

    .milestone-content {
        flex: 1;
    }

    .milestone-label {
        font-size: 12px;
        color: #0369a1;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .milestone-value {
        font-size: 15px;
        font-weight: 600;
        color: #0c4a6e;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .path-container {
            padding: 20px;
        }

        .header-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .path-title {
            font-size: 24px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-primary, .btn-secondary, .btn-danger {
            width: 100%;
            justify-content: center;
        }

        .goals-list {
            flex-direction: column;
        }

        .goal-item {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="path-container">
    <!-- Header -->
    <div class="path-header">
        <a href="{{ route('learning-path.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Back to Learning Path
        </a>

        <div class="header-top">
            <h1 class="path-title">{{ $learningPath->title }}</h1>
            @if($learningPath->is_ai_generated)
                <span class="ai-badge">
                    <i class="fas fa-robot"></i>
                    AI Generated
                </span>
            @endif
        </div>

        <p class="path-description">{{ $learningPath->description }}</p>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-book-open"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $learningPath->total_courses }}</span>
                <span class="stat-label">Total Courses</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $learningPath->completed_courses }}</span>
                <span class="stat-label">Completed</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="fas fa-spinner"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $learningPath->total_courses - $learningPath->completed_courses }}</span>
                <span class="stat-label">Remaining</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $learningPath->progress_percentage }}%</span>
                <span class="stat-label">Progress</span>
            </div>
        </div>
    </div>

    <!-- Goals Section -->
    @if($learningPath->goals)
        <div class="goals-section">
            <div class="goals-header">
                <i class="fas fa-bullseye"></i>
                <h3>Your Learning Goals</h3>
            </div>
            <ul class="goals-list">
                @foreach($learningPath->goals as $goal)
                    <li class="goal-item">
                        <i class="fas fa-check-circle"></i>
                        {{ $goal }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="action-buttons">
        <form action="{{ route('learning-path.generate') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn-primary">
                <i class="fas fa-sync-alt"></i>
                Regenerate Path
            </button>
        </form>
        
        <a href="{{ route('courses.public') }}" class="btn-secondary">
            <i class="fas fa-search"></i>
            Browse More Courses
        </a>

        <form action="{{ route('learning-path.delete', $learningPath->id) }}" method="POST" style="display: inline;" 
              onsubmit="return confirm('Are you sure you want to delete this learning path? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger">
                <i class="fas fa-trash"></i>
                Delete Path
            </button>
        </form>
    </div>

    <!-- Timeline Wrapper -->
    <div class="timeline-wrapper">
        <div class="timeline-header">
            <h3>
                <i class="fas fa-road"></i>
                Your Learning Journey
            </h3>
            <span class="progress-badge">
                Progress <span>{{ $learningPath->progress_percentage }}%</span>
            </span>
        </div>

        @include('user.learning-path.partials._path-timeline', [
            'items' => $items,
            'learningPath' => $learningPath
        ])

        <!-- Next Milestone -->
        @if($learningPath->next_milestone)
            <div class="milestone-section">
                <div class="milestone-icon">
                    <i class="fas fa-flag-checkered"></i>
                </div>
                <div class="milestone-content">
                    <div class="milestone-label">Next Milestone</div>
                    <div class="milestone-value">{{ $learningPath->next_milestone }}</div>
                </div>
            </div>
        @endif
    </div>

    <!-- Quick Links to Related Content -->
    <div style="display: flex; gap: 15px; justify-content: flex-end; margin-top: 20px;">
        <a href="{{ route('learning-path.sessions.upcoming') }}" class="btn-secondary" style="padding: 10px 20px;">
            <i class="fas fa-video"></i>
            View All Upcoming Sessions
        </a>
        <a href="{{ route('courses.my-courses') }}" class="btn-secondary" style="padding: 10px 20px;">
            <i class="fas fa-book"></i>
            My Courses
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animate progress bars
        document.querySelectorAll('.progress-fill').forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.transition = 'width 1s ease';
                bar.style.width = width;
            }, 300);
        });

        // Handle course start with loading
        window.startCourse = function(courseId, button) {
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Starting...';
            document.getElementById('loadingOverlay').style.display = 'flex';
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/learning-path/${courseId}/start`;
            
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            
            form.appendChild(csrf);
            document.body.appendChild(form);
            form.submit();
        };
    });
</script>
@endsection