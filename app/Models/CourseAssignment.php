<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseAssignment extends Model
{
    use HasFactory;

    protected $table = 'course_assignments';
    
    protected $fillable = [
        'course_id',
        'instructor_id',
        'title',
        'description',
        'file_path',
        'due_date',
        'points'
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class, 'course_assignment_id');
    }
}