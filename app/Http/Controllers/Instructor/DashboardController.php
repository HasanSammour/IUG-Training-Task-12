<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\CourseSession;
use App\Models\CourseAssignment;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $instructor = Auth::user();

        // Get instructor's courses by name
        $courses = Course::where('instructor_name', $instructor->name)
            ->withCount('enrollments')
            ->with('category')
            ->get();

        $courseIds = $courses->pluck('id');

        // Total stats
        $totalEnrollments = Enrollment::whereIn('course_id', $courseIds)->count();
        $totalRevenue = Enrollment::whereIn('course_id', $courseIds)->sum('amount_paid');
        $averageRating = round($courses->avg('rating') ?? 0, 1);

        // Get upcoming sessions (next 30 days)
        $upcomingSessions = CourseSession::whereIn('course_id', $courseIds)
            ->with('course')
            ->where('start_time', '>=', now())
            ->where('start_time', '<=', now()->addDays(30))
            ->orderBy('start_time')
            ->get();

        // Get pending assignments (next 30 days)
        $pendingAssignments = CourseAssignment::whereIn('course_id', $courseIds)
            ->where('due_date', '>=', now())
            ->where('due_date', '<=', now()->addDays(30))
            ->with('course')
            ->orderBy('due_date')
            ->get();

        // Get overdue assignments
        $overdueAssignments = CourseAssignment::whereIn('course_id', $courseIds)
            ->where('due_date', '<', now())
            ->with('course')
            ->orderBy('due_date')
            ->get();

        // Get today's sessions
        $todaySessions = CourseSession::whereIn('course_id', $courseIds)
            ->with('course')
            ->whereDate('start_time', today())
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->get();

        // Get recent enrollments with user and course info (last 7 days)
        $recentEnrollments = Enrollment::whereIn('course_id', $courseIds)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->with(['user', 'course'])
            ->latest()
            ->take(5)
            ->get();

        // Get unique recent students
        $recentStudents = $recentEnrollments->map(function ($enrollment) {
            return [
                'user' => $enrollment->user,
                'course' => $enrollment->course,
                'enrolled_at' => $enrollment->created_at
            ];
        })->unique('user.id')->take(4);

        // Course stats with completion rates
        $courseStats = $courses->map(function ($course) {
            $enrollments = $course->enrollments()->count();
            $completed = $course->enrollments()->where('status', 'completed')->count();
            $active = $course->enrollments()->where('status', 'active')->count();

            return [
                'course' => $course,
                'total_enrollments' => $enrollments,
                'completion_rate' => $enrollments > 0 ? round(($completed / $enrollments) * 100) : 0,
                'active_students' => $active,
                'revenue' => $course->enrollments()->sum('amount_paid')
            ];
        });

        // Get notifications
        $recentNotifications = Notification::where('user_id', $instructor->id)
            ->latest()
            ->take(5)
            ->get();

        $unreadNotifications = Notification::where('user_id', $instructor->id)
            ->where('is_read', false)
            ->count();

        // Enrollment trends (last 30 days)
        $enrollmentTrends = [];
        $revenueTrends = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $enrollments = Enrollment::whereIn('course_id', $courseIds)
                ->whereDate('created_at', $date)
                ->get();

            $enrollmentTrends[] = [
                'date' => Carbon::parse($date)->format('M d'),
                'count' => $enrollments->count()
            ];

            $revenueTrends[] = [
                'date' => Carbon::parse($date)->format('M d'),
                'amount' => $enrollments->sum('amount_paid')
            ];
        }

        // Top performing courses
        $topCourses = $courses->sortByDesc('enrollments_count')->take(3);

        // Prepare stats for view
        $stats = [
            'total_courses' => $courses->count(),
            'total_students' => $totalEnrollments,
            'avg_rating' => $averageRating,
            'total_revenue' => $totalRevenue,
            'active_courses' => $courses->where('is_active', true)->count(),
            'completion_rate' => round($courseStats->avg('completion_rate') ?? 0),
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
                'extendedProps' => [
                    'type' => 'session',
                    'course_id' => $session->course_id,
                    'session_id' => $session->id,
                    'course_title' => $session->course->title,
                    'description' => $session->description,
                    'meeting_url' => $session->meeting_url,
                    'recording_url' => $session->recording_url,
                    'status' => $session->status,
                    'editable' => true
                ]
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
                'url' => route('instructor.course.assignments.edit', [$assignment->course_id, $assignment->id]),
                'extendedProps' => [
                    'type' => 'assignment',
                    'course_id' => $assignment->course_id,
                    'assignment_id' => $assignment->id,
                    'course_title' => $assignment->course->title,
                    'points' => $assignment->points,
                    'editable' => true
                ]
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
                'url' => route('instructor.course.assignments.edit', [$assignment->course_id, $assignment->id]),
                'extendedProps' => [
                    'type' => 'overdue',
                    'course_id' => $assignment->course_id,
                    'assignment_id' => $assignment->id,
                    'course_title' => $assignment->course->title,
                    'editable' => true
                ]
            ];
        }

        return view('instructor.dashboard', compact(
            'courses',
            'stats',
            'recentEnrollments',
            'recentStudents',
            'recentNotifications',
            'unreadNotifications',
            'courseStats',
            'enrollmentTrends',
            'revenueTrends',
            'topCourses',
            'upcomingSessions',
            'pendingAssignments',
            'overdueAssignments',
            'todaySessions',
            'calendarEvents'
        ));
    }

    /**
     * API endpoint to update session date/time via calendar drag & drop
     */
    public function updateSessionDate(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:course_sessions,id',
            'new_start' => 'required|date',
            'new_end' => 'nullable|date|after:new_start'
        ]);

        $session = CourseSession::findOrFail($request->session_id);
        $course = $session->course;

        // Verify instructor owns this course
        if ($course->instructor_name !== Auth::user()->name) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $oldStart = $session->start_time;
        $session->start_time = Carbon::parse($request->new_start);
        
        if ($request->new_end) {
            $session->end_time = Carbon::parse($request->new_end);
        }

        $session->save();

        // Notify students about the change
        $enrollments = $course->enrollments()->with('user')->get();
        foreach ($enrollments as $enrollment) {
            Notification::create([
                'user_id' => $enrollment->user->id,
                'title' => '🔔 Session Rescheduled: ' . $session->title,
                'message' => "The session has been moved from " . $oldStart->format('M d, h:i A') . " to " . $session->start_time->format('M d, h:i A'),
                'type' => 'session',
                'data' => [
                    'session_id' => $session->id,
                    'course_id' => $course->id,
                    'old_start' => $oldStart,
                    'new_start' => $session->start_time
                ],
                'action_url' => route('courses.sessions.show', [$course->id, $session->id]),
                'action_text' => 'View Session',
                'is_read' => false
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Session updated successfully',
            'new_start' => $session->start_time->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * API endpoint to update assignment due date via calendar drag & drop
     */
    public function updateAssignmentDate(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:course_assignments,id',
            'new_date' => 'required|date'
        ]);

        $assignment = CourseAssignment::findOrFail($request->assignment_id);
        $course = $assignment->course;

        // Verify instructor owns this course
        if ($course->instructor_name !== Auth::user()->name) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $oldDate = $assignment->due_date;
        $assignment->due_date = Carbon::parse($request->new_date);
        $assignment->save();

        // Notify students about the change
        $enrollments = $course->enrollments()->with('user')->get();
        foreach ($enrollments as $enrollment) {
            Notification::create([
                'user_id' => $enrollment->user->id,
                'title' => '📝 Assignment Due Date Changed: ' . $assignment->title,
                'message' => "The due date has been changed from " . ($oldDate ? $oldDate->format('M d, Y') : 'No date') . " to " . $assignment->due_date->format('M d, Y'),
                'type' => 'assignment',
                'data' => [
                    'assignment_id' => $assignment->id,
                    'course_id' => $course->id,
                    'old_date' => $oldDate,
                    'new_date' => $assignment->due_date
                ],
                'action_url' => route('courses.assignments.show', [$course->id, $assignment->id]),
                'action_text' => 'View Assignment',
                'is_read' => false
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Assignment updated successfully',
            'new_date' => $assignment->due_date->format('Y-m-d')
        ]);
    }

    /**
     * API endpoint to get calendar events
     */
    public function getCalendarEvents()
    {
        $instructor = Auth::user();
        $courseIds = Course::where('instructor_name', $instructor->name)->pluck('id');
        
        $events = [];

        // Get sessions
        $sessions = CourseSession::whereIn('course_id', $courseIds)
            ->with('course')
            ->where('start_time', '>=', now()->subDays(30))
            ->where('start_time', '<=', now()->addDays(60))
            ->get();

        foreach ($sessions as $session) {
            $events[] = [
                'id' => 'session_' . $session->id,
                'title' => $session->title,
                'start' => $session->start_time->format('Y-m-d\TH:i:s'),
                'end' => $session->end_time ? $session->end_time->format('Y-m-d\TH:i:s') : null,
                'color' => '#3182ce',
                'url' => route('instructor.course.sessions.edit', [$session->course_id, $session->id]),
                'extendedProps' => [
                    'type' => 'session',
                    'course' => $session->course->title,
                    'editable' => true
                ]
            ];
        }

        // Get assignments
        $assignments = CourseAssignment::whereIn('course_id', $courseIds)
            ->with('course')
            ->where('due_date', '>=', now()->subDays(30))
            ->where('due_date', '<=', now()->addDays(60))
            ->get();

        foreach ($assignments as $assignment) {
            $color = $assignment->due_date < now() ? '#dc2626' : '#d97706';
            $events[] = [
                'id' => 'assignment_' . $assignment->id,
                'title' => ($assignment->due_date < now() ? '⚠️ ' : '📝 ') . $assignment->title,
                'start' => $assignment->due_date->format('Y-m-d'),
                'allDay' => true,
                'color' => $color,
                'url' => route('instructor.course.assignments.edit', [$assignment->course_id, $assignment->id]),
                'extendedProps' => [
                    'type' => 'assignment',
                    'course' => $assignment->course->title,
                    'points' => $assignment->points,
                    'editable' => true
                ]
            ];
        }

        return response()->json($events);
    }
}