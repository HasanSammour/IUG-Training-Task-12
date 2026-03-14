@extends('layouts.app')

@section('title', 'Edit Enrollment - Admin')
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

    /* Enrollment Info Card */
    .info-card {
        background: linear-gradient(135deg, #f8fafc, #ffffff);
        border-radius: 16px;
        padding: 25px;
        border: 1px solid #e2e8f0;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .info-content {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .enrollment-id {
        font-size: 18px;
        font-weight: 700;
        color: #2D3E50;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .enrollment-id i {
        color: #f59e0b;
        font-size: 16px;
    }

    .enrollment-meta {
        display: flex;
        gap: 20px;
        color: #64748b;
        font-size: 13px;
    }

    .enrollment-meta i {
        margin-right: 5px;
        color: #94a3b8;
    }

    .status-badge-large {
        padding: 8px 20px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending { background: #fef3c7; color: #92400e; }
    .status-active { background: #d1fae5; color: #065f46; }
    .status-completed { background: #dbeafe; color: #1e40af; }
    .status-cancelled { background: #fee2e2; color: #991b1b; }

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

    .form-input-static {
        background: #f8fafc;
        padding: 12px 16px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        color: #2D3E50;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .student-avatar-small {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2D3E50, #f59e0b);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        flex-shrink: 0;
    }

    .student-avatar-small img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
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

    /* Payment Method Hint */
    .payment-hint {
        font-size: 12px;
        color: #10b981;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Progress Section */
    .progress-section {
        background: #f8fafc;
        padding: 25px;
        border-radius: 12px;
        margin: 20px 0;
        border: 1px solid #e2e8f0;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .progress-header h3 {
        font-size: 16px;
        color: #2D3E50;
        font-weight: 600;
        margin: 0;
    }

    .progress-percentage-large {
        font-size: 24px;
        font-weight: 700;
        color: #2D3E50;
        background: white;
        padding: 4px 16px;
        border-radius: 30px;
        border: 1px solid #e2e8f0;
    }

    .progress-bar-container {
        height: 12px;
        background: #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #2D3E50, #f59e0b);
        border-radius: 10px;
        transition: width 0.5s ease;
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

    .progress-markers {
        display: flex;
        justify-content: space-between;
        padding: 0 5px;
        color: #94a3b8;
        font-size: 11px;
        margin-top: 5px;
    }

    .progress-buttons {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .btn-progress {
        flex: 1;
        padding: 10px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        color: #2D3E50;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-progress:hover {
        background: #2D3E50;
        color: white;
        border-color: #2D3E50;
    }

    /* Timeline */
    .timeline {
        margin: 30px 0;
        padding: 20px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .timeline h4 {
        font-size: 15px;
        color: #2D3E50;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .timeline h4 i {
        color: #f59e0b;
    }

    .timeline-item {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        padding: 8px 0;
    }

    .timeline-dot {
        width: 12px;
        height: 12px;
        background: #cbd5e0;
        border-radius: 50%;
        position: relative;
    }

    .timeline-dot.active {
        background: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    }

    .timeline-dot.completed {
        background: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }

    .timeline-content {
        flex: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .timeline-text {
        font-size: 14px;
        color: #2D3E50;
    }

    .timeline-date {
        font-size: 12px;
        color: #94a3b8;
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

    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
        padding: 14px 30px;
        border-radius: 10px;
        border: 1px solid #fecaca;
        font-weight: 600;
        cursor: pointer;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s ease;
        font-size: 15px;
        text-decoration: none;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: white;
        border-color: #ef4444;
        transform: translateY(-2px);
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

    .form-input.error, .form-select.error {
        border-color: #ef4444;
        background-color: #fef2f2;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-container {
            padding: 15px;
        }

        .info-card {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }

        .enrollment-meta {
            flex-direction: column;
            gap: 5px;
        }

        .form-card {
            padding: 20px;
        }

        .form-buttons {
            flex-direction: column;
        }

        .progress-buttons {
            flex-wrap: wrap;
        }

        .btn-progress {
            min-width: 60px;
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
            <i class="fas fa-edit"></i>
            Edit Enrollment
        </h1>
    </div>

    <!-- Enrollment Info Card -->
    <div class="info-card">
        <div class="info-content">
            <div class="enrollment-id">
                <i class="fas fa-hashtag"></i>
                {{ $enrollment->enrollment_id }}
            </div>
            <div class="enrollment-meta">
                <span><i class="fas fa-calendar"></i> Enrolled: {{ $enrollment->enrolled_at->format('M d, Y') }}</span>
                <span><i class="fas fa-clock"></i> Last updated: {{ $enrollment->updated_at->diffForHumans() }}</span>
            </div>
        </div>
        <div class="status-badge-large status-{{ $enrollment->status }}">
            <i class="fas fa-{{ $enrollment->status == 'active' ? 'play' : ($enrollment->status == 'completed' ? 'check' : ($enrollment->status == 'pending' ? 'clock' : 'times')) }}"></i>
            {{ ucfirst($enrollment->status) }}
        </div>
    </div>

    <!-- Form Card -->
    <div class="form-card">
        <form action="{{ route('admin.enrollments.update', $enrollment) }}" method="POST" id="enrollmentForm">
            @csrf
            @method('PUT')
            
            <!-- Student & Course Info (Read-only) -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Student & Course Information
                </h3>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Student</label>
                        <div class="form-input-static">
                            @if($enrollment->user->avatar && \Storage::disk('public')->exists($enrollment->user->avatar))
                                <div class="student-avatar-small">
                                    <img src="{{ Storage::url($enrollment->user->avatar) }}" alt="{{ $enrollment->user->name }}">
                                </div>
                            @else
                                <div class="student-avatar-small">
                                    {{ substr($enrollment->user->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <strong>{{ $enrollment->user->name }}</strong><br>
                                <small style="color: #64748b;">{{ $enrollment->user->email }}</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Course</label>
                        <div class="form-input-static">
                            <div>
                                <strong>{{ $enrollment->course->title }}</strong><br>
                                <small style="color: #64748b;">
                                    <i class="fas fa-chalkboard-teacher"></i> {{ $enrollment->course->instructor_name }}
                                </small>
                            </div>
                        </div>
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
                            <div class="amount-label">Current Amount</div>
                            <div class="amount-value" id="amountValue">${{ number_format($enrollment->amount_paid, 2) }}</div>
                        </div>
                        <input type="number" name="amount_paid" id="amountPaid" class="form-input @error('amount_paid') error @enderror" 
                               placeholder="0.00" step="0.01" value="{{ old('amount_paid', $enrollment->amount_paid) }}" 
                               {{ $enrollment->payment_method == 'free' ? 'disabled' : '' }}>
                        @error('amount_paid')
                            <span class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                        
                        <!-- Hidden input for free payment -->
                        @if($enrollment->payment_method == 'free')
                            <input type="hidden" name="amount_paid" value="0">
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Payment Method <span class="required">*</span>
                        </label>
                        <select name="payment_method" id="paymentMethod" class="form-select @error('payment_method') error @enderror" required>
                            <option value="credit_card" {{ old('payment_method', $enrollment->payment_method) == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            <option value="paypal" {{ old('payment_method', $enrollment->payment_method) == 'paypal' ? 'selected' : '' }}>PayPal</option>
                            <option value="bank_transfer" {{ old('payment_method', $enrollment->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="manual" {{ old('payment_method', $enrollment->payment_method) == 'manual' ? 'selected' : '' }}>Manual</option>
                            <option value="free" {{ old('payment_method', $enrollment->payment_method) == 'free' ? 'selected' : '' }}>Free</option>
                        </select>
                        
                        <!-- Free Payment Hint -->
                        <div id="freePaymentHint" class="payment-hint" style="display: {{ $enrollment->payment_method == 'free' ? 'flex' : 'none' }};">
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

            <!-- Notes Field -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-sticky-note"></i>
                    Additional Notes
                </h3>

                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea name="notes" class="form-input" rows="3" placeholder="Add any additional notes about this enrollment...">{{ old('notes', $enrollment->notes) }}</textarea>
                    <div style="font-size: 11px; color: #94a3b8; margin-top: 5px;">Optional - Max 1000 characters</div>
                    @error('notes')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Progress Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-chart-line"></i>
                    Progress Tracking
                </h3>

                <div class="progress-section">
                    <div class="progress-header">
                        <h3>Current Progress</h3>
                        <span class="progress-percentage-large" id="progressPercentage">{{ $enrollment->progress_percentage }}%</span>
                    </div>
                    
                    <div class="progress-bar-container">
                        <div class="progress-bar-fill" id="progressFill" 
                             style="width: {{ $enrollment->progress_percentage }}%"></div>
                    </div>
                    
                    <input type="range" id="progressSlider" class="progress-slider" 
                           min="0" max="100" value="{{ $enrollment->progress_percentage }}">
                    
                    <div class="progress-markers">
                        <span>0%</span>
                        <span>25%</span>
                        <span>50%</span>
                        <span>75%</span>
                        <span>100%</span>
                    </div>
                    
                    <input type="hidden" name="progress_percentage" id="progressInput" 
                           value="{{ $enrollment->progress_percentage }}">
                    
                    <div class="progress-buttons">
                        <button type="button" class="btn-progress" onclick="setProgress(0)">0%</button>
                        <button type="button" class="btn-progress" onclick="setProgress(25)">25%</button>
                        <button type="button" class="btn-progress" onclick="setProgress(50)">50%</button>
                        <button type="button" class="btn-progress" onclick="setProgress(75)">75%</button>
                        <button type="button" class="btn-progress" onclick="setProgress(100)">100%</button>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-tag"></i>
                    Enrollment Status
                </h3>

                <div class="form-group">
                    <label class="form-label">Status <span class="required">*</span></label>
                    <select name="status" id="statusSelect" class="form-select @error('status') error @enderror" required>
                        <option value="pending" {{ old('status', $enrollment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ old('status', $enrollment->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ old('status', $enrollment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $enrollment->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <span class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <!-- Timeline -->
            <div class="timeline">
                <h4>
                    <i class="fas fa-history"></i>
                    Enrollment Timeline
                </h4>
                
                <div class="timeline-item">
                    <div class="timeline-dot completed"></div>
                    <div class="timeline-content">
                        <span class="timeline-text">Enrollment Created</span>
                        <span class="timeline-date">{{ $enrollment->created_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>
                
                @if($enrollment->completed_at)
                <div class="timeline-item">
                    <div class="timeline-dot completed"></div>
                    <div class="timeline-content">
                        <span class="timeline-text">Course Completed</span>
                        <span class="timeline-date">{{ $enrollment->completed_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>
                @endif
                
                <div class="timeline-item">
                    <div class="timeline-dot {{ $enrollment->updated_at != $enrollment->created_at ? 'active' : '' }}"></div>
                    <div class="timeline-content">
                        <span class="timeline-text">Last Updated</span>
                        <span class="timeline-date">{{ $enrollment->updated_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-buttons">
                <button type="button" class="btn-delete" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i> Delete
                </button>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Update Enrollment
                </button>
            </div>
        </form>

        <!-- Hidden Delete Form -->
        <form id="delete-form" action="{{ route('admin.enrollments.destroy', $enrollment) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const paymentMethod = document.getElementById('paymentMethod');
        const amountInput = document.getElementById('amountPaid');
        const amountDisplay = document.getElementById('amountValue');
        const freePaymentHint = document.getElementById('freePaymentHint');
        const slider = document.getElementById('progressSlider');
        const percentage = document.getElementById('progressPercentage');
        const fill = document.getElementById('progressFill');
        const progressInput = document.getElementById('progressInput');
        const statusSelect = document.getElementById('statusSelect');

        // ===================================
        // PAYMENT METHOD HANDLER (Fixed for Edit)
        // ===================================
        if (paymentMethod) {
            // Store original values
            const originalAmount = '{{ $enrollment->amount_paid }}';
            const originalMethod = '{{ $enrollment->payment_method }}';

            paymentMethod.addEventListener('change', function() {
                const isFree = this.value === 'free';
                
                // Remove any existing hidden input first
                const existingHidden = document.getElementById('hiddenAmountInput');
                if (existingHidden) {
                    existingHidden.remove();
                }
                
                if (isFree) {
                    // Save current value to restore later if needed
                    if (amountInput.value) {
                        amountInput.setAttribute('data-previous-value', amountInput.value);
                    }
                    
                    // Disable the visible input
                    amountInput.disabled = true;
                    
                    // Create hidden input with value 0
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'amount_paid';
                    hiddenInput.id = 'hiddenAmountInput';
                    hiddenInput.value = '0';
                    amountInput.parentNode.appendChild(hiddenInput);
                    
                    // Update display
                    amountDisplay.innerHTML = '$0.00 <small>Free Enrollment</small>';
                    
                    // Show hint
                    freePaymentHint.style.display = 'flex';
                    
                } else {
                    // Enable the visible input
                    amountInput.disabled = false;
                    
                    // Restore previous value if exists
                    const previousValue = amountInput.getAttribute('data-previous-value');
                    if (previousValue && previousValue !== '0') {
                        amountInput.value = previousValue;
                    } else if (originalMethod === 'free' && !previousValue) {
                        // If it was free before and no previous value, use original amount
                        amountInput.value = originalAmount;
                    }
                    
                    // Update display
                    if (amountInput.value) {
                        amountDisplay.innerHTML = `$${parseFloat(amountInput.value).toFixed(2)} <small>Manual Entry</small>`;
                    }
                    
                    // Hide hint
                    freePaymentHint.style.display = 'none';
                }
            });
        }

        // ===================================
        // PROGRESS SLIDER
        // ===================================
        function updateProgress(value) {
            percentage.textContent = value + '%';
            fill.style.width = value + '%';
            progressInput.value = value;
            
            // If progress is 100%, suggest completing status
            if (value == 100 && statusSelect.value != 'completed') {
                // Optional: Could show a hint
            }
        }
        
        if (slider) {
            slider.addEventListener('input', function() {
                updateProgress(this.value);
            });
        }
        
        // Set progress function for buttons
        window.setProgress = function(value) {
            if (slider) {
                slider.value = value;
                updateProgress(value);
            }
        };

        // ===================================
        // DELETE CONFIRMATION
        // ===================================
        window.confirmDelete = function() {
            Swal.fire({
                title: 'Delete Enrollment?',
                html: `<div style="text-align: left;">
                        <p style="margin-bottom: 15px;">Are you sure you want to delete this enrollment?</p>
                        <div style="background: #fee2e2; border-left: 4px solid #dc2626; padding: 12px; border-radius: 6px; color: #991b1b; font-size: 13px;">
                            <i class="fas fa-exclamation-triangle"></i> 
                            <span style="margin-left: 5px;">This action cannot be undone.</span>
                        </div>
                       </div>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form').submit();
                }
            });
        };

        // ===================================
        // FORM VALIDATION
        // ===================================
        document.getElementById('enrollmentForm').addEventListener('submit', function(e) {
            const payment = paymentMethod.value;
            const amount = amountInput.value;
            
            // For free payment, it's always valid (hidden input will be submitted)
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
    });
</script>
@endsection