@extends('layouts.app')

@section('title', 'Edit Student - Shifra Admin')
@section('body-class', 'admin-page')

@section('styles')
<style>
    .admin-container {
        padding: 20px;
        max-width: 1000px;
        margin: 0 auto;
    }

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

    .back-btn {
        color: #64748b;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        transition: color 0.3s;
    }

    .back-btn:hover {
        color: #2D3E50;
    }

    .form-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        border: 1px solid #edf2f7;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .form-section {
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 16px;
        color: #2D3E50;
        margin-bottom: 20px;
        font-weight: 600;
        padding-bottom: 10px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
    }

    .form-label .required {
        color: #ef4444;
    }

    .form-input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s;
    }

    .form-input:focus {
        border-color: #2D3E50;
        outline: none;
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    .form-input.error {
        border-color: #ef4444;
        background-color: #fef2f2;
    }

    .form-textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s;
        resize: vertical;
        min-height: 100px;
    }

    .form-textarea:focus {
        border-color: #2D3E50;
        outline: none;
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-secondary {
        background: #f1f5f9;
        color: #64748b;
        text-decoration: none;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

    .btn-primary {
        background: #2D3E50;
        color: white;
    }

    .btn-primary:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
    }

    /* Avatar Upload Section */
    .avatar-section {
        display: flex;
        align-items: center;
        gap: 25px;
        margin-bottom: 30px;
        padding: 20px;
        background: #f8fafc;
        border-radius: 12px;
    }

    @media (max-width: 768px) {
        .avatar-section {
            flex-direction: column;
            text-align: center;
        }
    }

    .avatar-wrapper {
        position: relative;
        width: 100px;
        height: 100px;
    }

    .avatar-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .avatar-initials {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2D3E50, #3182ce);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        font-weight: 700;
        border: 3px solid white;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .avatar-upload-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 32px;
        height: 32px;
        background: #2D3E50;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid white;
    }

    .avatar-upload-btn:hover {
        background: #1a252f;
        transform: scale(1.1);
    }

    .avatar-info h4 {
        font-size: 18px;
        color: #2D3E50;
        margin-bottom: 5px;
    }

    .avatar-info p {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 10px;
    }

    .avatar-actions {
        display: flex;
        gap: 10px;
    }

    .btn-upload {
        background: #e0f2fe;
        color: #0369a1;
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-upload:hover {
        background: #bae6fd;
    }

    .btn-remove {
        background: #fee2e2;
        color: #dc2626;
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-remove:hover {
        background: #fecaca;
    }

    /* Password Section */
    .password-section {
        margin-top: 20px;
        padding: 20px;
        background: #f8fafc;
        border-radius: 12px;
    }

    .password-toggle {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .password-toggle input[type="checkbox"] {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .password-fields {
        display: none;
    }

    .password-fields.show {
        display: block;
    }

    .password-strength {
        height: 4px;
        background: #e2e8f0;
        border-radius: 2px;
        margin-top: 8px;
        overflow: hidden;
    }

    .strength-meter {
        height: 100%;
        border-radius: 2px;
        transition: width 0.3s ease;
    }

    .strength-weak { background: #ef4444; width: 25%; }
    .strength-medium { background: #f59e0b; width: 50%; }
    .strength-strong { background: #10b981; width: 75%; }
    .strength-very-strong { background: #059669; width: 100%; }

    /* Badge */
    .badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .badge-success {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-warning {
        background: #fef3c7;
        color: #d97706;
    }

    .badge-info {
        background: #dbeafe;
        color: #1e40af;
    }

    /* Hint Text */
    .hint-text {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-container {
            padding: 15px;
        }
        
        .form-card {
            padding: 20px;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
        
        .avatar-actions {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-user-edit"></i>
            Edit Student
        </h1>
        <a href="{{ route('admin.students.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Students
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.students.update', $student) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Avatar Upload Section -->
            <div class="avatar-section">
                <div class="avatar-wrapper">
                    @if($student->avatar && \Storage::disk('public')->exists($student->avatar))
                        <img src="{{ $student->avatar_url }}" alt="{{ $student->name }}" class="avatar-image" id="avatarPreview">
                    @else
                        <div class="avatar-initials" id="avatarInitials">
                            {{ $student->initials }}
                        </div>
                        <img src="" alt="Preview" class="avatar-image" id="avatarPreview" style="display: none;">
                    @endif
                    
                    <label for="avatarInput" class="avatar-upload-btn" title="Upload new avatar">
                        <i class="fas fa-camera"></i>
                    </label>
                    <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display: none;">
                </div>
                
                <div class="avatar-info">
                    <h4>{{ $student->name }}</h4>
                    <p>Student ID: #{{ str_pad($student->id, 5, '0', STR_PAD_LEFT) }}</p>
                    
                    <div class="avatar-actions">
                        <button type="button" class="btn-upload" onclick="document.getElementById('avatarInput').click()">
                            <i class="fas fa-upload"></i> Change Photo
                        </button>
                        
                        @if($student->avatar && \Storage::disk('public')->exists($student->avatar))
                            <button type="button" class="btn-remove" id="removeAvatarBtn">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        @endif
                    </div>
                    <div class="hint-text">
                        <i class="fas fa-info-circle"></i> JPG, PNG or GIF • Max 2MB
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-user"></i>
                    Personal Information
                </h3>
                
                <div class="form-group">
                    <label class="form-label">
                        Full Name <span class="required">*</span>
                    </label>
                    <input type="text" name="name" 
                           class="form-input @error('name') error @enderror" 
                           value="{{ old('name', $student->name) }}" 
                           placeholder="Enter full name" required>
                    @error('name')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            Email Address <span class="required">*</span>
                        </label>
                        <input type="email" name="email" 
                               class="form-input @error('email') error @enderror" 
                               value="{{ old('email', $student->email) }}" 
                               placeholder="student@example.com" required>
                        @error('email')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" name="phone" 
                               class="form-input @error('phone') error @enderror" 
                               value="{{ old('phone', $student->phone) }}" 
                               placeholder="+1234567890">
                        @error('phone')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-briefcase"></i>
                    Professional Information
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Company</label>
                        <input type="text" name="company" 
                               class="form-input @error('company') error @enderror" 
                               value="{{ old('company', $student->company) }}" 
                               placeholder="Company name">
                        @error('company')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Job Title</label>
                        <input type="text" name="job_title" 
                               class="form-input @error('job_title') error @enderror" 
                               value="{{ old('job_title', $student->job_title) }}" 
                               placeholder="Job title">
                        @error('job_title')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Bio</label>
                    <textarea name="bio" class="form-textarea @error('bio') error @enderror" 
                              placeholder="Brief description about the student...">{{ old('bio', $student->bio) }}</textarea>
                    @error('bio')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                    <div class="hint-text">
                        <i class="fas fa-info-circle"></i> Max 1000 characters
                    </div>
                </div>
            </div>

            <!-- Password Update Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-lock"></i>
                    Password Update
                </h3>
                
                <div class="password-section">
                    <div class="password-toggle">
                        <input type="checkbox" id="changePasswordCheckbox">
                        <label for="changePasswordCheckbox" style="font-size: 14px; color: #4a5568;">
                            Change Password
                        </label>
                    </div>
                    
                    <div class="password-fields" id="passwordFields">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password" id="password" 
                                       class="form-input @error('password') error @enderror" 
                                       placeholder="Enter new password" disabled>
                                <div class="password-strength">
                                    <div class="strength-meter" id="strengthMeter"></div>
                                </div>
                                @error('password')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       class="form-input" placeholder="Confirm new password" disabled>
                                <div id="passwordMatchMessage" style="font-size: 12px; margin-top: 5px;"></div>
                            </div>
                        </div>
                        <div class="hint-text">
                            <i class="fas fa-info-circle"></i> Minimum 8 characters with at least one number and one special character
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Status -->
            <div class="form-section">
                <h3 class="section-title">
                    <i class="fas fa-shield-alt"></i>
                    Account Status
                </h3>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Email Verification</label>
                        <div style="margin-top: 8px;">
                            @if($student->email_verified_at)
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle"></i> Verified
                                </span>
                                <div style="font-size: 11px; color: #94a3b8; margin-top: 5px;">
                                    {{ $student->email_verified_at->format('M d, Y') }}
                                </div>
                            @else
                                <span class="badge badge-warning">
                                    <i class="fas fa-clock"></i> Not Verified
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Account Created</label>
                        <div style="margin-top: 8px; color: #64748b; font-size: 14px;">
                            <i class="fas fa-calendar"></i> 
                            {{ $student->created_at->format('F d, Y') }}
                            <span style="display: block; font-size: 12px; color: #94a3b8; margin-top: 2px;">
                                {{ $student->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i> Update Student
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Hidden form for removing avatar -->
<form id="removeAvatarForm" action="{{ route('admin.students.update', $student) }}" method="POST" style="display: none;">
    @csrf
    @method('PUT')
    <input type="hidden" name="remove_avatar" value="1">
    <input type="hidden" name="name" value="{{ $student->name }}">
    <input type="hidden" name="email" value="{{ $student->email }}">
</form>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Avatar upload preview
        const avatarInput = document.getElementById('avatarInput');
        const avatarPreview = document.getElementById('avatarPreview');
        const avatarInitials = document.getElementById('avatarInitials');
        
        if (avatarInput) {
            avatarInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Check file size (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('File size must be less than 2MB');
                        avatarInput.value = '';
                        return;
                    }
                    
                    // Check file type
                    if (!file.type.match('image.*')) {
                        alert('Only image files are allowed');
                        avatarInput.value = '';
                        return;
                    }
                    
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (avatarPreview) {
                            avatarPreview.src = e.target.result;
                            avatarPreview.style.display = 'block';
                            if (avatarInitials) avatarInitials.style.display = 'none';
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
        
        // Remove avatar button
        const removeAvatarBtn = document.getElementById('removeAvatarBtn');
        if (removeAvatarBtn) {
            removeAvatarBtn.addEventListener('click', function() {
                Swal.fire({
                    title: 'Remove Avatar?',
                    text: 'Are you sure you want to remove the student\'s profile picture?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, remove it',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('removeAvatarForm').submit();
                    }
                });
            });
        }
        
        // Password change toggle
        const changePasswordCheckbox = document.getElementById('changePasswordCheckbox');
        const passwordFields = document.getElementById('passwordFields');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        
        if (changePasswordCheckbox) {
            changePasswordCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    passwordFields.classList.add('show');
                    passwordInput.disabled = false;
                    confirmPasswordInput.disabled = false;
                } else {
                    passwordFields.classList.remove('show');
                    passwordInput.disabled = true;
                    confirmPasswordInput.disabled = true;
                    passwordInput.value = '';
                    confirmPasswordInput.value = '';
                }
            });
        }
        
        // Password strength checker
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                if (password.length >= 8) strength++;
                if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
                if (password.match(/[0-9]/)) strength++;
                if (password.match(/[^a-zA-Z0-9]/)) strength++;
                
                const strengthMeter = document.getElementById('strengthMeter');
                strengthMeter.className = 'strength-meter';
                
                if (strength === 0 || strength === 1) {
                    strengthMeter.classList.add('strength-weak');
                } else if (strength === 2) {
                    strengthMeter.classList.add('strength-medium');
                } else if (strength === 3) {
                    strengthMeter.classList.add('strength-strong');
                } else {
                    strengthMeter.classList.add('strength-very-strong');
                }
                
                checkPasswordMatch();
            });
        }
        
        // Password match checker
        function checkPasswordMatch() {
            if (!passwordInput || !confirmPasswordInput) return;
            
            const password = passwordInput.value;
            const confirm = confirmPasswordInput.value;
            const matchMessage = document.getElementById('passwordMatchMessage');
            
            if (confirm === '') {
                matchMessage.innerHTML = '';
            } else if (password === confirm) {
                matchMessage.innerHTML = '<i class="fas fa-check-circle" style="color: #10b981;"></i> Passwords match';
                matchMessage.style.color = '#10b981';
            } else {
                matchMessage.innerHTML = '<i class="fas fa-exclamation-circle" style="color: #ef4444;"></i> Passwords do not match';
                matchMessage.style.color = '#ef4444';
            }
        }
        
        if (confirmPasswordInput) {
            confirmPasswordInput.addEventListener('input', checkPasswordMatch);
        }
        
        // Form validation
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const nameInput = this.querySelector('input[name="name"]');
                const emailInput = this.querySelector('input[name="email"]');
                
                if (!nameInput.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Validation Error',
                        text: 'Please enter student name',
                        icon: 'error',
                        confirmButtonColor: '#2d3e50'
                    });
                    nameInput.focus();
                    return false;
                }
                
                if (!emailInput.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Validation Error',
                        text: 'Please enter email address',
                        icon: 'error',
                        confirmButtonColor: '#2d3e50'
                    });
                    emailInput.focus();
                    return false;
                }
                
                // Check if password change is checked and passwords match
                if (changePasswordCheckbox && changePasswordCheckbox.checked) {
                    const password = passwordInput.value;
                    const confirm = confirmPasswordInput.value;
                    
                    if (password !== confirm) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Password Mismatch',
                            text: 'Passwords do not match',
                            icon: 'error',
                            confirmButtonColor: '#2d3e50'
                        });
                        return false;
                    }
                    
                    if (password.length < 8) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Weak Password',
                            text: 'Password must be at least 8 characters',
                            icon: 'error',
                            confirmButtonColor: '#2d3e50'
                        });
                        return false;
                    }
                }
            });
        }
    });
</script>
@endsection