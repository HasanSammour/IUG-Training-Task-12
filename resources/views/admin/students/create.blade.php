@extends('layouts.app')

@section('title', 'Add New Student')
@section('body-class', 'admin-page')

@section('styles')
<style>
    /* Same styles - remove role-options section */
    .form-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .form-header {
        margin-bottom: 30px;
    }

    .form-title {
        font-size: 24px;
        font-weight: bold;
        color: #2D3E50;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

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

    .form-label .required {
        color: #ef4444;
    }

    .form-input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        border-color: #2D3E50;
        outline: none;
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    .form-input.error {
        border-color: #ef4444;
    }

    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 5px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    .form-actions {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
    }

    .btn-submit {
        background: #2D3E50;
        color: white;
        padding: 12px 25px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-submit:hover {
        background: #1a252f;
        transform: translateY(-2px);
    }

    .btn-cancel {
        background: #f1f5f9;
        color: #64748b;
        padding: 12px 25px;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        flex: 1;
        text-decoration: none;
        text-align: center;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
    }

    /* Avatar Upload */
    .avatar-upload {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .avatar-preview {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #f8fafc;
        border: 2px dashed #cbd5e0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-placeholder {
        text-align: center;
        color: #94a3b8;
    }

    .avatar-placeholder i {
        font-size: 32px;
        margin-bottom: 5px;
    }

    .upload-button {
        background: #f0f9ff;
        color: #0369a1;
        padding: 8px 16px;
        border-radius: 6px;
        border: 1px solid #e0f2fe;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    .upload-button:hover {
        background: #e0f2fe;
    }

    .remove-button {
        background: #fef2f2;
        color: #dc2626;
        padding: 8px 16px;
        border-radius: 6px;
        border: 1px solid #fecaca;
        cursor: pointer;
        font-size: 13px;
        transition: all 0.3s ease;
        margin-left: 10px;
    }

    .remove-button:hover {
        background: #fee2e2;
    }

    /* Password Generator */
    .password-generator {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .password-generator button {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .password-generator button:hover {
        background: #e2e8f0;
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

    .hint-text {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 5px;
    }
</style>
@endsection

@section('content')
<div class="form-container">
    
    <div class="form-header">
        <h1 class="form-title">
            <i class="fas fa-user-plus"></i>
            Add New Student
        </h1>
        <p style="color: #64748b; margin-top: 5px;">Fill in the student details below to create a new account.</p>
    </div>

    <form action="{{ route('admin.students.store') }}" method="POST" class="form-card" id="studentForm" enctype="multipart/form-data">
        @csrf
        
        <!-- Avatar Upload -->
        <div class="avatar-upload">
            <div class="avatar-preview" id="avatarPreview">
                <div class="avatar-placeholder">
                    <i class="fas fa-user"></i>
                    <div style="font-size: 11px;">Preview</div>
                </div>
            </div>
            <div>
                <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display: none;">
                <button type="button" class="upload-button" onclick="document.getElementById('avatarInput').click()">
                    <i class="fas fa-upload"></i> Upload Photo
                </button>
                <button type="button" class="remove-button" id="removeAvatarBtn" style="display: none;" onclick="removeAvatar()">
                    <i class="fas fa-trash"></i> Remove
                </button>
                <div style="font-size: 12px; color: #94a3b8; margin-top: 5px;">
                    JPG, PNG or GIF • Max 2MB
                </div>
            </div>
        </div>

        <!-- Personal Information - FIXED: Single name field -->
        <div class="form-group">
            <label class="form-label">
                Full Name <span class="required">*</span>
            </label>
            <input type="text" name="name" class="form-input @error('name') error @enderror" 
                   value="{{ old('name') }}" placeholder="Enter student's full name" required>
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">
                    Email Address <span class="required">*</span>
                </label>
                <input type="email" name="email" 
                       class="form-input @error('email') error @enderror" 
                       value="{{ old('email') }}" 
                       placeholder="student@example.com" 
                       required>
                
                @error('email')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i> 
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">
                    Phone Number
                </label>
                <input type="tel" name="phone" class="form-input @error('phone') error @enderror" 
                       value="{{ old('phone') }}" placeholder="+1234567890">
                @error('phone')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Password -->
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">
                    Password <span class="required">*</span>
                </label>
                <input type="password" name="password" id="password" class="form-input @error('password') error @enderror" required>
                <div class="password-generator">
                    <button type="button" onclick="generatePassword()">
                        <i class="fas fa-key"></i> Generate
                    </button>
                    <button type="button" onclick="togglePasswordVisibility()">
                        <i class="fas fa-eye"></i> Show/Hide
                    </button>
                </div>
                <div class="password-strength">
                    <div class="strength-meter" id="strengthMeter"></div>
                </div>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    Confirm Password <span class="required">*</span>
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" required>
                <div id="passwordMatchMessage" style="font-size: 12px; margin-top: 5px;"></div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Company</label>
                <input type="text" name="company" class="form-input" value="{{ old('company') }}" placeholder="Company name">
            </div>
            
            <div class="form-group">
                <label class="form-label">Job Title</label>
                <input type="text" name="job_title" class="form-input" value="{{ old('job_title') }}" placeholder="Job title">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Bio</label>
            <textarea name="bio" class="form-input" rows="3" placeholder="Brief description about the student...">{{ old('bio') }}</textarea>
            <div class="hint-text">Max 1000 characters</div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="submit" class="btn-submit" id="submitBtn">
                <i class="fas fa-save"></i> Create Student
            </button>
            <a href="{{ route('admin.students.index') }}" class="btn-cancel">
                Cancel
            </a>
        </div>

    </form>

</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Avatar upload preview
        const avatarInput = document.getElementById('avatarInput');
        const avatarPreview = document.getElementById('avatarPreview');
        const removeBtn = document.getElementById('removeAvatarBtn');
        
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
                    avatarPreview.innerHTML = `<img src="${e.target.result}" alt="Avatar Preview">`;
                    removeBtn.style.display = 'inline-block';
                };
                reader.readAsDataURL(file);
            }
        });
        
        // Password strength checker
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        const strengthMeter = document.getElementById('strengthMeter');
        const matchMessage = document.getElementById('passwordMatchMessage');
        const submitBtn = document.getElementById('submitBtn');
        
        function checkPasswordStrength() {
            const password = passwordInput.value;
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
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
        }
        
        function checkPasswordMatch() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;
            
            if (confirm === '') {
                matchMessage.innerHTML = '';
                matchMessage.style.color = '';
            } else if (password === confirm) {
                matchMessage.innerHTML = '<i class="fas fa-check-circle"></i> Passwords match';
                matchMessage.style.color = '#10b981';
            } else {
                matchMessage.innerHTML = '<i class="fas fa-exclamation-circle"></i> Passwords do not match';
                matchMessage.style.color = '#ef4444';
            }
        }
        
        passwordInput.addEventListener('input', function() {
            checkPasswordStrength();
            checkPasswordMatch();
        });
        
        confirmInput.addEventListener('input', checkPasswordMatch);
        
        // Form validation before submit
        document.getElementById('studentForm').addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirm = confirmInput.value;
            
            if (password !== confirm) {
                e.preventDefault();
                alert('Passwords do not match!');
            }
        });
    });
    
    function generatePassword() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
        let password = '';
        for (let i = 0; i < 12; i++) {
            password += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('password').value = password;
        document.getElementById('password_confirmation').value = password;
        document.getElementById('password').dispatchEvent(new Event('input'));
        document.getElementById('password_confirmation').dispatchEvent(new Event('input'));
    }
    
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
    }
    
    function removeAvatar() {
        const avatarInput = document.getElementById('avatarInput');
        const avatarPreview = document.getElementById('avatarPreview');
        const removeBtn = document.getElementById('removeAvatarBtn');
        
        avatarInput.value = '';
        avatarPreview.innerHTML = `
            <div class="avatar-placeholder">
                <i class="fas fa-user"></i>
                <div style="font-size: 11px;">Preview</div>
            </div>
        `;
        removeBtn.style.display = 'none';
    }
</script>
@endsection