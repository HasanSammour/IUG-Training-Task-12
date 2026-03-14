@extends('layouts.app')

@section('title', 'Add New Enrollment - Admin')
@section('body-class', 'admin-page')

@section('styles')
<style>
    .admin-container {
        padding: 20px;
        max-width: 900px;
        margin: 0 auto;
        width: 100%;
    }

    /* Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e2e8f0;
    }

    .page-title {
        font-size: 24px;
        color: #2D3E50;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-title i {
        color: #f59e0b;
    }

    .back-btn {
        color: #64748b;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
        padding: 8px 16px;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }

    .back-btn:hover {
        color: #2D3E50;
        background: #f1f5f9;
        transform: translateX(-5px);
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        border: 1px solid #edf2f7;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
    }

    .form-section {
        margin-bottom: 30px;
        padding-bottom: 25px;
        border-bottom: 1px solid #f1f5f9;
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .section-title {
        font-size: 16px;
        color: #2D3E50;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-title i {
        color: #f59e0b;
        font-size: 18px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .form-label .required {
        color: #ef4444;
        margin-left: 4px;
    }

    .form-input, .form-select {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        color: #2D3E50;
        background: white;
        transition: all 0.3s ease;
    }

    .form-input:focus, .form-select:focus {
        border-color: #2D3E50;
        outline: none;
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    .form-input:hover, .form-select:hover {
        border-color: #94a3b8;
    }

    .form-input:disabled {
        background: #f1f5f9;
        color: #94a3b8;
        cursor: not-allowed;
        border-color: #e2e8f0;
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

    /* Status Section */
    .status-section {
        background: #f8fafc;
        padding: 25px;
        border-radius: 12px;
        margin: 25px 0;
        border: 1px solid #e2e8f0;
    }

    .progress-container {
        margin-top: 20px;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .progress-header label {
        font-weight: 600;
        color: #2D3E50;
        font-size: 14px;
    }

    .progress-value {
        font-size: 18px;
        color: #2D3E50;
        font-weight: 700;
        background: white;
        padding: 4px 12px;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
    }

    .progress-slider {
        width: 100%;
        height: 8px;
        -webkit-appearance: none;
        background: #e2e8f0;
        border-radius: 10px;
        outline: none;
        margin: 15px 0;
    }

    .progress-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 22px;
        height: 22px;
        background: #2D3E50;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid white;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        transition: all 0.2s ease;
    }

    .progress-slider::-webkit-slider-thumb:hover {
        transform: scale(1.15);
        background: #f59e0b;
    }

    .progress-slider::-moz-range-thumb {
        width: 22px;
        height: 22px;
        background: #2D3E50;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid white;
        box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    .progress-markers {
        display: flex;
        justify-content: space-between;
        padding: 0 5px;
        color: #94a3b8;
        font-size: 11px;
        margin-top: 5px;
    }

    /* Amount Display */
    .amount-display {
        background: linear-gradient(135deg, #f0f9ff, #e6f0fa);
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #dbeafe;
        margin-bottom: 20px;
    }

    .amount-label {
        font-size: 12px;
        color: #0369a1;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 5px;
    }

    .amount-value {
        font-size: 28px;
        font-weight: 700;
        color: #2D3E50;
    }

    .amount-value small {
        font-size: 14px;
        font-weight: 400;
        color: #64748b;
        margin-left: 8px;
    }

    /* Student/Course Preview */
    .selection-preview {
        display: none;
        background: #f8fafc;
        padding: 15px;
        border-radius: 10px;
        margin-top: 10px;
        border: 1px solid #e2e8f0;
    }

    .selection-preview.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .preview-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .preview-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2D3E50, #f59e0b);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 16px;
    }

    .preview-info h4 {
        font-size: 15px;
        color: #2D3E50;
        margin-bottom: 4px;
    }

    .preview-info p {
        font-size: 12px;
        color: #64748b;
    }

    /* Payment Method Hint */
    .payment-hint {
        font-size: 12px;
        color: #10b981;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .payment-hint i {
        font-size: 12px;
    }

    /* Error Messages */
    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .error-message i {
        font-size: 12px;
    }

    .form-input.error, .form-select.error {
        border-color: #ef4444;
        background-color: #fef2f2;
    }

    /* Buttons */
    .form-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }

    .btn-submit {
        background: #2D3E50;
        color: white;
        padding: 14px 30px;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        flex: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        font-size: 15px;
    }

    .btn-submit:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.2);
    }

    .btn-submit i {
        font-size: 16px;
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #64748b;
        padding: 14px 30px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        text-decoration: none;
        text-align: center;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        font-size: 15px;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
        color: #2D3E50;
        transform: translateY(-2px);
    }

    /* Info Tooltips */
    .info-tooltip {
        display: inline-block;
        margin-left: 6px;
        color: #94a3b8;
        cursor: help;
        font-size: 12px;
    }

    .info-tooltip:hover {
        color: #2D3E50;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-container {
            padding: 15px;
        }

        .form-card {
            padding: 20px;
        }

        .form-buttons {
            flex-direction: column;
        }

        .btn-submit, .btn-cancel {
            width: 100%;
        }

        .status-section {
            padding: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <!-- Page Header -->
    <div class="page-header">
        <a href="{{ route('admin.enrollments.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Enrollments
        </a>
        <h1 class="page-title">
            <i class="fas fa-plus-circle"></i>
            Add New Enrollment
        </h1>
    </div>

    <!-- Form Card -->
    <div class="form-card">
        <form action="{{ route('admin.enrollments.store') }}" method="POST" id="enrollmentForm">
            @csrf

            <!-- Student & Course Selection -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-user-graduate"></i>
                    Student & Course Selection
                </h3>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            Student <span class="required">*</span>
                            <span class="info-tooltip" title="Select the student to enroll">
                                <i class="fas fa-question-circle"></i>
                            </span>
                        </label>
                        <select name="user_id" id="studentSelect" class="form-select @error('user_id') error @enderror" required>
                            <option value="">-- Select Student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" data-name="{{ $student->name }}" data-email="{{ $student->email }}" data-avatar="{{ $student->avatar }}" {{ old('user_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }} ({{ $student->email }})
                                </option>
                            @endforeach
                        </select>
                        
                        <!-- Student Preview -->
                        <div id="studentPreview" class="selection-preview">
                            <div class="preview-item">
                                <div class="preview-avatar" id="studentAvatar">JS</div>
                                <div class="preview-info">
                                    <h4 id="studentName">John Smith</h4>
                                    <p id="studentEmail">john@example.com</p>
                                </div>
                            </div>
                        </div>
                        
                        @error('user_id')
                            <span class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Course <span class="required">*</span>
                            <span class="info-tooltip" title="Select the course to enroll in">
                                <i class="fas fa-question-circle"></i>
                            </span>
                        </label>
                        <select name="course_id" id="courseSelect" class="form-select @error('course_id') error @enderror" required>
                            <option value="">-- Select Course --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" data-price="{{ $course->final_price }}" data-title="{{ $course->title }}" data-instructor="{{ $course->instructor_name }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                    {{ $course->title }} - ${{ number_format($course->final_price, 2) }}
                                </option>
                            @endforeach
                        </select>
                        
                        <!-- Course Preview -->
                        <div id="coursePreview" class="selection-preview">
                            <div class="preview-item">
                                <div class="preview-avatar" style="background: linear-gradient(135deg, #f59e0b, #2D3E50);">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="preview-info">
                                    <h4 id="courseTitle">Course Title</h4>
                                    <p id="courseInstructor">Instructor Name</p>
                                </div>
                            </div>
                        </div>
                        
                        @error('course_id')
                            <span class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-credit-card"></i>
                    Payment Information
                </h3>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            Amount Paid <span class="required">*</span>
                        </label>
                        <div class="amount-display" id="amountDisplay">
                            <div class="amount-label">Course Price</div>
                            <div class="amount-value" id="amountValue">$0.00</div>
                        </div>
                        <input type="number" name="amount_paid" id="amountPaid" class="form-input @error('amount_paid') error @enderror" 
                               placeholder="0.00" step="0.01" value="{{ old('amount_paid') }}" required>
                        @error('amount_paid')
                            <span class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Payment Method <span class="required">*</span>
                        </label>
                        <select name="payment_method" id="paymentMethod" class="form-select @error('payment_method') error @enderror" required>
                            <option value="">-- Select Method --</option>
                            <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="manual" {{ old('payment_method') == 'manual' ? 'selected' : '' }}>Manual</option>
                            <option value="free" {{ old('payment_method') == 'free' ? 'selected' : '' }}>Free</option>
                        </select>
                        
                        <!-- Free Payment Hint -->
                        <div id="freePaymentHint" class="payment-hint" style="display: none;">
                            <i class="fas fa-info-circle"></i> Amount will be set to $0.00 for free enrollment
                        </div>
                        
                        @error('payment_method')
                            <span class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Notes Field (from schema) -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-sticky-note"></i>
                    Additional Notes
                </h3>

                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-input" rows="3" placeholder="Add any additional notes about this enrollment...">{{ old('notes') }}</textarea>
                    <div style="font-size: 11px; color: #94a3b8; margin-top: 5px;">Optional - Max 1000 characters</div>
                    @error('notes')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Enrollment Status -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-chart-line"></i>
                    Enrollment Status
                </h3>

                <div class="status-section">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                Status <span class="required">*</span>
                            </label>
                            <select name="status" class="form-select @error('status') error @enderror" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }} selected>Active</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <span class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Enrollment Date
                            </label>
                            <input type="date" name="enrolled_at" class="form-input @error('enrolled_at') error @enderror" 
                                   value="{{ old('enrolled_at', date('Y-m-d')) }}">
                            @error('enrolled_at')
                                <span class="error-message">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="progress-container">
                        <div class="progress-header">
                            <label>Progress Percentage</label>
                            <span class="progress-value" id="progressValue">{{ old('progress_percentage', 0) }}%</span>
                        </div>
                        <input type="range" name="progress_percentage" class="progress-slider" 
                               min="0" max="100" value="{{ old('progress_percentage', 0) }}" 
                               id="progressSlider">
                        <div class="progress-markers">
                            <span>0%</span>
                            <span>25%</span>
                            <span>50%</span>
                            <span>75%</span>
                            <span>100%</span>
                        </div>
                        @error('progress_percentage')
                            <span class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-buttons">
                <a href="{{ route('admin.enrollments.index') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Create Enrollment
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const studentSelect = document.getElementById('studentSelect');
        const courseSelect = document.getElementById('courseSelect');
        const paymentMethod = document.getElementById('paymentMethod');
        const studentPreview = document.getElementById('studentPreview');
        const coursePreview = document.getElementById('coursePreview');
        const amountInput = document.getElementById('amountPaid');
        const amountDisplay = document.getElementById('amountValue');
        const progressSlider = document.getElementById('progressSlider');
        const progressValue = document.getElementById('progressValue');
        const freePaymentHint = document.getElementById('freePaymentHint');

        // Student Preview
        if (studentSelect) {
            studentSelect.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                if (this.value) {
                    const name = selected.getAttribute('data-name') || selected.text.split(' (')[0];
                    const email = selected.getAttribute('data-email') || '';
                    const avatar = selected.getAttribute('data-avatar');
                    
                    document.getElementById('studentName').textContent = name;
                    document.getElementById('studentEmail').textContent = email;
                    
                    // Set avatar
                    const avatarEl = document.getElementById('studentAvatar');
                    if (avatar) {
                        avatarEl.innerHTML = `<img src="/storage/${avatar}" alt="${name}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">`;
                    } else {
                        const initials = name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                        avatarEl.textContent = initials;
                        avatarEl.style.background = 'linear-gradient(135deg, #2D3E50, #f59e0b)';
                    }
                    
                    studentPreview.classList.add('active');
                } else {
                    studentPreview.classList.remove('active');
                }
            });

            // Trigger if already selected (old value)
            if (studentSelect.value) {
                studentSelect.dispatchEvent(new Event('change'));
            }
        }

        // Course Preview and Price
        if (courseSelect) {
            courseSelect.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                if (this.value) {
                    const price = selected.getAttribute('data-price');
                    const title = selected.getAttribute('data-title');
                    const instructor = selected.getAttribute('data-instructor');
                    
                    // Update preview
                    document.getElementById('courseTitle').textContent = title;
                    document.getElementById('courseInstructor').textContent = instructor;
                    coursePreview.classList.add('active');
                    
                    // Update amount only if not free payment and no manual override
                    if (paymentMethod.value !== 'free' && !amountInput.value) {
                        amountInput.value = price;
                        amountDisplay.innerHTML = `$${parseFloat(price).toFixed(2)} <small>Course Price</small>`;
                    }
                } else {
                    coursePreview.classList.remove('active');
                    if (paymentMethod.value !== 'free') {
                        amountInput.value = '';
                        amountDisplay.innerHTML = '$0.00 <small>Course Price</small>';
                    }
                }
            });

            // Trigger if already selected (old value)
            if (courseSelect.value) {
                courseSelect.dispatchEvent(new Event('change'));
            }
        }


        // Payment Method Change Handler
        if (paymentMethod) {
            paymentMethod.addEventListener('change', function() {
                const isFree = this.value === 'free';

                if (isFree) {
                    // Save current value to restore later if needed
                    amountInput.setAttribute('data-previous-value', amountInput.value);

                    // Set to 0 and disable
                    amountInput.value = '0';
                    amountInput.disabled = true;
                    amountDisplay.innerHTML = '$0.00 <small>Free Enrollment</small>';

                    // Show hint
                    freePaymentHint.style.display = 'flex';

                    // Add hidden input to submit the value
                    let hiddenInput = document.getElementById('hiddenAmountInput');
                    if (!hiddenInput) {
                        hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'amount_paid';
                        hiddenInput.id = 'hiddenAmountInput';
                        hiddenInput.value = '0';
                        amountInput.parentNode.appendChild(hiddenInput);
                    } else {
                        hiddenInput.value = '0';
                    }

                    // Remove name from disabled input so it doesn't submit
                    amountInput.removeAttribute('name');

                } else {
                    // Enable input
                    amountInput.disabled = false;
                    amountInput.setAttribute('name', 'amount_paid');

                    // Remove hidden input if exists
                    const hiddenInput = document.getElementById('hiddenAmountInput');
                    if (hiddenInput) {
                        hiddenInput.remove();
                    }

                    // Hide hint
                    freePaymentHint.style.display = 'none';

                    // Restore previous value or set from course
                    const previousValue = amountInput.getAttribute('data-previous-value');
                    if (previousValue && previousValue !== '0') {
                        amountInput.value = previousValue;
                    } else if (courseSelect.value) {
                        const selected = courseSelect.options[courseSelect.selectedIndex];
                        const price = selected.getAttribute('data-price');
                        if (price) {
                            amountInput.value = price;
                        }
                    }

                    // Update display
                    if (amountInput.value) {
                        amountDisplay.innerHTML = `$${parseFloat(amountInput.value).toFixed(2)} <small>Manual Entry</small>`;
                    } else if (courseSelect.value) {
                        const selected = courseSelect.options[courseSelect.selectedIndex];
                        const price = selected.getAttribute('data-price');
                        if (price) {
                            amountDisplay.innerHTML = `$${parseFloat(price).toFixed(2)} <small>Course Price</small>`;
                        }
                    } else {
                        amountDisplay.innerHTML = '$0.00 <small>Course Price</small>';
                    }
                }
            });

            // Trigger if free is already selected (old value)
            if (paymentMethod.value === 'free') {
                paymentMethod.dispatchEvent(new Event('change'));
            }
        }

        // Manual amount change
        if (amountInput) {
            amountInput.addEventListener('input', function() {
                if (paymentMethod.value !== 'free' && this.value) {
                    amountDisplay.innerHTML = `$${parseFloat(this.value).toFixed(2)} <small>Manual Entry</small>`;
                } else if (paymentMethod.value !== 'free' && courseSelect.value && !this.value) {
                    const selected = courseSelect.options[courseSelect.selectedIndex];
                    const price = selected.getAttribute('data-price');
                    if (price) {
                        amountDisplay.innerHTML = `$${parseFloat(price).toFixed(2)} <small>Course Price</small>`;
                    }
                }
            });
        }

        // Progress slider
        if (progressSlider) {
            progressSlider.addEventListener('input', function() {
                progressValue.textContent = this.value + '%';
            });
        }

        // Form validation
        document.getElementById('enrollmentForm').addEventListener('submit', function(e) {
            const student = studentSelect.value;
            const course = courseSelect.value;
            const payment = paymentMethod.value;
            const amount = amountInput.value;
            
            if (!student) {
                e.preventDefault();
                Swal.fire({
                    title: 'Validation Error',
                    text: 'Please select a student',
                    icon: 'error',
                    confirmButtonColor: '#2D3E50'
                });
                return false;
            }
            
            if (!course) {
                e.preventDefault();
                Swal.fire({
                    title: 'Validation Error',
                    text: 'Please select a course',
                    icon: 'error',
                    confirmButtonColor: '#2D3E50'
                });
                return false;
            }
            
            if (!payment) {
                e.preventDefault();
                Swal.fire({
                    title: 'Validation Error',
                    text: 'Please select a payment method',
                    icon: 'error',
                    confirmButtonColor: '#2D3E50'
                });
                return false;
            }
            
            // For free payment, amount is automatically 0
            if (payment !== 'free' && (!amount || amount <= 0)) {
                e.preventDefault();
                Swal.fire({
                    title: 'Validation Error',
                    text: 'Please enter a valid amount',
                    icon: 'error',
                    confirmButtonColor: '#2D3E50'
                });
                return false;
            }
        });

        // Date picker default
        const dateInput = document.querySelector('input[name="enrolled_at"]');
        if (dateInput && !dateInput.value) {
            const today = new Date().toISOString().split('T')[0];
            dateInput.value = today;
        }
    });
</script>
@endsection