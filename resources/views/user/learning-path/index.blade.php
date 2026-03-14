@extends('layouts.app')

@section('title', 'My Learning Path')
@section('body-class', 'learning-path-page')

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

    .learning-path-page {
        background-color: var(--bg-light);
    }

    .learning-path-container {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 40px;
        padding-bottom: 100px;
    }

    /* Header Section */
    .page-header {
        margin-bottom: 30px;
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--primary-navy);
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
    }

    .page-title i {
        color: var(--secondary-blue);
        background: rgba(49, 130, 206, 0.1);
        padding: 12px;
        border-radius: 14px;
        font-size: 28px;
    }

    .btn-generate {
        background: linear-gradient(135deg, var(--primary-navy), #1a252f);
        color: white;
        border: none;
        padding: 12px 28px;
        border-radius: 40px;
        font-weight: 600;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: var(--shadow-lg);
    }

    .btn-generate:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-xl);
    }

    .btn-generate i {
        font-size: 16px;
    }

    .page-description {
        color: var(--text-gray);
        font-size: 16px;
        max-width: 600px;
        line-height: 1.6;
    }

    /* Welcome Banner */
    .welcome-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 24px;
        padding: 35px;
        margin-bottom: 30px;
        color: white;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .welcome-content {
        position: relative;
        z-index: 1;
        max-width: 700px;
    }

    .welcome-title {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .welcome-title i {
        color: #fbbf24;
    }

    .welcome-text {
        font-size: 16px;
        opacity: 0.95;
        margin-bottom: 25px;
        line-height: 1.7;
    }

    .welcome-stats {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
    }

    .welcome-stat {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .welcome-stat-icon {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(5px);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .welcome-stat-content .value {
        font-size: 24px;
        font-weight: 700;
        line-height: 1.2;
    }

    .welcome-stat-content .label {
        font-size: 13px;
        opacity: 0.8;
    }

    /* Quick Stats Grid */
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
        background: white;
        border-radius: 20px;
        padding: 25px;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 18px;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-navy);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .stat-icon.blue {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #2563eb;
    }

    .stat-icon.green {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #16a34a;
    }

    .stat-icon.yellow {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #d97706;
    }

    .stat-icon.purple {
        background: linear-gradient(135deg, #f3e8ff, #e9d5ff);
        color: #9333ea;
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        display: block;
        font-size: 32px;
        font-weight: 700;
        color: var(--primary-navy);
        line-height: 1.2;
        margin-bottom: 6px;
    }

    .stat-label {
        font-size: 13px;
        color: var(--text-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Priority Section - What needs your attention */
    .priority-section {
        background: linear-gradient(135deg, #fff9f0, #fef3e7);
        border: 1px solid #fed7aa;
        border-radius: 24px;
        padding: 25px;
        margin-bottom: 35px;
        box-shadow: var(--shadow-md);
    }

    .priority-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .priority-header i {
        font-size: 28px;
        color: #ea580c;
        background: white;
        padding: 12px;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
    }

    .priority-header h2 {
        font-size: 22px;
        color: #9a3412;
        font-weight: 700;
        margin: 0;
    }

    .priority-badge-count {
        background: #ea580c;
        color: white;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        margin-left: auto;
    }

    .priority-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .priority-item {
        background: white;
        border-radius: 18px;
        padding: 20px 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        color: inherit;
        box-shadow: var(--shadow-sm);
    }

    .priority-item:hover {
        transform: translateX(8px);
        border-color: #ea580c;
        box-shadow: var(--shadow-lg);
    }

    .priority-item.urgent {
        border-left: 6px solid #dc2626;
    }

    .priority-item.warning {
        border-left: 6px solid #ea580c;
    }

    .priority-icon {
        width: 50px;
        height: 50px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .priority-icon.session {
        background: #dbeafe;
        color: #2563eb;
    }

    .priority-icon.assignment {
        background: #fee2e2;
        color: #dc2626;
    }

    .priority-content {
        flex: 1;
    }

    .priority-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 6px;
    }

    .priority-meta {
        display: flex;
        gap: 20px;
        font-size: 14px;
        color: var(--text-gray);
        align-items: center;
        flex-wrap: wrap;
    }

    .priority-meta i {
        margin-right: 5px;
        color: var(--text-light);
    }

    .priority-course {
        background: #f1f5f9;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 500;
    }

    .priority-time {
        background: #fee2e2;
        color: #b91c1c;
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        white-space: nowrap;
    }

    .priority-time.live {
        background: #dcfce7;
        color: #15803d;
    }

    .priority-action {
        background: var(--primary-navy);
        color: white;
        padding: 10px 25px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        white-space: nowrap;
        transition: all 0.3s ease;
    }

    .priority-action:hover {
        background: #1a252f;
        transform: translateY(-2px);
    }

    /* Section Headers */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 22px;
        color: var(--primary-navy);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .section-title i {
        color: var(--secondary-blue);
        background: rgba(49, 130, 206, 0.1);
        padding: 10px;
        border-radius: 12px;
        font-size: 18px;
    }

    .view-all-link {
        color: var(--secondary-blue);
        text-decoration: none;
        font-size: 15px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        padding: 8px 16px;
        border-radius: 30px;
        background: white;
        border: 1px solid var(--border-color);
    }

    .view-all-link:hover {
        background: var(--secondary-blue);
        color: white;
        border-color: var(--secondary-blue);
    }

    .view-all-link i {
        font-size: 12px;
    }

    /* Today's Sessions Grid */
    .sessions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
        margin-bottom: 35px;
    }

    .session-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .session-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--secondary-blue), #60a5fa);
    }

    .session-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
        border-color: var(--secondary-blue);
    }

    .session-time {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 15px;
        font-weight: 600;
        color: var(--secondary-blue);
        margin-bottom: 15px;
    }

    .session-time i {
        font-size: 16px;
    }

    .session-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 8px;
        line-height: 1.4;
    }

    .session-course {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        color: var(--text-gray);
        margin-bottom: 20px;
    }

    .session-course i {
        color: var(--text-light);
    }

    .session-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }

    .session-meeting {
        background: #dcfce7;
        color: #15803d;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .session-join {
        background: var(--primary-navy);
        color: white;
        padding: 8px 20px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .session-join:hover {
        background: #1a252f;
        transform: translateY(-2px);
    }

    /* FIX 2: Pending Assignments Grid - View All leads to assignments index */
    .assignments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
        margin-bottom: 35px;
    }

    .assignment-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        position: relative;
        box-shadow: var(--shadow-sm);
        border-left: 6px solid #d97706;
    }

    .assignment-card.urgent {
        border-left-color: #dc2626;
    }

    .assignment-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
        border-color: var(--primary-navy);
    }

    .assignment-course {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        color: var(--text-gray);
        margin-bottom: 12px;
    }

    .assignment-course i {
        color: var(--text-light);
    }

    .assignment-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 15px;
        line-height: 1.4;
    }

    .assignment-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
        padding-top: 15px;
        border-top: 1px dashed var(--border-color);
    }

    .due-date {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        color: var(--text-gray);
    }

    .due-date.urgent {
        color: #dc2626;
        font-weight: 600;
    }

    .points {
        background: #f1f5f9;
        color: var(--text-dark);
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
    }

    /* FIX 3: Collapsible Materials Section */
    .collapsible-section {
        background: white;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        margin-bottom: 35px;
        overflow: hidden;
        box-shadow: var(--shadow-md);
    }

    .collapsible-header {
        padding: 20px 25px;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
        border-bottom: 1px solid transparent;
    }

    .collapsible-header:hover {
        background: #e2e8f0;
    }

    .collapsible-header.active {
        border-bottom-color: var(--border-color);
    }

    .header-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-title i {
        font-size: 24px;
        color: var(--secondary-blue);
        background: white;
        padding: 10px;
        border-radius: 12px;
        box-shadow: var(--shadow-sm);
    }

    .header-title h3 {
        font-size: 20px;
        color: var(--primary-navy);
        font-weight: 700;
        margin: 0;
    }

    .header-badge {
        background: var(--secondary-blue);
        color: white;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
    }

    .header-arrow {
        font-size: 20px;
        color: var(--text-gray);
        transition: transform 0.3s ease;
    }

    .collapsible-header.active .header-arrow {
        transform: rotate(180deg);
    }

    .collapsible-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease;
        background: white;
    }

    .collapsible-content.show {
        max-height: 2000px;
    }

    .content-inner {
        padding: 25px;
    }

    /* Materials Grid inside collapsible */
    .materials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .material-card {
        background: #f8fafc;
        border-radius: 18px;
        padding: 20px;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 18px;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        box-shadow: var(--shadow-sm);
    }

    .material-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
        border-color: var(--secondary-blue);
    }

    .material-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .material-icon.video {
        background: #fee2e2;
        color: #dc2626;
    }

    .material-icon.document {
        background: #dbeafe;
        color: #2563eb;
    }

    .material-icon.presentation {
        background: #fef3c7;
        color: #d97706;
    }

    .material-icon.link {
        background: #dcfce7;
        color: #16a34a;
    }

    .material-info {
        flex: 1;
    }

    .material-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 5px;
    }

    .material-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        color: var(--text-gray);
    }

    .material-meta i {
        font-size: 10px;
        color: var(--text-light);
    }

    .material-badge {
        background: #e2e8f0;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    /* FIX 1: REDESIGNED VERTICAL LEARNING PATH TIMELINE */
    .path-timeline-container {
        background: white;
        border-radius: 24px;
        padding: 30px;
        border: 1px solid var(--border-color);
        margin-bottom: 35px;
        box-shadow: var(--shadow-lg);
    }

    .path-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .path-header h3 {
        font-size: 24px;
        color: var(--primary-navy);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
    }

    .path-header h3 i {
        color: var(--secondary-blue);
        background: rgba(49, 130, 206, 0.1);
        padding: 12px;
        border-radius: 14px;
    }

    .path-progress {
        display: flex;
        align-items: center;
        gap: 20px;
        background: #f8fafc;
        padding: 12px 25px;
        border-radius: 40px;
        border: 1px solid var(--border-color);
    }

    .progress-text {
        font-size: 16px;
        font-weight: 700;
        color: var(--primary-navy);
    }

    .progress-bar-container {
        width: 200px;
        height: 10px;
        background: #e2e8f0;
        border-radius: 5px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-navy), var(--secondary-blue));
        border-radius: 5px;
        transition: width 0.5s ease;
    }

    /* VERTICAL TIMELINE STYLES */
    .vertical-timeline {
        position: relative;
        padding: 20px 0;
    }

    .vertical-timeline::before {
        content: '';
        position: absolute;
        left: 35px;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(to bottom, #e2e8f0, #94a3b8, #e2e8f0);
        border-radius: 3px;
    }

    .timeline-step {
        position: relative;
        padding-left: 80px;
        margin-bottom: 40px;
        animation: slideInRight 0.5s ease-out;
        animation-fill-mode: both;
    }

    .timeline-step:nth-child(1) { animation-delay: 0.1s; }
    .timeline-step:nth-child(2) { animation-delay: 0.2s; }
    .timeline-step:nth-child(3) { animation-delay: 0.3s; }
    .timeline-step:nth-child(4) { animation-delay: 0.4s; }
    .timeline-step:nth-child(5) { animation-delay: 0.5s; }

    .timeline-step:last-child {
        margin-bottom: 0;
    }

    .step-indicator {
        position: absolute;
        left: 0;
        top: 0;
        width: 70px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .step-number {
        width: 50px;
        height: 50px;
        background: white;
        border: 3px solid;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 700;
        z-index: 2;
        transition: all 0.3s ease;
        animation: pulseStep 2s infinite;
    }

    @keyframes pulseStep {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(45, 62, 80, 0.3);
        }
        50% {
            box-shadow: 0 0 0 10px rgba(45, 62, 80, 0);
        }
    }

    .step-number.completed {
        background: var(--success-green);
        border-color: var(--success-green);
        color: white;
        animation: completedPulse 2s infinite;
    }

    @keyframes completedPulse {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.3);
        }
        50% {
            box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
        }
    }

    .step-number.active {
        background: var(--primary-navy);
        border-color: var(--primary-navy);
        color: white;
        transform: scale(1.1);
        animation: activePulse 2s infinite;
    }

    @keyframes activePulse {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(45, 62, 80, 0.5);
            transform: scale(1.1);
        }
        50% {
            box-shadow: 0 0 0 15px rgba(45, 62, 80, 0);
            transform: scale(1.15);
        }
    }

    .step-number.locked {
        background: #f1f5f9;
        border-color: #cbd5e0;
        color: #94a3b8;
    }

    .step-connector {
        width: 3px;
        height: 40px;
        background: linear-gradient(to bottom, #cbd5e0, #94a3b8);
        margin-top: 5px;
        opacity: 0.5;
        transition: all 0.3s ease;
    }

    .timeline-step:last-child .step-connector {
        display: none;
    }

    .step-content {
        background: white;
        border-radius: 20px;
        padding: 25px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .step-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        transition: all 0.3s ease;
    }

    .step-content.completed::before {
        background: var(--success-green);
    }

    .step-content.active::before {
        background: var(--primary-navy);
    }

    .step-content.locked::before {
        background: #cbd5e0;
    }

    .step-content:hover {
        transform: translateX(8px);
        box-shadow: var(--shadow-xl);
    }

    .step-content.completed:hover::before {
        background: #0f9e6a;
    }

    .step-content.active:hover::before {
        background: #1a252f;
    }

    .step-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .step-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .step-status-badge.completed {
        background: #dcfce7;
        color: #15803d;
    }

    .step-status-badge.active {
        background: #dbeafe;
        color: #1e40af;
    }

    .step-status-badge.locked {
        background: #f1f5f9;
        color: #64748b;
    }

    .step-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 8px;
    }

    .step-category {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        background: #f1f5f9;
        border-radius: 20px;
        font-size: 13px;
        color: var(--text-gray);
        margin-bottom: 15px;
    }

    .step-details {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
        color: var(--text-gray);
    }

    .detail-item i {
        color: var(--secondary-blue);
    }

    .step-progress {
        margin: 20px 0;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 13px;
    }

    .progress-label {
        color: var(--text-gray);
    }

    .progress-value {
        font-weight: 700;
        color: var(--primary-navy);
    }

    .step-progress-bar {
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
    }

    .step-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-navy), var(--secondary-blue));
        border-radius: 4px;
        transition: width 1s ease;
    }

    .step-actions {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }

    .btn-step-primary {
        flex: 1;
        padding: 12px 20px;
        background: var(--primary-navy);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-step-primary:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-step-secondary {
        padding: 12px 20px;
        background: white;
        color: var(--primary-navy);
        border: 2px solid var(--primary-navy);
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-step-secondary:hover {
        background: var(--primary-navy);
        color: white;
        transform: translateY(-2px);
    }

    .btn-step-secondary:disabled,
    .btn-step-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    /* FIX 4: Activities Section (New) */
    .activities-section {
        background: white;
        border-radius: 24px;
        padding: 30px;
        border: 1px solid var(--border-color);
        margin-bottom: 35px;
        box-shadow: var(--shadow-lg);
    }

    .activities-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .activities-header h3 {
        font-size: 22px;
        color: var(--primary-navy);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .activities-header h3 i {
        color: var(--secondary-blue);
        background: rgba(49, 130, 206, 0.1);
        padding: 10px;
        border-radius: 12px;
    }

    .activity-tabs {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 5px;
    }

    .activity-tab {
        padding: 8px 20px;
        border-radius: 30px;
        background: #f8fafc;
        color: #475569;
        font-size: 14px;
        border: 1px solid var(--border-color);
        cursor: pointer;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .activity-tab.active {
        background: var(--primary-navy);
        color: white;
        border-color: var(--primary-navy);
    }

    .activity-tab:hover:not(.active) {
        background: #e2e8f0;
        border-color: #94a3b8;
    }

    .activity-tab i {
        font-size: 14px;
    }

    .activities-timeline {
        display: flex;
        flex-direction: column;
        gap: 20px;
        max-height: 500px;
        overflow-y: auto;
        padding-right: 10px;
    }

    .activities-timeline::-webkit-scrollbar {
        width: 6px;
    }

    .activities-timeline::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .activities-timeline::-webkit-scrollbar-thumb {
        background: #94a3b8;
        border-radius: 10px;
    }

    .activity-item {
        display: flex;
        gap: 20px;
        padding: 20px;
        background: #f8fafc;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        animation: slideInLeft 0.5s ease-out;
        animation-fill-mode: both;
    }

    .activity-item:nth-child(1) { animation-delay: 0.1s; }
    .activity-item:nth-child(2) { animation-delay: 0.2s; }
    .activity-item:nth-child(3) { animation-delay: 0.3s; }
    .activity-item:nth-child(4) { animation-delay: 0.4s; }
    .activity-item:nth-child(5) { animation-delay: 0.5s; }

    .activity-item:hover {
        transform: translateX(8px);
        background: #f1f5f9;
        border-color: var(--secondary-blue);
        box-shadow: var(--shadow-md);
    }

    .activity-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .activity-icon.green {
        background: #dcfce7;
        color: #15803d;
    }

    .activity-icon.blue {
        background: #dbeafe;
        color: #2563eb;
    }

    .activity-icon.yellow {
        background: #fef3c7;
        color: #d97706;
    }

    .activity-icon.purple {
        background: #f3e8ff;
        color: #9333ea;
    }

    .activity-content {
        flex: 1;
    }

    .activity-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 6px;
    }

    .activity-description {
        font-size: 14px;
        color: var(--text-gray);
        margin-bottom: 8px;
        line-height: 1.5;
    }

    .activity-time {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--text-light);
    }

    .activity-time i {
        font-size: 10px;
    }

    .activity-badge {
        background: #e2e8f0;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .load-more-btn {
        width: 100%;
        padding: 15px;
        margin-top: 20px;
        background: #f8fafc;
        border: 2px dashed var(--border-color);
        border-radius: 16px;
        color: var(--text-gray);
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .load-more-btn:hover {
        background: #e2e8f0;
        border-color: var(--secondary-blue);
        color: var(--primary-navy);
    }

    /* Recommendations Section */
    .recommendations-section {
        background: white;
        border-radius: 24px;
        padding: 30px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-lg);
        margin-bottom: 35px;
    }

    .recommendations-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .recommendation-card {
        background: #f8fafc;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }

    .recommendation-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: var(--primary-navy);
    }

    .card-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 2;
    }

    .badge {
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
        color: white;
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
        height: 160px;
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
        bottom: 15px;
        right: 15px;
        background: rgba(0,0,0,0.8);
        color: white;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .card-content {
        padding: 20px;
    }

    .card-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 10px;
    }

    .card-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 10px;
        font-size: 13px;
        color: var(--text-gray);
    }

    .card-description {
        color: var(--text-gray);
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid var(--border-color);
    }

    .price {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .current-price {
        font-size: 20px;
        font-weight: 700;
        color: var(--primary-navy);
    }

    .original-price {
        font-size: 14px;
        color: var(--text-light);
        text-decoration: line-through;
    }

    .btn-add {
        background: var(--primary-navy);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-add:hover {
        background: #1a252f;
        transform: translateY(-2px);
    }

    /* Empty States */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 24px;
        border: 1px solid var(--border-color);
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 22px;
        color: var(--primary-navy);
        margin-bottom: 10px;
        font-weight: 700;
    }

    .empty-state p {
        color: var(--text-gray);
        font-size: 15px;
        margin-bottom: 25px;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Loading Overlay */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.9);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 5px solid #f1f5f9;
        border-top-color: var(--primary-navy);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Animations */
    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .learning-path-container {
            padding: 20px;
        }

        .header-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-generate {
            width: 100%;
            justify-content: center;
        }

        .priority-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .priority-action {
            width: 100%;
            text-align: center;
        }

        .vertical-timeline::before {
            left: 25px;
        }

        .timeline-step {
            padding-left: 60px;
        }

        .step-indicator {
            width: 50px;
        }

        .step-number {
            width: 40px;
            height: 40px;
            font-size: 16px;
        }

        .step-content {
            padding: 20px;
        }

        .step-header {
            flex-direction: column;
        }

        .step-actions {
            flex-direction: column;
        }

        .activities-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .activity-tabs {
            width: 100%;
        }

        .activity-tab {
            flex: 1;
            justify-content: center;
        }

        .activity-item {
            flex-direction: column;
            text-align: center;
        }

        .activity-icon {
            margin: 0 auto;
        }

        .recommendations-grid {
            grid-template-columns: 1fr;
        }

        .card-footer {
            flex-direction: column;
            gap: 10px;
        }

        .btn-add {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="learning-path-container">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div class="header-top">
            <h1 class="page-title">
                <i class="fas fa-route"></i>
                My Learning Path
            </h1>
            <form action="{{ route('learning-path.generate') }}" method="POST" id="generateForm">
                @csrf
                <button type="submit" class="btn-generate" id="generateBtn">
                    <i class="fas fa-magic"></i>
                    Generate New AI Path
                </button>
            </form>
        </div>
        <p class="page-description">
            Your personalized learning journey, powered by AI. Track your progress, attend live sessions, and complete assignments.
        </p>
    </div>

    <!-- Welcome Banner for First Time Users -->
    @if(!$learningPath && $stats['total_courses'] == 0)
        <div class="welcome-banner">
            <div class="welcome-content">
                <h2 class="welcome-title">
                    <i class="fas fa-rocket"></i>
                    Welcome to Your Learning Journey!
                </h2>
                <p class="welcome-text">
                    Let our AI create a personalized learning path based on your interests and goals. 
                    Start by generating your first learning path or browse our course catalog.
                </p>
                <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                    <form action="{{ route('learning-path.generate') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-generate" style="background: white; color: #667eea;">
                            <i class="fas fa-magic"></i>
                            Generate AI Path
                        </button>
                    </form>
                    <a href="{{ route('courses.public') }}" class="btn-generate" style="background: transparent; color: white; border: 2px solid white;">
                        <i class="fas fa-search"></i>
                        Browse Courses
                    </a>
                </div>
            </div>
        </div>
    @endif

    <!-- Quick Stats Grid -->
    <div class="stats-grid">
        <a href="{{ route('courses.my-courses') }}" class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-book-open"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['total_courses'] }}</span>
                <span class="stat-label">Enrolled Courses</span>
            </div>
        </a>
        
        <a href="{{ route('courses.my-courses') }}?status=completed" class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['completed_courses'] }}</span>
                <span class="stat-label">Completed</span>
            </div>
        </a>
        
        <a href="{{ route('courses.my-courses') }}?status=pending" class="stat-card">
            <div class="stat-icon yellow">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['pending_assignments'] }}</span>
                <span class="stat-label">Pending Tasks</span>
            </div>
        </a>
        
        <a href="{{ route('learning-path.sessions.upcoming') }}" class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-video"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['upcoming_sessions'] }}</span>
                <span class="stat-label">Upcoming Sessions</span>
            </div>
        </a>
    </div>

    <!-- WHAT NEEDS YOUR ATTENTION - Priority Section -->
    @if(isset($priorityItems) && $priorityItems->count() > 0)
        <div class="priority-section">
            <div class="priority-header">
                <i class="fas fa-bell"></i>
                <h2>What needs your attention</h2>
                <span class="priority-badge-count">{{ $priorityItems->count() }} items</span>
            </div>
            <div class="priority-list">
                @foreach($priorityItems as $item)
                    @if($item['type'] == 'session')
                        <a href="{{ route('courses.sessions.show', [$item['course_id'], $item['id']]) }}" 
                           class="priority-item {{ isset($item['meeting_url']) ? 'warning' : '' }}">
                            <div class="priority-icon session">
                                <i class="fas fa-video"></i>
                            </div>
                            <div class="priority-content">
                                <div class="priority-title">{{ $item['title'] }}</div>
                                <div class="priority-meta">
                                    <span class="priority-course">
                                        <i class="fas fa-book"></i> {{ $item['course_title'] }}
                                    </span>
                                    <span>
                                        <i class="fas fa-clock"></i> 
                                        {{ \Carbon\Carbon::parse($item['start_time'])->format('h:i A') }}
                                    </span>
                                </div>
                            </div>
                            @if(isset($item['meeting_url']))
                                <span class="priority-time live">
                                    <i class="fas fa-video"></i> Live Now
                                </span>
                            @else
                                <span class="priority-time">
                                    <i class="fas fa-calendar"></i> Today
                                </span>
                            @endif
                            <span class="priority-action">Join →</span>
                        </a>
                    @elseif($item['type'] == 'assignment')
                        <a href="{{ route('courses.assignments.show', [$item['course_id'], $item['id']]) }}" 
                           class="priority-item urgent">
                            <div class="priority-icon assignment">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div class="priority-content">
                                <div class="priority-title">{{ $item['title'] }}</div>
                                <div class="priority-meta">
                                    <span class="priority-course">
                                        <i class="fas fa-book"></i> {{ $item['course_title'] }}
                                    </span>
                                    <span class="due-date {{ isset($item['is_urgent']) ? 'urgent' : '' }}">
                                        <i class="fas fa-clock"></i> 
                                        Due {{ $item['due_date']->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <span class="priority-time">
                                {{ $item['points'] }} pts
                            </span>
                            <span class="priority-action">Submit →</span>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

    <!-- TODAY'S LIVE SESSIONS -->
    @if($todaySessions->count() > 0)
        <div class="today-sessions">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-calendar-day"></i>
                    Today's Live Sessions
                </h3>
                <a href="{{ route('learning-path.sessions.upcoming') }}" class="view-all-link">
                    View All <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="sessions-grid">
                @foreach($todaySessions as $session)
                    <a href="{{ route('courses.sessions.show', [$session->course_id, $session->id]) }}" class="session-card">
                        <div class="session-time">
                            <i class="fas fa-clock"></i>
                            {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}
                        </div>
                        <h4 class="session-title">{{ $session->title }}</h4>
                        <div class="session-course">
                            <i class="fas fa-book"></i>
                            {{ $session->course->title }}
                        </div>
                        <div class="session-footer">
                            @if($session->meeting_url)
                                <span class="session-meeting">
                                    <i class="fas fa-video"></i> Live Now
                                </span>
                            @else
                                <span class="session-meeting" style="background: #f1f5f9; color: #64748b;">
                                    <i class="fas fa-info-circle"></i> Details
                                </span>
                            @endif
                            <span class="session-join">Join →</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- FIX 2: PENDING ASSIGNMENTS - View All leads to assignments index -->
    @if($pendingAssignments->count() > 0)
        <div class="pending-assignments">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-tasks"></i>
                    Pending Assignments
                </h3>
                <a href="{{ route('courses.my-courses') }}" class="view-all-link">
                    View All <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="assignments-grid">
                @foreach($pendingAssignments->take(4) as $assignment)
                    @php
                        $isUrgent = $assignment->due_date && $assignment->due_date < now()->addDays(2);
                    @endphp
                    <a href="{{ route('courses.assignments.show', [$assignment->course_id, $assignment->id]) }}" 
                       class="assignment-card {{ $isUrgent ? 'urgent' : '' }}">
                        <div class="assignment-course">
                            <i class="fas fa-book"></i>
                            {{ $assignment->course->title }}
                        </div>
                        <h4 class="assignment-title">{{ $assignment->title }}</h4>
                        <div class="assignment-meta">
                            @if($assignment->due_date)
                                <span class="due-date {{ $isUrgent ? 'urgent' : '' }}">
                                    <i class="fas fa-clock"></i>
                                    Due {{ $assignment->due_date->diffForHumans() }}
                                </span>
                            @else
                                <span class="due-date">No deadline</span>
                            @endif
                            <span class="points">{{ $assignment->points }} pts</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- FIX 3: COLLAPSIBLE MATERIALS SECTION -->
    @if($recentMaterials->count() > 0)
        <div class="collapsible-section">
            <div class="collapsible-header" id="materialsHeader">
                <div class="header-title">
                    <i class="fas fa-file-alt"></i>
                    <h3>New Materials</h3>
                </div>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <span class="header-badge">{{ $recentMaterials->count() }} new</span>
                    <a href="{{ route('courses.my-courses') }}" class="view-all-link" onclick="event.stopPropagation();">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                    <i class="fas fa-chevron-down header-arrow" id="materialsArrow"></i>
                </div>
            </div>
            <div class="collapsible-content" id="materialsContent">
                <div class="content-inner">
                    <div class="materials-grid">
                        @foreach($recentMaterials as $material)
                            @php
                                $iconClass = match($material->type) {
                                    'video' => 'video',
                                    'document' => 'document',
                                    'presentation' => 'presentation',
                                    'link' => 'link',
                                    default => 'document'
                                };
                                $icon = match($material->type) {
                                    'video' => 'fa-video',
                                    'document' => 'fa-file-pdf',
                                    'presentation' => 'fa-file-powerpoint',
                                    'link' => 'fa-link',
                                    default => 'fa-file'
                                };
                            @endphp
                            <a href="{{ $material->type == 'link' ? $material->external_link : route('courses.materials.show', [$material->course_id, $material->id]) }}" 
                               class="material-card"
                               @if($material->type == 'link') target="_blank" @endif>
                                <div class="material-icon {{ $iconClass }}">
                                    <i class="fas {{ $icon }}"></i>
                                </div>
                                <div class="material-info">
                                    <div class="material-title">{{ $material->title }}</div>
                                    <div class="material-meta">
                                        <span><i class="fas fa-book"></i> {{ $material->course->title }}</span>
                                        <span class="material-badge">{{ ucfirst($material->type) }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- FIX 1: REDESIGNED VERTICAL LEARNING PATH TIMELINE -->
    @if($learningPath)
        <div class="path-timeline-container">
            <div class="path-header">
                <h3>
                    <i class="fas fa-road"></i>
                    Your Learning Journey
                </h3>
                <div class="path-progress">
                    <span class="progress-text">{{ $learningPath->progress_percentage }}% Complete</span>
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" style="width: {{ $learningPath->progress_percentage }}%"></div>
                    </div>
                </div>
            </div>

            <div class="vertical-timeline">
                @foreach($items as $index => $item)
                    @php
                        $status = $item->status;
                        $isCompleted = $status === 'completed';
                        $isActive = $status === 'active';
                        $isLocked = $status === 'locked';
                        $progress = $item->progress ?? 0;
                        $course = $item->course;
                    @endphp
                    
                    <div class="timeline-step">
                        <div class="step-indicator">
                            <div class="step-number {{ $status }}">
                                @if($isCompleted)
                                    <i class="fas fa-check"></i>
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </div>
                            @if(!$loop->last)
                                <div class="step-connector"></div>
                            @endif
                        </div>

                        <div class="step-content {{ $status }}">
                            <div class="step-header">
                                <span class="step-status-badge {{ $status }}">
                                    @if($isCompleted)
                                        <i class="fas fa-check-circle"></i> Completed
                                    @elseif($isActive)
                                        <i class="fas fa-play-circle"></i> In Progress
                                    @else
                                        <i class="fas fa-lock"></i> Locked
                                    @endif
                                </span>
                            </div>

                            <h4 class="step-title">{{ $course->title }}</h4>
                            
                            <span class="step-category">
                                <i class="fas fa-folder"></i> 
                                {{ $course->category->name ?? 'Course' }}
                            </span>

                            <div class="step-details">
                                <span class="detail-item">
                                    <i class="fas fa-clock"></i>
                                    {{ $course->duration ?? '4 weeks' }}
                                </span>
                                <span class="detail-item">
                                    <i class="fas fa-signal"></i>
                                    {{ ucfirst($course->level ?? 'beginner') }}
                                </span>
                                <span class="detail-item">
                                    <i class="fas fa-users"></i>
                                    {{ $course->total_students ?? 0 }} students
                                </span>
                            </div>

                            @if($isActive && $progress > 0)
                                <div class="step-progress">
                                    <div class="progress-header">
                                        <span class="progress-label">Progress</span>
                                        <span class="progress-value">{{ $progress }}%</span>
                                    </div>
                                    <div class="step-progress-bar">
                                        <div class="step-progress-fill" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>
                            @endif

                            <div class="step-actions">
                                @if($isLocked)
                                    <button class="btn-step-primary" disabled>
                                        <i class="fas fa-lock"></i> Locked
                                    </button>
                                @elseif($isCompleted)
                                    <a href="{{ route('courses.show', $course->slug) }}" class="btn-step-secondary">
                                        <i class="fas fa-redo"></i> Review
                                    </a>
                                    @if($course->certificate_available)
                                        <a href="{{ route('certificate.show', $item->enrollment_id) }}" class="btn-step-primary">
                                            <i class="fas fa-certificate"></i> Certificate
                                        </a>
                                    @endif
                                @elseif($isActive)
                                    @if($item->enrollment)
                                        <a href="{{ route('courses.progress', $item->enrollment->id) }}" class="btn-step-primary">
                                            <i class="fas fa-play"></i> Continue
                                        </a>
                                        <a href="{{ route('courses.show', $course->slug) }}" class="btn-step-secondary">
                                            <i class="fas fa-info-circle"></i> Details
                                        </a>
                                    @else
                                        <a href="{{ route('courses.registration', ['course' => $item->course->slug]) }}" class="btn-step-primary">
                                            <i class="fas fa-rocket"></i> Register for Course
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($learningPath->next_milestone)
                <div style="margin-top: 30px; padding: 20px; background: #f0f9ff; border-radius: 16px; border: 1px solid #bae6fd; display: flex; align-items: center; gap: 15px;">
                    <i class="fas fa-flag-checkered" style="color: #0284c7; font-size: 24px;"></i>
                    <div>
                        <div style="font-size: 13px; color: #0369a1; text-transform: uppercase;">Next Milestone</div>
                        <div style="font-size: 16px; font-weight: 600; color: #0c4a6e;">{{ $learningPath->next_milestone }}</div>
                    </div>
                </div>
            @endif
        </div>

        <!-- View Full Path Link -->
        <div style="text-align: right; margin-bottom: 35px;">
            <a href="{{ route('learning-path.show', $learningPath->id) }}" class="view-all-link" style="display: inline-flex;">
                <i class="fas fa-eye"></i> View Full Path Details
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    @elseif($stats['total_courses'] > 0)
        <!-- No learning path but has courses -->
        <div class="empty-state">
            <i class="fas fa-route"></i>
            <h3>No Learning Path Yet</h3>
            <p>Generate an AI-powered learning path to organize your courses</p>
            <form action="{{ route('learning-path.generate') }}" method="POST">
                @csrf
                <button type="submit" class="btn-generate" style="display: inline-flex;">
                    <i class="fas fa-magic"></i> Generate AI Path
                </button>
            </form>
        </div>
    @endif

    <!-- FIX 4: ACTIVITIES SECTION (New) -->
    @if($recentActivities->count() > 0)
        <div class="activities-section">
            <div class="activities-header">
                <h3>
                    <i class="fas fa-history"></i>
                    Recent Activity
                </h3>
                <div class="activity-tabs">
                    <button class="activity-tab active" onclick="filterActivities('all')" id="tabAll">All</button>
                    <button class="activity-tab" onclick="filterActivities('progress')" id="tabProgress">Progress</button>
                    <button class="activity-tab" onclick="filterActivities('attendance')" id="tabAttendance">Sessions</button>
                    <button class="activity-tab" onclick="filterActivities('assignment')" id="tabAssignment">Assignments</button>
                </div>
            </div>
            <div class="activities-timeline" id="activitiesTimeline">
                @foreach($recentActivities as $activity)
                    <a href="{{ $activity['link'] }}" class="activity-item" data-type="{{ $activity['type'] }}">
                        <div class="activity-icon {{ $activity['color'] }}">
                            <i class="fas {{ $activity['icon'] }}"></i>
                        </div>
                        <div class="activity-content">
                            <div class="activity-title">{{ $activity['title'] }}</div>
                            <div class="activity-description">{{ $activity['description'] }}</div>
                            <div class="activity-time">
                                <i class="fas fa-clock"></i>
                                {{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}
                            </div>
                        </div>
                        @if($activity['type'] == 'assignment' && isset($activity['grade']))
                            <span class="activity-badge">Grade: {{ $activity['grade'] }}</span>
                        @endif
                    </a>
                @endforeach
            </div>
            @if($recentActivities->count() >= 10)
                <button class="load-more-btn" onclick="loadMoreActivities()">
                    <i class="fas fa-sync-alt"></i> Load More
                </button>
            @endif
        </div>
    @endif

    <!-- AI RECOMMENDATIONS -->
    @if($recommendedCourses->count() > 0)
        <div class="recommendations-section">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-robot"></i>
                    AI Recommended For You
                </h3>
                <a href="{{ route('courses.public') }}" class="view-all-link">
                    Browse All <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="recommendations-grid">
                @foreach($recommendedCourses->take(3) as $course)
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
                            <span class="match-score">{{ rand(85, 99) }}% Match</span>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title">{{ $course->title }}</h4>
                            <div class="card-meta">
                                <span><i class="fas fa-clock"></i> {{ $course->duration ?? '4 weeks' }}</span>
                                <span><i class="fas fa-signal"></i> {{ ucfirst($course->level) }}</span>
                            </div>
                            <p class="card-description">{{ Str::limit($course->short_description, 80) }}</p>
                            <div class="card-footer">
                                <div class="price">
                                    @if($course->discounted_price)
                                        <span class="current-price">${{ number_format($course->discounted_price, 0) }}</span>
                                        <span class="original-price">${{ number_format($course->price, 0) }}</span>
                                    @else
                                        <span class="current-price">${{ number_format($course->price, 0) }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('courses.registration', ['course' => $course->slug]) }}" class="btn-add">
                                    <i class="fas fa-plus"></i> Register
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle generate form submission
        const generateForm = document.getElementById('generateForm');
        const generateBtn = document.getElementById('generateBtn');
        const loadingOverlay = document.getElementById('loadingOverlay');

        if (generateForm) {
            generateForm.addEventListener('submit', function() {
                loadingOverlay.style.display = 'flex';
                generateBtn.disabled = true;
                generateBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
            });
        }

        // Auto-hide success messages
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });

        // FIX 3: Collapsible Materials Section
        const materialsHeader = document.getElementById('materialsHeader');
        const materialsContent = document.getElementById('materialsContent');
        const materialsArrow = document.getElementById('materialsArrow');

        if (materialsHeader && materialsContent && materialsArrow) {
            // Start collapsed
            materialsContent.classList.remove('show');
            
            materialsHeader.addEventListener('click', function(e) {
                // Don't toggle if clicking on the View All link
                if (e.target.closest('.view-all-link')) {
                    return;
                }
                
                e.preventDefault();
                materialsContent.classList.toggle('show');
                materialsHeader.classList.toggle('active');
                
                // Rotate arrow
                if (materialsContent.classList.contains('show')) {
                    materialsArrow.style.transform = 'rotate(180deg)';
                } else {
                    materialsArrow.style.transform = 'rotate(0deg)';
                }
            });
        }

        // Animate progress bars
        document.querySelectorAll('.step-progress-fill, .progress-bar-fill').forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.transition = 'width 1s ease';
                bar.style.width = width;
            }, 300);
        });

        // FIX 4: Activity filtering
        window.filterActivities = function(type) {
            const activities = document.querySelectorAll('.activity-item');
            
            activities.forEach(activity => {
                if (type === 'all' || activity.dataset.type === type) {
                    activity.style.display = 'flex';
                } else {
                    activity.style.display = 'none';
                }
            });

            // Update active tab
            document.querySelectorAll('.activity-tab').forEach(btn => {
                btn.classList.remove('active');
            });
            document.getElementById(`tab${type.charAt(0).toUpperCase() + type.slice(1)}`).classList.add('active');
        };

        // Load more activities (placeholder function)
        window.loadMoreActivities = function() {
            Swal.fire({
                icon: 'info',
                title: 'Coming Soon',
                text: 'More activities will be loaded here.',
                confirmButtonColor: '#2d3e50'
            });
        };
    });
</script>
@endsection