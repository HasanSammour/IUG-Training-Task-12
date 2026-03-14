<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Notification;
use App\Models\Message; // Add this
use App\Models\SessionAttendance;
use App\Models\CourseSession;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BulkActionController extends Controller
{
    use AuthorizesRequests;

    public function updateProgress(Request $request, Course $course)
    {
        $this->authorize('update', $course);
        
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
            'progress' => 'required|integer|min:0|max:100',
            'reason' => 'nullable|string'
        ]);

        $updated = 0;
        foreach ($request->student_ids as $studentId) {
            $enrollment = Enrollment::where('course_id', $course->id)
                ->where('user_id', $studentId)
                ->first();
                
            if ($enrollment) {
                $oldProgress = $enrollment->progress_percentage;
                $enrollment->update([
                    'progress_percentage' => $request->progress,
                    'status' => $request->progress >= 100 ? 'completed' : 'active',
                    'completed_at' => $request->progress >= 100 ? now() : $enrollment->completed_at
                ]);
                
                // Create notification for student
                Notification::create([
                    'user_id' => $studentId,
                    'title' => '📊 Progress Updated',
                    'message' => "Your progress in '{$course->title}' has been updated to {$request->progress}%",
                    'type' => 'progress',
                    'data' => [
                        'course_id' => $course->id,
                        'old_progress' => $oldProgress,
                        'new_progress' => $request->progress
                    ],
                    'action_url' => route('courses.progress', $enrollment->id),
                    'action_text' => 'View Course',
                    'is_read' => false
                ]);
                
                $updated++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Progress updated for {$updated} students",
            'updated' => $updated
        ]);
    }

    public function markSessionAttendance(Request $request, Course $course)
    {
        $this->authorize('update', $course);
        
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
            'session_id' => 'required|exists:course_sessions,id'
        ]);

        $session = CourseSession::findOrFail($request->session_id);
        $marked = 0;

        foreach ($request->student_ids as $studentId) {
            SessionAttendance::updateOrCreate(
                [
                    'course_session_id' => $session->id,
                    'user_id' => $studentId
                ],
                [
                    'attended' => true,
                    'instructor_notes' => 'Marked via bulk action'
                ]
            );
            $marked++;
        }

        return response()->json([
            'success' => true,
            'message' => "Attendance marked for {$marked} students in session: {$session->title}"
        ]);
    }

    // SendBulkMessage
    public function sendBulkMessage(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
            'message' => 'required|string'
        ]);

        $instructor = auth()->user();
        $sent = 0;
        $errors = 0;

        // Create a default subject
        $subject = 'Message from Instructor: ' . $course->title;

        foreach ($request->student_ids as $studentId) {
            try {
                // Save to messages table
                $message = Message::create([
                    'sender_id' => $instructor->id,
                    'receiver_id' => $studentId,
                    'message' => $request->message,
                    'course_id' => $course->id,
                    'is_read' => false
                ]);

                // Create notification for student - use the default subject
                Notification::create([
                    'user_id' => $studentId,
                    'title' => $subject,
                    'message' => $request->message,
                    'type' => 'message',
                    'data' => [
                        'course_id' => $course->id,
                        'sender_id' => $instructor->id,
                        'sender_name' => $instructor->name,
                        'message_id' => $message->id
                    ],
                    'action_url' => route('messages.conversation', $instructor->id),
                    'action_text' => 'Reply',
                    'is_read' => false
                ]);

                $sent++;
            } catch (\Exception $e) {
                $errors++;
                \Log::error('Bulk message error: ' . $e->getMessage());
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Message sent to {$sent} students" . ($errors > 0 ? " (Failed: {$errors})" : ""),
            'sent' => $sent,
            'errors' => $errors
        ]);
    }

    public function shareMaterial(Request $request, Course $course)
    {
        $this->authorize('update', $course);
        
        $request->validate([
            'material_id' => 'required|exists:course_materials,id',
            'message' => 'nullable|string'
        ]);

        $material = CourseMaterial::findOrFail($request->material_id);
        $students = $course->enrollments()->with('user')->get();
        $sent = 0;

        foreach ($students as $enrollment) {
            Notification::create([
                'user_id' => $enrollment->user->id,
                'title' => '📚 New Material: ' . $material->title,
                'message' => $request->message ?? "New course material has been shared",
                'type' => 'material',
                'data' => [
                    'material_id' => $material->id,
                    'course_id' => $course->id,
                    'material_type' => $material->type
                ],
                'action_url' => $material->file_url,
                'action_text' => 'View Material',
                'is_read' => false
            ]);
            $sent++;
        }

        return response()->json([
            'success' => true,
            'message' => "Material shared with {$sent} students"
        ]);
    }
}