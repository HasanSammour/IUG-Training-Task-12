@props(['items' => [], 'learningPath' => null])

<div class="path-timeline">
    <div class="timeline-header">
        <h3 class="timeline-title">
            <i class="fas fa-road"></i>
            Your Learning Journey
        </h3>
        @if($learningPath)
            <div class="timeline-progress">
                <div class="progress-circle" data-progress="{{ $learningPath->progress_percentage }}">
                    <span class="progress-text">{{ $learningPath->progress_percentage }}%</span>
                </div>
            </div>
        @endif
    </div>

    @if($items->count() > 0)
        <div class="timeline-steps">
            @foreach($items as $index => $item)
                @php
                    $status = $item->status;
                    $course = $item->course;
                    $isCompleted = $status === 'completed';
                    $isActive = $status === 'active';
                    $isLocked = $status === 'locked';
                    $progress = $item->progress ?? 0;
                @endphp
                
                <div class="timeline-step {{ $status }} {{ $loop->first ? 'first' : '' }} {{ $loop->last ? 'last' : '' }}"
                     data-position="{{ $index + 1 }}">
                    
                    <div class="step-indicator">
                        @if($isCompleted)
                            <div class="indicator-icon completed">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        @elseif($isActive)
                            <div class="indicator-icon active">
                                <span class="step-number">{{ $index + 1 }}</span>
                            </div>
                        @else
                            <div class="indicator-icon locked">
                                <i class="fas fa-lock"></i>
                            </div>
                        @endif
                        
                        @if(!$loop->last)
                            <div class="step-connector {{ $isCompleted ? 'completed' : '' }}"></div>
                        @endif
                    </div>

                    <div class="step-content card-hover">
                        <div class="step-header">
                            <h4 class="step-title">{{ $course->title ?? 'Course ' . ($index + 1) }}</h4>
                            <span class="step-level level-{{ $course->level ?? 'beginner' }}">
                                <i class="fas fa-signal"></i>
                                {{ ucfirst($course->level ?? 'Beginner') }}
                            </span>
                        </div>

                        @if($course)
                            <div class="step-meta">
                                <span class="meta-item">
                                    <i class="fas fa-clock"></i>
                                    {{ $course->duration ?? '4 weeks' }}
                                </span>
                                <span class="meta-item">
                                    <i class="fas fa-folder"></i>
                                    {{ $course->category->name ?? 'General' }}
                                </span>
                            </div>
                        @endif

                        @if($isActive && $progress > 0)
                            <div class="step-progress">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $progress }}%"></div>
                                </div>
                                <span class="progress-value">{{ $progress }}%</span>
                            </div>
                        @endif

                        <div class="step-actions">
                            @if($isLocked)
                                <button class="btn-locked" disabled>
                                    <i class="fas fa-lock"></i>
                                    Locked
                                </button>
                            @elseif($isCompleted)
                                <a href="{{ route('courses.show', $course->slug) }}" class="btn-review">
                                    <i class="fas fa-redo"></i>
                                    Review
                                </a>
                                @if($course->certificate_available)
                                    <a href="{{ route('certificate.show', $item->enrollment_id) }}" class="btn-certificate">
                                        <i class="fas fa-certificate"></i>
                                    </a>
                                @endif
                            @elseif($isActive)
                                @if($enrollment = $item->enrollment)
                                    <a href="{{ route('courses.progress', $enrollment->id) }}" class="btn-continue">
                                        <i class="fas fa-play"></i>
                                        Continue
                                    </a>
                                @else
                                    <form action="{{ route('learning-path.start', $course->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-start">
                                            <i class="fas fa-rocket"></i>
                                            Start Course
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($learningPath && $learningPath->next_milestone)
            <div class="next-milestone">
                <i class="fas fa-flag-checkered"></i>
                <span>Next Milestone: {{ $learningPath->next_milestone }}</span>
            </div>
        @endif
    @else
        <div class="empty-timeline">
            <div class="empty-icon">
                <i class="fas fa-road"></i>
            </div>
            <h4>No learning path yet</h4>
            <p>Generate your personalized learning path to get started</p>
            <form action="{{ route('learning-path.generate') }}" method="POST">
                @csrf
                <button type="submit" class="btn-generate">
                    <i class="fas fa-magic"></i>
                    Generate AI Path
                </button>
            </form>
        </div>
    @endif
