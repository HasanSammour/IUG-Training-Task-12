@props(['review', 'compact' => false])

<div class="review-card-component {{ $compact ? 'compact' : '' }}">
    <div class="review-header">
        <div class="reviewer-info">
            <div class="reviewer-avatar">
                @if($review->user->avatar)
                    <img src="{{ $review->user->avatar_url }}" alt="{{ $review->user->name }}">
                @else
                    {{ $review->user->initials }}
                @endif
            </div>
            <div class="reviewer-details">
                <h4 class="reviewer-name">{{ $review->user->name }}</h4>
                <span class="review-date">{{ $review->created_at->format('M d, Y') }}</span>
            </div>
        </div>
        
        <div class="review-rating">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= $review->rating)
                    <i class="fas fa-star"></i>
                @else
                    <i class="far fa-star"></i>
                @endif
            @endfor
            <span class="rating-value">({{ $review->rating }}.0)</span>
        </div>
    </div>

    @if(!$compact)
        @if($review->title)
            <h3 class="review-title">{{ $review->title }}</h3>
        @endif
        <p class="review-comment">{{ $review->comment }}</p>
    @else
        <p class="review-comment">{{ Str::limit($review->comment, 100) }}</p>
    @endif

    <div class="review-footer">
        <div class="helpful-buttons">
            <button class="helpful-btn" onclick="markHelpful({{ $review->id }})">
                <i class="fas fa-thumbs-up"></i> {{ $review->helpful_count }}
            </button>
            <button class="helpful-btn" onclick="markNotHelpful({{ $review->id }})">
                <i class="fas fa-thumbs-down"></i> {{ $review->not_helpful_count }}
            </button>
        </div>
        
        @if(!$review->is_approved)
            <span class="pending-badge">Pending Approval</span>
        @endif
    </div>
</div>

<style>
.review-card-component {
    background: white;
    border-radius: 16px;
    padding: 20px;
    border: 1px solid #e2e8f0;
    margin-bottom: 15px;
    transition: all 0.3s ease;
}

.review-card-component:hover {
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    border-color: #2D3E50;
}

.review-card-component.compact {
    padding: 15px;
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
    flex-wrap: wrap;
    gap: 10px;
}

.reviewer-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.reviewer-avatar {
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
}

.reviewer-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}

.reviewer-details h4 {
    font-size: 14px;
    color: #2D3E50;
    margin-bottom: 2px;
    font-weight: 600;
}

.review-date {
    font-size: 11px;
    color: #94a3b8;
}

.review-rating {
    display: flex;
    align-items: center;
    gap: 2px;
}

.review-rating i {
    color: #fbbf24;
    font-size: 14px;
}

.review-rating i.far {
    color: #cbd5e1;
}

.rating-value {
    font-size: 12px;
    color: #64748b;
    margin-left: 5px;
}

.review-title {
    font-size: 16px;
    color: #2D3E50;
    margin-bottom: 8px;
    font-weight: 600;
}

.review-comment {
    color: #4b5563;
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 15px;
}

.review-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #f1f5f9;
}

.helpful-buttons {
    display: flex;
    gap: 10px;
}

.helpful-btn {
    background: #f1f5f9;
    border: none;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    color: #475569;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 4px;
}

.helpful-btn:hover {
    background: #e2e8f0;
}

.pending-badge {
    background: #fef3c7;
    color: #92400e;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}
</style>