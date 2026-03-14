@extends('layouts.app')

@section('title', 'Messages - Sent')
@section('body-class', 'messages-page')

@section('styles')
<style>
    :root {
        --primary-navy: #2d3e50;
        --secondary-blue: #3182ce;
        --success-green: #10b981;
        --warning-orange: #f59e0b;
        --danger-red: #ef4444;
        --text-dark: #1e293b;
        --text-gray: #64748b;
        --text-light: #94a3b8;
        --bg-light: #f8fbff;
        --white: #ffffff;
        --border-color: #e2e8f0;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --radius-sm: 0.375rem;
        --radius-md: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
    }

    /* Full width layout */
    body.messages-page {
        background-color: #f8fbff;
        min-height: 100vh;
    }

    .messages-container {
        width: 100%;
        max-width: 100%;
        padding: 30px 40px;
        margin: 0;
        padding-bottom: 100px;
        box-sizing: border-box;
    }

    /* Header Styles - Full width gradient */
    .page-header {
        background: linear-gradient(135deg, var(--primary-navy) 0%, #1a252f 100%);
        border-radius: var(--radius-xl);
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: var(--shadow-lg);
        color: var(--white);
        width: 100%;
        box-sizing: border-box;
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title i {
        color: #93c5fd;
    }

    .header-actions {
        display: flex;
        gap: 12px;
    }

    .btn {
        padding: 10px 20px;
        border-radius: var(--radius-lg);
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background: var(--white);
        color: var(--primary-navy);
    }

    .btn-primary:hover {
        background: #f1f5f9;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-outline {
        background: rgba(255, 255, 255, 0.1);
        color: var(--white);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .btn-outline:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    /* Stats Cards - Full width grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
        width: 100%;
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
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 25px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-navy);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: var(--radius-md);
        background: #f0f7ff;
        color: var(--primary-navy);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        display: block;
        font-size: 28px;
        font-weight: 700;
        color: var(--primary-navy);
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 12px;
        color: var(--text-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Tabs - Main navigation */
    .tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 10px;
        width: 100%;
    }

    .tab {
        padding: 10px 20px;
        text-decoration: none;
        color: var(--text-gray);
        font-weight: 500;
        border-radius: var(--radius-md) var(--radius-md) 0 0;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .tab:hover {
        color: var(--primary-navy);
        background: #f8fafc;
    }

    .tab.active {
        color: var(--primary-navy);
        border-bottom-color: var(--primary-navy);
        background: #f8fafc;
        font-weight: 600;
    }

    .tab-badge {
        background: #e2e8f0;
        color: var(--text-dark);
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .tab.active .tab-badge {
        background: var(--primary-navy);
        color: var(--white);
    }

    /* Filter Tabs - Secondary navigation (ALL/READ/PENDING) */
    .filter-tabs {
        display: flex;
        gap: 10px;
        margin: 20px 0 25px 0;
        width: 100%;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 8px 24px;
        border-radius: 30px;
        background: #f1f5f9;
        color: var(--text-gray);
        font-size: 14px;
        font-weight: 500;
        border: 1px solid var(--border-color);
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .filter-tab:hover {
        background: #e2e8f0;
        color: var(--primary-navy);
        border-color: var(--primary-navy);
    }

    .filter-tab.active {
        background: var(--primary-navy);
        color: var(--white);
        border-color: var(--primary-navy);
    }

    .filter-tab i {
        font-size: 12px;
    }

    @media (max-width: 768px) {
        .filter-tabs {
            justify-content: center;
        }
    }

    /* Messages List - Full width */
    .messages-list {
        background: var(--white);
        border-radius: var(--radius-xl);
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        margin-bottom: 30px;
        width: 100%;
    }

    .message-item {
        display: flex;
        align-items: center;
        padding: 25px 30px;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.3s ease;
        width: 100%;
        box-sizing: border-box;
    }

    .message-item:last-child {
        border-bottom: none;
    }

    .message-item:hover {
        background: #f8fafc;
        transform: translateX(5px);
    }

    .avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-navy), #1a252f);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 20px;
        margin-right: 20px;
        flex-shrink: 0;
        box-shadow: var(--shadow-md);
    }

    .message-content {
        flex: 1;
    }

    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .receiver-name {
        font-weight: 600;
        color: var(--primary-navy);
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .role-badge {
        padding: 3px 10px;
        border-radius: 30px;
        font-size: 10px;
        font-weight: 600;
        color: var(--white);
    }

    .role-badge.instructor {
        background: #065f46;
    }

    .role-badge.student {
        background: #7c3aed;
    }

    .role-badge.admin {
        background: #1e40af;
    }

    .time {
        font-size: 12px;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .message-text {
        color: var(--text-gray);
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 12px;
        padding-right: 20px;
    }

    .message-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .course-badge {
        background: #f1f5f9;
        color: var(--primary-navy);
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .course-badge i {
        color: var(--text-gray);
    }

    .read-status {
        font-size: 12px;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .read-status i {
        font-size: 12px;
    }

    .read-status.read i {
        color: var(--success-green);
    }

    .read-status.delivered i {
        color: var(--text-light);
    }

    /* Empty State - Full width */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: var(--white);
        border-radius: var(--radius-xl);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
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
        color: var(--primary-navy);
        margin-bottom: 10px;
        font-weight: 600;
    }

    .empty-text {
        color: var(--text-gray);
        margin-bottom: 25px;
        font-size: 15px;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    .btn-primary-lg {
        display: inline-block;
        padding: 12px 30px;
        background: var(--primary-navy);
        color: var(--white);
        text-decoration: none;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary-lg:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 30px;
        width: 100%;
    }

    .pagination {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination a, .pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 10px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        background: var(--white);
        color: var(--text-gray);
        text-decoration: none;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .pagination a:hover {
        background: var(--primary-navy);
        color: var(--white);
        border-color: var(--primary-navy);
        transform: translateY(-2px);
    }

    .pagination .active span {
        background: var(--primary-navy);
        color: var(--white);
        border-color: var(--primary-navy);
        font-weight: 600;
    }

    /* Animation for new messages */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .message-item {
        animation: slideIn 0.3s ease;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .messages-container {
            padding: 15px;
        }

        .header-top {
            flex-direction: column;
            gap: 15px;
            align-items: flex-start;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .message-item {
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }

        .avatar {
            margin-right: 0;
            margin-bottom: 15px;
        }

        .message-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .tabs {
            overflow-x: auto;
            padding-bottom: 5px;
            flex-wrap: nowrap;
        }

        .tab {
            white-space: nowrap;
        }

        .filter-tabs {
            justify-content: flex-start;
            overflow-x: auto;
            padding-bottom: 5px;
            flex-wrap: nowrap;
        }

        .filter-tab {
            white-space: nowrap;
        }

        .message-footer {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
    }
</style>
@endsection

@section('content')
<div class="messages-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-top">
            <h1 class="page-title">
                <i class="fas fa-paper-plane"></i>
                Sent Messages
            </h1>
            <div class="header-actions">
                <a href="{{ route('messages.inbox') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Back to Inbox
                </a>
            </div>
        </div>

        <!-- Stats with real-time IDs -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-value" id="totalSent">{{ $messages->total() }}</span>
                    <span class="stat-label">Total Sent</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-value" id="readCount">{{ $messages->where('is_read', true)->count() }}</span>
                    <span class="stat-label">Read</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-value" id="pendingCount">{{ $messages->where('is_read', false)->count() }}</span>
                    <span class="stat-label">Pending</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-value" id="recipientCount">{{ $messages->groupBy('receiver_id')->count() }}</span>
                    <span class="stat-label">Recipients</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Tabs (Inbox/Sent) -->
    <div class="tabs">
        <a href="{{ route('messages.inbox') }}" class="tab" id="inboxTab">
            <i class="fas fa-inbox"></i>
            Inbox
            @if(isset($unreadCount) && $unreadCount > 0)
                <span class="tab-badge" id="inboxUnreadBadge">{{ $unreadCount }}</span>
            @endif
        </a>
        <a href="{{ route('messages.sent') }}" class="tab active" id="sentTab">
            <i class="fas fa-paper-plane"></i>
            Sent
            <span class="tab-badge" id="sentTotalBadge">{{ $messages->total() }}</span>
        </a>
    </div>

    <!-- Filter Tabs (All/Read/Pending) - FIXED: Now in one line -->
    <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterMessages('all')" id="filterAll">
            <i class="fas fa-list"></i> All
        </button>
        <button class="filter-tab" onclick="filterMessages('read')" id="filterRead">
            <i class="fas fa-check-double"></i> Read
        </button>
        <button class="filter-tab" onclick="filterMessages('pending')" id="filterPending">
            <i class="fas fa-clock"></i> Pending
        </button>
    </div>

    <!-- Messages List -->
    @if($messages->count() > 0)
        <div class="messages-list" id="messagesList">
            @foreach($messages as $message)
                <div class="message-item" data-message-id="{{ $message->id }}" data-receiver-id="{{ $message->receiver_id }}" data-is-read="{{ $message->is_read ? 'true' : 'false' }}">
                    <div class="avatar">
                        {{ substr($message->receiver->name, 0, 1) }}
                    </div>
                    
                    <div class="message-content">
                        <div class="message-header">
                            <span class="receiver-name">
                                To: {{ $message->receiver->name }}
                                @if($message->receiver->hasRole('instructor'))
                                    <span class="role-badge instructor">Instructor</span>
                                @elseif($message->receiver->hasRole('student'))
                                    <span class="role-badge student">Student</span>
                                @elseif($message->receiver->hasRole('admin'))
                                    <span class="role-badge admin">Admin</span>
                                @endif
                            </span>
                            <span class="time">
                                <i class="fas fa-clock"></i> {{ $message->created_at->format('M d, Y - h:i A') }}
                            </span>
                        </div>
                        
                        <div class="message-text">
                            {{ Str::limit($message->message, 200) }}
                        </div>
                        
                        <div class="message-footer">
                            @if($message->course)
                                <span class="course-badge">
                                    <i class="fas fa-book"></i> {{ $message->course->title }}
                                </span>
                            @else
                                <span></span>
                            @endif
                            
                            <span class="read-status {{ $message->is_read ? 'read' : 'delivered' }}" id="readStatus-{{ $message->id }}">
                                @if($message->is_read)
                                    <i class="fas fa-check-double"></i> Read {{ $message->read_at ? $message->read_at->diffForHumans() : '' }}
                                @else
                                    <i class="fas fa-check"></i> Delivered
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            <div class="pagination">
                {{ $messages->links() }}
            </div>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="far fa-paper-plane"></i>
            </div>
            <h3 class="empty-title">No Sent Messages</h3>
            <p class="empty-text">You haven't sent any messages yet. Start a conversation with an instructor or student.</p>
            <a href="{{ route('courses.public') }}" class="btn-primary-lg">
                <i class="fas fa-book-open"></i> Browse Courses
            </a>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // SENT MESSAGES PAGE - REAL-TIME UPDATES
    let currentStats = {
        total: {{ $messages->total() }},
        read: {{ $messages->where('is_read', true)->count() }},
        pending: {{ $messages->where('is_read', false)->count() }},
        recipients: {{ $messages->groupBy('receiver_id')->count() }}
    };

    let currentFilter = 'all';

    console.log('Sent messages loaded:', currentStats);

    // UPDATE MESSAGE READ STATUS
    function updateMessageReadStatus(messageId, isRead, readAt) {
        const statusElement = document.getElementById(`readStatus-${messageId}`);
        if (!statusElement) return;

        const wasRead = statusElement.classList.contains('read');
        const messageElement = document.querySelector(`.message-item[data-message-id="${messageId}"]`);
        
        if (isRead && !wasRead) {
            // Update visual
            statusElement.classList.remove('delivered');
            statusElement.classList.add('read');
            statusElement.innerHTML = `<i class="fas fa-check-double"></i> Read ${readAt ? formatTimeAgo(readAt) : ''}`;
            
            // Update message data attribute
            if (messageElement) {
                messageElement.dataset.isRead = 'true';
            }
            
            // Update stats
            updateStats('read', 1);
            updateStats('pending', -1);
            
            // Re-apply current filter if needed
            if (currentFilter !== 'all') {
                filterMessages(currentFilter);
            }
        }
    }

    // UPDATE STATS
    function updateStats(type, change) {
        const element = document.getElementById(type === 'read' ? 'readCount' : 
                                          type === 'pending' ? 'pendingCount' : 
                                          type === 'total' ? 'totalSent' : 
                                          'recipientCount');
        
        if (element) {
            currentStats[type] = Math.max(0, currentStats[type] + change);
            element.textContent = currentStats[type];
        }

        // Update sent tab badge
        const sentBadge = document.getElementById('sentTotalBadge');
        if (sentBadge) {
            sentBadge.textContent = currentStats.total;
        }
    }

    // FORMAT TIME AGO
    function formatTimeAgo(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();
        const diffMs = now - date;
        const diffMins = Math.floor(diffMs / 60000);
        const diffHours = Math.floor(diffMins / 60);
        const diffDays = Math.floor(diffHours / 24);

        if (diffMins < 1) return 'just now';
        if (diffMins < 60) return diffMins + ' minute' + (diffMins > 1 ? 's' : '') + ' ago';
        if (diffHours < 24) return diffHours + ' hour' + (diffHours > 1 ? 's' : '') + ' ago';
        if (diffDays < 7) return diffDays + ' day' + (diffDays > 1 ? 's' : '') + ' ago';
        
        return date.toLocaleDateString();
    }

    // FILTER MESSAGES
    function filterMessages(filter) {
        currentFilter = filter;
        
        const messages = document.querySelectorAll('.message-item');
        const filterTabs = document.querySelectorAll('.filter-tab');
        let visibleCount = 0;

        // Update active tab
        filterTabs.forEach(tab => {
            tab.classList.remove('active');
            if (tab.id === `filter${filter.charAt(0).toUpperCase() + filter.slice(1)}`) {
                tab.classList.add('active');
            }
        });

        messages.forEach(msg => {
            const isRead = msg.dataset.isRead === 'true';
            
            if (filter === 'all') {
                msg.style.display = 'flex';
                visibleCount++;
            } else if (filter === 'read') {
                if (isRead) {
                    msg.style.display = 'flex';
                    visibleCount++;
                } else {
                    msg.style.display = 'none';
                }
            } else if (filter === 'pending') {
                if (!isRead) {
                    msg.style.display = 'flex';
                    visibleCount++;
                } else {
                    msg.style.display = 'none';
                }
            }
        });

        // Show/hide empty state based on visible count
        handleEmptyState(filter, visibleCount, messages.length);
    }

    function handleEmptyState(filter, visibleCount, totalMessages) {
        const existingEmptyState = document.getElementById('filterEmptyState');
        const messagesList = document.getElementById('messagesList');
        const originalEmptyState = document.querySelector('.empty-state:not(#filterEmptyState)');
        
        // Remove existing filter empty state if any
        if (existingEmptyState) {
            existingEmptyState.remove();
        }

        // If no visible messages and we have messages total > 0
        if (visibleCount === 0 && totalMessages > 0) {
            // Hide messages list
            if (messagesList) messagesList.style.display = 'none';
            
            // Create filter-specific empty state
            const container = document.querySelector('.messages-container');
            const emptyState = document.createElement('div');
            emptyState.id = 'filterEmptyState';
            emptyState.className = 'empty-state';
            
            let icon, title, text;
            if (filter === 'read') {
                icon = 'fa-check-double';
                title = 'No Read Messages';
                text = 'You don\'t have any read messages at the moment.';
            } else {
                icon = 'fa-clock';
                title = 'No Pending Messages';
                text = 'All your messages have been read!';
            }
            
            emptyState.innerHTML = `
                <div class="empty-icon">
                    <i class="fas ${icon}"></i>
                </div>
                <h3 class="empty-title">${title}</h3>
                <p class="empty-text">${text}</p>
                <button onclick="filterMessages('all')" class="btn-primary-lg">
                    <i class="fas fa-times"></i> Clear Filter
                </button>
            `;
            
            // Insert after filter tabs
            const filterTabs = document.querySelector('.filter-tabs');
            filterTabs.insertAdjacentElement('afterend', emptyState);
        } else {
            // Show messages list
            if (messagesList) messagesList.style.display = 'block';
        }
    }

    // MARK MESSAGE AS READ
    window.markMessageAsRead = function(messageId) {
        fetch(`/messages/${messageId}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateMessageReadStatus(messageId, true, new Date().toISOString());
            }
        })
        .catch(error => console.error('Error marking as read:', error));
    };

    // INITIALIZE
    document.addEventListener('DOMContentLoaded', function() {
        // Add click handlers to filter tabs
        document.getElementById('filterAll').addEventListener('click', () => filterMessages('all'));
        document.getElementById('filterRead').addEventListener('click', () => filterMessages('read'));
        document.getElementById('filterPending').addEventListener('click', () => filterMessages('pending'));
    });
</script>
@endsection