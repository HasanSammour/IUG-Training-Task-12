<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'notes',
        'priority',
        'reminder_date',
    ];

    protected $casts = [
        'priority' => 'integer',
        'reminder_date' => 'date',
    ];

    // أولويات القائمة
    const PRIORITY_LOW = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_HIGH = 3;
    const PRIORITY_URGENT = 4;

    // العلاقات
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', '>=', self::PRIORITY_HIGH);
    }

    public function scopeWithReminders($query)
    {
        return $query->whereNotNull('reminder_date')
                    ->where('reminder_date', '<=', now()->addDays(7));
    }

    public function scopeExpiredReminders($query)
    {
        return $query->whereNotNull('reminder_date')
                    ->where('reminder_date', '<', now());
    }

    public function scopeByPriority($query)
    {
        return $query->orderByDesc('priority')->orderBy('created_at');
    }

    // دوال مساعدة
    public function getPriorityTextAttribute()
    {
        $priorities = [
            self::PRIORITY_LOW => 'Low',
            self::PRIORITY_MEDIUM => 'Medium',
            self::PRIORITY_HIGH => 'High',
            self::PRIORITY_URGENT => 'Urgent',
        ];

        return $priorities[$this->priority] ?? 'Medium';
    }

    public function getPriorityColorAttribute()
    {
        $colors = [
            self::PRIORITY_LOW => 'gray',
            self::PRIORITY_MEDIUM => 'blue',
            self::PRIORITY_HIGH => 'yellow',
            self::PRIORITY_URGENT => 'red',
        ];

        return $colors[$this->priority] ?? 'blue';
    }

    public function getDaysUntilReminderAttribute()
    {
        if (!$this->reminder_date) return null;
        
        return now()->diffInDays($this->reminder_date, false);
    }

    public function getIsReminderDueAttribute()
    {
        if (!$this->reminder_date) return false;
        
        return $this->days_until_reminder <= 0;
    }

    public function getIsReminderSoonAttribute()
    {
        if (!$this->reminder_date) return false;
        
        return $this->days_until_reminder > 0 && $this->days_until_reminder <= 3;
    }

    public function getReminderStatusAttribute()
    {
        if (!$this->reminder_date) return 'none';
        
        if ($this->is_reminder_due) return 'due';
        if ($this->is_reminder_soon) return 'soon';
        
        return 'future';
    }

    public function getNotesExcerptAttribute($length = 100)
    {
        if (!$this->notes) return '';
        
        return strlen($this->notes) > $length 
            ? substr($this->notes, 0, $length) . '...' 
            : $this->notes;
    }

    public function addToWishlist($userId, $courseId, $priority = self::PRIORITY_MEDIUM)
    {
        return self::firstOrCreate(
            [
                'user_id' => $userId,
                'course_id' => $courseId,
            ],
            [
                'priority' => $priority,
                'created_at' => now(),
            ]
        );
    }

    public function removeFromWishlist($userId, $courseId)
    {
        return self::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->delete();
    }

    public function isInWishlist($userId, $courseId)
    {
        return self::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->exists();
    }

    public function getUserWishlist($userId)
    {
        return self::where('user_id', $userId)
            ->with('course')
            ->orderByDesc('priority')
            ->orderBy('created_at')
            ->get();
    }

    public function setReminder($date)
    {
        $this->update(['reminder_date' => $date]);
    }

    public function clearReminder()
    {
        $this->update(['reminder_date' => null]);
    }

    public function updatePriority($priority)
    {
        $this->update(['priority' => $priority]);
    }

    public function moveToEnrollment()
    {
        // إنشاء تسجيل من القائمة
        $enrollment = Enrollment::create([
            'user_id' => $this->user_id,
            'course_id' => $this->course_id,
            'enrollment_id' => 'ENR-' . strtoupper(substr(uniqid(), -8)),
            'amount_paid' => $this->course->final_price,
            'payment_method' => 'pending',
            'status' => 'pending',
            'progress_percentage' => 0,
            'enrolled_at' => now(),
        ]);

        // حذف من القائمة
        $this->delete();

        return $enrollment;
    }
}