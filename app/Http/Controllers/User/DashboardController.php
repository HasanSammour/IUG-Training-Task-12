<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSession;
use App\Models\CourseAssignment;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Current active enrollment
        $currentEnrollment = $user->enrollments()
            ->where('status', 'active')
            ->with('course')
            ->latest()
            ->first();
            
        // Get upcoming sessions (next 30 days)
        $upcomingSessions = CourseSession::whereIn('course_id', $user->enrollments()->pluck('course_id'))
            ->with('course')
            ->where('start_time', '>=', now())
            ->where('start_time', '<=', now()->addDays(30))
            ->orderBy('start_time')
            ->get();
        
        // Get pending assignments (due in next 30 days)
        $pendingAssignments = collect();
        $enrolledCourseIds = $user->enrollments()->pluck('course_id');
        
        foreach ($enrolledCourseIds as $courseId) {
            $assignments = CourseAssignment::where('course_id', $courseId)
                ->where(function ($q) use ($user) {
                    $q->whereDoesntHave('submissions', function ($sq) use ($user) {
                        $sq->where('user_id', $user->id);
                    })->orWhereHas('submissions', function ($sq) use ($user) {
                        $sq->where('user_id', $user->id)->whereNull('grade');
                    });
                })
                ->whereNotNull('due_date')
                ->where('due_date', '>=', now())
                ->where('due_date', '<=', now()->addDays(30))
                ->with('course')
                ->orderBy('due_date')
                ->get();
            $pendingAssignments = $pendingAssignments->concat($assignments);
        }
        
        // Get today's sessions
        $todaySessions = CourseSession::whereIn('course_id', $enrolledCourseIds)
            ->with('course')
            ->whereDate('start_time', today())
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->get();
            
        // Get overdue assignments
        $overdueAssignments = collect();
        foreach ($enrolledCourseIds as $courseId) {
            $assignments = CourseAssignment::where('course_id', $courseId)
                ->where(function ($q) use ($user) {
                    $q->whereDoesntHave('submissions', function ($sq) use ($user) {
                        $sq->where('user_id', $user->id);
                    })->orWhereHas('submissions', function ($sq) use ($user) {
                        $sq->where('user_id', $user->id)->whereNull('grade');
                    });
                })
                ->whereNotNull('due_date')
                ->where('due_date', '<', now())
                ->with('course')
                ->orderBy('due_date')
                ->get();
            $overdueAssignments = $overdueAssignments->concat($assignments);
        }
            
        // Recommended courses
        $recommendedCourses = $this->getRecommendedCourses($user);
        
        // Learning path
        $learningPath = $user->learningPaths()->first();
        if ($learningPath) {
            $learningPath->remaining_courses = $learningPath->total_courses - $learningPath->completed_courses;
        }
        
        // Unread notifications count
        $unreadNotifications = $user->notifications()
            ->where('is_read', false)
            ->count();
            
        // Recent notifications
        $recentNotifications = $user->notifications()
            ->latest()
            ->take(5)
            ->get();
            
        // Statistics
        $stats = [
            'total_courses' => $user->enrollments()->count(),
            'completed_courses' => $user->enrollments()->where('status', 'completed')->count(),
            'in_progress' => $user->enrollments()->where('status', 'active')->count(),
            'total_progress' => round($user->enrollments()->avg('progress_percentage') ?? 0),
            'current_streak' => $this->calculateStreak($user),
            'upcoming_sessions' => $upcomingSessions->count(),
            'pending_assignments' => $pendingAssignments->count(),
            'overdue_assignments' => $overdueAssignments->count(),
            'today_sessions' => $todaySessions->count(),
        ];
        
        // Prepare calendar events
        $calendarEvents = [];
        
        // Add sessions to calendar
        foreach ($upcomingSessions as $session) {
            $calendarEvents[] = [
                'id' => 'session_' . $session->id,
                'title' => $session->title,
                'start' => $session->start_time->format('Y-m-d\TH:i:s'),
                'end' => $session->end_time ? $session->end_time->format('Y-m-d\TH:i:s') : null,
                'color' => '#3182ce',
                'textColor' => '#ffffff',
                'url' => route('courses.sessions.show', [$session->course_id, $session->id]),
                'description' => $session->description,
                'course' => $session->course->title,
                'type' => 'session'
            ];
        }
        
        // Add assignments to calendar
        foreach ($pendingAssignments as $assignment) {
            $calendarEvents[] = [
                'id' => 'assignment_' . $assignment->id,
                'title' => '📝 ' . $assignment->title,
                'start' => $assignment->due_date->format('Y-m-d'),
                'allDay' => true,
                'color' => '#d97706',
                'textColor' => '#ffffff',
                'url' => route('courses.assignments.show', [$assignment->course_id, $assignment->id]),
                'description' => $assignment->description,
                'course' => $assignment->course->title,
                'type' => 'assignment'
            ];
        }
        
        // Add overdue assignments to calendar
        foreach ($overdueAssignments as $assignment) {
            $calendarEvents[] = [
                'id' => 'overdue_' . $assignment->id,
                'title' => '⚠️ ' . $assignment->title . ' (Overdue)',
                'start' => $assignment->due_date->format('Y-m-d'),
                'allDay' => true,
                'color' => '#dc2626',
                'textColor' => '#ffffff',
                'url' => route('courses.assignments.show', [$assignment->course_id, $assignment->id]),
                'description' => $assignment->description,
                'course' => $assignment->course->title,
                'type' => 'overdue'
            ];
        }

        // Check if this is first login and needs onboarding
        $showOnboarding = session()->pull('show_onboarding', false);
        
        // IMPORTANT: Only set the flag if user needs onboarding AND hasn't completed it
        if ($showOnboarding && $user->hasRole('student') && !$user->onboarding_completed) {
            session(['show_onboarding_dashboard' => true]);
        }
        
        return view('user.dashboard', compact(
            'currentEnrollment',
            'recommendedCourses',
            'learningPath',
            'unreadNotifications',
            'recentNotifications',
            'stats',
            'todaySessions',
            'upcomingSessions',
            'pendingAssignments',
            'overdueAssignments',
            'calendarEvents',
            'showOnboarding'
        ));
    }
    
    private function getRecommendedCourses($user)
    {
        // If user has a learning path, get courses from it
        $learningPath = $user->learningPaths()->first();
        
        if ($learningPath) {
            return $learningPath->items()
                ->with('course')
                ->where('status', 'locked')
                ->take(3)
                ->get()
                ->pluck('course')
                ->filter();
        }
        
        // Otherwise recommend based on categories of enrolled courses
        $enrolledCategories = $user->enrollments()
            ->with('course.category')
            ->get()
            ->pluck('course.category_id')
            ->filter()
            ->unique()
            ->values();
            
        if ($enrolledCategories->isNotEmpty()) {
            return Course::whereIn('category_id', $enrolledCategories)
                ->where('is_active', true)
                ->whereNotIn('id', $user->enrollments()->pluck('course_id'))
                ->inRandomOrder()
                ->take(3)
                ->get();
        }
        
        // Fallback to random featured courses
        return Course::where('is_active', true)
            ->where('is_featured', true)
            ->inRandomOrder()
            ->take(3)
            ->get();
    }
    
    private function calculateStreak($user)
    {
        // Calculate study streak (days in a row with learning activity)
        $enrollments = $user->enrollments()
            ->where('updated_at', '>=', now()->subDays(30))
            ->get();
            
        if ($enrollments->isEmpty()) {
            return 0;
        }
        
        $dates = $enrollments->map(function($enrollment) {
            return $enrollment->updated_at->format('Y-m-d');
        })->unique()->sort()->values();
        
        $streak = 0;
        $currentStreak = 0;
        $lastDate = null;
        
        foreach ($dates as $date) {
            if ($lastDate === null) {
                $currentStreak = 1;
            } elseif ($date === date('Y-m-d', strtotime($lastDate . ' +1 day'))) {
                $currentStreak++;
            } else {
                $currentStreak = 1;
            }
            
            $lastDate = $date;
            $streak = max($streak, $currentStreak);
        }
        
        // Check if streak continues today
        $today = now()->format('Y-m-d');
        if ($lastDate === $today || $lastDate === date('Y-m-d', strtotime('-1 day'))) {
            return $streak;
        }
        
        return 0; // Streak broken
    }
    
    /**
     * API endpoint to get calendar events
     */
    public function getCalendarEvents()
    {
        $user = Auth::user();
        $events = [];
        
        // Get upcoming sessions
        $sessions = CourseSession::whereIn('course_id', $user->enrollments()->pluck('course_id'))
            ->with('course')
            ->where('start_time', '>=', now())
            ->where('start_time', '<=', now()->addDays(60))
            ->get();
            
        foreach ($sessions as $session) {
            $events[] = [
                'id' => $session->id,
                'title' => $session->title,
                'start' => $session->start_time->format('Y-m-d\TH:i:s'),
                'end' => $session->end_time ? $session->end_time->format('Y-m-d\TH:i:s') : null,
                'color' => '#3182ce',
                'url' => route('courses.sessions.show', [$session->course_id, $session->id]),
                'extendedProps' => [
                    'course' => $session->course->title,
                    'type' => 'session'
                ]
            ];
        }
        
        return response()->json($events);
    }
}