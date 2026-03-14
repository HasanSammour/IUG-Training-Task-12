@extends('layouts.app')

@section('title', $course->title . ' - Students')
@section('body-class', 'instructor-course-students')

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

    .instructor-course-students {
        background-color: var(--bg-light);
        min-height: 100vh;
    }

    .students-content {
        padding: 30px 40px;
        max-width: 1400px;
        margin: 0 auto;
        padding-bottom: 100px;
    }

    /* Header Section */
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding: 20px 25px;
        background: var(--white);
        border-radius: var(--radius-xl);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
    }

    .back-link {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-dark);
        text-decoration: none;
        font-weight: 500;
        padding: 8px 16px;
        border-radius: var(--radius-md);
        transition: all 0.3s ease;
    }

    .back-link:hover {
        background: #f1f5f9;
        color: var(--primary-navy);
    }

    .page-title-section h1 {
        font-size: 24px;
        color: var(--primary-navy);
        margin-bottom: 5px;
        font-weight: 700;
    }

    .page-subtitle {
        color: var(--text-gray);
        font-size: 14px;
    }

    .header-actions {
        display: flex;
        gap: 12px;
    }

    .badge {
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge i {
        font-size: 12px;
    }

    .badge.active {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }

    .badge.inactive {
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
    }

    .badge.featured {
        background: #fef3c7;
        color: #d97706;
        border: 1px solid #fde68a;
    }

    /* Course Info Card */
    .course-info-card {
        background: linear-gradient(135deg, #f0f7ff 0%, #e6f0fa 100%);
        margin-bottom: 25px;
        padding: 25px;
        border-radius: var(--radius-xl);
        border: 1px solid var(--border-color);
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 25px;
        align-items: center;
    }

    @media (max-width: 768px) {
        .course-info-card {
            grid-template-columns: 1fr;
            text-align: center;
        }
    }

    .course-info-text h2 {
        font-size: 22px;
        color: var(--primary-navy);
        margin-bottom: 8px;
        font-weight: 700;
    }

    .course-meta {
        display: flex;
        gap: 20px;
        color: var(--text-gray);
        font-size: 14px;
        flex-wrap: wrap;
    }

    .course-meta i {
        margin-right: 6px;
        color: var(--primary-navy);
    }

    .course-price {
        text-align: right;
    }

    .price-current {
        font-size: 24px;
        font-weight: 700;
        color: var(--primary-navy);
    }

    .price-original {
        font-size: 16px;
        color: var(--text-light);
        text-decoration: line-through;
        margin-left: 10px;
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
        background: var(--white);
        padding: 20px;
        border-radius: var(--radius-lg);
        border: 1px solid #edf2f7;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-sm);
    }

    .stat-card:hover {
        transform: translateY(-3px);
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
        font-size: 20px;
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

    /* Tab Navigation */
    .course-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        overflow-x: auto;
        padding-bottom: 5px;
        border-bottom: 1px solid var(--border-color);
    }

    .tab-btn {
        padding: 12px 24px;
        border-radius: 30px 30px 0 0;
        background: #f8fafc;
        color: #475569;
        font-size: 14px;
        border: 1px solid var(--border-color);
        border-bottom: none;
        cursor: pointer;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .tab-btn i {
        color: #64748b;
    }

    .tab-btn.active {
        background: var(--white);
        color: var(--primary-navy);
        font-weight: 600;
        border-color: var(--primary-navy);
        border-bottom: 2px solid var(--white);
        margin-bottom: -1px;
    }

    .tab-btn.active i {
        color: var(--primary-navy);
    }

    .tab-btn:hover:not(.active) {
        background: #e2e8f0;
        border-color: #94a3b8;
    }

    .tab-badge {
        background: var(--primary-navy);
        color: var(--white);
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 11px;
        margin-left: 5px;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Filter Section */
    .filter-section {
        background: var(--white);
        padding: 25px;
        border-radius: var(--radius-lg);
        margin-bottom: 25px;
        border: 1px solid #edf2f7;
        box-shadow: var(--shadow-sm);
    }

    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .filter-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--primary-navy);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-title i {
        color: var(--secondary-blue);
    }

    .clear-filters {
        color: var(--text-gray);
        font-size: 13px;
        text-decoration: none;
        padding: 6px 12px;
        border-radius: 6px;
        background: #f1f5f9;
        transition: all 0.3s ease;
    }

    .clear-filters:hover {
        background: #e2e8f0;
        color: var(--primary-navy);
    }

    .filter-grid {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .filter-row-1 {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 20px;
    }

    .filter-row-2 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .filter-row-3 {
        display: grid;
        grid-template-columns: 200px 1fr;
        gap: 20px;
        align-items: center;
        margin-top: 10px;
    }

    @media (max-width: 992px) {
        .filter-row-1 {
            grid-template-columns: 1fr;
        }
        .filter-row-2 {
            grid-template-columns: repeat(2, 1fr);
        }
        .filter-row-3 {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .filter-row-2 {
            grid-template-columns: 1fr;
        }
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-gray);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .filter-label i {
        color: var(--secondary-blue);
        font-size: 14px;
    }

    .filter-input {
        padding: 12px 14px;
        border-radius: 10px;
        border: 1px solid var(--border-color);
        background: var(--white);
        font-size: 14px;
        color: var(--text-dark);
        transition: all 0.3s ease;
        width: 100%;
        height: 48px;
        box-sizing: border-box;
    }

    .filter-input:focus {
        outline: none;
        border-color: var(--primary-navy);
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    .filter-select {
        padding: 12px 14px;
        border-radius: 10px;
        border: 1px solid var(--border-color);
        background: var(--white);
        font-size: 14px;
        color: var(--text-dark);
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-position: right 14px center;
        background-repeat: no-repeat;
        background-size: 16px;
        padding-right: 40px;
        width: 100%;
        height: 48px;
        box-sizing: border-box;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--primary-navy);
    }

    .search-wrapper {
        position: relative;
        width: 100%;
        display: flex;
        align-items: center;
    }

    .search-input {
        width: 100%;
        padding: 12px 14px 12px 45px;
        border-radius: 10px;
        border: 1px solid var(--border-color);
        background: var(--white);
        font-size: 14px;
        color: var(--text-dark);
        transition: all 0.3s ease;
        height: 48px;
        box-sizing: border-box;
    }

    .search-input::placeholder {
        color: var(--text-light);
        font-size: 14px;
        opacity: 1;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary-navy);
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
        background: var(--white);
    }

    .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-light);
        font-size: 16px;
        pointer-events: none;
        z-index: 2;
    }

    .btn-apply {
        width: 100%;
        padding: 12px;
        background: var(--primary-navy);
        color: var(--white);
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 48px;
        box-sizing: border-box;
    }

    .btn-apply:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.2);
    }

    .active-filters {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
    }

    .filter-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        background: #f1f5f9;
        border-radius: 30px;
        font-size: 13px;
        color: var(--text-dark);
        font-weight: 500;
    }

    .filter-tag i {
        color: var(--text-gray);
        font-size: 12px;
    }

    .remove-filter {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #cbd5e0;
        color: var(--white);
        font-size: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .remove-filter:hover {
        background: var(--primary-navy);
    }

    .filter-label-text {
        font-weight: 600;
        color: #475569;
    }

    /* Bulk Actions Bar */
    .bulk-actions-bar {
        background: #f0f9ff;
        border: 1px solid #bae6fd;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .bulk-select-all {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #0369a1;
        font-weight: 500;
    }

    .bulk-select-all input {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: var(--primary-navy);
    }

    .bulk-actions-select {
        flex: 1;
        min-width: 200px;
    }

    .bulk-actions-select select {
        width: 100%;
        padding: 10px 12px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background: var(--white);
        font-size: 13px;
        outline: none;
        cursor: pointer;
    }

    .bulk-actions-select select:focus {
        border-color: var(--primary-navy);
        box-shadow: 0 0 0 2px rgba(45, 62, 80, 0.1);
    }

    .btn-apply-bulk {
        background: var(--primary-navy);
        color: var(--white);
        border: none;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-apply-bulk:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
    }

    /* Students Table Section */
    .students-section {
        background: var(--white);
        border-radius: var(--radius-xl);
        border: 1px solid #edf2f7;
        overflow: hidden;
        margin-bottom: 30px;
        width: 100%;
        box-shadow: var(--shadow-md);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        border-bottom: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 15px;
    }

    .section-title {
        font-size: 18px;
        color: var(--primary-navy);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-export {
        background: #f1f5f9;
        color: var(--text-dark);
        padding: 10px 18px;
        border-radius: 10px;
        border: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-export:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

    .btn-export.pdf {
        background: #fee2e2;
        color: #b91c1c;
    }

    .btn-export.pdf:hover {
        background: #fecaca;
    }

    .btn-bulk {
        background: var(--primary-navy);
        color: var(--white);
        padding: 10px 18px;
        border-radius: 10px;
        border: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-bulk:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1200px;
    }

    th {
        text-align: left;
        padding: 16px 20px;
        font-size: 12px;
        color: var(--text-gray);
        background: #fafafa;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #f1f5f9;
    }

    td {
        padding: 20px;
        font-size: 14px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    tr:hover td {
        background: #f8fafc;
    }

    .checkbox-cell {
        width: 40px;
        text-align: center;
    }

    .checkbox-cell input {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: var(--primary-navy);
    }

    .student-cell {
        min-width: 200px;
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .student-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--primary-navy), #1a252f);
        color: var(--white);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        flex-shrink: 0;
    }

    .student-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .student-details {
        flex: 1;
    }

    .student-name {
        color: var(--primary-navy);
        font-weight: 600;
        font-size: 15px;
        margin-bottom: 4px;
    }

    .student-email {
        font-size: 12px;
        color: var(--text-gray);
    }

    .date-cell {
        color: #475569;
        font-weight: 500;
    }

    .progress-cell {
        min-width: 150px;
    }

    .progress-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .progress-bar-container {
        flex: 1;
        height: 8px;
        background: #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary-navy), #4a5e70);
        border-radius: 10px;
        transition: width 0.5s ease;
    }

    .progress-percentage {
        font-size: 13px;
        font-weight: 600;
        color: var(--primary-navy);
        min-width: 45px;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        text-align: center;
        min-width: 100px;
    }

    .status-active {
        background: #dcfce7;
        color: #15803d;
    }

    .status-pending {
        background: #fef3c7;
        color: #b45309;
    }

    .status-completed {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #b91c1c;
    }

    .activity-cell {
        color: var(--text-gray);
        font-size: 13px;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background: var(--white);
        color: var(--text-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .btn-icon:hover {
        background: var(--primary-navy);
        color: var(--white);
        border-color: var(--primary-navy);
        transform: translateY(-2px);
    }

    .btn-icon.message:hover {
        background: #2563eb;
        border-color: #2563eb;
    }

    .btn-icon.progress:hover {
        background: #16a34a;
        border-color: #16a34a;
    }

    .btn-icon.certificate:hover {
        background: #d97706;
        border-color: #d97706;
    }

    .btn-icon.details:hover {
        background: var(--primary-navy);
        border-color: var(--primary-navy);
    }

    /* Sessions Section - Fixed width */
    .sessions-section {
        background: var(--white);
        border-radius: var(--radius-xl);
        border: 1px solid #edf2f7;
        overflow: hidden;
        margin-bottom: 30px;
        width: 100%;
        box-shadow: var(--shadow-md);
    }

    .sessions-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        border-bottom: 1px solid #f1f5f9;
        flex-wrap: wrap;
        gap: 15px;
    }

    .sessions-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 25px;
        width: 100%;
    }

    @media (max-width: 1200px) {
        .sessions-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .sessions-grid {
            grid-template-columns: 1fr;
        }
    }

    .session-card {
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        position: relative;
        width: 100%;
        box-sizing: border-box;
    }

    .session-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        border-color: var(--primary-navy);
    }

    .session-status {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 10px;
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

    .session-time {
        font-size: 12px;
        color: var(--text-gray);
        margin: 10px 0;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .session-meeting, .session-recording {
        margin: 8px 0;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .session-meeting i, .session-recording i {
        color: #2563eb;
    }

    .session-meeting a, .session-recording a {
        color: #2563eb;
        text-decoration: none;
    }

    .session-meeting a:hover, .session-recording a:hover {
        text-decoration: underline;
    }

    .session-actions {
        display: flex;
        gap: 8px;
        margin-top: 15px;
        flex-wrap: wrap;
    }

    .btn-session {
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-session.share {
        background: #2563eb;
        color: var(--white);
    }

    .btn-session.attendance {
        background: #10b981;
        color: var(--white);
    }

    .btn-session.edit {
        background: #f1f5f9;
        color: #475569;
    }

    .btn-session.edit:hover {
        background: #e2e8f0;
        color: #2D3E50;
    }

    .btn-session.delete {
        background: #fee2e2;
        color: #b91c1c;
    }

    .btn-session.delete:hover {
        background: #fecaca;
    }

    .btn-session:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* Assignments Section - Fixed width */
    .assignments-section {
        background: var(--white);
        border-radius: var(--radius-xl);
        border: 1px solid #edf2f7;
        overflow: hidden;
        margin-bottom: 30px;
        width: 100%;
        box-shadow: var(--shadow-md);
    }

    .assignments-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 25px;
        width: 100%;
    }

    @media (max-width: 1200px) {
        .assignments-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .assignments-grid {
            grid-template-columns: 1fr;
        }
    }

    .assignment-card {
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        width: 100%;
        box-sizing: border-box;
    }

    .assignment-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        border-color: var(--primary-navy);
    }

    .assignment-due {
        font-size: 11px;
        color: var(--text-gray);
        margin: 8px 0;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .assignment-stats {
        display: flex;
        justify-content: space-between;
        margin: 12px 0;
        font-size: 12px;
        padding: 10px;
        background: var(--white);
        border-radius: 8px;
    }

    .submission-count {
        background: #dbeafe;
        color: #1e40af;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
    }

    .btn-assignment {
        width: 100%;
        padding: 10px;
        background: var(--primary-navy);
        color: var(--white);
        border: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-assignment:hover {
        background: #1a252f;
    }

    /* Materials Section - Fixed width */
    .materials-section {
        background: var(--white);
        border-radius: var(--radius-xl);
        border: 1px solid #edf2f7;
        overflow: hidden;
        margin-bottom: 30px;
        width: 100%;
        box-shadow: var(--shadow-md);
    }

    .materials-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 25px;
        width: 100%;
    }

    @media (max-width: 1200px) {
        .materials-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .materials-grid {
            grid-template-columns: 1fr;
        }
    }

    .material-card {
        background: #f8fafc;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
        cursor: pointer;
        width: 100%;
        box-sizing: border-box;
    }

    .material-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        border-color: var(--primary-navy);
    }

    .material-icon {
        width: 50px;
        height: 50px;
        background: #e0f2fe;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0284c7;
        font-size: 22px;
        flex-shrink: 0;
    }

    .material-info {
        flex: 1;
    }

    .material-title {
        font-size: 15px;
        font-weight: 600;
        color: var(--primary-navy);
        margin-bottom: 4px;
    }

    .material-type {
        font-size: 11px;
        color: var(--text-gray);
    }

    .btn-material-share {
        background: none;
        border: none;
        color: var(--text-light);
        cursor: pointer;
        padding: 8px;
        transition: color 0.3s ease;
        font-size: 16px;
    }

    .btn-material-share:hover {
        color: #2563eb;
    }

    /* Empty State - FIXED: Full width */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        width: 100%;
        background: var(--white);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        grid-column: 1 / -1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
    }

    .empty-icon {
        font-size: 64px;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 20px;
        color: var(--primary-navy);
        margin-bottom: 10px;
        font-weight: 600;
    }

    .empty-state p {
        color: var(--text-gray);
        margin-bottom: 25px;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 20px 25px;
        border-top: 1px solid #f1f5f9;
    }

    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .pagination-info {
        font-size: 13px;
        color: var(--text-gray);
    }

    .pagination-links {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    .page-link {
        min-width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        color: #475569;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background: #f1f5f9;
        border-color: var(--primary-navy);
        color: var(--primary-navy);
    }

    .page-link.active {
        background: var(--primary-navy);
        color: var(--white);
        font-weight: 600;
        border-color: var(--primary-navy);
    }

    .page-arrow {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        text-decoration: none;
        color: var(--primary-navy);
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .page-arrow:hover:not(.disabled) {
        background: #f1f5f9;
        border-color: var(--primary-navy);
    }

    .page-arrow.disabled {
        opacity: 0.3;
        cursor: not-allowed;
        pointer-events: none;
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
        background: var(--white);
        border-radius: 20px;
        padding: 30px;
        max-width: 550px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: var(--shadow-lg);
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

    .close-btn {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: var(--text-light);
        transition: color 0.3s ease;
    }

    .close-btn:hover {
        color: var(--primary-navy);
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
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-navy);
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    .student-checkboxes {
        max-height: 300px;
        overflow-y: auto;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 10px;
    }

    .student-checkboxes label {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px;
        border-bottom: 1px solid #f1f5f9;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .student-checkboxes label:hover {
        background: #f8fafc;
    }

    .student-checkboxes label:last-child {
        border-bottom: none;
    }

    .student-checkboxes input {
        width: 18px;
        height: 18px;
        accent-color: var(--primary-navy);
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
    }

    .btn-primary:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
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
        width: 50px;
        height: 50px;
        border: 4px solid #f1f5f9;
        border-top-color: var(--primary-navy);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .students-content {
            padding: 15px;
        }

        .header-section {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }

        .course-info-card {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .course-meta {
            justify-content: center;
        }

        .course-price {
            text-align: center;
        }

        .course-tabs {
            flex-wrap: nowrap;
            overflow-x: auto;
            padding-bottom: 10px;
        }

        .tab-btn {
            padding: 10px 16px;
            font-size: 13px;
        }

        .bulk-actions-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .bulk-actions-select {
            width: 100%;
        }

        .btn-apply-bulk {
            width: 100%;
        }

        .filter-row-1,
        .filter-row-2,
        .filter-row-3 {
            grid-template-columns: 1fr;
        }

        .pagination-container {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .pagination-links {
            justify-content: center;
        }

        .sessions-grid,
        .assignments-grid,
        .materials-grid {
            grid-template-columns: 1fr;
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
<div class="students-content">
    <!-- Header Section -->
    <div class="header-section">
        <a href="{{ route('instructor.courses') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to My Courses
        </a>

        <div class="page-title-section">
            <h1>{{ $course->title }}</h1>
            <p class="page-subtitle">Manage students, sessions, assignments & materials</p>
        </div>

        <div class="header-actions">
            {{-- This may not be needed since i prevent Instructor from intering to this page for inactive course  --}}
            @if(!$course->is_active && auth()->user()->hasRole('instructor'))
                <span class="badge" style="background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;">
                    <i class="fas fa-exclamation-triangle"></i> Inactive - View Only
                </span>
            @else
                <span class="badge {{ $course->is_active ? 'active' : 'inactive' }}">
                    <i class="fas {{ $course->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                    {{ $course->is_active ? 'Active' : 'Inactive' }}
                </span>
            @endif

            @if($course->is_featured)
                <span class="badge featured">
                    <i class="fas fa-star"></i> Featured
                </span>
            @endif
        </div>
    </div>

    <!-- Course Info Card -->
    <div class="course-info-card">
        <div class="course-info-text">
            <h2>{{ $course->title }}</h2>
            <div class="course-meta">
                <span><i class="fas fa-chalkboard-teacher"></i> {{ $course->instructor_name }}</span>
                <span><i class="fas fa-clock"></i> {{ $course->duration ?? '4 weeks' }}</span>
                <span><i class="fas fa-tag"></i> {{ ucfirst($course->level) }}</span>
                <span><i class="fas fa-video"></i> {{ ucfirst($course->format) }}</span>
                <span><i class="fas fa-folder"></i> {{ $course->category->name ?? 'Uncategorized' }}</span>
            </div>
        </div>

        <div class="course-price">
            @if($course->discounted_price)
                <span class="price-current">${{ number_format($course->discounted_price, 0) }}</span>
                <span class="price-original">${{ number_format($course->price, 0) }}</span>
            @else
                <span class="price-current">${{ number_format($course->price, 0) }}</span>
            @endif
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-details">
                <span class="stat-number">{{ $stats['total'] }}</span>
                <span class="stat-label">Total Students</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-details">
                <span class="stat-number">{{ $stats['active'] }}</span>
                <span class="stat-label">Active</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="stat-details">
                <span class="stat-number">{{ $stats['completed'] }}</span>
                <span class="stat-label">Completed</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-details">
                <span class="stat-number">{{ $stats['average_progress'] }}%</span>
                <span class="stat-label">Avg Progress</span>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="course-tabs">
        <button class="tab-btn active" onclick="switchTab('students')" id="tabStudents">
            <i class="fas fa-users"></i>
            Students
            <span class="tab-badge">{{ $enrollments->total() }}</span>
        </button>
        <button class="tab-btn" onclick="switchTab('sessions')" id="tabSessions">
            <i class="fas fa-video"></i>
            Live Sessions
            <span class="tab-badge">{{ $sessions->count() }}</span>
        </button>
        <button class="tab-btn" onclick="switchTab('assignments')" id="tabAssignments">
            <i class="fas fa-tasks"></i>
            Assignments
            <span class="tab-badge">{{ $assignments->count() }}</span>
        </button>
        <button class="tab-btn" onclick="switchTab('materials')" id="tabMaterials">
            <i class="fas fa-file-alt"></i>
            Materials
            <span class="tab-badge">{{ $materials->count() }}</span>
        </button>
    </div>

    <!-- Students Tab -->
    <div id="tabStudentsContent" class="tab-content active">
        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-header">
                <h3 class="filter-title">
                    <i class="fas fa-filter"></i> Filter Students
                </h3>
                @if(request()->anyFilled(['status', 'search', 'date_from', 'date_to', 'progress_min', 'progress_max']))
                    <a href="{{ route('instructor.course-students', ['course' => $course->id]) }}" class="clear-filters">
                        <i class="fas fa-times-circle"></i> Clear All Filters
                    </a>
                @endif
            </div>

            <form method="GET" action="{{ route('instructor.course-students', ['course' => $course->id]) }}" id="filterForm">
                <div class="filter-grid">
                    <div class="filter-row-1">
                        <div class="filter-group">
                            <label class="filter-label"><i class="fas fa-flag"></i> Enrollment Status</label>
                            <select name="status" class="filter-select">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <div class="search-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" name="search" class="search-input"
                                placeholder="Search by student name or email..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="filter-row-2">
                        <div class="filter-group">
                            <label class="filter-label"><i class="fas fa-calendar"></i> From Date</label>
                            <input type="date" name="date_from" class="filter-input" value="{{ request('date_from') }}">
                        </div>

                        <div class="filter-group">
                            <label class="filter-label"><i class="fas fa-calendar"></i> To Date</label>
                            <input type="date" name="date_to" class="filter-input" value="{{ request('date_to') }}">
                        </div>

                        <div class="filter-group">
                            <label class="filter-label"><i class="fas fa-percent"></i> Min Progress</label>
                            <input type="number" name="progress_min" class="filter-input" placeholder="0%" min="0" max="100"
                                value="{{ request('progress_min') }}">
                        </div>

                        <div class="filter-group">
                            <label class="filter-label"><i class="fas fa-percent"></i> Max Progress</label>
                            <input type="number" name="progress_max" class="filter-input" placeholder="100%" min="0"
                                max="100" value="{{ request('progress_max') }}">
                        </div>
                    </div>

                    <div class="filter-row-3">
                        <button type="submit" class="btn-apply">
                            <i class="fas fa-check"></i> Apply Filters
                        </button>

                        <div class="active-filters">
                            @php
                                $activeFilters = [];
                                if (request('status')) $activeFilters[] = ['type' => 'status', 'label' => 'Status: ' . ucfirst(request('status')), 'param' => 'status'];
                                if (request('date_from')) $activeFilters[] = ['type' => 'date_from', 'label' => 'From: ' . \Carbon\Carbon::parse(request('date_from'))->format('M d, Y'), 'param' => 'date_from'];
                                if (request('date_to')) $activeFilters[] = ['type' => 'date_to', 'label' => 'To: ' . \Carbon\Carbon::parse(request('date_to'))->format('M d, Y'), 'param' => 'date_to'];
                                if (request('progress_min')) $activeFilters[] = ['type' => 'progress_min', 'label' => 'Min: ' . request('progress_min') . '%', 'param' => 'progress_min'];
                                if (request('progress_max')) $activeFilters[] = ['type' => 'progress_max', 'label' => 'Max: ' . request('progress_max') . '%', 'param' => 'progress_max'];
                                if (request('search')) $activeFilters[] = ['type' => 'search', 'label' => 'Search: "' . request('search') . '"', 'param' => 'search'];
                            @endphp

                            @if(!empty($activeFilters))
                                <span class="filter-label-text">Active Filters:</span>
                                @foreach($activeFilters as $filter)
                                    <span class="filter-tag">
                                        <i class="fas fa-filter"></i> {{ $filter['label'] }}
                                        <a href="{{ route('instructor.course-students', ['course' => $course->id] + request()->except($filter['param'])) }}" 
                                           class="remove-filter">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Bulk Actions Bar -->
        <div class="bulk-actions-bar">
            <div class="bulk-select-all">
                <input type="checkbox" id="selectAll" onclick="toggleSelectAll()">
                <label for="selectAll">Select All</label>
            </div>
            <div class="bulk-actions-select">
                <select id="bulkAction">
                    <option value="">Bulk Actions</option>
                    <option value="progress">Update Progress</option>
                    <option value="attendance">Mark Attendance (Bulk)</option>
                    <option value="message">Send Message</option>
                </select>
            </div>
            <button class="btn-apply-bulk" onclick="applyBulkAction()">
                <i class="fas fa-check"></i> Apply to Selected
            </button>
        </div>

        <!-- Students Table -->
        <div class="students-section">
            <div class="section-header">
                <h3 class="section-title">
                    <i class="fas fa-user-graduate"></i> Enrolled Students
                </h3>
                <div class="section-actions">
                    <button class="btn-export pdf" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                </div>
            </div>

            @if($enrollments->count() > 0)
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th class="checkbox-cell">
                                    <input type="checkbox" id="selectAllHeader" onclick="toggleSelectAll()">
                                </th>
                                <th>Student</th>
                                <th>Enrolled Date</th>
                                <th>Progress</th>
                                <th>Status</th>
                                <th>Last Activity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enrollments as $enrollment)
                                <tr>
                                    <td class="checkbox-cell">
                                        <input type="checkbox" class="student-checkbox" value="{{ $enrollment->user_id }}">
                                    </td>
                                    <td class="student-cell">
                                        <div class="student-info">
                                            <div class="student-avatar">
                                                @if($enrollment->user->avatar)
                                                    <img src="{{ $enrollment->user->avatar_url }}" alt="{{ $enrollment->user->name }}">
                                                @else
                                                    {{ $enrollment->user->initials }}
                                                @endif
                                            </div>
                                            <div class="student-details">
                                                <div class="student-name">{{ $enrollment->user->name }}</div>
                                                <div class="student-email">{{ $enrollment->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="date-cell">
                                        <div>{{ $enrollment->enrolled_at->format('M d, Y') }}</div>
                                        <small>{{ $enrollment->enrolled_at->diffForHumans() }}</small>
                                    </td>
                                    <td class="progress-cell">
                                        <div class="progress-wrapper">
                                            <div class="progress-bar-container">
                                                <div class="progress-bar-fill" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                            </div>
                                            <span class="progress-percentage">{{ $enrollment->progress_percentage }}%</span>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match ($enrollment->status) {
                                                'active' => 'status-active',
                                                'completed' => 'status-completed',
                                                'pending' => 'status-pending',
                                                'cancelled' => 'status-cancelled',
                                                default => ''
                                            };
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">
                                            {{ ucfirst($enrollment->status) }}
                                        </span>
                                    </td>
                                    <td class="activity-cell">
                                        @if($enrollment->updated_at)
                                            <div>{{ $enrollment->updated_at->format('M d, Y') }}</div>
                                            <small>{{ $enrollment->updated_at->diffForHumans() }}</small>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon message"
                                                onclick="sendMessage({{ $enrollment->user->id }}, '{{ $enrollment->user->name }}')"
                                                title="Send Message">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                            <button class="btn-icon progress" onclick="viewProgress({{ $enrollment->id }})"
                                                title="View Detailed Progress">
                                                <i class="fas fa-chart-pie"></i>
                                            </button>
                                            <button class="btn-icon certificate"
                                                onclick="generateCertificate({{ $enrollment->id }}, {{ $enrollment->progress_percentage }}, '{{ $enrollment->user->name }}')"
                                                title="Generate Certificate">
                                                <i class="fas fa-certificate"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrapper">
                    <div class="pagination-container">
                        <div class="pagination-info">
                            Showing <strong>{{ $enrollments->firstItem() }}</strong> to <strong>{{ $enrollments->lastItem() }}</strong>
                            of <strong>{{ $enrollments->total() }}</strong> students
                        </div>
                        <div class="pagination-links">
                            {{ $enrollments->onEachSide(1)->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h3>No Students Found</h3>
                    <p>
                        @if(request()->anyFilled(['status', 'search', 'date_from', 'date_to', 'progress_min', 'progress_max']))
                            No students match your current filters.
                        @else
                            No students have enrolled in this course yet.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Sessions Tab - UPDATED with Edit Modal and Delete Button -->
    <div id="tabSessionsContent" class="tab-content">
        <div class="sessions-section">
            <div class="sessions-header">
                <h3 class="section-title">
                    <i class="fas fa-video"></i> Live Sessions
                </h3>
                <button class="btn-bulk" onclick="openCreateSessionModal()">
                    <i class="fas fa-plus"></i> Schedule Session
                </button>
            </div>

            @if($sessions->count() > 0)
                <div class="sessions-grid">
                    @foreach($sessions as $session)
                        <div class="session-card">
                            <span class="session-status status-{{ $session->status }}">
                                {{ ucfirst($session->status) }}
                            </span>
                            <h4>{{ $session->title }}</h4>
                            <p>{{ Str::limit($session->description, 80) }}</p>
                            <div class="session-time">
                                <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($session->start_time)->format('M d, Y - h:i A') }}
                            </div>
                            @if($session->meeting_url)
                                <div class="session-meeting">
                                    <i class="fas fa-video"></i> 
                                    <a href="{{ $session->meeting_url }}" target="_blank">Meeting Link</a>
                                </div>
                            @endif
                            @if($session->recording_url)
                                <div class="session-recording">
                                    <i class="fas fa-play-circle"></i> 
                                    <a href="{{ $session->recording_url }}" target="_blank">Recording</a>
                                </div>
                            @endif
                            <div class="session-actions">
                                @if($session->meeting_url)
                                    <button class="btn-session share" onclick="shareMeetingLink({{ $session->id }})">
                                        <i class="fas fa-share"></i> Share Link
                                    </button>
                                @endif
                                @if($session->recording_url)
                                    <button class="btn-session share" onclick="shareRecording({{ $session->id }})">
                                        <i class="fas fa-video"></i> Share Recording
                                    </button>
                                @endif
                                <button class="btn-session attendance" onclick="openSessionAttendanceModal({{ $session->id }}, '{{ $session->title }}')">
                                    <i class="fas fa-check-circle"></i> Attendance
                                </button>
                                
                                <!-- NEW: Edit and Delete buttons -->
                                <div style="display: flex; gap: 5px; margin-top: 10px; width: 100%;">
                                    <button class="btn-session edit" onclick="openEditSessionModal({{ $session->id }})" style="flex: 1;">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn-session delete" onclick="deleteSession({{ $session->id }}, '{{ $session->title }}')" style="flex: 1;">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-video"></i>
                    </div>
                    <h3>No Sessions Scheduled</h3>
                    <p>Schedule your first live session.</p>
                    <button class="btn-bulk" onclick="openCreateSessionModal()">
                        <i class="fas fa-plus"></i> Schedule Session
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Assignments Tab -->
    <div id="tabAssignmentsContent" class="tab-content">
        <div class="assignments-section">
            <div class="sessions-header">
                <h3 class="section-title">
                    <i class="fas fa-tasks"></i> Assignments
                </h3>
                <a href="{{ route('instructor.course.assignments.create', ['course' => $course->id]) }}" class="btn-bulk">
                    <i class="fas fa-plus"></i> Create Assignment
                </a>
            </div>

            @if($assignments->count() > 0)
                <div class="assignments-grid">
                    @foreach($assignments as $assignment)
                        <div class="assignment-card">
                            <h4>{{ $assignment->title }}</h4>
                            <p>{{ Str::limit($assignment->description, 80) }}</p>
                            @if($assignment->due_date)
                                <div class="assignment-due">
                                    <i class="fas fa-calendar"></i> Due: {{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') }}
                                </div>
                            @endif
                            <div class="assignment-stats">
                                <span class="submission-count">
                                    <i class="fas fa-users"></i> {{ $assignment->submissions_count ?? 0 }} submissions
                                </span>
                                <span>{{ $assignment->points }} pts</span>
                            </div>
                            <button class="btn-assignment" onclick="viewSubmissions({{ $assignment->id }})">
                                View Submissions
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <h3>No Assignments</h3>
                    <p>Create your first assignment.</p>
                    <a href="{{ route('instructor.course.assignments.create', ['course' => $course->id]) }}" class="btn-bulk">
                        <i class="fas fa-plus"></i> Create Assignment
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Materials Tab -->
    <div id="tabMaterialsContent" class="tab-content">
        <div class="materials-section">
            <div class="sessions-header">
                <h3 class="section-title">
                    <i class="fas fa-file-alt"></i> Course Materials
                </h3>
                <a href="{{ route('instructor.course.materials.create', ['course' => $course->id]) }}" class="btn-bulk">
                    <i class="fas fa-plus"></i> Add Material
                </a>
            </div>

            @if($materials->count() > 0)
                <div class="materials-grid">
                    @foreach($materials as $material)
                        <div class="material-card" onclick="viewMaterial({{ $material->id }})">
                            <div class="material-icon">
                                @switch($material->type)
                                    @case('video')
                                        <i class="fas fa-video"></i>
                                        @break
                                    @case('document')
                                        <i class="fas fa-file-pdf"></i>
                                        @break
                                    @case('presentation')
                                        <i class="fas fa-file-powerpoint"></i>
                                        @break
                                    @case('link')
                                        <i class="fas fa-link"></i>
                                        @break
                                    @default
                                        <i class="fas fa-file"></i>
                                @endswitch
                            </div>
                            <div class="material-info">
                                <div class="material-title">{{ $material->title }}</div>
                                <div class="material-type">{{ ucfirst($material->type) }}</div>
                            </div>
                            <button class="btn-material-share" onclick="event.stopPropagation(); shareMaterial({{ $material->id }})">
                                <i class="fas fa-share-alt"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3>No Materials</h3>
                    <p>Add course materials for your students.</p>
                    <a href="{{ route('instructor.course.materials.create', ['course' => $course->id]) }}" class="btn-bulk">
                        <i class="fas fa-plus"></i> Add Material
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Message Modal -->
<div class="modal" id="messageModal" onclick="if(event.target === this) closeMessageModal()">
    <div class="modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h3><i class="fas fa-envelope"></i> Send Message to <span id="studentName"></span></h3>
            <button class="close-btn" onclick="closeMessageModal()">&times;</button>
        </div>
        <div class="success-message" id="successMessage">
            <i class="fas fa-check-circle"></i> Message sent successfully!
        </div>
        <form id="messageForm">
            @csrf
            <input type="hidden" id="receiverId" name="receiver_id">
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <div class="form-group">
                <label for="messageText">Your Message</label>
                <textarea id="messageText" name="message" class="form-control" rows="4" placeholder="Type your message..." required></textarea>
            </div>
            <div class="modal-actions">
                <button type="submit" class="btn-primary" id="sendBtn">
                    <i class="fas fa-paper-plane"></i> Send
                </button>
                <button type="button" class="btn-secondary" onclick="closeMessageModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Message Modal -->
<div class="modal" id="bulkMessageModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Send Message to Selected Students</h3>
            <button class="close-btn" onclick="closeBulkMessageModal()">&times;</button>
        </div>
        <div class="form-group">
            <label>Message</label>
            <textarea id="bulkMessage" class="form-control" rows="4" required></textarea>
        </div>
        <div class="modal-actions">
            <button class="btn-primary" onclick="sendBulkMessage()">
                <i class="fas fa-paper-plane"></i> Send
            </button>
            <button class="btn-secondary" onclick="closeBulkMessageModal()">Cancel</button>
        </div>
    </div>
</div>

<!-- Create Session Modal -->
<div class="modal" id="sessionModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Schedule New Session</h3>
            <button class="close-btn" onclick="closeSessionModal()">&times;</button>
        </div>
        <form method="POST" action="{{ route('instructor.course.sessions.store', ['course' => $course->id]) }}">
            @csrf
            <div class="form-group">
                <label>Session Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Meeting URL (Google Meet/Zoom)</label>
                <input type="url" name="meeting_url" class="form-control" placeholder="https://meet.google.com/...">
            </div>
            <div class="form-group">
                <label>Recording URL (Optional)</label>
                <input type="url" name="recording_url" class="form-control" placeholder="https://youtube.com/...">
            </div>
            <div class="form-group">
                <label>Start Time</label>
                <input type="datetime-local" name="start_time" class="form-control" required>
            </div>
            <div class="form-group">
                <label>End Time (Optional)</label>
                <input type="datetime-local" name="end_time" class="form-control">
            </div>
            <div class="modal-actions">
                <button type="submit" class="btn-primary">Save Session</button>
                <button type="button" class="btn-secondary" onclick="closeSessionModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- NEW: Edit Session Modal -->
<div class="modal" id="editSessionModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Session</h3>
            <button class="close-btn" onclick="closeEditSessionModal()">&times;</button>
        </div>
        <form method="POST" action="" id="editSessionForm">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Session Title</label>
                <input type="text" name="title" id="edit_title" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Meeting URL</label>
                <input type="url" name="meeting_url" id="edit_meeting_url" class="form-control" placeholder="https://meet.google.com/...">
            </div>
            <div class="form-group">
                <label>Recording URL</label>
                <input type="url" name="recording_url" id="edit_recording_url" class="form-control" placeholder="https://youtube.com/...">
            </div>
            <div class="form-group">
                <label>Start Time</label>
                <input type="datetime-local" name="start_time" id="edit_start_time" class="form-control" required>
            </div>
            <div class="form-group">
                <label>End Time (Optional)</label>
                <input type="datetime-local" name="end_time" id="edit_end_time" class="form-control">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" id="edit_status" class="form-control">
                    <option value="scheduled">Scheduled</option>
                    <option value="ongoing">Ongoing</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="modal-actions">
                <button type="submit" class="btn-primary">Update Session</button>
                <button type="button" class="btn-secondary" onclick="closeEditSessionModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Session-Specific Attendance Modal -->
<div class="modal" id="sessionAttendanceModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Mark Attendance for: <span id="attendanceSessionTitle"></span></h3>
            <button class="close-btn" onclick="closeSessionAttendanceModal()">&times;</button>
        </div>
        <form id="sessionAttendanceForm">
            @csrf
            <input type="hidden" id="attendanceSessionId" name="session_id">
            
            <div class="form-group">
                <label>Select Students to Mark as Attended</label>
                <div class="student-checkboxes" id="attendanceStudentList">
                    @foreach($enrollments as $enrollment)
                        <label>
                            <input type="checkbox" class="attendance-checkbox" value="{{ $enrollment->user_id }}">
                            {{ $enrollment->user->name }} ({{ $enrollment->user->email }})
                        </label>
                    @endforeach
                </div>
            </div>
            
            <div class="form-group">
                <label>Additional Notes (Optional)</label>
                <textarea name="notes" class="form-control" rows="2" placeholder="Any notes about attendance..."></textarea>
            </div>
            
            <div class="modal-actions">
                <button type="submit" class="btn-primary">Mark Attendance</button>
                <button type="button" class="btn-secondary" onclick="closeSessionAttendanceModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Bulk Attendance Modal -->
<div class="modal" id="bulkAttendanceModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Mark Attendance for Selected Students</h3>
            <button class="close-btn" onclick="closeBulkAttendanceModal()">&times;</button>
        </div>
        <form id="bulkAttendanceForm">
            @csrf
            <div class="form-group">
                <label>Select Session</label>
                <select id="bulkAttendanceSessionId" class="form-control" required>
                    <option value="">Choose a session...</option>
                    @foreach($sessions as $session)
                        <option value="{{ $session->id }}">
                            {{ $session->title }} - {{ \Carbon\Carbon::parse($session->start_time)->format('M d, h:i A') }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label>Notes (Optional)</label>
                <textarea name="notes" class="form-control" rows="2" placeholder="Any notes about attendance..."></textarea>
            </div>
            
            <div class="modal-actions">
                <button type="submit" class="btn-primary">Mark Attendance</button>
                <button type="button" class="btn-secondary" onclick="closeBulkAttendanceModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Progress Modal -->
<div class="modal" id="progressModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Update Progress for Selected Students</h3>
            <button class="close-btn" onclick="closeProgressModal()">&times;</button>
        </div>
        <div class="form-group">
            <label>Set Progress Percentage</label>
            <input type="range" id="bulkProgress" min="0" max="100" value="0" class="form-control" oninput="updateProgressValue(this.value)">
            <div style="text-align: center; margin-top: 10px; font-size: 18px; font-weight: 600;">
                <span id="progressDisplay">0</span>%
            </div>
        </div>
        <div class="modal-actions">
            <button class="btn-primary" onclick="submitBulkProgress()">Update Progress</button>
            <button class="btn-secondary" onclick="closeProgressModal()">Cancel</button>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // DOM Elements
    let selectedStudents = [];
    let sessionsData = @json($sessions);

    console.log('Sessions data loaded:', sessionsData);

    document.addEventListener('DOMContentLoaded', function() {
        // Progress bar animations
        document.querySelectorAll('.progress-bar-fill').forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.transition = 'width 1s ease';
                bar.style.width = width;
            }, 300);
        });

        // Filter form submit
        const filterForm = document.getElementById('filterForm');
        if (filterForm) {
            filterForm.addEventListener('submit', function() {
                document.getElementById('loadingOverlay').style.display = 'flex';
            });
        }

        // Search debounce
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            let timeout;
            searchInput.addEventListener('keyup', function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    if (this.value.length >= 3 || this.value.length === 0) {
                        filterForm.submit();
                    }
                }, 500);
            });
        }

        // Checkbox listeners
        document.querySelectorAll('.student-checkbox').forEach(cb => {
            cb.addEventListener('change', updateSelectedStudents);
        });

        // Select all header
        const selectAllHeader = document.getElementById('selectAllHeader');
        if (selectAllHeader) {
            selectAllHeader.addEventListener('change', function() {
                const selectAll = document.getElementById('selectAll');
                if (selectAll) selectAll.checked = this.checked;
                toggleSelectAll();
            });
        }
    });

    // Tab Switching
    function switchTab(tabName) {
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.getElementById(`tab${tabName.charAt(0).toUpperCase() + tabName.slice(1)}`).classList.add('active');
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        document.getElementById(`tab${tabName.charAt(0).toUpperCase() + tabName.slice(1)}Content`).classList.add('active');
    }

    // Select All
    function toggleSelectAll() {
        const selectAll = document.getElementById('selectAll');
        const selectAllHeader = document.getElementById('selectAllHeader');
        const checkboxes = document.querySelectorAll('.student-checkbox');
        const isChecked = selectAll ? selectAll.checked : (selectAllHeader ? selectAllHeader.checked : false);
        checkboxes.forEach(cb => cb.checked = isChecked);
        if (selectAllHeader) selectAllHeader.checked = isChecked;
        if (selectAll) selectAll.checked = isChecked;
        updateSelectedStudents();
    }

    function updateSelectedStudents() {
        selectedStudents = [];
        document.querySelectorAll('.student-checkbox:checked').forEach(cb => {
            selectedStudents.push(cb.value);
        });
        const checkboxes = document.querySelectorAll('.student-checkbox');
        const checkedCount = document.querySelectorAll('.student-checkbox:checked').length;
        const allChecked = checkedCount === checkboxes.length && checkboxes.length > 0;
        const selectAll = document.getElementById('selectAll');
        const selectAllHeader = document.getElementById('selectAllHeader');
        if (selectAll) selectAll.checked = allChecked;
        if (selectAllHeader) selectAllHeader.checked = allChecked;
    }

    // Bulk Actions
    function applyBulkAction() {
        const action = document.getElementById('bulkAction').value;
        updateSelectedStudents();
        if (selectedStudents.length === 0) {
            Swal.fire({ 
                icon: 'warning', 
                title: 'No Students Selected', 
                text: 'Please select at least one student', 
                confirmButtonColor: '#2d3e50' 
            });
            return;
        }
        switch (action) {
            case 'progress': openProgressModal(); break;
            case 'attendance': openBulkAttendanceModal(); break;
            case 'message': openBulkMessageModal(); break;
            default: 
                Swal.fire({ 
                    icon: 'warning', 
                    title: 'Select Action', 
                    text: 'Please select an action from the dropdown', 
                    confirmButtonColor: '#2d3e50' 
                });
        }
    }

    // View Progress
    function viewProgress(enrollmentId) {
        window.location.href = `/instructor/student/${enrollmentId}/progress`;
    }

    // Single Message
    function sendMessage(userId, userName) {
        document.getElementById('studentName').textContent = userName;
        document.getElementById('receiverId').value = userId;
        document.getElementById('messageModal').style.display = 'flex';
        document.getElementById('successMessage').style.display = 'none';
        document.getElementById('messageForm').reset();
    }

    function closeMessageModal() {
        document.getElementById('messageModal').style.display = 'none';
    }

    document.getElementById('messageForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const sendBtn = document.getElementById('sendBtn');
        const originalText = sendBtn.innerHTML;
        sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        sendBtn.disabled = true;
        const messageText = document.getElementById('messageText').value.trim();
        if (!messageText) {
            Swal.fire({ 
                icon: 'warning', 
                title: 'Empty Message', 
                text: 'Please enter a message', 
                confirmButtonColor: '#2d3e50' 
            });
            sendBtn.innerHTML = originalText;
            sendBtn.disabled = false;
            return;
        }
        fetch('/messages/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                receiver_id: document.getElementById('receiverId').value,
                message: messageText,
                course_id: '{{ $course->id }}'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('successMessage').style.display = 'block';
                document.getElementById('messageForm').reset();
                setTimeout(() => document.getElementById('successMessage').style.display = 'none', 3000);
                setTimeout(() => {
                    closeMessageModal();
                    Swal.fire({ 
                        icon: 'success', 
                        title: 'Message Sent!', 
                        text: 'Message delivered', 
                        timer: 2000, 
                        showConfirmButton: false 
                    });
                }, 1500);
            } else {
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Error', 
                    text: data.message || 'Failed to send', 
                    confirmButtonColor: '#2d3e50' 
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({ 
                icon: 'error', 
                title: 'Error', 
                text: 'Something went wrong', 
                confirmButtonColor: '#2d3e50' 
            });
        })
        .finally(() => {
            sendBtn.innerHTML = originalText;
            sendBtn.disabled = false;
        });
    });

    // Bulk Message
    function openBulkMessageModal() {
        document.getElementById('bulkMessageModal').style.display = 'flex';
    }

    function closeBulkMessageModal() {
        document.getElementById('bulkMessageModal').style.display = 'none';
    }

    function sendBulkMessage() {
        const message = document.getElementById('bulkMessage').value.trim();

        if (!message) {
            Swal.fire('Error', 'Please enter a message', 'error');
            return;
        }

        document.getElementById('loadingOverlay').style.display = 'flex';

        fetch('{{ route("instructor.course.bulk.message", ["course" => $course->id]) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                student_ids: selectedStudents,
                message: message
            })
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
                    title: 'Success!',
                    text: data.message || `Message sent to ${selectedStudents.length} students`,
                    timer: 3000,
                    showConfirmButton: false
                });
                closeBulkMessageModal();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to send',
                    confirmButtonColor: '#2d3e50'
                });
            }
        })
        .catch(error => {
            document.getElementById('loadingOverlay').style.display = 'none';
            console.error('Error:', error);
            let errorMessage = 'Something went wrong';
            if (error.message) errorMessage = error.message;
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage,
                confirmButtonColor: '#2d3e50'
            });
        });
    }

    // Session Functions
    function openCreateSessionModal() {
        document.getElementById('sessionModal').style.display = 'flex';
    }

    function closeSessionModal() {
        document.getElementById('sessionModal').style.display = 'none';
    }

    // Edit Session Functions
    function openEditSessionModal(sessionId) {
        const session = sessionsData.find(s => s.id === sessionId);
        if (session) {
            document.getElementById('edit_title').value = session.title;
            document.getElementById('edit_description').value = session.description || '';
            document.getElementById('edit_meeting_url').value = session.meeting_url || '';
            document.getElementById('edit_recording_url').value = session.recording_url || '';
            document.getElementById('edit_start_time').value = session.start_time.replace(' ', 'T').substring(0, 16);
            document.getElementById('edit_end_time').value = session.end_time ? session.end_time.replace(' ', 'T').substring(0, 16) : '';
            document.getElementById('edit_status').value = session.status;
            
            const form = document.getElementById('editSessionForm');
            form.action = `/instructor/course/{{ $course->id }}/sessions/${sessionId}`;
            
            document.getElementById('editSessionModal').style.display = 'flex';
        }
    }

    function closeEditSessionModal() {
        document.getElementById('editSessionModal').style.display = 'none';
    }

    // Delete Session
    function deleteSession(sessionId, sessionTitle) {
        console.log('Deleting Session ID:', sessionId);

        if (!sessionId) {
            Swal.fire('Error', 'Session ID is missing', 'error');
            return;
        }

        Swal.fire({
            title: 'Delete Session?',
            html: `Are you sure you want to delete <strong>"${sessionTitle}"</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading overlay
                document.getElementById('loadingOverlay').style.display = 'flex';

                // Build the URL
                const url = `/instructor/course/{{ $course->id }}/sessions/${sessionId}`;
                console.log('Delete URL:', url);

                // Send DELETE request
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);

                    // Check if response is OK
                    if (!response.ok) {
                        return response.json().then(errData => {
                            throw new Error(errData.message || 'Server error');
                        });
                    }

                    // Parse JSON response
                    return response.json();
                })
                .then(data => {
                    console.log('Success data:', data);

                    // Hide loading overlay
                    document.getElementById('loadingOverlay').style.display = 'none';

                    if (data.success) {
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: data.message || 'Session has been deleted successfully.',
                            timer: 2000,
                            showConfirmButton: false,
                            willClose: () => {
                                // Reload the page after success
                                location.reload();
                            }
                        });
                    } else {
                        // Show error message
                        Swal.fire('Error', data.message || 'Failed to delete session', 'error');
                    }
                })
                .catch(error => {
                    // Hide loading overlay
                    document.getElementById('loadingOverlay').style.display = 'none';

                    console.error('Delete error:', error);

                    // Show error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Something went wrong while deleting the session.',
                        confirmButtonColor: '#2d3e50'
                    });
                });
            }
        });
    }

    function shareMeetingLink(sessionId) {
        document.getElementById('loadingOverlay').style.display = 'flex';
        fetch(`/instructor/course/{{ $course->id }}/sessions/${sessionId}/share-meeting`, {
            method: 'POST',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                'Content-Type': 'application/json', 
                'Accept': 'application/json' 
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('loadingOverlay').style.display = 'none';
            if (data.success) {
                Swal.fire('Success', data.message, 'success');
            } else {
                Swal.fire('Error', data.message || 'Failed to share', 'error');
            }
        })
        .catch(error => {
            document.getElementById('loadingOverlay').style.display = 'none';
            Swal.fire('Error', 'Something went wrong', 'error');
        });
    }

    function shareRecording(sessionId) {
        document.getElementById('loadingOverlay').style.display = 'flex';
        fetch(`/instructor/course/{{ $course->id }}/sessions/${sessionId}/share-recording`, {
            method: 'POST',
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}', 
                'Content-Type': 'application/json', 
                'Accept': 'application/json' 
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('loadingOverlay').style.display = 'none';
            if (data.success) {
                Swal.fire('Success', data.message, 'success');
            } else {
                Swal.fire('Error', data.message || 'Failed to share', 'error');
            }
        })
        .catch(error => {
            document.getElementById('loadingOverlay').style.display = 'none';
            Swal.fire('Error', 'Something went wrong', 'error');
        });
    }

    // Session-Specific Attendance Modal
    function openSessionAttendanceModal(sessionId, sessionTitle) {
        document.getElementById('attendanceSessionId').value = sessionId;
        document.getElementById('attendanceSessionTitle').textContent = sessionTitle;
        // Uncheck all checkboxes
        document.querySelectorAll('#attendanceStudentList input').forEach(cb => cb.checked = false);
        document.getElementById('sessionAttendanceModal').style.display = 'flex';
    }

    function closeSessionAttendanceModal() {
        document.getElementById('sessionAttendanceModal').style.display = 'none';
    }

    document.getElementById('sessionAttendanceForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const sessionId = document.getElementById('attendanceSessionId').value;
        const studentIds = [];
        document.querySelectorAll('#attendanceStudentList input:checked').forEach(cb => studentIds.push(cb.value));
        const notes = document.querySelector('textarea[name="notes"]').value;
        
        if (studentIds.length === 0) {
            Swal.fire({ 
                icon: 'warning', 
                title: 'No Students Selected', 
                text: 'Please select at least one student', 
                confirmButtonColor: '#2d3e50' 
            });
            return;
        }
        
        document.getElementById('loadingOverlay').style.display = 'flex';
        
        fetch(`/instructor/course/{{ $course->id }}/bulk/attendance`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ 
                student_ids: studentIds, 
                session_id: sessionId,
                notes: notes
            })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('loadingOverlay').style.display = 'none';
            if (data.success) {
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Success', 
                    text: data.message, 
                    timer: 2000, 
                    showConfirmButton: false 
                });
                closeSessionAttendanceModal();
            } else {
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Error', 
                    text: data.message || 'Failed to mark attendance', 
                    confirmButtonColor: '#2d3e50' 
                });
            }
        })
        .catch(error => {
            document.getElementById('loadingOverlay').style.display = 'none';
            Swal.fire({ 
                icon: 'error', 
                title: 'Error', 
                text: 'Something went wrong', 
                confirmButtonColor: '#2d3e50' 
            });
        });
    });

    // Bulk Attendance Modal
    function openBulkAttendanceModal() {
        document.getElementById('bulkAttendanceModal').style.display = 'flex';
    }

    function closeBulkAttendanceModal() {
        document.getElementById('bulkAttendanceModal').style.display = 'none';
    }

    document.getElementById('bulkAttendanceForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const sessionId = document.getElementById('bulkAttendanceSessionId').value;
        const notes = document.querySelector('#bulkAttendanceForm textarea[name="notes"]').value;
        
        if (!sessionId) {
            Swal.fire({ 
                icon: 'warning', 
                title: 'No Session Selected', 
                text: 'Please select a session', 
                confirmButtonColor: '#2d3e50' 
            });
            return;
        }
        
        if (selectedStudents.length === 0) {
            Swal.fire({ 
                icon: 'warning', 
                title: 'No Students Selected', 
                text: 'Please select students first', 
                confirmButtonColor: '#2d3e50' 
            });
            return;
        }
        
        document.getElementById('loadingOverlay').style.display = 'flex';
        
        fetch(`/instructor/course/{{ $course->id }}/bulk/attendance`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ 
                student_ids: selectedStudents, 
                session_id: sessionId,
                notes: notes
            })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('loadingOverlay').style.display = 'none';
            if (data.success) {
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Success', 
                    text: data.message, 
                    timer: 2000, 
                    showConfirmButton: false 
                });
                closeBulkAttendanceModal();
            } else {
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Error', 
                    text: data.message || 'Failed to mark attendance', 
                    confirmButtonColor: '#2d3e50' 
                });
            }
        })
        .catch(error => {
            document.getElementById('loadingOverlay').style.display = 'none';
            Swal.fire({ 
                icon: 'error', 
                title: 'Error', 
                text: 'Something went wrong', 
                confirmButtonColor: '#2d3e50' 
            });
        });
    });

    // Progress Functions
    function openProgressModal() {
        document.getElementById('progressModal').style.display = 'flex';
    }

    function closeProgressModal() {
        document.getElementById('progressModal').style.display = 'none';
    }

    function updateProgressValue(value) {
        document.getElementById('progressDisplay').textContent = value;
    }

    function submitBulkProgress() {
        const progress = document.getElementById('bulkProgress').value;
        updateSelectedStudents();
        if (selectedStudents.length === 0) {
            Swal.fire({ 
                icon: 'warning', 
                title: 'No Students Selected', 
                text: 'Please select at least one student', 
                confirmButtonColor: '#2d3e50' 
            });
            return;
        }
        document.getElementById('loadingOverlay').style.display = 'flex';
        fetch('{{ route("instructor.course.bulk.progress", ["course" => $course->id]) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ 
                student_ids: selectedStudents, 
                progress: progress
            })
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
                    title: 'Success', 
                    text: data.message, 
                    timer: 2000, 
                    showConfirmButton: false 
                });
                closeProgressModal();
                setTimeout(() => location.reload(), 1500);
            } else {
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Error', 
                    text: data.message || 'Failed to update progress', 
                    confirmButtonColor: '#2d3e50' 
                });
            }
        })
        .catch(error => {
            document.getElementById('loadingOverlay').style.display = 'none';
            console.error('Error:', error);
            let errorMessage = 'Something went wrong';
            if (error.message) errorMessage = error.message;
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage,
                confirmButtonColor: '#2d3e50'
            });
        });
    }

    // Material Functions
    function shareMaterial(materialId) {
        Swal.fire({
            title: 'Share Material',
            text: 'Add an optional message for students:',
            input: 'textarea',
            inputPlaceholder: 'Optional message...',
            showCancelButton: true,
            confirmButtonText: 'Share',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#2d3e50',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('loadingOverlay').style.display = 'flex';
                fetch('{{ route("instructor.course.bulk.share-material", ["course" => $course->id]) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ 
                        material_id: materialId, 
                        message: result.value 
                    })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    if (data.success) {
                        Swal.fire({ 
                            icon: 'success', 
                            title: 'Success', 
                            text: data.message, 
                            timer: 2000, 
                            showConfirmButton: false 
                        });
                    } else {
                        Swal.fire({ 
                            icon: 'error', 
                            title: 'Error', 
                            text: data.message || 'Failed to share', 
                            confirmButtonColor: '#2d3e50' 
                        });
                    }
                })
                .catch(error => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    Swal.fire({ 
                        icon: 'error', 
                        title: 'Error', 
                        text: 'Something went wrong', 
                        confirmButtonColor: '#2d3e50' 
                    });
                });
            }
        });
    }

    function viewMaterial(materialId) {
        window.open(`/instructor/course/{{ $course->id }}/materials/${materialId}`, '_blank');
    }

    // Assignment Functions
    function viewSubmissions(assignmentId) {
        window.location.href = `/instructor/course/{{ $course->id }}/assignments/${assignmentId}/submissions`;
    }

    // Generate Certificate
    function generateCertificate(enrollmentId, progress, studentName) {
        if (progress < 100) {
            Swal.fire({
                icon: 'info',
                title: 'Course Not Completed',
                text: `${studentName} has only completed ${progress}%. Certificates require 100%.`,
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
                document.getElementById('loadingOverlay').style.display = 'flex';
                window.open(`/instructor/certificate/${enrollmentId}`, '_blank');
                setTimeout(() => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    Swal.fire({ 
                        icon: 'success', 
                        title: 'Certificate Generated!', 
                        timer: 2000, 
                        showConfirmButton: false 
                    });
                }, 1000);
            }
        });
    }

    // Export PDF
    function exportToPDF() {
        document.getElementById('loadingOverlay').style.display = 'flex';
        const url = new URL(`{{ route('instructor.course-students.report', $course->id) }}`, window.location.origin);
        url.searchParams.append('export', 'pdf');
        window.open(url.toString(), '_blank');
        setTimeout(() => document.getElementById('loadingOverlay').style.display = 'none', 1500);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Check course status on page load
        @if(auth()->user()->hasRole('instructor') && !$course->is_active)
            Swal.fire({
                icon: 'warning',
                title: 'Course Inactive',
                html: `<strong>"{{ $course->title }}"</strong> is currently inactive.<br><br>
                       You can view content but cannot make changes.<br>
                       Please contact an administrator to activate it.`,
                confirmButtonColor: '#2d3e50',
                confirmButtonText: 'I Understand'
            });
        @endif
    });
</script>
@endsection