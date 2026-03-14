<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'phone',
        'avatar',
        'bio',
        'company',
        'job_title',
        'settings',
        'onboarding_completed',
        'onboarding_shown_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'settings' => 'array',
            'onboarding_completed' => 'boolean',
            'onboarding_shown_at' => 'datetime',
        ];
    }

    // Relationships
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function learningPaths()
    {
        return $this->hasMany(LearningPath::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function reviews()
    {
        return $this->hasMany(CourseReview::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function notes()
    {
        return $this->hasMany(StudentNote::class, 'user_id')->latest();
    }

    public function createdNotes()
    {
        return $this->hasMany(StudentNote::class, 'created_by')->latest();
    }

    // Helper methods
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar && file_exists(public_path('storage/' . $this->avatar))) {
            return asset('storage/' . $this->avatar);
        }

        // Generate avatar from initials using UI Avatars service
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=fff&background=2d3e50&size=200';
    }

    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        $initials = '';

        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }

        return substr($initials, 0, 2);
    }

    public function getTotalSpentAttribute()
    {
        return $this->enrollments()->sum('amount_paid');
    }

    public function getCompletedCoursesCountAttribute()
    {
        return $this->enrollments()->where('status', 'completed')->count();
    }

    public function getActiveCoursesAttribute()
    {
        return $this->enrollments()
            ->where('status', 'active')
            ->with('course')
            ->get();
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%");
    }

    public function getNotesCountAttribute()
    {
        return $this->notes()->count();
    }

    public function getRecentNotesAttribute($limit = 5)
    {
        return $this->notes()
            ->with('creator')
            ->visibleTo(auth()->id())
            ->latest()
            ->take($limit)
            ->get();
    }

    /**
     * Check if user needs to see onboarding.
     */
    public function needsOnboarding(): bool
    {
        // Only students need onboarding
        if (!$this->hasRole('student')) {
            return false;
        }
        
        // If already completed, no need
        if ($this->onboarding_completed) {
            return false;
        }
        
        // New users (created within last 7 days) need onboarding
        if ($this->created_at->gt(now()->subDays(7))) {
            return true;
        }
        
        // Users with no learning path need onboarding
        if (!$this->learningPaths()->exists()) {
            return true;
        }
        
        return false;
    }

    /**
     * Mark onboarding as completed.
     */
    public function completeOnboarding(): void
    {
        $this->update([
            'onboarding_completed' => true,
            'onboarding_shown_at' => now(),
        ]);
    }
}