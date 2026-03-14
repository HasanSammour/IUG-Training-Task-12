@extends('layouts.app')

@section('title', 'Shifra - Dashboard')
@section('body-class', 'user-dashboard')

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

        .user-dashboard {
            background-color: var(--bg-light);
            min-height: 100vh;
        }

        .dashboard-container {
            width: 100%;
            max-width: 1400px;
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

        /* Stats Grid */
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
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
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

        /* Calendar Section - Full Width */
        .calendar-section {
            background: white;
            border-radius: 30px;
            padding: 30px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-xl);
            margin-bottom: 30px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .calendar-header h2 {
            font-size: 24px;
            color: var(--primary-navy);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0;
        }

        .calendar-header h2 i {
            color: var(--secondary-blue);
            background: rgba(49, 130, 206, 0.1);
            padding: 12px;
            border-radius: 14px;
        }

        .calendar-legend {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: var(--text-gray);
        }

        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 4px;
        }

        .legend-color.session {
            background: #3182ce;
        }

        .legend-color.assignment {
            background: #d97706;
        }

        .legend-color.overdue {
            background: #dc2626;
        }

        /* Calendar Container */
        .calendar-wrapper {
            height: 500px;
            margin-bottom: 20px;
        }

        /* FullCalendar Custom Styles */
        .fc {
            font-family: inherit;
            height: 100%;
        }

        .fc .fc-toolbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-navy);
        }

        .fc .fc-button-primary {
            background: white;
            color: var(--primary-navy);
            border: 2px solid var(--border-color);
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .fc .fc-button-primary:hover {
            background: var(--primary-navy);
            color: white;
            border-color: var(--primary-navy);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .fc .fc-button-primary:not(:disabled):active,
        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background: var(--primary-navy);
            border-color: var(--primary-navy);
        }

        .fc .fc-daygrid-day {
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .fc .fc-daygrid-day:hover {
            background: #f8fafc;
        }

        .fc .fc-daygrid-day.fc-day-today {
            background: #f0f9ff;
        }

        .fc .fc-daygrid-day-number {
            color: var(--text-dark);
            font-weight: 500;
            padding: 8px;
        }

        .fc .fc-col-header-cell {
            padding: 12px 0;
            background: #f8fafc;
        }

        .fc .fc-col-header-cell-cushion {
            color: var(--primary-navy);
            font-weight: 600;
            text-decoration: none;
        }

        .fc-event {
            border: none;
            padding: 4px 6px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            border-radius: 6px;
            margin: 2px 4px;
            transition: all 0.2s ease;
        }

        .fc-event:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
            box-shadow: var(--shadow-md);
        }

        .fc-event.session {
            background: #3182ce;
            border-left: 3px solid #1e40af;
        }

        .fc-event.assignment {
            background: #d97706;
            border-left: 3px solid #b45309;
        }

        .fc-event.overdue {
            background: #dc2626;
            border-left: 3px solid #991b1b;
        }

        /* Upcoming Events List */
        .upcoming-events {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px dashed var(--border-color);
        }

        .upcoming-title {
            font-size: 16px;
            color: var(--text-gray);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .upcoming-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .event-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            background: #f8fafc;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .event-card:hover {
            transform: translateX(8px);
            border-color: var(--secondary-blue);
            box-shadow: var(--shadow-md);
            background: white;
        }

        .event-time {
            min-width: 100px;
            padding: 8px 15px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
        }

        .event-time.session {
            background: #dbeafe;
            color: #2563eb;
        }

        .event-time.assignment {
            background: #fef3c7;
            color: #d97706;
        }

        .event-time.overdue {
            background: #fee2e2;
            color: #dc2626;
        }

        .event-details {
            flex: 1;
        }

        .event-details h4 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .event-details p {
            font-size: 13px;
            color: var(--text-gray);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .event-details p i {
            color: var(--text-light);
        }

        .event-badge {
            background: var(--primary-navy);
            color: white;
            padding: 6px 15px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        @media (max-width: 992px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Current Course Card - FIXED: Single line layout */
        .current-course-card {
            background: white;
            border-radius: 24px;
            padding: 25px;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: var(--shadow-lg);
            width: 100%;
            min-height: 140px;
        }

        @media (max-width: 768px) {
            .current-course-card {
                flex-direction: column;
                text-align: center;
                align-items: center;
            }
        }

        .course-thumb {
            width: 100px;
            height: 100px;
            border-radius: 16px;
            object-fit: cover;
            box-shadow: var(--shadow-md);
            flex-shrink: 0;
        }

        .course-info {
            flex: 1;
            min-width: 0;
        }

        .course-info h3 {
            font-size: 18px;
            color: var(--primary-navy);
            margin-bottom: 6px;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .course-meta {
            display: flex;
            gap: 12px;
            font-size: 12px;
            color: var(--text-gray);
            margin-bottom: 8px;
            flex-wrap: wrap;
        }

        .course-meta span {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .progress-wrapper {
            min-width: 180px;
            max-width: 250px;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            font-size: 12px;
            color: var(--text-dark);
        }

        .progress-bar {
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary-navy), var(--secondary-blue));
            border-radius: 4px;
            transition: width 0.5s ease;
        }

        .btn-continue {
            background: var(--primary-navy);
            color: white;
            padding: 12px 20px;
            border-radius: 30px;
            border: none;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            white-space: nowrap;
            box-shadow: var(--shadow-md);
            flex-shrink: 0;
        }

        .btn-continue:hover {
            background: #1a252f;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Learning Path Card - Single line layout */
        .path-card {
            background: white;
            border-radius: 24px;
            padding: 25px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
            width: 100%;
        }

        .path-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .path-header h3 {
            font-size: 18px;
            color: var(--primary-navy);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ai-badge {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            flex-shrink: 0;
        }

        .path-stats {
            display: flex;
            gap: 20px;
            margin: 15px 0;
        }

        .path-stat {
            text-align: center;
            flex: 1;
        }

        .path-stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-navy);
            line-height: 1.2;
            margin-bottom: 2px;
        }

        .path-stat-label {
            font-size: 11px;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-path {
            background: var(--primary-navy);
            color: white;
            padding: 12px 20px;
            border-radius: 30px;
            border: none;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            width: 100%;
        }

        .btn-path:hover {
            background: #1a252f;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Tasks Card - COLLAPSIBLE */
        .tasks-card {
            background: white;
            border-radius: 24px;
            padding: 25px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg);
        }

        .tasks-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            user-select: none;
        }

        .tasks-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .tasks-header-left h3 {
            font-size: 20px;
            color: var(--primary-navy);
            font-weight: 700;
            margin: 0;
        }

        .tasks-header-left i {
            color: var(--secondary-blue);
            background: rgba(49, 130, 206, 0.1);
            padding: 10px;
            border-radius: 12px;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .tasks-header:hover .tasks-header-left i {
            background: var(--secondary-blue);
            color: white;
        }

        .tasks-header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .task-count-badge {
            background: var(--primary-navy);
            color: white;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        .toggle-icon {
            font-size: 20px;
            color: var(--text-gray);
            transition: transform 0.3s ease;
        }

        .tasks-header.collapsed .toggle-icon {
            transform: rotate(180deg);
        }

        .tasks-content {
            max-height: 600px;
            overflow: hidden;
            transition: max-height 0.5s ease, opacity 0.3s ease;
            opacity: 1;
            margin-top: 20px;
        }

        .tasks-content.collapsed {
            max-height: 0;
            opacity: 0;
            margin-top: 0;
        }

        .task-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 15px;
            overflow-x: auto;
        }

        .task-tab {
            padding: 8px 16px;
            border-radius: 30px;
            background: #f8fafc;
            color: var(--text-gray);
            border: 1px solid var(--border-color);
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .task-tab i {
            font-size: 13px;
        }

        .task-tab.active {
            background: var(--primary-navy);
            color: white;
            border-color: var(--primary-navy);
        }

        .task-tab .count {
            background: rgba(255, 255, 255, 0.2);
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 11px;
        }

        .task-tab:not(.active) .count {
            background: #e2e8f0;
            color: var(--text-gray);
        }

        .tasks-list {
            max-height: 350px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .tasks-list::-webkit-scrollbar {
            width: 6px;
        }

        .tasks-list::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .tasks-list::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 10px;
        }

        .task-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            margin-bottom: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            background: white;
        }

        .task-item:hover {
            transform: translateX(5px);
            border-color: var(--primary-navy);
            box-shadow: var(--shadow-md);
        }

        .task-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .task-icon.blue {
            background: #dbeafe;
            color: #2563eb;
        }

        .task-icon.yellow {
            background: #fef3c7;
            color: #d97706;
        }

        .task-icon.red {
            background: #fee2e2;
            color: #dc2626;
        }

        .task-content {
            flex: 1;
            min-width: 0;
        }

        .task-title {
            font-size: 15px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .task-meta {
            display: flex;
            gap: 10px;
            font-size: 11px;
            color: var(--text-gray);
            flex-wrap: wrap;
        }

        .task-due {
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .task-due.urgent {
            color: var(--danger-red);
            font-weight: 600;
        }

        .task-points {
            background: #e2e8f0;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
        }

        .task-course {
            font-size: 10px;
            color: var(--text-light);
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .task-course i {
            font-size: 9px;
        }

        /* Recommended Courses Grid - 3 in a row */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        @media (max-width: 992px) {
            .courses-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .courses-grid {
                grid-template-columns: 1fr;
            }
        }

        .course-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-navy);
        }

        .course-card h4 {
            font-size: 17px;
            color: var(--primary-navy);
            margin-bottom: 8px;
            font-weight: 700;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .course-card p {
            font-size: 13px;
            color: var(--text-gray);
            margin-bottom: 15px;
            line-height: 1.5;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 10px;
            border-top: 1px solid var(--border-color);
        }

        .course-price {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-navy);
        }

        .btn-details {
            background: #f0f7ff;
            color: var(--primary-navy);
            padding: 8px 14px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-details:hover {
            background: var(--primary-navy);
            color: white;
        }

        /* Notifications List */
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
        }

        .notification-item.unread {
            background: #f0f9ff;
            border-left: 4px solid var(--secondary-blue);
        }

        .notification-icon {
            width: 50px;
            height: 50px;
            background: #f0f7ff;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-navy);
            font-size: 20px;
            flex-shrink: 0;
        }

        .notification-content {
            flex: 1;
            min-width: 0;
        }

        .notification-content h4 {
            font-size: 16px;
            color: var(--primary-navy);
            margin-bottom: 5px;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .notification-content p {
            font-size: 14px;
            color: var(--text-gray);
            line-height: 1.5;
            margin-bottom: 5px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .notification-time {
            font-size: 12px;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Empty States */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-gray);
            background: white;
            border-radius: 20px;
            border: 2px dashed var(--border-color);
            width: 100%;
        }

        .empty-state i {
            font-size: 48px;
            color: #cbd5e1;
            margin-bottom: 15px;
        }

        .empty-state h3 {
            font-size: 18px;
            color: var(--primary-navy);
            margin-bottom: 8px;
            font-weight: 600;
        }

        .empty-state p {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .btn-primary {
            background: var(--primary-navy);
            color: white;
            padding: 10px 25px;
            border-radius: 40px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .btn-primary:hover {
            background: #1a252f;
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
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

            .priority-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .priority-badge {
                width: 100%;
                text-align: center;
            }

            .calendar-wrapper {
                height: 400px;
            }

            .calendar-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .event-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .event-time {
                width: 100%;
            }

            .current-course-card {
                flex-direction: column;
                text-align: center;
            }

            .course-thumb {
                margin: 0 auto;
            }

            .progress-wrapper {
                max-width: 100%;
                margin: 10px 0;
            }

            .btn-continue {
                width: 100%;
            }

            .courses-grid {
                grid-template-columns: 1fr;
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
                    <p>Your learning journey continues. Track your progress, join sessions, and complete tasks.</p>
                </div>
                <div class="date-time">
                    <div class="current-date" id="currentDate"></div>
                    <div class="current-time" id="currentTime"></div>
                </div>
            </div>
        </section>

        <!-- Onboarding Section - Interactive Welcome Tour - Only shows for first-time users -->
        @if(session('show_onboarding_dashboard') && Auth::user()->hasRole('student'))
            @include('user.partials.onboarding')
        @endif

        <!-- Stats Grid -->
        <section class="stats-section">
            <div class="stats-grid">
                <a href="{{ route('courses.my-courses') }}" class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $stats['total_courses'] ?? 0 }}</span>
                        <span class="stat-label">Enrolled</span>
                    </div>
                </a>

                <a href="{{ route('courses.my-courses') }}?status=completed" class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $stats['completed_courses'] ?? 0 }}</span>
                        <span class="stat-label">Completed</span>
                    </div>
                </a>

                <a href="{{ route('courses.my-courses') }}?status=active" class="stat-card">
                    <div class="stat-icon yellow">
                        <i class="fas fa-spinner"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $stats['in_progress'] ?? 0 }}</span>
                        <span class="stat-label">In Progress</span>
                    </div>
                </a>

                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="fas fa-fire"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-value">{{ $stats['current_streak'] ?? 0 }}</span>
                        <span class="stat-label">Day Streak</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Today's Priority Section -->
        @if(($todaySessions->count() ?? 0) > 0 || ($overdueAssignments->count() ?? 0) > 0 || ($pendingAssignments->where('due_date', now()->format('Y-m-d'))->count() ?? 0) > 0)
            <section class="priority-section">
                <div class="priority-header">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h2>Today's Priority</h2>
                </div>
                <div class="priority-list">
                    <!-- Live Sessions Today -->
                    @foreach($todaySessions ?? [] as $session)
                        <a href="{{ route('courses.sessions.show', [$session->course_id, $session->id]) }}"
                            class="priority-item {{ $session->meeting_url ? 'urgent' : '' }}">
                            <div class="priority-icon session">
                                <i class="fas fa-video"></i>
                            </div>
                            <div class="priority-content">
                                <div class="priority-title">{{ $session->title }}</div>
                                <div class="priority-meta">
                                    <span><i class="fas fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}</span>
                                    <span><i class="fas fa-book"></i> {{ $session->course->title }}</span>
                                </div>
                            </div>
                            @if($session->meeting_url)
                                <span class="priority-badge live">Join Now</span>
                            @else
                                <span class="priority-badge">View Details</span>
                            @endif
                        </a>
                    @endforeach

                    <!-- Overdue Assignments -->
                    @foreach($overdueAssignments ?? [] as $assignment)
                        <a href="{{ route('courses.assignments.show', [$assignment->course_id, $assignment->id]) }}"
                            class="priority-item urgent">
                            <div class="priority-icon assignment">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div class="priority-content">
                                <div class="priority-title">{{ $assignment->title }}</div>
                                <div class="priority-meta">
                                    <span><i class="fas fa-clock"></i> Due
                                        {{ \Carbon\Carbon::parse($assignment->due_date)->diffForHumans() }}</span>
                                    <span><i class="fas fa-book"></i> {{ $assignment->course->title }}</span>
                                </div>
                            </div>
                            <span class="priority-badge urgent">Overdue</span>
                        </a>
                    @endforeach

                    <!-- Due Today Assignments -->
                    @foreach($pendingAssignments->where('due_date', now()->format('Y-m-d')) ?? [] as $assignment)
                        <a href="{{ route('courses.assignments.show', [$assignment->course_id, $assignment->id]) }}"
                            class="priority-item">
                            <div class="priority-icon assignment">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div class="priority-content">
                                <div class="priority-title">{{ $assignment->title }}</div>
                                <div class="priority-meta">
                                    <span><i class="fas fa-clock"></i> Due Today</span>
                                    <span><i class="fas fa-book"></i> {{ $assignment->course->title }}</span>
                                </div>
                            </div>
                            <span class="priority-badge">Submit</span>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Calendar Section -->
        <section class="calendar-section">
            <div class="calendar-header">
                <h2>
                    <i class="fas fa-calendar-alt"></i>
                    Your Schedule
                </h2>
                <div class="calendar-legend">
                    <span class="legend-item">
                        <span class="legend-color session"></span>
                        Live Sessions
                    </span>
                    <span class="legend-item">
                        <span class="legend-color assignment"></span>
                        Assignments
                    </span>
                    <span class="legend-item">
                        <span class="legend-color overdue"></span>
                        Overdue
                    </span>
                </div>
            </div>

            <!-- Calendar Container -->
            <div class="calendar-wrapper">
                <div id="calendar"></div>
            </div>

            <!-- Upcoming Events List -->
            @if(($upcomingSessions->count() ?? 0) > 0 || ($pendingAssignments->count() ?? 0) > 0)
                <div class="upcoming-events">
                    <h3 class="upcoming-title">
                        <i class="fas fa-clock"></i>
                        Upcoming (Next 7 Days)
                    </h3>
                    <div class="upcoming-list">
                        @foreach($upcomingSessions->take(3) ?? [] as $session)
                            <a href="{{ route('courses.sessions.show', [$session->course_id, $session->id]) }}" class="event-card">
                                <div class="event-time session">
                                    {{ \Carbon\Carbon::parse($session->start_time)->format('M d, h:i A') }}
                                </div>
                                <div class="event-details">
                                    <h4>{{ $session->title }}</h4>
                                    <p>
                                        <i class="fas fa-book"></i> {{ $session->course->title }}
                                        @if($session->meeting_url)
                                            <span class="event-badge">Live Session</span>
                                        @endif
                                    </p>
                                </div>
                            </a>
                        @endforeach

                        @foreach($pendingAssignments->where('due_date', '>=', now())->where('due_date', '<=', now()->addDays(7))->take(3) ?? [] as $assignment)
                            <a href="{{ route('courses.assignments.show', [$assignment->course_id, $assignment->id]) }}"
                                class="event-card">
                                <div class="event-time assignment">
                                    Due {{ \Carbon\Carbon::parse($assignment->due_date)->format('M d') }}
                                </div>
                                <div class="event-details">
                                    <h4>{{ $assignment->title }}</h4>
                                    <p>
                                        <i class="fas fa-book"></i> {{ $assignment->course->title }}
                                        <span class="event-badge">{{ $assignment->points }} pts</span>
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </section>

        <!-- Dashboard Grid -->
        <div class="dashboard-grid">
            <!-- Left Column: Current Course + Learning Path -->
            <div>
                <!-- Current Course -->
                @if($currentEnrollment)
                    <section style="margin-bottom: 25px;">
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="fas fa-play-circle"></i>
                                Continue Learning
                            </h3>
                            <a href="{{ route('courses.my-courses') }}" class="view-all">
                                All Courses <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="current-course-card">
                            <img src="{{ $currentEnrollment->course->image_url }}" alt="{{ $currentEnrollment->course->title }}"
                                class="course-thumb">
                            <div class="course-info">
                                <h3 title="{{ $currentEnrollment->course->title }}">{{ $currentEnrollment->course->title }}</h3>
                                <div class="course-meta">
                                    <span><i class="fas fa-user"></i> {{ $currentEnrollment->course->instructor_name }}</span>
                                    <span><i class="fas fa-clock"></i> {{ $currentEnrollment->course->duration }}</span>
                                </div>
                                <div class="progress-wrapper">
                                    <div class="progress-header">
                                        <span>Progress</span>
                                        <span>{{ $currentEnrollment->progress_percentage }}%</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill"
                                            style="width: {{ $currentEnrollment->progress_percentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('courses.progress', $currentEnrollment->id) }}" class="btn-continue">
                                <i class="fas fa-play"></i> Continue
                            </a>
                        </div>
                    </section>
                @endif

                <!-- Learning Path -->
                @if($learningPath)
                    <section>
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="fas fa-route"></i>
                                Learning Path
                            </h3>
                            <a href="{{ route('learning-path.index') }}" class="view-all">
                                View Path <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        <div class="path-card">
                            <div class="path-header">
                                <h3 title="{{ $learningPath->title }}">
                                    <i class="fas fa-robot" style="color: #667eea;"></i>
                                    {{ Str::limit($learningPath->title, 30) }}
                                </h3>
                                <span class="ai-badge">AI Generated</span>
                            </div>

                            <div class="path-stats">
                                <div class="path-stat">
                                    <span class="path-stat-value">{{ $learningPath->completed_courses }}</span>
                                    <span class="path-stat-label">Completed</span>
                                </div>
                                <div class="path-stat">
                                    <span class="path-stat-value">{{ $learningPath->remaining_courses }}</span>
                                    <span class="path-stat-label">Remaining</span>
                                </div>
                                <div class="path-stat">
                                    <span class="path-stat-value">{{ $learningPath->total_courses }}</span>
                                    <span class="path-stat-label">Total</span>
                                </div>
                            </div>

                            <div class="progress-wrapper" style="max-width: 100%; margin-bottom: 20px;">
                                <div class="progress-header">
                                    <span>Path Progress</span>
                                    <span>{{ $learningPath->progress_percentage }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $learningPath->progress_percentage }}%"></div>
                                </div>
                            </div>

                            <a href="{{ route('learning-path.index') }}" class="btn-path">
                                <i class="fas fa-route"></i> Continue Path
                            </a>
                        </div>
                    </section>
                @elseif(($stats['total_courses'] ?? 0) > 0)
                    <section>
                        <div class="empty-state" style="padding: 40px;">
                            <i class="fas fa-route"></i>
                            <h3>No Learning Path</h3>
                            <p>Generate an AI-powered path to organize your courses</p>
                            <form action="{{ route('learning-path.generate') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-magic"></i> Generate AI Path
                                </button>
                            </form>
                        </div>
                    </section>
                @endif
            </div>

            <!-- Right Column: Tasks -->
            <section>
                <div class="tasks-card">
                    <div class="tasks-header" id="tasksHeader" onclick="toggleTasks()">
                        <div class="tasks-header-left">
                            <i class="fas fa-tasks"></i>
                            <h3>Your Tasks</h3>
                        </div>
                        <div class="tasks-header-right">
                            <span class="task-count-badge">
                                {{ ($pendingAssignments->count() ?? 0) + ($overdueAssignments->count() ?? 0) }}
                            </span>
                            <i class="fas fa-chevron-down toggle-icon" id="toggleIcon"></i>
                        </div>
                    </div>

                    <div class="tasks-content" id="tasksContent">
                        <!-- Task Tabs -->
                        <div class="task-tabs">
                            <button class="task-tab active" onclick="filterTasks('all', this)" id="tabAll">
                                <i class="fas fa-th-large"></i>
                                All
                                <span
                                    class="count">{{ ($pendingAssignments->count() ?? 0) + ($overdueAssignments->count() ?? 0) }}</span>
                            </button>
                            <button class="task-tab" onclick="filterTasks('pending', this)" id="tabPending">
                                <i class="fas fa-clock"></i>
                                Pending
                                <span class="count">{{ $pendingAssignments->count() ?? 0 }}</span>
                            </button>
                            <button class="task-tab" onclick="filterTasks('overdue', this)" id="tabOverdue">
                                <i class="fas fa-exclamation-triangle"></i>
                                Overdue
                                <span class="count">{{ $overdueAssignments->count() ?? 0 }}</span>
                            </button>
                        </div>

                        <!-- Tasks List -->
                        <div class="tasks-list" id="tasksList">
                            @php
                                $hasPending = $pendingAssignments && $pendingAssignments->count() > 0;
                                $hasOverdue = $overdueAssignments && $overdueAssignments->count() > 0;
                            @endphp

                            @if($hasPending || $hasOverdue)
                                @if($hasPending)
                                    @foreach($pendingAssignments as $assignment)
                                        <a href="{{ route('courses.assignments.show', [$assignment->course_id, $assignment->id]) }}"
                                            class="task-item" data-type="pending">
                                            <div class="task-icon yellow">
                                                <i class="fas fa-file-alt"></i>
                                            </div>
                                            <div class="task-content">
                                                <div class="task-title" title="{{ $assignment->title }}">{{ $assignment->title }}</div>
                                                <div class="task-meta">
                                                    @if($assignment->due_date)
                                                        @php
                                                            $isUrgent = \Carbon\Carbon::parse($assignment->due_date)->isToday();
                                                        @endphp
                                                        <span class="task-due {{ $isUrgent ? 'urgent' : '' }}">
                                                            <i class="fas fa-clock"></i>
                                                            Due {{ \Carbon\Carbon::parse($assignment->due_date)->diffForHumans() }}
                                                        </span>
                                                    @endif
                                                    <span class="task-points">{{ $assignment->points }} pts</span>
                                                </div>
                                                <div class="task-course">
                                                    <i class="fas fa-book"></i> {{ $assignment->course->title }}
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif

                                @if($hasOverdue)
                                    @foreach($overdueAssignments as $assignment)
                                        <a href="{{ route('courses.assignments.show', [$assignment->course_id, $assignment->id]) }}"
                                            class="task-item" data-type="overdue">
                                            <div class="task-icon red">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </div>
                                            <div class="task-content">
                                                <div class="task-title" title="{{ $assignment->title }}">{{ $assignment->title }}</div>
                                                <div class="task-meta">
                                                    <span class="task-due urgent">
                                                        <i class="fas fa-clock"></i>
                                                        Overdue {{ \Carbon\Carbon::parse($assignment->due_date)->diffForHumans() }}
                                                    </span>
                                                    <span class="task-points">{{ $assignment->points }} pts</span>
                                                </div>
                                                <div class="task-course">
                                                    <i class="fas fa-book"></i> {{ $assignment->course->title }}
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            @else
                                <div class="empty-state" style="padding: 40px;">
                                    <i class="fas fa-check-circle" style="color: #10b981;"></i>
                                    <h3>All Caught Up!</h3>
                                    <p>No pending assignments. Enjoy your learning!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Recommended Courses -->
        @if($recommendedCourses && $recommendedCourses->count() > 0)
            <section>
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-lightbulb"></i>
                        Recommended For You
                    </h3>
                    <a href="{{ route('courses.public') }}" class="view-all">
                        View All <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="courses-grid">
                    @foreach($recommendedCourses as $course)
                        <div class="course-card">
                            <h4 title="{{ $course->title }}">{{ Str::limit($course->title, 50) }}</h4>
                            <p>{{ Str::limit($course->short_description, 80) }}</p>
                            <div class="card-footer">
                                <span class="course-price">${{ number_format($course->final_price, 2) }}</span>
                                <a href="{{ route('courses.show', $course->slug) }}" class="btn-details">
                                    <i class="fas fa-eye"></i> Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Recent Notifications -->
        @if($recentNotifications && $recentNotifications->count() > 0)
            <section>
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
                        <div class="notification-item {{ !$notification->is_read ? 'unread' : '' }}">
                            <div class="notification-icon">
                                <i class="fas fa-{{ $notification->type_icon ?? 'bell' }}"></i>
                            </div>
                            <div class="notification-content">
                                <h4>{{ $notification->title }}</h4>
                                <p>{{ $notification->message }}</p>
                                <span class="notification-time">
                                    <i class="fas fa-clock"></i>
                                    {{ $notification->created_at->diffForHumans() }}
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
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script>
        // Task collapse state
        let tasksCollapsed = false;

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

            // Initialize FullCalendar
            const calendarEl = document.getElementById('calendar');
            if (calendarEl) {
                // Wait for FullCalendar to load
                if (typeof FullCalendar !== 'undefined') {
                    initCalendar();
                } else {
                    // Load FullCalendar dynamically if not loaded
                    const script = document.createElement('script');
                    script.src = '{{ asset("fullcalendar/main.min.js") }}';
                    script.onload = initCalendar;
                    document.head.appendChild(script);
                }
            }

            function initCalendar() {
                const calendarEl = document.getElementById('calendar');
                if (!calendarEl) return;

                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek'
                    },
                    themeSystem: 'standard',
                    height: '100%',
                    events: {!! isset($calendarEvents) ? json_encode($calendarEvents) : '[]' !!},
                    eventClick: function (info) {
                        if (info.event.url) {
                            window.location.href = info.event.url;
                            return false;
                        }
                    },
                    eventDidMount: function (info) {
                        // Add custom class based on event type
                        const eventType = info.event.extendedProps?.type ||
                            (info.event.title?.includes('📝') ? 'assignment' :
                                info.event.title?.includes('⚠️') ? 'overdue' : 'session');

                        if (eventType === 'session') {
                            info.el.classList.add('session');
                        } else if (eventType === 'assignment') {
                            info.el.classList.add('assignment');
                        } else if (eventType === 'overdue') {
                            info.el.classList.add('overdue');
                        }
                    },
                    dayCellDidMount: function (info) {
                        // Highlight today
                        const today = new Date();
                        if (info.date.toDateString() === today.toDateString()) {
                            info.el.style.background = '#f0f9ff';
                        }
                    },
                    // Fix for event display
                    eventDisplay: 'block',
                    eventTimeFormat: {
                        hour: '2-digit',
                        minute: '2-digit',
                        meridiem: 'short'
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

        // Toggle Tasks Collapse
        function toggleTasks() {
            const content = document.getElementById('tasksContent');
            const icon = document.getElementById('toggleIcon');
            const header = document.querySelector('.tasks-header');

            tasksCollapsed = !tasksCollapsed;

            if (tasksCollapsed) {
                content.classList.add('collapsed');
                header.classList.add('collapsed');
                icon.style.transform = 'rotate(0deg)';
            } else {
                content.classList.remove('collapsed');
                header.classList.remove('collapsed');
                icon.style.transform = 'rotate(180deg)';
            }
        }

        // Task filtering
        function filterTasks(type, element) {
            const tasks = document.querySelectorAll('.task-item');
            const tabs = document.querySelectorAll('.task-tab');

            tabs.forEach(tab => tab.classList.remove('active'));
            element.classList.add('active');

            let visibleCount = 0;

            tasks.forEach(task => {
                if (type === 'all') {
                    task.style.display = 'flex';
                    visibleCount++;
                } else {
                    if (task.dataset.type === type) {
                        task.style.display = 'flex';
                        visibleCount++;
                    } else {
                        task.style.display = 'none';
                    }
                }
            });

            // Show empty state if no visible tasks
            const tasksList = document.getElementById('tasksList');
            const existingEmpty = document.querySelector('.tasks-list .empty-state');

            if (visibleCount === 0 && tasks.length > 0) {
                if (!existingEmpty) {
                    const emptyDiv = document.createElement('div');
                    emptyDiv.className = 'empty-state';
                    emptyDiv.style.padding = '40px';
                    emptyDiv.innerHTML = `
                        <i class="fas fa-check-circle" style="color: #10b981;"></i>
                        <h3>No Tasks Found</h3>
                        <p>No ${type} tasks at the moment.</p>
                    `;
                    tasksList.appendChild(emptyDiv);
                }
            } else if (existingEmpty) {
                existingEmpty.remove();
            }
        }
    </script>
@endsection