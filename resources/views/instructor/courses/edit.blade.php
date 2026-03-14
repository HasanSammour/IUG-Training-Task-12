@extends('layouts.app')

@section('title', 'Edit Course - Instructor')
@section('body-class', 'instructor-page')

@section('styles')
<style>
    .instructor-page {
        background-color: #f8fbff;
        min-height: 100vh;
        padding-bottom: 70px;
    }

    .instructor-container {
        padding: 20px;
        max-width: 1100px;
        margin: 0 auto;
    }

    .page-container {
        padding: 0 20px;
    }

    @media (max-width: 768px) {
        .page-container {
            padding: 0 15px;
        }
    }

    .instructor-header {
        margin-bottom: 30px;
        padding: 0 20px;
    }

    .instructor-title {
        font-size: 24px;
        color: #2D3E50;
        margin-bottom: 30px;
    }

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

    .instructor-card {
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

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
    }

    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        background: white;
        transition: border-color 0.3s ease;
    }

    .form-input:focus, .form-select:focus, .form-textarea:focus {
        outline: none;
        border-color: #2D3E50;
        box-shadow: 0 0 0 3px rgba(45, 62, 80, 0.1);
    }

    .form-input:disabled, .form-select:disabled {
        background: #f1f5f9;
        cursor: not-allowed;
        opacity: 0.7;
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    .checkbox-group {
        display: flex;
        gap: 15px;
        margin-bottom: 10px;
    }

    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .checkbox-item input {
        width: 16px;
        height: 16px;
    }

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
        border: 1px solid #e2e8f0;
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

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 768px) {
        .grid-2 {
            grid-template-columns: 1fr;
        }
    }

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

    .current-image-section {
        margin-top: 20px;
        text-align: center;
        padding: 15px;
        background: #f8fafc;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }

    .current-image-section p {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 10px;
    }

    .instructor-info {
        background: #f0f7ff;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .instructor-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2d3e50, #3182ce);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
    }

    .instructor-details h4 {
        font-size: 16px;
        color: #2D3E50;
        margin-bottom: 2px;
        font-weight: 600;
    }

    .instructor-details p {
        font-size: 13px;
        color: #64748b;
    }

    .warning-badge {
        background: #fff3cd;
        color: #856404;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 15px;
    }
</style>
@endsection

@section('content')
<div class="page-container">
    <div class="instructor-container">
        <div class="instructor-header">
            <h1 class="instructor-title">
                <a href="{{ route('instructor.courses') }}" style="color: inherit; text-decoration: none; margin-right: 10px;">
                    <i class="fas fa-arrow-left"></i>
                </a>
                Edit Course: {{ $course->title }}
            </h1>
        </div>

        <div class="warning-badge">
            <i class="fas fa-info-circle"></i>
            You're editing this course as an instructor
        </div>

        <form action="{{ route('instructor.courses.update', $course) }}" method="POST" enctype="multipart/form-data" class="form-layout">
            @csrf
            @method('PUT')
            
            <!-- Left Column: Main Form -->
            <div class="instructor-card">
                <!-- Instructor Info (Fixed) -->
                <div class="instructor-info">
                    <div class="instructor-avatar">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="instructor-details">
                        <h4>{{ auth()->user()->name }}</h4>
                        <p>{{ auth()->user()->email }} · Course Instructor</p>
                    </div>
                </div>

                <!-- Basic Information -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-info-circle"></i> Basic Information</h3>
                    
                    <div class="form-group">
                        <label for="title" class="form-label">Course Title *</label>
                        <input type="text" id="title" name="title" class="form-input" 
                               value="{{ old('title', $course->title) }}" required>
                        @error('title')
                            <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="grid-2">
                        <div class="form-group">
                            <label for="category_id" class="form-label">Category *</label>
                            <select id="category_id" name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id', $course->category_id) == $category->id) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Instructor</label>
                            <input type="text" class="form-input" value="{{ $course->instructor_name }}" disabled>
                            <small style="color: #94a3b8; font-size: 11px;">Instructor cannot be changed</small>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="short_description" class="form-label">Short Description *</label>
                        <textarea id="short_description" name="short_description" class="form-input" 
                                  maxlength="500" required>{{ old('short_description', $course->short_description) }}</textarea>
                        <small style="color: #94a3b8; font-size: 11px; display: block; margin-top: 5px;">
                            This appears in course cards and search results
                        </small>
                        @error('short_description')
                            <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="description" class="form-label">Full Description *</label>
                        <textarea id="description" name="description" class="form-textarea" 
                                  required>{{ old('description', $course->description) }}</textarea>
                        @error('description')
                            <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Course Details -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-cog"></i> Course Details</h3>
                    
                    <div class="grid-2">
                        <div class="form-group">
                            <label for="duration" class="form-label">Duration *</label>
                            <input type="text" id="duration" name="duration" class="form-input" 
                                   placeholder="e.g., 8 weeks, 40 hours" value="{{ old('duration', $course->duration) }}" required>
                            @error('duration')
                                <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="level" class="form-label">Level *</label>
                            <select id="level" name="level" class="form-select" required>
                                <option value="">Select Level</option>
                                <option value="beginner" {{ old('level', $course->level) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ old('level', $course->level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ old('level', $course->level) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                            @error('level')
                                <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="grid-2">
                        <div class="form-group">
                            <label for="format" class="form-label">Format *</label>
                            <select id="format" name="format" class="form-select" required>
                                <option value="">Select Format</option>
                                <option value="online" {{ old('format', $course->format) == 'online' ? 'selected' : '' }}>Online</option>
                                <option value="in-person" {{ old('format', $course->format) == 'in-person' ? 'selected' : '' }}>In-Person</option>
                                <option value="hybrid" {{ old('format', $course->format) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            </select>
                            @error('format')
                                <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="total_students" class="form-label">Total Students</label>
                            <input type="number" id="total_students" name="total_students" class="form-input" 
                                   min="0" value="{{ old('total_students', $course->total_students) }}" disabled>
                            <small style="color: #94a3b8; font-size: 11px;">Auto-updated based on enrollments</small>
                            @error('total_students')
                                <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Course Content -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-book"></i> Course Content</h3>
                    
                    <div class="form-group">
                        <label for="tags" class="form-label">Tags (comma separated)</label>
                        <input type="text" id="tags" name="tags" class="form-input" 
                               placeholder="e.g., react, javascript, web development" 
                               value="{{ old('tags', is_array($course->tags_list) ? implode(', ', $course->tags_list) : $course->tags) }}">
                        <small style="color: #94a3b8; font-size: 11px; display: block; margin-top: 5px;">
                            Separate tags with commas
                        </small>
                        <div class="tags-container" id="tagsPreview">
                            @if(is_array($course->tags_list) && count($course->tags_list) > 0)
                                @foreach($course->tags_list as $tag)
                                    <div class="tag">
                                        {{ $tag }}
                                        <span class="tag-remove" onclick="removeTag('{{ $tag }}')">×</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="requirements" class="form-label">Requirements</label>
                        <textarea id="requirements" name="requirements" class="form-textarea" 
                                  placeholder="List course requirements (one per line)">{{ old('requirements', is_array($course->requirements_list) ? implode("\n", $course->requirements_list) : $course->requirements) }}</textarea>
                        <small style="color: #94a3b8; font-size: 11px; display: block; margin-top: 5px;">
                            Enter each requirement on a new line
                        </small>
                    </div>
                    
                    <div class="form-group">
                        <label for="what_you_will_learn" class="form-label">What You'll Learn</label>
                        <textarea id="what_you_will_learn" name="what_you_will_learn" class="form-textarea" 
                                  placeholder="List learning outcomes (one per line)">{{ old('what_you_will_learn', is_array($course->learnings_list) ? implode("\n", $course->learnings_list) : $course->what_you_will_learn) }}</textarea>
                        <small style="color: #94a3b8; font-size: 11px; display: block; margin-top: 5px;">
                            Enter each learning outcome on a new line
                        </small>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-search"></i> SEO Settings</h3>
                    
                    <div class="form-group meta-input">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea id="meta_description" name="meta_description" class="form-input" 
                                  placeholder="Brief description for search engines (max 160 characters)" 
                                  maxlength="160" oninput="updateCharCount(this)">{{ old('meta_description', $course->meta_description) }}</textarea>
                        <div class="char-count" id="metaCharCount">{{ strlen($course->meta_description ?? '') }}/160</div>
                        <small style="color: #94a3b8; font-size: 11px; display: block; margin-top: 5px;">
                            This appears in search engine results
                        </small>
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar -->
            <div class="instructor-card">
                <!-- Course Image -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-image"></i> Course Image</h3>
                    
                    @if($course->image_path)
                        <div class="current-image-section">
                            <p>Current Image:</p>
                            <img src="{{ $course->image_url }}" alt="{{ $course->title }}" class="image-preview">
                        </div>
                    @endif
                    
                    <div class="image-upload" id="imageUpload">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p style="color: #64748b; margin-bottom: 5px;">Click to upload new image</p>
                        <p style="font-size: 11px; color: #94a3b8;">JPG, PNG up to 2MB</p>
                        <input type="file" id="image" name="image" accept="image/*" style="display: none;">
                        <img id="imagePreview" class="image-preview" alt="New Image Preview" style="display: none;">
                    </div>
                    @error('image')
                        <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Pricing -->
                <div class="form-section">
                    <h3 class="section-title"><i class="fas fa-tag"></i> Pricing</h3>
                    
                    <div class="price-display" id="priceDisplay">${{ number_format($course->price, 2) }}</div>
                    
                    <div class="form-group">
                        <label for="price" class="form-label">Price ($) *</label>
                        <input type="number" id="price" name="price" class="form-input" 
                               step="0.01" min="0" placeholder="0.00" required 
                               value="{{ old('price', $course->price) }}" oninput="updatePriceDisplay()">
                        @error('price')
                            <span class="text-danger" style="color: #e53e3e; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="checkbox-item" style="margin-bottom: 15px;">
                        <input type="checkbox" id="enableDiscount" onchange="toggleDiscount()" 
                               {{ ($course->discounted_price && $course->discounted_price > 0) ? 'checked' : '' }}>
                        <label for="enableDiscount" style="margin-bottom: 0;">Enable Discount</label>
                    </div>
                    
                    <div id="discountFields" style="display: {{ ($course->discounted_price && $course->discounted_price > 0) ? 'block' : 'none' }};">
                        <div class="discount-inputs">
                            <div class="form-group">
                                <label for="discounted_price" class="form-label">Discounted Price ($)</label>
                                <input type="number" id="discounted_price" name="discounted_price" 
                                       class="form-input" step="0.01" min="0" 
                                       placeholder="0.00" value="{{ old('discounted_price', $course->discounted_price) }}"
                                       oninput="calculateDiscountPercentage()">
                            </div>
                            
                            <div class="form-group">
                                <label for="discount_percentage" class="form-label">Discount %</label>
                                <input type="number" id="discount_percentage" name="discount_percentage" 
                                       class="form-input" min="0" max="100" placeholder="0"
                                       value="{{ old('discount_percentage', $course->discount_percentage) }}"
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
                                   {{ old('is_active', $course->is_active) ? 'checked' : '' }}>
                            <label for="is_active" style="margin-bottom: 0;">Active</label>
                        </div>
                        
                        <div class="checkbox-item">
                            <input type="checkbox" id="is_featured" name="is_featured" value="1"
                                   {{ old('is_featured', $course->is_featured) ? 'checked' : '' }}>
                            <label for="is_featured" style="margin-bottom: 0;">Featured</label>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Update Course
                </button>
                
                <a href="{{ route('instructor.courses') }}" class="btn-cancel">
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
        
        // Initialize tags preview
        const tagsValue = document.getElementById('tags').value;
        if (tagsValue) {
            document.getElementById('tags').dispatchEvent(new Event('input'));
        }
        
        // Initialize meta description character count
        const metaDescription = document.getElementById('meta_description');
        if (metaDescription) {
            updateCharCount(metaDescription);
        }
    });
</script>
@endsection