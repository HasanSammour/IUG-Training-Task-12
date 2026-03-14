@extends('layouts.app')

@section('title', $assignment->title . ' - Assignment')
@section('body-class', 'auth-page')

@section('styles')
<style>
    .assignment-container {
        padding: 30px 40px;
        max-width: 1000px;
        margin: 0 auto;
        padding-bottom: 100px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        text-decoration: none;
        font-size: 14px;
        margin-bottom: 20px;
        transition: color 0.3s ease;
    }

    .back-link:hover {
        color: #2D3E50;
    }

    .assignment-card {
        background: white;
        border-radius: 24px;
        padding: 40px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .assignment-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .assignment-title {
        font-size: 32px;
        color: #2D3E50;
        font-weight: 700;
        margin: 0;
    }

    .assignment-points {
        background: #e2e8f0;
        color: #475569;
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
    }

    .assignment-meta {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
        padding: 20px;
        background: #f8fafc;
        border-radius: 16px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .meta-icon {
        width: 40px;
        height: 40px;
        background: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #2D3E50;
        font-size: 16px;
    }

    .meta-content {
        flex: 1;
    }

    .meta-label {
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .meta-value {
        font-size: 15px;
        font-weight: 600;
        color: #2D3E50;
    }

    .assignment-description {
        margin-bottom: 40px;
        padding: 25px;
        background: #f8fafc;
        border-radius: 16px;
        border-left: 4px solid #3182ce;
    }

    .description-title {
        font-size: 16px;
        font-weight: 600;
        color: #2D3E50;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .description-text {
        color: #475569;
        font-size: 15px;
        line-height: 1.7;
        white-space: pre-wrap;
    }

    .submission-section {
        margin-top: 40px;
        padding: 25px;
        background: #f8fafc;
        border-radius: 16px;
    }

    .section-title {
        font-size: 20px;
        color: #2D3E50;
        margin-bottom: 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .submission-status {
        margin-bottom: 25px;
        padding: 20px;
        border-radius: 12px;
    }

    .status-graded {
        background: #dcfce7;
        border: 1px solid #bbf7d0;
    }

    .status-submitted {
        background: #dbeafe;
        border: 1px solid #bae6fd;
    }

    .status-pending {
        background: #fef3c7;
        border: 1px solid #fde68a;
    }

    .grade-box {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .grade-value {
        font-size: 36px;
        font-weight: 700;
        color: #15803d;
    }

    .grade-total {
        font-size: 18px;
        color: #64748b;
    }

    .feedback-box {
        margin-top: 20px;
        padding: 20px;
        background: white;
        border-radius: 12px;
    }

    .feedback-text {
        color: #475569;
        font-size: 14px;
        line-height: 1.6;
    }

    .submission-info {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #64748b;
        font-weight: 500;
    }

    .info-value {
        color: #2D3E50;
        font-weight: 600;
    }

    .file-attachment {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: white;
        border-radius: 10px;
        text-decoration: none;
        color: inherit;
        border: 1px solid #e2e8f0;
        margin-top: 15px;
    }

    .file-attachment:hover {
        border-color: #3182ce;
    }

    .file-icon {
        width: 45px;
        height: 45px;
        background: #e0f2fe;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0284c7;
        font-size: 18px;
    }

    .file-info {
        flex: 1;
    }

    .file-name {
        font-size: 14px;
        font-weight: 600;
        color: #2D3E50;
        margin-bottom: 2px;
    }

    .file-size {
        font-size: 11px;
        color: #64748b;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #2D3E50;
    }

    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }

    .file-input {
        padding: 20px;
        border: 2px dashed #e2e8f0;
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-input:hover {
        border-color: #3182ce;
        background: #f8fafc;
    }

    .file-input i {
        font-size: 32px;
        color: #94a3b8;
        margin-bottom: 10px;
    }

    .file-input p {
        color: #64748b;
        font-size: 13px;
    }

    .file-preview {
        margin-top: 10px;
        padding: 10px;
        background: #f1f5f9;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-submit {
        width: 100%;
        padding: 14px;
        background: #2D3E50;
        color: white;
        border: none;
        border-radius: 10px;
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
    }

    .btn-submit:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .file-note {
        margin-top: 10px;
        padding: 12px;
        background: #f0f9ff;
        border-radius: 8px;
        color: #0369a1;
        font-size: 13px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    @media (max-width: 768px) {
        .assignment-container {
            padding: 20px;
        }

        .assignment-card {
            padding: 25px;
        }

        .assignment-title {
            font-size: 24px;
        }

        .grade-box {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endsection

@section('content')
<div class="assignment-container">
    <a href="{{ route('courses.assignments.index', $course->id) }}" class="back-link">
        <i class="fas fa-arrow-left"></i>
        Back to Assignments
    </a>

    <div class="assignment-card">
        <div class="assignment-header">
            <h1 class="assignment-title">{{ $assignment->title }}</h1>
            <span class="assignment-points">{{ $assignment->points }} points</span>
        </div>

        <div class="assignment-meta">
            @if($assignment->due_date)
                <div class="meta-item">
                    <div class="meta-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="meta-content">
                        <div class="meta-label">Due Date</div>
                        <div class="meta-value {{ $isOverdue ? 'text-danger' : '' }}">
                            {{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') }}
                            @if($isOverdue)
                                <span style="color: #dc2626; font-size: 12px;">(Overdue)</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <div class="meta-item">
                <div class="meta-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="meta-content">
                    <div class="meta-label">Status</div>
                    <div class="meta-value">
                        @if($submission)
                            @if($submission->grade)
                                <span style="color: #15803d;">Graded</span>
                            @else
                                <span style="color: #1e40af;">Submitted</span>
                            @endif
                        @else
                            <span style="color: #92400e;">Not Started</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="meta-item">
                <div class="meta-icon">
                    <i class="fas fa-file"></i>
                </div>
                <div class="meta-content">
                    <div class="meta-label">Attachment</div>
                    <div class="meta-value">
                        @if($assignment->file_path)
                            <a href="{{ Storage::url($assignment->file_path) }}" target="_blank" style="color: #3182ce;">Download</a>
                        @else
                            No attachment
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($assignment->description)
            <div class="assignment-description">
                <h3 class="description-title">
                    <i class="fas fa-align-left"></i>
                    Assignment Description
                </h3>
                <div class="description-text">{{ $assignment->description }}</div>
            </div>
        @endif

        <div class="submission-section">
            <h3 class="section-title">
                <i class="fas fa-{{ $submission ? 'edit' : 'upload' }}"></i>
                {{ $submission ? 'Your Submission' : 'Submit Your Work' }}
            </h3>

            @if($submission)
                <!-- Existing Submission -->
                <div class="submission-status status-{{ $submission->grade ? 'graded' : 'submitted' }}">
                    @if($submission->grade)
                        <div class="grade-box">
                            <span class="grade-value">{{ $submission->grade }}</span>
                            <span class="grade-total">/ {{ $assignment->points }} points</span>
                        </div>
                        @if($submission->feedback)
                            <div class="feedback-box">
                                <strong style="color: #2D3E50; display: block; margin-bottom: 8px;">
                                    <i class="fas fa-comment"></i> Instructor Feedback:
                                </strong>
                                <div class="feedback-text">{{ $submission->feedback }}</div>
                            </div>
                        @endif
                    @else
                        <div style="display: flex; align-items: center; gap: 10px; color: #1e40af;">
                            <i class="fas fa-clock"></i>
                            <strong>Your assignment has been submitted and is awaiting grading.</strong>
                        </div>
                    @endif

                    <div class="submission-info">
                        <div class="info-row">
                            <span class="info-label">Submitted on:</span>
                            <span class="info-value">{{ $submission->submitted_at?->format('M d, Y - h:i A') ?? 'Not submitted' }}</span>                        </div>
                        <div class="info-row">
                            <span class="info-label">Status:</span>
                            <span class="info-value">{{ $submission->grade ? 'Graded' : 'Pending Review' }}</span>
                        </div>
                    </div>

                    @if($submission->submission_text)
                        <div style="margin-top: 20px; padding: 15px; background: white; border-radius: 10px;">
                            <strong style="color: #2D3E50; display: block; margin-bottom: 10px;">Your Answer:</strong>
                            <div style="color: #475569;">{{ $submission->submission_text }}</div>
                        </div>
                    @endif

                    @if($submission->file_path)
                        <a href="{{ route('courses.assignments.download', [$course->id, $submission]) }}" class="file-attachment">
                            <div class="file-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="file-info">
                                <div class="file-name">{{ basename($submission->file_path) }}</div>
                                <div class="file-size">Click to download your submitted file</div>
                            </div>
                            <i class="fas fa-download" style="color: #64748b;"></i>
                        </a>
                    @endif

                    @if(!$submission->grade)
                        <div class="file-note">
                            <i class="fas fa-info-circle"></i>
                            You can edit your submission until the instructor starts grading.
                        </div>
                    @endif
                </div>
            @endif

            @if(!$submission || (!$submission->grade && !$isOverdue))
                <!-- Submission Form -->
                <form id="submissionForm">
                    @csrf
                    <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">

                    <div class="form-group">
                        <label class="form-label">Your Answer</label>
                        <textarea name="submission_text" class="form-control" placeholder="Type your answer here...">{{ $submission->submission_text ?? '' }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Upload File (Optional)</label>
                        <div class="file-input" onclick="document.getElementById('file').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Click to upload or drag and drop</p>
                            <p style="font-size: 11px;">PDF, DOC, DOCX, ZIP (Max 20MB)</p>
                            <input type="file" id="file" name="file" style="display: none;">
                        </div>
                        <div id="filePreview" class="file-preview" style="display: none;">
                            <i class="fas fa-check-circle" style="color: #10b981;"></i>
                            <span id="fileName"></span>
                            <button type="button" onclick="removeFile()" style="margin-left: auto; background: none; border: none; color: #ef4444; cursor: pointer;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn">
                        <i class="fas fa-paper-plane"></i>
                        {{ $submission ? 'Update Submission' : 'Submit Assignment' }}
                    </button>
                </form>

                <div class="file-note">
                    <i class="fas fa-info-circle"></i>
                    You can submit text, upload files, or both. Make sure to review your work before submitting.
                </div>
            @elseif($isOverdue && !$submission)
                <div class="submission-status status-pending" style="text-align: center;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 32px; color: #92400e; margin-bottom: 10px;"></i>
                    <h4 style="color: #92400e; margin-bottom: 5px;">Assignment Overdue</h4>
                    <p style="color: #92400e;">The due date for this assignment has passed. Please contact your instructor.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    document.getElementById('file')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('fileName').textContent = file.name;
            document.getElementById('filePreview').style.display = 'flex';
        }
    });

    function removeFile() {
        document.getElementById('file').value = '';
        document.getElementById('filePreview').style.display = 'none';
    }

    document.getElementById('submissionForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
        submitBtn.disabled = true;
        
        fetch('{{ route("courses.assignments.submit", [$course->id, $assignment->id]) }}', {
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
                    title: 'Success!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.error || 'Something went wrong'
                });
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to submit assignment'
            });
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
</script>
@endsection