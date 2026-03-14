<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

      protected $fillable = [
        'name',
        'slug',
        'icon',
        'description',
        'color',
        'is_active',
    ];
    protected $casts = [
        'is_active' => 'boolean',
    ];

    // these accessors to the $appends array
    protected $appends = ['course_count', 'active_course_count'];

    // العلاقات
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeWithCourseCount($query)
    {
        return $query->withCount('courses');
    }

    // دوال مساعدة
    public function getIconClassAttribute()
    {
        return $this->icon ?? 'fa-folder';
    }

    public function getCourseCountAttribute()
    {
        if (array_key_exists('courses_count', $this->attributes)) {
            return $this->attributes['courses_count'];
        }
        
        return $this->courses()->count();
    }

    public function getActiveCourseCountAttribute()
    {
        // If we loaded the relationship count, use it
        if (array_key_exists('courses_count', $this->attributes)) {
            // We need to actually count active courses
            return $this->courses()->where('is_active', true)->count();
        }
        
        return $this->courses()->where('is_active', true)->count();
    }

    public function getCategoryColorAttribute()
    {
        return $this->color ?? '#3B82F6';
    }

    public function getStatusTextAttribute()
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }

    public function getStatusColorAttribute()
    {
        return $this->is_active ? '#10B981' : '#EF4444';
    }
}
