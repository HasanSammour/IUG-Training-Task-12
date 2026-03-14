@extends('layouts.app')

@section('title', $material->title)
@section('body-class', 'instructor-page')

@section('styles')
<style>
    .instructor-page {
        background-color: #f8fbff;
    }

    .material-container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 40px;
        padding-bottom: 100px;
    }

    /* Back Link */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        text-decoration: none;
        margin-bottom: 25px;
        padding: 8px 16px;
        background: white;
        border-radius: 30px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        font-size: 14px;
        font-weight: 500;
    }

    .back-link:hover {
        color: #2D3E50;
        background: #f8fafc;
        border-color: #2D3E50;
        transform: translateX(-3px);
    }

    .back-link i {
        font-size: 12px;
    }

    /* Main Card */
    .material-card {
        background: white;
        border-radius: 24px;
        padding: 40px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        width: 100%;
    }

    /* Header Section */
    .material-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 30px;
        gap: 20px;
    }

    .material-title-section {
        flex: 1;
    }

    .material-title {
        font-size: 32px;
        color: #2D3E50;
        font-weight: 700;
        margin-bottom: 12px;
        line-height: 1.2;
    }

    .material-meta {
        display: flex;
        gap: 25px;
        color: #64748b;
        font-size: 14px;
        flex-wrap: wrap;
    }

    .material-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .material-meta i {
        color: #3182ce;
        font-size: 14px;
    }

    .material-icon-large {
        width: 90px;
        height: 90px;
        background: linear-gradient(135deg, #e0f2fe, #bae6fd);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0284c7;
        font-size: 42px;
        flex-shrink: 0;
        box-shadow: 0 8px 20px rgba(2, 132, 199, 0.15);
        border: 1px solid rgba(255,255,255,0.5);
    }

    /* Description Section */
    .material-description {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 35px;
        border-left: 4px solid #3182ce;
        line-height: 1.7;
    }

    .material-description h3 {
        font-size: 16px;
        font-weight: 600;
        color: #2D3E50;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .material-description h3 i {
        color: #3182ce;
    }

    .material-description p {
        color: #475569;
        font-size: 15px;
        margin: 0;
        white-space: pre-wrap;
    }

    /* Preview Section */
    .material-preview {
        margin-bottom: 35px;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }

    .preview-header {
        background: #f8fafc;
        padding: 15px 25px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .preview-header h3 {
        font-size: 16px;
        font-weight: 600;
        color: #2D3E50;
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }

    .preview-header h3 i {
        color: #3182ce;
    }

    .preview-content {
        padding: 30px;
        background: #ffffff;
        min-height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Video Preview */
    .video-preview {
        width: 100%;
        height: auto;
        background: #0f172a;
        border-radius: 12px;
        overflow: hidden;
        position: relative;
    }

    .video-embed {
        width: 100%;
        aspect-ratio: 16 / 9;
        border: none;
        background: #000;
    }

    .video-placeholder {
        width: 100%;
        aspect-ratio: 16 / 9;
        background: linear-gradient(135deg, #1e293b, #0f172a);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: white;
        position: relative;
    }

    .video-placeholder i {
        font-size: 70px;
        color: rgba(255, 255, 255, 0.2);
        margin-bottom: 15px;
    }

    .video-placeholder p {
        color: rgba(255, 255, 255, 0.7);
        font-size: 16px;
        margin-bottom: 20px;
    }

    .video-placeholder .btn-play {
        background: #3182ce;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 30px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }

    .video-placeholder .btn-play:hover {
        background: #2563eb;
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
    }

    /* Document Preview */
    .document-preview {
        text-align: center;
        padding: 50px;
        background: #f8fafc;
        border-radius: 16px;
        border: 2px dashed #cbd5e1;
        width: 100%;
    }

    .document-icon-large {
        width: 100px;
        height: 100px;
        background: #e0f2fe;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0284c7;
        font-size: 48px;
        margin: 0 auto 25px;
        box-shadow: 0 10px 25px rgba(2, 132, 199, 0.2);
    }

    .document-preview h4 {
        font-size: 20px;
        color: #2D3E50;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .document-preview p {
        color: #64748b;
        margin-bottom: 25px;
        font-size: 14px;
    }

    /* Link Preview */
    .link-preview {
        text-align: center;
        padding: 40px;
        background: #f8fafc;
        border-radius: 16px;
        width: 100%;
    }

    .link-icon-large {
        width: 90px;
        height: 90px;
        background: #dbeafe;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2563eb;
        font-size: 36px;
        margin: 0 auto 20px;
    }

    .link-url-display {
        background: white;
        padding: 15px 20px;
        border-radius: 30px;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        max-width: 100%;
        overflow: hidden;
    }

    .link-url {
        color: #2563eb;
        text-decoration: none;
        font-size: 14px;
        word-break: break-all;
    }

    .link-url:hover {
        text-decoration: underline;
    }

    .link-favicon {
        width: 20px;
        height: 20px;
        background: #e2e8f0;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        color: #475569;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #e2e8f0;
        flex-wrap: wrap;
    }

    .btn {
        padding: 12px 25px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        border: none;
    }

    .btn-share {
        background: #2563eb;
        color: white;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    .btn-share:hover {
        background: #1d4ed8;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
    }

    .btn-edit {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #cbd5e1;
    }

    .btn-edit:hover {
        background: #e2e8f0;
        color: #2D3E50;
        transform: translateY(-2px);
    }

    .btn-download {
        background: #2D3E50;
        color: white;
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.2);
    }

    .btn-download:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(45, 62, 80, 0.3);
    }

    .btn-download i, .btn-share i, .btn-edit i {
        font-size: 14px;
    }

    /* File Info */
    .file-info {
        background: #f1f5f9;
        border-radius: 12px;
        padding: 15px 20px;
        margin-top: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .file-size {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #475569;
        font-size: 13px;
    }

    .file-size i {
        color: #64748b;
    }

    /* Loading Overlay (reuse from parent) */
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
        border-top-color: #2D3E50;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .material-container {
            padding: 15px;
        }

        .material-card {
            padding: 25px;
        }

        .material-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .material-icon-large {
            width: 70px;
            height: 70px;
            font-size: 32px;
        }

        .material-title {
            font-size: 24px;
        }

        .material-meta {
            gap: 15px;
        }

        .preview-content {
            padding: 20px;
        }

        .document-preview {
            padding: 30px 20px;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .file-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
    }
</style>
@endsection

@section('content')
<div class="material-container">
    <!-- Back Link -->
    <a href="{{ route('instructor.course.materials.index', $course->id) }}?tab=materials" class="back-link">
        <i class="fas fa-arrow-left"></i> Back to Course Materials
    </a>

    <!-- Main Card -->
    <div class="material-card">
        <!-- Header -->
        <div class="material-header">
            <div class="material-title-section">
                <h1 class="material-title">{{ $material->title }}</h1>
                <div class="material-meta">
                    <span><i class="fas fa-tag"></i> {{ ucfirst($material->type) }}</span>
                    <span><i class="fas fa-clock"></i> Added {{ $material->created_at->diffForHumans() }}</span>
                    @if($material->file_size)
                        <span><i class="fas fa-database"></i> {{ $material->file_size }}</span>
                    @endif
                </div>
            </div>
            <div class="material-icon-large">
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
        </div>

        <!-- Description -->
        @if($material->description)
            <div class="material-description">
                <h3><i class="fas fa-align-left"></i> Description</h3>
                <p>{{ $material->description }}</p>
            </div>
        @endif

        <!-- Preview Section -->
        <div class="material-preview">
            <div class="preview-header">
                <h3><i class="fas fa-eye"></i> Preview</h3>
                @if($material->type !== 'link' && $material->file_path)
                    <span class="file-size">
                        <i class="fas fa-file"></i> 
                        {{ pathinfo($material->file_path, PATHINFO_EXTENSION) }} file
                    </span>
                @endif
            </div>
            <div class="preview-content">
                @if($material->type === 'link')
                    <!-- Link Preview -->
                    <div class="link-preview">
                        <div class="link-icon-large">
                            <i class="fas fa-link"></i>
                        </div>
                        <h4>External Resource</h4>
                        <div class="link-url-display">
                            <span class="link-favicon">
                                <i class="fas fa-globe"></i>
                            </span>
                            <a href="{{ $material->external_link }}" target="_blank" class="link-url">
                                {{ $material->external_link }}
                            </a>
                        </div>
                        <a href="{{ $material->external_link }}" target="_blank" class="btn btn-download">
                            <i class="fas fa-external-link-alt"></i> Open Link
                        </a>
                    </div>

                @elseif($material->type === 'video')
                    <!-- Video Preview -->
                    <div class="video-preview">
                        @if($material->embed_code)
                            <!-- Embedded Video (YouTube/Vimeo) -->
                            <iframe class="video-embed" 
                                    src="{{ $material->embed_code }}" 
                                    title="{{ $material->title }}"
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen>
                            </iframe>
                        @elseif($material->file_path && $material->is_video)
                            <!-- HTML5 Video Player -->
                            <video controls class="video-embed" preload="metadata">
                                <source src="{{ asset('storage/' . $material->file_path) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <!-- Video Placeholder -->
                            <div class="video-placeholder">
                                <i class="fas fa-play-circle"></i>
                                <p>Video preview not available</p>
                                @if($material->file_path)
                                    <a href="{{ asset('storage/' . $material->file_path) }}" 
                                       target="_blank" 
                                       class="btn-play">
                                        <i class="fas fa-download"></i> Download Video
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                @elseif($material->type === 'presentation')
                    <!-- Presentation Preview -->
                    <div class="document-preview">
                        <div class="document-icon-large">
                            <i class="fas fa-file-powerpoint"></i>
                        </div>
                        <h4>{{ $material->title }}</h4>
                        <p>PowerPoint Presentation</p>
                        @if($material->file_path)
                            <a href="{{ asset('storage/' . $material->file_path) }}" 
                               target="_blank" 
                               class="btn btn-download">
                                <i class="fas fa-download"></i> Download Presentation
                            </a>
                        @endif
                    </div>

                @elseif($material->type === 'document')
                    <!-- Document Preview -->
                    <div class="document-preview">
                        <div class="document-icon-large">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <h4>{{ $material->title }}</h4>
                        <p>PDF Document</p>
                        @if($material->file_path)
                            <a href="{{ asset('storage/' . $material->file_path) }}" 
                               target="_blank" 
                               class="btn btn-download">
                                <i class="fas fa-download"></i> Download PDF
                            </a>
                        @endif
                    </div>

                @else
                    <!-- Default File Preview -->
                    <div class="document-preview">
                        <div class="document-icon-large">
                            <i class="fas fa-file"></i>
                        </div>
                        <h4>{{ $material->title }}</h4>
                        <p>File</p>
                        @if($material->file_path)
                            <a href="{{ asset('storage/' . $material->file_path) }}" 
                               target="_blank" 
                               class="btn btn-download">
                                <i class="fas fa-download"></i> Download File
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- File Info (if applicable) -->
        @if($material->file_path && $material->file_size)
            <div class="file-info">
                <span class="file-size">
                    <i class="fas fa-file"></i> Filename: {{ basename($material->file_path) }}
                </span>
                <span class="file-size">
                    <i class="fas fa-database"></i> Size: {{ $material->file_size }}
                </span>
                <span class="file-size">
                    <i class="fas fa-calendar"></i> Uploaded: {{ $material->created_at->format('M d, Y') }}
                </span>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn btn-share" onclick="shareMaterial({{ $material->id }})">
                <i class="fas fa-share-alt"></i> Share with Students
            </button>
            <a href="{{ route('instructor.course.materials.edit', [$course->id, $material->id]) }}" class="btn btn-edit">
                <i class="fas fa-edit"></i> Edit Material
            </a>
        </div>
    </div>
</div>

<!-- Loading Overlay (ensure this exists in your layout or add it) -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
            cancelButtonColor: '#6c757d',
            inputAttributes: {
                'aria-label': 'Type your message here'
            }
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
                        message: result.value || '' 
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
                            title: 'Shared!',
                            text: data.message || 'Material shared successfully',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Failed to share material',
                            confirmButtonColor: '#2d3e50'
                        });
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
                });
            }
        });
    }
</script>
@endsection