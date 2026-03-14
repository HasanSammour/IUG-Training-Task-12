<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\CourseSession;
use App\Models\CourseAssignment;
use App\Models\CourseMaterial;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class CourseProgressController extends Controller
{
    public function show(Enrollment $enrollment)
    {
        // Manual authorization check
        if ($enrollment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this enrollment.');
        }
        // Prevent instructors from accessing student pages
        if (auth()->user()->hasRole('instructor')) {
            abort(403, 'Instructors cannot access student courses.');
        }

        // Block access for pending/cancelled
        if (in_array($enrollment->status, [Enrollment::STATUS_PENDING, Enrollment::STATUS_CANCELLED])) {
            return redirect()->route('courses.my-courses')
                ->with('error', 'This enrollment is ' . $enrollment->status);
        }

        $course = $enrollment->course;
        $user = $enrollment->user;

        // Get all sessions with attendance for this user
        $sessions = CourseSession::where('course_id', $course->id)
            ->with(['attendance' => function($q) use ($user) {
                $q->where('user_id', $user->id);
            }])
            ->orderBy('start_time', 'desc')
            ->get();

        // Get all assignments with submissions for this user
        $assignments = CourseAssignment::where('course_id', $course->id)
            ->with(['submissions' => function($q) use ($user) {
                $q->where('user_id', $user->id);
            }])
            ->orderBy('due_date')
            ->get();

        // Get all materials
        $materials = CourseMaterial::where('course_id', $course->id)
            ->orderBy('order_position')
            ->get();

            // Calculate stats
            $totalSessions = $sessions->count();
            $attendedSessions = $sessions->filter(function($session) use ($user) {
                return $session->attendance->isNotEmpty() && $session->attendance->first()->attended;
            })->count();

            $missedSessions = $totalSessions - $attendedSessions;

            $totalAssignments = $assignments->count();
            $submittedAssignments = $assignments->filter(function($assignment) {
                return $assignment->submissions->isNotEmpty();
            })->count();

            $gradedAssignments = $assignments->filter(function($assignment) {
                return $assignment->submissions->isNotEmpty() && !is_null($assignment->submissions->first()->grade);
            })->count();

            $pendingAssignments = $totalAssignments - $submittedAssignments;

            $totalMaterials = $materials->count();

            $stats = [
                'total_sessions' => $totalSessions,
                'attended_sessions' => $attendedSessions,
                'missed_sessions' => $missedSessions,
                'total_assignments' => $totalAssignments,
                'submitted_assignments' => $submittedAssignments,
                'graded_assignments' => $gradedAssignments,
                'pending_assignments' => $pendingAssignments,
                'total_materials' => $totalMaterials,
            ];

        // Get today's session if any
        $todaySession = CourseSession::where('course_id', $course->id)
            ->whereDate('start_time', today())
            ->where('start_time', '>', now())
            ->where('status', 'scheduled')
            ->first();

        // Get learning path context if exists
        $learningPath = $user->learningPaths()->first();
        $pathItem = null;
        
        if ($learningPath) {
            $pathItem = $learningPath->items()
                ->where('course_id', $course->id)
                ->first();
        }

        // Calculate next milestone
        $nextMilestone = $this->calculateNextMilestone($enrollment->progress_percentage, $stats);

        return view('user.course-progress', compact(
            'enrollment',
            'course',
            'user',
            'sessions',
            'assignments',
            'materials',
            'stats',
            'todaySession',
            'pathItem',
            'nextMilestone'
        ));
    }

    private function calculateNextMilestone($progress, $stats)
    {
        if ($stats['total_sessions'] == 0 && $stats['total_assignments'] == 0) {
            return [
                'description' => 'Wait for instructor to add content',
                'remaining' => 100 - $progress
            ];
        }

        if ($stats['attended_sessions'] == 0 && $stats['total_sessions'] > 0) {
            return [
                'description' => 'Attend your first live session',
                'remaining' => 25 - $progress
            ];
        }

        // FIXED: Use pending_assignments instead of submitted_assignments
        if ($stats['pending_assignments'] == $stats['total_assignments'] && $stats['total_assignments'] > 0) {
            return [
                'description' => 'Submit your first assignment',
                'remaining' => 50 - $progress
            ];
        }

        if ($stats['missed_sessions'] > 2) {
            return [
                'description' => 'Improve your attendance',
                'remaining' => 75 - $progress
            ];
        }

        // FIXED: Use pending_assignments
        if ($stats['pending_assignments'] > 0) {
            return [
                'description' => 'Complete pending assignments',
                'remaining' => 90 - $progress
            ];
        }

        if ($progress < 100) {
            return [
                'description' => 'Complete all requirements',
                'remaining' => 100 - $progress
            ];
        }

        return null;
    }

    public function requestCertificate(Enrollment $enrollment)
    {
        if ($enrollment->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($enrollment->status !== 'completed') {
            return response()->json(['error' => 'Course not completed'], 400);
        }

        // Send notification to instructor
        $course = $enrollment->course;
        $instructor = User::where('name', $course->instructor_name)->first();

        if ($instructor) {
            Notification::create([
                'user_id' => $instructor->id,
                'title' => '🎓 Certificate Request',
                'message' => "Student {$enrollment->user->name} has requested a certificate for course: {$course->title}",
                'type' => 'certificate',
                'data' => [
                    'enrollment_id' => $enrollment->id,
                    'course_id' => $course->id,
                    'student_id' => $enrollment->user_id,
                    'student_name' => $enrollment->user->name
                ],
                'action_url' => route('instructor.student.progress', $enrollment->id),
                'action_text' => 'View Student',
                'is_read' => false
            ]);
        }

        // Store in session to show "Request Sent" status
        session(['certificate_requested_' . $enrollment->id => true]);

        return response()->json([
            'success' => true,
            'message' => 'Certificate request sent to instructor'
        ]);
    }
}