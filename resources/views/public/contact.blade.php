@extends('layouts.app')

@section('title', 'Contact Us - Shifra Training Center')
@section('body-class', 'public-page')

@section('styles')
<style>
    :root {
        --primary-navy: #2d3e50;
        --secondary-blue: #3182ce;
        --accent-green: #10b981;
        --accent-orange: #f59e0b;
        --accent-purple: #8b5cf6;
        --text-dark: #1e293b;
        --text-gray: #64748b;
        --text-light: #94a3b8;
        --bg-light: #f8fbff;
        --white: #ffffff;
        --border-color: #e2e8f0;
    }

    .contact-page {
        background: linear-gradient(135deg, #f8fbff 0%, #f0f5fa 100%);
        min-height: 100vh;
        padding: 40px 20px 80px;
    }

    .contact-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Hero Section */
    .contact-hero {
        text-align: center;
        margin-bottom: 60px;
        animation: fadeInDown 0.8s ease;
    }

    .contact-hero h1 {
        font-size: 48px;
        font-weight: 800;
        color: var(--primary-navy);
        margin-bottom: 20px;
        position: relative;
        display: inline-block;
    }

    .contact-hero h1::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 4px;
        background: linear-gradient(90deg, var(--secondary-blue), var(--accent-purple));
        border-radius: 2px;
    }

    .contact-hero p {
        font-size: 18px;
        color: var(--text-gray);
        max-width: 700px;
        margin: 30px auto 0;
        line-height: 1.8;
    }

    /* Main Grid Layout */
    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-bottom: 60px;
    }

    @media (max-width: 992px) {
        .contact-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 30px;
        padding: 40px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        border: 1px solid var(--border-color);
        animation: fadeInLeft 0.8s ease;
    }

    .form-card h2 {
        font-size: 28px;
        color: var(--primary-navy);
        margin-bottom: 10px;
        font-weight: 700;
    }

    .form-card p {
        color: var(--text-gray);
        margin-bottom: 30px;
        font-size: 15px;
    }

    .contact-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 576px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-dark);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .form-group label i {
        color: var(--secondary-blue);
        font-size: 14px;
    }

    .form-group label span {
        color: #ef4444;
        font-size: 14px;
    }

    .form-control {
        padding: 14px 16px;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: #fafafa;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--secondary-blue);
        background: white;
        box-shadow: 0 0 0 4px rgba(49, 130, 206, 0.1);
    }

    .form-control.error {
        border-color: #ef4444;
    }

    textarea.form-control {
        min-height: 140px;
        resize: vertical;
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--primary-navy), var(--secondary-blue));
        color: white;
        padding: 16px 30px;
        border: none;
        border-radius: 16px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 10px;
    }

    .btn-submit:hover:not(:disabled) {
        transform: translateY(-3px);
        box-shadow: 0 20px 30px rgba(45, 62, 80, 0.2);
    }

    .btn-submit:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .btn-submit i {
        font-size: 16px;
    }

    /* Info Block */
    .info-block {
        background: linear-gradient(135deg, #f0f9ff, #e6f0fa);
        border-radius: 20px;
        padding: 25px;
        margin-top: 30px;
        border: 1px solid var(--border-color);
        position: relative;
        overflow: hidden;
    }

    .info-block::before {
        content: '';
        position: absolute;
        top: -20px;
        right: -20px;
        width: 100px;
        height: 100px;
        background: rgba(49, 130, 206, 0.05);
        border-radius: 50%;
    }

    .info-block h4 {
        font-size: 18px;
        color: var(--primary-navy);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
    }

    .info-block h4 i {
        color: var(--secondary-blue);
    }

    .info-block p {
        color: var(--text-dark);
        font-size: 14px;
        line-height: 1.7;
        margin-bottom: 15px;
        position: relative;
        padding-left: 15px;
        border-left: 3px solid var(--secondary-blue);
    }

    .info-features {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .info-features {
            grid-template-columns: 1fr;
        }
    }

    .info-feature {
        background: white;
        padding: 15px;
        border-radius: 12px;
        text-align: center;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .info-feature:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        border-color: var(--secondary-blue);
    }

    .info-feature i {
        font-size: 24px;
        color: var(--secondary-blue);
        margin-bottom: 8px;
    }

    .info-feature span {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-dark);
        display: block;
    }

    .info-feature small {
        font-size: 11px;
        color: var(--text-gray);
    }

    .demo-badge {
        display: inline-block;
        background: linear-gradient(135deg, var(--accent-purple), var(--secondary-blue));
        color: white;
        padding: 4px 12px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 600;
        margin-left: 10px;
        vertical-align: middle;
    }

    /* Info Card */
    .info-card {
        background: white;
        border-radius: 30px;
        padding: 40px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        border: 1px solid var(--border-color);
        animation: fadeInRight 0.8s ease;
        height: fit-content;
    }

    .info-card h2 {
        font-size: 28px;
        color: var(--primary-navy);
        margin-bottom: 30px;
        font-weight: 700;
    }

    /* Map Container */
    .map-wrapper {
        width: 100%;
        height: 250px;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 30px;
        border: 1px solid var(--border-color);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    .map-wrapper iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    /* Contact Details - Single Column */
    .details-container {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 30px;
    }

    .detail-row {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 18px 20px;
        background: #f8fafc;
        border-radius: 16px;
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
        width: 100%;
    }

    .detail-row:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        border-color: var(--secondary-blue);
    }

    .detail-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--secondary-blue), var(--accent-purple));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        flex-shrink: 0;
    }

    .detail-content {
        flex: 1;
    }

    .detail-content h4 {
        font-size: 14px;
        color: var(--text-gray);
        margin-bottom: 4px;
        font-weight: 500;
    }

    .detail-content p {
        font-size: 16px;
        color: var(--text-dark);
        font-weight: 600;
        line-height: 1.5;
    }

    .detail-content a {
        color: var(--text-dark);
        text-decoration: none;
        transition: color 0.3s ease;
        font-size: 16px;
        font-weight: 600;
    }

    .detail-content a:hover {
        color: var(--secondary-blue);
    }

    /* Business Hours Card */
    .hours-card {
        background: linear-gradient(135deg, #f0f9ff, #e6f0fa);
        border-radius: 20px;
        padding: 25px;
        margin-top: 20px;
        border: 1px solid var(--border-color);
    }

    .hours-card h4 {
        font-size: 16px;
        color: var(--primary-navy);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
    }

    .hours-card h4 i {
        color: var(--secondary-blue);
    }

    .hours-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px dashed rgba(45, 62, 80, 0.1);
    }

    .hours-row:last-child {
        border-bottom: none;
    }

    .hours-day {
        font-weight: 600;
        color: var(--text-dark);
    }

    .hours-time {
        color: var(--secondary-blue);
        font-weight: 500;
    }

    /* Social Links - CENTERED */
    .social-section {
        margin-top: 60px;
        text-align: center;
        animation: fadeInUp 0.8s ease;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .social-section h3 {
        font-size: 24px;
        color: var(--primary-navy);
        margin-bottom: 30px;
        font-weight: 700;
        position: relative;
        display: inline-block;
    }

    .social-section h3::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, var(--secondary-blue), var(--accent-purple));
        border-radius: 2px;
    }

    .social-grid {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 25px;
        flex-wrap: wrap;
        margin: 0 auto;
        max-width: 600px;
    }

    .social-link {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: white;
        color: var(--text-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        transition: all 0.3s ease;
        text-decoration: none;
        border: 2px solid var(--border-color);
        box-shadow: 0 8px 15px rgba(0,0,0,0.05);
    }

    .social-link:hover {
        transform: translateY(-10px) scale(1.1);
        color: white;
        border-color: transparent;
        box-shadow: 0 20px 30px rgba(0,0,0,0.15);
    }

    .social-link.whatsapp:hover {
        background: #25D366;
    }

    .social-link.instagram:hover {
        background: linear-gradient(45deg, #f09433, #d62976, #962fbf, #4f5bd5);
    }

    .social-link.email:hover {
        background: #ea4335;
    }

    .social-link.map:hover {
        background: #34a853;
    }

    /* Success Message */
    .success-message {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        display: none;
        align-items: center;
        justify-content: center;
        gap: 10px;
        animation: slideDown 0.5s ease;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
        width: 100%;
    }

    .success-message.show {
        display: flex;
    }

    .success-message i {
        font-size: 20px;
    }

    /* Loading Spinner */
    .loading-spinner-small {
        display: inline-block;
        width: 18px;
        height: 18px;
        border: 2px solid rgba(255,255,255,0.3);
        border-top-color: white;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Error States */
    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 4px;
    }

    /* Animations */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
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

    /* Responsive */
    @media (max-width: 768px) {
        .contact-hero h1 {
            font-size: 36px;
        }

        .form-card,
        .info-card {
            padding: 30px 20px;
        }
        
        .detail-row {
            flex-wrap: wrap;
        }

        .social-link {
            width: 60px;
            height: 60px;
            font-size: 24px;
        }
    }
</style>
@endsection

@section('content')
<div class="contact-page">
    <div class="contact-container">
        <!-- Hero Section -->
        <div class="contact-hero">
            <h1>Get In Touch</h1>
            <p>Have questions about our courses or need assistance? We're here to help! Reach out to us anytime.</p>
        </div>

        <!-- Flash Success Message (for non-AJAX) -->
        @if(session('success'))
            <div class="success-message show" id="flashSuccess">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Main Grid -->
        <div class="contact-grid">
            <!-- Left Column - Contact Form -->
            <div class="form-card">
                <h2>Send Us a Message</h2>
                <p>We'll get back to you within 24 hours</p>

                <form class="contact-form" id="contactForm" method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>
                                <i class="fas fa-user"></i>
                                Full Name <span>*</span>
                            </label>
                            <input type="text" name="name" class="form-control @error('name') error @enderror" 
                                   placeholder="John Doe" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>
                                <i class="fas fa-envelope"></i>
                                Email <span>*</span>
                            </label>
                            <input type="email" name="email" class="form-control @error('email') error @enderror" 
                                   placeholder="john@example.com" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>
                                <i class="fas fa-phone"></i>
                                Phone Number
                            </label>
                            <input type="tel" name="phone" class="form-control" 
                                   placeholder="+970 59 123 4567" value="{{ old('phone') }}">
                        </div>

                        <div class="form-group">
                            <label>
                                <i class="fas fa-tag"></i>
                                Subject <span>*</span>
                            </label>
                            <input type="text" name="subject" class="form-control @error('subject') error @enderror" 
                                   placeholder="Course Inquiry" value="{{ old('subject') }}" required>
                            @error('subject')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                            <i class="fas fa-comment"></i>
                            Message <span>*</span>
                        </label>
                        <textarea name="message" class="form-control @error('message') error @enderror" 
                                  placeholder="How can we help you?" required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn">
                        <i class="fas fa-paper-plane"></i>
                        Send Message
                    </button>
                </form>

                <!-- Info Block About Message Handling -->
                <div class="info-block">
                    <h4>
                        <i class="fas fa-info-circle"></i>
                        About Your Message
                        <span class="demo-badge">Training Project</span>
                    </h4>
                    <p>
                        This is a practical training project for educational purposes. While the form is fully functional 
                        and your message will be saved in our database, please note that this is a demonstration platform 
                        and not a live commercial service.
                    </p>
                    
                    <div class="info-features">
                        <div class="info-feature">
                            <i class="fas fa-database"></i>
                            <span>Saved in Database</span>
                            <small>Your message is stored securely</small>
                        </div>
                        <div class="info-feature">
                            <i class="fas fa-envelope-open-text"></i>
                            <span>Demo Purpose Only</span>
                            <small>No actual email is sent</small>
                        </div>
                        <div class="info-feature">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Training Project</span>
                            <small>Showcasing Laravel skills</small>
                        </div>
                    </div>

                    <p style="margin-top: 15px; font-size: 13px; color: var(--text-gray); border-left: none; padding-left: 0;">
                        <i class="fas fa-lightbulb" style="color: var(--accent-orange);"></i>
                        This platform was developed as a practical training project to demonstrate full-stack web development 
                        capabilities using Laravel, including database integration, form validation, AJAX requests, and 
                        responsive design.
                    </p>
                </div>
            </div>

            <!-- Right Column - Contact Information -->
            <div class="info-card">
                <h2>Contact Information</h2>

                <!-- Map -->
                <div class="map-wrapper">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5405.944813507409!2d34.4353623!3d31.5243795!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14fd7f5a0b9b9b9b%3A0x9b9b9b9b9b9b9b9b!2sAl-Shifa%20Medical%20Complex!5e0!3m2!1sen!2s!4v1700000000000!5m2!1sen!2s" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>

                <!-- Contact Details - Single Column Layout -->
                <div class="details-container">
                    <!-- Address Row -->
                    <div class="detail-row">
                        <div class="detail-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="detail-content">
                            <h4>Address</h4>
                            <p>{{ $contactInfo['address'] }}</p>
                        </div>
                    </div>

                    <!-- Phone Row -->
                    <div class="detail-row">
                        <div class="detail-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="detail-content">
                            <h4>Phone</h4>
                            <p><a href="tel:{{ $contactInfo['phone'] }}">{{ $contactInfo['phone'] }}</a></p>
                        </div>
                    </div>

                    <!-- Email Row -->
                    <div class="detail-row">
                        <div class="detail-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="detail-content">
                            <h4>Email</h4>
                            <p><a href="mailto:{{ $contactInfo['email'] }}">{{ $contactInfo['email'] }}</a></p>
                        </div>
                    </div>

                    <!-- Working Hours Row -->
                    <div class="detail-row">
                        <div class="detail-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="detail-content">
                            <h4>Working Hours</h4>
                            <p>{{ $contactInfo['hours'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Business Hours Card -->
                <div class="hours-card">
                    <h4>
                        <i class="fas fa-calendar-alt"></i>
                        Weekly Schedule
                    </h4>
                    <div class="hours-row">
                        <span class="hours-day">Saturday - Thursday</span>
                        <span class="hours-time">9:00 AM - 5:00 PM</span>
                    </div>
                    <div class="hours-row">
                        <span class="hours-day">Friday</span>
                        <span class="hours-time">Closed</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Links Section -->
        <div class="social-section">
            <h3>Connect With Us</h3>
            <div class="social-grid">
                <a href="mailto:{{ $contactInfo['email'] }}" class="social-link email" title="Email">
                    <i class="fas fa-envelope"></i>
                </a>
                <a href="{{ $contactInfo['whatsapp'] }}" target="_blank" class="social-link whatsapp" title="WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
                <a href="{{ $contactInfo['instagram'] }}" target="_blank" class="social-link instagram" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="{{ $contactInfo['map_url'] }}" target="_blank" class="social-link map" title="Location">
                    <i class="fas fa-map-marker-alt"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contactForm = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submitBtn');

        // Auto-hide flash messages
        const flashSuccess = document.getElementById('flashSuccess');
        if (flashSuccess) {
            setTimeout(() => {
                flashSuccess.style.opacity = '0';
                setTimeout(() => {
                    flashSuccess.style.display = 'none';
                }, 300);
            }, 5000);
        }

        if (contactForm) {
            contactForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const originalText = submitBtn.innerHTML;

                // Show loading state
                submitBtn.innerHTML = '<span class="loading-spinner-small"></span> Sending...';
                submitBtn.disabled = true;

                // Clear previous errors
                document.querySelectorAll('.error-message').forEach(el => el.remove());
                document.querySelectorAll('.form-control.error').forEach(el => {
                    el.classList.remove('error');
                });

                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await response.json();

                    if (response.ok && data.success) {
                        // Show SweetAlert success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Message Sent!',
                            html: `
                                <div style="text-align: center;">
                                    <p style="margin-bottom: 10px; color: #2d3e50;">${data.message}</p>
                                    <div style="background: #f8fafc; padding: 15px; border-radius: 10px; margin-top: 10px;">
                                        <i class="fas fa-info-circle" style="color: #3182ce;"></i>
                                        <p style="font-size: 13px; color: #64748b; margin-top: 5px;">
                                            This is a training project demo. Your message has been saved in our database.
                                        </p>
                                    </div>
                                </div>
                            `,
                            confirmButtonColor: '#2d3e50',
                            confirmButtonText: 'Great!',
                            timer: 5000,
                            timerProgressBar: true,
                            background: 'white',
                            backdrop: 'rgba(45, 62, 80, 0.2)'
                        });

                        // Reset form
                        this.reset();
                    } else if (data.errors) {
                        // Display validation errors with SweetAlert
                        let errorHtml = '<div style="text-align: left;">';
                        Object.keys(data.errors).forEach(field => {
                            const input = document.querySelector(`[name="${field}"]`);
                            if (input) {
                                input.classList.add('error');
                                errorHtml += `<p style="color: #ef4444; margin-bottom: 5px;"><i class="fas fa-exclamation-circle"></i> ${data.errors[field][0]}</p>`;
                            }
                        });
                        errorHtml += '</div>';

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: errorHtml,
                            confirmButtonColor: '#2d3e50'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.message || 'An error occurred. Please try again.',
                            confirmButtonColor: '#2d3e50'
                        });
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Connection Error',
                        text: 'Could not connect to server. Please check your internet connection.',
                        confirmButtonColor: '#2d3e50'
                    });
                } finally {
                    // Restore button
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            });
        }

        // Hover effects for cards
        document.querySelectorAll('.detail-row, .social-link, .info-feature').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Input focus effects
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });
    });
</script>
@endsection