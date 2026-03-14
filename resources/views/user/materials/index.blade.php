@extends('layouts.app')

@section('title', $course->title . ' - Materials')
@section('body-class', 'auth-page')

@section('styles')
<style>
    .materials-container {
        padding: 30px 40px;
        max-width: 1400px;
        margin: 0 auto;
        padding-bottom: 100px;
    }

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
        margin-bottom: 15px;
        transition: color 0.3s ease;
    }

    .back-link:hover {
        color: #2D3E50;
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

    .stats-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 30px;
    }

    .stats-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: #dbeafe;
        color: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stats-content .value {
        font-size: 28px;
        font-weight: 700;
        color: #2D3E50;
        line-height: 1.2;
    }

    .stats-content .label {
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
    }

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

    .materials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .material-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 15px;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }

    .material-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border-color: #2D3E50;
    }

    .material-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
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
        margin-bottom: 5px;
        line-height: 1.4;
    }

    .material-meta {
        display: flex;
        gap: 10px;
        font-size: 11px;
        color: #64748b;
    }

    .material-meta i {
        margin-right: 3px;
    }

    .material-download {
        color: #64748b;
        transition: color 0.3s ease;
    }

    .material-card:hover .material-download {
        color: #3182ce;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        grid-column: 1 / -1;
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
    }

    .empty-state p {
        color: #64748b;
        margin-bottom: 25px;
    }

    @media (max-width: 768px) {
        .materials-container {
            padding: 20px;
        }

        .header-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .materials-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="materials-container">
    <div class="page-header">
        <a href="{{ route('courses.progress', $enrollment->id ?? '') }}" class="back-link">
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
    </div>

    <div class="stats-card">
        <div class="stats-icon">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="stats-content">
            <span class="value">{{ $materials->total() }}</span>
            <span class="label">Total Materials</span>
        </div>
    </div>

    <div class="filter-tabs">
        <button class="filter-tab active" onclick="filterMaterials('all')">All</button>
        <button class="filter-tab" onclick="filterMaterials('document')">Documents</button>
        <button class="filter-tab" onclick="filterMaterials('video')">Videos</button>
        <button class="filter-tab" onclick="filterMaterials('presentation')">Presentations</button>
        <button class="filter-tab" onclick="filterMaterials('link')">Links</button>
    </div>

    @if($materials->count() > 0)
        <div class="materials-grid" id="materialsGrid">
            @foreach($materials as $material)
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
                
                <a href="{{ $material->type == 'link' ? $material->external_link : route('courses.materials.show', [$course->id, $material->id]) }}" 
                   class="material-card"
                   @if($material->type == 'link') target="_blank" @endif
                   data-type="{{ $material->type }}">
                    <div class="material-icon {{ $iconClass }}">
                        <i class="fas {{ $icon }}"></i>
                    </div>
                    <div class="material-info">
                        <div class="material-title">{{ $material->title }}</div>
                        <div class="material-meta">
                            <span><i class="fas fa-tag"></i> {{ ucfirst($material->type) }}</span>
                            @if($material->file_size)
                                <span><i class="fas fa-database"></i> {{ round($material->file_size / 1024 / 1024, 2) }} MB</span>
                            @endif
                        </div>
                    </div>
                    <i class="fas fa-{{ $material->type == 'link' ? 'external-link-alt' : 'download' }} material-download"></i>
                </a>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $materials->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-file-alt"></i>
            <h3>No Materials Yet</h3>
            <p>The instructor hasn't shared any materials for this course yet.</p>
            <a href="{{ route('courses.show', $course->slug) }}" class="btn-primary" style="display: inline-block; padding: 12px 30px; background: #2D3E50; color: white; text-decoration: none; border-radius: 8px;">
                <i class="fas fa-info-circle"></i> Course Details
            </a>
        </div>
    @endif
</div>

<script>
    function filterMaterials(type) {
        const materials = document.querySelectorAll('.material-card');
        
        materials.forEach(card => {
            if (type === 'all' || card.dataset.type === type) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
        
        // Update active tab
        document.querySelectorAll('.filter-tab').forEach(btn => {
            btn.classList.remove('active');
            if (btn.textContent.trim().toLowerCase() === type || 
                (type === 'all' && btn.textContent.trim() === 'All')) {
                btn.classList.add('active');
            }
        });
    }
</script>
@endsection