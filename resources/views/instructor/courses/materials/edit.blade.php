@extends('layouts.app')

@section('title', 'Edit Material')
@section('body-class', 'instructor-page')

@section('styles')
<style>
    .material-container {
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

    .material-card {
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
        min-height: 120px;
        resize: vertical;
    }

    .type-selector {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    @media (max-width: 640px) {
        .type-selector {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .type-option {
        position: relative;
    }

    .type-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .type-option label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        padding: 20px 15px;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin: 0;
    }

    .type-option input[type="radio"]:checked + label {
        border-color: #2D3E50;
        background: #f0f7ff;
        box-shadow: 0 4px 12px rgba(45,62,80,0.1);
    }

    .type-option label i {
        font-size: 32px;
        color: #2D3E50;
    }

    .type-option label span {
        font-size: 14px;
        font-weight: 600;
        color: #2D3E50;
    }

    .current-file {
        background: #f1f5f9;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        border: 1px solid #e2e8f0;
    }

    .current-file i {
        font-size: 32px;
        color: #2563eb;
    }

    .file-info {
        flex: 1;
    }

    .file-name {
        font-size: 15px;
        font-weight: 600;
        color: #2D3E50;
        margin-bottom: 4px;
        word-break: break-all;
    }

    .file-meta {
        font-size: 12px;
        color: #64748b;
        display: flex;
        gap: 15px;
    }

    .remove-file-btn {
        background: #fee2e2;
        color: #b91c1c;
        border: none;
        padding: 8px 15px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .remove-file-btn:hover {
        background: #fecaca;
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
        display: none;
    }

    .file-upload-area.show {
        display: block;
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
        display: none;
    }

    .file-preview.show {
        display: block;
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

    .remove-new-file {
        background: #fee2e2;
        color: #b91c1c;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
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

    .btn-danger {
        padding: 14px 25px;
        background: #fee2e2;
        color: #b91c1c;
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

    .btn-danger:hover {
        background: #fecaca;
        transform: translateY(-2px);
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
        .material-container {
            padding: 20px;
        }

        .material-card {
            padding: 25px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-primary, .btn-secondary, .btn-danger {
            width: 100%;
        }

        .type-selector {
            grid-template-columns: 1fr;
        }

        .current-file {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endsection

@section('content')
<div class="material-container">
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <div class="page-header">
        <a href="{{ route('instructor.course.materials.index', $course) }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Back to Materials
        </a>
        
        <h1 class="page-title">
            <i class="fas fa-edit"></i>
            Edit Material
        </h1>
        
        <div class="course-badge">
            <i class="fas fa-book"></i>
            {{ $course->title }}
        </div>
    </div>

    <div class="material-card">
        <form method="POST" action="{{ route('instructor.course.materials.update', [$course, $material]) }}" enctype="multipart/form-data" id="editForm">
            @csrf
            @method('PUT')
            
            <div class="section-title">
                <i class="fas fa-info-circle"></i>
                Basic Information
            </div>
            
            <div class="form-group">
                <label>
                    <i class="fas fa-heading"></i>
                    Material Title
                </label>
                <input type="text" name="title" class="form-control" value="{{ old('title', $material->title) }}" required>
                @error('title')
                    <span style="color: #dc2626; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label>
                    <i class="fas fa-align-left"></i>
                    Description (Optional)
                </label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $material->description) }}</textarea>
                @error('description')
                    <span style="color: #dc2626; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="section-title" style="margin-top: 30px;">
                <i class="fas fa-tag"></i>
                Material Type
            </div>
            
            <div class="type-selector">
                <div class="type-option">
                    <input type="radio" name="type" id="type-document" value="document" {{ $material->type == 'document' ? 'checked' : '' }}>
                    <label for="type-document">
                        <i class="fas fa-file-pdf"></i>
                        <span>Document</span>
                    </label>
                </div>
                <div class="type-option">
                    <input type="radio" name="type" id="type-video" value="video" {{ $material->type == 'video' ? 'checked' : '' }}>
                    <label for="type-video">
                        <i class="fas fa-video"></i>
                        <span>Video</span>
                    </label>
                </div>
                <div class="type-option">
                    <input type="radio" name="type" id="type-presentation" value="presentation" {{ $material->type == 'presentation' ? 'checked' : '' }}>
                    <label for="type-presentation">
                        <i class="fas fa-file-powerpoint"></i>
                        <span>Presentation</span>
                    </label>
                </div>
                <div class="type-option">
                    <input type="radio" name="type" id="type-link" value="link" {{ $material->type == 'link' ? 'checked' : '' }}>
                    <label for="type-link">
                        <i class="fas fa-link"></i>
                        <span>External Link</span>
                    </label>
                </div>
                <div class="type-option">
                    <input type="radio" name="type" id="type-other" value="other" {{ $material->type == 'other' ? 'checked' : '' }}>
                    <label for="type-other">
                        <i class="fas fa-file"></i>
                        <span>Other</span>
                    </label>
                </div>
            </div>
            
            @if($material->type != 'link' && $material->file_path)
                <div class="current-file" id="currentFile">
                    <i class="fas fa-file-alt"></i>
                    <div class="file-info">
                        <div class="file-name">{{ basename($material->file_path) }}</div>
                        <div class="file-meta">
                            <span><i class="fas fa-database"></i> 
                                @php
                                    $size = Storage::disk('public')->exists($material->file_path) 
                                        ? round(Storage::disk('public')->size($material->file_path) / 1024 / 1024, 2) . ' MB'
                                        : 'Unknown';
                                @endphp
                                {{ $size }}
                            </span>
                            <span><i class="fas fa-calendar-alt"></i> Uploaded: {{ $material->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    <button type="button" class="remove-file-btn" onclick="removeCurrentFile()">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
                <input type="hidden" name="remove_current_file" id="removeCurrentFile" value="0">
            @endif
            
            <div id="fileUploadSection" style="{{ $material->type == 'link' ? 'display: none;' : 'display: block;' }}">
                <div class="section-title" style="margin-top: 30px;">
                    <i class="fas fa-cloud-upload-alt"></i>
                    Upload New File (Optional)
                </div>
                
                <div class="form-group">
                    <div class="file-upload-area" id="fileUploadArea" class="{{ $material->file_path ? '' : 'show' }}">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p>Click to upload new file</p>
                        <small>Supported: PDF, DOC, DOCX, PPT, MP4, ZIP (Max: 50MB)</small>
                        <input type="file" name="file" class="file-input" id="fileInput" accept=".pdf,.doc,.docx,.ppt,.pptx,.mp4,.zip">
                    </div>
                    
                    <div id="filePreview" class="file-preview"></div>
                    
                    @error('file')
                        <span style="color: #dc2626; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div id="linkSection" style="{{ $material->type == 'link' ? 'display: block;' : 'display: none;' }}">
                <div class="section-title" style="margin-top: 30px;">
                    <i class="fas fa-link"></i>
                    External Link
                </div>
                
                <div class="form-group">
                    <label>
                        <i class="fas fa-globe"></i>
                        URL
                    </label>
                    <input type="url" name="external_link" class="form-control" value="{{ old('external_link', $material->external_link) }}" placeholder="https://...">
                    @error('external_link')
                        <span style="color: #dc2626; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="section-title" style="margin-top: 30px;">
                <i class="fas fa-sort"></i>
                Display Order
            </div>
            
            <div class="form-group">
                <label>
                    <i class="fas fa-sort-numeric-down"></i>
                    Order Position
                </label>
                <input type="number" name="order_position" class="form-control" value="{{ old('order_position', $material->order_position) }}" min="0">
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
                        Notify students about this update
                    </span>
                </div>
            </div>
            
            <div class="action-buttons">
                <button type="submit" class="btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i>
                    Update Material
                </button>
                
                <a href="{{ route('instructor.course.materials.index', $course) }}" class="btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
                
                <button type="button" class="btn-danger" onclick="deleteMaterial()">
                    <i class="fas fa-trash"></i>
                    Delete
                </button>
            </div>
        </form>
        
        <form id="deleteForm" action="{{ route('instructor.course.materials.destroy', [$course, $material]) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const fileSection = document.getElementById('fileUploadSection');
            const linkSection = document.getElementById('linkSection');
            
            if (this.value === 'link') {
                fileSection.style.display = 'none';
                linkSection.style.display = 'block';
            } else {
                fileSection.style.display = 'block';
                linkSection.style.display = 'none';
            }
        });
    });

    document.getElementById('fileInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const preview = document.getElementById('filePreview');
            preview.classList.add('show');
            preview.innerHTML = `
                <div class="file-item">
                    <i class="fas fa-file-alt"></i>
                    <div class="file-info">
                        <div class="file-name">${file.name}</div>
                        <div class="file-meta">
                            <span><i class="fas fa-database"></i> ${(file.size / 1024 / 1024).toFixed(2)} MB</span>
                        </div>
                    </div>
                    <button type="button" class="remove-new-file" onclick="removeNewFile()">
                        <i class="fas fa-times"></i> Remove
                    </button>
                </div>
            `;
        }
    });

    function removeNewFile() {
        document.getElementById('fileInput').value = '';
        document.getElementById('filePreview').classList.remove('show');
        document.getElementById('filePreview').innerHTML = '';
    }

    function removeCurrentFile() {
        Swal.fire({
            title: 'Remove File?',
            text: 'Are you sure you want to remove the current file?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, remove it'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('currentFile').style.display = 'none';
                document.getElementById('fileUploadArea').classList.add('show');
                document.getElementById('removeCurrentFile').value = '1';
            }
        });
    }

    function deleteMaterial() {
        Swal.fire({
            title: 'Delete Material?',
            html: `Are you sure you want to delete <strong>"{{ $material->title }}"</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('loadingOverlay').style.display = 'flex';
                document.getElementById('deleteForm').submit();
            }
        });
    }

    document.getElementById('editForm')?.addEventListener('submit', function() {
        document.getElementById('loadingOverlay').style.display = 'flex';
    });
</script>
@endsection