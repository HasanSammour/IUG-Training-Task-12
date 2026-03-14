@extends('layouts.app')

@section('title', 'Add New Course')
@section('body-class', 'admin-page')

@section('styles')
<style>
    .admin-page {
        background-color: #f8fbff;
        min-height: 100vh;
        padding-bottom: 70px;
    }

    .admin-container {
        padding: 20px;
        max-width: 1100px;
        margin: 0 auto;
    }

    /* Add space between page and browser edges */
    .page-container {
        padding: 0 20px;
    }

    @media (max-width: 768px) {
        .page-container {
            padding: 0 15px;
        }
    }

    .page-header {
        margin-bottom: 30px;
        padding: 0 20px;
    }

    .page-header h1 {
        font-size: 24px;
        color: #2D3E50;
        margin-bottom: 30px;
    }

    /* Form Layout */
    .form-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
    }

    @media (max-width: 768px) {
        .form-layout {
            grid-template-columns: 1fr;
        }
    }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        border: 1px solid #edf2f7;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .form-section {
        margin-bottom: 30px;
        padding-bottom: 25px;
        border-bottom: 1px solid #f1f5f9;
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: #2D3E50;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #3182ce;
    }

    /* Form Groups */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        background: white;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #2D3E50;
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    .form-control.textarea {
        min-height: 120px;
        resize: vertical;
    }

    /* Checkbox and Radio */
    .checkbox-group, .radio-group {
        display: flex;
        gap: 15px;
        margin-bottom: 10px;
    }

    .checkbox-item, .radio-item {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .checkbox-item input, .radio-item input {
        width: 16px;
        height: 16px;
    }

    /* Image Upload */
    .image-upload {
        border: 2px dashed #e2e8f0;
        border-radius: 8px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.3s ease;
    }

    .image-upload:hover {
        border-color: #3182ce;
    }

    .image-upload i {
        font-size: 36px;
        color: #94a3b8;
        margin-bottom: 10px;
    }

    .image-preview {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        margin-top: 15px;
        display: none;
    }

    /* Sidebar */
    .sidebar-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #edf2f7;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        position: sticky;
        top: 20px;
    }

    .price-display {
        font-size: 32px;
        font-weight: 700;
        color: #2D3E50;
        margin-bottom: 10px;
    }

    .discount-inputs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 10px;
    }

    /* Buttons */
    .btn-submit {
        width: 100%;
        padding: 15px;
        background: #2D3E50;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .btn-submit:hover {
        background: #1a252f;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
    }

    .btn-cancel {
        width: 100%;
        padding: 15px;
        background: #f7fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
        margin-top: 15px;
        display: block;
    }

    .btn-cancel:hover {
        background: #e2e8f0;
    }

    /* Tags Input */
    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 8px;
    }

    .tag {
        background: #e0f2fe;
        color: #0369a1;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .tag-remove {
        cursor: pointer;
        font-size: 10px;
    }

    /* Instructor Select Styling */
    .instructor-select {
        position: relative;
    }

    .instructor-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 0;
    }

    .instructor-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2D3E50, #3182ce);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 12px;
    }

    .instructor-info {
        display: flex;
        flex-direction: column;
    }

    .instructor-name {
        font-size: 14px;
        font-weight: 500;
        color: #2D3E50;
    }

    .instructor-email {
        font-size: 11px;
        color: #718096;
    }

    /* Select dropdown styling */
    select option {
        padding: 10px;
    }

    /* Meta Description Input */
    .meta-input {
        position: relative;
    }

    .char-count {
        position: absolute;
        right: 10px;
        bottom: 10px;
        font-size: 11px;
        color: #94a3b8;
        background: white;
        padding: 0 5px;
    }
</style>
@endsection

