<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseMaterial extends Model
{
    use HasFactory;

    protected $table = 'course_materials';
    
    protected $fillable = [
        'course_id',
        'instructor_id',
        'title',
        'description',
        'file_path',
        'file_type',
        'external_link',
        'file_size',
        'type',
        'order_position'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function getFileUrlAttribute()
    {
        if ($this->external_link) {
            return $this->external_link;
        }
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }
}