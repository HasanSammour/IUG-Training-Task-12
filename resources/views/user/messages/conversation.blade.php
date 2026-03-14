@extends('layouts.app')

@section('title', 'Conversation with ' . ($otherUser->name ?? 'User'))
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
        --message-sent: #dcf8c6;
        --message-received: #ffffff;
    }

    /* Full width layout */
    body.messages-page {
        background-color: #e5ddd5;
        min-height: 100vh;
    }

    .conversation-container {
        width: 100%;
        max-width: 100%;
        padding: 20px 30px;
        margin: 0;
        padding-bottom: 100px;
        box-sizing: border-box;
    }

    /* Header - WhatsApp style */
    .conversation-header {
        background: linear-gradient(135deg, var(--primary-navy) 0%, #1a252f 100%);
        border-radius: var(--radius-xl) var(--radius-xl) 0 0;
        padding: 15px 25px;
        margin-bottom: 2px;
        box-shadow: var(--shadow-md);
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        box-sizing: border-box;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-avatar-large {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--white);
        color: var(--primary-navy);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 20px;
        box-shadow: var(--shadow-md);
    }

    .user-details {
        color: var(--white);
    }

    .user-details h2 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 2px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .user-details p {
        display: flex;
        align-items: center;
        gap: 10px;
        opacity: 0.9;
        font-size: 12px;
    }

    .role-badge {
        padding: 2px 8px;
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

    .back-btn {
        padding: 8px 16px;
        background: rgba(255, 255, 255, 0.1);
        color: var(--white);
        text-decoration: none;
        border-radius: 30px;
        font-weight: 500;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .back-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-1px);
    }

    /* Messages Card - WhatsApp style */
    .messages-card {
        background: #e5ddd5;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="%23e5ddd5" opacity="0.05"/></svg>');
        border-radius: 0 0 var(--radius-xl) var(--radius-xl);
        overflow: hidden;
        margin-bottom: 15px;
        box-shadow: var(--shadow-lg);
        height: calc(100vh - 280px);
        min-height: 400px;
        display: flex;
        flex-direction: column;
        width: 100%;
        box-sizing: border-box;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .messages-header {
        padding: 12px 20px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        background: rgba(255,255,255,0.95);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
        backdrop-filter: blur(5px);
    }

    .messages-header h3 {
        font-size: 14px;
        color: var(--text-dark);
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .course-context-badge {
        background: #f0f9ff;
        color: #0369a1;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .messages-list {
        padding: 20px;
        overflow-y: auto;
        flex: 1;
        scroll-behavior: smooth;
        display: flex;
        flex-direction: column;
    }

    /* Date Separator - WhatsApp style */
    .date-separator {
        text-align: center;
        margin: 15px 0;
        position: relative;
    }

    .date-separator span {
        background: rgba(225, 245, 254, 0.92);
        padding: 4px 15px;
        color: #54656f;
        font-size: 11px;
        font-weight: 500;
        border-radius: 30px;
        box-shadow: var(--shadow-sm);
        display: inline-block;
        backdrop-filter: blur(5px);
    }

    /* Message Items - WhatsApp style */
    .message-item {
        display: flex;
        margin-bottom: 8px;
        animation: fadeIn 0.2s ease;
        width: 100%;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .message-item.sent {
        justify-content: flex-end;
    }

    .message-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-navy), #1a252f);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 12px;
        margin-right: 8px;
        flex-shrink: 0;
        align-self: flex-end;
        box-shadow: var(--shadow-sm);
    }

    .message-item.sent .message-avatar {
        display: none;
    }

    .message-bubble {
        max-width: 65%;
        padding: 8px 12px;
        border-radius: 12px;
        position: relative;
        word-wrap: break-word;
        box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        font-size: 14px;
        line-height: 1.4;
    }

    .message-item.received .message-bubble {
        background: var(--message-received);
        color: #111b21;
        border-top-left-radius: 4px;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .message-item.sent .message-bubble {
        background: var(--message-sent);
        color: #111b21;
        border-top-right-radius: 4px;
    }

    .message-text {
        margin-bottom: 4px;
        white-space: pre-wrap;
        word-break: break-word;
        padding-right: 50px;
    }

    .message-meta {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 3px;
        font-size: 10px;
        color: #667781;
        margin-top: 2px;
        float: right;
    }

    .message-item.sent .message-meta {
        color: #4b5b66;
    }

    .read-receipt {
        display: flex;
        align-items: center;
    }

    .read-receipt i {
        font-size: 12px;
    }

    .read-receipt .fa-check {
        color: #8696a0;
    }

    .read-receipt .fa-check-double {
        color: #53bdeb;
    }

    /* Message Form - WhatsApp style */
    .message-form-card {
        background: #f0f2f5;
        border-radius: 30px;
        padding: 10px 15px;
        box-shadow: var(--shadow-md);
        width: 100%;
        box-sizing: border-box;
    }

    .message-input-group {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .message-input-wrapper {
        flex: 1;
        position: relative;
    }

    .message-input {
        width: 100%;
        padding: 10px 15px;
        border: none;
        border-radius: 24px;
        font-size: 14px;
        resize: none;
        min-height: 24px;
        max-height: 120px;
        transition: all 0.2s ease;
        font-family: inherit;
        line-height: 1.5;
        overflow-y: auto;
        background: var(--white);
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
    }

    .message-input:focus {
        outline: none;
        box-shadow: inset 0 1px 3px rgba(0,0,0,0.1), 0 0 0 2px rgba(45,62,80,0.1);
    }

    .message-input::placeholder {
        color: #8696a0;
        font-style: normal;
    }

    .send-btn {
        padding: 0 20px;
        background: var(--primary-navy);
        color: var(--white);
        border: none;
        border-radius: 30px;
        font-weight: 500;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 6px;
        height: 40px;
        min-width: 80px;
        justify-content: center;
    }

    .send-btn:hover:not(:disabled) {
        background: #1a252f;
        transform: scale(1.02);
    }

    .send-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .send-btn i {
        font-size: 14px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        background: transparent;
        width: 100%;
    }

    .empty-icon {
        font-size: 48px;
        color: #aebac1;
        margin-bottom: 15px;
    }

    .empty-title {
        font-size: 16px;
        color: #54656f;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .empty-text {
        color: #8696a0;
        font-size: 13px;
        margin-bottom: 0;
    }

    /* Scroll Button - WhatsApp style */
    .scroll-to-bottom {
        position: fixed;
        bottom: 110px;
        right: 30px;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: var(--white);
        color: var(--primary-navy);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: var(--shadow-lg);
        transition: all 0.2s ease;
        opacity: 0;
        visibility: hidden;
        z-index: 100;
        font-size: 18px;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .scroll-to-bottom.visible {
        opacity: 1;
        visibility: visible;
    }

    .scroll-to-bottom:hover {
        transform: scale(1.1);
        background: #f5f5f5;
    }

    /* New Message Notification - WhatsApp style */
    .new-message-notification {
        position: fixed;
        bottom: 110px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--primary-navy);
        color: white;
        padding: 10px 20px;
        border-radius: 40px;
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 1000;
        animation: slideUp 0.3s ease;
        font-size: 13px;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .new-message-notification button {
        background: white;
        color: var(--primary-navy);
        border: none;
        padding: 4px 12px;
        border-radius: 30px;
        font-weight: 500;
        font-size: 11px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .new-message-notification button:hover {
        transform: scale(1.05);
        background: #f5f5f5;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translate(-50%, 20px);
        }
        to {
            opacity: 1;
            transform: translate(-50%, 0);
        }
    }

    /* Loading */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.9);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-spinner {
        width: 40px;
        height: 40px;
        border: 3px solid #f1f5f9;
        border-top-color: var(--primary-navy);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .conversation-container {
            padding: 10px;
        }

        .conversation-header {
            padding: 12px 15px;
        }

        .user-info {
            gap: 10px;
        }

        .user-avatar-large {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .user-details h2 {
            font-size: 16px;
        }

        .message-bubble {
            max-width: 85%;
        }

        .scroll-to-bottom {
            bottom: 100px;
            right: 15px;
        }

        .new-message-notification {
            width: 90%;
            bottom: 100px;
            flex-wrap: wrap;
            justify-content: center;
            text-align: center;
        }
    }
</style>
@endsection

@section('content')
<div class="conversation-container">
    <!-- Header -->
    <div class="conversation-header">
        <div class="user-info">
            <div class="user-avatar-large">
                {{ $otherUser && $otherUser->name ? substr($otherUser->name, 0, 1) : '?' }}
            </div>
            <div class="user-details">
                <h2>
                    {{ $otherUser->name ?? 'Unknown User' }}
                    @if($otherUser && $otherUser->hasRole('instructor'))
                        <span class="role-badge instructor">Instructor</span>
                    @elseif($otherUser && $otherUser->hasRole('student'))
                        <span class="role-badge student">Student</span>
                    @elseif($otherUser && $otherUser->hasRole('admin'))
                        <span class="role-badge admin">Admin</span>
                    @endif
                </h2>
                <p>
                    <span>Last seen recently</span>
                </p>
            </div>
        </div>
        <a href="{{ route('messages.inbox') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <!-- Messages Card -->
    <div class="messages-card">
        <div class="messages-header">
            <h3>
                <i class="fas fa-lock" style="font-size: 10px;"></i>
                Messages are end-to-end encrypted
            </h3>

            @php
                // Check if any message in the conversation has a course
                $hasCourse = $messages->contains(function($message) {
                    return $message->course_id !== null;
                });
                $conversationCourse = $hasCourse ? $messages->firstWhere('course_id', '!=', null)?->course : null;
            @endphp

            @if($conversationCourse)
                <div class="course-context-badge">
                    <i class="fas fa-book"></i>
                    {{ $conversationCourse->title }}
                </div>
            @endif
        </div>

        <div class="messages-list" id="messagesList">
            @php
                $currentDate = null;
            @endphp
            
            @forelse($messages as $message)
                @php
                    $messageDate = $message->created_at->format('Y-m-d');
                @endphp
                
                @if($currentDate !== $messageDate)
                    @php $currentDate = $messageDate; @endphp
                    <div class="date-separator">
                        <span>{{ $message->created_at->format('F j, Y') }}</span>
                    </div>
                @endif
                
                <div class="message-item {{ $message->sender_id == auth()->id() ? 'sent' : 'received' }}"
                     data-message-id="{{ $message->id }}"
                     data-is-read="{{ $message->is_read ? 'true' : 'false' }}">
                    
                    @if($message->sender_id != auth()->id())
                        <div class="message-avatar">
                            {{ substr($message->sender->name, 0, 1) }}
                        </div>
                    @endif
                    
                    <div class="message-bubble">
                        <div class="message-text">
                            {{ $message->message }}
                        </div>
                        <div class="message-meta">
                            <span>{{ $message->created_at->format('h:i A') }}</span>
                            @if($message->sender_id == auth()->id())
                                <span class="read-receipt" id="receipt-{{ $message->id }}">
                                    @if($message->is_read)
                                        <i class="fas fa-check-double" style="color: #53bdeb;"></i>
                                    @else
                                        <i class="fas fa-check" style="color: #8696a0;"></i>
                                    @endif
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="far fa-comment-dots"></i>
                    </div>
                    <h3 class="empty-title">No messages yet</h3>
                    <p class="empty-text">Say hello to start the conversation</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Message Form - WhatsApp style -->
    <div class="message-form-card">
        <form id="messageForm">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $otherUser->id ?? '' }}" id="receiverId">
            <!-- Always include course_id input, even if empty -->
            <input type="hidden" name="course_id" id="courseId" value="{{ isset($course) && $course ? $course->id : '' }}">
            
            <div class="message-input-group">
                <div class="message-input-wrapper">
                    <textarea id="messageText" name="message" class="message-input" 
                              placeholder="Type a message..." 
                              oninput="autoResize(this)" required></textarea>
                </div>
                <button type="submit" class="send-btn" id="sendBtn">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Scroll to bottom button -->
    <div class="scroll-to-bottom" id="scrollToBottom" onclick="scrollToBottom(true)">
        <i class="fas fa-arrow-down"></i>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
<script>
    // DOM Elements
    const messagesList = document.getElementById('messagesList');
    const messageForm = document.getElementById('messageForm');
    const messageInput = document.getElementById('messageText');
    const sendBtn = document.getElementById('sendBtn');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const scrollToBottomBtn = document.getElementById('scrollToBottom');
    let lastMessageId = {{ $messages->last()->id ?? 0 }};
    let pollingInterval;
    let isCheckingMessages = false;
    let newMessageCount = 0;
    let userScrolled = false;

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        // Initial scroll to bottom without animation
        scrollToBottom(false);
        
        // Mark messages as read
        markMessagesAsRead();
        
        // Start polling for new messages
        startPolling();
        
        // Scroll event listener
        messagesList.addEventListener('scroll', function() {
            const atBottom = isScrolledToBottom();
            
            if (atBottom) {
                scrollToBottomBtn.classList.remove('visible');
                const notification = document.querySelector('.new-message-notification');
                if (notification) {
                    notification.remove();
                }
                newMessageCount = 0;
                userScrolled = false;
            } else {
                scrollToBottomBtn.classList.add('visible');
                userScrolled = true;
            }
        });

        // Focus on input
        messageInput.focus();
    });

    // Auto resize textarea
    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = Math.min(textarea.scrollHeight, 120) + 'px';
    }

    // Scroll to bottom
    function scrollToBottom(animate = true) {
        if (animate) {
            messagesList.scrollTo({
                top: messagesList.scrollHeight,
                behavior: 'smooth'
            });
        } else {
            messagesList.scrollTop = messagesList.scrollHeight;
        }
        
        const notification = document.querySelector('.new-message-notification');
        if (notification) {
            notification.remove();
        }
        newMessageCount = 0;
        scrollToBottomBtn.classList.remove('visible');
        userScrolled = false;
    }

    // Check if scrolled to bottom
    function isScrolledToBottom() {
        const threshold = 50;
        return messagesList.scrollHeight - messagesList.scrollTop - messagesList.clientHeight < threshold;
    }

    // Mark messages as read and update icons
    function markMessagesAsRead() {
        const unreadMessages = document.querySelectorAll('.message-item.received[data-is-read="false"]');
        
        unreadMessages.forEach(msg => {
            const msgId = msg.dataset.messageId;
            
            fetch(`/messages/${msgId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    msg.dataset.isRead = 'true';
                }
            })
            .catch(error => console.error('Error marking as read:', error));
        });
    }

    // Update read receipt for a specific message
    function updateReadReceipt(messageId, isRead) {
        const receiptSpan = document.getElementById(`receipt-${messageId}`);
        if (receiptSpan) {
            if (isRead) {
                receiptSpan.innerHTML = '<i class="fas fa-check-double" style="color: #53bdeb;"></i>';
            } else {
                receiptSpan.innerHTML = '<i class="fas fa-check" style="color: #8696a0;"></i>';
            }
        }
    }

    // Send message
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const messageText = messageInput.value.trim();
        if (!messageText) {
            return;
        }

        const receiverId = document.getElementById('receiverId').value;
        if (!receiverId) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Cannot send message: recipient not found',
                confirmButtonColor: '#2d3e50',
                timer: 2000,
                showConfirmButton: false
            });
            return;
        }

        sendBtn.disabled = true;
        sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        const courseInput = document.querySelector('input[name="course_id"]');
        const courseId = courseInput ? courseInput.value : null;

        fetch('{{ route("messages.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                receiver_id: receiverId,
                message: messageText,
                course_id: courseId
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                messageInput.value = '';
                autoResize(messageInput);

                addMessageToChat({
                    id: data.data.id,
                    message: messageText,
                    sender_id: {{ auth()->id() }},
                    created_at: new Date().toISOString(),
                    is_read: false
                });

                lastMessageId = data.data.id;
                scrollToBottom(true);
                messageInput.focus();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to send message.',
                    confirmButtonColor: '#2d3e50'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to send message. Please try again.',
                confirmButtonColor: '#2d3e50'
            });
        })
        .finally(() => {
            sendBtn.disabled = false;
            sendBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
        });
    });

    // Add message to chat with proper date handling
    function addMessageToChat(message) {
        // Check for duplicates
        if (document.querySelector(`.message-item[data-message-id="${message.id}"]`)) {
            return;
        }
        
        const isSent = message.sender_id == {{ auth()->id() }};
        const messageDate = new Date(message.created_at);
        const today = new Date();
        const yesterday = new Date(today);
        yesterday.setDate(yesterday.getDate() - 1);
        
        let dateDisplay;
        if (messageDate.toDateString() === today.toDateString()) {
            dateDisplay = 'Today';
        } else if (messageDate.toDateString() === yesterday.toDateString()) {
            dateDisplay = 'Yesterday';
        } else {
            dateDisplay = messageDate.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
        }
        
        // Check if we need to add a date separator
        const lastDateSeparator = document.querySelector('.date-separator:last-child span');
        const lastDate = lastDateSeparator ? lastDateSeparator.textContent : null;
        
        if (!lastDate || lastDate !== dateDisplay) {
            const dateSeparator = document.createElement('div');
            dateSeparator.className = 'date-separator';
            dateSeparator.innerHTML = `<span>${dateDisplay}</span>`;
            messagesList.appendChild(dateSeparator);
        }
        
        const messageDiv = document.createElement('div');
        messageDiv.className = `message-item ${isSent ? 'sent' : 'received'}`;
        messageDiv.dataset.messageId = message.id;
        messageDiv.dataset.isRead = message.is_read ? 'true' : 'false';
        
        let html = '';
        if (!isSent) {
            html += '<div class="message-avatar">{{ $otherUser && $otherUser->name ? substr($otherUser->name, 0, 1) : '?' }}</div>';
        }
        
        const time = messageDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        
        html += `
            <div class="message-bubble">
                <div class="message-text">${escapeHtml(message.message)}</div>
                <div class="message-meta">
                    <span>${time}</span>
                    ${isSent ? `<span class="read-receipt" id="receipt-${message.id}"><i class="fas fa-check" style="color: #8696a0;"></i></span>` : ''}
                </div>
            </div>
        `;

        messageDiv.innerHTML = html;
        messagesList.appendChild(messageDiv);
    }

    // Escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // ========== POLLING ========== //
    function startPolling() {
        if (pollingInterval) {
            clearInterval(pollingInterval);
        }
        pollingInterval = setInterval(checkForNewMessages, 5000);
    }

    function checkForNewMessages() {
        if (isCheckingMessages) return;
        
        isCheckingMessages = true;
        
        const afterId = parseInt(lastMessageId) || 0;
        
        fetch(`/messages/conversation/{{ $otherUser->id }}/new?after=${afterId}`, {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(messages => {
            if (messages && messages.length > 0) {
                newMessageCount += messages.length;
                
                const wasAtBottom = isScrolledToBottom();
                
                let highestId = lastMessageId;
                
                messages.forEach(message => {
                    if (!document.querySelector(`.message-item[data-message-id="${message.id}"]`)) {
                        addMessageToChat(message);
                        highestId = Math.max(highestId, parseInt(message.id));
                    }
                });
                
                if (highestId > lastMessageId) {
                    lastMessageId = highestId;
                }
                
                if (wasAtBottom && !userScrolled) {
                    scrollToBottom(false);
                    markMessagesAsRead();
                } else if (messages.length > 0) {
                    showNewMessageNotification(newMessageCount);
                }
            }
        })
        .catch(error => {
            console.error('Error polling messages:', error);
        })
        .finally(() => {
            isCheckingMessages = false;
        });
    }

    // Show new message notification
    function showNewMessageNotification(count) {
        const existing = document.querySelector('.new-message-notification');
        if (existing) {
            existing.remove();
        }
        
        const notification = document.createElement('div');
        notification.className = 'new-message-notification';
        notification.innerHTML = `
            <i class="fas fa-envelope"></i>
            <span>${count} new message${count > 1 ? 's' : ''}</span>
            <button onclick="scrollToBottom(true)">View</button>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.style.animation = 'slideDown 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }
        }, 5000);
    }

    // Enter key to send (Shift+Enter for new line)
    messageInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            messageForm.dispatchEvent(new Event('submit'));
        }
    });

    // Cleanup on page leave
    window.addEventListener('beforeunload', function() {
        if (pollingInterval) {
            clearInterval(pollingInterval);
        }
    });

    // Debug function (optional)
    function debugLastMessageId() {
        const messages = document.querySelectorAll('.message-item');
        let maxId = 0;
        messages.forEach(msg => {
            const id = parseInt(msg.dataset.messageId);
            if (id > maxId) maxId = id;
        });
        console.log('DOM max ID:', maxId, 'JS lastMessageId:', lastMessageId);
    }
</script>
@endsection