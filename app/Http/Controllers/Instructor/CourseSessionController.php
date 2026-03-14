<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseSession;
use App\Models\SessionAttendance;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\ChecksCourseStatus;

class CourseSessionController extends Controller
{
    use AuthorizesRequests, ChecksCourseStatus;

    public function index(Course $course)
    {
        // Check course status
        $this->checkCourseStatus($course);

        $this->authorize('update', $course);
        
        $sessions = $course->sessions()
            ->with('attendance')
            ->orderBy('start_time', 'desc')
            ->get();
            
        return view('instructor.courses.sessions.index', compact('course', 'sessions'));
    }

    public function store(Request $request, Course $course)
    {
        // Check course status
        $this->abortIfCourseInactive($course);
        $this->authorize('update', $course);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meeting_url' => 'nullable|url',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
        ]);

        $session = CourseSession::create([
            'course_id' => $course->id,
            'instructor_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'meeting_url' => $request->meeting_url,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'scheduled'
        ]);

        return redirect()->back()->with('success', 'Session scheduled successfully');
    }

    public function update(Request $request, Course $course, CourseSession $session)
    {
        // Check course status
        $this->abortIfCourseInactive($course);
        $this->authorize('update', $course);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meeting_url' => 'nullable|url',
            'recording_url' => 'nullable|url',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'status' => 'in:scheduled,ongoing,completed,cancelled'
        ]);

        $session->update($request->all());

        return redirect()->back()->with('success', 'Session updated successfully');
    }
    
    // This is for Update in Calender in Dashboard
    public function ajaxUpdate(Request $request, Course $course, CourseSession $session)
    {
        $this->authorize('update', $course);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meeting_url' => 'nullable|url',
            'recording_url' => 'nullable|url',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'status' => 'in:scheduled,ongoing,completed,cancelled'
        ]);
    
        $session->update([
            'title' => $request->title,
            'description' => $request->description,
            'meeting_url' => $request->meeting_url,
            'recording_url' => $request->recording_url,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Session updated successfully',
            'session' => $session
        ]);
    }
    
    public function shareMeetingLink(Course $course, CourseSession $session)
    {
        // Check course status
        $this->checkCourseStatus($course);

        $this->authorize('update', $course);
        
        $students = $course->enrollments()->with('user')->get();
        
        foreach ($students as $enrollment) {
            Notification::create([
                'user_id' => $enrollment->user->id,
                'title' => '🔔 Live Session: ' . $session->title,
                'message' => "Join us on " . $session->start_time->format('M d, h:i A'),
                'type' => 'session',
                'data' => [
                    'session_id' => $session->id,
                    'course_id' => $course->id,
                    'meeting_url' => $session->meeting_url,
                    'start_time' => $session->start_time
                ],
                'action_url' => $session->meeting_url,
                'action_text' => 'Join Meeting',
                'is_read' => false
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Meeting link shared with all students']);
    }

    public function shareRecording(Course $course, CourseSession $session)
    {
        // Check course status
        $this->checkCourseStatus($course);

        $this->authorize('update', $course);
        
        if (!$session->recording_url) {
            return response()->json(['success' => false, 'message' => 'No recording available'], 400);
        }
        
        $students = $course->enrollments()->with('user')->get();
        
        foreach ($students as $enrollment) {
            Notification::create([
                'user_id' => $enrollment->user->id,
                'title' => '📹 Recording Available: ' . $session->title,
                'message' => "The recording for the session is now available",
                'type' => 'session',
                'data' => [
                    'session_id' => $session->id,
                    'course_id' => $course->id,
                    'recording_url' => $session->recording_url
                ],
                'action_url' => $session->recording_url,
                'action_text' => 'Watch Recording',
                'is_read' => false
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Recording link shared with all students']);
    }

    public function markAttendance(Request $request, Course $course, CourseSession $session)
    {
        // Check course status
        $this->checkCourseStatus($course);

        $this->authorize('update', $course);
        
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
            'attended' => 'boolean'
        ]);

        foreach ($request->student_ids as $studentId) {
            SessionAttendance::updateOrCreate(
                [
                    'course_session_id' => $session->id,
                    'user_id' => $studentId
                ],
                [
                    'attended' => $request->attended ?? true,
                    'instructor_notes' => $request->notes ?? null
                ]
            );
        }

        $count = count($request->student_ids);
        return response()->json(['success' => true, 'message' => "Attendance marked for {$count} students"]);
    }

    public function destroy(Course $course, CourseSession $session)
    {
        // Check course status
        $this->checkCourseStatus($course);

        $this->authorize('update', $course);

        $session->delete();

        // Check if it's an AJAX request
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Session deleted successfully'
            ]);
        }

        return redirect()->back()->with('success', 'Session deleted successfully');
    }
}