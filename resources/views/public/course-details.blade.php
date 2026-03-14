@extends('layouts.app')

@section('title', $course->title . ' - Shifra')
@section('body-class', 'public-page')

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
        --shadow-lg: 0 10px 15px -3px rgba(21, 17, 17, 0.1);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .public-page {
        background-color: var(--bg-light);
    }

    .course-details-page {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 30px 40px;
        padding-bottom: 100px;
    }

    /* Navigation */
    .navigation-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--text-gray);
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
        padding: 10px 20px;
        background: white;
        border-radius: 40px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .back-link:hover {
        color: var(--primary-navy);
        border-color: var(--primary-navy);
        transform: translateX(-5px);
    }

    .admin-tools {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-admin-tool {
        padding: 10px 20px;
        border-radius: 40px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .btn-admin-tool.edit {
        background: #f1f5f9;
        color: var(--text-dark);
        border: 1px solid var(--border-color);
    }

    .btn-admin-tool.edit:hover {
        background: #e2e8f0;
        color: var(--primary-navy);
        transform: translateY(-2px);
    }

    .btn-admin-tool.manage {
        background: #1e40af;
        color: white;
    }

    .btn-admin-tool.manage:hover {
        background: #3730a3;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-admin-tool.students {
        background: #065f46;
        color: white;
    }

    .btn-admin-tool.students:hover {
        background: #047857;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, var(--primary-navy) 0%, #1a252f 100%);
        border-radius: 30px;
        padding: 50px;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .hero-title {
        font-size: 42px;
        font-weight: 700;
        color: white;
        margin-bottom: 15px;
        line-height: 1.2;
        max-width: 800px;
    }

    .hero-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
    }

    .hero-meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.9);
        font-size: 15px;
        background: rgba(255, 255, 255, 0.1);
        padding: 8px 20px;
        border-radius: 40px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .hero-meta-item i {
        color: var(--secondary-blue);
    }

    .hero-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .hero-badge {
        padding: 6px 18px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .hero-badge.featured {
        background: #fef3c7;
        color: #d97706;
    }

    .hero-badge.new {
        background: #dbeafe;
        color: #1e40af;
    }

    .hero-badge.inactive {
        background: #fee2e2;
        color: #dc2626;
    }

    /* Main Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        margin-bottom: 50px;
    }

    @media (max-width: 992px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Left Column */
    .left-column {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    /* Cards */
    .info-card {
        background: white;
        border-radius: 24px;
        padding: 30px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
    }

    .card-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-title i {
        color: var(--secondary-blue);
        background: rgba(49, 130, 206, 0.1);
        padding: 10px;
        border-radius: 12px;
    }

    .description-text {
        color: var(--text-gray);
        font-size: 16px;
        line-height: 1.8;
        white-space: pre-line;
    }

    /* Highlights Grid */
    .highlights-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .highlight-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        background: #f8fafc;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .highlight-item:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        border-color: var(--secondary-blue);
    }

    .highlight-icon {
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--secondary-blue);
        font-size: 20px;
        box-shadow: var(--shadow-sm);
    }

    .highlight-content h4 {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 5px;
    }

    .highlight-content p {
        font-size: 13px;
        color: var(--text-gray);
    }

    /* What You'll Learn */
    .learn-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .learn-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .learn-item:hover {
        background: #f1f5f9;
        border-color: var(--secondary-blue);
        transform: translateX(5px);
    }

    .learn-item i {
        color: var(--success-green);
        font-size: 16px;
    }

    .learn-item span {
        color: var(--text-dark);
        font-size: 14px;
        font-weight: 500;
    }

    /* Requirements */
    .requirements-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .requirement-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid var(--border-color);
    }

    .requirement-item:last-child {
        border-bottom: none;
    }

    .requirement-item i {
        color: var(--warning-orange);
        font-size: 14px;
    }

    .requirement-item span {
        color: var(--text-gray);
        font-size: 14px;
    }

    /* Right Column */
    .right-column {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    /* Course Image Card */
    .image-card {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-lg);
    }

    .course-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .image-overlay {
        padding: 25px;
        background: linear-gradient(135deg, var(--primary-navy), #1a252f);
        color: white;
    }

    .overlay-price {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .current-price {
        font-size: 36px;
        font-weight: 700;
    }

    .original-price {
        font-size: 20px;
        color: rgba(255, 255, 255, 0.6);
        text-decoration: line-through;
    }

    .discount-badge {
        background: var(--success-green);
        color: white;
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
    }

    .free-badge-large {
        background: var(--success-green);
        color: white;
        padding: 12px 25px;
        border-radius: 40px;
        font-size: 18px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .btn-primary {
        width: 100%;
        padding: 18px;
        background: var(--primary-navy);
        color: white;
        border: none;
        border-radius: 16px;
        font-size: 18px;
        font-weight: 700;
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
        transform: translateY(-3px);
        box-shadow: var(--shadow-xl);
    }

    .btn-outline {
        width: 100%;
        padding: 15px;
        background: transparent;
        color: var(--primary-navy);
        border: 2px solid var(--primary-navy);
        border-radius: 16px;
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

    .btn-outline:hover {
        background: var(--primary-navy);
        color: white;
        transform: translateY(-2px);
    }

    .btn-continue {
        background: var(--success-green);
    }

    .btn-continue:hover {
        background: #0f9e6a;
    }

    .btn-edit {
        background: var(--secondary-blue);
    }

    .btn-edit:hover {
        background: #2563eb;
    }

    .btn-manage {
        background: #1e40af;
    }

    .btn-manage:hover {
        background: #3730a3;
    }

    .btn-reenroll {
        background: #f59e0b;
    }

    .btn-reenroll:hover {
        background: #d97706;
    }

    /* Instructor Message Styling */
    .instructor-message {
        background: linear-gradient(135deg, #f0f9ff, #e6f0fa);
        border: 1px solid #bae6fd;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        width: 100%;
    }
    
    .message-icon {
        width: 50px;
        height: 50px;
        background: #0284c7;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 22px;
        flex-shrink: 0;
    }
    
    .message-content {
        flex: 1;
    }
    
    .message-content h4 {
        font-size: 16px;
        font-weight: 600;
        color: #0369a1;
        margin-bottom: 4px;
    }
    
    .message-content p {
        font-size: 14px;
        color: #0c4a6e;
        margin: 0;
    }
    
    /* Alert Styling */
    .alert {
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        width: 100%;
    }
    
    .alert.cancelled {
        background: #fee2e2;
        border: 1px solid #fecaca;
    }
    
    .alert.pending {
        background: #fef3c7;
        border: 1px solid #fde68a;
    }
    
    .alert-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
    
    .alert.cancelled .alert-icon {
        background: #dc2626;
        color: white;
    }
    
    .alert.pending .alert-icon {
        background: #d97706;
        color: white;
    }
    
    .alert-content {
        flex: 1;
    }
    
    .alert-content h4 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 4px;
    }
    
    .alert.cancelled .alert-content h4 {
        color: #b91c1c;
    }
    
    .alert.pending .alert-content h4 {
        color: #92400e;
    }
    
    .alert-content p {
        font-size: 14px;
        margin: 0;
    }
    
    .alert.cancelled .alert-content p {
        color: #991b1b;
    }
    
    .alert.pending .alert-content p {
        color: #854d0e;
    }

    /* Stats Card */
    .stats-card {
        background: white;
        border-radius: 24px;
        padding: 25px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    .stat-item {
        text-align: center;
        padding: 15px;
        background: #f8fafc;
        border-radius: 16px;
    }

    .stat-value {
        display: block;
        font-size: 28px;
        font-weight: 700;
        color: var(--primary-navy);
        line-height: 1.2;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 12px;
        color: var(--text-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Instructor Card */
    .instructor-card {
        background: white;
        border-radius: 24px;
        padding: 25px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .instructor-avatar {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--primary-navy), var(--secondary-blue));
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 600;
    }

    .instructor-info h4 {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 5px;
    }

    .instructor-info p {
        color: var(--text-gray);
        font-size: 14px;
    }

    /* Tags */
    .tags-section {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .tag {
        padding: 8px 20px;
        background: #f1f5f9;
        color: var(--text-dark);
        border-radius: 40px;
        font-size: 14px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .tag i {
        color: var(--secondary-blue);
    }

    /* Role-Based Admin Panel */
    .admin-panel {
        background: white;
        border-radius: 24px;
        padding: 25px;
        border: 2px solid #fde68a;
        box-shadow: var(--shadow-lg);
        margin-top: 20px;
    }

    .admin-panel-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--border-color);
    }

    .admin-panel-header i {
        color: #d97706;
        font-size: 24px;
    }

    .admin-panel-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-navy);
        margin: 0;
    }

    .admin-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }

    .admin-stat {
        text-align: center;
        padding: 15px;
        background: #fef3c7;
        border-radius: 12px;
    }

    .admin-stat-value {
        display: block;
        font-size: 24px;
        font-weight: 700;
        color: #92400e;
    }

    .admin-stat-label {
        font-size: 12px;
        color: #92400e;
    }

    .admin-actions {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .admin-action-btn {
        padding: 12px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.3s ease;
    }

    .admin-action-btn.blue {
        background: #dbeafe;
        color: #1e40af;
    }

    .admin-action-btn.green {
        background: #dcfce7;
        color: #15803d;
    }

    .admin-action-btn.purple {
        background: #f3e8ff;
        color: #6b21a8;
    }

    .admin-action-btn:hover {
        transform: translateY(-2px);
        filter: brightness(0.95);
    }

    /* REVIEW SECTION STYLES */
    .reviews-section {
        background: white;
        border-radius: 24px;
        padding: 30px;
        margin: 40px 0;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-lg);
    }

    .reviews-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .reviews-header h2 {
        font-size: 24px;
        color: var(--primary-navy);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .reviews-header h2 i {
        color: #f59e0b;
        background: #fef3c7;
        padding: 10px;
        border-radius: 12px;
    }

    .rating-summary {
        display: flex;
        align-items: center;
        gap: 30px;
        flex-wrap: wrap;
        margin-bottom: 30px;
        padding: 20px;
        background: #f8fafc;
        border-radius: 20px;
    }

    .average-rating {
        text-align: center;
        min-width: 120px;
    }

    .average-number {
        font-size: 48px;
        font-weight: 700;
        color: var(--primary-navy);
        line-height: 1;
    }

    .average-stars {
        color: #fbbf24;
        font-size: 18px;
        margin: 5px 0;
    }

    .total-reviews {
        font-size: 14px;
        color: var(--text-gray);
    }

    .rating-bars {
        flex: 1;
    }

    .rating-bar-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
    }

    .rating-bar-label {
        min-width: 30px;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .rating-bar-container {
        flex: 1;
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
    }

    .rating-bar-fill {
        height: 100%;
        background: #fbbf24;
        border-radius: 4px;
    }

    .rating-bar-count {
        min-width: 40px;
        font-size: 13px;
        color: var(--text-gray);
    }

    .reviews-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }

    .review-card {
        background: #f8fafc;
        border-radius: 20px;
        padding: 25px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .review-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: var(--secondary-blue);
    }

    .reviewer-info {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }

    .reviewer-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-navy), var(--secondary-blue));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 18px;
    }

    .reviewer-details h4 {
        font-size: 16px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 5px;
    }

    .reviewer-stars {
        color: #fbbf24;
        font-size: 14px;
    }

    .reviewer-stars span {
        margin-left: 5px;
        color: var(--text-gray);
        font-size: 13px;
    }

    .review-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--primary-navy);
        margin-bottom: 10px;
    }

    .review-comment {
        color: var(--text-gray);
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .review-date {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: var(--text-light);
        margin-bottom: 15px;
    }

    .review-helpful {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .btn-helpful {
        background: white;
        border: 1px solid var(--border-color);
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .btn-helpful:hover {
        background: var(--secondary-blue);
        color: white;
        border-color: var(--secondary-blue);
    }

    .btn-helpful i {
        color: var(--secondary-blue);
    }

    .btn-helpful:hover i {
        color: white;
    }

    .your-review-badge {
        background: #fef3c7;
        color: #92400e;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 10px;
    }

    .pending-badge {
        background: #f1f5f9;
        color: #64748b;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        margin-left: 10px;
    }

    .btn-write-review {
        background: #f59e0b;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 40px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-write-review:hover {
        background: #d97706;
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    .login-to-review {
        padding: 20px;
        background: #f8fafc;
        border-radius: 16px;
        text-align: center;
        color: var(--text-gray);
    }

    .login-to-review a {
        color: var(--secondary-blue);
        font-weight: 600;
        text-decoration: none;
    }

    .login-to-review a:hover {
        text-decoration: underline;
    }

    /* Related Courses */
    .related-section {
        margin-top: 50px;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 25px;
    }

    @media (max-width: 768px) {
        .related-grid {
            grid-template-columns: 1fr;
        }
    }

    .related-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        border: 1px solid var(--border-color);
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
        display: flex;
        gap: 15px;
    }

    .related-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
        border-color: var(--secondary-blue);
    }

    .related-image {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        object-fit: cover;
    }

    .related-info h4 {
        font-size: 16px;
        font-weight: 600;
        color: var(--primary-navy);
        margin-bottom: 5px;
    }

    .related-info p {
        font-size: 13px;
        color: var(--text-gray);
    }

    .related-price {
        font-size: 16px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-top: 8px;
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
        background: white;
        border-radius: 24px;
        padding: 30px;
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: var(--shadow-xl);
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
        font-size: 22px;
        color: var(--primary-navy);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-header h3 i {
        color: #f59e0b;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        color: var(--text-light);
        transition: all 0.3s ease;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .close-btn:hover {
        color: var(--danger-red);
        background: #f1f5f9;
    }

    .rating-selector {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        justify-content: center;
    }

    .star {
        font-size: 36px;
        cursor: pointer;
        color: #cbd5e0;
        transition: all 0.3s ease;
    }

    .star:hover,
    .star.active {
        color: #fbbf24;
        transform: scale(1.1);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-navy);
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .modal-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 25px;
    }

    .btn-submit {
        background: var(--primary-navy);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #475569;
        border: 1px solid var(--border-color);
        padding: 12px 25px;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
    }

    /* Admin Select Styles */
    .admin-select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        font-size: 14px;
        background: white;
        cursor: pointer;
        margin-bottom: 15px;
    }

    .admin-select:focus {
        outline: none;
        border-color: var(--primary-navy);
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    .admin-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px;
    }

    .admin-option i {
        color: var(--secondary-blue);
    }

    .loading-spinner-small {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid #f1f5f9;
        border-top-color: var(--primary-navy);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-right: 8px;
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
        width: 60px;
        height: 60px;
        border: 5px solid #f1f5f9;
        border-top-color: var(--primary-navy);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .course-details-page {
            padding: 20px 15px;
        }

        .hero-title {
            font-size: 32px;
        }

        .highlights-grid,
        .learn-list {
            grid-template-columns: 1fr;
        }

        .admin-stats,
        .admin-actions {
            grid-template-columns: 1fr;
        }

        .related-grid {
            grid-template-columns: 1fr;
        }

        .reviews-grid {
            grid-template-columns: 1fr;
        }

        .rating-summary {
            flex-direction: column;
            align-items: flex-start;
        }

        .modal-actions {
            flex-direction: column;
        }

        .rating-selector {
            flex-wrap: wrap;
        }
    }
</style>
@endsection

@section('content')
<div class="course-details-page">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Navigation -->
    <div class="navigation-bar">
        <a href="{{ route('courses.public') }}" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Back to Courses
        </a>

        @auth
            @if(auth()->user()->hasRole('admin'))
                <div class="admin-tools">
                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn-admin-tool edit">
                        <i class="fas fa-edit"></i> Edit Course
                    </a>
                    <a href="{{ route('admin.courses.index') }}" class="btn-admin-tool manage">
                        <i class="fas fa-cog"></i> Manage
                    </a>
                    <a href="{{ route('admin.students.index') }}?course={{ $course->id }}" class="btn-admin-tool students">
                        <i class="fas fa-users"></i> Students
                    </a>
                </div>
            @elseif(auth()->user()->hasRole('instructor') && $course->instructor_name == auth()->user()->name)
                <div class="admin-tools">
                    <a href="{{ route('instructor.courses.edit', $course) }}" class="btn-admin-tool edit">
                        <i class="fas fa-edit"></i> Edit Course
                    </a>
                    <a href="{{ route('instructor.course-students', $course) }}" class="btn-admin-tool students">
                        <i class="fas fa-users"></i> View Students
                    </a>
                </div>
            @endif
        @endauth
    </div>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">{{ $course->title }}</h1>
            
            <div class="hero-meta">
                <span class="hero-meta-item">
                    <i class="fas fa-chalkboard-teacher"></i>
                    {{ $course->instructor_name }}
                </span>
                <span class="hero-meta-item">
                    <i class="fas fa-clock"></i>
                    {{ $course->duration ?? '4 weeks' }}
                </span>
                <span class="hero-meta-item">
                    <i class="fas fa-signal"></i>
                    {{ ucfirst($course->level) }}
                </span>
                <span class="hero-meta-item">
                    <i class="fas fa-video"></i>
                    {{ ucfirst($course->format) }}
                </span>
            </div>

            <div class="hero-badges">
                @if(!$course->is_active)
                    <span class="hero-badge inactive">
                        <i class="fas fa-eye-slash"></i> Inactive
                    </span>
                @endif
                @if($course->is_featured)
                    <span class="hero-badge featured">
                        <i class="fas fa-star"></i> Featured
                    </span>
                @endif
                @if($course->created_at->gt(now()->subDays(7)))
                    <span class="hero-badge new">
                        <i class="fas fa-fire"></i> New
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="content-grid">
        <!-- Left Column -->
        <div class="left-column">
            <!-- Description -->
            <div class="info-card">
                <h3 class="card-title">
                    <i class="fas fa-align-left"></i>
                    About This Course
                </h3>
                <div class="description-text">
                    {{ $course->description }}
                </div>
            </div>

            <!-- Highlights -->
            <div class="info-card">
                <h3 class="card-title">
                    <i class="fas fa-star"></i>
                    Course Highlights
                </h3>
                <div class="highlights-grid">
                    <div class="highlight-item">
                        <div class="highlight-icon">
                            <i class="fas fa-video"></i>
                        </div>
                        <div class="highlight-content">
                            <h4>{{ $course->sessions_count }}</h4>
                            <p>Live Sessions</p>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <div class="highlight-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div class="highlight-content">
                            <h4>{{ $course->assignments_count }}</h4>
                            <p>Assignments</p>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <div class="highlight-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="highlight-content">
                            <h4>{{ $course->materials_count }}</h4>
                            <p>Resources</p>
                        </div>
                    </div>
                    <div class="highlight-item">
                        <div class="highlight-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="highlight-content">
                            <h4>{{ $course->duration ?? '4' }}</h4>
                            <p>Weeks</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- What You'll Learn -->
            @if($course->what_you_will_learn)
                @php
                    $learnItems = is_array($course->what_you_will_learn) 
                        ? $course->what_you_will_learn 
                        : json_decode($course->what_you_will_learn, true) ?? [];
                @endphp
                @if(count($learnItems) > 0)
                    <div class="info-card">
                        <h3 class="card-title">
                            <i class="fas fa-graduation-cap"></i>
                            What You'll Learn
                        </h3>
                        <div class="learn-list">
                            @foreach($learnItems as $item)
                                <div class="learn-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>{{ $item }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            <!-- Requirements -->
            @if($course->requirements)
                @php
                    $reqItems = is_array($course->requirements) 
                        ? $course->requirements 
                        : json_decode($course->requirements, true) ?? [];
                @endphp
                @if(count($reqItems) > 0)
                    <div class="info-card">
                        <h3 class="card-title">
                            <i class="fas fa-clipboard-list"></i>
                            Requirements
                        </h3>
                        <div class="requirements-list">
                            @foreach($reqItems as $req)
                                <div class="requirement-item">
                                    <i class="fas fa-circle"></i>
                                    <span>{{ $req }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        </div>

        <!-- Right Column -->
        <div class="right-column">
            <!-- Course Image & Price -->
            <div class="image-card">
                <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="course-image">
                <div class="image-overlay">
                    @php
                        $isFree = $course->price == 0;
                    @endphp

                    @if($isFree)
                        <div class="free-badge-large">
                            <i class="fas fa-gift"></i> FREE COURSE
                        </div>
                    @else
                        <div class="overlay-price">
                            <span class="current-price">${{ number_format($course->final_price, 2) }}</span>
                            @if($course->is_discounted)
                                <span class="original-price">${{ number_format($course->price, 2) }}</span>
                                <span class="discount-badge">
                                    -{{ $course->discount_percentage ?? round((($course->price - $course->discounted_price) / $course->price) * 100) }}%
                                </span>
                            @endif
                        </div>
                    @endif

                    <!-- Action Buttons - Role Based -->
                    <div class="action-buttons">
                        @auth
                            @if(auth()->user()->hasRole('admin'))
                                <a href="{{ route('admin.courses.edit', $course) }}" class="btn-primary btn-manage">
                                    <i class="fas fa-cog"></i> Manage Course
                                </a>
                            @elseif(auth()->user()->hasRole('instructor'))
                                @if($course->instructor_name == auth()->user()->name)
                                    {{-- Instructor owns this course --}}
                                    <a href="{{ route('instructor.course-students', $course) }}" class="btn-primary" style="background: #065f46;">
                                        <i class="fas fa-users"></i> View Students
                                    </a>
                                    <a href="{{ route('instructor.courses.edit', $course) }}" class="btn-outline">
                                        <i class="fas fa-edit"></i> Edit Course
                                    </a>
                                    <a href="{{ route('instructor.dashboard') }}" class="btn-outline">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>
                                @else
                                    {{-- Instructor viewing another instructor's course --}}
                                    <div class="instructor-message">
                                        <div class="message-icon">
                                            <i class="fas fa-info-circle"></i>
                                        </div>
                                        <div class="message-content">
                                            <h4>Viewing as Instructor</h4>
                                            <p>You are viewing this course as an instructor. You cannot enroll in courses.</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('courses.show', $course->slug) }}" class="btn-outline">
                                        <i class="fas fa-info-circle"></i> Course Details
                                    </a>
                                @endif
                            @elseif(auth()->user()->hasRole('student'))
                                @if($isEnrolled)
                                    {{-- Student enrollment logic --}}
                                    @if($enrollment && $enrollment->status == 'cancelled')
                                        <div class="alert cancelled">
                                            <div class="alert-icon">
                                                <i class="fas fa-times-circle"></i>
                                            </div>
                                            <div class="alert-content">
                                                <h4>Enrollment Cancelled</h4>
                                                <p>Your enrollment was cancelled. Contact an admin to re-enroll.</p>
                                            </div>
                                        </div>
                                        <button onclick="openReenrollModal()" class="btn-primary btn-reenroll">
                                            <i class="fas fa-envelope"></i> Contact Admin
                                        </button>
                                    @elseif($enrollment && $enrollment->status == 'pending')
                                        <div class="alert pending">
                                            <div class="alert-icon">
                                                <i class="fas fa-clock"></i>
                                            </div>
                                            <div class="alert-content">
                                                <h4>Pending Approval</h4>
                                                <p>Your enrollment is pending approval.</p>
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ route('courses.progress', $enrollment->id) }}" class="btn-primary btn-continue">
                                            <i class="fas fa-play"></i> Continue Learning
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('courses.registration', $course->slug) }}" class="btn-primary">
                                        <i class="fas fa-{{ $isFree ? 'gift' : 'shopping-cart' }}"></i>
                                        {{ $isFree ? 'Get Free' : 'Enroll Now' }}
                                    </a>
                                @endif
                            @endif
                        @else
                            {{-- Guest --}}
                            <a href="{{ route('login') }}?redirect={{ urlencode(route('courses.registration', $course->slug)) }}" class="btn-primary">
                                <i class="fas fa-{{ $isFree ? 'gift' : 'shopping-cart' }}"></i>
                                {{ $isFree ? 'Get Free' : 'Enroll Now' }}
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="stats-card">
                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-value">{{ $course->total_students ?? 0 }}</span>
                        <span class="stat-label">Students</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">{{ number_format($ratingStats['average'], 1) }}</span>
                        <span class="stat-label">Rating</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">{{ $ratingStats['total'] }}</span>
                        <span class="stat-label">Reviews</span>
                    </div>
                </div>
            </div>

            <!-- Instructor -->
            <div class="instructor-card">
                <div class="instructor-avatar">
                    {{ substr($course->instructor_name, 0, 1) }}
                </div>
                <div class="instructor-info">
                    <h4>{{ $course->instructor_name }}</h4>
                    <p>Course Instructor</p>
                </div>
            </div>

            <!-- Tags -->
            @if($course->tags)
                @php
                    $tags = is_array($course->tags) ? $course->tags : json_decode($course->tags, true) ?? [];
                @endphp
                @if(count($tags) > 0)
                    <div class="tags-section">
                        @foreach($tags as $tag)
                            <span class="tag">
                                <i class="fas fa-tag"></i> {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                @endif
            @endif

            <!-- Admin/Instructor Panel (Additional Stats) -->
            @auth
                @if(auth()->user()->hasRole('admin') || (auth()->user()->hasRole('instructor') && $course->instructor_name == auth()->user()->name))
                    <div class="admin-panel">
                        <div class="admin-panel-header">
                            <i class="fas fa-chart-line"></i>
                            <h3>Course Analytics</h3>
                        </div>
                        <div class="admin-stats">
                            <div class="admin-stat">
                                <span class="admin-stat-value">{{ $course->enrollments_count ?? 0 }}</span>
                                <span class="admin-stat-label">Enrollments</span>
                            </div>
                            <div class="admin-stat">
                                <span class="admin-stat-value">{{ $course->enrollments()->where('status', 'completed')->count() ?? 0 }}</span>
                                <span class="admin-stat-label">Completed</span>
                            </div>
                            <div class="admin-stat">
                                <span class="admin-stat-value">{{ $course->enrollments()->where('status', 'active')->count() ?? 0 }}</span>
                                <span class="admin-stat-label">Active</span>
                            </div>
                        </div>
                        <div class="admin-actions">
                            <a href="{{ route(auth()->user()->hasRole('admin') ? 'admin.enrollments.index' : 'instructor.course-students', $course) }}" class="admin-action-btn blue">
                                <i class="fas fa-users"></i> View All
                            </a>
                            <a href="{{ route(auth()->user()->hasRole('admin') ? 'admin.analytics.courses' : 'instructor.dashboard') }}" class="admin-action-btn green">
                                <i class="fas fa-chart-bar"></i> Analytics
                            </a>
                            <a href="{{ route(auth()->user()->hasRole('admin') ? 'admin.courses.edit' : 'instructor.courses.edit', $course) }}" class="admin-action-btn purple">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>

    <!-- RE-ENROLLMENT MODAL -->
    <div class="modal" id="reenrollModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-envelope"></i> Request Re-enrollment</h3>
                <button class="close-btn" onclick="closeReenrollModal()">&times;</button>
            </div>
            <form id="reenrollForm">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                
                <div class="form-group">
                    <label>Select Admin</label>
                    <select name="admin_id" id="adminSelect" class="admin-select" required>
                        <option value="">Choose an admin...</option>
                        @php
                            $admins = \App\Models\User::role('admin')->get();
                        @endphp
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}">
                                {{ $admin->name }} ({{ $admin->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Your Message</label>
                    <textarea name="message" class="form-control" rows="4" 
                              placeholder="Explain why you want to re-enroll..." 
                              required>I would like to request re-enrollment in the course "{{ $course->title }}".</textarea>
                </div>
                
                <div class="modal-actions">
                    <button type="submit" class="btn-submit" id="submitReenrollBtn">
                        <i class="fas fa-paper-plane"></i> Send Request
                    </button>
                    <button type="button" class="btn-cancel" onclick="closeReenrollModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- REVIEWS SECTION - Visible to ALL users -->
    <div class="reviews-section">
        <div class="reviews-header">
            <h2>
                <i class="fas fa-star"></i>
                Student Reviews
                @if($ratingStats['total'] > 0)
                    <span style="margin-left: 10px; font-size: 18px; color: var(--text-gray);">
                        ({{ $ratingStats['total'] }} {{ Str::plural('review', $ratingStats['total']) }})
                    </span>
                @endif
            </h2>
            
            @auth
                @if($canReview && !$userReview)
                    <button class="btn-write-review" onclick="openReviewModal()">
                        <i class="fas fa-star"></i> Write a Review
                    </button>
                @endif
            @endauth
        </div>

        <!-- Rating Summary -->
        @if($ratingStats['total'] > 0)
            <div class="rating-summary">
                <div class="average-rating">
                    <div class="average-number">{{ number_format($ratingStats['average'], 1) }}</div>
                    <div class="average-stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($ratingStats['average']))
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <div class="total-reviews">{{ $ratingStats['total'] }} {{ Str::plural('review', $ratingStats['total']) }}</div>
                </div>
                
                <div class="rating-bars">
                    @for($star = 5; $star >= 1; $star--)
                        @php
                            $count = $ratingStats['distribution'][$star] ?? 0;
                            $percentage = $ratingStats['total'] > 0 ? round(($count / $ratingStats['total']) * 100) : 0;
                        @endphp
                        <div class="rating-bar-item">
                            <span class="rating-bar-label">{{ $star }} <i class="fas fa-star" style="color: #fbbf24;"></i></span>
                            <div class="rating-bar-container">
                                <div class="rating-bar-fill" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="rating-bar-count">{{ $count }}</span>
                        </div>
                    @endfor
                </div>
            </div>
        @endif

        <!-- User's Existing Review (if any) -->
        @if($userReview)
            <div class="review-card" style="border: 2px solid #f59e0b;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <span class="your-review-badge">
                        <i class="fas fa-star"></i> Your Review
                    </span>
                    @if(!$userReview->is_approved)
                        <span class="pending-badge">
                            <i class="fas fa-clock"></i> Pending Approval
                        </span>
                    @endif
                </div>
                <div class="reviewer-info">
                    <div class="reviewer-avatar">
                        {{ Auth::user()->initials }}
                    </div>
                    <div class="reviewer-details">
                        <h4>{{ Auth::user()->name }}</h4>
                        <div class="reviewer-stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $userReview->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                            <span>{{ $userReview->rating }}/5</span>
                        </div>
                    </div>
                </div>
                @if($userReview->title)
                    <h5 class="review-title">{{ $userReview->title }}</h5>
                @endif
                <p class="review-comment">{{ $userReview->comment }}</p>
                <div class="review-date">
                    <i class="fas fa-clock"></i> {{ $userReview->created_at->diffForHumans() }}
                </div>
                
                @if(!$userReview->is_approved)
                    <div style="display: flex; gap: 10px; margin-top: 15px;">
                        <button class="btn-helpful" onclick="editReview({{ json_encode($userReview) }})">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn-helpful" onclick="deleteReview({{ $userReview->id }})" style="color: #dc2626;">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                @endif
            </div>
        @endif

        <!-- All Reviews Grid -->
        @if($reviews->count() > 0)
            <div class="reviews-grid">
                @foreach($reviews as $review)
                    @if(!$userReview || $review->id != $userReview->id)
                        <div class="review-card">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">
                                    {{ $review->user->initials ?? substr($review->user->name, 0, 1) }}
                                </div>
                                <div class="reviewer-details">
                                    <h4>{{ $review->user->name }}</h4>
                                    <div class="reviewer-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                        <span>{{ $review->rating }}/5</span>
                                    </div>
                                </div>
                            </div>
                            @if($review->title)
                                <h5 class="review-title">{{ $review->title }}</h5>
                            @endif
                            <p class="review-comment">{{ $review->comment }}</p>
                            <div class="review-date">
                                <i class="fas fa-clock"></i> {{ $review->created_at->diffForHumans() }}
                            </div>
                            
                            @auth
                                <div class="review-helpful">
                                    <button class="btn-helpful" onclick="markHelpful({{ $review->id }})">
                                        <i class="fas fa-thumbs-up"></i> Helpful ({{ $review->helpful_count }})
                                    </button>
                                    <button class="btn-helpful" onclick="markNotHelpful({{ $review->id }})">
                                        <i class="fas fa-thumbs-down"></i> ({{ $review->not_helpful_count }})
                                    </button>
                                </div>
                            @endauth
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Pagination -->
            @if($reviews->hasPages())
                <div class="pagination-wrapper" style="margin-top: 30px;">
                    {{ $reviews->links('pagination::bootstrap-4') }}
                </div>
            @endif
        @elseif(!$userReview)
            <div class="empty-state" style="padding: 60px 20px; text-align: center;">
                <i class="fas fa-star" style="font-size: 48px; color: #cbd5e1; margin-bottom: 15px;"></i>
                <h4>No Reviews Yet</h4>
                <p style="color: var(--text-gray); margin-bottom: 20px;">Be the first to share your experience with this course!</p>
                @auth
                    @if($canReview)
                        <button class="btn-write-review" onclick="openReviewModal()">
                            <i class="fas fa-star"></i> Write a Review
                        </button>
                    @elseif($isEnrolled)
                        <p style="color: var(--text-gray);">Complete the course to write a review.</p>
                    @else
                        <p style="color: var(--text-gray);"><a href="{{ route('courses.registration', $course->slug) }}">Enroll</a> and complete the course to write a review.</p>
                    @endif
                @else
                    <div class="login-to-review">
                        <p><a href="{{ route('login') }}?redirect={{ urlencode(route('courses.show', $course->slug)) }}">Login</a> to write a review after completing the course.</p>
                    </div>
                @endauth
            </div>
        @endif
    </div>

    <!-- Related Courses -->
    @if($relatedCourses->count() > 0)
        <div class="related-section">
            <h3 class="card-title">
                <i class="fas fa-link"></i>
                Related Courses
            </h3>
            <div class="related-grid">
                @foreach($relatedCourses as $related)
                    <a href="{{ route('courses.show', $related->slug) }}" class="related-card">
                        <img src="{{ $related->image_url }}" alt="{{ $related->title }}" class="related-image">
                        <div class="related-info">
                            <h4>{{ Str::limit($related->title, 40) }}</h4>
                            <p>{{ $related->instructor_name }}</p>
                            <div class="related-price">
                                @if($related->price == 0)
                                    FREE
                                @else
                                    ${{ number_format($related->final_price, 2) }}
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>

<!-- Write Review Modal -->
<div class="modal" id="reviewModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-star"></i> Write a Review</h3>
            <button class="close-btn" onclick="closeReviewModal()">&times;</button>
        </div>
        <form id="reviewForm">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            
            <div class="rating-selector">
                <span class="star" onclick="setRating(1)" id="star1"><i class="far fa-star"></i></span>
                <span class="star" onclick="setRating(2)" id="star2"><i class="far fa-star"></i></span>
                <span class="star" onclick="setRating(3)" id="star3"><i class="far fa-star"></i></span>
                <span class="star" onclick="setRating(4)" id="star4"><i class="far fa-star"></i></span>
                <span class="star" onclick="setRating(5)" id="star5"><i class="far fa-star"></i></span>
            </div>
            <input type="hidden" name="rating" id="ratingValue" required>
            
            <div class="form-group">
                <label>Review Title (Optional)</label>
                <input type="text" name="title" class="form-control" placeholder="Summarize your experience" id="reviewTitle">
            </div>
            
            <div class="form-group">
                <label>Your Review</label>
                <textarea name="comment" class="form-control" rows="4" placeholder="Share your experience with this course..." required id="reviewComment"></textarea>
            </div>
            
            <div class="modal-actions">
                <button type="submit" class="btn-submit">Submit Review</button>
                <button type="button" class="btn-cancel" onclick="closeReviewModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Review Modal -->
<div class="modal" id="editReviewModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-edit"></i> Edit Your Review</h3>
            <button class="close-btn" onclick="closeEditReviewModal()">&times;</button>
        </div>
        <form id="editReviewForm">
            @csrf
            @method('PUT')
            <input type="hidden" name="review_id" id="editReviewId">
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            
            <div class="rating-selector">
                <span class="star" onclick="setEditRating(1)" id="editStar1"><i class="far fa-star"></i></span>
                <span class="star" onclick="setEditRating(2)" id="editStar2"><i class="far fa-star"></i></span>
                <span class="star" onclick="setEditRating(3)" id="editStar3"><i class="far fa-star"></i></span>
                <span class="star" onclick="setEditRating(4)" id="editStar4"><i class="far fa-star"></i></span>
                <span class="star" onclick="setEditRating(5)" id="editStar5"><i class="far fa-star"></i></span>
            </div>
            <input type="hidden" name="rating" id="editRatingValue" required>
            
            <div class="form-group">
                <label>Review Title (Optional)</label>
                <input type="text" name="title" class="form-control" id="editReviewTitle">
            </div>
            
            <div class="form-group">
                <label>Your Review</label>
                <textarea name="comment" class="form-control" rows="4" required id="editReviewComment"></textarea>
            </div>
            
            <div class="modal-actions">
                <button type="submit" class="btn-submit">Update Review</button>
                <button type="button" class="btn-cancel" onclick="closeEditReviewModal()">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let currentRating = 0;
    let currentEditRating = 0;

    // Re-enrollment Modal Functions
    function openReenrollModal() {
        document.getElementById('reenrollModal').style.display = 'flex';
    }

    function closeReenrollModal() {
        document.getElementById('reenrollModal').style.display = 'none';
        document.getElementById('reenrollForm').reset();
    }

    // Handle Re-enrollment Form Submit
    document.getElementById('reenrollForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('submitReenrollBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="loading-spinner-small"></span> Sending...';
        submitBtn.disabled = true;
        
        const formData = new FormData(this);
        
        fetch('{{ route("messages.send-to-admin") }}', {
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
                Swal.fire({
                    icon: 'success',
                    title: 'Request Sent!',
                    text: data.message,
                    timer: 3000,
                    showConfirmButton: false
                });
                closeReenrollModal();
            } else {
                Swal.fire('Error', data.message || 'Failed to send request', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Something went wrong', 'error');
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });

    // Review Functions
    function openReviewModal() {
        document.getElementById('reviewModal').style.display = 'flex';
        setRating(0);
        document.getElementById('reviewTitle').value = '';
        document.getElementById('reviewComment').value = '';
    }

    function closeReviewModal() {
        document.getElementById('reviewModal').style.display = 'none';
    }

    function setRating(rating) {
        currentRating = rating;
        document.getElementById('ratingValue').value = rating;
        
        for (let i = 1; i <= 5; i++) {
            const star = document.getElementById(`star${i}`);
            if (i <= rating) {
                star.innerHTML = '<i class="fas fa-star"></i>';
                star.classList.add('active');
            } else {
                star.innerHTML = '<i class="far fa-star"></i>';
                star.classList.remove('active');
            }
        }
    }

    document.getElementById('reviewForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (currentRating === 0) {
            Swal.fire('Error', 'Please select a rating', 'error');
            return;
        }
        
        const formData = new FormData(this);
        document.getElementById('loadingOverlay').style.display = 'flex';
        
        fetch(`/courses/{{ $course->id }}/reviews`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('loadingOverlay').style.display = 'none';
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Review Submitted!',
                    text: data.message,
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
                closeReviewModal();
            } else {
                Swal.fire('Error', data.message || 'Failed to submit review', 'error');
            }
        })
        .catch(error => {
            document.getElementById('loadingOverlay').style.display = 'none';
            Swal.fire('Error', 'Something went wrong', 'error');
        });
    });

    function editReview(review) {
        if (review.is_approved) {
            Swal.fire({
                icon: 'info',
                title: 'Review Already Approved',
                text: 'Approved reviews cannot be edited. Please contact admin if you need changes.',
                confirmButtonColor: '#2d3e50'
            });
            return;
        }
        
        document.getElementById('editReviewId').value = review.id;
        document.getElementById('editReviewTitle').value = review.title || '';
        document.getElementById('editReviewComment').value = review.comment;
        setEditRating(review.rating);
        document.getElementById('editReviewModal').style.display = 'flex';
    }

    function closeEditReviewModal() {
        document.getElementById('editReviewModal').style.display = 'none';
    }

    function setEditRating(rating) {
        currentEditRating = rating;
        document.getElementById('editRatingValue').value = rating;
        
        for (let i = 1; i <= 5; i++) {
            const star = document.getElementById(`editStar${i}`);
            if (i <= rating) {
                star.innerHTML = '<i class="fas fa-star"></i>';
                star.classList.add('active');
            } else {
                star.innerHTML = '<i class="far fa-star"></i>';
                star.classList.remove('active');
            }
        }
    }

    document.getElementById('editReviewForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (currentEditRating === 0) {
            Swal.fire('Error', 'Please select a rating', 'error');
            return;
        }
        
        const reviewId = document.getElementById('editReviewId').value;
        const formData = new FormData(this);
        formData.append('_method', 'PUT');
        
        document.getElementById('loadingOverlay').style.display = 'flex';
        
        fetch(`/courses/{{ $course->id }}/reviews/${reviewId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('loadingOverlay').style.display = 'none';
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Review Updated!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
                closeEditReviewModal();
            } else {
                Swal.fire('Error', data.message || 'Failed to update review', 'error');
            }
        })
        .catch(error => {
            document.getElementById('loadingOverlay').style.display = 'none';
            Swal.fire('Error', 'Something went wrong', 'error');
        });
    });

    function deleteReview(reviewId) {
        Swal.fire({
            title: 'Delete Review?',
            text: 'Are you sure you want to delete your review?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Yes, delete it'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('loadingOverlay').style.display = 'flex';
                
                fetch(`/courses/{{ $course->id }}/reviews/${reviewId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message || 'Failed to delete review', 'error');
                    }
                })
                .catch(error => {
                    document.getElementById('loadingOverlay').style.display = 'none';
                    Swal.fire('Error', 'Something went wrong', 'error');
                });
            }
        });
    }

    function markHelpful(reviewId) {
        fetch(`/courses/{{ $course->id }}/reviews/${reviewId}/helpful`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }

    function markNotHelpful(reviewId) {
        fetch(`/courses/{{ $course->id }}/reviews/${reviewId}/not-helpful`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
</script>
@endsection