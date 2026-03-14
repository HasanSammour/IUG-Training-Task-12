@props(['stats' => []])

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <i class="fas fa-book-open"></i>
        </div>
        <div class="stat-content">
            <span class="stat-value">{{ $stats['total_courses'] ?? 0 }}</span>
            <span class="stat-label">Total Courses</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <span class="stat-value">{{ $stats['completed_courses'] ?? 0 }}</span>
            <span class="stat-label">Completed</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon yellow">
            <i class="fas fa-spinner"></i>
        </div>
        <div class="stat-content">
            <span class="stat-value">{{ $stats['in_progress'] ?? 0 }}</span>
            <span class="stat-label">In Progress</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon purple">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-content">
            <span class="stat-value">{{ $stats['total_hours'] ?? 0 }}h</span>
            <span class="stat-label">Learning Hours</span>
        </div>
    </div>
</div>

@if(($stats['completion_rate'] ?? 0) > 0)
    <div class="overall-progress">
        <div class="progress-header">
            <span class="progress-title">
                <i class="fas fa-chart-line"></i>
                Overall Progress
            </span>
            <span class="progress-percentage">{{ $stats['completion_rate'] }}%</span>
        </div>
        <div class="progress-bar-container">
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ $stats['completion_rate'] }}%"></div>
            </div>
        </div>
    </div>
@endif

<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 25px;
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
    flex-shrink: 0;
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

.overall-progress {
    background: white;
    border-radius: 16px;
    padding: 20px;
    border: 1px solid #e2e8f0;
    margin-top: 20px;
}

.progress-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.progress-title {
    font-size: 14px;
    font-weight: 600;
    color: #2D3E50;
    display: flex;
    align-items: center;
    gap: 8px;
}

.progress-title i {
    color: #3182ce;
}

.progress-percentage {
    font-size: 16px;
    font-weight: 700;
    color: #2D3E50;
}

.progress-bar-container {
    width: 100%;
}

.progress-bar {
    height: 8px;
    background: #e2e8f0;
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #2D3E50, #3182ce);
    border-radius: 4px;
    transition: width 0.5s ease;
}
</style>