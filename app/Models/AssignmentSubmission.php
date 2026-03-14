<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $table = 'assignment_submissions';
    
    protected $fillable = [
        'course_assignment_id',
        'user_id',
        'submission_text',
        'file_path',
        'grade',
        'feedback',
        'status',
        'submitted_at'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function assignment()
    {
        return $this->belongsTo(CourseAssignment::class, 'course_assignment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}