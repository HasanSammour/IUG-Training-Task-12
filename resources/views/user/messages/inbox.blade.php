@extends('layouts.app')

@section('title', 'Messages - Inbox')
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

        /* Message Alert - Full width */
        .message-alert {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: var(--radius-lg);
            padding: 15px 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            color: #0369a1;
            transition: all 0.3s ease;
            width: 100%;
            box-sizing: border-box;
            cursor: pointer;
        }

        .message-alert:hover {
            background: #e0f2fe;
            transform: translateX(5px);
        }

        .alert-icon {
            width: 40px;
            height: 40px;
            background: #0284c7;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
        }

        .alert-content {
            flex: 1;
        }

        .alert-title {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .alert-text {
            font-size: 13px;
            opacity: 0.8;
        }

        .alert-badge {
            background: var(--danger-red);
            color: var(--white);
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Tabs */
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

        /* Conversations List - Full width */
        .conversations-list {
            background: var(--white);
            border-radius: var(--radius-xl);
            border: 1px solid var(--border-color);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            width: 100%;
        }

        .conversation-item {
            display: flex;
            align-items: center;
            padding: 20px 25px;
            border-bottom: 1px solid var(--border-color);
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            position: relative;
            width: 100%;
            box-sizing: border-box;
        }

        .conversation-item:last-child {
            border-bottom: none;
        }

        .conversation-item:hover {
            background: #f8fafc;
            transform: translateX(5px);
        }

        .conversation-item.unread {
            background: #f0f9ff;
            border-left: 4px solid var(--secondary-blue);
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

        .conversation-content {
            flex: 1;
        }

        .conversation-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .user-name {
            font-weight: 600;
            color: var(--primary-navy);
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
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

        .last-message {
            color: var(--text-gray);
            font-size: 14px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .last-message i {
            color: var(--text-light);
            font-size: 10px;
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

        .unread-count {
            background: var(--danger-red);
            color: var(--white);
            padding: 4px 10px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            min-width: 24px;
            text-align: center;
            margin-left: 20px;
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

        /* Unread filter active state */
        .filter-active {
            background: var(--primary-navy);
            color: var(--white);
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            margin-left: 8px;
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

            .conversation-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .avatar {
                margin-right: 0;
            }

            .unread-count {
                margin-left: 0;
                margin-top: 10px;
            }

            .conversation-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }

            .tabs {
                overflow-x: auto;
                padding-bottom: 5px;
            }

            .tab {
                white-space: nowrap;
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
                    <i class="fas fa-envelope"></i>
                    Messages
                </h1>
                <div class="header-actions">
                    <a href="{{ route('notifications.index') }}" class="btn btn-outline">
                        <i class="fas fa-bell"></i> Notifications
                    </a>
                </div>
            </div>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value" id="totalConversations">{{ count($conversations) }}</span>
                        <span class="stat-label">Conversations</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value" id="unreadCount">{{ $unreadCount }}</span>
                        <span class="stat-label">Unread</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ \App\Models\Message::where('sender_id', auth()->id())->count() }}</span>
                        <span class="stat-label">Sent</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <span
                            class="stat-value">{{ \App\Models\Message::where('receiver_id', auth()->id())->where('is_read', true)->count() }}</span>
                        <span class="stat-label">Read</span>
                    </div>
                </div>
            </div>

            <!-- Alert for unread messages - Only shown if there are unread messages -->
            @if($unreadCount > 0)
                <div class="message-alert" onclick="filterUnread()" id="unreadAlert">
                    <div class="alert-icon">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <div class="alert-content">
                        <div class="alert-title">You have <span id="alertUnreadCount">{{ $unreadCount }}</span> unread
                            message{{ $unreadCount > 1 ? 's' : '' }}</div>
                        <div class="alert-text">Click to view only unread conversations</div>
                    </div>
                    <span class="alert-badge" id="alertBadge">{{ $unreadCount }} new</span>
                </div>
            @endif

            <!-- Filter indicator -->
            <div id="filterIndicator"
                style="display: none; margin-top: 15px; padding: 10px; background: rgba(255,255,255,0.1); border-radius: 8px;">
                <span><i class="fas fa-filter"></i> Showing: <span id="currentFilter">Unread conversations
                        only</span></span>
                <button onclick="clearFilter()"
                    style="margin-left: 15px; background: white; border: none; padding: 4px 12px; border-radius: 20px; color: var(--primary-navy); font-size: 12px; cursor: pointer;">
                    <i class="fas fa-times"></i> Clear filter
                </button>
            </div>
        </div>

        <!-- Tabs -->
        <div class="tabs">
            <a href="{{ route('messages.inbox') }}" class="tab active" id="inboxTab">
                <i class="fas fa-inbox"></i>
                Inbox
                <span class="tab-badge" id="inboxBadge">{{ count($conversations) }}</span>
            </a>
            <a href="{{ route('messages.sent') }}" class="tab" id="sentTab">
                <i class="fas fa-paper-plane"></i>
                Sent
            </a>
        </div>

        <!-- Conversations List -->
        <div id="conversationsContainer">
            @if(count($conversations) > 0)
                <div class="conversations-list" id="conversationsList">
                    @foreach($conversations as $conversation)
                        @php
                            $otherUser = $conversation['user'];
                            $lastMessage = $conversation['last_message'];
                            $unread = $conversation['unread_count'] ?? 0;
                            $course = $conversation['course'] ?? null;
                        @endphp

                        <a href="{{ route('messages.conversation', $otherUser->id) }}{{ $course ? '?course_id=' . $course->id : '' }}"
                            class="conversation-item {{ $unread > 0 ? 'unread' : '' }}"
                            data-unread="{{ $unread > 0 ? 'true' : 'false' }}" data-conversation-id="{{ $otherUser->id }}">

                            <div class="avatar">
                                {{ substr($otherUser->name, 0, 1) }}
                            </div>

                            <div class="conversation-content">
                                <div class="conversation-header">
                                    <span class="user-name">
                                        {{ $otherUser->name }}
                                        @if($otherUser->hasRole('instructor'))
                                            <span class="role-badge instructor">Instructor</span>
                                        @elseif($otherUser->hasRole('student'))
                                            <span class="role-badge student">Student</span>
                                        @elseif($otherUser->hasRole('admin'))
                                            <span class="role-badge admin">Admin</span>
                                        @endif
                                    </span>
                                    <span class="time">
                                        <i class="fas fa-clock"></i> {{ $lastMessage->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                <div class="last-message">
                                    <i class="fas fa-reply"></i>
                                    {{ Str::limit($lastMessage->message, 80) }}
                                </div>

                                @if($course)
                                    <span class="course-badge">
                                        <i class="fas fa-book"></i> {{ $course->title }}
                                    </span>
                                @endif
                            </div>

                            @if($unread > 0)
                                <span class="unread-count">{{ $unread }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state" id="emptyState">
                    <div class="empty-icon">
                        <i class="far fa-envelope"></i>
                    </div>
                    <h3 class="empty-title">No Conversations Yet</h3>
                    <p class="empty-text">When you message an instructor or student, your conversations will appear here.</p>
                    <a href="{{ route('courses.public') }}" class="btn-primary-lg">
                        <i class="fas fa-book-open"></i> Browse Courses
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let filterActive = false;
        let originalConversations = [];

        document.addEventListener('DOMContentLoaded', function () {
            // Store original conversations for filtering
            document.querySelectorAll('.conversation-item').forEach(item => {
                originalConversations.push({
                    element: item,
                    unread: item.dataset.unread === 'true'
                });
            });
        });

        function filterUnread() {
            filterActive = true;
            const conversations = document.querySelectorAll('.conversation-item');
            let unreadCount = 0;

            conversations.forEach(item => {
                if (item.dataset.unread === 'true') {
                    item.style.display = 'flex';
                    unreadCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Show filter indicator
            document.getElementById('filterIndicator').style.display = 'block';

            // Update stats
            document.getElementById('totalConversations').textContent = unreadCount;

            // Hide the alert
            const alert = document.getElementById('unreadAlert');
            if (alert) alert.style.display = 'none';

            // Show empty state if no unread messages
            if (unreadCount === 0) {
                showEmptyUnreadState();
            }
        }

        function clearFilter() {
            filterActive = false;
            const conversations = document.querySelectorAll('.conversation-item');

            conversations.forEach(item => {
                item.style.display = 'flex';
            });

            // Hide filter indicator
            document.getElementById('filterIndicator').style.display = 'none';

            // Restore original stats
            document.getElementById('totalConversations').textContent = '{{ count($conversations) }}';

            // Remove empty unread state if it exists
            const emptyUnread = document.getElementById('emptyUnreadState');
            if (emptyUnread) {
                emptyUnread.remove();
            }

            // Show conversations list if hidden
            const conversationsList = document.getElementById('conversationsList');
            if (conversationsList) {
                conversationsList.style.display = 'block';
            }

            // Show alert again if there are unread messages
            const alert = document.getElementById('unreadAlert');
            if (alert && {{ $unreadCount }} > 0) {
                alert.style.display = 'flex';
            }
        }

        function showEmptyUnreadState() {
            // Hide conversations list
            const conversationsList = document.getElementById('conversationsList');
            if (conversationsList) {
                conversationsList.style.display = 'none';
            }

            // Check if empty state already exists
            if (document.getElementById('emptyUnreadState')) return;

            // Create empty state for unread filter
            const container = document.getElementById('conversationsContainer');
            const emptyState = document.createElement('div');
            emptyState.id = 'emptyUnreadState';
            emptyState.className = 'empty-state';
            emptyState.innerHTML = `
                <div class="empty-icon">
                    <i class="far fa-envelope-open"></i>
                </div>
                <h3 class="empty-title">No Unread Messages</h3>
                <p class="empty-text">You've read all your messages! Great job staying on top of your conversations.</p>
                <button onclick="clearFilter()" class="btn-primary-lg">
                    <i class="fas fa-times"></i> Clear Filter
                </button>
            `;
            container.appendChild(emptyState);
        }

        // Real-time unread count update (we call this when messages are read)
        function updateUnreadCount(change) {
            const unreadElements = [
                document.getElementById('unreadCount'),
                document.getElementById('alertUnreadCount'),
                document.getElementById('alertBadge')
            ];

            unreadElements.forEach(element => {
                if (element) {
                    let count = parseInt(element.textContent) || 0;
                    element.textContent = Math.max(0, count + change);
                }
            });

            // Update inbox badge
            const inboxBadge = document.getElementById('inboxBadge');
            if (inboxBadge) {
                let count = parseInt(inboxBadge.textContent) || 0;
                inboxBadge.textContent = count;
            }

            // Hide alert if unread becomes 0
            const alert = document.getElementById('unreadAlert');
            if (alert && parseInt(document.getElementById('unreadCount').textContent) === 0) {
                alert.style.display = 'none';
            }
        }

        // Mark conversation as read when opened
        function markConversationAsRead(userId) {
            const conversation = document.querySelector(`.conversation-item[data-conversation-id="${userId}"]`);
            if (conversation && conversation.classList.contains('unread')) {
                conversation.classList.remove('unread');
                const unreadBadge = conversation.querySelector('.unread-count');
                if (unreadBadge) {
                    unreadBadge.remove();
                }
                conversation.dataset.unread = 'false';

                // Update unread count
                updateUnreadCount(-1);

                // If filter is active, maybe hide this conversation
                if (filterActive) {
                    conversation.style.display = 'none';

                    // Check if any unread conversations left
                    const remainingUnread = document.querySelectorAll('.conversation-item[data-unread="true"]').length;
                    if (remainingUnread === 0) {
                        showEmptyUnreadState();
                    }
                }
            }
        }
    </script>
@endsection