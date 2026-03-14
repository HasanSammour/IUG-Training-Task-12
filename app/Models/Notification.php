<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'is_read',
        'data',
        'action_url',
        'action_text',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'data' => 'array',
        'created_at' => 'datetime',
    ];

    // أنواع الإشعارات
    const TYPE_COURSE = 'course';
    const TYPE_SYSTEM = 'system';
    const TYPE_ENROLLMENT = 'enrollment';
    const TYPE_PROGRESS = 'progress';
    const TYPE_ACHIEVEMENT = 'achievement';
    const TYPE_REMINDER = 'reminder';
    const TYPE_MESSAGE = 'message';

    // العلاقات
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // دوال مساعدة
    public function getTypeIconAttribute()
    {
        $icons = [
            self::TYPE_COURSE => 'fa-book',
            self::TYPE_SYSTEM => 'fa-cog',
            self::TYPE_ENROLLMENT => 'fa-user-plus',
            self::TYPE_PROGRESS => 'fa-chart-line',
            self::TYPE_ACHIEVEMENT => 'fa-trophy',
            self::TYPE_REMINDER => 'fa-bell',
            self::TYPE_MESSAGE => 'fa-envelope',
        ];

        return $icons[$this->type] ?? 'fa-bell';
    }

    public function getTypeColorAttribute()
    {
        $colors = [
            self::TYPE_COURSE => 'blue',
            self::TYPE_SYSTEM => 'gray',
            self::TYPE_ENROLLMENT => 'green',
            self::TYPE_PROGRESS => 'yellow',
            self::TYPE_ACHIEVEMENT => 'purple',
            self::TYPE_REMINDER => 'red',
            self::TYPE_MESSAGE => 'blue',
        ];

        return $colors[$this->type] ?? 'gray';
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getIsRecentAttribute()
    {
        return $this->created_at->greaterThan(now()->subHours(24));
    }

    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    public function markAsUnread()
    {
        $this->update(['is_read' => false]);
    }

    // دوال إنشاء إشعارات
    public static function createCourseNotification($userId, $title, $message, $courseId = null, $actionUrl = null)
    {
        return self::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => self::TYPE_COURSE,
            'data' => $courseId ? ['course_id' => $courseId] : null,
            'action_url' => $actionUrl,
            'action_text' => 'View Course',
        ]);
    }

    public static function createEnrollmentNotification($userId, $courseTitle)
    {
        return self::create([
            'user_id' => $userId,
            'title' => 'New Enrollment',
            'message' => "You have been enrolled in '{$courseTitle}'",
            'type' => self::TYPE_ENROLLMENT,
            'action_text' => 'Start Learning',
        ]);
    }

    public static function createProgressNotification($userId, $courseTitle, $progress)
    {
        return self::create([
            'user_id' => $userId,
            'title' => 'Progress Update',
            'message' => "You've reached {$progress}% in '{$courseTitle}'",
            'type' => self::TYPE_PROGRESS,
            'action_text' => 'Continue',
        ]);
    }

    public static function createAchievementNotification($userId, $achievement)
    {
        return self::create([
            'user_id' => $userId,
            'title' => 'Achievement Unlocked!',
            'message' => $achievement,
            'type' => self::TYPE_ACHIEVEMENT,
            'action_text' => 'View Achievements',
        ]);
    }
}