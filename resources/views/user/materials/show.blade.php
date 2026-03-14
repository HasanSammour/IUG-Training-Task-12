@extends('layouts.app')

@section('title', $material->title . ' - Material')
@section('body-class', 'auth-page')

@section('styles')
<style>
    .material-container {
        padding: 30px 40px;
        max-width: 1000px;
        margin: 0 auto;
        padding-bottom: 100px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 20px;
        transition: color 0.3s ease;
    }

    .back-link:hover {
        color: #2D3E50;
    }

    .material-card {
        background: white;
        border-radius: 24px;
        padding: 40px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .material-header {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .material-icon-large {
        width: 80px;
        height: 80px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
    }

    .material-icon-large.video { background: #fee2e2; color: #dc2626; }
    .material-icon-large.document { background: #dbeafe; color: #2563eb; }
    .material-icon-large.presentation { background: #fef3c7; color: #d97706; }
    .material-icon-large.link { background: #dcfce7; color: #16a34a; }
    .material-icon-large.other { background: #f1f5f9; color: #64748b; }

    .material-info {
        flex: 1;
    }

    .material-title {
        font-size: 28px;
        color: #2D3E50;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .material-meta {
        display: flex;
        gap: 20px;
        color: #64748b;
        font-size: 14px;
    }

    .material-meta i {
        margin-right: 5px;
    }

    .material-description {
        margin-bottom: 40px;
        padding: 25px;
        background: #f8fafc;
        border-radius: 16px;
        border-left: 4px solid #3182ce;
    }

    .description-title {
        font-size: 16px;
        font-weight: 600;
        color: #2D3E50;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .description-text {
        color: #475569;
        font-size: 15px;
        line-height: 1.7;
        white-space: pre-wrap;
    }

    .preview-section {
        margin-top: 30px;
        padding: 30px;
        background: #f8fafc;
        border-radius: 16px;
    }

    .preview-title {
        font-size: 18px;
        color: #2D3E50;
        margin-bottom: 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .video-container {
        width: 100%;
        aspect-ratio: 16 / 9;
        background: #1e293b;
        border-radius: 12px;
        overflow: hidden;
    }

    .video-container iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    .video-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        background: linear-gradient(135deg, #1e293b, #0f172a);
    }

    .video-placeholder i {
        font-size: 48px;
        color: #475569;
        margin-bottom: 15px;
    }

    .document-preview {
        text-align: center;
        padding: 40px;
        background: white;
        border-radius: 12px;
        border: 2px dashed #e2e8f0;
    }

    .document-icon-large {
        width: 100px;
        height: 100px;
        background: #dbeafe;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        font-size: 48px;
        margin: 0 auto 20px;
    }

    .document-preview p {
        color: #64748b;
        margin-bottom: 20px;
    }

    .link-preview {
        text-align: center;
        padding: 40px;
        background: white;
        border-radius: 12px;
    }

    .link-icon-large {
        width: 90px;
        height: 90px;
        background: #dcfce7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #16a34a;
        font-size: 36px;
        margin: 0 auto 20px;
    }

    .link-url {
        color: #3182ce;
        text-decoration: none;
        font-size: 16px;
        word-break: break-all;
    }

    .link-url:hover {
        text-decoration: underline;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
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
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-primary:hover {
        background: #1a252f;
        transform: translateY(-2px);
    }

    .btn-secondary {
        flex: 1;
        padding: 14px 25px;
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
        gap: 10px;
    }

    .btn-secondary:hover {
        background: #f8fafc;
        border-color: #2D3E50;
        color: #2D3E50;
    }

    .file-info {
        margin-top: 20px;
        padding: 15px;
        background: #f1f5f9;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .file-size {
        display: flex;
        align-items: center;
        gap: 5px;
        color: #64748b;
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .material-container {
            padding: 20px;
        }

        .material-card {
            padding: 25px;
        }

        .material-header {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .material-title {
            font-size: 24px;
        }

        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<div class="material-container">
    <a href="{{ route('courses.materials.index', $course->id) }}" class="back-link">
        <i class="fas fa-arrow-left"></i>
        Back to Materials
    </a>

    <div class="material-card">
        <div class="material-header">
            @php
                $iconClass = match($material->type) {
                    'video' => 'video',
                    'document' => 'document',
                    'presentation' => 'presentation',
                    'link' => 'link',
                    default => 'other'
                };
                
                $icon = match($material->type) {
                    'video' => 'fa-video',
                    'document' => 'fa-file-pdf',
                    'presentation' => 'fa-file-powerpoint',
                    'link' => 'fa-link',
                    default => 'fa-file'
                };
            @endphp
            
            <div class="material-icon-large {{ $iconClass }}">
                <i class="fas {{ $icon }}"></i>
            </div>

            <div class="material-info">
                <h1 class="material-title">{{ $material->title }}</h1>
                <div class="material-meta">
                    <span><i class="fas fa-tag"></i> {{ ucfirst($material->type) }}</span>
                    <span><i class="fas fa-clock"></i> Added {{ $material->created_at->diffForHumans() }}</span>
                    @if($material->file_size)
                        <span><i class="fas fa-database"></i> {{ round($material->file_size / 1024 / 1024, 2) }} MB</span>
                    @endif
                </div>
            </div>
        </div>

        @if($material->description)
            <div class="material-description">
                <h3 class="description-title">
                    <i class="fas fa-align-left"></i>
                    Description
                </h3>
                <div class="description-text">{{ $material->description }}</div>
            </div>
        @endif

        <div class="preview-section">
            <h3 class="preview-title">
                <i class="fas fa-eye"></i>
                Preview
            </h3>

            @if($material->type === 'video')
                <div class="video-container">
                    @if($material->embed_code)
                        <iframe src="{{ $material->embed_code }}" allowfullscreen></iframe>
                    @elseif($material->file_path)
                        <video controls style="width: 100%; height: 100%;">
                            <source src="{{ Storage::url($material->file_path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <div class="video-placeholder">
                            <i class="fas fa-play-circle"></i>
                            <p>Video preview not available</p>
                        </div>
                    @endif
                </div>

            @elseif($material->type === 'link')
                <div class="link-preview">
                    <div class="link-icon-large">
                        <i class="fas fa-link"></i>
                    </div>
                    <a href="{{ $material->external_link }}" target="_blank" class="link-url">
                        {{ $material->external_link }}
                    </a>
                </div>

            @elseif(in_array($material->type, ['document', 'presentation']))
                <div class="document-preview">
                    <div class="document-icon-large">
                        <i class="fas {{ $material->type === 'presentation' ? 'fa-file-powerpoint' : 'fa-file-pdf' }}"></i>
                    </div>
                    <p>Preview is not available for this file type</p>
                    @if($material->file_path)
                        <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="btn-primary" style="display: inline-block; padding: 12px 30px; text-decoration: none;">
                            <i class="fas fa-eye"></i> Open File
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <div class="action-buttons">
            @if($material->type === 'link')
                <a href="{{ $material->external_link }}" target="_blank" class="btn-primary">
                    <i class="fas fa-external-link-alt"></i>
                    Open Link
                </a>
            @elseif($material->file_path)
                <a href="{{ route('courses.materials.download', [$course->id, $material->id]) }}" class="btn-primary">
                    <i class="fas fa-download"></i>
                    Download
                </a>
            @endif
            
            <a href="{{ route('courses.materials.index', $course->id) }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Materials
            </a>
        </div>

        @if($material->file_path)
            <div class="file-info">
                <i class="fas fa-file"></i>
                <span>Filename: {{ basename($material->file_path) }}</span>
                @if($material->file_size)
                    <span class="file-size">
                        <i class="fas fa-database"></i> {{ round($material->file_size / 1024 / 1024, 2) }} MB
                    </span>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection