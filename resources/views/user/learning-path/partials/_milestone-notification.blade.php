@props(['notification' => null, 'type' => 'success', 'message' => '', 'action' => null])

<div class="milestone-notification {{ $type }}" id="milestoneNotification">
    <div class="notification-icon">
        @if($type === 'success')
            <i class="fas fa-trophy"></i>
        @elseif($type === 'info')
            <i class="fas fa-info-circle"></i>
        @elseif($type === 'warning')
            <i class="fas fa-exclamation-triangle"></i>
        @endif
    </div>

    <div class="notification-content">
        <h4 class="notification-title">
            @if($notification)
                {{ $notification->title }}
            @else
                @if($type === 'success') 🎉 Congratulations!
                @elseif($type === 'info') 📢 Great Progress!
                @elseif($type === 'warning') ⏰ Keep Going!
                @endif
            @endif
        </h4>
        <p class="notification-message">
            @if($notification)
                {{ $notification->message }}
            @else
                {{ $message }}
            @endif
        </p>
    </div>

    @if($action)
        <div class="notification-actions">
            <a href="{{ $action['url'] }}" class="notification-btn">
                <i class="fas {{ $action['icon'] ?? 'fa-arrow-right' }}"></i>
                {{ $action['text'] }}
            </a>
        </div>
    @endif

    <button class="notification-close" onclick="this.closest('.milestone-notification').remove()">
        <i class="fas fa-times"></i>
    </button>
</div>

<style>
.milestone-notification {
    position: relative;
    background: white;
    border-radius: 16px;
    padding: 20px;
    margin-bottom: 20px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    gap: 15px;
    animation: slideDown 0.5s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.milestone-notification.success {
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border-color: #bbf7d0;
}

.milestone-notification.info {
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    border-color: #bae6fd;
}

.milestone-notification.warning {
    background: linear-gradient(135deg, #fffbeb, #fef3c7);
    border-color: #fde68a;
}

.notification-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    flex-shrink: 0;
}

.success .notification-icon {
    background: #10b981;
    color: white;
}

.info .notification-icon {
    background: #3182ce;
    color: white;
}

.warning .notification-icon {
    background: #f59e0b;
    color: white;
}

.notification-content {
    flex: 1;
}

.notification-title {
    font-size: 16px;
    font-weight: 600;
    margin: 0 0 5px 0;
}

.success .notification-title {
    color: #166534;
}

.info .notification-title {
    color: #1e40af;
}

.warning .notification-title {
    color: #92400e;
}

.notification-message {
    font-size: 14px;
    margin: 0;
    line-height: 1.5;
}

.success .notification-message {
    color: #166534;
}

.info .notification-message {
    color: #1e40af;
}

.warning .notification-message {
    color: #92400e;
}

.notification-actions {
    margin-left: 15px;
}

.notification-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: white;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.success .notification-btn {
    color: #166534;
    border: 1px solid #bbf7d0;
}

.success .notification-btn:hover {
    background: #166534;
    color: white;
    border-color: #166534;
}

.info .notification-btn {
    color: #1e40af;
    border: 1px solid #bae6fd;
}

.info .notification-btn:hover {
    background: #1e40af;
    color: white;
    border-color: #1e40af;
}

.warning .notification-btn {
    color: #92400e;
    border: 1px solid #fde68a;
}

.warning .notification-btn:hover {
    background: #92400e;
    color: white;
    border-color: #92400e;
}

.notification-close {
    position: absolute;
    top: 10px;
    right: 10px;
    background: none;
    border: none;
    color: inherit;
    cursor: pointer;
    padding: 5px;
    font-size: 14px;
    opacity: 0.6;
    transition: opacity 0.3s ease;
}

.notification-close:hover {
    opacity: 1;
}

@media (max-width: 768px) {
    .milestone-notification {
        flex-direction: column;
        text-align: center;
        padding: 20px 15px;
    }
    
    .notification-actions {
        margin-left: 0;
        margin-top: 10px;
    }
    
    .notification-btn {
        white-space: normal;
    }
}
</style>