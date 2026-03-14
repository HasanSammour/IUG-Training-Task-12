<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'created_by',
        'content',
        'is_private',
    ];

    protected $casts = [
        'is_private' => 'boolean',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopePublic($query)
    {
        return $query->where('is_private', false);
    }

    public function scopePrivate($query)
    {
        return $query->where('is_private', true);
    }

    public function scopeVisibleTo($query, $userId)
    {
        return $query->where(function($q) use ($userId) {
            $q->where('is_private', false)
              ->orWhere('created_by', $userId);
        });
    }

    // Helpers - FIXED: Add missing accessor methods
    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('M d, Y');
    }

    public function getCreatedAtDiffAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getCreatorNameAttribute()
    {
        return $this->creator->name ?? 'Unknown';
    }

    public function getCreatorInitialsAttribute()
    {
        return $this->creator->initials ?? 'A';
    }

    public function getExcerptAttribute($length = 100)
    {
        return strlen($this->content) > $length 
            ? substr($this->content, 0, $length) . '...' 
            : $this->content;
    }
}