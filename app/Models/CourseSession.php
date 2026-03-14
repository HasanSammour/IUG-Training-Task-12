<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseSession extends Model
{
    use HasFactory;

    protected $table = 'course_sessions';
    
    protected $fillable = [
        'course_id',
        'instructor_id',
        'title',
        'description',
        'meeting_url',
        'recording_url',
        'start_time',
        'end_time',
        'status'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function attendance()
    {
        return $this->hasMany(SessionAttendance::class, 'course_session_id');
    }

    public function attendedStudents()
    {
        return $this->belongsToMany(User::class, 'session_attendance', 'course_session_id', 'user_id')
                    ->withPivot('attended', 'instructor_notes')
                    ->withTimestamps();
    }
}