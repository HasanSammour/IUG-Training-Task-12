@extends('layouts.app')

@section('title', 'Instructor Dashboard')
@section('body-class', 'instructor-dashboard')

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

        .instructor-dashboard {
            background-color: var(--bg-light);
            min-height: 100vh;
        }

        .dashboard-container {
            width: 100%;
            max-width: 1600px;
            margin: 0 auto;
            padding: 30px 40px;
            padding-bottom: 100px;
        }

        /* Welcome Section */
        .welcome-section {
            margin-bottom: 30px;
        }

        .welcome-card {
            background: linear-gradient(135deg, var(--primary-navy) 0%, #1a252f 100%);
            color: white;
            border-radius: 30px;
            padding: 40px;
            box-shadow: var(--shadow-xl);
            position: relative;
            overflow: hidden;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .welcome-content {
            position: relative;
            z-index: 2;
        }

        .welcome-content h1 {
            font-size: 36px;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .welcome-content p {
            font-size: 16px;
            opacity: 0.9;
            max-width: 500px;
            line-height: 1.6;
        }

        .date-time {
            position: absolute;
            bottom: 30px;
            right: 40px;
            text-align: right;
            z-index: 2;
            background: rgba(255, 255, 255, 0.1);
            padding: 15px 25px;
            border-radius: 50px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .current-date {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 4px;
        }

        .current-time {
            font-size: 28px;
            font-weight: 700;
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
        }

        /* Stats Grid - One Line */
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
            border-radius: 24px;
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
            border-top: 4px solid #065f46;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
            border-color: #065f46;
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            background: #f0f7ff;
            color: var(--primary-navy);
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
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Today's Priority Section */
        .priority-section {
            background: linear-gradient(135deg, #fff9f0, #fef3e7);
            border: 1px solid #fed7aa;
            border-radius: 24px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: var(--shadow-lg);
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
            cursor: pointer;
        }

        .priority-item:hover {
            transform: translateX(8px);
            border-color: #ea580c;
            box-shadow: var(--shadow-lg);
        }

        .priority-item.urgent {
            border-left: 6px solid var(--danger-red);
        }

        .priority-icon {
            width: 55px;
            height: 55px;
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
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .priority-meta {
            display: flex;
            gap: 20px;
            font-size: 14px;
            color: var(--text-gray);
            flex-wrap: wrap;
        }

        .priority-badge {
            background: #ea580c;
            color: white;
            padding: 10px 25px;
            border-radius: 40px;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
        }

        .priority-badge.urgent {
            background: var(--danger-red);
        }

        .priority-badge.live {
            background: var(--success-green);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5);
            }

            50% {
                box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
            }
        }

        /* Section Headers */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 24px;
            color: var(--primary-navy);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0;
        }

        .section-title i {
            color: var(--secondary-blue);
            background: rgba(49, 130, 206, 0.1);
            padding: 12px;
            border-radius: 14px;
            font-size: 20px;
        }

        .view-all {
            color: var(--secondary-blue);
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 40px;
            background: white;
            border: 2px solid var(--border-color);
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .view-all:hover {
            background: var(--secondary-blue);
            color: white;
            border-color: var(--secondary-blue);
            transform: translateY(-2px);
        }

        /* My Courses and Quick Stats Row */
        .top-row-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        @media (max-width: 992px) {
            .top-row-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Dashboard Cards */
        .dashboard-card {
            background: white;
            border-radius: 24px;
            padding: 25px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-header-left h3 {
            font-size: 18px;
            color: var(--primary-navy);
            font-weight: 700;
            margin: 0;
        }

        .card-header-left i {
            color: var(--secondary-blue);
            background: rgba(49, 130, 206, 0.1);
            padding: 10px;
            border-radius: 12px;
            font-size: 16px;
        }

        .badge-count {
            background: var(--primary-navy);
            color: white;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        /* Courses List */
        .courses-list {
            max-height: 300px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .courses-list::-webkit-scrollbar {
            width: 6px;
        }

        .courses-list::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .courses-list::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 10px;
        }

        .course-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .course-row:hover {
            background: #f8fafc;
            transform: translateX(5px);
            border-radius: 12px;
        }

        .course-row:last-child {
            border-bottom: none;
        }

        .course-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: #dbeafe;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .course-info {
            flex: 1;
        }

        .course-info h4 {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .course-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 12px;
        }

        .student-count {
            color: var(--text-gray);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .student-count i {
            color: var(--secondary-blue);
            font-size: 11px;
        }

        .status-badge {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
        }

        .status-badge.active {
            background: #dcfce7;
            color: #15803d;
        }

        .status-badge.inactive {
            background: #fee2e2;
            color: #dc2626;
        }

        /* Quick Stats Grid inside card */
        .quick-stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .quick-stat-item {
            background: #f8fafc;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .quick-stat-item:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            background: white;
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
            font-size: 12px;
            color: var(--text-gray);
            text-transform: uppercase;
        }

        /* Progress Bars */
        .progress-item {
            margin-bottom: 15px;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .progress-bar-bg {
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.5s ease;
        }

        .progress-bar-fill.green {
            background: #065f46;
        }

        .progress-bar-fill.blue {
            background: var(--secondary-blue);
        }

        /* Recent Students - Horizontal Scroll */
        .students-horizontal-section {
            margin-bottom: 30px;
        }

        .students-horizontal-scroll {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding: 10px 5px 20px 5px;
            scrollbar-width: thin;
        }

        .students-horizontal-scroll::-webkit-scrollbar {
            height: 8px;
        }

        .students-horizontal-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .students-horizontal-scroll::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 10px;
        }

        .student-horizontal-card {
            min-width: 250px;
            background: white;
            border-radius: 20px;
            padding: 20px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: var(--shadow-md);
        }

        .student-horizontal-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
            border-color: #065f46;
        }

        .student-avatar-large {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-navy), var(--secondary-blue));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 600;
            margin: 0 auto 15px;
            border: 3px solid white;
            box-shadow: var(--shadow-md);
        }

        .student-name-large {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 4px;
            text-align: center;
        }

        .student-email-large {
            font-size: 12px;
            color: var(--text-gray);
            margin-bottom: 12px;
            text-align: center;
        }

        .student-course-badge {
            background: #e0f2fe;
            color: #0369a1;
            padding: 6px 15px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .student-enrolled-time {
            font-size: 11px;
            color: var(--text-light);
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Quick Actions - Two Rows Design */
        .quick-actions-section {
            margin-bottom: 30px;
        }

        /* First Row - Three Buttons */
        .actions-row-1 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        /* Second Row - Two Buttons */
        .actions-row-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        @media (max-width: 768px) {

            .actions-row-1,
            .actions-row-2 {
                grid-template-columns: 1fr;
            }
        }

        .action-card {
            background: white;
            border-radius: 20px;
            padding: 25px 20px;
            border: 1px solid var(--border-color);
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: var(--shadow-md);
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
            border-color: #065f46;
            background: linear-gradient(135deg, white, #f8fafc);
        }

        .action-icon-large {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            background: #f0f7ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            color: #065f46;
            font-size: 28px;
            transition: all 0.3s ease;
        }

        .action-card:hover .action-icon-large {
            transform: scale(1.1);
            background: #065f46;
            color: white;
        }

        .action-title-large {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .action-desc {
            font-size: 13px;
            color: var(--text-gray);
            line-height: 1.5;
            max-width: 200px;
            margin: 0 auto;
        }

        .action-badge {
            background: #fee2e2;
            color: var(--danger-red);
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 12px;
        }

        /* Calendar Section */
        .calendar-section {
            margin-bottom: 30px;
        }

        .calendar-wrapper {
            background: white;
            border-radius: 24px;
            padding: 25px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
        }

        #calendar {
            height: 600px;
            margin-top: 20px;
        }

        /* Custom Calendar Styles */
        .fc-toolbar-title {
            font-size: 1.5em !important;
            font-weight: 700 !important;
            color: var(--primary-navy) !important;
        }

        .fc-button-primary {
            background-color: var(--primary-navy) !important;
            border-color: var(--primary-navy) !important;
        }

        .fc-button-primary:hover {
            background-color: #1a252f !important;
            border-color: #1a252f !important;
        }

        .fc-button-primary:not(:disabled):active,
        .fc-button-primary:not(:disabled).fc-button-active {
            background-color: #1a252f !important;
            border-color: #1a252f !important;
        }

        .fc-event {
            cursor: pointer;
            border-radius: 8px !important;
            padding: 4px 8px !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            transition: transform 0.2s ease;
            border: none !important;
        }

        .fc-event:hover {
            transform: scale(1.02);
            filter: brightness(1.1);
        }

        .fc-day-today {
            background-color: #f0f9ff !important;
        }

        .fc-highlight {
            background-color: rgba(49, 130, 206, 0.1) !important;
        }

        .fc-daygrid-event {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .fc-event-main {
            padding: 2px 4px;
        }

        /* Event Popover */
        .event-popover {
            position: absolute;
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: var(--shadow-xl);
            border: 1px solid var(--border-color);
            max-width: 300px;
            z-index: 1000;
            display: none;
        }

        .event-popover.show {
            display: block;
            animation: fadeIn 0.2s ease;
        }

        .popover-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .popover-header h4 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
        }

        .popover-close {
            background: none;
            border: none;
            color: var(--text-gray);
            cursor: pointer;
            font-size: 18px;
        }

        .popover-body {
            margin-bottom: 15px;
        }

        .popover-body p {
            font-size: 14px;
            color: var(--text-gray);
            margin-bottom: 8px;
            line-height: 1.5;
        }

        .popover-body .meta {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-light);
            margin-top: 10px;
        }

        .popover-actions {
            display: flex;
            gap: 10px;
        }

        .btn-popover {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
            border: none;
        }

        .btn-popover.primary {
            background: var(--primary-navy);
            color: white;
        }

        .btn-popover.primary:hover {
            background: #1a252f;
        }

        .btn-popover.secondary {
            background: #f1f5f9;
            color: var(--text-gray);
        }

        .btn-popover.secondary:hover {
            background: #e2e8f0;
        }

        /* FIX 1: Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 10000;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        .modal-content {
            background: var(--white);
            border-radius: 24px;
            padding: 30px;
            max-width: 550px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: var(--shadow-xl);
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
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
            font-size: 22px;
            color: var(--primary-navy);
            font-weight: 700;
            margin: 0;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 28px;
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
            color: var(--danger-red);
            background: #fee2e2;
            transform: rotate(90deg);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--border-color);
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-navy);
            box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        .modal-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 25px;
        }

        .btn-primary {
            background: var(--primary-navy);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .btn-primary:hover {
            background: #1a252f;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #475569;
            border: 2px solid var(--border-color);
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            border-color: var(--primary-navy);
            color: var(--primary-navy);
        }

        /* Notifications Section */
        .notifications-section {
            margin-bottom: 30px;
        }

        .notifications-list {
            background: white;
            border-radius: 24px;
            border: 1px solid var(--border-color);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
        }

        .notification-item {
            padding: 20px 25px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            gap: 15px;
            align-items: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-item:hover {
            background: #f8fafc;
            transform: translateX(5px);
        }

        .notification-item.unread {
            background: #f0f9ff;
            border-left: 4px solid var(--secondary-blue);
        }

        .notification-icon {
            width: 45px;
            height: 45px;
            background: #f0f7ff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-navy);
            font-size: 18px;
        }

        .notification-content {
            flex: 1;
        }

        .notification-content h4 {
            font-size: 15px;
            color: var(--text-dark);
            margin-bottom: 4px;
            font-weight: 600;
        }

        .notification-content p {
            font-size: 13px;
            color: var(--text-gray);
            line-height: 1.5;
        }

        .notification-time {
            font-size: 11px;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 5px;
        }

        /* Empty States */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-gray);
            background: #f8fafc;
            border-radius: 16px;
            border: 2px dashed var(--border-color);
        }

        .empty-state i {
            font-size: 40px;
            color: #cbd5e1;
            margin-bottom: 10px;
        }

        .empty-state p {
            font-size: 13px;
            margin-bottom: 15px;
        }

        .btn-small {
            background: var(--primary-navy);
            color: white;
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .btn-small:hover {
            background: #1a252f;
            transform: translateY(-2px);
        }

        .btn-small.outline {
            background: transparent;
            border: 2px solid var(--primary-navy);
            color: var(--primary-navy);
        }

        .btn-small.outline:hover {
            background: var(--primary-navy);
            color: white;
        }

        /* Loading Overlay */
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
            width: 60px;
            height: 60px;
            border: 5px solid #f1f5f9;
            border-top-color: var(--primary-navy);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 20px;
            }

            .welcome-card {
                padding: 25px;
            }

            .date-time {
                position: relative;
                bottom: auto;
                right: auto;
                margin-top: 20px;
                text-align: center;
            }

            .students-horizontal-scroll {
                gap: 15px;
            }

            .student-horizontal-card {
                min-width: 220px;
            }

            .fc-toolbar {
                flex-direction: column;
                gap: 10px;
            }

            .fc-toolbar-title {
                font-size: 1.2em !important;
            }

            .modal-actions {
                flex-direction: column;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-container">
        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner"></div>
        </div>

        <!-- Welcome Section -->
        <section class="welcome-section">
            <div class="welcome-card">
                <div class="welcome-content">
                    <h1>Welcome back, {{ Auth::user()->name }}! 👋</h1>
                    <p>Manage your courses, track student progress, and inspire learning.</p>
                </div>
                <div class="date-time">
                    <div class="current-date" id="currentDate"></div>
                    <div class="current-time" id="currentTime"></div>
                </div>
            </div>
        </section>

        <!-- Stats Grid - One Line -->
        <section class="stats-section">
            <div class="stats-grid">
                <a href="{{ route('instructor.courses') }}" class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $stats['total_courses'] ?? 0 }}</span>
                        <span class="stat-label">My Courses</span>
                    </div>
                </a>

                <a href="{{ route('instructor.courses') }}" class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $stats['total_students'] ?? 0 }}</span>
                        <span class="stat-label">Total Students</span>
                    </div>
                </a>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ number_format($stats['avg_rating'] ?? 0, 1) }}</span>
                        <span class="stat-label">Avg Rating</span>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">${{ number_format($stats['total_revenue'] ?? 0, 2) }}</span>
                        <span class="stat-label">Total Revenue</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Today's Priority Section -->
        @php
            $priorityItems = collect();

            // Add today's sessions
            foreach ($todaySessions as $session) {
                $priorityItems->push([
                    'type' => 'session',
                    'title' => $session->title,
                    'course' => $session->course->title,
                    'time' => $session->start_time->format('h:i A'),
                    'url' => '#',
                    'badge' => 'Live Now',
                    'badge_class' => 'live',
                    'icon' => 'video',
                    'icon_class' => 'session',
                    'session_id' => $session->id,
                    'course_id' => $session->course_id
                ]);
            }

            // Add urgent assignments (due in next 2 days)
            foreach ($pendingAssignments as $assignment) {
                if ($assignment->due_date && $assignment->due_date <= now()->addDays(2)) {
                    $priorityItems->push([
                        'type' => 'assignment',
                        'title' => $assignment->title,
                        'course' => $assignment->course->title,
                        'due' => $assignment->due_date->diffForHumans(),
                        'url' => route('instructor.course.assignments.edit', [$assignment->course_id, $assignment->id]),
                        'badge' => 'Due Soon',
                        'badge_class' => 'urgent',
                        'icon' => 'tasks',
                        'icon_class' => 'assignment',
                        'assignment_id' => $assignment->id,
                        'course_id' => $assignment->course_id
                    ]);
                }
            }

            // Add overdue assignments
            foreach ($overdueAssignments as $assignment) {
                $priorityItems->push([
                    'type' => 'assignment',
                    'title' => $assignment->title,
                    'course' => $assignment->course->title,
                    'due' => $assignment->due_date->diffForHumans(),
                    'url' => route('instructor.course.assignments.edit', [$assignment->course_id, $assignment->id]),
                    'badge' => 'Overdue',
                    'badge_class' => 'urgent',
                    'icon' => 'exclamation-triangle',
                    'icon_class' => 'assignment',
                    'assignment_id' => $assignment->id,
                    'course_id' => $assignment->course_id
                ]);
            }

            $priorityItems = $priorityItems->take(3);
        @endphp

        @if($priorityItems->count() > 0)
            <section class="priority-section">
                <div class="priority-header">
                    <i class="fas fa-bell"></i>
                    <h2>Today's Priority</h2>
                </div>
                <div class="priority-list">
                    @foreach($priorityItems as $item)
                        @if($item['type'] == 'session')
                            <div class="priority-item {{ isset($item['badge_class']) && $item['badge_class'] == 'urgent' ? 'urgent' : '' }}"
                                onclick="openEditModal({{ $item['session_id'] }}, {{ $item['course_id'] }})">
                                <div class="priority-icon {{ $item['icon_class'] }}">
                                    <i class="fas fa-{{ $item['icon'] }}"></i>
                                </div>
                                <div class="priority-content">
                                    <div class="priority-title">{{ $item['title'] }}</div>
                                    <div class="priority-meta">
                                        <span><i class="fas fa-book"></i> {{ $item['course'] }}</span>
                                        @if(isset($item['time']))
                                            <span><i class="fas fa-clock"></i> {{ $item['time'] }}</span>
                                        @elseif(isset($item['due']))
                                            <span><i class="fas fa-hourglass"></i> {{ $item['due'] }}</span>
                                        @endif
                                    </div>
                                </div>
                                <span class="priority-badge {{ $item['badge_class'] ?? '' }}">
                                    {{ $item['badge'] }}
                                </span>
                            </div>
                        @else
                            <a href="{{ $item['url'] }}"
                                class="priority-item {{ isset($item['badge_class']) && $item['badge_class'] == 'urgent' ? 'urgent' : '' }}">
                                <div class="priority-icon {{ $item['icon_class'] }}">
                                    <i class="fas fa-{{ $item['icon'] }}"></i>
                                </div>
                                <div class="priority-content">
                                    <div class="priority-title">{{ $item['title'] }}</div>
                                    <div class="priority-meta">
                                        <span><i class="fas fa-book"></i> {{ $item['course'] }}</span>
                                        @if(isset($item['due']))
                                            <span><i class="fas fa-hourglass"></i> {{ $item['due'] }}</span>
                                        @endif
                                    </div>
                                </div>
                                <span class="priority-badge {{ $item['badge_class'] ?? '' }}">
                                    {{ $item['badge'] }}
                                </span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Top Row: My Courses and Quick Stats (Side by Side) -->
        <div class="top-row-grid">
            <!-- Column 1: My Courses -->
            <div>
                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <i class="fas fa-chalkboard"></i>
                            <h3>My Courses</h3>
                        </div>
                        <div class="card-header-right">
                            <span class="badge-count">{{ $stats['total_courses'] ?? 0 }}</span>
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                        <a href="{{ route('instructor.courses.create') }}" class="btn-small" style="background: #065f46;">
                            <i class="fas fa-plus"></i> New Course
                        </a>
                        <a href="{{ route('instructor.courses') }}" class="btn-small outline">
                            <i class="fas fa-eye"></i> View All
                        </a>
                    </div>

                    @if($courses->count() > 0)
                        <div class="courses-list">
                            @foreach($courses->take(5) as $course)
                                <a href="{{ route('instructor.course-students', $course) }}" class="course-row">
                                    <div class="course-icon">
                                        <i class="fas fa-{{ $course->is_active ? 'play' : 'pause' }}"></i>
                                    </div>
                                    <div class="course-info">
                                        <h4>{{ Str::limit($course->title, 35) }}</h4>
                                        <div class="course-meta">
                                            <span class="student-count">
                                                <i class="fas fa-users"></i> {{ $course->enrollments_count ?? 0 }} students
                                            </span>
                                            <span class="status-badge {{ $course->is_active ? 'active' : 'inactive' }}">
                                                {{ $course->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        @if($courses->count() > 5)
                            <div style="margin-top: 15px; text-align: center;">
                                <a href="{{ route('instructor.courses') }}" class="btn-small outline">
                                    View All {{ $courses->count() }} Courses
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="empty-state">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <p>No courses yet</p>
                            <a href="{{ route('instructor.courses.create') }}" class="btn-small">
                                <i class="fas fa-plus"></i> Create Course
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Column 2: Quick Stats -->
            <div>
                <div class="dashboard-card">
                    <div class="card-header">
                        <div class="card-header-left">
                            <i class="fas fa-chart-pie"></i>
                            <h3>Quick Stats</h3>
                        </div>
                    </div>

                    <div class="quick-stats-grid">
                        <div class="quick-stat-item">
                            <span class="quick-stat-value">{{ $stats['active_courses'] ?? 0 }}</span>
                            <span class="quick-stat-label">Active Courses</span>
                        </div>
                        <div class="quick-stat-item">
                            <span class="quick-stat-value">{{ $stats['completion_rate'] ?? 0 }}%</span>
                            <span class="quick-stat-label">Completion Rate</span>
                        </div>
                        <div class="quick-stat-item">
                            <span class="quick-stat-value">{{ $stats['upcoming_sessions'] ?? 0 }}</span>
                            <span class="quick-stat-label">Upcoming</span>
                        </div>
                        <div class="quick-stat-item">
                            <span class="quick-stat-value">{{ $stats['pending_assignments'] ?? 0 }}</span>
                            <span class="quick-stat-label">Pending Tasks</span>
                        </div>
                    </div>

                    <!-- Progress Bars -->
                    <div style="margin-top: 15px;">
                        <div class="progress-item">
                            <div class="progress-header">
                                <span>Average Progress</span>
                                <span>{{ $stats['completion_rate'] ?? 0 }}%</span>
                            </div>
                            <div class="progress-bar-bg">
                                <div class="progress-bar-fill green" style="width: {{ $stats['completion_rate'] ?? 0 }}%;">
                                </div>
                            </div>
                        </div>
                        <div class="progress-item">
                            <div class="progress-header">
                                <span>Active vs Total</span>
                                <span>{{ $stats['active_courses'] ?? 0 }}/{{ $stats['total_courses'] ?? 0 }}</span>
                            </div>
                            <div class="progress-bar-bg">
                                @php
                                    $activePercentage = $stats['total_courses'] > 0 ? ($stats['active_courses'] / $stats['total_courses'] * 100) : 0;
                                @endphp
                                <div class="progress-bar-fill blue" style="width: {{ $activePercentage }}%;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Mini Stats -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 20px;">
                        <div style="background: #f8fafc; border-radius: 12px; padding: 12px; text-align: center;">
                            <div style="font-size: 20px; font-weight: 700; color: #d97706;">
                                {{ $stats['today_sessions'] ?? 0 }}</div>
                            <div style="font-size: 11px; color: var(--text-gray);">Today's Sessions</div>
                        </div>
                        <div style="background: #f8fafc; border-radius: 12px; padding: 12px; text-align: center;">
                            <div style="font-size: 20px; font-weight: 700; color: #dc2626;">
                                {{ $stats['overdue_assignments'] ?? 0 }}</div>
                            <div style="font-size: 11px; color: var(--text-gray);">Overdue</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Students - Horizontal Scroll -->
        <section class="students-horizontal-section">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-users"></i>
                    Recent Students
                </h3>
                <a href="{{ route('instructor.courses') }}" class="view-all">
                    View All <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            @if(isset($recentStudents) && $recentStudents->count() > 0)
                <div class="students-horizontal-scroll">
                    @foreach($recentStudents as $student)
                        <a href="{{ route('instructor.student.progress', $student['user']->enrollments->first()->id ?? 0) }}"
                            class="student-horizontal-card">
                            <div class="student-avatar-large">
                                {{ substr($student['user']->name, 0, 1) }}
                            </div>
                            <div class="student-name-large">{{ $student['user']->name }}</div>
                            <div class="student-email-large">{{ $student['user']->email }}</div>
                            @if(isset($student['course']))
                                <div class="student-course-badge">{{ Str::limit($student['course']->title, 20) }}</div>
                            @endif
                            <div class="student-enrolled-time">
                                <i class="fas fa-clock"></i> {{ $student['enrolled_at']->diffForHumans() }}
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <p>No recent students</p>
                </div>
            @endif
        </section>

        <!-- Quick Actions - Two Rows -->
        <section class="quick-actions-section">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-bolt"></i>
                    Quick Actions
                </h3>
            </div>

            <!-- First Row - Three Buttons -->
            <div class="actions-row-1">
                <a href="{{ route('instructor.courses.create') }}" class="action-card">
                    <div class="action-icon-large">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <div class="action-title-large">New Course</div>
                    <div class="action-desc">Create a new course and start teaching</div>
                </a>

                <a href="{{ route('instructor.courses') }}" class="action-card">
                    <div class="action-icon-large">
                        <i class="fas fa-chalkboard"></i>
                    </div>
                    <div class="action-title-large">My Courses</div>
                    <div class="action-desc">View and manage all your courses</div>
                    @if($courses->count() > 0)
                        <span class="action-badge">{{ $courses->count() }} Total</span>
                    @endif
                </a>

                <a href="{{ route('profile.edit') }}" class="action-card">
                    <div class="action-icon-large">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <div class="action-title-large">Profile</div>
                    <div class="action-desc">Update your profile and settings</div>
                </a>
            </div>

            <!-- Second Row - Two Buttons -->
            <div class="actions-row-2">
                <a href="{{ route('notifications.index') }}" class="action-card">
                    <div class="action-icon-large">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="action-title-large">Notifications</div>
                    <div class="action-desc">{{ $unreadNotifications ?? 0 }} unread notifications</div>
                    @if($unreadNotifications > 0)
                        <span class="action-badge">{{ $unreadNotifications }} New</span>
                    @endif
                </a>

                <a href="{{ route('messages.inbox') }}" class="action-card">
                    <div class="action-icon-large">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="action-title-large">Messages</div>
                    <div class="action-desc">Communicate with your students</div>
                </a>
            </div>
        </section>

        <!-- Calendar Section -->
        <section class="calendar-section">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-calendar-alt"></i>
                    Schedule Calendar
                </h3>
                <div>
                    <span class="badge-count" style="background: #3182ce;">{{ $upcomingSessions->count() }} Sessions</span>
                    <span class="badge-count"
                        style="background: #d97706; margin-left: 10px;">{{ $pendingAssignments->count() }} Due</span>
                </div>
            </div>

            <div class="calendar-wrapper">
                <div id="calendar"></div>
            </div>
        </section>

        <!-- Event Popover -->
        <div class="event-popover" id="eventPopover">
            <div class="popover-header">
                <h4 id="popoverTitle">Event Title</h4>
                <button class="popover-close" onclick="closePopover()">&times;</button>
            </div>
            <div class="popover-body" id="popoverBody">
                <p id="popoverDescription">Event description</p>
                <div class="meta" id="popoverMeta"></div>
            </div>
            <div class="popover-actions" id="popoverActions">
                <a href="#" id="popoverEditBtn" class="btn-popover primary" onclick="return false;">Edit</a>
                <button class="btn-popover secondary" onclick="closePopover()">Close</button>
            </div>
        </div>

        <!-- FIX 1: Session Edit Modal (Styled) -->
        <div class="modal" id="sessionEditModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Edit Session</h3>
                    <button class="close-btn" onclick="closeSessionModal()">&times;</button>
                </div>
                <form id="sessionEditForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_session_id" name="session_id">
                    <input type="hidden" id="edit_course_id" name="course_id">

                    <div class="form-group">
                        <label>Session Title</label>
                        <input type="text" id="edit_title" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Description</label>
                        <textarea id="edit_description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Meeting URL</label>
                        <input type="url" id="edit_meeting_url" class="form-control"
                            placeholder="https://meet.google.com/...">
                    </div>

                    <div class="form-group">
                        <label>Recording URL</label>
                        <input type="url" id="edit_recording_url" class="form-control"
                            placeholder="https://youtube.com/...">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Start Time</label>
                            <input type="datetime-local" id="edit_start_time" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>End Time</label>
                            <input type="datetime-local" id="edit_end_time" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select id="edit_status" class="form-control">
                            <option value="scheduled">Scheduled</option>
                            <option value="ongoing">Ongoing</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div class="modal-actions">
                        <button type="submit" class="btn-primary">Update Session</button>
                        <button type="button" class="btn-secondary" onclick="closeSessionModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Notifications Section -->
        @if(isset($recentNotifications) && $recentNotifications->count() > 0)
            <section class="notifications-section">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-bell"></i>
                        Recent Notifications
                    </h3>
                    <a href="{{ route('notifications.index') }}" class="view-all">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="notifications-list">
                    @foreach($recentNotifications as $notification)
                        <div class="notification-item {{ !$notification->is_read ? 'unread' : '' }}"
                            onclick="markAsRead({{ $notification->id }})">
                            <div class="notification-icon">
                                <i class="fas fa-{{ $notification->type == 'course' ? 'book' : 'bell' }}"></i>
                            </div>
                            <div class="notification-content">
                                <h4>{{ $notification->title }}</h4>
                                <p>{{ Str::limit($notification->message, 80) }}</p>
                                <span class="notification-time">
                                    <i class="fas fa-clock"></i> {{ $notification->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let currentEvent = null;
        let calendar = null;
        let pendingDrop = null;

        document.addEventListener('DOMContentLoaded', function () {
            // Update current date and time
            function updateDateTime() {
                const now = new Date();

                const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', dateOptions);

                const timeOptions = { hour: '2-digit', minute: '2-digit', hour12: true };
                document.getElementById('currentTime').textContent = now.toLocaleTimeString('en-US', timeOptions);
            }

            updateDateTime();
            setInterval(updateDateTime, 1000);

            // Initialize Calendar
            const calendarEl = document.getElementById('calendar');

            if (calendarEl) {
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,listWeek'
                    },
                    themeSystem: 'standard',
                    firstDay: 1, // Monday
                    height: 600,
                    slotMinTime: '08:00:00',
                    slotMaxTime: '20:00:00',
                    editable: true,
                    selectable: true,
                    selectMirror: true,
                    dayMaxEvents: true,
                    weekends: true,

                    // Events from server
                    events: @json($calendarEvents),

                    // Event drag handler
                    eventDrop: function (info) {
                        // Store the drop info
                        pendingDrop = info;

                        const event = info.event;
                        const oldEvent = info.oldEvent;

                        const newDate = event.start;
                        const formattedDate = formatDateForDisplay(newDate);

                        let message = '';
                        if (event.extendedProps.type === 'session') {
                            const formattedTime = newDate.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                            message = `Move session "${event.title}" to ${formattedDate} at ${formattedTime}?`;
                        } else {
                            message = `Change due date for assignment "${event.title}" to ${formattedDate}?`;
                        }

                        // Show confirmation dialog
                        Swal.fire({
                            title: 'Confirm Date Change',
                            text: message,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#2d3e50',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, update it',
                            cancelButtonText: 'Cancel',
                            reverseButtons: true,
                            showLoaderOnConfirm: true,
                            preConfirm: () => {
                                document.getElementById('loadingOverlay').style.display = 'flex';
                                return updateEventDate(event, oldEvent);
                            },
                            allowOutsideClick: () => !Swal.isLoading()
                        }).then((result) => {
                            if (!result.isConfirmed) {
                                // Revert the drop
                                calendar.refetchEvents();
                            }
                            pendingDrop = null;
                        });

                        // Prevent automatic update
                        return false;
                    },

                    // Event resize handler
                    eventResize: function (info) {
                        pendingDrop = info;

                        const event = info.event;

                        Swal.fire({
                            title: 'Confirm Duration Change',
                            text: `Update session "${event.title}" duration?`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#2d3e50',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, update it',
                            cancelButtonText: 'Cancel',
                            reverseButtons: true,
                            showLoaderOnConfirm: true,
                            preConfirm: () => {
                                document.getElementById('loadingOverlay').style.display = 'flex';
                                return updateEventDate(event, info.oldEvent);
                            },
                            allowOutsideClick: () => !Swal.isLoading()
                        }).then((result) => {
                            if (!result.isConfirmed) {
                                calendar.refetchEvents();
                            }
                            pendingDrop = null;
                        });

                        return false;
                    },

                    // Event click handler - Open modal
                    eventClick: function (info) {
                        info.jsEvent.preventDefault(); // Prevent default navigation

                        const event = info.event;
                        const props = event.extendedProps || {};

                        if (props.type === 'session') {
                            // Load session data into modal
                            loadSessionData(event);

                            // Set the form action URL
                            const form = document.getElementById('sessionEditForm');
                            form.action = `/instructor/course/${props.course_id}/sessions/${props.session_id}`;

                            // Open session edit modal
                            document.getElementById('sessionEditModal').style.display = 'flex';
                        } else {
                            // Redirect to assignment edit page
                            window.location.href = event.url;
                        }
                    }
                });

                calendar.render();
            }

            // Auto-hide alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });
        });

        // Helper function to format date for display
        function formatDateForDisplay(date) {
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        }

        // Helper function to format date for API (YYYY-MM-DD)
        function formatDateForAPI(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Update event date after drag/drop (called after confirmation)
        function updateEventDate(event, oldEvent) {
            const eventId = event.id;
            const [type, id] = eventId.split('_');

            let url = '';
            let data = {};

            if (type === 'session') {
                url = '{{ route("instructor.calendar.session.update") }}';
                data = {
                    session_id: id,
                    new_start: event.start.toISOString(),
                    new_end: event.end ? event.end.toISOString() : null
                };
            } else if (type === 'assignment' || type === 'overdue') {
                url = '{{ route("instructor.calendar.assignment.update") }}';
                data = {
                    assignment_id: id,
                    new_date: formatDateForAPI(event.start)
                };
            }

            return fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            // RELOAD THE PAGE AFTER UPDATE
                            window.location.reload();
                        });
                        return true;
                    } else {
                        throw new Error(data.message || 'Update failed');
                    }
                })
                .catch(error => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Something went wrong',
                        confirmButtonColor: '#2d3e50'
                    });
                    calendar.refetchEvents();
                    return false;
                });
        }

        // Load session data into modal
        function loadSessionData(event) {
            const props = event.extendedProps || {};

            document.getElementById('edit_session_id').value = props.session_id || '';
            document.getElementById('edit_course_id').value = props.course_id || '';
            document.getElementById('edit_title').value = event.title.replace(/^(🔔|📝|⚠️)\s*/, '');

            if (event.start) {
                const startDate = new Date(event.start);
                const year = startDate.getFullYear();
                const month = String(startDate.getMonth() + 1).padStart(2, '0');
                const day = String(startDate.getDate()).padStart(2, '0');
                const hours = String(startDate.getHours()).padStart(2, '0');
                const minutes = String(startDate.getMinutes()).padStart(2, '0');
                document.getElementById('edit_start_time').value = `${year}-${month}-${day}T${hours}:${minutes}`;
            }

            if (event.end) {
                const endDate = new Date(event.end);
                const year = endDate.getFullYear();
                const month = String(endDate.getMonth() + 1).padStart(2, '0');
                const day = String(endDate.getDate()).padStart(2, '0');
                const hours = String(endDate.getHours()).padStart(2, '0');
                const minutes = String(endDate.getMinutes()).padStart(2, '0');
                document.getElementById('edit_end_time').value = `${year}-${month}-${day}T${hours}:${minutes}`;
            }

            document.getElementById('edit_description').value = props.description || '';
            document.getElementById('edit_meeting_url').value = props.meeting_url || '';
            document.getElementById('edit_recording_url').value = props.recording_url || '';
            document.getElementById('edit_status').value = props.status || 'scheduled';
        }

        // Open edit modal from priority items
        function openEditModal(sessionId, courseId) {
            document.getElementById('loadingOverlay').style.display = 'flex';
            console.log('openEditModal called with:', { sessionId, courseId });

            // Fetch session data
            fetch(`/instructor/course/${courseId}/sessions/${sessionId}/edit`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to fetch session data');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    console.log('Session data received:', data);

                    // Populate modal with session data
                    document.getElementById('edit_session_id').value = sessionId;
                    document.getElementById('edit_course_id').value = courseId;
                    document.getElementById('edit_title').value = data.title;
                    document.getElementById('edit_description').value = data.description || '';
                    document.getElementById('edit_meeting_url').value = data.meeting_url || '';
                    document.getElementById('edit_recording_url').value = data.recording_url || '';
                    document.getElementById('edit_status').value = data.status || 'scheduled';

                    if (data.start_time) {
                        const startDate = new Date(data.start_time);
                        const year = startDate.getFullYear();
                        const month = String(startDate.getMonth() + 1).padStart(2, '0');
                        const day = String(startDate.getDate()).padStart(2, '0');
                        const hours = String(startDate.getHours()).padStart(2, '0');
                        const minutes = String(startDate.getMinutes()).padStart(2, '0');
                        document.getElementById('edit_start_time').value = `${year}-${month}-${day}T${hours}:${minutes}`;
                    } else {
                        document.getElementById('edit_start_time').value = '';
                    }

                    if (data.end_time) {
                        const endDate = new Date(data.end_time);
                        const year = endDate.getFullYear();
                        const month = String(endDate.getMonth() + 1).padStart(2, '0');
                        const day = String(endDate.getDate()).padStart(2, '0');
                        const hours = String(endDate.getHours()).padStart(2, '0');
                        const minutes = String(endDate.getMinutes()).padStart(2, '0');
                        document.getElementById('edit_end_time').value = `${year}-${month}-${day}T${hours}:${minutes}`;
                    } else {
                        document.getElementById('edit_end_time').value = '';
                    }

                    // Show modal
                    document.getElementById('sessionEditModal').style.display = 'flex';
                })
                .catch(error => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to load session data',
                        confirmButtonColor: '#2d3e50'
                    });
                });
        }

        function closeSessionModal() {
            document.getElementById('sessionEditModal').style.display = 'none';
        }

        // Handle session edit form submission
        document.getElementById('sessionEditForm')?.addEventListener('submit', function (e) {
            e.preventDefault();

            const sessionId = document.getElementById('edit_session_id').value;
            const courseId = document.getElementById('edit_course_id').value;

            if (!sessionId || !courseId) {
                Swal.fire('Error', 'Missing session or course information', 'error');
                return;
            }

            const formData = {
                title: document.getElementById('edit_title').value,
                description: document.getElementById('edit_description').value,
                meeting_url: document.getElementById('edit_meeting_url').value,
                recording_url: document.getElementById('edit_recording_url').value,
                start_time: document.getElementById('edit_start_time').value,
                end_time: document.getElementById('edit_end_time').value,
                status: document.getElementById('edit_status').value
            };

            document.getElementById('loadingOverlay').style.display = 'flex';

            // Use the new dedicated AJAX endpoint
            const url = `/instructor/course/${courseId}/sessions/${sessionId}/ajax-update`;
            console.log('Submitting to URL:', url);

            fetch(url, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || 'Server error');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: 'Session updated successfully',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            // RELOAD THE PAGE AFTER UPDATE
                            window.location.reload();
                        });
                        closeSessionModal();
                    } else {
                        Swal.fire('Error', data.message || 'Update failed', 'error');
                    }
                })
                .catch(error => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    console.error('Error:', error);
                    Swal.fire('Error', error.message || 'Something went wrong', 'error');
                });
        });

        function showEventPopover(event) {
            currentEvent = event;
            const extendedProps = event.extendedProps || {};

            document.getElementById('popoverTitle').textContent = event.title;

            let description = '';
            let meta = '';

            if (extendedProps.type === 'session') {
                description = extendedProps.description || 'No description';
                meta = `<i class="fas fa-book"></i> ${extendedProps.course || 'Course'}`;
                document.getElementById('popoverEditBtn').onclick = function (e) {
                    e.preventDefault();
                    closePopover();
                    loadSessionData(event);
                    document.getElementById('sessionEditModal').style.display = 'flex';
                };
            } else {
                description = `Course: ${extendedProps.course || 'Course'}`;
                if (extendedProps.points) {
                    meta = `<i class="fas fa-star"></i> ${extendedProps.points} points`;
                }
                document.getElementById('popoverEditBtn').href = event.url;
                document.getElementById('popoverEditBtn').onclick = null;
            }

            document.getElementById('popoverDescription').textContent = description;
            document.getElementById('popoverMeta').innerHTML = meta;

            const rect = event.el.getBoundingClientRect();
            const popover = document.getElementById('eventPopover');

            popover.style.top = rect.bottom + window.scrollY + 10 + 'px';
            popover.style.left = rect.left + window.scrollX + 'px';
            popover.classList.add('show');
        }

        function closePopover() {
            document.getElementById('eventPopover').classList.remove('show');
            currentEvent = null;
        }

        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
        }

        // Confirm Delete (kept for compatibility)
        function confirmDelete(courseId, courseTitle) {
            Swal.fire({
                title: 'Delete Course?',
                html: `Are you sure you want to delete <strong>"${courseTitle}"</strong>?<br><br>This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    document.getElementById(`delete-form-${courseId}`).submit();
                }
            });
        }

        // Close modal when clicking outside
        window.onclick = function (event) {
            const modal = document.getElementById('sessionEditModal');
            if (event.target === modal) {
                closeSessionModal();
            }
        }
    </script>
@endsection