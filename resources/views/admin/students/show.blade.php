@extends('layouts.app')

@section('title', $student->name . ' - Student Details')
@section('body-class', 'admin-page')

@section('styles')
<style>
    /* Keep all your existing styles exactly as they are */
    .student-detail-container {
        padding: 20px;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Back Button */
    .back-button {
        margin-bottom: 20px;
    }

    .back-button a {
        color: #64748b;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
        width: fit-content;
    }

    .back-button a:hover {
        color: #2D3E50;
        transform: translateX(-5px);
    }

    /* Student Header Card */
    .student-header-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        border: 1px solid #e2e8f0;
        margin-bottom: 25px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        position: relative;
        overflow: hidden;
    }

    .student-header-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #2D3E50, #3182ce);
    }

    .student-profile-row {
        display: flex;
        gap: 30px;
        align-items: center;
    }

    @media (max-width: 768px) {
        .student-profile-row {
            flex-direction: column;
            text-align: center;
        }
    }

    .avatar-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
        flex-shrink: 0;
    }

    .avatar-large {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2D3E50, #3182ce);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: bold;
        border: 4px solid white;
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
    }

    .avatar-large img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .avatar-badge {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: #10b981;
        color: white;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid white;
    }

    .student-info-wrapper {
        flex: 1;
    }

    .student-name-section {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .student-name {
        font-size: 32px;
        font-weight: 700;
        color: #2D3E50;
        margin: 0;
    }

    .student-id-badge {
        background: #f1f5f9;
        color: #64748b;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .student-contact-info {
        display: flex;
        gap: 25px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        font-size: 14px;
    }

    .contact-item i {
        width: 16px;
        color: #94a3b8;
    }

    .student-badges {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-verified {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-unverified {
        background: #fef3c7;
        color: #d97706;
    }

    .badge-role {
        background: #e0f2fe;
        color: #0369a1;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 12px;
        margin-top: 20px;
        flex-wrap: wrap;
    }

    .btn-action-large {
        padding: 12px 24px;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .btn-edit {
        background: #3182ce;
        color: white;
    }

    .btn-edit:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(49, 130, 206, 0.3);
    }

    .btn-enroll {
        background: #2D3E50;
        color: white;
    }

    .btn-enroll:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.3);
    }

    .btn-message {
        background: white;
        color: #2D3E50;
        border: 1px solid #e2e8f0;
    }

    .btn-message:hover {
        background: #f8fafc;
        border-color: #2D3E50;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: #fee2e2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .btn-delete:hover {
        background: #dc2626;
        color: white;
        border-color: #dc2626;
        transform: translateY(-2px);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-top: 30px;
    }

    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .stat-card {
        background: #f8fafc;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-icon.blue {
        background: #dbeafe;
        color: #1e40af;
    }

    .stat-icon.green {
        background: #dcfce7;
        color: #15803d;
    }

    .stat-icon.purple {
        background: #f3e8ff;
        color: #7e22ce;
    }

    .stat-icon.orange {
        background: #fed7aa;
        color: #9a3412;
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        display: block;
        font-size: 24px;
        font-weight: 700;
        color: #2D3E50;
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    @keyframes pulse {
        0% { opacity: 0.6; transform: scale(1); }
        50% { opacity: 1; transform: scale(1.1); }
        100% { opacity: 0.6; transform: scale(1); }
    }

    /* Tabs */
    .tabs-container {
        background: white;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        margin-bottom: 25px;
    }

    .tabs {
        display: flex;
        gap: 5px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
        padding: 0 10px;
        overflow-x: auto;
    }

    .tab {
        padding: 16px 24px;
        background: none;
        border: none;
        color: #64748b;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        position: relative;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .tab:hover {
        color: #2D3E50;
    }

    .tab.active {
        color: #2D3E50;
    }

    .tab.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background: #2D3E50;
        border-radius: 2px 2px 0 0;
    }

    .tab-content {
        display: none;
        padding: 25px;
    }

    .tab-content.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Notes Styling */
    .notes-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .note-item {
        display: flex;
        gap: 15px;
        padding: 20px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        position: relative;
    }

    .note-item:hover {
        background: white;
        border-color: #cbd5e0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .note-avatar {
        flex-shrink: 0;
    }

    .note-avatar-initials {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2D3E50, #3182ce);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
    }

    .note-content-wrapper {
        flex: 1;
    }

    .note-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .note-author {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .note-author strong {
        color: #2D3E50;
        font-size: 15px;
    }

    .note-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .note-badge.admin {
        background: #dbeafe;
        color: #1e40af;
    }

    .note-badge.instructor {
        background: #dcfce7;
        color: #065f46;
    }

    .note-badge.private {
        background: #fef3c7;
        color: #d97706;
    }

    .note-meta {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .note-date {
        font-size: 12px;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .note-actions {
        display: flex;
        gap: 8px;
    }

    .note-action-btn {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        background: white;
        color: #64748b;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .note-action-btn:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        transform: translateY(-2px);
    }

    .note-action-btn.edit-note:hover {
        background: #dbeafe;
        color: #1e40af;
        border-color: #1e40af;
    }

    .note-action-btn.delete-note:hover {
        background: #fee2e2;
        color: #dc2626;
        border-color: #dc2626;
    }

    .note-content {
        color: #4a5568;
        font-size: 14px;
        line-height: 1.6;
        white-space: pre-wrap;
    }

    /* Note Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background: white;
        width: 600px;
        max-width: 90%;
        border-radius: 16px;
        margin: 0 auto;
        padding: 25px;
        position: relative;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .modal-title {
        color: #2D3E50;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: #64748b;
        text-decoration: none;
    }

    .modal-close:hover {
        color: #2D3E50;
    }

    .modal-body {
        margin-bottom: 25px;
    }

    .modal-footer {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .note-textarea {
        width: 100%;
        padding: 15px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        min-height: 150px;
        resize: vertical;
        transition: all 0.3s ease;
    }

    .note-textarea:focus {
        border-color: #2D3E50;
        outline: none;
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    .note-private-checkbox {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 15px;
        padding: 10px 15px;
        background: #f8fafc;
        border-radius: 8px;
    }

    .note-private-checkbox input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .note-private-checkbox label {
        font-size: 14px;
        color: #64748b;
        cursor: pointer;
    }

    /* Content Cards */
    .content-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        margin-bottom: 25px;
        overflow: hidden;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .card-title {
        font-size: 18px;
        font-weight: 600;
        color: #2D3E50;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .card-body {
        padding: 25px;
    }

    /* Enrollment Table */
    .table-responsive {
        overflow-x: auto;
    }

    .enrollment-table {
        width: 100%;
        border-collapse: collapse;
    }

    .enrollment-table th {
        text-align: left;
        padding: 15px 20px;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .enrollment-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .enrollment-table tr:hover td {
        background: #f8fafc;
    }

    .course-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .course-icon {
        width: 44px;
        height: 44px;
        background: linear-gradient(135deg, #2D3E50, #3182ce);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
    }

    .course-info h4 {
        font-size: 15px;
        font-weight: 600;
        color: #2D3E50;
        margin-bottom: 4px;
    }

    .course-info p {
        font-size: 12px;
        color: #64748b;
        margin: 0;
    }

    .progress-wrapper {
        min-width: 140px;
    }

    .progress-percentage {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: #64748b;
        margin-bottom: 6px;
    }

    .progress-bar-container {
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #2D3E50, #3182ce);
        border-radius: 4px;
        transition: width 0.5s ease;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-active {
        background: #dcfce7;
        color: #15803d;
    }

    .status-completed {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-pending {
        background: #fef3c7;
        color: #d97706;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #dc2626;
    }

    /* Learning Path Card */
    .learning-path-card {
        background: linear-gradient(135deg, #f0f9ff, #e6f0fa);
        border: 1px solid #dbeafe;
        border-radius: 16px;
        padding: 25px;
        position: relative;
        overflow: hidden;
    }

    .learning-path-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 6px;
        height: 100%;
        background: linear-gradient(180deg, #2D3E50, #3182ce);
    }

    .path-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .path-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e40af;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .ai-badge {
        background: white;
        color: #1e40af;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        border: 1px solid #dbeafe;
    }

    .path-progress {
        margin-bottom: 25px;
    }

    .path-progress-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        color: #64748b;
        font-size: 14px;
    }

    .path-items {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .path-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        background: white;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .path-item:hover {
        border-color: #2D3E50;
        transform: translateX(5px);
    }

    .item-status-indicator {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }

    .item-status-indicator.completed {
        background: #10b981;
        color: white;
    }

    .item-status-indicator.active {
        background: #3b82f6;
        color: white;
    }

    .item-status-indicator.locked {
        background: #e2e8f0;
        color: #94a3b8;
    }

    .item-content {
        flex: 1;
    }

    .item-title {
        font-weight: 600;
        color: #2D3E50;
        margin-bottom: 2px;
    }

    .item-meta {
        font-size: 11px;
        color: #64748b;
    }

    /* Activity Timeline */
    .activity-timeline {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .activity-item {
        display: flex;
        gap: 15px;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .activity-icon.blue {
        background: #dbeafe;
        color: #1e40af;
    }

    .activity-icon.green {
        background: #dcfce7;
        color: #15803d;
    }

    .activity-icon.purple {
        background: #f3e8ff;
        color: #7e22ce;
    }

    .activity-content {
        flex: 1;
    }

    .activity-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }

    .activity-title {
        font-weight: 600;
        color: #2D3E50;
    }

    .activity-time {
        font-size: 12px;
        color: #94a3b8;
    }

    .activity-description {
        font-size: 14px;
        color: #64748b;
        margin: 0;
    }

    /* Course Cards Grid */
    .course-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .recommended-course-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px;
        transition: all 0.3s ease;
    }

    .recommended-course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        border-color: #2D3E50;
    }

    .course-category {
        display: inline-block;
        padding: 4px 12px;
        background: #e0f2fe;
        color: #0369a1;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .course-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #2D3E50;
        margin-bottom: 8px;
        line-height: 1.4;
    }

    .course-card-price {
        font-size: 18px;
        font-weight: 700;
        color: #2D3E50;
        margin: 15px 0;
    }

    .btn-recommend {
        width: 100%;
        padding: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        color: #2D3E50;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-recommend:hover {
        background: #2D3E50;
        color: white;
        border-color: #2D3E50;
    }

    /* Empty States */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    .empty-state i {
        font-size: 48px;
        color: #cbd5e0;
        margin-bottom: 15px;
    }

    .empty-state h4 {
        color: #64748b;
        margin-bottom: 8px;
        font-size: 18px;
    }

    .empty-state p {
        color: #94a3b8;
        margin-bottom: 20px;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background: white;
        width: 500px;
        max-width: 90%;
        border-radius: 16px;
        margin: 0 auto;
        padding: 25px;
        position: relative;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-control:focus {
        outline: none;
        border-color: #2D3E50 !important;
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    .btn-action-large:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .student-detail-container {
            padding: 15px;
        }

        .student-header-card {
            padding: 20px;
        }

        .student-name {
            font-size: 24px;
        }

        .student-contact-info {
            gap: 15px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-action-large {
            width: 100%;
        }

        .tabs {
            padding: 0;
        }

        .tab {
            padding: 12px 16px;
            font-size: 13px;
        }

        .tab i {
            display: none;
        }

        .card-header {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }

        .stats-grid {
            margin-top: 20px;
        }
    }

    /* Priority colors */
    .priority-high {
        color: #d97706;
    }
    
    .priority-urgent {
        color: #dc2626;
    }
</style>
@endsection

@section('content')
<div class="student-detail-container">
    
    <!-- Back Button -->
    <div class="back-button">
        <a href="{{ route('admin.students.index') }}">
            <i class="fas fa-arrow-left"></i>
            Back to Students
        </a>
    </div>

    <!-- Student Header Card -->
    <div class="student-header-card">
        <div class="student-profile-row">
            <!-- Avatar -->
            <div class="avatar-wrapper">
                @if($student->avatar && \Storage::disk('public')->exists($student->avatar))
                    <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}" class="avatar-large">
                @else
                    <div class="avatar-large">
                        {{ $student->initials }}
                    </div>
                @endif
                @if($student->email_verified_at)
                    <div class="avatar-badge" title="Email Verified">
                        <i class="fas fa-check"></i>
                    </div>
                @endif
            </div>

            <!-- Student Info -->
            <div class="student-info-wrapper">
                <div class="student-name-section">
                    <h1 class="student-name">{{ $student->name }}</h1>
                    <span class="student-id-badge">
                        ID: STU{{ str_pad($student->id, 5, '0', STR_PAD_LEFT) }}
                    </span>
                </div>

                <div class="student-contact-info">
                    <span class="contact-item">
                        <i class="fas fa-envelope"></i>
                        {{ $student->email }}
                    </span>
                    <span class="contact-item">
                        <i class="fas fa-phone"></i>
                        {{ $student->phone ?? 'No phone provided' }}
                    </span>
                    <span class="contact-item">
                        <i class="fas fa-calendar-alt"></i>
                        Joined {{ $student->created_at->format('M d, Y') }}
                    </span>
                    @if($student->company)
                    <span class="contact-item">
                        <i class="fas fa-building"></i>
                        {{ $student->company }}
                    </span>
                    @endif
                </div>

                <div class="student-badges">
                    @if($student->email_verified_at)
                        <span class="badge badge-verified">
                            <i class="fas fa-check-circle"></i>
                            Email Verified
                        </span>
                    @else
                        <span class="badge badge-unverified">
                            <i class="fas fa-clock"></i>
                            Email Unverified
                        </span>
                    @endif
                    
                    @foreach($student->getRoleNames() as $role)
                        <span class="badge badge-role">
                            <i class="fas fa-user-tag"></i>
                            {{ ucfirst($role) }}
                        </span>
                    @endforeach
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('admin.students.edit', $student) }}" class="btn-action-large btn-edit">
                        <i class="fas fa-edit"></i>
                        Edit Profile
                    </a>
                    <a href="{{ route('admin.students.enrollments', $student) }}" class="btn-action-large btn-enroll">
                        <i class="fas fa-book-open"></i>
                        Manage Enrollments
                    </a>
                    <button class="btn-action-large btn-message" onclick="openMessageModal()">
                        <i class="fas fa-envelope"></i>
                        Send Message
                    </button>
                    <button class="btn-action-large btn-delete" onclick="confirmDeleteStudent({{ $student->id }}, '{{ addslashes($student->name) }}')">
                        <i class="fas fa-trash"></i>
                        Delete Student
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-value">{{ $stats['total_enrollments'] }}</span>
                    <span class="stat-label">Total Enrollments</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon green">
                    <i class="fas fa-play-circle"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-value">{{ $stats['active_enrollments'] }}</span>
                    <span class="stat-label">Active Courses</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-trophy"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-value">{{ $stats['completed_courses'] }}</span>
                    <span class="stat-label">Completed</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-value">${{ number_format($stats['total_spent'], 2) }}</span>
                    <span class="stat-label">Total Spent</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="tabs-container">
        <div class="tabs">
            <button class="tab active" data-tab="enrollments">
                <i class="fas fa-book-open"></i>
                Enrollments
                @if($stats['total_enrollments'] > 0)
                    <span style="background: #2D3E50; color: white; padding: 2px 8px; border-radius: 12px; font-size: 11px; margin-left: 5px;">
                        {{ $stats['total_enrollments'] }}
                    </span>
                @endif
            </button>
            <button class="tab" data-tab="learning-path">
                <i class="fas fa-route"></i>
                Learning Path
                @if($activeLearningPath)
                    <span style="background: #10b981; color: white; padding: 2px 8px; border-radius: 12px; font-size: 11px; margin-left: 5px;">
                        {{ $activeLearningPath->progress_percentage }}%
                    </span>
                @endif
            </button>
            <button class="tab" data-tab="activity">
                <i class="fas fa-history"></i>
                Activity
            </button>
            <button class="tab" data-tab="recommended">
                <i class="fas fa-thumbs-up"></i>
                Recommended
            </button>
            <button class="tab" data-tab="wishlist">
                <i class="fas fa-heart"></i>
                Wishlist
                @if($student->wishlists()->count() > 0)
                    <span style="background: #ef4444; color: white; padding: 2px 8px; border-radius: 12px; font-size: 11px; margin-left: 5px;">
                        {{ $student->wishlists()->count() }}
                    </span>
                @endif
            </button>
            <button class="tab" data-tab="notes">
                <i class="fas fa-sticky-note"></i>
                Notes
            </button>
        </div>

        <!-- Tab Content: Enrollments -->
        <div class="tab-content active" id="enrollments-tab">
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-book-open"></i>
                        Course Enrollments
                    </h3>
                    <a href="{{ route('admin.students.enrollments', $student) }}" class="btn-action-large btn-enroll" style="padding: 10px 20px; font-size: 13px;">
                        <i class="fas fa-plus"></i>
                        Add Enrollment
                    </a>
                </div>
                <div class="card-body">
                    @if($recentEnrollments->count() > 0)
                        <div class="table-responsive">
                            <table class="enrollment-table">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Enrolled Date</th>
                                        <th>Progress</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentEnrollments as $enrollment)
                                    <tr>
                                        <td>
                                            <div class="course-cell">
                                                <div class="course-icon">
                                                    <i class="fas fa-graduation-cap"></i>
                                                </div>
                                                <div class="course-info">
                                                    <h4>{{ $enrollment->course->title }}</h4>
                                                    <p>{{ $enrollment->course->instructor_name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="font-weight: 500; color: #2D3E50;">
                                                {{ $enrollment->enrolled_at->format('M d, Y') }}
                                            </div>
                                            <div style="font-size: 11px; color: #94a3b8;">
                                                {{ $enrollment->enrolled_at->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress-wrapper">
                                                <div class="progress-percentage">
                                                    <span>Progress</span>
                                                    <span style="font-weight: 600; color: #2D3E50;">
                                                        {{ $enrollment->progress_percentage }}%
                                                    </span>
                                                </div>
                                                <div class="progress-bar-container">
                                                    <div class="progress-bar-fill" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ $enrollment->status }}">
                                                {{ $enrollment->status }}
                                            </span>
                                        </td>
                                        <td style="font-weight: 700; color: #2D3E50;">
                                            ${{ number_format($enrollment->amount_paid, 2) }}
                                        </td>
                                        <td>
                                            <div style="display: flex; gap: 8px;">
                                                <a href="{{ route('admin.enrollments.edit', $enrollment) }}" 
                                                   class="btn-action-large" 
                                                   style="padding: 6px 12px; font-size: 12px; background: #f0f9ff; color: #0369a1; border: 1px solid #e0f2fe;">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('courses.progress', $enrollment) }}" 
                                                   class="btn-action-large" 
                                                   style="padding: 6px 12px; font-size: 12px; background: #f8fafc; color: #2D3E50; border: 1px solid #e2e8f0;">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($stats['total_enrollments'] > 5)
                            <div style="text-align: center; margin-top: 25px;">
                                <a href="{{ route('admin.students.enrollments', $student) }}" class="btn-action-large btn-view" style="background: white; border: 1px solid #e2e8f0; color: #2D3E50;">
                                    View All {{ $stats['total_enrollments'] }} Enrollments
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="empty-state">
                            <i class="fas fa-book-open"></i>
                            <h4>No Enrollments Yet</h4>
                            <p>This student hasn't enrolled in any courses yet.</p>
                            <a href="{{ route('admin.students.enrollments', $student) }}" class="btn-action-large btn-enroll" style="margin-top: 10px;">
                                <i class="fas fa-plus"></i>
                                Add First Enrollment
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tab Content: Learning Path -->
        <div class="tab-content" id="learning-path-tab">
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-route"></i>
                        Learning Path
                    </h3>
                    <button class="btn-action-large btn-enroll" style="padding: 10px 20px; font-size: 13px;" onclick="confirmGenerateLearningPath({{ $student->id }})">
                        <i class="fas fa-magic"></i>
                        Generate AI Path
                    </button>
                </div>
                <div class="card-body">
                    @if($activeLearningPath)
                        <div class="learning-path-card">
                            <div class="path-header">
                                <div class="path-title">
                                    <i class="fas fa-route"></i>
                                    {{ $activeLearningPath->title }}
                                </div>
                                @if($activeLearningPath->is_ai_generated)
                                    <span class="ai-badge">
                                        <i class="fas fa-robot"></i>
                                        AI Generated
                                    </span>
                                @endif
                            </div>
                            
                            <div class="path-progress">
                                <div class="path-progress-header">
                                    <span>Overall Progress</span>
                                    <span style="font-weight: 700; color: #2D3E50;">
                                        {{ $activeLearningPath->progress_percentage }}%
                                    </span>
                                </div>
                                <div class="progress-bar-container" style="height: 10px;">
                                    <div class="progress-bar-fill" style="width: {{ $activeLearningPath->progress_percentage }}%;"></div>
                                </div>
                                <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 12px; color: #64748b;">
                                    <span>
                                        <i class="fas fa-check-circle"></i>
                                        {{ $activeLearningPath->completed_courses }} of {{ $activeLearningPath->total_courses }} courses
                                    </span>
                                    <span>
                                        <i class="fas fa-clock"></i>
                                        Est. {{ $activeLearningPath->estimated_completion_weeks ?? 0 }} weeks remaining
                                    </span>
                                </div>
                            </div>
                            
                            <div class="path-items">
                                @foreach($activeLearningPath->items->take(5) as $item)
                                    <div class="path-item">
                                        <div class="item-status-indicator {{ $item->status }}">
                                            @if($item->status == 'completed')
                                                <i class="fas fa-check"></i>
                                            @elseif($item->status == 'active')
                                                <i class="fas fa-play"></i>
                                            @else
                                                <i class="fas fa-lock"></i>
                                            @endif
                                        </div>
                                        <div class="item-content">
                                            <div class="item-title">{{ $item->course->title }}</div>
                                            <div class="item-meta">
                                                {{ ucfirst($item->status) }} • {{ $item->progress }}% complete
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if($activeLearningPath->items->count() > 5)
                                <div style="text-align: center; margin-top: 20px;">
                                    <a href="#" class="btn-action-large" style="background: white; border: 1px solid #dbeafe; color: #1e40af; font-size: 13px;">
                                        View All {{ $activeLearningPath->total_courses }} Courses
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-route"></i>
                            <h4>No Learning Path</h4>
                            <p>This student doesn't have an active learning path yet.</p>
                            <button class="btn-action-large btn-enroll" style="margin-top: 10px;" onclick="confirmGenerateLearningPath({{ $student->id }})">
                                <i class="fas fa-magic"></i>
                                Create AI Learning Path
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tab Content: Activity -->
        <div class="tab-content" id="activity-tab">
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history"></i>
                        Recent Activity
                    </h3>
                </div>
                <div class="card-body">
                    @if($recentActivity->count() > 0)
                        <div class="activity-timeline">
                            @foreach($recentActivity as $activity)
                                <div class="activity-item">
                                    <div class="activity-icon {{ $activity['color'] }}">
                                        <i class="fas {{ $activity['icon'] }}"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-header">
                                            <span class="activity-title">{{ $activity['title'] }}</span>
                                            <span class="activity-time">{{ $activity['date']->diffForHumans() }}</span>
                                        </div>
                                        <p class="activity-description">{{ $activity['description'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-history"></i>
                            <h4>No Activity Yet</h4>
                            <p>Recent activity will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tab Content: Recommended -->
        <div class="tab-content" id="recommended-tab">
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-thumbs-up"></i>
                        Recommended Courses
                    </h3>
                </div>
                <div class="card-body">
                    @if($recommendedCourses->count() > 0)
                        <div class="course-cards-grid">
                            @foreach($recommendedCourses as $course)
                                <div class="recommended-course-card">
                                    <span class="course-category">{{ $course->category->name ?? 'Uncategorized' }}</span>
                                    <h4 class="course-card-title">{{ $course->title }}</h4>
                                    <p style="font-size: 13px; color: #64748b; margin-bottom: 15px;">
                                        {{ $course->instructor_name }}
                                    </p>
                                    <div class="course-card-price">
                                        ${{ number_format($course->final_price, 2) }}
                                        @if($course->is_discounted)
                                            <span style="font-size: 12px; color: #94a3b8; text-decoration: line-through; margin-left: 5px;">
                                                ${{ number_format($course->price, 2) }}
                                            </span>
                                        @endif
                                    </div>
                                    <a href="{{ route('admin.courses.enrollments', $course) }}" class="btn-recommend">
                                        <i class="fas fa-user-plus"></i>
                                        Enroll Student
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-thumbs-up"></i>
                            <h4>No Recommendations Yet</h4>
                            <p>Enroll the student in courses to get personalized recommendations.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tab Content: Wishlist -->
        <div class="tab-content" id="wishlist-tab">
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-heart"></i>
                        Wishlist
                    </h3>
                </div>
                <div class="card-body">
                    @php
                        $wishlistItems = $student->wishlists()->with('course.category')->get();
                    @endphp
                    @if($wishlistItems->count() > 0)
                        <div class="course-cards-grid">
                            @foreach($wishlistItems as $wishlist)
                                <div class="recommended-course-card">
                                    <span class="course-category">{{ $wishlist->course->category->name ?? 'Uncategorized' }}</span>
                                    <h4 class="course-card-title">{{ $wishlist->course->title }}</h4>
                                    <div style="font-size: 12px; color: #64748b; margin-bottom: 10px;">
                                        <i class="fas fa-tag"></i>
                                        Priority: 
                                        <span style="font-weight: 600; color: 
                                            @if($wishlist->priority >= 3) #d97706
                                            @elseif($wishlist->priority >= 4) #dc2626
                                            @else #64748b
                                            @endif">
                                            {{ $wishlist->priority_text }}
                                        </span>
                                    </div>
                                    <div class="course-card-price">
                                        ${{ number_format($wishlist->course->final_price, 2) }}
                                    </div>
                                    <a href="{{ route('admin.courses.enrollments', $wishlist->course) }}" class="btn-recommend">
                                        <i class="fas fa-user-plus"></i>
                                        Enroll Student
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-heart"></i>
                            <h4>Empty Wishlist</h4>
                            <p>This student hasn't added any courses to their wishlist.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tab Content: Notes -->
        <div class="tab-content" id="notes-tab">
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-sticky-note"></i>
                        Student Notes
                    </h3>
                    <button type="button" class="btn-action-large btn-enroll" style="padding: 10px 20px; font-size: 13px;" 
                            onclick="openAddNoteModal()">
                        <i class="fas fa-plus"></i>
                        Add Note
                    </button>
                </div>
                <div class="card-body">
                    @php
                        $notes = $student->notes()->with('creator')->visibleTo(auth()->id())->latest()->get();
                    @endphp

                    @if($notes->count() > 0)
                        <div class="notes-list">
                            @foreach($notes as $note)
                                <div class="note-item">
                                    <div class="note-avatar">
                                        <div class="note-avatar-initials">
                                            {{ $note->creator_initials }}
                                        </div>
                                    </div>
                                    <div class="note-content-wrapper">
                                        <div class="note-header">
                                            <div class="note-author">
                                                <strong>{{ $note->creator_name }}</strong>
                                                @if($note->creator && $note->creator->hasRole('admin'))
                                                    <span class="note-badge admin">Admin</span>
                                                @endif
                                                @if($note->creator && $note->creator->hasRole('instructor'))
                                                    <span class="note-badge instructor">Instructor</span>
                                                @endif
                                                @if($note->is_private)
                                                    <span class="note-badge private">
                                                        <i class="fas fa-lock"></i> Private
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="note-meta">
                                                <span class="note-date">{{ $note->created_at_diff }}</span>
                                                @if($note->created_by == auth()->id())
                                                    <div class="note-actions">
                                                        <a href="{{ route('admin.students.notes.edit', ['student' => $student, 'note' => $note]) }}" 
                                                           class="note-action-btn edit-note" title="Edit note">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        <button type="button" 
                                                                class="note-action-btn delete-note" 
                                                                title="Delete note"
                                                                onclick="confirmDeleteNote({{ $student->id }}, {{ $note->id }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        <form id="delete-note-form-{{ $note->id }}" 
                                                              action="{{ route('admin.students.notes.destroy', ['student' => $student, 'note' => $note]) }}" 
                                                              method="POST" 
                                                              style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="note-content">
                                            {{ $note->content }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-sticky-note"></i>
                            <h4>No Notes Yet</h4>
                            <p>Add a note to keep track of student progress, achievements, or important information.</p>
                            <button type="button" class="btn-action-large btn-enroll" style="margin-top: 10px;"
                                    onclick="openAddNoteModal()">
                                <i class="fas fa-plus"></i> Add Your First Note
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Note Modal -->
    <div id="addNoteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-sticky-note"></i> Add New Note
                </h3>
                <button type="button" class="modal-close" onclick="closeAddNoteModal()">
                    &times;
                </button>
            </div>

            <form action="{{ route('admin.students.notes.store', $student) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div style="margin-bottom: 20px;">
                        <textarea name="content" rows="6" class="note-textarea" 
                                  placeholder="Write your note here..." required></textarea>
                    </div>

                    <div class="note-private-checkbox">
                        <input type="checkbox" name="is_private" id="is_private" value="1">
                        <label for="is_private">
                            <i class="fas fa-lock"></i> Make this note private (only visible to me)
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeAddNoteModal()">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Note
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Note Modal -->
    @if(isset($editNote))
    <div id="editNoteModal" class="modal show">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-edit"></i> Edit Note
                </h3>
                <a href="{{ route('admin.students.show', $student) }}" class="modal-close">
                    &times;
                </a>
            </div>

            <form action="{{ route('admin.students.notes.update', ['student' => $student, 'note' => $editNote]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div style="margin-bottom: 20px;">
                        <textarea name="content" rows="6" class="note-textarea" required>{{ $editNote->content }}</textarea>
                    </div>

                    <div class="note-private-checkbox">
                        <input type="checkbox" name="is_private" id="edit_is_private" value="1" {{ $editNote->is_private ? 'checked' : '' }}>
                        <label for="edit_is_private">
                            <i class="fas fa-lock"></i> Private note
                        </label>
                    </div>
                </div>

                <div class="modal-footer">
                    <a href="{{ route('admin.students.show', $student) }}" class="btn btn-secondary">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Note
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Bio Section (if exists) -->
    @if($student->bio)
        <div class="content-card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user"></i>
                    About {{ $student->name }}
                </h3>
            </div>
            <div class="card-body">
                <p style="color: #4a5568; line-height: 1.6; margin: 0;">
                    {{ $student->bio }}
                </p>
                @if($student->company || $student->job_title)
                    <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #f1f5f9;">
                        @if($student->job_title)
                            <span style="display: inline-block; margin-right: 15px; color: #64748b;">
                                <i class="fas fa-briefcase"></i>
                                {{ $student->job_title }}
                            </span>
                        @endif
                        @if($student->company)
                            <span style="color: #64748b;">
                                <i class="fas fa-building"></i>
                                {{ $student->company }}
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

<!-- Message Modal -->
<div class="modal" id="messageModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fas fa-envelope"></i>
                Send Message to {{ $student->name }}
            </h3>
            <button type="button" class="modal-close" onclick="closeMessageModal()">
                &times;
            </button>
        </div>

        <form id="messageForm">
            @csrf
            <input type="hidden" name="student_id" value="{{ $student->id }}">
            
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; color: #2D3E50; font-weight: 600;">
                        Subject <span style="color: #94a3b8;">(optional)</span>
                    </label>
                    <input type="text" name="subject" class="form-control" 
                           placeholder="Enter message subject..." 
                           style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px;">
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; color: #2D3E50; font-weight: 600;">
                        Message <span style="color: #ef4444;">*</span>
                    </label>
                    <textarea name="message" rows="5" class="form-control" 
                              placeholder="Type your message here..." 
                              style="width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; resize: vertical;" 
                              required></textarea>
                </div>

                <div style="background: #f0f9ff; border-left: 4px solid #2D3E50; padding: 15px; border-radius: 8px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                        <i class="fas fa-info-circle" style="color: #2D3E50;"></i>
                        <span style="font-weight: 600; color: #2D3E50;">Student Information</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 10px;">
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #2D3E50, #3182ce); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                            {{ $student->initials }}
                        </div>
                        <div>
                            <div style="font-weight: 500; color: #2D3E50;">{{ $student->name }}</div>
                            <div style="font-size: 12px; color: #64748b;">{{ $student->email }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer" style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                <button type="button" class="btn-action-large" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;" onclick="closeMessageModal()">
                    Cancel
                </button>
                <button type="submit" class="btn-action-large btn-enroll" id="sendMessageBtn">
                    <i class="fas fa-paper-plane"></i>
                    Send Message
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Student Form -->
<form id="delete-student-form-{{ $student->id }}" action="{{ route('admin.students.destroy', $student) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const tabId = this.getAttribute('data-tab');
                
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding content
                this.classList.add('active');
                document.getElementById(`${tabId}-tab`).classList.add('active');
                
                // Save active tab to localStorage
                localStorage.setItem('activeStudentTab', tabId);
            });
        });
        
        // Restore active tab from localStorage
        const activeTab = localStorage.getItem('activeStudentTab');
        if (activeTab) {
            const tabToActivate = document.querySelector(`.tab[data-tab="${activeTab}"]`);
            if (tabToActivate) {
                tabToActivate.click();
            }
        }
        
        // Animate progress bars
        const progressBars = document.querySelectorAll('.progress-bar-fill');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, 300);
        });
    });

    // Message Modal Functions
    window.openMessageModal = function() {
        document.getElementById('messageModal').classList.add('show');
    };
    
    window.closeMessageModal = function() {
        document.getElementById('messageModal').classList.remove('show');
        document.getElementById('messageForm').reset();
    };
    
    // Handle Message Form Submission
    document.getElementById('messageForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
    
        const submitBtn = document.getElementById('sendMessageBtn');
        const originalText = submitBtn.innerHTML;
    
        // Show loading state
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        submitBtn.disabled = true;
    
        const formData = new FormData(this);
    
        fetch('{{ route("admin.students.send-message", $student) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close modal
                closeMessageModal();
    
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Message Sent!',
                    text: data.message,
                    timer: 3000,
                    showConfirmButton: false,
                    background: 'white',
                    backdrop: 'rgba(45, 62, 80, 0.2)'
                });
    
                // Reset form
                this.reset();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to send message',
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
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('messageModal');
        if (event.target === modal) {
            modal.classList.remove('show');
        }
    });

    // Delete student confirmation
    window.confirmDeleteStudent = function(studentId, studentName) {
        Swal.fire({
            title: 'Delete Student?',
            html: `<div style="text-align: left;">
                    <p style="margin-bottom: 15px;">Are you sure you want to delete <strong>${studentName}</strong>?</p>
                    <div style="background: #fee2e2; border-left: 4px solid #dc2626; padding: 12px; border-radius: 6px; color: #991b1b; font-size: 13px;">
                        <i class="fas fa-exclamation-triangle"></i> 
                        <span style="margin-left: 5px;">This action cannot be undone. All enrollments, progress data, notes, and wishlist items will be permanently deleted.</span>
                    </div>
                   </div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete student',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-student-form-${studentId}`).submit();
            }
        });
    };

    // SWEETALERT: Generate learning path confirmation
    window.confirmGenerateLearningPath = function(studentId) {
        Swal.fire({
            title: 'Generate AI Learning Path',
            html: `<div style="text-align: left;">
                    <p style="margin-bottom: 15px;">This will analyze:</p>
                    <ul style="list-style: none; padding-left: 0; margin-bottom: 20px;">
                        <li style="margin-bottom: 8px;">
                            <i class="fas fa-check-circle" style="color: #10b981; margin-right: 10px;"></i>
                            Enrolled & completed courses
                        </li>
                        <li style="margin-bottom: 8px;">
                            <i class="fas fa-check-circle" style="color: #10b981; margin-right: 10px;"></i>
                            Wishlist items
                        </li>
                        <li style="margin-bottom: 8px;">
                            <i class="fas fa-check-circle" style="color: #10b981; margin-right: 10px;"></i>
                            Course categories & levels
                        </li>
                    </ul>
                    <p style="font-size: 14px; color: #64748b;">
                        A personalized learning path will be created with recommended courses.
                    </p>
                   </div>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2d3e50',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fas fa-robot"></i> Generate AI Path',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Generating Learning Path...',
                    html: `
                        <div style="text-align: center; padding: 20px;">
                            <div style="margin-bottom: 20px;">
                                <i class="fas fa-robot" style="font-size: 48px; color: #2d3e50; animation: pulse 1.5s infinite;"></i>
                            </div>
                            <div style="width: 100%; background: #e2e8f0; border-radius: 10px; height: 6px; margin: 15px 0; overflow: hidden;">
                                <div id="progressBar" style="width: 0%; height: 100%; background: linear-gradient(90deg, #2d3e50, #3182ce); border-radius: 10px; transition: width 0.5s ease;"></div>
                            </div>
                            <p id="generationStatus" style="color: #64748b; margin-top: 15px;">Analyzing student data...</p>
                        </div>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        // Simulate progress steps
                        const steps = [
                            { progress: 20, message: 'Checking enrolled courses...' },
                            { progress: 40, message: 'Analyzing wishlist items...' },
                            { progress: 60, message: 'Finding recommended courses...' },
                            { progress: 80, message: 'Creating learning path...' },
                            { progress: 100, message: 'Finalizing recommendations...' }
                        ];

                        let step = 0;
                        const interval = setInterval(() => {
                            if (step < steps.length) {
                                const progressBar = document.getElementById('progressBar');
                                const statusEl = document.getElementById('generationStatus');

                                if (progressBar) progressBar.style.width = steps[step].progress + '%';
                                if (statusEl) statusEl.innerHTML = steps[step].message;

                                step++;
                            }
                        }, 600);

                        // Make actual API call
                        fetch(`/admin/students/${studentId}/learning-path/generate`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            clearInterval(interval);

                            // Complete progress bar
                            const progressBar = document.getElementById('progressBar');
                            const statusEl = document.getElementById('generationStatus');

                            if (progressBar) progressBar.style.width = '100%';
                            if (statusEl) statusEl.innerHTML = 'Complete!';

                            setTimeout(() => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: '✅ Learning Path Generated!',
                                        html: `
                                            <div style="text-align: left; margin-top: 15px;">
                                                <p style="margin-bottom: 10px;">AI has created a personalized learning path with:</p>
                                                <div style="display: flex; gap: 15px; justify-content: center; margin: 20px 0;">
                                                    <div style="text-align: center;">
                                                        <span style="display: block; font-size: 28px; font-weight: 700; color: #2d3e50;">${data.courses_count || 0}</span>
                                                        <span style="font-size: 12px; color: #64748b;">Recommended Courses</span>
                                                    </div>
                                                </div>
                                                <div style="background: #f0f9ff; border-left: 4px solid #2d3e50; padding: 15px; border-radius: 8px; margin-top: 15px;">
                                                    <i class="fas fa-info-circle" style="color: #2d3e50; margin-right: 8px;"></i>
                                                    View the learning path in the "Learning Path" tab above.
                                                </div>
                                            </div>
                                        `,
                                        confirmButtonColor: '#2d3e50',
                                        confirmButtonText: 'View Learning Path',
                                        showCancelButton: true,
                                        cancelButtonText: 'Stay Here',
                                        reverseButtons: true
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Switch to learning path tab
                                            const learningPathTab = document.querySelector('.tab[data-tab="learning-path"]');
                                            if (learningPathTab) learningPathTab.click();
                                            // Reload to show new path
                                            setTimeout(() => location.reload(), 300);
                                        } else {
                                            location.reload();
                                        }
                                    });
                                } else {
                                    throw new Error(data.message || 'Failed to generate path');
                                }
                            }, 500);
                        })
                        .catch(error => {
                            clearInterval(interval);
                            console.error('Error:', error);

                            Swal.fire({
                                icon: 'error',
                                title: 'Generation Failed',
                                text: error.message || 'An error occurred while generating the learning path.',
                                confirmButtonColor: '#2d3e50'
                            });
                        });
                    }
                });
            }
        });
    };

    // SWEETALERT: Delete note confirmation
    window.confirmDeleteNote = function(studentId, noteId) {
        Swal.fire({
            title: 'Delete Note?',
            text: 'Are you sure you want to delete this note? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete note',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-note-form-${noteId}`).submit();
            }
        });
    };

    // Modal functions for Add Note
    window.openAddNoteModal = function() {
        document.getElementById('addNoteModal').classList.add('show');
    };

    window.closeAddNoteModal = function() {
        document.getElementById('addNoteModal').classList.remove('show');
    };

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('addNoteModal');
        if (event.target === modal) {
            modal.classList.remove('show');
        }
    });
</script>
@endsection