@extends('layouts.app')

@section('title', $student->name . ' - Progress')
@section('body-class', 'instructor-progress')

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
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .instructor-progress {
        background-color: var(--bg-light);
        min-height: 100vh;
    }

    .progress-container {
        padding: 30px 40px;
        max-width: 1400px;
        margin: 0 auto;
        padding-bottom: 100px;
    }

    /* Header */
    .header-section {
        margin-bottom: 25px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--text-gray);
        text-decoration: none;
        padding: 8px 16px;
        background: var(--white);
        border-radius: 30px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .back-link:hover {
        color: var(--primary-navy);
        border-color: var(--primary-navy);
        transform: translateX(-3px);
    }

    /* Student Profile Card */
    .profile-card {
        background: var(--white);
        border-radius: 24px;
        padding: 30px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        animation: slideInDown 0.5s ease-out;
    }

    .profile-info {
        display: flex;
        align-items: center;
        gap: 25px;
        flex-wrap: wrap;
    }

    .avatar-large {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, var(--primary-navy), #1a252f);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 38px;
        font-weight: 600;
        box-shadow: 0 10px 25px rgba(45, 62, 80, 0.2);
        border: 4px solid var(--white);
        animation: pulseAvatar 2s infinite;
    }

    @keyframes pulseAvatar {
        0%, 100% {
            box-shadow: 0 10px 25px rgba(45, 62, 80, 0.2);
        }
        50% {
            box-shadow: 0 15px 35px rgba(45, 62, 80, 0.3);
        }
    }

    .details h1 {
        font-size: 28px;
        color: var(--primary-navy);
        margin-bottom: 8px;
        font-weight: 700;
        animation: slideInRight 0.5s ease-out;
    }

    .details .email {
        color: var(--text-gray);
        font-size: 16px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        animation: slideInRight 0.6s ease-out;
    }

    .enrollment-info {
        display: flex;
        gap: 20px;
        color: var(--text-gray);
        font-size: 14px;
        animation: slideInRight 0.7s ease-out;
    }

    .enrollment-info i {
        color: var(--secondary-blue);
    }

    /* FIXED: ANIMATED PROGRESS CIRCLE - Adjusted positioning */
    .progress-circle-large {
        width: 110px; /* Slightly smaller */
        height: 110px;
        position: relative;
        cursor: pointer;
        transition: transform 0.3s ease;
        margin-right: 15px; /* Add right margin */
        margin-left: 10px; /* Add left margin for balance */
    }

    .progress-circle-large:hover {
        transform: scale(1.05);
    }

    .circular-chart {
        width: 100%;
        height: 100%;
        transform: rotate(-90deg);
    }

    .circle-bg {
        stroke: #e2e8f0;
        stroke-width: 8;
        fill: none;
        stroke-linecap: round;
    }

    .circle-progress {
        stroke: var(--primary-navy);
        stroke-width: 8;
        fill: none;
        stroke-linecap: round;
        stroke-dasharray: 0, 100.53;
        animation: fillProgress 1.5s ease-out forwards;
    }

    @keyframes fillProgress {
        to {
            stroke-dasharray: {{ ($enrollment->progress_percentage / 100) * 100.53 }}, 100.53;
        }
    }

    /* FIXED: Progress text - smaller font */
    .progress-text-large {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 24px; /* Reduced from 28px */
        font-weight: 700;
        color: var(--primary-navy);
        animation: fadeInScale 1s ease-out;
    }

    .progress-label-large {
        position: absolute;
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 12px;
        color: var(--text-gray);
        white-space: nowrap;
        opacity: 0;
        animation: fadeInUp 0.5s ease-out 0.5s forwards;
    }

    /* Stats Grid Animations */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
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
        padding: 20px;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
        animation: fadeInUp 0.5s ease-out;
        animation-fill-mode: both;
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-navy);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        transition: all 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
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

    .stat-details {
        flex: 1;
    }

    .stat-number {
        display: block;
        font-size: 24px;
        font-weight: 700;
        color: var(--primary-navy);
        line-height: 1.2;
        margin-bottom: 4px;
        transition: all 0.3s ease;
    }

    .stat-card:hover .stat-number {
        transform: scale(1.05);
        color: var(--secondary-blue);
    }

    .stat-label {
        font-size: 12px;
        color: var(--text-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Section Cards Animations */
    .section-card {
        background: var(--white);
        border-radius: 20px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        margin-bottom: 30px;
        box-shadow: var(--shadow-sm);
        animation: slideInUp 0.6s ease-out;
        animation-fill-mode: both;
    }

    .section-card:nth-of-type(1) { animation-delay: 0.2s; }
    .section-card:nth-of-type(2) { animation-delay: 0.3s; }
    .section-card:nth-of-type(3) { animation-delay: 0.4s; }

    .section-card:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }

    .section-header {
        padding: 20px 25px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        background: linear-gradient(to right, #fafafa, var(--white));
    }

    .section-title {
        font-size: 18px;
        color: var(--primary-navy);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--secondary-blue);
        transition: transform 0.3s ease;
    }

    .section-card:hover .section-title i {
        transform: rotate(360deg);
    }

    .section-badge {
        background: #f1f5f9;
        color: var(--text-gray);
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .section-card:hover .section-badge {
        background: var(--primary-navy);
        color: var(--white);
    }

    .section-content {
        padding: 25px;
    }

    /* Tables with animations */
    .sessions-table, .assignments-table {
        width: 100%;
        border-collapse: collapse;
    }

    .sessions-table th, .assignments-table th {
        text-align: left;
        padding: 12px 10px;
        font-size: 12px;
        color: var(--text-gray);
        font-weight: 600;
        text-transform: uppercase;
        border-bottom: 1px solid #f1f5f9;
    }

    .sessions-table td, .assignments-table td {
        padding: 15px 10px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        transition: all 0.3s ease;
    }

    .sessions-table tbody tr:hover td,
    .assignments-table tbody tr:hover td {
        background: #f8fafc;
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
        transition: all 0.3s ease;
    }

    tr:hover .status-badge {
        transform: scale(1.05);
    }

    .status-scheduled {
        background: #fef3c7;
        color: #92400e;
    }

    .status-ongoing {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-completed {
        background: #dcfce7;
        color: #15803d;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #b91c1c;
    }

    .attended-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    tr:hover .attended-badge {
        transform: scale(1.05);
    }

    .attended-yes {
        background: #dcfce7;
        color: #15803d;
    }

    .attended-no {
        background: #fee2e2;
        color: #b91c1c;
    }

    .grade-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    tr:hover .grade-badge {
        transform: scale(1.05);
    }

    .grade-high {
        background: #dcfce7;
        color: #15803d;
    }

    .grade-medium {
        background: #fef3c7;
        color: #d97706;
    }

    .grade-low {
        background: #fee2e2;
        color: #b91c1c;
    }

    .grade-pending {
        background: #f1f5f9;
        color: #64748b;
    }

    /* Activity Timeline with animations */
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 10px;
        bottom: 10px;
        width: 2px;
        background: linear-gradient(to bottom, #e2e8f0, #94a3b8, #e2e8f0);
        animation: timelinePulse 3s infinite;
    }

    @keyframes timelinePulse {
        0%, 100% {
            opacity: 0.5;
        }
        50% {
            opacity: 1;
        }
    }

    .timeline-item {
        position: relative;
        padding-bottom: 25px;
        animation: slideInLeft 0.5s ease-out;
        animation-fill-mode: both;
    }

    .timeline-item:nth-child(1) { animation-delay: 0.1s; }
    .timeline-item:nth-child(2) { animation-delay: 0.2s; }
    .timeline-item:nth-child(3) { animation-delay: 0.3s; }
    .timeline-item:nth-child(4) { animation-delay: 0.4s; }
    .timeline-item:nth-child(5) { animation-delay: 0.5s; }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-icon {
        position: absolute;
        left: -30px;
        top: 0;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: var(--white);
        border: 2px solid;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        z-index: 2;
        transition: all 0.3s ease;
        animation: bounceIn 0.5s ease-out;
    }

    .timeline-item:hover .timeline-icon {
        transform: scale(1.2) rotate(360deg);
    }

    .timeline-icon.green {
        border-color: #16a34a;
        color: #16a34a;
    }

    .timeline-icon.blue {
        border-color: #2563eb;
        color: #2563eb;
    }

    .timeline-icon.yellow {
        border-color: #d97706;
        color: #d97706;
    }

    .timeline-content {
        background: #f8fafc;
        padding: 15px 20px;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }

    .timeline-item:hover .timeline-content {
        transform: translateX(5px);
        background: var(--white);
        box-shadow: var(--shadow-md);
    }

    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }

    .timeline-title {
        font-weight: 600;
        color: var(--primary-navy);
    }

    .timeline-time {
        font-size: 12px;
        color: var(--text-gray);
    }

    .timeline-sub {
        font-size: 13px;
        color: var(--text-gray);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: var(--text-gray);
    }

    .empty-state i {
        font-size: 48px;
        color: #cbd5e0;
        margin-bottom: 15px;
    }

    /* Action Buttons Styling */
    .action-buttons-container {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .btn-action {
        background: #f1f5f9;
        color: var(--text-dark);
        padding: 12px 24px;
        border-radius: 10px;
        border: none;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: var(--shadow-sm);
        animation: fadeInUp 0.5s ease-out 0.5s both;
    }

    .btn-action:hover {
        background: #e2e8f0;
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    .btn-action:active {
        transform: translateY(0);
    }

    .btn-action i {
        font-size: 14px;
        transition: transform 0.3s ease;
    }

    .btn-action:hover i {
        transform: translateX(3px) scale(1.1);
    }

    .btn-action.primary {
        background: var(--primary-navy);
        color: var(--white);
    }

    .btn-action.primary:hover {
        background: #1a252f;
    }

    .btn-action.pdf {
        background: #fee2e2;
        color: #b91c1c;
    }

    .btn-action.pdf:hover {
        background: #fecaca;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content {
        background: var(--white);
        border-radius: 20px;
        padding: 30px;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: var(--shadow-xl);
        animation: slideInModal 0.4s ease-out;
    }

    @keyframes slideInModal {
        from {
            transform: translateY(-30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border-color);
    }

    .modal-header h3 {
        font-size: 20px;
        color: var(--primary-navy);
        font-weight: 600;
    }

    .modal-header h3 i {
        color: var(--secondary-blue);
        margin-right: 8px;
        animation: shake 2s infinite;
    }

    @keyframes shake {
        0%, 100% { transform: rotate(0); }
        10% { transform: rotate(15deg); }
        20% { transform: rotate(-15deg); }
        30% { transform: rotate(10deg); }
        40% { transform: rotate(-10deg); }
        50% { transform: rotate(5deg); }
        60% { transform: rotate(-5deg); }
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: var(--text-light);
        transition: all 0.3s ease;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .close-btn:hover {
        color: var(--primary-navy);
        background: #f1f5f9;
        transform: rotate(90deg);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-navy);
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
        transform: scale(1.02);
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .modal-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 25px;
    }

    .btn-primary {
        background: var(--primary-navy);
        color: var(--white);
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary:hover {
        background: #1a252f;
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(45, 62, 80, 0.2);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-primary i {
        transition: transform 0.3s ease;
    }

    .btn-primary:hover i {
        transform: translateX(3px);
    }

    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid var(--border-color);
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

    .success-message {
        background: #dcfce7;
        color: #15803d;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: none;
        animation: slideDown 0.3s ease;
    }

    /* Keyframe Animations */
    @keyframes slideInDown {
        from {
            transform: translateY(-30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes slideInUp {
        from {
            transform: translateY(30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes slideInLeft {
        from {
            transform: translateX(-30px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideInRight {
        from {
            transform: translateX(30px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes fadeInUp {
        from {
            transform: translateY(20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes fadeInScale {
        from {
            transform: translate(-50%, -50%) scale(0.5);
            opacity: 0;
        }
        to {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }
    }

    @keyframes bounceIn {
        0% {
            transform: scale(0.3);
            opacity: 0;
        }
        50% {
            transform: scale(1.05);
            opacity: 0.8;
        }
        70% {
            transform: scale(0.9);
            opacity: 0.9;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes slideDown {
        from {
            transform: translateY(-10px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .progress-container {
            padding: 15px;
        }
        
        .profile-card {
            flex-direction: column;
            text-align: center;
        }
        
        .profile-info {
            flex-direction: column;
            text-align: center;
        }
        
        .enrollment-info {
            justify-content: center;
        }
        
        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .action-buttons-container {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }

        .modal-actions {
            flex-direction: column;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
            justify-content: center;
        }
        
        /* FIXED: Mobile adjustments for progress circle */
        .progress-circle-large {
            margin-right: 0;
            margin-left: 0;
            margin-top: 15px;
        }
    }
</style>
@endsection

@section('content')
<div class="progress-container">
    <!-- Back Link -->
    <a href="{{ route('instructor.course-students', $course->id) }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Course Students
    </a>

    <!-- Student Profile Card -->
    <div class="profile-card">
        <div class="profile-info">
            <div class="avatar-large">
                {{ $student->initials }}
            </div>
            <div class="details">
                <h1>{{ $student->name }}</h1>
                <div class="email">
                    <i class="fas fa-envelope"></i> {{ $student->email }}
                </div>
                <div class="enrollment-info">
                    <span><i class="fas fa-calendar-alt"></i> Enrolled: {{ $enrollment->created_at->format('M d, Y') }}</span>
                    <span><i class="fas fa-clock"></i> Status: 
                        <span style="color: {{ $enrollment->status == 'active' ? '#15803d' : ($enrollment->status == 'completed' ? '#1e40af' : '#b45309') }}">
                            {{ ucfirst($enrollment->status) }}
                        </span>
                    </span>
                </div>
            </div>
        </div>
        
        <!-- FIXED: ANIMATED PROGRESS CIRCLE - Adjusted positioning -->
        <div class="progress-circle-large">
            <svg viewBox="0 0 40 40" class="circular-chart">
                <circle class="circle-bg" cx="20" cy="20" r="16"></circle>
                <circle class="circle-progress" cx="20" cy="20" r="16"></circle>
            </svg>
            <div class="progress-text-large">{{ $enrollment->progress_percentage }}%</div>
            <div class="progress-label-large">Course Progress</div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-details">
                <span class="stat-number">{{ $attendedSessions }}/{{ $totalSessions }}</span>
                <span class="stat-label">Sessions Attended</span>
                <small style="color: var(--text-gray);">{{ $attendanceRate }}% attendance</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="stat-details">
                <span class="stat-number">{{ $submittedAssignments }}/{{ $totalAssignments }}</span>
                <span class="stat-label">Assignments Done</span>
                <small style="color: var(--text-gray);">{{ $submissionRate }}% submission</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-details">
                <span class="stat-number">{{ $averageGrade }}</span>
                <span class="stat-label">Average Grade</span>
                <small style="color: var(--text-gray);">out of 100</small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-details">
                <span class="stat-number">{{ $enrollment->updated_at->diffForHumans() }}</span>
                <span class="stat-label">Last Activity</span>
            </div>
        </div>
    </div>

    <!-- Sessions Section -->
    <div class="section-card">
        <div class="section-header">
            <h3 class="section-title">
                <i class="fas fa-video"></i> Live Sessions Attendance
            </h3>
            <span class="section-badge">{{ $attendedSessions }} of {{ $totalSessions }} attended</span>
        </div>
        <div class="section-content">
            @if($sessions->count() > 0)
                <table class="sessions-table">
                    <thead>
                        <tr>
                            <th>Session</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th>Attendance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sessions as $session)
                            <tr>
                                <td>
                                    <strong>{{ $session->title }}</strong>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($session->start_time)->format('M d, Y - h:i A') }}</td>
                                <td>
                                    <span class="status-badge status-{{ $session->status }}">
                                        {{ ucfirst($session->status) }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $attended = $attendance->firstWhere('course_session_id', $session->id);
                                    @endphp
                                    @if($attended && $attended->attended)
                                        <span class="attended-badge attended-yes">
                                            <i class="fas fa-check-circle"></i> Attended
                                        </span>
                                    @else
                                        <span class="attended-badge attended-no">
                                            <i class="fas fa-times-circle"></i> Missed
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-video"></i>
                    <p>No sessions scheduled for this course yet.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Assignments Section -->
    <div class="section-card">
        <div class="section-header">
            <h3 class="section-title">
                <i class="fas fa-tasks"></i> Assignments & Grades
            </h3>
            <span class="section-badge">Avg: {{ $averageGrade }}</span>
        </div>
        <div class="section-content">
            @if($assignments->count() > 0)
                <table class="assignments-table">
                    <thead>
                        <tr>
                            <th>Assignment</th>
                            <th>Due Date</th>
                            <th>Submitted</th>
                            <th>Grade</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignments as $assignment)
                            @php
                                $submission = $assignment->submissions->first();
                                $isSubmitted = !is_null($submission);
                                $isLate = $isSubmitted && $assignment->due_date && $submission->submitted_at > $assignment->due_date;
                                $gradeClass = 'grade-pending';
                                if ($isSubmitted && $submission->grade) {
                                    if ($submission->grade >= 80) $gradeClass = 'grade-high';
                                    elseif ($submission->grade >= 60) $gradeClass = 'grade-medium';
                                    else $gradeClass = 'grade-low';
                                }
                            @endphp
                            <tr>
                                <td>
                                    <strong>{{ $assignment->title }}</strong>
                                </td>
                                <td>
                                    @if($assignment->due_date)
                                        {{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') }}
                                        @if($assignment->due_date->isPast() && !$isSubmitted)
                                            <span style="color: #b91c1c; font-size: 11px;">(Overdue)</span>
                                        @endif
                                    @else
                                        No due date
                                    @endif
                                </td>
                                <td>
                                    @if($isSubmitted)
                                        {{ $submission->submitted_at->format('M d, Y') }}
                                        @if($isLate)
                                            <span style="color: #d97706; font-size: 11px;">(Late)</span>
                                        @endif
                                    @else
                                        <span style="color: #94a3b8;">Not submitted</span>
                                    @endif
                                </td>
                                <td>
                                    @if($isSubmitted && $submission->grade)
                                        <span class="grade-badge {{ $gradeClass }}">
                                            {{ $submission->grade }}/{{ $assignment->points }}
                                        </span>
                                    @elseif($isSubmitted)
                                        <span class="grade-badge grade-pending">Pending</span>
                                    @else
                                        <span class="grade-badge grade-pending">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($isSubmitted)
                                        @if($submission->grade)
                                            <span style="color: #15803d;"><i class="fas fa-check-circle"></i> Graded</span>
                                        @else
                                            <span style="color: #d97706;"><i class="fas fa-clock"></i> Awaiting Grade</span>
                                        @endif
                                    @else
                                        <span style="color: #64748b;"><i class="fas fa-hourglass"></i> Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-tasks"></i>
                    <p>No assignments created for this course yet.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Activity Timeline -->
    <div class="section-card">
        <div class="section-header">
            <h3 class="section-title">
                <i class="fas fa-history"></i> Recent Activity
            </h3>
            <span class="section-badge">Last 20 activities</span>
        </div>
        <div class="section-content">
            @if($activities->count() > 0)
                <div class="timeline">
                    @foreach($activities as $activity)
                        <div class="timeline-item">
                            <div class="timeline-icon {{ $activity['color'] }}">
                                <i class="{{ $activity['icon'] }}"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <span class="timeline-title">{{ $activity['title'] }}</span>
                                    <span class="timeline-time">{{ $activity['date']->diffForHumans() }}</span>
                                </div>
                                @if(isset($activity['grade']))
                                    <div class="timeline-sub">
                                        Grade: {{ $activity['grade'] }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-history"></i>
                    <p>No recent activity found.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons-container">
        <button class="btn-action primary" onclick="sendMessage({{ $student->id }}, '{{ $student->name }}')">
            <i class="fas fa-envelope"></i> Send Message
        </button>
        @if($enrollment->progress_percentage >= 100)
            <button class="btn-action pdf" onclick="generateCertificate({{ $enrollment->id }}, 100, '{{ $student->name }}')">
                <i class="fas fa-certificate"></i> Generate Certificate
            </button>
        @endif
    </div>
</div>

<!-- Message Modal -->
<div class="modal" id="messageModal" onclick="if(event.target === this) closeMessageModal()">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fas fa-envelope"></i> Send Message to <span id="studentName"></span></h3>
            <button class="close-btn" onclick="closeMessageModal()">&times;</button>
        </div>
        <form id="messageForm">
            @csrf
            <input type="hidden" id="receiverId" name="receiver_id">
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <div class="form-group">
                <textarea name="message" class="form-control" rows="4" placeholder="Type your message..." required></textarea>
            </div>
            <div class="modal-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-paper-plane"></i> Send
                </button>
                <button type="button" class="btn-secondary" onclick="closeMessageModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Message functions
    function sendMessage(userId, userName) {
        document.getElementById('studentName').textContent = userName;
        document.getElementById('receiverId').value = userId;
        document.getElementById('messageModal').style.display = 'flex';
    }

    function closeMessageModal() {
        document.getElementById('messageModal').style.display = 'none';
    }

    document.getElementById('messageForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = this.querySelector('textarea[name="message"]').value;
        const receiverId = document.getElementById('receiverId').value;

        if (!message.trim()) {
            Swal.fire('Warning', 'Please enter a message', 'warning');
            return;
        }

        fetch('/messages/send', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ 
                receiver_id: receiverId, 
                message: message,
                course_id: '{{ $course->id }}'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Message sent successfully',
                    timer: 2000,
                    showConfirmButton: false
                });
                closeMessageModal();
                this.reset();
            } else {
                Swal.fire('Error', data.message || 'Failed to send message', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Something went wrong', 'error');
        });
    });

    function generateCertificate(enrollmentId, progress, studentName) {
        if (progress < 100) {
            Swal.fire({
                icon: 'info',
                title: 'Course Not Completed',
                text: `${studentName} has only completed ${progress}%`,
                confirmButtonColor: '#2d3e50'
            });
            return;
        }
        Swal.fire({
            title: 'Generate Certificate',
            text: `Generate certificate for ${studentName}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Generate',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#2d3e50',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                window.open(`/instructor/certificate/${enrollmentId}`, '_blank');
                Swal.fire({
                    icon: 'success',
                    title: 'Certificate Generated!',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    }
</script>
@endsection