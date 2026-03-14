<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'enrollment_id',
        'amount_paid',
        'payment_method',
        'status',
        'progress_percentage',
        'enrolled_at',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'progress_percentage' => 'integer',
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // القيم الثابتة
    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    const PAYMENT_METHODS = [
        'credit_card' => 'Credit Card',
        'paypal' => 'PayPal',
        'bank_transfer' => 'Bank Transfer',
        'manual' => 'Manual',
        'free' => 'Free',
    ];

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
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    public function scopeOfUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeOfCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('enrollment_id', 'like', "%{$search}%")
            ->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhereHas('course', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
    }

    // دوال مساعدة
    public function getPaymentMethodTextAttribute()
    {
        return self::PAYMENT_METHODS[$this->payment_method] ?? $this->payment_method;
    }

    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_ACTIVE => 'bg-green-100 text-green-800',
            self::STATUS_COMPLETED => 'bg-blue-100 text-blue-800',
            self::STATUS_CANCELLED => 'bg-red-100 text-red-800',
        ];

        return $classes[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getProgressColorAttribute()
    {
        if ($this->progress_percentage < 30)
            return 'red';
        if ($this->progress_percentage < 70)
            return 'yellow';
        return 'green';
    }

    public function getIsCompletedAttribute()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function getIsActiveAttribute()
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function getDurationAttribute()
    {
        if (!$this->enrolled_at)
            return null;

        $endDate = $this->completed_at ?? now();
        return $this->enrolled_at->diffInDays($endDate);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'progress_percentage' => 100,
            'completed_at' => now(),
        ]);
    }

    public function updateProgress($progress)
    {
        $progress = max(0, min(100, $progress));

        $this->update([
            'progress_percentage' => $progress,
            'status' => $progress == 100 ? self::STATUS_COMPLETED : self::STATUS_ACTIVE,
            'completed_at' => $progress == 100 ? now() : null,
        ]);
    }
}