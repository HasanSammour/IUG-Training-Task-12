@extends('layouts.app')

@section('title', 'Categories - Shifra Admin')
@section('body-class', 'admin-page')

@section('styles')
    <style>
        .admin-container {
            padding: 30px 20px;
            background-color: #f8fbff;
            min-height: calc(100vh - 150px);
            max-width: 1600px;
            margin: 0 auto;
            width: 95%;
        }

        /* Header */
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px;
            background: linear-gradient(135deg, #fff 0%, #f8fafc 100%);
            border-radius: 16px;
            margin-bottom: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }

        .admin-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #2D3E50 0%, #3B82F6 100%);
        }

        .admin-title {
            font-size: 26px;
            font-weight: 700;
            color: #2D3E50;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-title i {
            color: #3B82F6;
            background: rgba(59, 130, 246, 0.1);
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn-add {
            background: linear-gradient(135deg, #2D3E50 0%, #1a252f 100%);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            font-size: 15px;
            box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(45, 62, 80, 0.2);
        }

        /* Filters */
        .filters-section {
            background: white;
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
        }

        .filter-form {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto auto;
            gap: 15px;
            align-items: end;
        }

        @media (max-width: 1024px) {
            .filter-form {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .filter-form {
                grid-template-columns: 1fr;
            }
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .search-box {
            position: relative;
        }

        .search-box i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 15px;
        }

        .search-input {
            width: 100%;
            padding: 14px 14px 14px 48px;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #2D3E50;
            background: white;
            box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
        }

        .filter-select {
            padding: 14px;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            background: #f8fafc;
            color: #2D3E50;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%232D3E50' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 16px;
            padding-right: 40px;
        }

        .filter-btn {
            padding: 14px 24px;
            border-radius: 10px;
            border: none;
            background: linear-gradient(135deg, #2D3E50 0%, #1a252f 100%);
            color: white;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            font-size: 14px;
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
        }

        .btn-clear {
            padding: 14px 24px;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            background: white;
            color: #64748b;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 14px;
            white-space: nowrap;
        }

        /* Categories Grid */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        @media (min-width: 1400px) {
            .categories-grid {
                grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .categories-grid {
                grid-template-columns: 1fr;
            }
        }

        .category-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            border: 1.5px solid #e2e8f0;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: #2D3E50;
        }

        .category-gradient {
            height: 4px;
            background: linear-gradient(90deg, #3B82F6 0%, #8B5CF6 100%);
            transition: all 0.3s ease;
        }

        .category-card:hover .category-gradient {
            height: 6px;
        }

        .category-content {
            padding: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .category-header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .category-icon-container {
            width: 64px;
            height: 64px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            transition: all 0.3s ease;
        }

        .category-card:hover .category-icon-container {
            transform: scale(1.05) rotate(5deg);
        }

        .category-info {
            flex: 1;
            min-width: 0;
        }

        .category-name {
            font-size: 18px;
            font-weight: 700;
            color: #2D3E50;
            margin-bottom: 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .category-slug {
            font-size: 13px;
            color: #94a3b8;
            background: #f8fafc;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
            font-family: 'Courier New', monospace;
        }

        .category-description {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .category-color {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            padding: 10px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .color-badge {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        }

        .color-text {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
        }

        .category-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 20px;
            border-top: 1.5px solid #f1f5f9;
        }

        .category-stats {
            display: flex;
            gap: 20px;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .stat-value {
            font-size: 18px;
            font-weight: 700;
            color: #2D3E50;
            margin-bottom: 2px;
            line-height: 1;
        }

        .stat-label {
            font-size: 11px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            font-weight: 600;
        }

        .category-actions {
            display: flex;
            gap: 10px;
        }

        .action-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            background: white;
            color: #64748b;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .action-btn.edit:hover {
            background: #2D3E50;
            color: white;
            border-color: #2D3E50;
        }

        .action-btn.delete:hover {
            background: #EF4444;
            color: white;
            border-color: #EF4444;
        }

        .category-status {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .status-active {
            background: rgba(16, 185, 129, 0.15);
            color: #065f46;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-inactive {
            background: rgba(239, 68, 68, 0.15);
            color: #7f1d1d;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 80px 30px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border: 1.5px solid #e2e8f0;
            margin: 40px 0;
        }

        .empty-icon {
            font-size: 64px;
            color: #cbd5e0;
            margin-bottom: 20px;
            opacity: 0.6;
        }

        .empty-title {
            font-size: 22px;
            font-weight: 700;
            color: #4b5563;
            margin-bottom: 10px;
        }

        .empty-text {
            font-size: 15px;
            color: #94a3b8;
            max-width: 400px;
            margin: 0 auto 30px;
            line-height: 1.6;
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
            z-index: 10000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 550px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            animation: modalSlide 0.3s ease;
        }

        @keyframes modalSlide {
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
            padding: 25px 30px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h2 {
            font-size: 20px;
            font-weight: 700;
            color: #2D3E50;
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0;
        }

        .modal-header h2 i {
            color: #3B82F6;
            background: rgba(59, 130, 246, 0.1);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 28px;
            color: #94a3b8;
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .close-btn:hover {
            background: #f1f5f9;
            color: #2D3E50;
        }

        .modal-body {
            padding: 30px;
        }

        .modal-footer {
            padding: 20px 30px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            gap: 15px;
            justify-content: flex-end;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #2D3E50;
            margin-bottom: 8px;
        }

        .form-label small {
            font-weight: normal;
            color: #94a3b8;
            margin-left: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-control:focus {
            outline: none;
            border-color: #2D3E50;
            background: white;
            box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        /* Color Picker */
        .color-input-group {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .color-input-group input[type="color"] {
            width: 50px;
            height: 50px;
            padding: 5px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            cursor: pointer;
        }

        .color-input-group input[type="text"] {
            flex: 1;
        }

        /* Icon Selector */
        .icon-selector {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .icon-selector .icon-preview {
            width: 50px;
            height: 50px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #2D3E50;
            background: #f8fafc;
        }

        .icon-selector input {
            flex: 1;
        }

        .icon-quick-select {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 8px;
            margin-top: 15px;
            max-height: 200px;
            overflow-y: auto;
            padding: 15px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
        }

        @media (max-width: 768px) {
            .icon-quick-select {
                grid-template-columns: repeat(6, 1fr);
            }
        }

        @media (max-width: 480px) {
            .icon-quick-select {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .icon-option {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s ease;
            margin: 0 auto;
        }

        .icon-option:hover {
            background: #2D3E50;
            color: white;
            border-color: #2D3E50;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
        }

        .icon-option.active {
            background: #2D3E50;
            color: white;
            border-color: #2D3E50;
        }

        /* Checkbox */
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1.5px solid #e2e8f0;
        }

        .checkbox-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 2px solid #cbd5e0;
            cursor: pointer;
            accent-color: #2D3E50;
        }

        .checkbox-group label {
            font-size: 14px;
            font-weight: 600;
            color: #2D3E50;
            cursor: pointer;
            margin: 0;
        }

        /* Buttons */
        .btn {
            padding: 12px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2D3E50 0%, #1a252f 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(45, 62, 80, 0.2);
        }

        .btn-secondary {
            background: white;
            color: #64748b;
            border: 1.5px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: #EF4444;
            color: white;
        }

        .btn-danger:hover {
            background: #DC2626;
            transform: translateY(-2px);
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 25px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border: 1.5px solid #e2e8f0;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .pagination-container {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
        }

        .pagination-info {
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
        }

        .pagination-links {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .page-link {
            min-width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            color: #64748b;
            background: white;
            border: 1.5px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background: #f8fafc;
            border-color: #2D3E50;
            color: #2D3E50;
            transform: translateY(-2px);
        }

        .page-link.active {
            background: linear-gradient(135deg, #2D3E50 0%, #1a252f 100%);
            color: white;
            border-color: #2D3E50;
        }

        .page-arrow {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            text-decoration: none;
            color: #2D3E50;
            background: white;
            border: 1.5px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .page-arrow.disabled {
            opacity: 0.5;
            pointer-events: none;
        }

        /* Alert */
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.3s ease;
        }

        .alert-success {
            background: #d1fae5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .alert-error {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Loading Spinner */
        .btn-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, .3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('content')
    <div class="admin-container">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Header -->
        <div class="admin-header">
            <h1 class="admin-title">
                <i class="fas fa-tags"></i>
                <span>Categories Management</span>
            </h1>
            <div class="action-buttons">
                <button class="btn-add" onclick="openModal('addModal')">
                    <i class="fas fa-plus-circle"></i>
                    Add Category
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-section">
            <form method="GET" action="{{ route('admin.categories.index') }}" class="filter-form">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-search"></i>
                        Search Categories
                    </label>
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" class="search-input" placeholder="Search by name, description..."
                            value="{{ request('search') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-filter"></i>
                        Status
                    </label>
                    <select name="status" class="filter-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-sort"></i>
                        Sort By
                    </label>
                    <select name="sort" class="filter-select">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="filter-btn">
                        <i class="fas fa-filter"></i>
                        Apply Filters
                    </button>
                </div>

                @if(request()->hasAny(['search', 'status', 'sort']))
                    <div class="form-group">
                        <a href="{{ route('admin.categories.index') }}" class="btn-clear">
                            <i class="fas fa-times"></i>
                            Clear
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Categories Grid -->
        @if($categories->count() > 0)
            <div class="categories-grid">
                @foreach($categories as $category)
                    <div class="category-card">
                        <div class="category-gradient" style="background: {{ $category->color ?? '#3B82F6' }}"></div>

                        <span class="category-status status-{{ $category->is_active ? 'active' : 'inactive' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>

                        <div class="category-content">
                            <div class="category-header">
                                <div class="category-icon-container" style="background: {{ $category->color ?? '#3B82F6' }}">
                                    <i class="fas {{ $category->icon ?? 'fa-folder' }}"></i>
                                </div>
                                <div class="category-info">
                                    <h3 class="category-name">{{ $category->name }}</h3>
                                    <span class="category-slug">{{ $category->slug }}</span>
                                </div>
                            </div>

                            <div class="category-description">
                                {{ $category->description ?: 'No description provided.' }}
                            </div>

                            <div class="category-color">
                                <div class="color-badge" style="background: {{ $category->color ?? '#3B82F6' }}"></div>
                                <span class="color-text">{{ $category->color ?? '#3B82F6' }}</span>
                            </div>

                            <div class="category-footer">
                                <div class="category-stats">
                                    <div class="stat-item">
                                        <div class="stat-value">{{ $category->total_courses_count }}</div>
                                        <div class="stat-label">Total</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-value">{{ $category->courses_count }}</div>
                                        <div class="stat-label">Active</div>
                                    </div>
                                </div>

                                <div class="category-actions">
                                    <button class="action-btn edit"
                                        onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->icon ?? 'fa-folder' }}', '{{ $category->color ?? '#3B82F6' }}', '{{ addslashes($category->description) }}', {{ $category->is_active ? 'true' : 'false' }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn delete"
                                        onclick="deleteCategory({{ $category->id }}, '{{ $category->name }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h3 class="empty-title">No Categories Found</h3>
                <p class="empty-text">
                    @if(request()->hasAny(['search', 'status', 'sort']))
                        Try adjusting your search criteria or filters
                    @else
                        Start by creating your first category to organize courses
                    @endif
                </p>
                @if(!request()->hasAny(['search', 'status', 'sort']))
                    <button class="btn-add" onclick="openModal('addModal')" style="min-width: 200px; margin: 0 auto;">
                        <i class="fas fa-plus-circle"></i>
                        Create First Category
                    </button>
                @endif
            </div>
        @endif

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="pagination-container">
                <div class="pagination-info">
                    Showing <strong>{{ $categories->firstItem() ?? 0 }}</strong> to
                    <strong>{{ $categories->lastItem() ?? 0 }}</strong> of
                    <strong>{{ $categories->total() }}</strong> categories
                </div>
                <div class="pagination-links">
                    {{-- Previous Page Link --}}
                    @if($categories->onFirstPage())
                        <span class="page-arrow disabled">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $categories->previousPageUrl() }}" class="page-arrow">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements - Show 5 pages with dots --}}
                    @php
                        $currentPage = $categories->currentPage();
                        $lastPage = $categories->lastPage();
                        $start = max(1, $currentPage - 2);
                        $end = min($lastPage, $currentPage + 2);

                        // Adjust start and end to always show 5 pages when possible
                        if ($end - $start < 4) {
                            if ($start == 1) {
                                $end = min($lastPage, $start + 4);
                            } elseif ($end == $lastPage) {
                                $start = max(1, $end - 4);
                            }
                        }
                    @endphp

                    {{-- First page link with dots --}}
                    @if($start > 1)
                        <a href="{{ $categories->url(1) }}" class="page-link">1</a>
                        @if($start > 2)
                            <span class="page-link" style="background: none; border: none; box-shadow: none;">...</span>
                        @endif
                    @endif

                    {{-- Page numbers --}}
                    @for($page = $start; $page <= $end; $page++)
                        @if($page == $currentPage)
                            <span class="page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $categories->url($page) }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endfor

                    {{-- Last page link with dots --}}
                    @if($end < $lastPage)
                        @if($end < $lastPage - 1)
                            <span class="page-link" style="background: none; border: none; box-shadow: none;">...</span>
                        @endif
                        <a href="{{ $categories->url($lastPage) }}" class="page-link">{{ $lastPage }}</a>
                    @endif

                    {{-- Next Page Link --}}
                    @if($categories->hasMorePages())
                        <a href="{{ $categories->nextPageUrl() }}" class="page-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="page-arrow disabled">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <!-- Add Category Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>
                    <i class="fas fa-plus-circle"></i>
                    Add New Category
                </h2>
                <button class="close-btn" onclick="closeModal('addModal')">&times;</button>
            </div>
            <form id="addCategoryForm" action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">
                            Category Name <small>*Required</small>
                        </label>
                        <input type="text" name="name" class="form-control" placeholder="e.g., Web Development" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Icon <small>Font Awesome Icon</small></label>
                        <div class="icon-selector">
                            <div class="icon-preview">
                                <i class="fas fa-folder" id="addIconPreview"></i>
                            </div>
                            <input type="text" name="icon" id="addIcon" class="form-control" 
                                   value="fa-folder" placeholder="fa-folder" readonly 
                                   style="background-color: #f1f5f9; cursor: default;">
                        </div>
                        <div class="icon-quick-select" id="addIconGrid"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Color</label>
                        <div class="color-input-group">
                            <input type="color" name="color" id="addColor" value="#3B82F6"
                                onchange="document.getElementById('addColorText').value = this.value">
                            <input type="text" id="addColorText" class="form-control" value="#3B82F6" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control"
                            placeholder="Brief description of this category..." rows="3"></textarea>
                    </div>

                    <div class="checkbox-group">
                        <input type="checkbox" name="is_active" id="addIsActive" checked>
                        <label for="addIsActive">Active Category</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>
                    <i class="fas fa-edit"></i>
                    Edit Category
                </h2>
                <button class="close-btn" onclick="closeModal('editModal')">&times;</button>
            </div>
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">
                            Category Name <small>*Required</small>
                        </label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>

                    <div class="icon-selector">
                        <div class="icon-preview">
                            <i class="fas" id="editIconPreview"></i>
                        </div>
                        <input type="text" name="icon" id="editIcon" class="form-control" 
                               value="fa-folder" readonly 
                               style="background-color: #f1f5f9; cursor: default;">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Color</label>
                        <div class="color-input-group">
                            <input type="color" name="color" id="editColor" value="#3B82F6"
                                onchange="document.getElementById('editColorText').value = this.value">
                            <input type="text" id="editColorText" class="form-control" value="#3B82F6" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="editDescription" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="checkbox-group">
                        <input type="checkbox" name="is_active" id="editIsActive">
                        <label for="editIsActive">Active Category</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Hidden Delete Forms for each category -->
    @foreach($categories as $category)
        <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category) }}" method="POST"
            style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
@endsection

@section('scripts')
    <script>
        // Expanded Font Awesome Icons Collection
        const fontAwesomeIcons = [
            'fa-folder', 'fa-folder-open', 'fa-tags', 'fa-tag', 'fa-code', 'fa-laptop-code',
            'fa-desktop', 'fa-globe', 'fa-server', 'fa-database', 'fa-cloud', 'fa-chart-line',
            'fa-chart-bar', 'fa-chart-pie', 'fa-calculator', 'fa-briefcase', 'fa-building',
            'fa-user-tie', 'fa-users', 'fa-user-graduate', 'fa-graduation-cap', 'fa-book',
            'fa-book-open', 'fa-file-alt', 'fa-pencil-alt', 'fa-paint-brush', 'fa-palette',
            'fa-camera', 'fa-video', 'fa-music', 'fa-headphones', 'fa-microphone',
            'fa-mobile-alt', 'fa-tablet-alt', 'fa-robot', 'fa-shield-alt', 'fa-lock',
            'fa-key', 'fa-language', 'fa-comments', 'fa-comment-dots', 'fa-envelope',
            'fa-bell', 'fa-calendar', 'fa-clock', 'fa-hourglass', 'fa-trophy', 'fa-medal',
            'fa-star', 'fa-heart', 'fa-thumbs-up', 'fa-check-circle', 'fa-exclamation-circle',
            'fa-question-circle', 'fa-cog', 'fa-tools', 'fa-wrench',
            'fa-sliders-h', 'fa-filter', 'fa-search', 'fa-lightbulb', 'fa-brain',
            'fa-rocket', 'fa-space-shuttle', 'fa-flask', 'fa-atom', 'fa-dna',
            'fa-arrow-right', 'fa-box', 'fa-cubes', 'fa-layer-group', 'fa-th-large'
        ];

        // Initialize icon grids
        function initializeIconGrids() {
            const addGrid = document.getElementById('addIconGrid');
            const editGrid = document.getElementById('editIconGrid');

            if (addGrid) {
                addGrid.innerHTML = fontAwesomeIcons.map(icon =>
                    `<div class="icon-option" onclick="selectIcon('${icon}', 'add')">
                        <i class="fas ${icon}"></i>
                    </div>`
                ).join('');
            }

            if (editGrid) {
                editGrid.innerHTML = fontAwesomeIcons.map(icon =>
                    `<div class="icon-option" onclick="selectIcon('${icon}', 'edit')">
                        <i class="fas ${icon}"></i>
                    </div>`
                ).join('');
            }
        }

        // Modal Functions
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Icon Selection
        function selectIcon(icon, modal) {
            const iconInput = document.getElementById(modal + 'Icon');
            const iconPreview = document.getElementById(modal + 'IconPreview');

            iconInput.value = icon;
            iconPreview.className = 'fas ' + icon;

            // Update active state
            document.querySelectorAll('#' + modal + 'Modal .icon-option').forEach(opt => {
                opt.classList.remove('active');
                if (opt.querySelector('i').classList.contains(icon)) {
                    opt.classList.add('active');
                }
            });
        }

        // Edit Category - Set form action and populate fields
        function editCategory(id, name, icon, color, description, isActive) {
            const form = document.getElementById('editCategoryForm');
            form.action = '/admin/categories/' + id;

            document.getElementById('editName').value = name;
            document.getElementById('editIcon').value = icon || 'fa-folder';
            document.getElementById('editIconPreview').className = 'fas ' + (icon || 'fa-folder');
            document.getElementById('editColor').value = color || '#3B82F6';
            document.getElementById('editColorText').value = color || '#3B82F6';
            document.getElementById('editDescription').value = description || '';
            document.getElementById('editIsActive').checked = isActive;

            // Set active icon
            document.querySelectorAll('#editModal .icon-option').forEach(opt => {
                opt.classList.remove('active');
                if (opt.querySelector('i').classList.contains(icon || 'fa-folder')) {
                    opt.classList.add('active');
                }
            });

            openModal('editModal');
        }

        // Delete Category - EXACTLY LIKE YOUR COURSES PAGE
        function deleteCategory(id, name) {
            Swal.fire({
                title: 'Delete Category',
                text: `Are you sure you want to delete "${name}"? This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2d3e50',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                customClass: {
                    popup: 'shadow-lg rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Submit the form - just like courses page
                    const form = document.getElementById(`delete-form-${id}`);
                    if (form) {
                        form.submit();
                    }
                }
            });
        }

        // Close modals when clicking outside
        window.onclick = function (event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        }

        // Initialize everything when DOM is ready
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize icon grids
            initializeIconGrids();

            // Set default active icons
            setTimeout(() => {
                const addDefaultIcon = document.querySelector('#addModal .icon-option i.fa-folder');
                if (addDefaultIcon) {
                    addDefaultIcon.closest('.icon-option').classList.add('active');
                }

                const editDefaultIcon = document.querySelector('#editModal .icon-option i.fa-folder');
                if (editDefaultIcon) {
                    editDefaultIcon.closest('.icon-option').classList.add('active');
                }
            }, 100);

            // Auto-hide alerts
            setTimeout(function () {
                document.querySelectorAll('.alert').forEach(alert => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        });
    </script>
@endsection