</div>

<style>
.path-timeline {
    background: white;
    border-radius: 20px;
    padding: 30px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}

.timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.timeline-title {
    font-size: 20px;
    color: #2D3E50;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.timeline-title i {
    color: #3182ce;
}

.progress-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: conic-gradient(#2D3E50 {{ $learningPath->progress_percentage ?? 0 }}%, #e2e8f0 0);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.progress-circle::before {
    content: '';
    position: absolute;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: white;
}

.progress-text {
    position: relative;
    font-size: 14px;
    font-weight: 600;
    color: #2D3E50;
    z-index: 1;
}

.timeline-steps {
    display: flex;
    flex-direction: column;
    gap: 20px;
    position: relative;
}

.timeline-step {
    display: flex;
    gap: 20px;
    position: relative;
}

.step-indicator {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    width: 40px;
}

.indicator-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    z-index: 2;
    transition: all 0.3s ease;
}

.indicator-icon.completed {
    background: #10b981;
    color: white;
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
}

.indicator-icon.active {
    background: #2D3E50;
    color: white;
    font-weight: 600;
    box-shadow: 0 0 0 4px rgba(45, 62, 80, 0.1);
}

.indicator-icon.locked {
    background: #f1f5f9;
    color: #94a3b8;
}

.step-connector {
    width: 2px;
    height: 40px;
    background: #e2e8f0;
    margin: 5px 0;
    transition: background 0.3s ease;
}

.step-connector.completed {
    background: #10b981;
}

.timeline-step.last .step-connector {
    display: none;
}

.step-content {
    flex: 1;
    background: #f8fafc;
    border-radius: 16px;
    padding: 20px;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    margin-bottom: 10px;
}

.step-content:hover {
    transform: translateX(5px);
    border-color: #2D3E50;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.step-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 10px;
}

.step-title {
    font-size: 16px;
    font-weight: 600;
    color: #2D3E50;
    margin: 0;
    flex: 1;
}

.step-level {
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    white-space: nowrap;
    margin-left: 10px;
}

.step-level.level-beginner {
    background: #e6f7e6;
    color: #2e7d32;
}

.step-level.level-intermediate {
    background: #fff3e0;
    color: #f57c00;
}

.step-level.level-advanced {
    background: #ffebee;
    color: #c62828;
}

.step-meta {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
    font-size: 12px;
    color: #64748b;
}

.meta-item i {
    margin-right: 5px;
    color: #94a3b8;
}

.step-progress {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
}

.progress-bar {
    flex: 1;
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

.progress-value {
    font-size: 12px;
    font-weight: 600;
    color: #2D3E50;
    min-width: 40px;
}

.step-actions {
    display: flex;
    gap: 10px;
}

.btn-locked, .btn-review, .btn-continue, .btn-start, .btn-certificate {
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

.btn-locked {
    background: #f1f5f9;
    color: #94a3b8;
    cursor: not-allowed;
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

.btn-certificate {
    background: #d97706;
    color: white;
    padding: 8px 12px;
}

.btn-certificate:hover {
    background: #b85e00;
    transform: translateY(-2px);
}

.next-milestone {
    margin-top: 25px;
    padding: 15px 20px;
    background: #f0f9ff;
    border-radius: 12px;
    border: 1px solid #bae6fd;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #0369a1;
    font-weight: 500;
}

.next-milestone i {
    color: #0284c7;
    font-size: 16px;
}

.empty-timeline {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    font-size: 48px;
    color: #cbd5e1;
    margin-bottom: 15px;
}

.empty-timeline h4 {
    font-size: 18px;
    color: #2D3E50;
    margin-bottom: 8px;
}

.empty-timeline p {
    color: #64748b;
    margin-bottom: 20px;
}

.btn-generate {
    background: #2D3E50;
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 30px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-generate:hover {
    background: #1a252f;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(45,62,80,0.15);
}

@media (max-width: 768px) {
    .timeline-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    
    .step-header {
        flex-direction: column;
        gap: 8px;
    }
    
    .step-level {
        margin-left: 0;
    }
    
    .step-actions {
        flex-wrap: wrap;
    }
}
</style>