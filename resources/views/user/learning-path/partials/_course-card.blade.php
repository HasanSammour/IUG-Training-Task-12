@props(['course', 'enrollment' => null, 'showActions' => true, 'compact' => false])

<div class="course-card {{ $compact ? 'compact' : '' }}">
    <div class="course-image">
        <img src="{{ $course->image_url }}" alt="{{ $course->title }}">
        @if($course->level)
            <span class="level-badge level-{{ $course->level }}">
                <i class="fas fa-signal"></i>
                {{ ucfirst($course->level) }}
            </span>
        @endif
    </div>

    <div class="course-content">
        <div class="course-header">
            <h3 class="course-title">
                <a href="{{ route('courses.show', $course->slug) }}">
                    {{ $course->title }}
                </a>
            </h3>
            @if($course->category)
                <span class="course-category">
                    <i class="fas fa-folder"></i>
                    {{ $course->category->name }}
                </span>
            @endif
        </div>

        <p class="course-description">
            {{ Str::limit($course->short_description, 100) }}
        </p>

        <div class="course-meta">
            <span class="meta-item">
                <i class="fas fa-clock"></i>
                {{ $course->duration ?? '4 weeks' }}
            </span>
            <span class="meta-item">
                <i class="fas fa-users"></i>
                {{ $course->total_students ?? 0 }} students
            </span>
            <span class="meta-item rating">
                <i class="fas fa-star"></i>
                {{ number_format($course->rating ?? 4.5, 1) }}
            </span>
        </div>

        @if($enrollment)
            <div class="enrollment-progress">
                <div class="progress-header">
                    <span class="progress-label">Your Progress</span>
                    <span class="progress-value">{{ $enrollment->progress_percentage }}%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $enrollment->progress_percentage }}%"></div>
                </div>
            </div>
        @endif

        @if($showActions)
            <div class="course-actions">
                @if($enrollment)
                    @if($enrollment->status === 'completed')
                        <a href="{{ route('courses.show', $course->slug) }}" class="btn-review">
                            <i class="fas fa-redo"></i>
                            Review
                        </a>
                        @if($course->certificate_available)
                            <a href="{{ route('certificate.show', $enrollment->id) }}" class="btn-certificate">
                                <i class="fas fa-certificate"></i>
                                Certificate
                            </a>
                        @endif
                    @else
                        <a href="{{ route('courses.progress', $enrollment->id) }}" class="btn-continue">
                            <i class="fas fa-play"></i>
                            Continue
                        </a>
                    @endif
                @else
                    <form action="{{ route('learning-path.start', $course->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn-start">
                            <i class="fas fa-rocket"></i>
                            Start Course
                        </button>
                    </form>
                @endif

                <a href="{{ route('courses.show', $course->slug) }}" class="btn-details">
                    <i class="fas fa-info-circle"></i>
                    Details
                </a>
            </div>
        @endif
    </div>
</div>

<style>
.course-card {
    background: white;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.course-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.08);
    border-color: #2D3E50;
}

.course-card.compact {
    flex-direction: row;
    align-items: center;
}

.course-image {
    position: relative;
    height: 160px;
    overflow: hidden;
}

.course-card.compact .course-image {
    width: 120px;
    height: 120px;
    flex-shrink: 0;
}

.course-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.course-card:hover .course-image img {
    transform: scale(1.05);
}

.level-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    gap: 4px;
}

.level-badge.level-beginner {
    color: #2e7d32;
}

.level-badge.level-intermediate {
    color: #f57c00;
}

.level-badge.level-advanced {
    color: #c62828;
}

.course-content {
    padding: 20px;
    flex: 1;
}

.course-card.compact .course-content {
    padding: 15px;
}

.course-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 10px;
}

.course-title {
    font-size: 18px;
    font-weight: 600;
    margin: 0;
    flex: 1;
}

.course-title a {
    color: #2D3E50;
    text-decoration: none;
    transition: color 0.3s ease;
}

.course-title a:hover {
    color: #3182ce;
}

.course-category {
    font-size: 11px;
    color: #64748b;
    background: #f1f5f9;
    padding: 3px 10px;
    border-radius: 20px;
    white-space: nowrap;
    margin-left: 10px;
}

.course-category i {
    margin-right: 3px;
}

.course-description {
    color: #64748b;
    font-size: 14px;
    line-height: 1.5;
    margin-bottom: 15px;
}

.course-meta {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
    font-size: 12px;
    color: #64748b;
}

.meta-item i {
    margin-right: 4px;
    color: #94a3b8;
}

.meta-item.rating i {
    color: #fbbf24;
}

.enrollment-progress {
    margin-bottom: 15px;
}

.progress-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
    font-size: 12px;
}

.progress-label {
    color: #64748b;
}

.progress-value {
    font-weight: 600;
    color: #2D3E50;
}

.progress-bar {
    height: 6px;
    background: #e2e8f0;
    border-radius: 3px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #2D3E50, #3182ce);
    border-radius: 3px;
    transition: width 0.5s ease;
}

.course-actions {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.btn-review, .btn-continue, .btn-start, .btn-details, .btn-certificate {
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-review {
    background: #f1f5f9;
    color: #475569;
}

.btn-review:hover {
    background: #e2e8f0;
}

.btn-continue {
    background: #2D3E50;
    color: white;
}

.btn-continue:hover {
    background: #1a252f;
    transform: translateY(-2px);
}

.btn-start {
    background: #10b981;
    color: white;
}

.btn-start:hover {
    background: #0f9e6a;
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
}

.btn-certificate {
    background: #d97706;
    color: white;
}

.btn-certificate:hover {
    background: #b85e00;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .course-card.compact {
        flex-direction: column;
    }
    
    .course-card.compact .course-image {
        width: 100%;
        height: 140px;
    }
    
    .course-header {
        flex-direction: column;
        gap: 8px;
    }
    
    .course-category {
        margin-left: 0;
    }
    
    .course-actions {
        flex-wrap: wrap;
    }
}
</style>