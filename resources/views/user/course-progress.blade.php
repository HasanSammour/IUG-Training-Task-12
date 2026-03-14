@extends('layouts.app')

@section('title', $enrollment->course->title . ' - Progress')
@section('body-class', 'auth-page')

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
    }

    .auth-page {
        background-color: var(--bg-light);
    }

    .course-progress-container {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 40px;
        padding-bottom: 100px;
    }

    /* Hero Header */
    .hero-header {
        background: linear-gradient(135deg, var(--primary-navy) 0%, #1a252f 100%);
        border-radius: 30px;
        padding: 40px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .hero-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 30px;
    }

    .hero-left {
        flex: 1;
        min-width: 300px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        font-size: 15px;
        margin-bottom: 20px;
        padding: 8px 20px;
        background: rgba(255,255,255,0.1);
        border-radius: 30px;
        transition: all 0.3s ease;
    }

    .back-link:hover {
        background: rgba(255,255,255,0.2);
        color: white;
        transform: translateX(-5px);
    }

    .course-title {
        font-size: 36px;
        font-weight: 700;
        color: white;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .instructor-info {
        display: flex;
        align-items: center;
        gap: 10px;
        color: rgba(255,255,255,0.8);
        font-size: 16px;
        margin-bottom: 20px;
    }

    .instructor-info i {
        color: var(--secondary-blue);
    }

    .course-meta-badges {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .meta-badge {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(5px);
        padding: 8px 18px;
        border-radius: 30px;
        border: 1px solid rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: white;
    }

    .meta-badge i {
        color: var(--secondary-blue);
    }

    .hero-right {
        text-align: center;
    }

    .progress-circle-large {
        width: 140px;
        height: 140px;
        position: relative;
    }

    .circular-chart {
        width: 100%;
        height: 100%;
        transform: rotate(-90deg);
    }

    .circle-bg {
        stroke: rgba(255,255,255,0.2);
        stroke-width: 8;
        fill: none;
    }

    .circle-progress {
        stroke: var(--secondary-blue);
        stroke-width: 8;
        fill: none;
        stroke-linecap: round;
        stroke-dasharray: 100.53;
        stroke-dashoffset: 100.53;
        transition: stroke-dashoffset 1.5s ease;
    }

    .progress-text-large {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 32px;
        font-weight: 700;
        color: white;
    }

    .progress-label-large {
        position: absolute;
        bottom: -25px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 13px;
        color: rgba(255,255,255,0.7);
        white-space: nowrap;
    }

    /* Learning Path Context */
    .path-context-card {
        background: linear-gradient(135deg, #f0f9ff 0%, #e6f0fa 100%);
        border: 1px solid #bae6fd;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .path-icon {
        width: 60px;
        height: 60px;
        background: var(--secondary-blue);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .path-content {
        flex: 1;
    }

    .path-title {
        font-size: 16px;
        font-weight: 600;
        color: #0369a1;
        margin-bottom: 5px;
    }

    .path-description {
        font-size: 14px;
        color: #0c4a6e;
        margin-bottom: 0;
    }

    .path-button {
        background: white;
        color: #0369a1;
        border: 1px solid #bae6fd;
        padding: 10px 25px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .path-button:hover {
        background: var(--secondary-blue);
        color: white;
        border-color: var(--secondary-blue);
        transform: translateY(-2px);
    }

    /* Quick Stats Row */
    .quick-stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 35px;
    }

    @media (max-width: 992px) {
        .quick-stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .quick-stats-row {
            grid-template-columns: 1fr;
        }
    }

    .quick-stat-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 18px;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        cursor: pointer;
    }

    .quick-stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: var(--secondary-blue);
    }

    .quick-stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .quick-stat-icon.blue {
        background: #dbeafe;
        color: #2563eb;
    }

    .quick-stat-icon.green {
        background: #dcfce7;
        color: #16a34a;
    }

    .quick-stat-icon.yellow {
        background: #fef3c7;
        color: #d97706;
    }

    .quick-stat-icon.purple {
        background: #f3e8ff;
        color: #9333ea;
    }

    .quick-stat-content {
        flex: 1;
    }

    .quick-stat-value {
        display: block;
        font-size: 28px;
        font-weight: 700;
        color: var(--primary-navy);
        line-height: 1.2;
        margin-bottom: 5px;
    }

    .quick-stat-label {
        font-size: 13px;
        color: var(--text-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Today's Session Banner */
    .today-session-banner {
        background: linear-gradient(135deg, #f0f9ff 0%, #e6f0fa 100%);
        border: 1px solid #bae6fd;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 35px;
        display: flex;
        align-items: center;
        gap: 25px;
        flex-wrap: wrap;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        animation: pulseBorder 2s infinite;
    }

    @keyframes pulseBorder {
        0%, 100% {
            border-color: #bae6fd;
            box-shadow: 0 0 0 0 rgba(2, 132, 199, 0.1);
        }
        50% {
            border-color: var(--secondary-blue);
            box-shadow: 0 0 0 8px rgba(2, 132, 199, 0.1);
        }
    }

    .today-session-info {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .today-session-time {
        background: var(--secondary-blue);
        color: white;
        padding: 10px 20px;
        border-radius: 40px;
        font-size: 15px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .today-session-details h4 {
        font-size: 18px;
        color: #0369a1;
        margin-bottom: 5px;
        font-weight: 700;
    }

    .today-session-details p {
        font-size: 14px;
        color: #0c4a6e;
    }

    .today-session-action {
        background: var(--secondary-blue);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 40px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
    }

    .today-session-action:hover {
        background: #0369a1;
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    /* Progress Overview Cards */
    .progress-overview {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 25px;
        margin-bottom: 35px;
    }

    @media (max-width: 992px) {
        .progress-overview {
            grid-template-columns: 1fr;
        }
    }

    .main-progress-card {
        background: white;
        border-radius: 24px;
        padding: 35px;
        border: 1px solid var(--border-color);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .progress-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .progress-header-row h3 {
        font-size: 20px;
        color: var(--primary-navy);
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .progress-header-row h3 i {
        color: var(--secondary-blue);
    }

    .progress-percentage-large {
        font-size: 22px;
        font-weight: 700;
        color: var(--secondary-blue);
        background: #eff6ff;
        padding: 8px 20px;
        border-radius: 40px;
    }

    .stats-card {
        background: white;
        border-radius: 24px;
        padding: 35px;
        border: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        gap: 20px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 18px;
        padding: 15px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .stat-item:last-child {
        border-bottom: none;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 16px;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-navy);
        font-size: 20px;
    }

    .stat-details {
        flex: 1;
    }

    .stat-value {
        display: block;
        font-size: 20px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 13px;
        color: var(--text-gray);
    }

    /* Next Milestone */
    .next-milestone {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 16px;
        padding: 20px;
        margin-top: 25px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .next-milestone i {
        color: var(--secondary-blue);
        font-size: 24px;
    }

    .milestone-content {
        flex: 1;
    }

    .milestone-label {
        font-size: 12px;
        color: #0369a1;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .milestone-value {
        font-size: 15px;
        font-weight: 600;
        color: #0c4a6e;
    }

    .milestone-remaining {
        font-size: 14px;
        font-weight: 600;
        color: var(--secondary-blue);
        background: white;
        padding: 5px 15px;
        border-radius: 30px;
    }

    /* Attendance Summary */
    .attendance-summary {
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px;
        margin-top: 25px;
        display: flex;
        justify-content: space-around;
        border: 1px solid var(--border-color);
    }

    .attendance-item {
        text-align: center;
    }

    .attendance-item .count {
        font-size: 28px;
        font-weight: 700;
        display: block;
        line-height: 1.2;
    }

    .attendance-item .count.attended {
        color: var(--success-green);
    }

    .attendance-item .count.missed {
        color: var(--danger-red);
    }

    .attendance-item .count.graded {
        color: var(--warning-orange);
    }

    .attendance-item .label {
        font-size: 12px;
        color: var(--text-gray);
        text-transform: uppercase;
    }

    /* Certificate Request Section */
    .certificate-request-section {
        background: linear-gradient(135deg, #fef9e7, #fef3c7);
        border: 1px solid #fde68a;
        border-radius: 24px;
        padding: 30px;
        margin: 35px 0;
        display: flex;
        align-items: center;
        gap: 25px;
        flex-wrap: wrap;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .certificate-icon {
        width: 80px;
        height: 80px;
        background: #d97706;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 36px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .certificate-content {
        flex: 1;
    }

    .certificate-title {
        font-size: 22px;
        font-weight: 700;
        color: #92400e;
        margin-bottom: 8px;
    }

    .certificate-text {
        color: #b45309;
        font-size: 15px;
        margin-bottom: 5px;
    }

    .certificate-note {
        color: #d97706;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .btn-request {
        background: #d97706;
        color: white;
        border: none;
        padding: 14px 35px;
        border-radius: 40px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        white-space: nowrap;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .btn-request:hover {
        background: #b85e00;
        transform: translateY(-3px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .request-sent {
        background: #dcfce7;
        color: #15803d;
        padding: 14px 35px;
        border-radius: 40px;
        font-size: 16px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: 1px solid #86efac;
    }

    /* REVIEW SECTION STYLES */
    .review-section {
        background: white;
        border-radius: 24px;
        padding: 30px;
        margin: 35px 0;
        border: 1px solid var(--border-color);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .review-header h3 {
        font-size: 22px;
        color: var(--primary-navy);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .review-header h3 i {
        color: #f59e0b;
        background: #fef3c7;
        padding: 10px;
        border-radius: 12px;
    }

    .btn-write-review {
        background: #f59e0b;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 40px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-write-review:hover {
        background: #d97706;
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .btn-edit-review {
        background: #f1f5f9;
        color: var(--text-dark);
        border: 1px solid var(--border-color);
        padding: 8px 20px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-edit-review:hover {
        background: #e2e8f0;
        border-color: var(--primary-navy);
        transform: translateY(-2px);
    }

    .your-review-card {
        background: #fef9e7;
        border: 1px solid #fde68a;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 25px;
        position: relative;
    }

    .your-review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .your-review-badge {
        background: #f59e0b;
        color: white;
        padding: 5px 15px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .pending-badge {
        background: #fef3c7;
        color: #92400e;
        padding: 5px 15px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .your-review-stars {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 10px;
    }

    .your-review-stars i {
        color: #fbbf24;
        font-size: 18px;
    }

    .your-review-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 10px;
    }

    .your-review-comment {
        color: var(--text-gray);
        font-size: 15px;
        line-height: 1.7;
        margin-bottom: 15px;
    }

    .your-review-meta {
        display: flex;
        gap: 15px;
        font-size: 13px;
        color: var(--text-light);
    }

    .review-actions {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .btn-small {
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-small.edit {
        background: #f1f5f9;
        color: var(--text-dark);
    }

    .btn-small.edit:hover {
        background: #e2e8f0;
    }

    .btn-small.delete {
        background: #fee2e2;
        color: #b91c1c;
    }

    .btn-small.delete:hover {
        background: #fecaca;
    }

    /* Reviews Grid */
    .reviews-grid {
        display: flex;
        flex-direction: column;
        gap: 20px;
        max-height: 500px;
        overflow-y: auto;
        padding-right: 10px;
    }

    .reviews-grid::-webkit-scrollbar {
        width: 6px;
    }

    .reviews-grid::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .reviews-grid::-webkit-scrollbar-thumb {
        background: #94a3b8;
        border-radius: 10px;
    }

    .review-item {
        background: #f8fafc;
        border-radius: 20px;
        padding: 25px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .review-item:hover {
        transform: translateX(5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border-color: var(--secondary-blue);
    }

    .reviewer-info {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .reviewer-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-navy), var(--secondary-blue));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
    }

    .reviewer-details h4 {
        font-size: 16px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 5px;
    }

    .review-stars {
        display: flex;
        align-items: center;
        gap: 3px;
    }

    .review-stars i {
        color: #fbbf24;
        font-size: 14px;
    }

    .review-stars span {
        margin-left: 5px;
        font-size: 13px;
        color: var(--text-gray);
    }

    .review-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--primary-navy);
        margin-bottom: 8px;
    }

    .review-comment {
        color: var(--text-gray);
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .review-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .review-date {
        font-size: 12px;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .helpful-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-helpful {
        background: #f1f5f9;
        border: none;
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-helpful:hover {
        background: #e2e8f0;
    }

    .btn-helpful i {
        color: var(--secondary-blue);
    }

    .helpful-count {
        font-size: 12px;
        color: var(--text-gray);
    }

    .empty-reviews {
        text-align: center;
        padding: 50px 20px;
    }

    .empty-reviews i {
        font-size: 48px;
        color: #cbd5e1;
        margin-bottom: 15px;
    }

    .empty-reviews h4 {
        font-size: 18px;
        color: var(--primary-navy);
        margin-bottom: 8px;
    }

    .empty-reviews p {
        color: var(--text-gray);
        margin-bottom: 20px;
    }

    /* Tab Navigation */
    .course-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        overflow-x: auto;
        padding-bottom: 5px;
        border-bottom: 2px solid var(--border-color);
    }

    .tab-btn {
        padding: 15px 30px;
        border-radius: 40px 40px 0 0;
        background: #f8fafc;
        color: #475569;
        font-size: 15px;
        border: 1px solid var(--border-color);
        border-bottom: none;
        cursor: pointer;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .tab-btn i {
        color: #64748b;
        font-size: 16px;
    }

    .tab-btn.active {
        background: white;
        color: var(--primary-navy);
        font-weight: 700;
        border-color: var(--primary-navy);
        border-bottom: 2px solid white;
        margin-bottom: -2px;
        transform: translateY(-2px);
    }

    .tab-btn.active i {
        color: var(--secondary-blue);
    }

    .tab-btn:hover:not(.active) {
        background: #e2e8f0;
        border-color: #94a3b8;
    }

    .tab-badge {
        background: var(--primary-navy);
        color: white;
        padding: 3px 10px;
        border-radius: 30px;
        font-size: 12px;
        margin-left: 8px;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Sessions Grid */
    .sessions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .session-card {
        background: white;
        border-radius: 24px;
        padding: 25px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .session-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: var(--secondary-blue);
    }

    .session-card.past {
        opacity: 0.8;
    }

    .session-card.upcoming {
        border-left: 6px solid var(--secondary-blue);
    }

    .session-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .session-status {
        display: inline-block;
        padding: 5px 15px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
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
        padding: 5px 15px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .attended-yes {
        background: #dcfce7;
        color: #15803d;
    }

    .attended-no {
        background: #fee2e2;
        color: #b91c1c;
    }

    .session-time {
        font-size: 15px;
        color: var(--secondary-blue);
        font-weight: 600;
        margin: 15px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .session-title {
        font-size: 18px;
        color: var(--primary-navy);
        margin-bottom: 10px;
        font-weight: 700;
    }

    .session-description {
        color: var(--text-gray);
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .session-actions {
        display: flex;
        gap: 12px;
        margin-top: 20px;
    }

    .btn-primary {
        flex: 1;
        padding: 12px;
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

    .btn-primary:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .btn-recording {
        background: #8b5cf6;
    }

    .btn-recording:hover {
        background: #7c3aed;
    }

    /* Assignments Grid */
    .assignments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }

    .assignment-card {
        background: white;
        border-radius: 24px;
        padding: 25px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border-left: 6px solid #d97706;
    }

    .assignment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: var(--primary-navy);
    }

    .assignment-card.graded {
        border-left-color: var(--success-green);
    }

    .assignment-card.submitted {
        border-left-color: var(--secondary-blue);
    }

    .assignment-card.urgent {
        border-left-color: var(--danger-red);
    }

    .assignment-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .assignment-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-navy);
        margin: 0;
    }

    .assignment-points {
        background: #e2e8f0;
        color: #475569;
        padding: 5px 15px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
    }

    .assignment-description {
        color: var(--text-gray);
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .assignment-due {
        font-size: 14px;
        color: var(--text-gray);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px;
        background: #f8fafc;
        border-radius: 12px;
    }

    .assignment-due.urgent {
        background: #fee2e2;
        color: var(--danger-red);
    }

    .submission-status {
        padding: 12px;
        border-radius: 12px;
        font-size: 14px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .status-not-started {
        background: #f1f5f9;
        color: #475569;
    }

    .status-submitted {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-graded {
        background: #dcfce7;
        color: #15803d;
    }

    .status-overdue {
        background: #fee2e2;
        color: #b91c1c;
    }

    .btn-view {
        width: 100%;
        padding: 12px;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid var(--border-color);
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

    .btn-view:hover {
        background: #e2e8f0;
        border-color: var(--primary-navy);
        color: var(--primary-navy);
        transform: translateY(-2px);
    }

    /* Materials Grid */
    .materials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
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
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }

    .material-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border-color: var(--secondary-blue);
        background: white;
    }

    .material-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
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

    .material-type {
        font-size: 13px;
        color: var(--text-gray);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .material-download {
        color: var(--text-light);
        transition: all 0.3s ease;
    }

    .material-card:hover .material-download {
        color: var(--secondary-blue);
        transform: translateY(-2px);
    }

    /* Empty State */
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

    .empty-state h4 {
        font-size: 20px;
        color: var(--primary-navy);
        margin-bottom: 10px;
        font-weight: 700;
    }

    .empty-state p {
        color: var(--text-gray);
        margin-bottom: 25px;
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
    }

    .modal-content {
        background: white;
        border-radius: 24px;
        padding: 30px;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
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
        font-size: 22px;
        color: var(--primary-navy);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-header h3 i {
        color: #f59e0b;
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
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .close-btn:hover {
        color: var(--danger-red);
        background: #f1f5f9;
    }

    .rating-selector {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        justify-content: center;
    }

    .star {
        font-size: 36px;
        cursor: pointer;
        color: #cbd5e0;
        transition: all 0.3s ease;
    }

    .star:hover,
    .star.active {
        color: #fbbf24;
        transform: scale(1.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-navy);
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
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

    .btn-submit {
        background: var(--primary-navy);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid var(--border-color);
        padding: 12px 25px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
    }

    .btn-delete {
        background: #fee2e2;
        color: #b91c1c;
        border: none;
        padding: 12px 25px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-delete:hover {
        background: #fecaca;
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .course-progress-container {
            padding: 20px;
        }

        .hero-header {
            padding: 25px;
        }

        .course-title {
            font-size: 28px;
        }

        .today-session-banner {
            flex-direction: column;
            text-align: center;
        }

        .today-session-info {
            flex-direction: column;
        }

        .course-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        .tab-btn {
            padding: 12px 20px;
            font-size: 14px;
        }

        .session-actions {
            flex-direction: column;
        }

        .certificate-request-section {
            flex-direction: column;
            text-align: center;
        }

        .attendance-summary {
            flex-direction: column;
            gap: 15px;
        }

        .path-context-card {
            flex-direction: column;
            text-align: center;
        }

        .review-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .review-actions {
            flex-direction: column;
        }

        .modal-actions {
            flex-direction: column;
        }

        .rating-selector {
            flex-wrap: wrap;
        }
    }
</style>
@endsection

@section('content')
<div class="course-progress-container">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Hero Header -->
    <div class="hero-header">
        <div class="hero-content">
            <div class="hero-left">
                <a href="{{ route('courses.my-courses') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Back to My Courses
                </a>
                <h1 class="course-title">{{ $course->title }}</h1>
                <div class="instructor-info">
                    <i class="fas fa-chalkboard-teacher"></i>
                    Instructor: {{ $course->instructor_name }}
                </div>
                <div class="course-meta-badges">
                    <span class="meta-badge">
                        <i class="fas fa-clock"></i> {{ $course->duration ?? '4 weeks' }}
                    </span>
                    <span class="meta-badge">
                        <i class="fas fa-signal"></i> {{ ucfirst($course->level) }}
                    </span>
                    <span class="meta-badge">
                        <i class="fas fa-tag"></i> {{ $course->category->name ?? 'General' }}
                    </span>
                </div>
            </div>
            <div class="hero-right">
                <div class="progress-circle-large">
                    <svg viewBox="0 0 40 40" class="circular-chart">
                        <circle class="circle-bg" cx="20" cy="20" r="16"></circle>
                        <circle class="circle-progress" cx="20" cy="20" r="16"></circle>
                    </svg>
                    <div class="progress-text-large">{{ $enrollment->progress_percentage }}%</div>
                    <div class="progress-label-large">Overall Progress</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Learning Path Context (if exists) -->
    @if(isset($pathItem) && $pathItem)
        <div class="path-context-card">
            <div class="path-icon">
                <i class="fas fa-route"></i>
            </div>
            <div class="path-content">
                <div class="path-title">Part of Your Learning Path</div>
                <div class="path-description">This course is part of your personalized learning journey</div>
            </div>
            <a href="{{ route('learning-path.index') }}" class="path-button">
                <i class="fas fa-route"></i>
                View Full Path
            </a>
        </div>
    @endif

    <!-- Quick Stats Row -->
    <div class="quick-stats-row">
        <a href="#sessions-tab" class="quick-stat-card" onclick="switchTab('sessions'); return false;">
            <div class="quick-stat-icon blue">
                <i class="fas fa-video"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $stats['total_sessions'] }}</span>
                <span class="quick-stat-label">Live Sessions</span>
            </div>
        </a>
        
        <a href="#assignments-tab" class="quick-stat-card" onclick="switchTab('assignments'); return false;">
            <div class="quick-stat-icon green">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $stats['submitted_assignments'] }}/{{ $stats['total_assignments'] }}</span>
                <span class="quick-stat-label">Assignments</span>
            </div>
        </a>
        
        <a href="#materials-tab" class="quick-stat-card" onclick="switchTab('materials'); return false;">
            <div class="quick-stat-icon yellow">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $stats['total_materials'] }}</span>
                <span class="quick-stat-label">Materials</span>
            </div>
        </a>
        
        <div class="quick-stat-card">
            <div class="quick-stat-icon purple">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $stats['attended_sessions'] }}/{{ $stats['total_sessions'] }}</span>
                <span class="quick-stat-label">Attendance</span>
            </div>
        </div>
    </div>

    <!-- Today's Session Banner (if any) -->
    @if(isset($todaySession) && $todaySession)
        <div class="today-session-banner">
            <div class="today-session-info">
                <div class="today-session-time">
                    <i class="fas fa-clock"></i>
                    {{ \Carbon\Carbon::parse($todaySession->start_time)->format('h:i A') }}
                </div>
                <div class="today-session-details">
                    <h4>{{ $todaySession->title }}</h4>
                    <p>{{ Str::limit($todaySession->description, 100) }}</p>
                </div>
            </div>
            @if($todaySession->meeting_url)
                <a href="{{ $todaySession->meeting_url }}" target="_blank" class="today-session-action">
                    <i class="fas fa-video"></i> Join Now
                </a>
            @else
                <a href="{{ route('courses.sessions.show', [$course->id, $todaySession->id]) }}" class="today-session-action">
                    <i class="fas fa-info-circle"></i> View Details
                </a>
            @endif
        </div>
    @endif

    <!-- Progress Overview -->
    <div class="progress-overview">
        <div class="main-progress-card">
            <div class="progress-header-row">
                <h3>
                    <i class="fas fa-chart-pie"></i>
                    Your Progress
                </h3>
                <span class="progress-percentage-large">{{ $enrollment->progress_percentage }}% Complete</span>
            </div>

            <!-- Attendance Summary -->
            <div class="attendance-summary">
                <div class="attendance-item">
                    <span class="count attended">{{ $stats['attended_sessions'] }}</span>
                    <span class="label">Attended</span>
                </div>
                <div class="attendance-item">
                    <span class="count missed">{{ $stats['missed_sessions'] }}</span>
                    <span class="label">Missed</span>
                </div>
                <div class="attendance-item">
                    <span class="count graded">{{ $stats['graded_assignments'] }}</span>
                    <span class="label">Graded</span>
                </div>
            </div>

            <!-- Next Milestone -->
            @if(isset($nextMilestone) && $nextMilestone)
                <div class="next-milestone">
                    <i class="fas fa-flag-checkered"></i>
                    <div class="milestone-content">
                        <div class="milestone-label">Next Milestone</div>
                        <div class="milestone-value">{{ $nextMilestone['description'] }}</div>
                    </div>
                    <span class="milestone-remaining">{{ $nextMilestone['remaining'] }}% to go</span>
                </div>
            @endif
        </div>

        <div class="stats-card">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-value">{{ $course->duration ?? '4 weeks' }}</span>
                    <span class="stat-label">Course Duration</span>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-tag"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-value">{{ ucfirst($enrollment->status) }}</span>
                    <span class="stat-label">Status</span>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-value">{{ $enrollment->enrolled_at->format('M d, Y') }}</span>
                    <span class="stat-label">Enrolled On</span>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas {{ $enrollment->completed_at ? 'fa-check-circle' : 'fa-spinner' }}"></i>
                </div>
                <div class="stat-details">
                    <span class="stat-value">{{ $enrollment->completed_at ? $enrollment->completed_at->format('M d, Y') : 'In Progress' }}</span>
                    <span class="stat-label">{{ $enrollment->completed_at ? 'Completed On' : 'Est. Completion' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Certificate Request Section (when completed) -->
    @if($enrollment->status == 'completed')
        @php
            $hasRequested = session('certificate_requested_' . $enrollment->id, false);
        @endphp
        <div class="certificate-request-section">
            <div class="certificate-icon">
                <i class="fas fa-certificate"></i>
            </div>
            <div class="certificate-content">
                <h3 class="certificate-title">Congratulations on Completing the Course! 🎉</h3>
                <p class="certificate-text">You've successfully completed all requirements. Request your certificate of completion.</p>
                <p class="certificate-note">
                    <i class="fas fa-info-circle"></i>
                    Your instructor will review and send the certificate once approved.
                </p>
            </div>
            @if($hasRequested)
                <div class="request-sent">
                    <i class="fas fa-check-circle"></i>
                    Request Sent
                </div>
            @else
                <button type="button" class="btn-request" onclick="requestCertificate({{ $enrollment->id }})" id="requestBtn">
                    <i class="fas fa-paper-plane"></i>
                    Request Certificate
                </button>
            @endif
        </div>
    @endif

    <!-- REVIEWS SECTION -->
    @php
        $userReview = \App\Models\CourseReview::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->first();
            
        $allReviews = \App\Models\CourseReview::where('course_id', $course->id)
            ->where('is_approved', true)
            ->with('user')
            ->latest()
            ->get();
            
        $reviewsCount = $allReviews->count();
        $averageRating = $reviewsCount > 0 ? round($allReviews->avg('rating'), 1) : 0;
    @endphp

    <div class="review-section">
        <div class="review-header">
            <h3>
                <i class="fas fa-star"></i>
                Course Reviews
                @if($reviewsCount > 0)
                    <span style="margin-left: 10px; font-size: 16px; color: var(--text-gray);">
                        {{ $averageRating }} ({{ $reviewsCount }} {{ Str::plural('review', $reviewsCount) }})
                    </span>
                @endif
            </h3>
            
            @if($enrollment->status == 'completed')
                @if($userReview)
                    <div class="review-actions">
                        <span class="pending-badge" style="margin-right: 10px;">
                            <i class="fas fa-check-circle"></i> You Reviewed
                        </span>
                        <button class="btn-edit-review" onclick="editReview({{ json_encode($userReview) }})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    </div>
                @else
                    <button class="btn-write-review" onclick="openReviewModal()">
                        <i class="fas fa-star"></i> Write a Review
                    </button>
                @endif
            @endif
        </div>

        <!-- User's Existing Review (if any) -->
        @if($userReview)
            <div class="your-review-card">
                <div class="your-review-header">
                    <span class="your-review-badge">
                        <i class="fas fa-star"></i> Your Review
                    </span>
                    @if(!$userReview->is_approved)
                        <span class="pending-badge">
                            <i class="fas fa-clock"></i> Pending Approval
                        </span>
                    @endif
                </div>
                <div class="your-review-stars">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $userReview->rating)
                            <i class="fas fa-star"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>
                @if($userReview->title)
                    <h4 class="your-review-title">{{ $userReview->title }}</h4>
                @endif
                <p class="your-review-comment">{{ $userReview->comment }}</p>
                <div class="your-review-meta">
                    <span><i class="fas fa-clock"></i> {{ $userReview->created_at->diffForHumans() }}</span>
                </div>
                <div class="review-actions">
                    <button class="btn-small edit" onclick="editReview({{ json_encode($userReview) }})">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button class="btn-small delete" onclick="deleteReview({{ $userReview->id }})">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </div>
        @endif

        <!-- All Reviews -->
        @if($allReviews->count() > 0)
            <div class="reviews-grid">
                @foreach($allReviews as $review)
                    @if(!$userReview || $review->id != $userReview->id)
                        <div class="review-item">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">
                                    {{ $review->user->initials ?? substr($review->user->name, 0, 1) }}
                                </div>
                                <div class="reviewer-details">
                                    <h4>{{ $review->user->name }}</h4>
                                    <div class="review-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                        <span>{{ $review->rating }}/5</span>
                                    </div>
                                </div>
                            </div>
                            @if($review->title)
                                <h5 class="review-title">{{ $review->title }}</h5>
                            @endif
                            <p class="review-comment">{{ $review->comment }}</p>
                            <div class="review-footer">
                                <span class="review-date">
                                    <i class="fas fa-clock"></i> {{ $review->created_at->diffForHumans() }}
                                </span>
                                <div class="helpful-buttons">
                                    <button class="btn-helpful" onclick="markHelpful({{ $review->id }})">
                                        <i class="fas fa-thumbs-up"></i> Helpful ({{ $review->helpful_count }})
                                    </button>
                                    <button class="btn-helpful" onclick="markNotHelpful({{ $review->id }})">
                                        <i class="fas fa-thumbs-down"></i> ({{ $review->not_helpful_count }})
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @elseif(!$userReview)
            <div class="empty-reviews">
                <i class="fas fa-star"></i>
                <h4>No Reviews Yet</h4>
                <p>Be the first to share your experience with this course!</p>
                @if($enrollment->status == 'completed')
                    <button class="btn-write-review" onclick="openReviewModal()">
                        <i class="fas fa-star"></i> Write a Review
                    </button>
                @endif
            </div>
        @endif
    </div>

    <!-- Tab Navigation -->
    <div class="course-tabs">
        <button class="tab-btn active" onclick="switchTab('sessions')" id="tabSessions">
            <i class="fas fa-video"></i>
            Live Sessions
            <span class="tab-badge">{{ $stats['total_sessions'] }}</span>
        </button>
        <button class="tab-btn" onclick="switchTab('assignments')" id="tabAssignments">
            <i class="fas fa-tasks"></i>
            Assignments
            <span class="tab-badge">{{ $stats['total_assignments'] }}</span>
        </button>
        <button class="tab-btn" onclick="switchTab('materials')" id="tabMaterials">
            <i class="fas fa-file-alt"></i>
            Materials
            <span class="tab-badge">{{ $stats['total_materials'] }}</span>
        </button>
    </div>

    <!-- Sessions Tab -->
    <div id="tabSessionsContent" class="tab-content active">
        @if($sessions->count() > 0)
            <div class="sessions-grid">
                @foreach($sessions as $session)
                    @php
                        $attendance = $session->attendance->first();
                        $isPast = $session->start_time < now();
                        $isUpcoming = $session->start_time > now() && $session->status == 'scheduled';
                    @endphp
                    <div class="session-card {{ $isPast ? 'past' : '' }} {{ $isUpcoming ? 'upcoming' : '' }}">
                        <div class="session-header">
                            <span class="session-status status-{{ $session->status }}">
                                {{ ucfirst($session->status) }}
                            </span>
                            @if($attendance && $attendance->attended)
                                <span class="attended-badge attended-yes">
                                    <i class="fas fa-check-circle"></i> Attended
                                </span>
                            @elseif($isPast && $session->status == 'completed')
                                <span class="attended-badge attended-no">
                                    <i class="fas fa-times-circle"></i> Missed
                                </span>
                            @endif
                        </div>

                        <div class="session-time">
                            <i class="fas fa-calendar-alt"></i>
                            {{ \Carbon\Carbon::parse($session->start_time)->format('M d, Y - h:i A') }}
                        </div>

                        <h4 class="session-title">{{ $session->title }}</h4>
                        
                        <p class="session-description">{{ Str::limit($session->description, 100) }}</p>

                        <div class="session-actions">
                            @if($session->meeting_url && $isUpcoming)
                                <a href="{{ $session->meeting_url }}" target="_blank" class="btn-primary">
                                    <i class="fas fa-video"></i> Join Session
                                </a>
                            @elseif($session->recording_url)
                                <a href="{{ $session->recording_url }}" target="_blank" class="btn-primary btn-recording">
                                    <i class="fas fa-play-circle"></i> Watch Recording
                                </a>
                            @elseif($isPast && $attendance && $attendance->attended)
                                <span class="btn-primary" style="background: var(--success-green); cursor: default;">
                                    <i class="fas fa-check-circle"></i> Attended
                                </span>
                            @else
                                <a href="{{ route('courses.sessions.show', [$course->id, $session->id]) }}" class="btn-primary">
                                    <i class="fas fa-info-circle"></i> Details
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-video"></i>
                <h4>No Sessions Yet</h4>
                <p>The instructor hasn't scheduled any live sessions for this course yet.</p>
            </div>
        @endif
    </div>

    <!-- Assignments Tab -->
    <div id="tabAssignmentsContent" class="tab-content">
        @if($assignments->count() > 0)
            <div class="assignments-grid">
                @foreach($assignments as $assignment)
                    @php
                        $submission = $assignment->submissions->first();
                        $isSubmitted = !is_null($submission);
                        $isGraded = $isSubmitted && !is_null($submission->grade);
                        $isOverdue = $assignment->due_date && $assignment->due_date < now() && !$isSubmitted;
                        
                        $cardClass = '';
                        $statusClass = 'not-started';
                        $statusText = 'Not Started';
                        $statusIcon = 'exclamation-circle';
                        
                        if ($isGraded) {
                            $cardClass = 'graded';
                            $statusClass = 'graded';
                            $statusText = 'Graded: ' . $submission->grade . '/' . $assignment->points;
                            $statusIcon = 'check-circle';
                        } elseif ($isSubmitted) {
                            $cardClass = 'submitted';
                            $statusClass = 'submitted';
                            $statusText = 'Submitted - Awaiting Grade';
                            $statusIcon = 'clock';
                        } elseif ($isOverdue) {
                            $cardClass = 'urgent';
                            $statusClass = 'overdue';
                            $statusText = 'Overdue';
                            $statusIcon = 'exclamation-triangle';
                        }
                    @endphp
                    
                    <div class="assignment-card {{ $cardClass }}">
                        <div class="assignment-header">
                            <h4 class="assignment-title">{{ $assignment->title }}</h4>
                            <span class="assignment-points">{{ $assignment->points }} pts</span>
                        </div>
                        
                        <p class="assignment-description">{{ Str::limit($assignment->description, 100) }}</p>
                        
                        @if($assignment->due_date)
                            <div class="assignment-due {{ $isOverdue ? 'urgent' : '' }}">
                                <i class="fas fa-calendar-alt"></i>
                                Due: {{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') }}
                                @if($isOverdue)
                                    <span>(Overdue)</span>
                                @endif
                            </div>
                        @endif
                        
                        <div class="submission-status status-{{ $statusClass }}">
                            <i class="fas fa-{{ $statusIcon }}"></i>
                            {{ $statusText }}
                        </div>
                        
                        @if($isGraded)
                            <a href="{{ route('courses.assignments.show', [$course->id, $assignment->id]) }}" class="btn-view">
                                <i class="fas fa-eye"></i> View Feedback
                            </a>
                        @else
                            <a href="{{ route('courses.assignments.show', [$course->id, $assignment->id]) }}" class="btn-view" style="background: var(--primary-navy); color: white;">
                                <i class="fas fa-{{ $isSubmitted ? 'edit' : 'upload' }}"></i>
                                {{ $isSubmitted ? 'Edit Submission' : 'Submit Assignment' }}
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-tasks"></i>
                <h4>No Assignments</h4>
                <p>The instructor hasn't created any assignments for this course yet.</p>
            </div>
        @endif
    </div>

    <!-- Materials Tab -->
    <div id="tabMaterialsContent" class="tab-content">
        @if($materials->count() > 0)
            <div class="materials-grid">
                @foreach($materials as $material)
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
                    <a href="{{ $material->type == 'link' ? $material->external_link : route('courses.materials.show', [$course->id, $material->id]) }}" 
                       class="material-card" 
                       @if($material->type == 'link') target="_blank" @endif>
                        <div class="material-icon {{ $iconClass }}">
                            <i class="fas {{ $icon }}"></i>
                        </div>
                        <div class="material-info">
                            <div class="material-title">{{ $material->title }}</div>
                            <div class="material-type">
                                <i class="fas fa-tag"></i> {{ ucfirst($material->type) }}
                            </div>
                        </div>
                        <i class="fas fa-{{ $material->type == 'link' ? 'external-link-alt' : 'download' }} material-download"></i>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-file-alt"></i>
                <h4>No Materials</h4>
                <p>The instructor hasn't shared any materials for this course yet.</p>
            </div>
        @endif
    </div>
</div>

<!-- Write Review Modal -->
<div class="modal" id="reviewModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-star"></i> Write a Review</h3>
            <button class="close-btn" onclick="closeReviewModal()">&times;</button>
        </div>
        <form id="reviewForm">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            
            <div class="rating-selector">
                <span class="star" onclick="setRating(1)" id="star1"><i class="far fa-star"></i></span>
                <span class="star" onclick="setRating(2)" id="star2"><i class="far fa-star"></i></span>
                <span class="star" onclick="setRating(3)" id="star3"><i class="far fa-star"></i></span>
                <span class="star" onclick="setRating(4)" id="star4"><i class="far fa-star"></i></span>
                <span class="star" onclick="setRating(5)" id="star5"><i class="far fa-star"></i></span>
            </div>
            <input type="hidden" name="rating" id="ratingValue" required>
            
            <div class="form-group">
                <label>Review Title (Optional)</label>
                <input type="text" name="title" class="form-control" placeholder="Summarize your experience" id="reviewTitle">
            </div>
            
            <div class="form-group">
                <label>Your Review</label>
                <textarea name="comment" class="form-control" rows="4" placeholder="Share your experience with this course..." required id="reviewComment"></textarea>
            </div>
            
            <div class="modal-actions">
                <button type="submit" class="btn-submit">Submit Review</button>
                <button type="button" class="btn-cancel" onclick="closeReviewModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Review Modal -->
<div class="modal" id="editReviewModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-edit"></i> Edit Your Review</h3>
            <button class="close-btn" onclick="closeEditReviewModal()">&times;</button>
        </div>
        <form id="editReviewForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="review_id" id="editReviewId">
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            
            <div class="rating-selector">
                <span class="star" onclick="setEditRating(1)" id="editStar1"><i class="far fa-star"></i></span>
                <span class="star" onclick="setEditRating(2)" id="editStar2"><i class="far fa-star"></i></span>
                <span class="star" onclick="setEditRating(3)" id="editStar3"><i class="far fa-star"></i></span>
                <span class="star" onclick="setEditRating(4)" id="editStar4"><i class="far fa-star"></i></span>
                <span class="star" onclick="setEditRating(5)" id="editStar5"><i class="far fa-star"></i></span>
            </div>
            <input type="hidden" name="rating" id="editRatingValue" required>
            
            <div class="form-group">
                <label>Review Title (Optional)</label>
                <input type="text" name="title" class="form-control" id="editReviewTitle">
            </div>
            
            <div class="form-group">
                <label>Your Review</label>
                <textarea name="comment" class="form-control" rows="4" required id="editReviewComment"></textarea>
            </div>
            
            <div class="modal-actions">
                <button type="submit" class="btn-submit">Update Review</button>
                <button type="button" class="btn-cancel" onclick="closeEditReviewModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let currentRating = 0;
    let currentEditRating = 0;

    document.addEventListener('DOMContentLoaded', function() {
        // Progress circle animation
        const progressCircle = document.querySelector('.circle-progress');
        if (progressCircle) {
            const percentage = {{ $enrollment->progress_percentage }};
            const offset = 100.53 - (percentage / 100 * 100.53);
            setTimeout(() => {
                progressCircle.style.transition = 'stroke-dashoffset 1.5s ease';
                progressCircle.style.strokeDashoffset = offset;
            }, 100);
        }
        
        // Check URL hash for tab
        if (window.location.hash) {
            const tab = window.location.hash.substring(1).replace('-tab', '');
            if (['sessions', 'assignments', 'materials'].includes(tab)) {
                switchTab(tab);
            }
        }
    });

    // Tab Switching
    function switchTab(tabName) {
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.getElementById(`tab${tabName.charAt(0).toUpperCase() + tabName.slice(1)}`).classList.add('active');
        
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        document.getElementById(`tab${tabName.charAt(0).toUpperCase() + tabName.slice(1)}Content`).classList.add('active');
        
        window.location.hash = tabName + '-tab';
    }

    // Request Certificate
    function requestCertificate(enrollmentId) {
        Swal.fire({
            title: 'Request Certificate?',
            text: 'Your instructor will review your request and send the certificate once approved.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Send Request',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#2d3e50',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('loadingOverlay').style.display = 'flex';
                
                fetch(`/courses/${enrollmentId}/request-certificate`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    
                    if (data.success) {
                        const requestSection = document.querySelector('.certificate-request-section');
                        const btnContainer = requestSection.querySelector('.btn-request');
                        
                        const sentMessage = document.createElement('div');
                        sentMessage.className = 'request-sent';
                        sentMessage.innerHTML = '<i class="fas fa-check-circle"></i> Request Sent';
                        
                        btnContainer.parentNode.replaceChild(sentMessage, btnContainer);
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Request Sent!',
                            text: data.message,
                            timer: 3000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire('Error', data.message || 'Failed to send request', 'error');
                    }
                })
                .catch(error => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    Swal.fire('Error', 'Something went wrong', 'error');
                });
            }
        });
    }

    // Review Functions
    function openReviewModal() {
        document.getElementById('reviewModal').style.display = 'flex';
        setRating(0);
        document.getElementById('reviewTitle').value = '';
        document.getElementById('reviewComment').value = '';
    }

    function closeReviewModal() {
        document.getElementById('reviewModal').style.display = 'none';
    }

    function setRating(rating) {
        currentRating = rating;
        document.getElementById('ratingValue').value = rating;
        
        for (let i = 1; i <= 5; i++) {
            const star = document.getElementById(`star${i}`);
            if (i <= rating) {
                star.innerHTML = '<i class="fas fa-star"></i>';
                star.classList.add('active');
            } else {
                star.innerHTML = '<i class="far fa-star"></i>';
                star.classList.remove('active');
            }
        }
    }

    document.getElementById('reviewForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (currentRating === 0) {
            Swal.fire('Error', 'Please select a rating', 'error');
            return;
        }
        
        const formData = new FormData(this);
        document.getElementById('loadingOverlay').style.display = 'flex';
        
        fetch(`/courses/{{ $course->id }}/reviews`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('loadingOverlay').style.display = 'none';
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Review Submitted!',
                    text: data.message,
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
                closeReviewModal();
            } else {
                Swal.fire('Error', data.message || 'Failed to submit review', 'error');
            }
        })
        .catch(error => {
            document.getElementById('loadingOverlay').style.display = 'none';
            Swal.fire('Error', 'Something went wrong', 'error');
        });
    });

    function editReview(review) {
        if (review.is_approved) {
            Swal.fire({
                icon: 'info',
                title: 'Review Already Approved',
                text: 'Approved reviews cannot be edited. Please contact admin if you need changes.',
                confirmButtonColor: '#2d3e50'
            });
            return;
        }

        // Open edit modal
        document.getElementById('editReviewId').value = review.id;
        document.getElementById('editReviewTitle').value = review.title || '';
        document.getElementById('editReviewComment').value = review.comment;
        setEditRating(review.rating);
        document.getElementById('editReviewModal').style.display = 'flex';
    }

    function closeEditReviewModal() {
        document.getElementById('editReviewModal').style.display = 'none';
    }

    function setEditRating(rating) {
        currentEditRating = rating;
        document.getElementById('editRatingValue').value = rating;
        
        for (let i = 1; i <= 5; i++) {
            const star = document.getElementById(`editStar${i}`);
            if (i <= rating) {
                star.innerHTML = '<i class="fas fa-star"></i>';
                star.classList.add('active');
            } else {
                star.innerHTML = '<i class="far fa-star"></i>';
                star.classList.remove('active');
            }
        }
    }

    // Edit Review Form Submission - WITH DETAILED ERROR HANDLING
    document.getElementById('editReviewForm')?.addEventListener('submit', function(e) {
        e.preventDefault();

        if (currentEditRating === 0) {
            Swal.fire('Error', 'Please select a rating', 'error');
            return;
        }

        const reviewId = document.getElementById('editReviewId').value;
        const formData = new FormData(this);

        // FIXED: Properly handle PUT request with form data
        formData.append('_method', 'PUT');

        // Log the data being sent for debugging
        console.log('Sending update for review ID:', reviewId);
        console.log('Form data entries:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        document.getElementById('loadingOverlay').style.display = 'flex';

        fetch(`/courses/{{ $course->id }}/reviews/${reviewId}`, {
            method: 'POST', // Using POST with _method override
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async response => {
            const text = await response.text();
            console.log('Raw response:', text);

            try {
                const data = JSON.parse(text);
                return { ok: response.ok, status: response.status, data };
            } catch (e) {
                console.error('JSON parse error:', e);
                throw new Error(`Server returned invalid JSON: ${text.substring(0, 100)}`);
            }
        })
        .then(({ ok, status, data }) => {
            document.getElementById('loadingOverlay').style.display = 'none';

            if (ok && data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Review Updated!',
                    text: data.message || 'Review updated successfully',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
                closeEditReviewModal();
            } else {
                console.error('Server error:', data);

                // Show detailed error message
                let errorMessage = data.message || 'Failed to update review';

                // Add validation errors if present
                if (data.errors) {
                    const validationErrors = Object.values(data.errors).flat().join('\n');
                    errorMessage += '\n\n' + validationErrors;
                }

                Swal.fire({
                    icon: 'error',
                    title: `Error (${status})`,
                    text: errorMessage,
                    confirmButtonColor: '#2d3e50',
                    footer: 'Check console for more details (F12)'
                });
            }
        })
        .catch(error => {
            document.getElementById('loadingOverlay').style.display = 'none';
            console.error('Fetch error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Network Error',
                text: error.message || 'Something went wrong',
                confirmButtonColor: '#2d3e50'
            });
        });
    });

    function deleteReview(reviewId) {
        Swal.fire({
            title: 'Delete Review?',
            text: 'Are you sure you want to delete your review?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('loadingOverlay').style.display = 'flex';
                
                fetch(`/courses/{{ $course->id }}/reviews/${reviewId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message || 'Failed to delete review', 'error');
                    }
                })
                .catch(error => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    console.error('Error:', error);
                    Swal.fire('Error', 'Something went wrong', 'error');
                });
            }
        });
    }

    function markHelpful(reviewId) {
        fetch(`/courses/{{ $course->id }}/reviews/${reviewId}/helpful`, {
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
                location.reload();
            }
        });
    }

    function markNotHelpful(reviewId) {
        fetch(`/courses/{{ $course->id }}/reviews/${reviewId}/not-helpful`, {
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
                location.reload();
            }
        });
    }
</script>
@endsection