<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningPath extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'total_courses',
        'completed_courses',
        'total_weeks',
        'progress_percentage',
        'next_milestone',
        'is_ai_generated',
        'goals',
        'estimated_completion_date',
    ];

    protected $casts = [
        'is_ai_generated' => 'boolean',
        'goals' => 'array',
        'estimated_completion_date' => 'date',
        'progress_percentage' => 'integer',
        'total_courses' => 'integer',
        'completed_courses' => 'integer',
        'total_weeks' => 'integer',
    ];

    // العلاقات
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(LearningPathItem::class)->orderBy('position');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'learning_path_items')
                    ->withPivot('position', 'status', 'progress')
                    ->orderBy('position');
    }

    // Scopes
    public function scopeAiGenerated($query)
    {
        return $query->where('is_ai_generated', true);
    }

    public function scopeManual($query)
    {
        return $query->where('is_ai_generated', false);
    }

    public function scopeCompleted($query)
    {
        return $query->whereColumn('completed_courses', '>=', 'total_courses');
    }

    public function scopeInProgress($query)
    {
        return $query->whereColumn('completed_courses', '<', 'total_courses')
                    ->where('progress_percentage', '>', 0);
    }

    // دوال مساعدة
    public function getStatusAttribute()
    {
        if ($this->completed_courses >= $this->total_courses) return 'completed';
        if ($this->progress_percentage > 0) return 'in_progress';
        return 'not_started';
    }

    public function getStatusTextAttribute()
    {
        $statuses = [
            'completed' => 'Completed',
            'in_progress' => 'In Progress',
            'not_started' => 'Not Started',
        ];

        return $statuses[$this->status] ?? 'Unknown';
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'completed' => 'green',
            'in_progress' => 'blue',
            'not_started' => 'gray',
        ];

        return $colors[$this->status] ?? 'gray';
    }

    public function getRemainingCoursesAttribute()
    {
        return $this->total_courses - $this->completed_courses;
    }

    public function getEstimatedCompletionWeeksAttribute()
    {
        if ($this->progress_percentage == 0) return $this->total_weeks;
        
        $remainingPercentage = 100 - $this->progress_percentage;
        $completedWeeks = ($this->progress_percentage / 100) * $this->total_weeks;
        $remainingWeeks = ($remainingPercentage / 100) * $this->total_weeks;
        
        return ceil($remainingWeeks);
    }

    public function getGoalsListAttribute()
    {
        return is_array($this->goals) ? $this->goals : json_decode($this->goals ?? '[]', true);
    }

    public function addCourse(Course $course, $position = null)
    {
        if ($position === null) {
            $position = $this->items()->max('position') + 1;
        }

        return $this->items()->create([
            'course_id' => $course->key(),
            'position' => $position,
            'status' => 'locked',
            'progress' => 0,
        ]);
    }

    public function updateProgress()
    {
        $completed = $this->items()->where('status', 'completed')->count();
        $total = $this->items()->count();
        
        $progress = $total > 0 ? round(($completed / $total) * 100) : 0;
        
        $this->update([
            'completed_courses' => $completed,
            'progress_percentage' => $progress,
        ]);
    }

    public function getNextCourse()
    {
        return $this->items()
            ->where('status', '!=', 'completed')
            ->orderBy('position')
            ->first();
    }
}