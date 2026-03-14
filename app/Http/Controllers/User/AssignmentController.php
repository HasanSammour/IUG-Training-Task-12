<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseAssignment;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index(Course $course)
    {
        $user = Auth::user();

        // Check if enrolled
        $enrollment = $user->enrollments()->where('course_id', $course->id)->first();
        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course');
        }

        $assignments = $course->assignments()
            ->with(['submissions' => function($q) use ($user) {
                $q->where('user_id', $user->id);
            }])
            ->orderBy('due_date')
            ->paginate(10);

        $stats = [
            'total' => $assignments->total(),
            'submitted' => $assignments->filter(function($assignment) {
                return $assignment->submissions->isNotEmpty();
            })->count(),
            'graded' => $assignments->filter(function($assignment) {
                return $assignment->submissions->isNotEmpty() && !is_null($assignment->submissions->first()->grade);
            })->count(),
        ];

        return view('user.assignments.index', compact('course', 'assignments', 'stats', 'enrollment'));
    }

    public function show(Course $course, CourseAssignment $assignment)
    {
        $user = Auth::user();
        
        // Check if enrolled
        $enrollment = $user->enrollments()->where('course_id', $course->id)->first();
        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course');
        }

        $submission = $assignment->submissions()
            ->where('user_id', $user->id)
            ->first();

        $isOverdue = $assignment->due_date && $assignment->due_date < now() && !$submission;

        return view('user.assignments.show', compact('course', 'assignment', 'submission', 'isOverdue'));
    }

    public function submit(Request $request, Course $course, CourseAssignment $assignment)
    {
        $user = Auth::user();
        
        // Check if enrolled
        $enrollment = $user->enrollments()->where('course_id', $course->id)->first();
        if (!$enrollment) {
            return response()->json(['error' => 'Not enrolled'], 403);
        }

        // Check if already graded
        $existingSubmission = $assignment->submissions()
            ->where('user_id', $user->id)
            ->first();

        if ($existingSubmission && $existingSubmission->grade !== null) {
            return response()->json(['error' => 'Assignment already graded'], 400);
        }

        $request->validate([
            'submission_text' => 'nullable|string',
            'file' => 'nullable|file|max:20480', // 20MB max
        ]);

        if (!$request->submission_text && !$request->hasFile('file')) {
            return response()->json(['error' => 'Please provide either text or file'], 400);
        }

        $data = [
            'course_assignment_id' => $assignment->id,
            'user_id' => $user->id,
            'submission_text' => $request->submission_text,
            'status' => 'submitted',
            'submitted_at' => now(),
        ];

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('submissions/' . $assignment->id, 'public');
            $data['file_path'] = $path;
        }

        if ($existingSubmission) {
            // Delete old file
            if ($existingSubmission->file_path) {
                Storage::disk('public')->delete($existingSubmission->file_path);
            }
            $existingSubmission->update($data);
            $submission = $existingSubmission;
        } else {
            $submission = AssignmentSubmission::create($data);
        }

        return response()->json([
            'success' => true,
            'message' => 'Assignment submitted successfully',
            'submission' => $submission
        ]);
    }

    public function downloadFile(Course $course, AssignmentSubmission $submission)
    {
        $user = Auth::user();
        
        if ($submission->user_id != $user->id) {
            abort(403);
        }

        if (!$submission->file_path) {
            abort(404);
        }

        return Storage::disk('public')->download($submission->file_path);
    }
}