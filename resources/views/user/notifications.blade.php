@extends('layouts.app')

@section('title', 'Notifications')
@section('body-class', 'auth-page')

@section('styles')
<style>
    /* Full width layout */
    body.auth-page {
        background-color: #f8fbff;
        min-height: 100vh;
    }

    .notifications-container {
        width: 100%;
        max-width: 100%;
        padding: 30px 40px;
        margin: 0;
        box-sizing: border-box;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 20px;
        border-bottom: 1px solid #e2e8f0;
    }

    .page-title {
        font-size: 28px;
        font-weight: bold;
        color: #2D3E50;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-actions {
        display: flex;
        gap: 12px;
    }

    .btn-action {
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-mark-all {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e0;
    }

    .btn-mark-all:hover {
        background: #e2e8f0;
    }

    .btn-clear-all {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .btn-clear-all:hover {
        background: #fecaca;
    }

    .btn-messages {
        background: #2563eb;
        color: white;
    }

    .btn-messages:hover {
        background: #1d4ed8;
    }

    .message-badge {
        background: #ef4444;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        margin-left: 5px;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 25px 20px;
        border: 1px solid #e2e8f0;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        border-color: #2D3E50;
    }

    .stat-value {
        display: block;
        font-size: 32px;
        font-weight: 700;
        color: #2D3E50;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 13px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Message Link */
    .message-link {
        display: flex;
        align-items: center;
        gap: 15px;
        background: linear-gradient(135deg, #f0f9ff 0%, #e6f0fa 100%);
        border: 1px solid #bae6fd;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 25px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .message-link:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(37, 99, 235, 0.1);
    }

    .message-icon {
        width: 50px;
        height: 50px;
        background: #2563eb;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
    }

    .message-content {
        flex: 1;
    }

    .message-content h3 {
        color: #1e40af;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .message-content p {
        color: #3b82f6;
        font-size: 13px;
    }

    .message-badge-large {
        background: #ef4444;
        color: white;
        padding: 5px 15px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
    }

    /* Filter Tabs */
    .filter-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        overflow-x: auto;
        padding-bottom: 5px;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 10px 20px;
        border-radius: 30px;
        background: #f8fafc;
        color: #475569;
        font-size: 14px;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .filter-tab.active {
        background: #2D3E50;
        color: white;
        border-color: #2D3E50;
    }

    .filter-tab .badge {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 11px;
        min-width: 20px;
        text-align: center;
    }

    .filter-tab:not(.active) .badge {
        background: #2D3E50;
        color: white;
    }

    /* Notifications List */
    .notifications-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 30px;
    }

    .notification-item {
        background: white;
        border-radius: 12px;
        padding: 25px;
        border: 1px solid #e2e8f0;
        display: flex;
        gap: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        width: 100%;
        box-sizing: border-box;
    }

    .notification-item:hover {
        border-color: #2D3E50;
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .notification-item.unread {
        background: #f0f9ff;
        border-left: 4px solid #2563eb;
    }

    .notification-icon {
        width: 50px;
        height: 50px;
        background: #f1f5f9;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        font-size: 20px;
        flex-shrink: 0;
    }

    .notification-item.unread .notification-icon {
        background: #dbeafe;
        color: #2563eb;
    }

    .notification-content {
        flex: 1;
    }

    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 8px;
    }

    .notification-title {
        font-size: 16px;
        font-weight: 600;
        color: #2D3E50;
    }

    .notification-time {
        font-size: 13px;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .notification-message {
        color: #475569;
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 12px;
    }

    .notification-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .notification-type {
        background: #f1f5f9;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .notification-actions {
        display: flex;
        gap: 10px;
    }

    .action-btn {
        background: none;
        border: none;
        font-size: 13px;
        cursor: pointer;
        padding: 6px 12px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s ease;
        z-index: 10;
        position: relative;
    }

    .mark-read-btn {
        color: #2563eb;
    }

    .mark-read-btn:hover {
        background: #dbeafe;
    }

    .delete-btn {
        color: #dc2626;
    }

    .delete-btn:hover {
        background: #fee2e2;
    }

    .unread-dot {
        width: 10px;
        height: 10px;
        background: #2563eb;
        border-radius: 50%;
        position: absolute;
        top: 25px;
        right: 25px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.2);
            opacity: 0.7;
        }
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        width: 100%;
        box-sizing: border-box;
    }

    .empty-icon {
        font-size: 64px;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .empty-title {
        font-size: 20px;
        color: #2D3E50;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .empty-text {
        color: #64748b;
        font-size: 15px;
        margin-bottom: 25px;
    }

    .btn-primary {
        display: inline-block;
        padding: 12px 30px;
        background: #2D3E50;
        color: white;
        text-decoration: none;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(45, 62, 80, 0.2);
    }

    /* Load More */
    .load-more {
        text-align: center;
        margin-top: 20px;
    }

    .load-more-btn {
        padding: 12px 30px;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .load-more-btn:hover:not(:disabled) {
        background: #2D3E50;
        color: white;
        border-color: #2D3E50;
    }

    .load-more-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .notifications-container {
            padding: 20px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .page-header {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .header-actions {
            width: 100%;
            flex-wrap: wrap;
        }

        .notification-item {
            flex-direction: column;
        }

        .notification-header {
            flex-direction: column;
            gap: 5px;
        }

        .notification-footer {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }

        .filter-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            justify-content: flex-start;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

</style>
@endsection

@section('content')
<div class="notifications-container">
    <!-- Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-bell" style="color: #2D3E50;"></i>
            Notifications
        </h1>
        <div class="header-actions">
            <a href="{{ route('messages.inbox') }}" class="btn-action btn-messages">
                <i class="fas fa-envelope"></i> Messages
                @if($unreadMessages > 0)
                <span class="message-badge">{{ $unreadMessages }}</span>
                @endif
            </a>
            <button class="btn-action btn-mark-all" onclick="markAllAsRead()">
                <i class="fas fa-check-double"></i> Mark All Read
            </button>
            <button class="btn-action btn-clear-all" onclick="clearAllNotifications()">
                <i class="fas fa-trash"></i> Clear All
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-value" id="totalCount">{{ $totalNotifications }}</span>
            <span class="stat-label">Total</span>
        </div>
        <div class="stat-card">
            <span class="stat-value" id="unreadCount">{{ $unreadCount }}</span>
            <span class="stat-label">Unread</span>
        </div>
        <div class="stat-card">
            <span class="stat-value" id="todayCount">{{ $todayCount }}</span>
            <span class="stat-label">Today</span>
        </div>
        <div class="stat-card">
            <span class="stat-value" id="weekCount">{{ $weekCount }}</span>
            <span class="stat-label">This Week</span>
        </div>
        <div class="stat-card">
            <span class="stat-value" id="messageCount">{{ $unreadMessages }}</span>
            <span class="stat-label">Messages</span>
        </div>
    </div>

    <!-- Message Link - Only shows if there are unread messages -->
    @if($unreadMessages > 0)
    <a href="{{ route('messages.inbox') }}" class="message-link">
        <div class="message-icon">
            <i class="fas fa-envelope-open-text"></i>
        </div>
        <div class="message-content">
            <h3>You have {{ $unreadMessages }} unread message{{ $unreadMessages > 1 ? 's' : '' }}</h3>
            <p>Click to view and reply to your messages</p>
        </div>
        <span class="message-badge-large">{{ $unreadMessages }} new</span>
    </a>
    @endif

    <!-- Filter Tabs - Now with ALL counts from database -->
    <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterNotifications('all')">
            <i class="fas fa-bell"></i> All
            <span class="badge" id="totalBadge">{{ $totalNotifications }}</span>
        </button>
        <button class="filter-tab" onclick="filterNotifications('unread')">
            <i class="fas fa-circle"></i> Unread
            <span class="badge" id="unreadBadge">{{ $unreadCount }}</span>
        </button>
        <button class="filter-tab" onclick="filterNotifications('today')">
            <i class="fas fa-calendar-day"></i> Today
            <span class="badge" id="todayBadge">{{ $todayCount }}</span>
        </button>
        <button class="filter-tab" onclick="filterNotifications('message')">
            <i class="fas fa-envelope"></i> Messages
            <span class="badge" id="messageTypeBadge">{{ $messageTypeCount }}</span>
        </button>
        <button class="filter-tab" onclick="filterNotifications('course')">
            <i class="fas fa-book"></i> Courses
            <span class="badge" id="courseBadge">{{ $courseCount }}</span>
        </button>
        <button class="filter-tab" onclick="filterNotifications('system')">
            <i class="fas fa-cog"></i> System
            <span class="badge" id="systemBadge">{{ $systemCount }}</span>
        </button>
        <button class="filter-tab" onclick="filterNotifications('enrollment')">
            <i class="fas fa-user-plus"></i> Enrollment
            <span class="badge" id="enrollmentBadge">{{ $enrollmentCount }}</span>
        </button>
        <button class="filter-tab" onclick="filterNotifications('progress')">
            <i class="fas fa-chart-line"></i> Progress
            <span class="badge" id="progressBadge">{{ $progressCount }}</span>
        </button>
        <button class="filter-tab" onclick="filterNotifications('achievement')">
            <i class="fas fa-trophy"></i> Achievement
            <span class="badge" id="achievementBadge">{{ $achievementCount }}</span>
        </button>
        <button class="filter-tab" onclick="filterNotifications('reminder')">
            <i class="fas fa-clock"></i> Reminder
            <span class="badge" id="reminderBadge">{{ $reminderCount }}</span>
        </button>
    </div>

    <!-- Notifications List Container -->
    <div id="notificationsContainer">
        @if($notifications->count() > 0)
        <div class="notifications-list" id="notificationsList">
            @foreach($notifications as $notification)
            <div class="notification-item {{ !$notification->is_read ? 'unread' : '' }}" data-id="{{ $notification->id }}" data-type="{{ $notification->type }}" data-date="{{ $notification->created_at->format('Y-m-d') }}">

                @if(!$notification->is_read)
                <div class="unread-dot"></div>
                @endif

                <div class="notification-icon">
                    <i class="fas fa-{{ $notification->type_icon ?? 'bell' }}"></i>
                </div>

                <div class="notification-content">
                    <div class="notification-header">
                        <span class="notification-title">{{ $notification->title }}</span>
                        <span class="notification-time">
                            <i class="fas fa-clock"></i> {{ $notification->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <div class="notification-message">
                        {{ $notification->message }}
                    </div>

                    <div class="notification-footer">
                        <span class="notification-type">
                            <i class="fas fa-tag"></i> {{ ucfirst($notification->type) }}
                        </span>
                        <div class="notification-actions">
                            @if(!$notification->is_read)
                            <button class="action-btn mark-read-btn" onclick="markAsRead({{ $notification->id }}, this)">
                                <i class="fas fa-check"></i> Mark Read
                            </button>
                            @endif
                            <button class="action-btn delete-btn" onclick="deleteNotification({{ $notification->id }}, this, event)">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($notifications->hasMorePages())
        <div class="load-more" id="loadMoreContainer">
            <button class="load-more-btn" onclick="loadMoreNotifications()" id="loadMoreBtn">
                <i class="fas fa-spinner fa-spin" id="loadSpinner" style="display: none;"></i>
                <span id="loadText">Load More Notifications</span>
            </button>
        </div>
        @endif
        @else
        <div class="empty-state" id="emptyState">
            <div class="empty-icon">
                <i class="far fa-bell-slash"></i>
            </div>
            <h3 class="empty-title">No Notifications</h3>
            <p class="empty-text">You're all caught up! New notifications will appear here when you have updates.</p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <a href="{{ route('courses.public') }}" class="btn-primary">
                    <i class="fas fa-book-open"></i> Browse Courses
                </a>
                <a href="{{ route('messages.inbox') }}" class="btn-primary" style="background: #2563eb;">
                    <i class="fas fa-envelope"></i> Messages
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // NOTIFICATIONS JAVASCRIPT
    let currentPage = {{ $notifications->currentPage() }};
    let lastPage = {{ $notifications->lastPage() }};
    let isLoading = false;
    let currentFilter = 'all';

    // Store initial counts from database
    let counts = {
        total: {{ $totalNotifications }},
        unread: {{ $unreadCount }},
        today: {{ $todayCount }},
        week: {{ $weekCount }},
        messages: {{ $unreadMessages }},
        messageType: {{ $messageTypeCount }},
        course: {{ $courseCount }},
        system: {{ $systemCount }},
        enrollment: {{ $enrollmentCount }},
        progress: {{ $progressCount }},
        achievement: {{ $achievementCount }},
        reminder: {{ $reminderCount }}
    };

    console.log('Notifications loaded:', counts);

    // ========== UPDATE STATS ==========
    function updateStats(type, change) {
        // Update the counts object
        if (counts[type] !== undefined) {
            counts[type] = Math.max(0, counts[type] + change);
        }

        // Update stat cards
        const statMap = {
            'total': 'totalCount',
            'unread': 'unreadCount',
            'today': 'todayCount',
            'week': 'weekCount',
            'messages': 'messageCount'
        };

        if (statMap[type]) {
            const element = document.getElementById(statMap[type]);
            if (element) element.textContent = counts[type];
        }

        // Update badges
        const badgeMap = {
            'total': 'totalBadge',
            'unread': 'unreadBadge',
            'today': 'todayBadge',
            'messageType': 'messageTypeBadge',
            'course': 'courseBadge',
            'system': 'systemBadge',
            'enrollment': 'enrollmentBadge',
            'progress': 'progressBadge',
            'achievement': 'achievementBadge',
            'reminder': 'reminderBadge'
        };

        if (badgeMap[type]) {
            const element = document.getElementById(badgeMap[type]);
            if (element) element.textContent = counts[type];
        }

        // Update message link if it exists
        if (type === 'messages') {
            updateMessageLink();
        }
    }

    // ========== UPDATE MESSAGE LINK ==========
    function updateMessageLink() {
        const messageLink = document.querySelector('.message-link');
        const messageCount = counts.messages;

        if (messageCount > 0) {
            if (messageLink) {
                // Update existing link
                const badge = messageLink.querySelector('.message-badge-large');
                const title = messageLink.querySelector('h3');
                if (badge) badge.textContent = messageCount + ' new';
                if (title) title.textContent = `You have ${messageCount} unread message${messageCount > 1 ? 's' : ''}`;
            }
        } else {
            // Remove link if it exists and count is 0
            if (messageLink) messageLink.remove();
        }
    }

    // ========== MARK AS READ (SINGLE) ==========
    function markAsRead(id, btn) {
        if (event) event.stopPropagation();

        const item = btn.closest('.notification-item');
        const wasUnread = item.classList.contains('unread');

        // Visual feedback
        item.classList.remove('unread');
        const dot = item.querySelector('.unread-dot');
        if (dot) dot.remove();
        btn.style.display = 'none';

        // Update stats
        if (wasUnread) {
            updateStats('unread', -1);
        }

        // Send request
        fetch(`/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Notification marked as read:', id);
                // Apply current filter to possibly hide this item
                applyFilter(currentFilter);
            }
        })
        .catch(err => console.log('Error marking as read:', err));
    }

    // ========== MARK ALL AS READ ==========
    function markAllAsRead() {
        Swal.fire({
            title: 'Mark all as read?',
            text: 'This will mark all notifications as read.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2d3e50',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, mark all',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Visual feedback
                document.querySelectorAll('.notification-item.unread').forEach(item => {
                    item.classList.remove('unread');
                    const dot = item.querySelector('.unread-dot');
                    if (dot) dot.remove();
                    const btn = item.querySelector('.mark-read-btn');
                    if (btn) btn.style.display = 'none';
                });

                // Update stats
                const currentUnread = counts.unread;
                updateStats('unread', -currentUnread);

                // Send request
                fetch('/notifications/read-all', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Done!',
                            text: 'All notifications marked as read',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        // Apply current filter
                        applyFilter(currentFilter);
                    }
                })
                .catch(err => console.log('Error:', err));
            }
        });
    }

    // ========== DELETE NOTIFICATION (SINGLE) ==========
    function deleteNotification(id, btn, evt) {
        if (evt) evt.stopPropagation();
        if (event) event.stopPropagation();

        Swal.fire({
            title: 'Delete notification?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Deleting...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const item = btn.closest('.notification-item');
                const wasUnread = item.classList.contains('unread');
                const type = item.dataset.type;

                // Send delete request
                fetch(`/notifications/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Swal.close();

                    if (data.success) {
                        // Update stats
                        updateStats('total', -1);
                        updateStats(type, -1);
                        if (wasUnread) {
                            updateStats('unread', -1);
                        }

                        // Check if it's today
                        const today = new Date().toISOString().split('T')[0];
                        if (item.dataset.date === today) {
                            updateStats('today', -1);
                        }

                        // Remove from UI
                        item.style.transition = 'opacity 0.3s ease';
                        item.style.opacity = '0';

                        setTimeout(() => {
                            item.remove();

                            // Check if list is empty
                            if (document.querySelectorAll('.notification-item').length === 0) {
                                showEmptyState();
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }, 300);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to delete notification',
                            confirmButtonColor: '#2d3e50'
                        });
                    }
                })
                .catch(err => {
                    console.error('Delete error:', err);
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to connect to server',
                        confirmButtonColor: '#2d3e50'
                    });
                });
            }
        });
    }

    // ========== CLEAR ALL NOTIFICATIONS ==========
    function clearAllNotifications() {
        Swal.fire({
            title: 'Clear all notifications?',
            text: 'This will permanently delete ALL notifications.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, clear all',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Clearing...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Send request to delete ALL
                fetch('/notifications', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to clear notifications',
                            confirmButtonColor: '#2d3e50'
                        });
                    }
                })
                .catch(err => {
                    console.error('Clear all error:', err);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to connect to server',
                        confirmButtonColor: '#2d3e50'
                    });
                });
            }
        });
    }

    // ========== APPLY FILTER ==========
    function applyFilter(filter) {
        const items = document.querySelectorAll('.notification-item');
        let visibleCount = 0;

        items.forEach(item => {
            const type = item.dataset.type;
            const date = item.dataset.date;
            const isUnread = item.classList.contains('unread');
            const today = new Date().toISOString().split('T')[0];

            let shouldShow = true;

            if (filter === 'all') {
                shouldShow = true;
            } else if (filter === 'unread') {
                shouldShow = isUnread;
            } else if (filter === 'today') {
                shouldShow = date === today;
            } else {
                shouldShow = type === filter;
            }

            item.style.display = shouldShow ? 'flex' : 'none';
            if (shouldShow) visibleCount++;
        });

        // Hide load more if no items visible or all pages loaded
        const loadMoreContainer = document.getElementById('loadMoreContainer');
        if (loadMoreContainer) {
            if (visibleCount === 0 || currentPage >= lastPage) {
                loadMoreContainer.style.display = 'none';
            } else {
                loadMoreContainer.style.display = 'block';
            }
        }
    }

    // ========== FILTER NOTIFICATIONS ==========
    function filterNotifications(filter) {
        const tabs = document.querySelectorAll('.filter-tab');

        tabs.forEach(tab => tab.classList.remove('active'));
        event.target.classList.add('active');

        currentFilter = filter;
        applyFilter(filter);
    }

    // ========== SHOW EMPTY STATE ==========
    function showEmptyState() {
        const container = document.getElementById('notificationsContainer');
        container.innerHTML = `
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="far fa-bell-slash"></i>
                </div>
                <h3 class="empty-title">No Notifications</h3>
                <p class="empty-text">You're all caught up! New notifications will appear here when you have updates.</p>
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <a href="{{ route('courses.public') }}" class="btn-primary">
                        <i class="fas fa-book-open"></i> Browse Courses
                    </a>
                    <a href="{{ route('messages.inbox') }}" class="btn-primary" style="background: #2563eb;">
                        <i class="fas fa-envelope"></i> Messages
                    </a>
                </div>
            </div>
        `;
    }

    // ========== LOAD MORE ==========
    function loadMoreNotifications() {
        if (isLoading || currentPage >= lastPage) return;

        isLoading = true;
        const btn = document.getElementById('loadMoreBtn');
        const spinner = document.getElementById('loadSpinner');
        const loadText = document.getElementById('loadText');

        spinner.style.display = 'inline-block';
        loadText.textContent = 'Loading...';
        btn.disabled = true;

        fetch(`?page=${currentPage + 1}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newItems = doc.querySelectorAll('.notification-item');
            const newLoadMore = doc.querySelector('.load-more');

            newItems.forEach(item => {
                document.getElementById('notificationsList').appendChild(item);
            });

            currentPage++;

            // Re-apply current filter to new items
            applyFilter(currentFilter);

            // Update lastPage from response
            const newLastPage = doc.querySelector('[data-last-page]')?.dataset.lastPage;
            if (newLastPage) {
                lastPage = parseInt(newLastPage);
            }

            // Hide load more if no more pages or no items visible
            if (currentPage >= lastPage || !newLoadMore) {
                document.getElementById('loadMoreContainer').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to load more notifications',
                confirmButtonColor: '#2d3e50'
            });
        })
        .finally(() => {
            spinner.style.display = 'none';
            loadText.textContent = 'Load More Notifications';
            btn.disabled = false;
            isLoading = false;
        });
    }

    // ========== INITIALIZE ==========
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Notifications page ready with counts:', counts);

        // Apply initial filter
        applyFilter('all');

        // Make notification items clickable (but not on buttons)
        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', function(e) {
                if (e.target.closest('button')) return;

                const id = this.dataset.id;
                if (id && this.classList.contains('unread')) {
                    const btn = this.querySelector('.mark-read-btn');
                    if (btn) markAsRead(id, btn);
                }
            });
        });
    });

    // Listen for notification count updates from central service
    if (typeof NotificationService !== 'undefined') {
        NotificationService.onCountChange(function(count) {
            console.log('Unread count updated from service:', count);

            // Update the unread count display if it exists
            const unreadStat = document.getElementById('unreadCount');
            if (unreadStat) {
                unreadStat.textContent = count;
            }

            const unreadBadge = document.getElementById('unreadBadge');
            if (unreadBadge) {
                unreadBadge.textContent = count;
            }

            // Update counts object if it exists
            if (typeof counts !== 'undefined' && counts) {
                counts.unread = count;
            }
        });
    }
</script>
@endsection