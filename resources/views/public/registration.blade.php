@extends('layouts.app')

@section('title', 'Register for ' . $course->title)
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
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .public-page {
        background-color: var(--bg-light);
    }

    .registration-container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        padding-bottom: 100px;
    }

    /* Back Link */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: var(--text-gray);
        text-decoration: none;
        font-size: 15px;
        margin-bottom: 25px;
        padding: 8px 20px;
        background: white;
        border-radius: 30px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .back-link:hover {
        color: var(--primary-navy);
        border-color: var(--primary-navy);
        transform: translateX(-5px);
    }

    /* Registration Card */
    .registration-card {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 30px;
    }

    @media (max-width: 992px) {
        .registration-card {
            grid-template-columns: 1fr;
        }
    }

    /* Left Column - Form */
    .form-section {
        background: white;
        border-radius: 30px;
        padding: 40px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-lg);
    }

    .section-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 10px;
    }

    .section-subtitle {
        color: var(--text-gray);
        font-size: 16px;
        margin-bottom: 30px;
    }

    .course-badge {
        display: inline-block;
        background: var(--secondary-blue);
        color: white;
        padding: 8px 20px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 30px;
    }

    .payment-methods {
        margin-bottom: 30px;
    }

    .payment-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .payment-title i {
        color: var(--secondary-blue);
    }

    .payment-options {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .payment-option {
        position: relative;
    }

    .payment-option input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .payment-option label {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        padding: 25px 15px;
        background: #f8fafc;
        border: 2px solid var(--border-color);
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-option input[type="radio"]:checked + label {
        border-color: var(--secondary-blue);
        background: #f0f7ff;
        box-shadow: var(--shadow-md);
    }

    .payment-option label i {
        font-size: 40px;
    }

    .payment-option label i.fa-credit-card {
        color: #2563eb;
    }

    .payment-option label i.fa-paypal {
        color: #003087;
    }

    .payment-option label span {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-dark);
    }

    .payment-note {
        background: #fef3c7;
        border: 1px solid #fde68a;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .payment-note i {
        font-size: 24px;
        color: #d97706;
    }

    .payment-note p {
        color: #92400e;
        font-size: 14px;
        line-height: 1.6;
        margin: 0;
    }

    .terms-checkbox {
        margin-bottom: 30px;
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        font-size: 15px;
        color: var(--text-dark);
    }

    .checkbox-label input {
        width: 20px;
        height: 20px;
        accent-color: var(--primary-navy);
    }

    .checkbox-label a {
        color: var(--secondary-blue);
        text-decoration: none;
        font-weight: 600;
    }

    .checkbox-label a:hover {
        text-decoration: underline;
    }

    .form-actions {
        display: flex;
        gap: 15px;
    }

    .btn-primary {
        flex: 1;
        padding: 16px;
        background: var(--primary-navy);
        color: white;
        border: none;
        border-radius: 16px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-primary:hover {
        background: #1a252f;
        transform: translateY(-3px);
        box-shadow: var(--shadow-xl);
    }

    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .btn-secondary {
        padding: 16px 30px;
        background: white;
        color: var(--text-gray);
        border: 2px solid var(--border-color);
        border-radius: 16px;
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
        border-color: var(--primary-navy);
        color: var(--primary-navy);
        transform: translateY(-2px);
    }

    /* Right Column - Course Summary */
    .summary-section {
        background: linear-gradient(135deg, #f0f9ff 0%, #e6f0fa 100%);
        border-radius: 30px;
        padding: 40px;
        border: 1px solid #bae6fd;
        box-shadow: var(--shadow-lg);
        position: sticky;
        top: 100px;
    }

    .summary-title {
        font-size: 20px;
        font-weight: 700;
        color: #0369a1;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .summary-title i {
        color: var(--secondary-blue);
    }

    .course-image {
        width: 100%;
        height: 180px;
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 25px;
    }

    .course-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .course-info h3 {
        font-size: 22px;
        font-weight: 700;
        color: var(--primary-navy);
        margin-bottom: 10px;
    }

    .instructor {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-gray);
        font-size: 14px;
        margin-bottom: 20px;
    }

    .instructor i {
        color: var(--secondary-blue);
    }

    .price-breakdown {
        background: white;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 25px;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .price-row:last-child {
        border-bottom: none;
    }

    .price-label {
        color: var(--text-gray);
    }

    .price-value {
        font-weight: 600;
        color: var(--text-dark);
    }

    .total-row {
        font-size: 18px;
        font-weight: 700;
        color: var(--primary-navy);
        padding-top: 15px;
    }

    .course-meta {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 15px;
        background: white;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
    }

    .meta-icon {
        width: 45px;
        height: 45px;
        background: #e0f2fe;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--secondary-blue);
        font-size: 18px;
    }

    .meta-content {
        flex: 1;
    }

    .meta-label {
        font-size: 12px;
        color: var(--text-gray);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .meta-value {
        font-size: 15px;
        font-weight: 600;
        color: var(--text-dark);
    }

    /* Free Course Specific */
    .free-badge-large {
        background: #dcfce7;
        color: #15803d;
        padding: 12px 25px;
        border-radius: 40px;
        font-size: 18px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 25px;
    }

    .free-message {
        background: #dcfce7;
        border: 1px solid #86efac;
        border-radius: 16px;
        padding: 25px;
        text-align: center;
        margin-bottom: 30px;
    }

    .free-message i {
        font-size: 48px;
        color: #15803d;
        margin-bottom: 15px;
    }

    .free-message h4 {
        font-size: 20px;
        color: #15803d;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .free-message p {
        color: #166534;
        margin-bottom: 20px;
    }

    .btn-free {
        background: #15803d;
        color: white;
        border: none;
        padding: 16px 30px;
        border-radius: 40px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .btn-free:hover {
        background: #0f9e6a;
        transform: translateY(-3px);
        box-shadow: var(--shadow-xl);
    }

    /* Loading Overlay */
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
        .registration-container {
            padding: 20px 15px;
        }

        .form-section,
        .summary-section {
            padding: 25px;
        }

        .payment-options {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .summary-section {
            position: static;
        }
    }
</style>
@endsection

@section('content')
<div class="registration-container">
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Back Link -->
    <a href="{{ route('courses.show', $course->slug) }}" class="back-link">
        <i class="fas fa-arrow-left"></i>
        Back to Course Details
    </a>

    <div class="registration-card">
        <!-- Left Column - Registration Form -->
        <div class="form-section">
            <h1 class="section-title">
                @if($course->price == 0 || $course->discounted_price == 0)
                    🎁 Free Enrollment
                @else
                    Complete Your Registration
                @endif
            </h1>
            <p class="section-subtitle">{{ $course->title }}</p>
            
            @if($course->price > 0 && ($course->discounted_price ?? $course->price) > 0)
                <!-- Paid Course Form -->
                <div class="course-badge">
                    <i class="fas fa-lock"></i> Secure Checkout
                </div>

                <form id="paymentForm" method="POST" action="{{ route('courses.register.process', $course) }}">
                    @csrf
                    
                    <div class="payment-methods">
                        <h3 class="payment-title">
                            <i class="fas fa-credit-card"></i>
                            Select Payment Method
                        </h3>

                        <div class="payment-options">
                            <div class="payment-option">
                                <input type="radio" name="payment_method" id="card" value="card" checked>
                                <label for="card">
                                    <i class="fas fa-credit-card"></i>
                                    <span>Credit Card</span>
                                </label>
                            </div>
                            
                            <div class="payment-option">
                                <input type="radio" name="payment_method" id="paypal" value="paypal">
                                <label for="paypal">
                                    <i class="fab fa-paypal"></i>
                                    <span>PayPal</span>
                                </label>
                            </div>
                        </div>

                        <!-- Payment Simulation Notice -->
                        <div class="payment-note">
                            <i class="fas fa-info-circle"></i>
                            <p>
                                <strong>Demo Mode:</strong> This is a simulated payment. 
                                No real money will be charged. Click "Complete Payment" to proceed.
                            </p>
                        </div>
                    </div>

                    <div class="terms-checkbox">
                        <label class="checkbox-label">
                            <input type="checkbox" name="terms" required>
                            <span>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></span>
                        </label>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-primary" id="submitBtn">
                            <i class="fas fa-lock"></i>
                            Complete Payment
                        </button>
                        <a href="{{ route('courses.show', $course->slug) }}" class="btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            @else
                <!-- Free Course Form -->
                <div class="free-message">
                    <i class="fas fa-gift"></i>
                    <h4>This Course is FREE!</h4>
                    <p>Enroll now and start learning immediately. No payment required.</p>
                    <button type="button" class="btn-free" id="freeEnrollBtn">
                        <i class="fas fa-rocket"></i>
                        Enroll for Free
                    </button>
                </div>

                <div class="terms-checkbox">
                    <label class="checkbox-label">
                        <input type="checkbox" id="freeTerms" required>
                        <span>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></span>
                    </label>
                </div>

                <div class="form-actions">
                    <a href="{{ route('courses.show', $course->slug) }}" class="btn-secondary" style="flex: 1;">
                        Cancel
                    </a>
                </div>
            @endif
        </div>

        <!-- Right Column - Course Summary -->
        <div class="summary-section">
            <h3 class="summary-title">
                <i class="fas fa-receipt"></i>
                Order Summary
            </h3>

            <div class="course-image">
                <img src="{{ $course->image_url }}" alt="{{ $course->title }}">
            </div>

            <div class="course-info">
                <h3>{{ $course->title }}</h3>
                <div class="instructor">
                    <i class="fas fa-chalkboard-teacher"></i>
                    {{ $course->instructor_name }}
                </div>
            </div>

            <div class="price-breakdown">
                <div class="price-row">
                    <span class="price-label">Course Price</span>
                    <span class="price-value">${{ number_format($course->price, 2) }}</span>
                </div>
                
                @if($course->discounted_price && $course->discounted_price < $course->price)
                    <div class="price-row">
                        <span class="price-label">Discount</span>
                        <span class="price-value" style="color: #10b981;">
                            -${{ number_format($course->price - $course->discounted_price, 2) }}
                        </span>
                    </div>
                @endif
                
                <div class="price-row total-row">
                    <span class="price-label">Total</span>
                    <span class="price-value">
                        @if($course->price == 0 || $course->discounted_price == 0)
                            FREE
                        @else
                            ${{ number_format($course->discounted_price ?? $course->price, 2) }}
                        @endif
                    </span>
                </div>
            </div>

            <div class="course-meta">
                <div class="meta-item">
                    <div class="meta-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="meta-content">
                        <div class="meta-label">Duration</div>
                        <div class="meta-value">{{ $course->duration ?? '4 weeks' }}</div>
                    </div>
                </div>

                <div class="meta-item">
                    <div class="meta-icon">
                        <i class="fas fa-signal"></i>
                    </div>
                    <div class="meta-content">
                        <div class="meta-label">Level</div>
                        <div class="meta-value">{{ ucfirst($course->level) }}</div>
                    </div>
                </div>

                <div class="meta-item">
                    <div class="meta-icon">
                        <i class="fas fa-video"></i>
                    </div>
                    <div class="meta-content">
                        <div class="meta-label">Format</div>
                        <div class="meta-value">{{ ucfirst($course->format) }}</div>
                    </div>
                </div>

                <div class="meta-item">
                    <div class="meta-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="meta-content">
                        <div class="meta-label">Students</div>
                        <div class="meta-value">{{ $course->total_students ?? 0 }} enrolled</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Free Course Enrollment
        const freeEnrollBtn = document.getElementById('freeEnrollBtn');
        const freeTerms = document.getElementById('freeTerms');

        if (freeEnrollBtn) {
            freeEnrollBtn.addEventListener('click', function() {
                if (!freeTerms || !freeTerms.checked) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Terms Required',
                        text: 'Please agree to the Terms of Service to continue.',
                        confirmButtonColor: '#2d3e50'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Enroll in Course?',
                    text: 'You are about to enroll in this free course.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Enroll',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#2d3e50',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        enrollFreeCourse();
                    }
                });
            });
        }

        // Paid Course Form Submission
        const paymentForm = document.getElementById('paymentForm');
        if (paymentForm) {
            paymentForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const termsChecked = document.querySelector('input[name="terms"]').checked;
                if (!termsChecked) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Terms Required',
                        text: 'Please agree to the Terms of Service to continue.',
                        confirmButtonColor: '#2d3e50'
                    });
                    return;
                }

                const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
                
                // Show payment simulation alert
                Swal.fire({
                    title: 'Demo Payment Simulation',
                    html: `
                        <div style="text-align: left;">
                            <p><strong>Payment Method:</strong> ${paymentMethod === 'card' ? 'Credit Card' : 'PayPal'}</p>
                            <p><strong>Note:</strong> This is a demo. No real payment will be processed.</p>
                        </div>
                    `,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Enroll Anyway',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#2d3e50',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitPaymentForm();
                    }
                });
            });
        }
    });

    function enrollFreeCourse() {
        const btn = document.getElementById('freeEnrollBtn');
        const originalText = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enrolling...';
        document.getElementById('loadingOverlay').style.display = 'flex';
        
        fetch('{{ route("courses.free-enroll", $course) }}', {
            method: 'POST',
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
                    title: 'Enrolled Successfully!',
                    text: data.message || 'You are now enrolled in this course.',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = data.redirect;
                });
            } else {
                btn.disabled = false;
                btn.innerHTML = originalText;
                
                if (data.redirect) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Already Enrolled',
                        text: data.message || 'You are already enrolled in this course.',
                        confirmButtonColor: '#2d3e50'
                    }).then(() => {
                        window.location.href = data.redirect;
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to enroll. Please try again.',
                        confirmButtonColor: '#2d3e50'
                    });
                }
            }
        })
        .catch(error => {
            document.getElementById('loadingOverlay').style.display = 'none';
            btn.disabled = false;
            btn.innerHTML = originalText;
            
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Something went wrong. Please try again.',
                confirmButtonColor: '#2d3e50'
            });
        });
    }

    function submitPaymentForm() {
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        document.getElementById('loadingOverlay').style.display = 'flex';
        
        // Submit the form
        document.getElementById('paymentForm').submit();
    }
</script>
@endsection