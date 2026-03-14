<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LearningPathItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'learning_path_id',
        'course_id',
        'position',
        'status',
        'progress',
        'started_at',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'position' => 'integer',
        'progress' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // القيم الثابتة
    const STATUS_LOCKED = 'locked';
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';

    // العلاقات
    public function learningPath()
    {
        return $this->belongsTo(LearningPath::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Scopes
    public function scopeLocked($query)
    {
        return $query->where('status', self::STATUS_LOCKED);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeInProgress($query)
    {
        return $query->where('progress', '>', 0)->where('progress', '<', 100);
    }

    // دوال مساعدة
    public function getStatusTextAttribute()
    {
        $statuses = [
            self::STATUS_LOCKED => 'Locked',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_COMPLETED => 'Completed',
        ];

        return $statuses[$this->status] ?? 'Unknown';
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            self::STATUS_LOCKED => 'gray',
            self::STATUS_ACTIVE => 'blue',
            self::STATUS_COMPLETED => 'green',
        ];

        return $colors[$this->status] ?? 'gray';
    }

    public function getIsLockedAttribute()
    {
        return $this->status === self::STATUS_LOCKED;
    }

    public function getIsActiveAttribute()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function getIsCompletedAttribute()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function unlock()
    {
        $this->update(['status' => self::STATUS_ACTIVE]);
    }

    public function markAsActive()
    {
        $this->update([
            'status' => self::STATUS_ACTIVE,
            'started_at' => now(),
        ]);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'progress' => 100,
            'completed_at' => now(),
        ]);
    }

    public function updateProgress($progress)
    {
        $progress = max(0, min(100, $progress));
        
        $this->update([
            'progress' => $progress,
            'status' => $progress == 100 ? self::STATUS_COMPLETED : self::STATUS_ACTIVE,
            'completed_at' => $progress == 100 ? now() : null,
        ]);
    }

    public function getPreviousItem()
    {
        return $this->learningPath->items()
            ->where('position', '<', $this->position)
            ->orderByDesc('position')
            ->first();
    }

    public function getNextItem()
    {
        return $this->learningPath->items()
            ->where('position', '>', $this->position)
            ->orderBy('position')
            ->first();
    }

    public function canBeUnlocked()
    {
        $previous = $this->getPreviousItem();
        return !$previous || $previous->is_completed;
    }
}
