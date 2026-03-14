<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\CourseSession;
use App\Models\CourseAssignment;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured courses
        $featuredCourses = Course::where('is_featured', true)
            ->where('is_active', true)
            ->take(3)
            ->get();
        
        // Base statistics
        $stats = [
            'total_courses' => Course::where('is_active', true)->count(),
            'total_students' => User::role('student')->count(),
            'success_rate' => 95,
            'instructors' => User::role('instructor')->count(),
        ];

        // Auth user specific data
        $userData = null;
        $recentActivity = null;
        $upcomingEvents = null;
        $unreadMessages = 0;
        $pendingTasks = 0;

        if (Auth::check()) {
            $user = Auth::user();
            
            if ($user->hasRole('admin')) {
                // Admin stats
                $userData = [
                    'total_courses' => Course::count(),
                    'active_courses' => Course::where('is_active', true)->count(),
                    'total_students' => User::role('student')->count(),
                    'total_instructors' => User::role('instructor')->count(),
                    'pending_enrollments' => Enrollment::where('status', 'pending')->count(),
                    'total_revenue' => Enrollment::sum('amount_paid') ?? 0,
                ];
                
                $pendingTasks = Enrollment::where('status', 'pending')->count();
                
            } elseif ($user->hasRole('instructor')) {
                // Instructor stats
                $courseIds = Course::where('instructor_name', $user->name)->pluck('id');
                
                $userData = [
                    'my_courses' => $courseIds->count(),
                    'active_courses' => Course::whereIn('id', $courseIds)->where('is_active', true)->count(),
                    'total_students' => Enrollment::whereIn('course_id', $courseIds)->where('status', 'active')->count(),
                    'pending_assignments' => CourseAssignment::whereIn('course_id', $courseIds)
                        ->whereHas('submissions', function($q) {
                            $q->whereNull('grade');
                        })->count(),
                ];
                
                $pendingTasks = $userData['pending_assignments'];
                
                // Upcoming sessions for instructor
                $upcomingEvents = CourseSession::whereIn('course_id', $courseIds)
                    ->where('start_time', '>', now())
                    ->where('status', 'scheduled')
                    ->orderBy('start_time')
                    ->take(3)
                    ->get();
                    
            } else {
                // Student stats
                $enrollments = $user->enrollments();
                
                $userData = [
                    'enrolled_courses' => $enrollments->count(),
                    'completed_courses' => $enrollments->where('status', 'completed')->count(),
                    'learning_hours' => $enrollments->with('course')->get()->sum(function($e) {
                        return intval(preg_replace('/[^0-9]/', '', $e->course->duration ?? '0')) ?: 0;
                    }),
                    'current_streak' => $this->calculateStreak($user),
                    'pending_assignments' => $this->getPendingAssignmentsCount($user),
                    'upcoming_sessions' => $this->getUpcomingSessionsCount($user),
                ];
                
                $pendingTasks = $userData['pending_assignments'];
                
                // Upcoming sessions for student
                $upcomingEvents = CourseSession::whereIn('course_id', $user->enrollments()->pluck('course_id'))
                    ->where('start_time', '>', now())
                    ->where('status', 'scheduled')
                    ->orderBy('start_time')
                    ->take(3)
                    ->get();
            }

            // Common data for all authenticated users
            $unreadMessages = Message::where('receiver_id', $user->id)
                ->where('is_read', false)
                ->count();
                
            $recentActivity = [
                'last_login' => $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Today',
                'unread_messages' => $unreadMessages,
                'upcoming_events' => $upcomingEvents && $upcomingEvents->count() > 0 ? $upcomingEvents->count() . ' upcoming' : 'No events',
                'pending_tasks' => $pendingTasks,
            ];
        }

        return view('public.index', compact(
            'featuredCourses', 
            'stats',
            'userData',
            'recentActivity',
            'upcomingEvents'
        ));
    }

    private function calculateStreak($user)
    {
        // Calculate study streak based on activity
        $enrollments = $user->enrollments()
            ->where('updated_at', '>=', now()->subDays(30))
            ->get();
            
        if ($enrollments->isEmpty()) {
            return 0;
        }
        
        $dates = $enrollments->map(function($e) {
            return $e->updated_at->format('Y-m-d');
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
        
        return $streak;
    }

    private function getPendingAssignmentsCount($user)
    {
        $courseIds = $user->enrollments()->pluck('course_id');
        
        return CourseAssignment::whereIn('course_id', $courseIds)
            ->whereDoesntHave('submissions', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->count();
    }

    private function getUpcomingSessionsCount($user)
    {
        return CourseSession::whereIn('course_id', $user->enrollments()->pluck('course_id'))
            ->where('start_time', '>', now())
            ->where('status', 'scheduled')
            ->count();
    }
}