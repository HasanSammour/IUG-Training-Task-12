<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSession;
use App\Models\SessionAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index(Course $course)
    {
        $user = Auth::user();
        
        // Check if enrolled
        $enrollment = $user->enrollments()->where('course_id', $course->id)->first();
        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course');
        }

        $sessions = $course->sessions()
            ->with(['attendance' => function($q) use ($user) {
                $q->where('user_id', $user->id);
            }])
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        $stats = [
            'total' => $sessions->total(),
            'upcoming' => $course->sessions()
                ->where('start_time', '>', now())
                ->where('status', 'scheduled')
                ->count(),
            'attended' => $course->sessions()
                ->whereHas('attendance', function($q) use ($user) {
                    $q->where('user_id', $user->id)->where('attended', true);
                })->count(),
        ];

        return view('user.sessions.index', compact('course', 'sessions', 'stats'));
    }

    public function show(Course $course, CourseSession $session)
    {
        $user = Auth::user();
        
        // Check if enrolled
        $enrollment = $user->enrollments()->where('course_id', $course->id)->first();
        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course');
        }

        $attendance = SessionAttendance::where('course_session_id', $session->id)
            ->where('user_id', $user->id)
            ->first();

        $isUpcoming = $session->start_time > now();
        $canJoin = $isUpcoming && $session->meeting_url && $session->status == 'scheduled';

        return view('user.sessions.show', compact('course', 'session', 'attendance', 'isUpcoming', 'canJoin'));
    }

    public function join(Course $course, CourseSession $session)
    {
        $user = Auth::user();
        
        // Check if enrolled
        $enrollment = $user->enrollments()->where('course_id', $course->id)->first();
        if (!$enrollment) {
            abort(403);
        }

        if (!$session->meeting_url) {
            abort(404, 'No meeting link available');
        }

        if ($session->start_time > now() && $session->status == 'scheduled') {
            return redirect($session->meeting_url);
        }

        abort(403, 'Session is not available for joining');
    }
}