<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LearningPath;
use App\Models\LearningPathItem;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CourseSession;
use App\Models\SessionAttendance;
use App\Models\CourseMaterial;
use App\Models\CourseAssignment;
use App\Models\AssignmentSubmission;

class LearningPathController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        // Get learning path with items
        $learningPath = $user->learningPaths()
            ->with(['items.course' => function($query) {
                $query->with('category');
            }])
            ->latest()
            ->first();
    
        $items = collect();
        if ($learningPath) {
            $items = $learningPath->items()
                ->with(['course.category', 'course.sessions'])
                ->orderBy('position')
                ->get()
                ->map(function ($item) use ($user) {
                    $item->enrollment = $user->enrollments()
                        ->where('course_id', $item->course_id)
                        ->first();
                    return $item;
                });
        }
    
        // Get enrolled course IDs
        $enrolledCourseIds = $user->enrollments()->pluck('course_id');
    
        // TODAY'S SESSIONS
        $todaySessions = CourseSession::whereIn('course_id', $enrolledCourseIds)
            ->with('course')
            ->whereDate('start_time', today())
            ->where('start_time', '>', now())
            ->where('status', 'scheduled')
            ->orderBy('start_time')
            ->get();
    
        // UPCOMING SESSIONS (for stats)
        $upcomingSessions = CourseSession::whereIn('course_id', $enrolledCourseIds)
            ->where('start_time', '>', now())
            ->where('status', 'scheduled')
            ->count();
    
        // PENDING ASSIGNMENTS
        $pendingAssignments = collect();
        foreach ($enrolledCourseIds as $courseId) {
            $assignments = CourseAssignment::where('course_id', $courseId)
                ->where(function ($q) use ($user) {
                    $q->whereDoesntHave('submissions', function ($sq) use ($user) {
                        $sq->where('user_id', $user->id);
                    })->orWhereHas('submissions', function ($sq) use ($user) {
                        $sq->where('user_id', $user->id)->whereNull('grade');
                    });
                })
                ->with('course')
                ->orderBy('due_date')
                ->get();
            $pendingAssignments = $pendingAssignments->concat($assignments);
        }
    
        // RECENT MATERIALS (last 7 days)
        $recentMaterials = CourseMaterial::whereIn('course_id', $enrolledCourseIds)
            ->with('course')
            ->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
    
        // PRIORITY ITEMS (what needs attention)
        $priorityItems = collect();
    
        // Add today's sessions
        foreach ($todaySessions as $session) {
            $priorityItems->push([
                'type' => 'session',
                'id' => $session->id,
                'course_id' => $session->course_id,
                'course_title' => $session->course->title,
                'title' => $session->title,
                'start_time' => $session->start_time,
                'meeting_url' => $session->meeting_url,
                'priority' => 1
            ]);
        }
    
        // Add urgent assignments (due in next 2 days)
        foreach ($pendingAssignments as $assignment) {
            if ($assignment->due_date && $assignment->due_date < now()->addDays(2)) {
                $priorityItems->push([
                    'type' => 'assignment',
                    'id' => $assignment->id,
                    'course_id' => $assignment->course_id,
                    'course_title' => $assignment->course->title,
                    'title' => $assignment->title,
                    'due_date' => $assignment->due_date,
                    'points' => $assignment->points,
                    'is_urgent' => $assignment->due_date < now()->addDay(),
                    'priority' => 2
                ]);
            }
        }
    
        // Sort by priority
        $priorityItems = $priorityItems->sortBy('priority')->values();
    
        // Get recommended courses
        $enrolledCourseIdsArray = $user->enrollments()->pluck('course_id')->toArray();
        $recommendedCourses = Course::where('is_active', true)
            ->whereNotIn('id', $enrolledCourseIdsArray)
            ->inRandomOrder()
            ->limit(4)
            ->get();
    
        // Calculate stats
        $enrollments = $user->enrollments()->with('course')->get();
    
        $stats = [
            'total_courses' => $enrollments->count(),
            'completed_courses' => $enrollments->where('status', 'completed')->count(),
            'in_progress' => $enrollments->where('status', 'active')->count(),
            'pending_assignments' => $pendingAssignments->count(),
            'upcoming_sessions' => $upcomingSessions,
            'total_hours' => $enrollments->sum(function ($e) {
                $duration = $e->course ? preg_replace('/[^0-9]/', '', $e->course->duration) : 0;
                return intval($duration) ?: 0;
            }),
        ];
    
        // Get recent activities
        $recentActivities = $this->getRecentActivities($user);
    
        return view('user.learning-path.index', compact(
            'learningPath',
            'items',
            'todaySessions',
            'pendingAssignments',
            'recentMaterials',
            'priorityItems',
            'recommendedCourses',
            'stats',
            'recentActivities'
        ));
    }

    public function show(LearningPath $learningPath)
    {
        $user = Auth::user();
        
        // Ensure the learning path belongs to the authenticated user
        if ($learningPath->user_id !== $user->id) {
            abort(403, 'Unauthorized access to this learning path.');
        }
    
        $items = $learningPath->items()
            ->with('course.category')
            ->orderBy('position')
            ->get()
            ->map(function($item) use ($user) {
                $item->enrollment = $user->enrollments()
                    ->where('course_id', $item->course_id)
                    ->first();
                return $item;
            });
    
        // Decode goals from JSON to array
        $learningPath->goals = json_decode($learningPath->goals, true) ?? [];
    
        return view('user.learning-path.show', compact('learningPath', 'items'));
    }
    
    public function destroy(LearningPath $learningPath)
    {
        $user = Auth::user();
        
        if ($learningPath->user_id !== $user->id) {
            abort(403, 'Unauthorized access to this learning path.');
        }
        
        $learningPath->delete();
    
        return redirect()->route('learning-path.index')
            ->with('success', 'Learning path deleted successfully.');
    }

    private function getNewMaterialsCount($user, $courseIds)
    {
        // You can implement this based on last viewed tracking
        return CourseMaterial::whereIn('course_id', $courseIds)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
    }

    private function getRecentActivities($user)
    {
        $activities = collect();

        // Course progress updates
        $enrollments = $user->enrollments()
            ->with('course')
            ->whereIn('status', ['active', 'completed'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        foreach ($enrollments as $enrollment) {
            $activities->push([
                'type' => 'progress',
                'title' => $enrollment->status === 'completed' ? 'Completed course' : 'Continued learning',
                'description' => $enrollment->course->title,
                'time' => $enrollment->updated_at,
                'icon' => $enrollment->status === 'completed' ? 'fa-check-circle' : 'fa-play-circle',
                'color' => $enrollment->status === 'completed' ? 'green' : 'blue',
                'link' => route('courses.progress', $enrollment->id)
            ]);
        }

        // Session attendance
        $attendance = SessionAttendance::where('user_id', $user->id)
            ->with('session.course')
            ->latest('created_at')
            ->take(5)
            ->get();

        foreach ($attendance as $record) {
            $activities->push([
                'type' => 'attendance',
                'title' => 'Attended live session',
                'description' => $record->session->title . ' - ' . $record->session->course->title,
                'time' => $record->session->start_time,
                'icon' => 'fa-video',
                'color' => 'purple',
                'link' => route('courses.sessions.show', [$record->session->course_id, $record->session->id])
            ]);
        }

        // Assignment submissions
        $submissions = AssignmentSubmission::where('user_id', $user->id)
            ->with('assignment.course')
            ->latest('submitted_at')
            ->take(5)
            ->get();

        foreach ($submissions as $submission) {
            $activities->push([
                'type' => 'assignment',
                'title' => $submission->grade ? 'Assignment graded' : 'Assignment submitted',
                'description' => $submission->assignment->title . ' - ' . $submission->assignment->course->title,
                'time' => $submission->submitted_at,
                'icon' => 'fa-tasks',
                'color' => $submission->grade ? 'green' : 'yellow',
                'link' => route('courses.assignments.show', [$submission->assignment->course_id, $submission->assignment->id])
            ]);
        }

        return $activities->sortByDesc('time')->take(10);
    }

    public function generate(Request $request)
    {
        $user = Auth::user();

        DB::beginTransaction();

        try {
            // Delete old learning path
            $user->learningPaths()->delete();

            // Get user's enrolled courses to avoid recommending already enrolled ones
            $enrolledCourseIds = $user->enrollments()->pluck('course_id')->toArray();

            // Get courses for new path (prioritize ones with sessions/materials)
            $courses = Course::where('is_active', true)
                ->whereNotIn('id', $enrolledCourseIds)
                ->withCount('sessions')
                ->withCount('materials')
                ->withCount('assignments')
                ->orderByDesc('sessions_count')
                ->orderByDesc('materials_count')
                ->orderByDesc('assignments_count')
                ->inRandomOrder()
                ->take(5)
                ->get();

            // If not enough courses, get any active courses
            if ($courses->count() < 3) {
                $courses = Course::where('is_active', true)
                    ->whereNotIn('id', $enrolledCourseIds)
                    ->inRandomOrder()
                    ->take(5)
                    ->get();
            }

            // Calculate total weeks
            $totalWeeks = $courses->sum(function ($course) {
                return intval(preg_replace('/[^0-9]/', '', $course->duration)) ?: 4;
            });

            // Create new learning path
            $learningPath = LearningPath::create([
                'user_id' => $user->id,
                'title' => 'My Personalized Learning Journey',
                'description' => 'AI-generated learning path based on your interests and goals.',
                'total_courses' => $courses->count(),
                'completed_courses' => 0,
                'total_weeks' => $totalWeeks,
                'progress_percentage' => 0,
                'next_milestone' => 'Start with: ' . ($courses->first()->title ?? 'Beginner courses'),
                'is_ai_generated' => true,
                'goals' => json_encode([
                    'Complete ' . $courses->count() . ' courses',
                    'Attend live sessions',
                    'Submit assignments on time',
                    'Earn certificates',
                ]),
            ]);

            // Create learning path items
            foreach ($courses as $index => $course) {
                LearningPathItem::create([
                    'learning_path_id' => $learningPath->id,
                    'course_id' => $course->id,
                    'position' => $index + 1,
                    'status' => $index === 0 ? 'active' : 'locked',
                    'progress' => 0,
                    'estimated_hours' => intval(preg_replace('/[^0-9]/', '', $course->duration)) ?: 10,
                ]);
            }

            DB::commit();

            return redirect()->route('learning-path.index')
                ->with('success', 'New AI-powered learning path generated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Learning path generation error: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate learning path. Please try again.');
        }
    }

    public function upcomingSessions()
    {
        $user = Auth::user();

        $sessions = CourseSession::whereIn('course_id', $user->enrollments()->pluck('course_id'))
            ->with('course')
            ->where('start_time', '>', now())
            ->where('status', 'scheduled')
            ->orderBy('start_time')
            ->paginate(20);

        return view('user.sessions.upcoming', compact('sessions'));
    }

    public function pastSessions()
    {
        $user = Auth::user();

        $sessions = CourseSession::whereIn('course_id', $user->enrollments()->pluck('course_id'))
            ->with(['course', 'attendance' => function($q) use ($user) {
                $q->where('user_id', $user->id);
            }])
            ->where('start_time', '<', now())
            ->where('status', 'completed')
            ->orderByDesc('start_time')
            ->paginate(20);

        return view('user.sessions.past', compact('sessions'));
    }

    public function setReminder(Request $request, CourseSession $session)
    {
        $user = Auth::user();

        // Check if enrolled in the course
        $enrolled = $user->enrollments()
            ->where('course_id', $session->course_id)
            ->exists();

        if (!$enrolled) {
            return response()->json(['error' => 'Not enrolled in this course'], 403);
        }

        // Store reminder in session or database
        session()->push('session_reminders', $session->id);

        return response()->json(['success' => true, 'message' => 'Reminder set successfully']);
    }

    public function startCourse(Course $course)
    {
        $user = Auth::user();
    
        // Check if already enrolled
        $existingEnrollment = $user->enrollments()->where('course_id', $course->id)->first();
    
        if ($existingEnrollment) {
            return redirect()->route('courses.progress', $existingEnrollment->id)
                ->with('info', 'You are already enrolled in this course.');
        }
    
        // Redirect to registration page instead of direct enrollment
        return redirect()->route('courses.registration', ['course' => $course->slug])
            ->with('info', 'Please complete registration to start this course.');
    }

    public function completeItem(LearningPathItem $item)
    {
        $this->authorize('update', $item);

        $user = Auth::user();
        $enrollment = $user->enrollments()
            ->where('course_id', $item->course_id)
            ->first();

        if (!$enrollment || $enrollment->progress_percentage < 100) {
            return response()->json([
                'success' => false,
                'message' => 'Course must be completed before marking as done.'
            ], 400);
        }

        DB::beginTransaction();

        try {
            $item->update([
                'status' => 'completed',
                'progress' => 100,
            ]);

            // Update learning path progress
            $learningPath = $item->learningPath;
            $completedCount = $learningPath->items()->where('status', 'completed')->count();
            $totalItems = $learningPath->items()->count();

            $progress = $totalItems > 0 ? round(($completedCount / $totalItems) * 100) : 0;

            // Find next item to unlock
            $nextItem = $learningPath->items()
                ->where('status', 'locked')
                ->orderBy('position')
                ->first();

            if ($nextItem) {
                $nextItem->update(['status' => 'active']);
            }

            $learningPath->update([
                'completed_courses' => $completedCount,
                'progress_percentage' => $progress,
                'next_milestone' => $nextItem ? 'Next: ' . ($nextItem->course->title ?? 'Continue learning') : 'All courses completed!',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Course completed! Great job!',
                'progress' => $progress,
                'next_unlocked' => $nextItem ? true : false,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Complete item error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to complete course. Please try again.'
            ], 500);
        }
    }

    public function getProgress()
    {
        $user = Auth::user();

        $enrollments = $user->enrollments()
            ->with('course')
            ->get()
            ->map(function ($e) {
                return [
                    'id' => $e->id,
                    'course_id' => $e->course_id,
                    'course_title' => $e->course->title,
                    'progress' => $e->progress_percentage,
                    'status' => $e->status,
                    'enrolled_at' => $e->enrolled_at->format('Y-m-d'),
                    'completed_at' => $e->completed_at?->format('Y-m-d'),
                    'course_image' => $e->course->image_url,
                ];
            });

        $learningPath = $user->learningPaths()->with('items')->first();

        return response()->json([
            'enrollments' => $enrollments,
            'learning_path' => $learningPath ? [
                'id' => $learningPath->id,
                'progress' => $learningPath->progress_percentage,
                'total_courses' => $learningPath->total_courses,
                'completed_courses' => $learningPath->completed_courses,
            ] : null,
        ]);
    }

    public function getSuggestions()
    {
        $user = Auth::user();
        $enrolledCourseIds = $user->enrollments()->pluck('course_id')->toArray();

        $recommendedCourses = Course::where('is_active', true)
            ->whereNotIn('id', $enrolledCourseIds)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return response()->json([
            'recommended' => $recommendedCourses->map(function ($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'slug' => $course->slug,
                    'level' => $course->level,
                    'duration' => $course->duration,
                    'image' => $course->image_url,
                    'price' => $course->formatted_price,
                    'category' => $course->category?->name,
                ];
            }),
        ]);
    }

    private function getAISuggestion($user)
    {
        $enrollments = $user->enrollments()->with('course')->get();

        if ($enrollments->isEmpty()) {
            $recommendedCourse = Course::where('is_active', true)
                ->where('level', 'beginner')
                ->inRandomOrder()
                ->first();

            return [
                'title' => '🚀 Start Your Learning Journey',
                'message' => 'Begin with this beginner-friendly course to build a strong foundation.',
                'recommended_course' => $recommendedCourse,
            ];
        }

        $completedCourses = $enrollments->where('status', 'completed');

        if ($completedCourses->count() > 0) {
            // Suggest next level course
            $lastCompleted = $completedCourses->last();
            $nextLevel = $lastCompleted->course->level === 'beginner' ? 'intermediate' : 'advanced';

            $recommendedCourse = Course::where('is_active', true)
                ->where('level', $nextLevel)
                ->where('category_id', $lastCompleted->course->category_id)
                ->inRandomOrder()
                ->first();

            if ($recommendedCourse) {
                return [
                    'title' => '📈 Level Up Your Skills',
                    'message' => "You've mastered {$lastCompleted->course->level} level. Ready for the next challenge?",
                    'recommended_course' => $recommendedCourse,
                ];
            }
        }

        // Default suggestion
        $recommendedCourse = Course::where('is_active', true)
            ->inRandomOrder()
            ->first();

        return [
            'title' => '🎯 Continue Your Journey',
            'message' => 'Keep learning with this recommended course based on your interests.',
            'recommended_course' => $recommendedCourse,
        ];
    }
}