@section('content')
<div class="page-container">
    <div class="admin-container">
        <div class="page-header">
            <h1>
                <a href="{{ route('admin.courses.index') }}" style="color: inherit; text-decoration: none; margin-right: 10px;">
                    <i class="fas fa-arrow-left"></i>
                </a>
                Add New Course
            </h1>
        </div>

        <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data" class="form-layout">
            @csrf
            
            <!-- Left Column: Main Form -->
            <div class="form-card">
                <!-- Basic Information -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-info-circle"></i> Basic Information</h3>
                    
                    <div class="form-group">
                        <label for="title">Course Title *</label>
                        <input type="text" id="title" name="title" class="form-control" 
                               placeholder="Enter course title" required value="{{ old('title') }}">
                        @error('title')
                            <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="category_id">Category *</label>
                        <select id="category_id" name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="short_description">Short Description *</label>
                        <textarea id="short_description" name="short_description" class="form-control" 
                                  placeholder="Brief description (max 500 characters)" maxlength="500" 
                                  required>{{ old('short_description') }}</textarea>
                        <small style="color: #94a3b8; font-size: 11px; display: block; margin-top: 5px;">
                            This appears in course cards and search results
                        </small>
                        @error('short_description')
                            <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Full Description *</label>
                        <textarea id="description" name="description" class="form-control textarea" 
                                  placeholder="Detailed course description" required>{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Course Details -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-cog"></i> Course Details</h3>
                    
                    <!-- UPDATED: Instructor selection from users with instructor role -->
                    <div class="form-group instructor-select">
                        <label for="instructor_id">Instructor *</label>
                        <select id="instructor_id" name="instructor_id" class="form-control" required>
                            <option value="">Select Instructor</option>
                            @foreach($instructors as $instructor)
                                <option value="{{ $instructor->id }}" {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                    {{ $instructor->name }} ({{ $instructor->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('instructor_id')
                            <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="duration">Duration *</label>
                        <input type="text" id="duration" name="duration" class="form-control" 
                               placeholder="e.g., 8 weeks, 40 hours" required value="{{ old('duration') }}">
                        @error('duration')
                            <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="level">Level *</label>
                        <select id="level" name="level" class="form-control" required>
                            <option value="">Select Level</option>
                            <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                        @error('level')
                            <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="format">Format *</label>
                        <select id="format" name="format" class="form-control" required>
                            <option value="">Select Format</option>
                            <option value="online" {{ old('format') == 'online' ? 'selected' : '' }}>Online</option>
                            <option value="in-person" {{ old('format') == 'in-person' ? 'selected' : '' }}>In-Person</option>
                            <option value="hybrid" {{ old('format') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                        </select>
                        @error('format')
                            <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Course Content -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-book"></i> Course Content</h3>
                    
                    <div class="form-group">
                        <label for="tags">Tags (comma separated)</label>
                        <input type="text" id="tags" name="tags" class="form-control" 
                               placeholder="e.g., react, javascript, web development" value="{{ old('tags') }}">
                        <small style="color: #94a3b8; font-size: 11px; display: block; margin-top: 5px;">
                            Separate tags with commas
                        </small>
                        <div class="tags-container" id="tagsPreview"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="requirements">Requirements</label>
                        <textarea id="requirements" name="requirements" class="form-control textarea" 
                                  placeholder="List course requirements (one per line)">{{ old('requirements') }}</textarea>
                        <small style="color: #94a3b8; font-size: 11px; display: block; margin-top: 5px;">
                            Enter each requirement on a new line
                        </small>
                    </div>
                    
                    <div class="form-group">
                        <label for="what_you_will_learn">What You'll Learn</label>
                        <textarea id="what_you_will_learn" name="what_you_will_learn" class="form-control textarea" 
                                  placeholder="List learning outcomes (one per line)">{{ old('what_you_will_learn') }}</textarea>
                        <small style="color: #94a3b8; font-size: 11px; display: block; margin-top: 5px;">
                            Enter each learning outcome on a new line
                        </small>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-search"></i> SEO Settings</h3>
                    
                    <div class="form-group meta-input">
                        <label for="meta_description">Meta Description</label>
                        <textarea id="meta_description" name="meta_description" class="form-control" 
                                  placeholder="Brief description for search engines (max 160 characters)" 
                                  maxlength="160" oninput="updateCharCount(this)">{{ old('meta_description') }}</textarea>
                        <div class="char-count" id="metaCharCount">0/160</div>
                        <small style="color: #94a3b8; font-size: 11px; display: block; margin-top: 5px;">
                            This appears in search engine results
                        </small>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="sidebar-card">
                <!-- Course Image -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-image"></i> Course Image</h3>
                    
                    <div class="image-upload" id="imageUpload">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p style="color: #64748b; margin-bottom: 5px;">Click to upload image</p>
                        <p style="font-size: 11px; color: #94a3b8;">JPG, PNG up to 2MB</p>
                        <input type="file" id="image" name="image" accept="image/*" style="display: none;">
                        <img id="imagePreview" class="image-preview" alt="Preview">
                    </div>
                    @error('image')
                        <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Pricing -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-tag"></i> Pricing</h3>
                    
                    <div class="price-display" id="priceDisplay">$0.00</div>
                    
                    <div class="form-group">
                        <label for="price">Price ($) *</label>
                        <input type="number" id="price" name="price" class="form-control" 
                               step="0.01" min="0" placeholder="0.00" required 
                               value="{{ old('price', 0) }}" oninput="updatePriceDisplay()">
                        @error('price')
                            <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="checkbox-item" style="margin-bottom: 15px;">
                        <input type="checkbox" id="enableDiscount" onchange="toggleDiscount()">
                        <label for="enableDiscount" style="margin-bottom: 0;">Enable Discount</label>
                    </div>
                    
                    <div id="discountFields" style="display: none;">
                        <div class="discount-inputs">
                            <div class="form-group">
                                <label for="discounted_price">Discounted Price ($)</label>
                                <input type="number" id="discounted_price" name="discounted_price" 
                                       class="form-control" step="0.01" min="0" 
                                       placeholder="0.00" value="{{ old('discounted_price') }}"
                                       oninput="calculateDiscountPercentage()">
                            </div>
                            
                            <div class="form-group">
                                <label for="discount_percentage">Discount %</label>
                                <input type="number" id="discount_percentage" name="discount_percentage" 
                                       class="form-control" min="0" max="100" placeholder="0"
                                       value="{{ old('discount_percentage') }}"
                                       oninput="calculateDiscountedPrice()">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course Status -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-toggle-on"></i> Status</h3>
                    
                    <div class="checkbox-group">
                        <div class="checkbox-item">
                            <input type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" style="margin-bottom: 0;">Active</label>
                        </div>
                        
                        <div class="checkbox-item">
                            <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                   {{ old('is_featured') ? 'checked' : '' }}>
                            <label for="is_featured" style="margin-bottom: 0;">Featured</label>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Create Course
                </button>
                
                <a href="{{ route('admin.courses.index') }}" class="btn-cancel">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Image Upload Preview
    document.getElementById('imageUpload').addEventListener('click', function() {
        document.getElementById('image').click();
    });

    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                preview.src = e.target.result;
                preview.style.display = 'block';
                document.getElementById('imageUpload').style.padding = '15px';
            };
            reader.readAsDataURL(file);
        }
    });

    // Tags Preview
    document.getElementById('tags').addEventListener('input', function(e) {
        const tagsContainer = document.getElementById('tagsPreview');
        tagsContainer.innerHTML = '';
        
        const tags = this.value.split(',').map(tag => tag.trim()).filter(tag => tag);
        tags.forEach(tag => {
            const tagElement = document.createElement('div');
            tagElement.className = 'tag';
            tagElement.innerHTML = `
                ${tag}
                <span class="tag-remove" onclick="removeTag('${tag}')">×</span>
            `;
            tagsContainer.appendChild(tagElement);
        });
    });

    function removeTag(tagToRemove) {
        const tagsInput = document.getElementById('tags');
        const tags = tagsInput.value.split(',').map(tag => tag.trim()).filter(tag => tag);
        const updatedTags = tags.filter(tag => tag !== tagToRemove);
        tagsInput.value = updatedTags.join(', ');
        
        // Trigger input event to update preview
        tagsInput.dispatchEvent(new Event('input'));
    }

    // Price Display
    function updatePriceDisplay() {
        const price = document.getElementById('price').value || 0;
        document.getElementById('priceDisplay').textContent = '$' + parseFloat(price).toFixed(2);
    }

    // Discount Toggle
    function toggleDiscount() {
        const discountFields = document.getElementById('discountFields');
        discountFields.style.display = document.getElementById('enableDiscount').checked ? 'block' : 'none';
    }

    function calculateDiscountPercentage() {
        const price = parseFloat(document.getElementById('price').value) || 0;
        const discountedPrice = parseFloat(document.getElementById('discounted_price').value) || 0;
        
        if (price > 0 && discountedPrice > 0) {
            const discountPercentage = ((price - discountedPrice) / price) * 100;
            document.getElementById('discount_percentage').value = Math.round(discountPercentage);
        }
    }

    function calculateDiscountedPrice() {
        const price = parseFloat(document.getElementById('price').value) || 0;
        const discountPercentage = parseFloat(document.getElementById('discount_percentage').value) || 0;
        
        if (price > 0 && discountPercentage > 0) {
            const discountedPrice = price - (price * discountPercentage / 100);
            document.getElementById('discounted_price').value = discountedPrice.toFixed(2);
        }
    }

    // Meta Description Character Count
    function updateCharCount(textarea) {
        const charCount = textarea.value.length;
        document.getElementById('metaCharCount').textContent = `${charCount}/160`;
        
        // Change color if approaching limit
        const charCountElement = document.getElementById('metaCharCount');
        if (charCount > 150) {
            charCountElement.style.color = '#e53e3e';
        } else if (charCount > 130) {
            charCountElement.style.color = '#f59e0b';
        } else {
            charCountElement.style.color = '#94a3b8';
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        updatePriceDisplay();
        
        // Initialize discount if old value exists
        const discountPrice = parseFloat("{{ old('discounted_price', 0) }}");
        if (discountPrice > 0) {
            document.getElementById('enableDiscount').checked = true;
            toggleDiscount();
        }
        
        // Initialize tags if old value exists
        const tagsValue = "{{ old('tags', '') }}";
        if (tagsValue) {
            document.getElementById('tags').value = tagsValue;
            document.getElementById('tags').dispatchEvent(new Event('input'));
        }
        
        // Initialize meta description character count
        const metaDescription = document.getElementById('meta_description');
        if (metaDescription) {
            updateCharCount(metaDescription);
        }
        
        // Enhanced instructor select
        const instructorSelect = document.getElementById('instructor_id');
        if (instructorSelect) {
            // Create custom dropdown styling
            instructorSelect.addEventListener('focus', function() {
                this.style.borderColor = '#2D3E50';
                this.style.boxShadow = '0 0 0 3px rgba(45, 62, 80, 0.1)';
            });
            
            instructorSelect.addEventListener('blur', function() {
                this.style.borderColor = '#e2e8f0';
                this.style.boxShadow = 'none';
            });
        }
    });
</script>
@endsection