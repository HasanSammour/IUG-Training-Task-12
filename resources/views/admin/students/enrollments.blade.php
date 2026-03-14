@extends('layouts.app')

@section('title', $student->name . ' - Enrollments')
@section('body-class', 'admin-page')

@section('styles')
<style>
    .admin-container {
        padding: 20px;
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e2e8f0;
    }

    .page-title {
        font-size: 24px;
        color: #2D3E50;
        font-weight: 700;
        margin: 0;
    }

    .back-btn {
        color: #64748b;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        color: #2D3E50;
        background: #f1f5f9;
        transform: translateX(-5px);
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
        padding: 25px;
        background: white;
        border-radius: 16px;
        border: 1px solid #edf2f7;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .student-avatar {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #2D3E50, #3182ce);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 700;
        box-shadow: 0 4px 10px rgba(45, 62, 80, 0.15);
    }

    .student-details h3 {
        font-size: 20px;
        color: #2D3E50;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .student-details p {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .student-details i {
        width: 16px;
        color: #94a3b8;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
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
        background: white;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #edf2f7;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border-color: #2D3E50;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #2D3E50;
        display: block;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .controls-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding: 15px 20px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .search-container {
        position: relative;
        flex: 1;
        max-width: 350px;
    }

    .search-input {
        width: 100%;
        padding: 12px 15px 12px 45px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        border-color: #2D3E50;
        outline: none;
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }

    .filter-dropdown {
        padding: 12px 20px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        color: #2D3E50;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-dropdown:hover {
        border-color: #2D3E50;
    }

    .btn-add {
        background: linear-gradient(135deg, #2D3E50, #1a252f);
        color: white;
        padding: 12px 24px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-add:hover {
        background: linear-gradient(135deg, #1a252f, #2D3E50);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.2);
        color: white;
    }

    .enrollments-table {
        background: white;
        border-radius: 16px;
        border: 1px solid #edf2f7;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        width: 100%;
    }

    .table-responsive {
        overflow-x: auto;
        width: 100%;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: auto;
    }

    /* FIX 02: Table columns width fit to content */
    th, td {
        padding: 16px 20px;
        white-space: nowrap;
    }

    /* Allow specific columns to wrap if needed */
    .course-title {
        white-space: normal;
        word-break: break-word;
        max-width: 300px;
    }

    .enrollment-id-cell {
        white-space: nowrap;
    }

    .date-cell {
        white-space: nowrap;
    }

    .amount-cell {
        white-space: nowrap;
    }

    .status-cell {
        white-space: nowrap;
    }

    .progress-cell {
        white-space: nowrap;
    }

    .actions-cell {
        white-space: nowrap;
    }

    th {
        background: #f8fafc;
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0;
        text-align: left;
    }

    td {
        font-size: 14px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    tr:hover td {
        background: #f8fafc;
    }

    .enrollment-id {
        color: #3182ce;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .enrollment-id:hover {
        text-decoration: underline;
        color: #1e40af;
    }

    .course-title {
        color: #2D3E50;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: normal;
        word-break: break-word;
    }

    .course-title i {
        color: #3182ce;
        flex-shrink: 0;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .status-active {
        background: #dcfce7;
        color: #15803d;
    }

    .status-active i {
        color: #15803d;
    }

    .status-completed {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-completed i {
        color: #1e40af;
    }

    .status-pending {
        background: #fef9c3;
        color: #854d0e;
    }

    .status-pending i {
        color: #854d0e;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #b91c1c;
    }

    .status-cancelled i {
        color: #b91c1c;
    }

    .progress-cell {
        min-width: 140px;
    }

    .progress-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .progress-bar-wrapper {
        flex: 1;
        height: 8px;
        background: #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        min-width: 80px;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #2D3E50, #3182ce);
        border-radius: 10px;
        transition: width 0.5s ease;
    }

    .progress-text {
        font-size: 12px;
        color: #64748b;
        min-width: 40px;
        font-weight: 600;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        font-size: 14px;
        border: 1px solid #e2e8f0;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    .btn-view {
        color: #2D3E50;
    }

    .btn-view:hover {
        background: #f1f5f9;
        border-color: #2D3E50;
    }

    .btn-edit {
        color: #3182ce;
    }

    .btn-edit:hover {
        background: #dbeafe;
        border-color: #3182ce;
    }

    .btn-delete {
        color: #dc2626;
    }

    .btn-delete:hover {
        background: #fee2e2;
        border-color: #dc2626;
    }

    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        background: white;
        border-top: 1px solid #f1f5f9;
    }

    .info-text {
        font-size: 13px;
        color: #64748b;
    }

    .pagination {
        display: flex;
        gap: 5px;
    }

    .page-link {
        padding: 8px 14px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        color: #64748b;
        background: white;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .page-link:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #2D3E50;
    }

    .page-link.active {
        background: #2D3E50;
        color: white;
        border-color: #2D3E50;
    }

    /* FIX 01: Empty state container wider and centered properly */
    .empty-state-wrapper {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 500px;
        padding: 40px 20px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 40px;
        background: white;
        border-radius: 24px;
        border: 1px solid #edf2f7;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        max-width: 600px;
        width: 100%;
        margin: 0 auto;
    }

    .empty-icon {
        font-size: 64px;
        color: #cbd5e0;
        margin-bottom: 24px;
    }

    .empty-state h3 {
        color: #2D3E50;
        margin-bottom: 12px;
        font-size: 24px;
        font-weight: 700;
    }

    .empty-state p {
        color: #94a3b8;
        margin-bottom: 28px;
        font-size: 16px;
    }

    .alert {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: #dcfce7;
        border-left: 4px solid #15803d;
        color: #166534;
    }

    .alert-error {
        background: #fee2e2;
        border-left: 4px solid #b91c1c;
        color: #991b1b;
    }

    .alert-info {
        background: #dbeafe;
        border-left: 4px solid #1e40af;
        color: #1e3a8a;
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
        animation: fadeIn 0.3s ease;
    }

    .modal-content {
        background: white;
        width: 500px;
        max-width: 90%;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        animation: slideIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
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
        padding: 20px 25px;
        border-bottom: 1px solid #e2e8f0;
    }

    .modal-title {
        font-size: 18px;
        font-weight: 700;
        color: #2D3E50;
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
        transition: all 0.3s ease;
    }

    .modal-close:hover {
        color: #2D3E50;
        transform: scale(1.1);
    }

    .modal-body {
        padding: 25px;
    }

    .modal-footer {
        padding: 20px 25px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #2D3E50;
    }

    .form-select, .form-input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-select:focus, .form-input:focus {
        border-color: #2D3E50;
        outline: none;
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    .btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: #2D3E50;
        color: white;
    }

    .btn-primary:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.2);
    }

    .btn-secondary {
        background: white;
        color: #64748b;
        border: 1px solid #e2e8f0;
    }

    .btn-secondary:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
    }

    .btn-danger {
        background: #dc2626;
        color: white;
    }

    .btn-danger:hover {
        background: #b91c1c;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.2);
    }

    @media (max-width: 1024px) {
        .controls-row {
            flex-direction: column;
            gap: 15px;
            align-items: stretch;
        }
        
        .search-container {
            max-width: 100%;
        }
        
        .empty-state-wrapper {
            min-height: 400px;
        }
        
        .empty-state {
            padding: 40px 20px;
        }
    }

    @media (max-width: 768px) {
        .admin-container {
            padding: 15px;
        }
        
        .student-info {
            flex-direction: column;
            text-align: center;
        }
        
        .stats-grid {
            margin-top: 20px;
        }
        
        .empty-state h3 {
            font-size: 20px;
        }
        
        .empty-state p {
            font-size: 14px;
        }
        
        .empty-state-wrapper {
            min-height: 350px;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success" id="flash-message">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-error" id="flash-message">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-graduation-cap" style="margin-right: 12px; color: #2D3E50;"></i>
            Student Enrollments
        </h1>
        <a href="{{ route('admin.students.show', $student) }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Student Profile
        </a>
    </div>

    <div class="student-info">
        <div class="student-avatar">
            @if($student->avatar && \Storage::disk('public')->exists($student->avatar))
                <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
            @else
                {{ $student->initials }}
            @endif
        </div>
        <div class="student-details">
            <h3>{{ $student->name }}</h3>
            <p>
                <i class="fas fa-envelope"></i> {{ $student->email }}
            </p>
            <p>
                <i class="fas fa-id-card"></i> Student ID: STU{{ str_pad($student->id, 5, '0', STR_PAD_LEFT) }}
            </p>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-value">{{ $stats['total'] }}</span>
            <span class="stat-label">Total Enrollments</span>
        </div>
        <div class="stat-card">
            <span class="stat-value">{{ $stats['active'] }}</span>
            <span class="stat-label">Active Courses</span>
        </div>
        <div class="stat-card">
            <span class="stat-value">{{ $stats['completed'] }}</span>
            <span class="stat-label">Completed</span>
        </div>
        <div class="stat-card">
            <span class="stat-value">${{ number_format($stats['total_spent'], 2) }}</span>
            <span class="stat-label">Total Spent</span>
        </div>
    </div>

    <div class="controls-row">
        <div style="display: flex; gap: 15px; align-items: center; flex: 1;">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search by ID or course..." id="searchInput" value="{{ request('search') }}">
            </div>
            
            <select class="filter-dropdown" id="statusFilter">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        
        <button type="button" class="btn-add" onclick="openEnrollmentModal()">
            <i class="fas fa-plus"></i> Add Enrollment
        </button>
    </div>

    @if($enrollments->count() > 0)
        <div class="enrollments-table">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Enrollment ID</th>
                            <th>Course</th>
                            <th>Enrolled Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Progress</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="enrollmentsTableBody">
                        @foreach($enrollments as $enrollment)
                            <tr>
                                <td class="enrollment-id-cell">
                                    <a href="{{ route('admin.enrollments.show', $enrollment) }}" class="enrollment-id">
                                        <i class="fas fa-receipt"></i>
                                        {{ $enrollment->enrollment_id }}
                                    </a>
                                </td>
                                <td>
                                    <div class="course-title" title="{{ $enrollment->course->title }}">
                                        <i class="fas fa-book"></i>
                                        {{ $enrollment->course->title }}
                                    </div>
                                </td>
                                <td class="date-cell">
                                    {{ $enrollment->enrolled_at->format('M d, Y') }}
                                    <div style="font-size: 11px; color: #94a3b8;">
                                        {{ $enrollment->enrolled_at->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="amount-cell" style="font-weight: 600; color: #2D3E50;">
                                    ${{ number_format($enrollment->amount_paid, 2) }}
                                </td>
                                <td class="status-cell">
                                    <span class="status-badge status-{{ $enrollment->status }}">
                                        <i class="fas 
                                            @if($enrollment->status == 'active') fa-play-circle
                                            @elseif($enrollment->status == 'completed') fa-check-circle
                                            @elseif($enrollment->status == 'pending') fa-clock
                                            @else fa-ban
                                            @endif
                                        "></i>
                                        {{ $enrollment->status }}
                                    </span>
                                </td>
                                <td class="progress-cell">
                                    <div class="progress-container">
                                        <div class="progress-bar-wrapper">
                                            <div class="progress-fill" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                        </div>
                                        <span class="progress-text">{{ $enrollment->progress_percentage }}%</span>
                                    </div>
                                </td>
                                <td class="actions-cell">
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.enrollments.show', $enrollment) }}" class="btn-action btn-view" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.enrollments.edit', $enrollment) }}" class="btn-action btn-edit" title="Edit Enrollment">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn-action btn-delete" 
                                                title="Remove Enrollment"
                                                onclick="confirmDeleteEnrollment({{ $student->id }}, {{ $enrollment->id }}, '{{ addslashes($enrollment->course->title) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-enrollment-form-{{ $enrollment->id }}" 
                                              action="{{ route('admin.students.enrollments.destroy', ['student' => $student, 'enrollment' => $enrollment]) }}" 
                                              method="POST" 
                                              style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="pagination-container">
                <div class="info-text">
                    Showing {{ $enrollments->firstItem() }} to {{ $enrollments->lastItem() }} of {{ $enrollments->total() }} enrollments
                </div>
                <div class="pagination">
                    @if($enrollments->onFirstPage())
                        <span class="page-link" style="opacity: 0.5; cursor: not-allowed;">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $enrollments->previousPageUrl() }}" class="page-link">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif
                    
                    @for($i = 1; $i <= $enrollments->lastPage(); $i++)
                        @if($i == $enrollments->currentPage())
                            <span class="page-link active">{{ $i }}</span>
                        @else
                            <a href="{{ $enrollments->url($i) }}" class="page-link">{{ $i }}</a>
                        @endif
                    @endfor
                    
                    @if($enrollments->hasMorePages())
                        <a href="{{ $enrollments->nextPageUrl() }}" class="page-link">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="page-link" style="opacity: 0.5; cursor: not-allowed;">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @else
        <!-- FIX 01: Empty state container wider and properly centered -->
        <div class="empty-state-wrapper">
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3>No Enrollments Yet</h3>
                <p>This student hasn't enrolled in any courses yet.<br>Add their first enrollment to get started.</p>
                <button type="button" class="btn-add" onclick="openEnrollmentModal()">
                    <i class="fas fa-plus"></i> Add First Enrollment
                </button>
            </div>
        </div>
    @endif
</div>

<!-- Add Enrollment Modal -->
<div id="enrollmentModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">
                <i class="fas fa-user-graduate"></i>
                Enroll in Course
            </h5>
            <button type="button" class="modal-close" onclick="closeEnrollmentModal()">&times;</button>
        </div>
        
        <form action="{{ route('admin.students.enroll-to-course', $student) }}" method="POST" id="enrollmentForm">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="course_id" class="form-label">Select Course</label>
                    <select name="course_id" id="course_id" class="form-select" required>
                        <option value="">-- Choose a course --</option>
                        @php
                            $availableCourses = App\Models\Course::where('is_active', true)
                                ->whereNotIn('id', $student->enrollments()->pluck('course_id'))
                                ->get();
                        @endphp
                        @foreach($availableCourses as $course)
                            <option value="{{ $course->id }}" data-price="{{ $course->final_price }}">
                                {{ $course->title }} - ${{ number_format($course->final_price, 2) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="amount_paid" class="form-label">Amount Paid</label>
                    <input type="number" name="amount_paid" id="amount_paid" class="form-input" step="0.01" min="0" required>
                </div>
                
                <div class="form-group">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="form-select" required>
                        <option value="manual">Manual Entry</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="paypal">PayPal</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="free">Free</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="status" class="form-label">Enrollment Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEnrollmentModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enroll Student
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide flash messages after 5 seconds
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            setTimeout(() => {
                flashMessage.style.transition = 'opacity 0.5s ease';
                flashMessage.style.opacity = '0';
                setTimeout(() => flashMessage.remove(), 500);
            }, 5000);
        }
        
        // Progress bar animation
        document.querySelectorAll('.progress-fill').forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.transition = 'width 0.8s ease';
                bar.style.width = width;
            }, 200);
        });
        
        // Set default amount when course is selected
        const courseSelect = document.getElementById('course_id');
        const amountInput = document.getElementById('amount_paid');
        
        if (courseSelect && amountInput) {
            courseSelect.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                if (selected && selected.dataset.price) {
                    amountInput.value = selected.dataset.price;
                }
            });
        }
        
        // Search functionality with URL params
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        
        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;
            
            // Update URL params for persistence
            const url = new URL(window.location.href);
            if (searchTerm) {
                url.searchParams.set('search', searchTerm);
            } else {
                url.searchParams.delete('search');
            }
            if (statusValue) {
                url.searchParams.set('status', statusValue);
            } else {
                url.searchParams.delete('status');
            }
            window.history.replaceState({}, '', url);
            
            // Client-side filtering
            const rows = document.querySelectorAll('#enrollmentsTableBody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const statusCell = row.querySelector('.status-badge');
                const rowStatus = statusCell ? statusCell.textContent.trim().toLowerCase() : '';
                
                let showBySearch = !searchTerm || text.includes(searchTerm);
                let showByStatus = !statusValue || rowStatus.includes(statusValue);
                
                row.style.display = showBySearch && showByStatus ? '' : 'none';
            });
        }
        
        if (searchInput) {
            let debounceTimer;
            searchInput.addEventListener('keyup', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(filterTable, 300);
            });
        }
        
        if (statusFilter) {
            statusFilter.addEventListener('change', filterTable);
        }
    });

    // SWEETALERT: Confirm delete enrollment
    window.confirmDeleteEnrollment = function(studentId, enrollmentId, courseTitle) {
        Swal.fire({
            title: 'Remove Enrollment?',
            html: `<div style="text-align: left;">
                    <p style="margin-bottom: 15px;">Are you sure you want to remove enrollment for:</p>
                    <div style="background: #f8fafc; padding: 12px; border-radius: 8px; margin-bottom: 15px; border-left: 4px solid #dc2626;">
                        <strong style="color: #2D3E50;">${courseTitle}</strong>
                    </div>
                    <div style="background: #fee2e2; border-left: 4px solid #dc2626; padding: 12px; border-radius: 6px; color: #991b1b; font-size: 13px;">
                        <i class="fas fa-exclamation-triangle"></i> 
                        <span style="margin-left: 5px;">This action cannot be undone. All progress data will be permanently deleted.</span>
                    </div>
                   </div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, remove enrollment',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-enrollment-form-${enrollmentId}`).submit();
            }
        });
    };

    // Modal functions
    window.openEnrollmentModal = function() {
        const modal = document.getElementById('enrollmentModal');
        if (modal) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    };

    window.closeEnrollmentModal = function() {
        const modal = document.getElementById('enrollmentModal');
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }
    };

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('enrollmentModal');
        if (event.target === modal) {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }
    });

    // Handle form submission with SweetAlert
    document.addEventListener('DOMContentLoaded', function() {
        const enrollmentForm = document.getElementById('enrollmentForm');
        if (enrollmentForm) {
            enrollmentForm.addEventListener('submit', function(e) {
                const courseSelect = document.getElementById('course_id');
                if (!courseSelect.value) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'No Course Selected',
                        text: 'Please select a course to enroll the student.',
                        icon: 'warning',
                        confirmButtonColor: '#2d3e50'
                    });
                }
            });
        }
    });
</script>
@endsection