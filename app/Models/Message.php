<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Message extends Model
{
    protected $fillable = [
        'sender_id', 
        'receiver_id', 
        'message', 
        'is_read', 
        'read_at', 
        'course_id'
    ];
    
    protected $casts = [
        'is_read' => 'boolean', 
        'read_at' => 'datetime'
    ];
    
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    
    public function scopeUnread($query, $userId)
    {
        return $query->where('receiver_id', $userId)->where('is_read', false);
    }
    
    public function scopeBetweenUsers($query, $user1, $user2)
    {
        return $query->where(function($q) use ($user1, $user2) {
            $q->where('sender_id', $user1)->where('receiver_id', $user2)
              ->orWhere('sender_id', $user2)->where('receiver_id', $user1);
        });
    }
}