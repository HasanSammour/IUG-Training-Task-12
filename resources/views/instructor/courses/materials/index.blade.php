@extends('layouts.app')

@section('title', 'Materials - ' . $course->title)
@section('body-class', 'instructor-page')

@section('styles')
<style>
    .materials-container {
        padding: 30px 40px;
        max-width: 1400px;
        margin: 0 auto;
        padding-bottom: 100px;
    }

    /* Header */
    .page-header {
        margin-bottom: 30px;
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

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #2D3E50;
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
    }

    .page-title i {
        color: #3182ce;
        background: rgba(49, 130, 206, 0.1);
        padding: 10px;
        border-radius: 12px;
    }

    .course-badge {
        background: #f1f5f9;
        color: #475569;
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .course-badge i {
        color: #2D3E50;
    }

    .page-subtitle {
        color: #64748b;
        font-size: 16px;
        max-width: 600px;
    }

    .btn-create {
        background: #2D3E50;
        color: white;
        padding: 12px 25px;
        border-radius: 30px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
    }

    .btn-create:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(45, 62, 80, 0.2);
    }

    /* Reorder Controls */
    .reorder-controls {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
        padding: 15px 20px;
        background: #f0f9ff;
        border-radius: 12px;
        border: 1px solid #bae6fd;
    }

    .reorder-toggle {
        display: flex;
        align-items: center;
        gap: 10px;
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

    .reorder-hint {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #0369a1;
        font-size: 14px;
        margin-left: auto;
    }

    .reorder-hint i {
        font-size: 16px;
    }

    .save-order-btn {
        background: #2D3E50;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: none;
        align-items: center;
        gap: 8px;
    }

    .save-order-btn:hover {
        background: #1a252f;
        transform: translateY(-2px);
    }

    .save-order-btn.show {
        display: inline-flex;
    }

    /* Stats Cards - UPDATED: 3 per line, 2 rows */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
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
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border-color: #2D3E50;
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
    
    .stat-icon.orange {
        background: #fed7aa;
        color: #c2410c;
    }

    .stat-icon.gray {
        background: #e2e8f0;
        color: #475569;
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        display: block;
        font-size: 28px;
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

    /* Filter Tabs */
    .filter-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        overflow-x: auto;
        padding-bottom: 5px;
        border-bottom: 1px solid #e2e8f0;
    }

    .filter-tab {
        padding: 10px 20px;
        border-radius: 30px;
        background: #f8fafc;
        color: #475569;
        font-size: 14px;
        border: 1px solid #e2e8f0;
        cursor: pointer;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .filter-tab.active {
        background: #2D3E50;
        color: white;
        border-color: #2D3E50;
    }

    .filter-tab:hover:not(.active) {
        background: #e2e8f0;
        border-color: #94a3b8;
    }

    .filter-tab i {
        font-size: 14px;
    }

    .filter-badge {
        background: rgba(255,255,255,0.2);
        color: white;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 11px;
        margin-left: 5px;
    }

    .filter-tab:not(.active) .filter-badge {
        background: #2D3E50;
        color: white;
    }

    /* Materials Grid */
    .materials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .material-card {
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .material-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        border-color: #2D3E50;
    }

    .material-card.dragging {
        opacity: 0.5;
        transform: scale(0.95);
    }

    .material-card.over {
        border: 2px dashed #2D3E50;
        transform: scale(1.02);
    }

    /* SIMPLE: Just make the whole card draggable */
    .material-card.reorder-mode {
        cursor: grab;
    }

    .material-card.reorder-mode:active {
        cursor: grabbing;
    }

    .position-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        width: 30px;
        height: 30px;
        background: #2D3E50;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 600;
        z-index: 10;
        opacity: 0;
    }

    .reorder-mode .position-badge {
        opacity: 1;
    }

    .material-header {
        padding: 20px;
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .material-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .material-icon.video { background: #fee2e2; color: #dc2626; }
    .material-icon.document { background: #dbeafe; color: #2563eb; }
    .material-icon.presentation { background: #fef3c7; color: #d97706; }
    .material-icon.link { background: #dcfce7; color: #16a34a; }
    .material-icon.other { background: #f1f5f9; color: #64748b; }

    .material-info {
        flex: 1;
    }

    .material-title {
        font-size: 16px;
        font-weight: 600;
        color: #2D3E50;
        margin-bottom: 4px;
    }

    .material-type {
        font-size: 12px;
        color: #64748b;
    }

    .material-body {
        padding: 20px;
        flex: 1;
    }

    .material-description {
        color: #475569;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 15px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .material-meta {
        display: flex;
        gap: 15px;
        font-size: 12px;
        color: #64748b;
        margin-top: 10px;
    }

    .material-meta i {
        margin-right: 5px;
        color: #94a3b8;
    }

    .material-footer {
        padding: 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 10px;
    }

    .btn-view {
        flex: 1;
        padding: 10px;
        background: #2D3E50;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-view:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45,62,80,0.15);
    }

    .btn-edit {
        padding: 10px 15px;
        background: #f1f5f9;
        color: #475569;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-edit:hover {
        background: #e2e8f0;
        border-color: #2D3E50;
        color: #2D3E50;
    }

    .btn-delete {
        padding: 10px 15px;
        background: #fee2e2;
        color: #b91c1c;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-delete:hover {
        background: #fecaca;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e1;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 20px;
        color: #2D3E50;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .empty-state p {
        color: #64748b;
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
        .materials-container {
            padding: 20px;
        }

        .header-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-create {
            width: 100%;
            justify-content: center;
        }

        .reorder-controls {
            flex-direction: column;
            align-items: flex-start;
        }

        .reorder-hint {
            margin-left: 0;
        }

        .material-footer {
            flex-direction: column;
        }

        .btn-view, .btn-edit, .btn-delete {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="materials-container">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Header -->
    <div class="page-header">
        <a href="{{ route('instructor.course-students', $course->id) }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Back to Course
        </a>

        <div class="header-top">
            <h1 class="page-title">
                <i class="fas fa-file-alt"></i>
                Course Materials
            </h1>
            <div class="course-badge">
                <i class="fas fa-book"></i>
                {{ $course->title }}
            </div>
        </div>
        <p class="page-subtitle">Manage and organize learning materials for your students</p>
    </div>

    <!-- Stats -->
    @php
        $totalMaterials = $materials->count();
        $documents = $materials->where('type', 'document')->count();
        $videos = $materials->where('type', 'video')->count();
        $presentations = $materials->where('type', 'presentation')->count();
        $links = $materials->where('type', 'link')->count();
        $others = $materials->where('type', 'other')->count();
    @endphp

    <!-- Stats Grid - 3 per line -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $totalMaterials }}</span>
                <span class="stat-label">Total Materials</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-file-pdf"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $documents }}</span>
                <span class="stat-label">Documents</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="fas fa-video"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $videos }}</span>
                <span class="stat-label">Videos</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-file-powerpoint"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $presentations }}</span>
                <span class="stat-label">Presentations</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-link"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $links }}</span>
                <span class="stat-label">Links</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon gray">
                <i class="fas fa-file"></i>
            </div>
            <div class="stat-content">
                <span class="stat-value">{{ $others }}</span>
                <span class="stat-label">Other</span>
            </div>
        </div>
    </div>

    <!-- Action Button & Reorder Controls -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
        <a href="{{ route('instructor.course.materials.create', $course) }}" class="btn-create">
            <i class="fas fa-plus"></i>
            Add New Material
        </a>

        @if($materials->count() > 1)
            <div class="reorder-controls">
                <div class="reorder-toggle">
                    <label class="toggle-switch">
                        <input type="checkbox" id="reorderToggle">
                        <span class="toggle-slider"></span>
                    </label>
                    <span class="toggle-label">Enable Reorder Mode</span>
                </div>
                <div class="reorder-hint">
                    <i class="fas fa-arrows-alt"></i>
                    <span>Drag cards to reorder</span>
                </div>
                <button class="save-order-btn" id="saveOrderBtn">
                    <i class="fas fa-save"></i>
                    Save Order
                </button>
            </div>
        @endif
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterMaterials('all')" id="filterAll">
            <i class="fas fa-th-large"></i>
            All
            <span class="filter-badge">{{ $totalMaterials }}</span>
        </button>
        <button class="filter-tab" onclick="filterMaterials('document')" id="filterDocument">
            <i class="fas fa-file-pdf"></i>
            Documents
            <span class="filter-badge">{{ $documents }}</span>
        </button>
        <button class="filter-tab" onclick="filterMaterials('video')" id="filterVideo">
            <i class="fas fa-video"></i>
            Videos
            <span class="filter-badge">{{ $videos }}</span>
        </button>
        <button class="filter-tab" onclick="filterMaterials('presentation')" id="filterPresentation">
            <i class="fas fa-file-powerpoint"></i>
            Presentations
            <span class="filter-badge">{{ $presentations }}</span>
        </button>
        <button class="filter-tab" onclick="filterMaterials('link')" id="filterLink">
            <i class="fas fa-link"></i>
            Links
            <span class="filter-badge">{{ $links }}</span>
        </button>
        <button class="filter-tab" onclick="filterMaterials('other')" id="filterOther">
            <i class="fas fa-file"></i>
            Other
            <span class="filter-badge">{{ $others }}</span>
        </button>
    </div>

    <!-- Materials Grid -->
    @if($materials->count() > 0)
        <div class="materials-grid" id="materialsGrid">
            @foreach($materials as $index => $material)
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
                
                <div class="material-card" 
                     data-id="{{ $material->id }}"
                     data-type="{{ $material->type }}"
                     data-position="{{ $index }}"
                     id="material-{{ $material->id }}">
                    
                    <div class="position-badge">
                        {{ $index + 1 }}
                    </div>

                    <div class="material-header">
                        <div class="material-icon {{ $iconClass }}">
                            <i class="fas {{ $icon }}"></i>
                        </div>
                        <div class="material-info">
                            <div class="material-title">{{ $material->title }}</div>
                            <div class="material-type">{{ ucfirst($material->type) }}</div>
                        </div>
                    </div>

                    <div class="material-body">
                        @if($material->description)
                            <div class="material-description">{{ Str::limit($material->description, 100) }}</div>
                        @endif

                        <div class="material-meta">
                            <span><i class="fas fa-clock"></i> {{ $material->created_at->format('M d, Y') }}</span>
                            @if($material->file_size)
                                <span><i class="fas fa-database"></i> {{ round($material->file_size / 1024 / 1024, 2) }} MB</span>
                            @endif
                        </div>
                    </div>

                    <div class="material-footer">
                        <a href="{{ route('instructor.course.materials.show', [$course, $material]) }}" class="btn-view">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('instructor.course.materials.edit', [$course, $material]) }}" class="btn-edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn-delete" onclick="deleteMaterial({{ $material->id }}, '{{ $material->title }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                        <form id="delete-form-{{ $material->id }}" 
                              action="{{ route('instructor.course.materials.destroy', [$course, $material]) }}" 
                              method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-file-alt"></i>
            <h3>No Materials Yet</h3>
            <p>Add your first course material to get started.</p>
            <a href="{{ route('instructor.course.materials.create', $course) }}" class="btn-create" style="display: inline-block; padding: 12px 30px;">
                <i class="fas fa-plus"></i>
                Add First Material
            </a>
        </div>
    @endif
</div>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let dragSrcElement = null;
    let reorderMode = false;
    let orderChanged = false;

    // Toggle reorder mode
    document.getElementById('reorderToggle')?.addEventListener('change', function(e) {
        reorderMode = this.checked;
        const cards = document.querySelectorAll('.material-card');
        const saveBtn = document.getElementById('saveOrderBtn');
        
        if (reorderMode) {
            cards.forEach(card => {
                card.classList.add('reorder-mode');
                card.setAttribute('draggable', 'true');
            });
            saveBtn.classList.add('show');
        } else {
            cards.forEach(card => {
                card.classList.remove('reorder-mode');
                card.setAttribute('draggable', 'false');
            });
            saveBtn.classList.remove('show');
            
            if (orderChanged) {
                Swal.fire({
                    title: 'Unsaved Changes',
                    text: 'You have unsaved order changes. Do you want to save them?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    cancelButtonText: 'Discard'
                }).then((result) => {
                    if (result.isConfirmed) {
                        saveOrder();
                    } else {
                        orderChanged = false;
                        location.reload();
                    }
                });
            }
        }
    });

    // SIMPLE: Add drag event listeners to all cards
    document.addEventListener('dragstart', function(e) {
        if (!reorderMode) return;
        
        const card = e.target.closest('.material-card');
        if (!card) return;
        
        dragSrcElement = card;
        e.dataTransfer.setData('text/plain', card.dataset.id);
        card.classList.add('dragging');
    });

    document.addEventListener('dragend', function(e) {
        const card = e.target.closest('.material-card');
        if (card) {
            card.classList.remove('dragging');
        }
    });

    document.addEventListener('dragover', function(e) {
        if (!reorderMode) return;
        e.preventDefault();
    });

    document.addEventListener('dragenter', function(e) {
        if (!reorderMode) return;
        
        const card = e.target.closest('.material-card');
        if (card && card !== dragSrcElement) {
            card.classList.add('over');
        }
    });

    document.addEventListener('dragleave', function(e) {
        if (!reorderMode) return;
        
        const card = e.target.closest('.material-card');
        if (card) {
            card.classList.remove('over');
        }
    });

    document.addEventListener('drop', function(e) {
        if (!reorderMode) return;
        e.preventDefault();
        
        const targetCard = e.target.closest('.material-card');
        if (!targetCard || !dragSrcElement || targetCard === dragSrcElement) return;
        
        targetCard.classList.remove('over');
        
        const grid = document.getElementById('materialsGrid');
        const cards = [...document.querySelectorAll('.material-card')];
        const fromIndex = cards.indexOf(dragSrcElement);
        const toIndex = cards.indexOf(targetCard);
        
        if (fromIndex < toIndex) {
            targetCard.parentNode.insertBefore(dragSrcElement, targetCard.nextSibling);
        } else {
            targetCard.parentNode.insertBefore(dragSrcElement, targetCard);
        }
        
        // Update position badges
        cards.forEach((card, index) => {
            const badge = card.querySelector('.position-badge');
            if (badge) {
                badge.textContent = index + 1;
            }
        });
        
        orderChanged = true;
    });

    // Save order
    function saveOrder() {
        const materials = [];
        document.querySelectorAll('.material-card').forEach((card, index) => {
            materials.push({
                id: card.dataset.id,
                position: index
            });
        });

        document.getElementById('loadingOverlay').style.display = 'flex';
        
        fetch('{{ route("instructor.course.materials.reorder", $course) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ materials })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('loadingOverlay').style.display = 'none';
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Order updated',
                    timer: 2000,
                    showConfirmButton: false
                });
                orderChanged = false;
            }
        })
        .catch(error => {
            document.getElementById('loadingOverlay').style.display = 'none';
            Swal.fire('Error', 'Something went wrong', 'error');
        });
    }

    document.getElementById('saveOrderBtn')?.addEventListener('click', saveOrder);

    // Filter materials
    function filterMaterials(type) {
        const materials = document.querySelectorAll('.material-card');
        materials.forEach(card => {
            const cardType = card.dataset.type;
            card.style.display = (type === 'all' || cardType === type) ? 'flex' : 'none';
        });

        document.querySelectorAll('.filter-tab').forEach(btn => btn.classList.remove('active'));
        document.getElementById(`filter${type.charAt(0).toUpperCase() + type.slice(1)}`).classList.add('active');
    }

    // Delete material
    function deleteMaterial(materialId, materialTitle) {
        Swal.fire({
            title: 'Delete Material?',
            html: `Are you sure you want to delete <strong>"${materialTitle}"</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('loadingOverlay').style.display = 'flex';
                document.getElementById(`delete-form-${materialId}`).submit();
            }
        });
    }
</script>
@endsection