<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'short_description',
        'price',
        'discounted_price',
        'discount_percentage',
        'instructor_name',
        'duration',
        'rating',
        'total_students',
        'level',
        'format',
        'image_path',
        'tags',
        'is_featured',
        'is_active',
        'meta_description',
        'requirements',
        'what_you_will_learn',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discounted_price' => 'decimal:2',
        'rating' => 'decimal:1',
        'total_students' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'tags' => 'array',
        'requirements' => 'array',
        'what_you_will_learn' => 'array',
    ];

    // العلاقات
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function learningPathItems()
    {
        return $this->hasMany(LearningPathItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(CourseReview::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function sessions()
    {
        return $this->hasMany(CourseSession::class);
    }
    
    public function assignments()
    {
        return $this->hasMany(CourseAssignment::class);
    }
    
    public function materials()
    {
        return $this->hasMany(CourseMaterial::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOfCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeOfLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    public function scopeOfFormat($query, $format)
    {
        return $query->where('format', $format);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->orWhere('instructor_name', 'like', "%{$search}%");
    }

    // دوال مساعدة
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            // Direct URL for testing
            return Storage::url($this->image_path);
        }
        
        return asset('images/course-placeholder.jpg');
    }

    public function getFinalPriceAttribute()
    {
        return $this->discounted_price ?? $this->price;
    }

    public function getIsDiscountedAttribute()
    {
        return !is_null($this->discounted_price);
    }

    public function getDiscountAmountAttribute()
    {
        if (!$this->is_discounted) return 0;
        return $this->price - $this->discounted_price;
    }

    public function getDurationInWeeksAttribute()
    {
        preg_match('/(\d+)\s*weeks?/i', $this->duration, $matches);
        return $matches[1] ?? 4; // Default to 4 weeks if not specified
    }

    public function getEnrolledStudentsCountAttribute()
    {
        return $this->enrollments()->count();
    }

    public function getActiveStudentsCountAttribute()
    {
        return $this->enrollments()->where('status', 'active')->count();
    }

    public function getAverageProgressAttribute()
    {
        return $this->enrollments()->avg('progress_percentage') ?? 0;
    }

    public function getTagsListAttribute()
    {
        return is_array($this->tags) ? $this->tags : json_decode($this->tags ?? '[]', true);
    }

    public function getRequirementsListAttribute()
    {
        return is_array($this->requirements) ? $this->requirements : json_decode($this->requirements ?? '[]', true);
    }

    public function getLearningsListAttribute()
    {
        return is_array($this->what_you_will_learn) ? $this->what_you_will_learn : json_decode($this->what_you_will_learn ?? '[]', true);
    }

    public function incrementStudentsCount()
    {
        $this->increment('total_students');
    }
}