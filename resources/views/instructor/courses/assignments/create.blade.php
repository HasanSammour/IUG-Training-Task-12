@extends('layouts.app')

@section('title', 'Create Assignment')
@section('body-class', 'instructor-page')

@section('styles')
<style>
    .assignment-container {
        padding: 30px 40px;
        max-width: 900px;
        margin: 0 auto;
        padding-bottom: 100px;
    }

    .page-header {
        margin-bottom: 25px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 15px;
        transition: color 0.3s ease;
        padding: 8px 16px;
        background: white;
        border-radius: 30px;
        border: 1px solid #e2e8f0;
    }

    .back-link:hover {
        color: #2D3E50;
        border-color: #2D3E50;
        transform: translateX(-3px);
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #2D3E50;
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0 0 5px 0;
    }

    .page-title i {
        color: #3182ce;
        background: rgba(49, 130, 206, 0.1);
        padding: 10px;
        border-radius: 12px;
    }

    .course-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f1f5f9;
        color: #475569;
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 20px;
    }

    .course-badge i {
        color: #2D3E50;
    }

    .assignment-card {
        background: white;
        border-radius: 24px;
        padding: 40px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .section-title {
        font-size: 18px;
        color: #2D3E50;
        margin-bottom: 25px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e2e8f0;
    }

    .section-title i {
        color: #3182ce;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #2D3E50;
        margin-bottom: 8px;
    }

    .form-group label i {
        color: #3182ce;
        margin-right: 5px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: #2D3E50;
        box-shadow: 0 0 0 3px rgba(45,62,80,0.1);
    }

    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 640px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    .file-upload-area {
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
        padding: 30px 20px;
        text-align: center;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .file-upload-area:hover {
        border-color: #2D3E50;
        background: #f1f5f9;
    }

    .file-upload-area i {
        font-size: 40px;
        color: #94a3b8;
        margin-bottom: 10px;
    }

    .file-upload-area p {
        color: #64748b;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .file-upload-area small {
        color: #94a3b8;
        font-size: 11px;
    }

    .file-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .file-preview {
        margin-top: 15px;
    }

    .file-item {
        background: #f1f5f9;
        border-radius: 10px;
        padding: 12px 15px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid #e2e8f0;
    }

    .file-item i {
        font-size: 24px;
        color: #2563eb;
    }

    .file-info {
        flex: 1;
    }

    .file-name {
        font-size: 14px;
        font-weight: 500;
        color: #2D3E50;
        margin-bottom: 2px;
        word-break: break-all;
    }

    .file-meta {
        font-size: 11px;
        color: #64748b;
        display: flex;
        gap: 10px;
    }

    .remove-file {
        background: #fee2e2;
        color: #b91c1c;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .remove-file:hover {
        background: #fecaca;
    }

    .toggle-group {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 10px;
    }

    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e0;
        transition: .3s;
        border-radius: 24px;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
    }

    input:checked + .toggle-slider {
        background-color: #2D3E50;
    }

    input:checked + .toggle-slider:before {
        transform: translateX(26px);
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #e2e8f0;
    }

    .btn-primary {
        flex: 1;
        padding: 14px 25px;
        background: #2D3E50;
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-primary:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45,62,80,0.15);
    }

    .btn-secondary {
        padding: 14px 30px;
        background: white;
        color: #475569;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #2D3E50;
        color: #2D3E50;
    }

    .help-text {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

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
        width: 50px;
        height: 50px;
        border: 4px solid #f1f5f9;
        border-top-color: #2D3E50;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    @media (max-width: 768px) {
        .assignment-container {
            padding: 20px;
        }

        .assignment-card {
            padding: 25px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-primary, .btn-secondary {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="assignment-container">
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <div class="page-header">
        <a href="{{ route('instructor.course.assignments.index', $course) }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Back to Assignments
        </a>
        
        <h1 class="page-title">
            <i class="fas fa-plus-circle"></i>
            Create New Assignment
        </h1>
        
        <div class="course-badge">
            <i class="fas fa-book"></i>
            {{ $course->title }}
        </div>
    </div>

    <div class="assignment-card">
        <form method="POST" action="{{ route('instructor.course.assignments.store', $course) }}" enctype="multipart/form-data" id="createForm">
            @csrf
            
            <div class="section-title">
                <i class="fas fa-info-circle"></i>
                Basic Information
            </div>
            
            <div class="form-group">
                <label>
                    <i class="fas fa-heading"></i>
                    Assignment Title
                </label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="e.g., Week 1 Assignment" required>
                @error('title')
                    <span style="color: #dc2626; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label>
                    <i class="fas fa-align-left"></i>
                    Description
                </label>
                <textarea name="description" class="form-control" rows="6" placeholder="Provide clear instructions and requirements..." required>{{ old('description') }}</textarea>
                @error('description')
                    <span style="color: #dc2626; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="section-title" style="margin-top: 30px;">
                <i class="fas fa-cog"></i>
                Assignment Settings
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>
                        <i class="fas fa-calendar-alt"></i>
                        Due Date (Optional)
                    </label>
                    <input type="datetime-local" name="due_date" class="form-control" value="{{ old('due_date') }}">
                    @error('due_date')
                        <span style="color: #dc2626; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label>
                        <i class="fas fa-star"></i>
                        Total Points
                    </label>
                    <input type="number" name="points" class="form-control" value="{{ old('points', 100) }}" min="0" max="1000">
                    @error('points')
                        <span style="color: #dc2626; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="section-title" style="margin-top: 30px;">
                <i class="fas fa-paperclip"></i>
                Attachment (Optional)
            </div>
            
            <div class="form-group">
                <div class="file-upload-area" id="fileUploadArea">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>Click to upload file or drag and drop</p>
                    <small>Supported: PDF, DOC, DOCX, ZIP (Max: 10MB)</small>
                    <input type="file" name="file" class="file-input" id="fileInput" accept=".pdf,.doc,.docx,.zip">
                </div>
                
                <div id="filePreview" class="file-preview" style="display: none;"></div>
                
                @error('file')
                    <span style="color: #dc2626; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="section-title" style="margin-top: 30px;">
                <i class="fas fa-bell"></i>
                Notification
            </div>
            
            <div class="form-group">
                <div class="toggle-group">
                    <label class="toggle-switch">
                        <input type="checkbox" name="notify_students" id="notifyStudents" value="1" checked>
                        <span class="toggle-slider"></span>
                    </label>
                    <span class="toggle-label">
                        <i class="fas fa-bell"></i>
                        Notify students about this assignment
                    </span>
                </div>
            </div>
            
            <div class="action-buttons">
                <button type="submit" class="btn-primary" id="submitBtn">
                    <i class="fas fa-plus-circle"></i>
                    Create Assignment
                </button>
                
                <a href="{{ route('instructor.course.assignments.index', $course) }}" class="btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    document.getElementById('fileInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const preview = document.getElementById('filePreview');
            const fileUploadArea = document.getElementById('fileUploadArea');
            
            fileUploadArea.style.display = 'none';
            preview.style.display = 'block';
            preview.innerHTML = `
                <div class="file-item">
                    <i class="fas fa-file-alt"></i>
                    <div class="file-info">
                        <div class="file-name">${file.name}</div>
                        <div class="file-meta">
                            <span><i class="fas fa-database"></i> ${(file.size / 1024).toFixed(2)} KB</span>
                        </div>
                    </div>
                    <button type="button" class="remove-file" onclick="removeFile()">
                        <i class="fas fa-times"></i> Remove
                    </button>
                </div>
            `;
        }
    });

    function removeFile() {
        document.getElementById('fileInput').value = '';
        document.getElementById('filePreview').style.display = 'none';
        document.getElementById('fileUploadArea').style.display = 'block';
    }

    document.getElementById('createForm')?.addEventListener('submit', function() {
        document.getElementById('loadingOverlay').style.display = 'flex';
    });
</script>
@endsection