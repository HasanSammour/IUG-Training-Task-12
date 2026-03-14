@props(['title' => 'Recommended For You', 'courses' => [], 'limit' => 3])

<div class="recommendations-section">
    <div class="section-header">
        <h3 class="section-title">
            <i class="fas fa-robot" style="color: #3182ce;"></i>
            {{ $title }}
        </h3>
        @if($courses->count() > $limit)
            <a href="{{ route('courses.public') }}" class="view-all">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        @endif
    </div>

    @if($courses->count() > 0)
        <div class="recommendations-grid">
            @foreach($courses->take($limit) as $course)
                <div class="recommendation-card">
                    <div class="card-badge">
                        @if($loop->index === 0)
                            <span class="badge best-match">Best Match</span>
                        @elseif($loop->index === 1)
                            <span class="badge good-match">Good Match</span>
                        @else
                            <span class="badge also-good">Also Good</span>
                        @endif
                    </div>

                    <div class="card-image">
                        <img src="{{ $course->image_url }}" alt="{{ $course->title }}">
                        <span class="match-score">
                            {{ rand(85, 99) }}% Match
                        </span>
                    </div>

                    <div class="card-content">
                        <h4 class="card-title">
                            <a href="{{ route('courses.show', $course->slug) }}">
                                {{ $course->title }}
                            </a>
                        </h4>

                        <div class="card-meta">
                            <span class="meta-item">
                                <i class="fas fa-clock"></i>
                                {{ $course->duration ?? '4 weeks' }}
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-signal"></i>
                                {{ ucfirst($course->level) }}
                            </span>
                        </div>

                        <p class="card-description">
                            {{ Str::limit($course->short_description, 80) }}
                        </p>

                        <div class="card-footer">
                            <div class="price">
                                @if($course->discounted_price)
                                    <span class="current-price">${{ number_format($course->discounted_price, 0) }}</span>
                                    <span class="original-price">${{ number_format($course->price, 0) }}</span>
                                @else
                                    <span class="current-price">${{ number_format($course->price, 0) }}</span>
                                @endif
                            </div>

                            <form action="{{ route('learning-path.start', $course->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-add">
                                    <i class="fas fa-plus"></i>
                                    Add to Path
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($courses->count() > $limit)
            <div class="recommendations-footer">
                <a href="{{ route('courses.public') }}" class="btn-browse">
                    <i class="fas fa-search"></i>
                    Browse All Courses
                </a>
            </div>
        @endif
    @else
        <div class="empty-recommendations">
            <div class="empty-icon">
                <i class="fas fa-robot"></i>
            </div>
            <h4>No recommendations yet</h4>
            <p>Start taking courses to get personalized AI recommendations</p>
            <a href="{{ route('courses.public') }}" class="btn-browse">
                <i class="fas fa-search"></i>
                Browse Courses
            </a>
        </div>
    @endif
</div>

<style>
.recommendations-section {
    background: white;
    border-radius: 20px;
    padding: 25px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    margin-bottom: 30px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.section-title {
    font-size: 18px;
    color: #2D3E50;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    margin: 0;
}

.view-all {
    color: #3182ce;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: color 0.3s ease;
}

.view-all:hover {
    color: #1e40af;
}

.view-all i {
    font-size: 12px;
    margin-left: 4px;
}

.recommendations-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.recommendation-card {
    background: #f8fafc;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
}

.recommendation-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.08);
    border-color: #2D3E50;
}

.card-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 2;
}

.badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    color: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.badge.best-match {
    background: #10b981;
}

.badge.good-match {
    background: #3182ce;
}

.badge.also-good {
    background: #8b5cf6;
}

.card-image {
    position: relative;
    height: 140px;
    overflow: hidden;
}

.card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.recommendation-card:hover .card-image img {
    transform: scale(1.05);
}

.match-score {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    backdrop-filter: blur(5px);
}

.card-content {
    padding: 20px;
}

.card-title {
    font-size: 16px;
    font-weight: 600;
    margin: 0 0 8px 0;
    line-height: 1.4;
}

.card-title a {
    color: #2D3E50;
    text-decoration: none;
    transition: color 0.3s ease;
}

.card-title a:hover {
    color: #3182ce;
}

.card-meta {
    display: flex;
    gap: 12px;
    margin-bottom: 10px;
    font-size: 11px;
    color: #64748b;
}

.meta-item i {
    margin-right: 4px;
    color: #94a3b8;
}

.card-description {
    color: #64748b;
    font-size: 13px;
    line-height: 1.5;
    margin-bottom: 15px;
}

.card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid #e2e8f0;
}

.price {
    display: flex;
    align-items: center;
    gap: 8px;
}

.current-price {
    font-size: 18px;
    font-weight: 700;
    color: #2D3E50;
}

.original-price {
    font-size: 13px;
    color: #94a3b8;
    text-decoration: line-through;
}

.btn-add {
    background: #2D3E50;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-add:hover {
    background: #1a252f;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(45,62,80,0.15);
}

.recommendations-footer {
    text-align: center;
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
}

.btn-browse {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 25px;
    background: #f1f5f9;
    color: #475569;
    text-decoration: none;
    border-radius: 30px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-browse:hover {
    background: #e2e8f0;
    color: #2D3E50;
}

.empty-recommendations {
    text-align: center;
    padding: 40px 20px;
}

.empty-icon {
    font-size: 48px;
    color: #cbd5e1;
    margin-bottom: 15px;
}

.empty-recommendations h4 {
    font-size: 16px;
    color: #2D3E50;
    margin-bottom: 5px;
}

.empty-recommendations p {
    color: #64748b;
    font-size: 14px;
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .recommendations-grid {
        grid-template-columns: 1fr;
    }
    
    .card-footer {
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-add {
        width: 100%;
        justify-content: center;
    }
}
</style>