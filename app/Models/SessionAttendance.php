<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SessionAttendance extends Model
{
    use HasFactory;

    protected $table = 'session_attendance';
    
    protected $fillable = [
        'course_session_id',
        'user_id',
        'attended',
        'instructor_notes'
    ];

    protected $casts = [
        'attended' => 'boolean',
    ];

    public function session()
    {
        return $this->belongsTo(CourseSession::class, 'course_session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}