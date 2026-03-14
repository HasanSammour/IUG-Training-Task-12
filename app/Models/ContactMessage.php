<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'assigned_to',
        'response',
        'responded_at',
        'response_by',
        'category',
        'priority',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    // الحالات
    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_RESPONDED = 'responded';
    const STATUS_CLOSED = 'closed';
    const STATUS_SPAM = 'spam';

    // الأولويات
    const PRIORITY_LOW = 'low';
    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_URGENT = 'urgent';

    // الفئات
    const CATEGORY_GENERAL = 'general';
    const CATEGORY_COURSE = 'course';
    const CATEGORY_TECHNICAL = 'technical';
    const CATEGORY_BILLING = 'billing';
    const CATEGORY_FEEDBACK = 'feedback';
    const CATEGORY_OTHER = 'other';

    // العلاقات
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'response_by');
    }

    // Scopes
    public function scopeNew($query)
    {
        return $query->where('status', self::STATUS_NEW);
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', self::STATUS_IN_PROGRESS);
    }

    public function scopeResponded($query)
    {
        return $query->where('status', self::STATUS_RESPONDED);
    }

    public function scopeUnresponded($query)
    {
        return $query->where('status', self::STATUS_NEW)
                    ->orWhere('status', self::STATUS_IN_PROGRESS);
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', self::PRIORITY_HIGH)
                    ->orWhere('priority', self::PRIORITY_URGENT);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // دوال مساعدة
    public function getStatusTextAttribute()
    {
        $statuses = [
            self::STATUS_NEW => 'New',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_RESPONDED => 'Responded',
            self::STATUS_CLOSED => 'Closed',
            self::STATUS_SPAM => 'Spam',
        ];

        return $statuses[$this->status] ?? 'Unknown';
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            self::STATUS_NEW => 'blue',
            self::STATUS_IN_PROGRESS => 'yellow',
            self::STATUS_RESPONDED => 'green',
            self::STATUS_CLOSED => 'gray',
            self::STATUS_SPAM => 'red',
        ];

        return $colors[$this->status] ?? 'gray';
    }

    public function getPriorityTextAttribute()
    {
        $priorities = [
            self::PRIORITY_LOW => 'Low',
            self::PRIORITY_NORMAL => 'Normal',
            self::PRIORITY_HIGH => 'High',
            self::PRIORITY_URGENT => 'Urgent',
        ];

        return $priorities[$this->priority] ?? 'Normal';
    }

    public function getPriorityColorAttribute()
    {
        $colors = [
            self::PRIORITY_LOW => 'gray',
            self::PRIORITY_NORMAL => 'blue',
            self::PRIORITY_HIGH => 'yellow',
            self::PRIORITY_URGENT => 'red',
        ];

        return $colors[$this->priority] ?? 'blue';
    }

    public function getCategoryTextAttribute()
    {
        $categories = [
            self::CATEGORY_GENERAL => 'General Inquiry',
            self::CATEGORY_COURSE => 'Course Related',
            self::CATEGORY_TECHNICAL => 'Technical Issue',
            self::CATEGORY_BILLING => 'Billing/Payment',
            self::CATEGORY_FEEDBACK => 'Feedback/Suggestion',
            self::CATEGORY_OTHER => 'Other',
        ];

        return $categories[$this->category] ?? 'General Inquiry';
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getIsUnreadAttribute()
    {
        return $this->status === self::STATUS_NEW;
    }

    public function getIsUrgentAttribute()
    {
        return $this->priority === self::PRIORITY_URGENT;
    }

    public function getMessageExcerptAttribute($length = 150)
    {
        return strlen($this->message) > $length 
            ? substr($this->message, 0, $length) . '...' 
            : $this->message;
    }

    public function assignToUser($userId)
    {
        $this->update([
            'assigned_to' => $userId,
            'status' => self::STATUS_IN_PROGRESS,
        ]);
    }

    public function respond($response, $responderId)
    {
        $this->update([
            'response' => $response,
            'response_by' => $responderId,
            'status' => self::STATUS_RESPONDED,
            'responded_at' => now(),
        ]);
    }

    public function markAsSpam()
    {
        $this->update(['status' => self::STATUS_SPAM]);
    }

    public function reopen()
    {
        $this->update(['status' => self::STATUS_IN_PROGRESS]);
    }

    public function close()
    {
        $this->update(['status' => self::STATUS_CLOSED]);
    }

    public function getResponseTimeAttribute()
    {
        if (!$this->responded_at) return null;
        
        return $this->created_at->diffInHours($this->responded_at);
    }

    public function getResponseTimeTextAttribute()
    {
        if (!$this->response_time) return 'Not responded yet';
        
        if ($this->response_time < 1) {
            return 'Responded in ' . round($this->response_time * 60) . ' minutes';
        } elseif ($this->response_time < 24) {
            return 'Responded in ' . round($this->response_time) . ' hours';
        } else {
            return 'Responded in ' . round($this->response_time / 24) . ' days';
        }
    }

    public static function getStats()
    {
        return [
            'total' => self::count(),
            'new' => self::where('status', self::STATUS_NEW)->count(),
            'in_progress' => self::where('status', self::STATUS_IN_PROGRESS)->count(),
            'responded' => self::where('status', self::STATUS_RESPONDED)->count(),
            'urgent' => self::where('priority', self::PRIORITY_URGENT)->count(),
            'average_response_time' => self::whereNotNull('responded_at')
                ->avg(\DB::raw('TIMESTAMPDIFF(HOUR, created_at, responded_at)')),
        ];
    }
}