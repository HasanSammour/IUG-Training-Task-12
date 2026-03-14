<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseAssignment;
use App\Models\AssignmentSubmission;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\ChecksCourseStatus;

class CourseAssignmentController extends Controller
{
    use AuthorizesRequests, ChecksCourseStatus;

    /**
     * Display a listing of assignments for a course.
     */
    public function index(Course $course)
    {
        // Check if course is active (for instructors)
        $this->checkCourseStatus($course);

        $this->authorize('update', $course);

        $assignments = $course->assignments()
            ->withCount('submissions')
            ->orderBy('due_date', 'desc')
            ->get();

        return view('instructor.courses.assignments.index', compact('course', 'assignments'));
    }

    /**
     * Show the form for creating a new assignment.
     */
    public function create(Course $course)
    {
        // Check if course is active (for instructors)
        $this->checkCourseStatus($course);

        $this->authorize('update', $course);
        return view('instructor.courses.assignments.create', compact('course'));
    }

    /**
     * Store a newly created assignment in storage.
     */
    public function store(Request $request, Course $course)
    {
        // Check if course is active (for instructors)
        $this->checkCourseStatus($course);

        $this->authorize('update', $course);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'nullable|date',
            'points' => 'nullable|integer|min:0|max:1000',
            'file' => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240'
        ]);

        $data = [
            'course_id' => $course->id,
            'instructor_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'points' => $request->points ?? 100,
        ];

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('assignments/' . $course->id, 'public');
            $data['file_path'] = $path;
        }

        $assignment = CourseAssignment::create($data);

        // Send notification to all enrolled students
        $enrollments = $course->enrollments()->with('user')->get();

        foreach ($enrollments as $enrollment) {
            $dueDateText = $assignment->due_date
                ? ' Due: ' . \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y')
                : '';

            Notification::create([
                'user_id' => $enrollment->user->id,
                'title' => '📝 New Assignment: ' . $assignment->title,
                'message' => "A new assignment has been created for '{$course->title}'.{$dueDateText} Total points: {$assignment->points}",
                'type' => 'assignment',
                'data' => [
                    'assignment_id' => $assignment->id,
                    'course_id' => $course->id,
                    'course_title' => $course->title,
                    'points' => $assignment->points,
                    'due_date' => $assignment->due_date
                ],
                'action_url' => route('courses.assignments.show', [$course->id, $assignment->id]),
                'action_text' => 'View Assignment',
                'is_read' => false
            ]);
        }

        return redirect()->route('instructor.course.assignments.index', $course)
            ->with('success', 'Assignment created successfully and ' . $enrollments->count() . ' students notified');
    }

    /**
     * Show the form for editing the specified assignment.
     */
    public function edit(Course $course, CourseAssignment $assignment)
    {
        // Check if course is active (for instructors)
        $this->checkCourseStatus($course);

        $this->authorize('update', $course);
        return view('instructor.courses.assignments.edit', compact('course', 'assignment'));
    }

    /**
     * Update the specified assignment in storage.
     */
    public function update(Request $request, Course $course, CourseAssignment $assignment)
    {
        // Check if course is active (for instructors)
        $this->checkCourseStatus($course);

        $this->authorize('update', $course);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'nullable|date',
            'points' => 'nullable|integer|min:0|max:1000',
            'file' => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240'
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'points' => $request->points ?? 100,
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            if ($assignment->file_path) {
                Storage::disk('public')->delete($assignment->file_path);
            }
            $path = $request->file('file')->store('assignments/' . $course->id, 'public');
            $data['file_path'] = $path;
        }

        $assignment->update($data);

        // Optional: Notify students about update (if major changes)
        if ($request->has('notify_students')) {
            $enrollments = $course->enrollments()->with('user')->get();

            foreach ($enrollments as $enrollment) {
                Notification::create([
                    'user_id' => $enrollment->user->id,
                    'title' => '✏️ Assignment Updated: ' . $assignment->title,
                    'message' => "The assignment '{$assignment->title}' in '{$course->title}' has been updated. Please check for changes.",
                    'type' => 'assignment',
                    'data' => [
                        'assignment_id' => $assignment->id,
                        'course_id' => $course->id,
                        'course_title' => $course->title,
                    ],
                    'action_url' => route('courses.assignments.show', [$course->id, $assignment->id]),
                    'action_text' => 'View Assignment',
                    'is_read' => false
                ]);
            }
        }

        return redirect()->route('instructor.course.assignments.index', $course)
            ->with('success', 'Assignment updated successfully');
    }

    /**
     * Display the submissions for a specific assignment.
     */
    public function showSubmissions(Course $course, CourseAssignment $assignment)
    {
        // This will automatically throw exception if course is inactive
        $this->checkCourseStatus($course);

        $this->authorize('update', $course);

        $submissions = $assignment->submissions()
            ->with('user')
            ->orderBy('submitted_at', 'desc')
            ->get();

        return view('instructor.courses.assignments.submissions', compact('course', 'assignment', 'submissions'));
    }

    /**
     * Grade a specific submission.
     */
    public function gradeSubmission(Request $request, Course $course, CourseAssignment $assignment, AssignmentSubmission $submission)
    {
        // Check if course is active (for instructors)
        if (Auth::user()->hasRole('instructor')) {
            $this->checkCourseStatus($course);
        }

        $this->authorize('update', $course);

        $request->validate([
            'grade' => 'required|integer|min:0|max:' . $assignment->points,
            'feedback' => 'nullable|string'
        ]);

        $submission->update([
            'grade' => $request->grade,
            'feedback' => $request->feedback,
            'status' => 'graded'
        ]);

        // Notify student
        Notification::create([
            'user_id' => $submission->user_id,
            'title' => '📝 Assignment Graded',
            'message' => "Your assignment '{$assignment->title}' has been graded. You received {$request->grade}/{$assignment->points} points.",
            'type' => 'assignment',
            'data' => [
                'assignment_id' => $assignment->id,
                'course_id' => $course->id,
                'grade' => $request->grade,
                'feedback' => $request->feedback
            ],
            'action_url' => route('courses.assignments.show', [$course->id, $assignment->id]),
            'action_text' => 'View Feedback',
            'is_read' => false
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Grade submitted successfully'
            ]);
        }

        return redirect()->back()->with('success', 'Grade submitted successfully');
    }

    /**
     * Remove the specified assignment from storage.
     */
    public function destroy(Course $course, CourseAssignment $assignment)
    {
        // Check if course is active (for instructors)
        if (Auth::user()->hasRole('instructor')) {
            $this->checkCourseStatus($course);
        }

        $this->authorize('update', $course);

        if ($assignment->file_path) {
            Storage::disk('public')->delete($assignment->file_path);
        }

        $assignment->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Assignment deleted successfully',
                'redirect' => route('instructor.course.assignments.index', $course)
            ]);
        }

        return redirect()->route('instructor.course.assignments.index', $course)
            ->with('success', 'Assignment deleted successfully');
    }
}