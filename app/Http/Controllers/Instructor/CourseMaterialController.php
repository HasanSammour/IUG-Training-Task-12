<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseMaterial;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Traits\ChecksCourseStatus;

class CourseMaterialController extends Controller
{
    use AuthorizesRequests, ChecksCourseStatus;

    /**
     * Display a listing of materials for a course.
     */
    public function index(Course $course)
    {
        // Check course status for instructors
        $this->checkCourseStatus($course);

        $this->authorize('update', $course);

        $materials = $course->materials()
            ->orderBy('order_position')
            ->get();

        return view('instructor.courses.materials.index', compact('course', 'materials'));
    }

    /**
     * Show the form for creating a new material.
     */
    public function create(Course $course)
    {
        // Check course status
        $this->abortIfCourseInactive($course);
        $this->authorize('update', $course);
        
        return view('instructor.courses.materials.create', compact('course'));
    }

    /**
     * Store a newly created material in storage.
     */
    public function store(Request $request, Course $course)
    {
        // Check course status
        $this->abortIfCourseInactive($course);
        $this->authorize('update', $course);
    
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:document,video,link,presentation,other',
            'external_link' => 'required_if:type,link|nullable|url',
            'file' => 'required_if:type,document,video,presentation,other|nullable|file|max:51200',
            'order_position' => 'nullable|integer'
        ]);
    
        $data = [
            'course_id' => $course->id,
            'instructor_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'external_link' => $request->external_link,
            'order_position' => $request->order_position ?? 0,
        ];
    
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('materials/' . $course->id, 'public');
            $data['file_path'] = $path;
            $data['file_type'] = $request->file('file')->getClientOriginalExtension();
            $data['file_size'] = $request->file('file')->getSize();
        }
    
        $material = CourseMaterial::create($data);
    
        // Send notification to students if requested
        if ($request->has('notify_students') && $request->notify_students) {
            $enrollments = $course->enrollments()->with('user')->get();
            foreach ($enrollments as $enrollment) {
                Notification::create([
                    'user_id' => $enrollment->user->id,
                    'title' => '📚 New Material: ' . $material->title,
                    'message' => "New course material has been added to '{$course->title}'",
                    'type' => 'material',
                    'data' => [
                        'material_id' => $material->id,
                        'course_id' => $course->id,
                    ],
                    'action_url' => route('courses.materials.show', [$course->id, $material->id]),
                    'action_text' => 'View Material',
                    'is_read' => false
                ]);
            }
        }
    
        return redirect()->route('instructor.course.materials.index', $course)
            ->with('success', 'Material added successfully' . 
                ($request->has('notify_students') && $request->notify_students ? ' and students notified' : ''));
    }

    /**
     * Show the form for editing the specified material.
     */
    public function edit(Course $course, CourseMaterial $material)
    {
        // Check course status
        $this->abortIfCourseInactive($course);
        $this->authorize('update', $course);
        
        return view('instructor.courses.materials.edit', compact('course', 'material'));
    }

    /**
     * Update the specified material in storage.
     */
    public function update(Request $request, Course $course, CourseMaterial $material)
    {
        // Check course status
        if (auth()->user()->hasRole('instructor') && !$course->is_active) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This course is inactive. Please contact an administrator to activate it first.'
                ], 403);
            }
            return redirect()->back()
                ->with('error', 'This course is inactive. Please contact an administrator to activate it first.');
        }

        $this->authorize('update', $course);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:document,video,link,presentation,other',
            'external_link' => 'nullable|url',
            'file' => 'nullable|file|max:51200',
            'order_position' => 'nullable|integer'
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'external_link' => $request->external_link,
            'order_position' => $request->order_position ?? $material->order_position,
        ];

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $path = $request->file('file')->store('materials/' . $course->id, 'public');
            $data['file_path'] = $path;
            $data['file_type'] = $request->file('file')->getClientOriginalExtension();
            $data['file_size'] = $request->file('file')->getSize();
        }

        // Handle file removal
        if ($request->has('remove_current_file') && $request->remove_current_file == '1') {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $data['file_path'] = null;
            $data['file_type'] = null;
            $data['file_size'] = null;
        }

        $material->update($data);

        // Send notification to students if requested
        if ($request->has('notify_students') && $request->notify_students) {
            $enrollments = $course->enrollments()->with('user')->get();
            foreach ($enrollments as $enrollment) {
                Notification::create([
                    'user_id' => $enrollment->user->id,
                    'title' => '📚 Material Updated: ' . $material->title,
                    'message' => "Course material has been updated in '{$course->title}'",
                    'type' => 'material',
                    'data' => [
                        'material_id' => $material->id,
                        'course_id' => $course->id,
                    ],
                    'action_url' => route('courses.materials.show', [$course->id, $material->id]),
                    'action_text' => 'View Material',
                    'is_read' => false
                ]);
            }
        }

        return redirect()->route('instructor.course.materials.index', $course)
            ->with('success', 'Material updated successfully' . 
                ($request->has('notify_students') && $request->notify_students ? ' and students notified' : ''));
    }

    /**
     * Display the specified material.
     */
    public function show(Course $course, CourseMaterial $material)
    {
        // Check course status
        $this->checkCourseStatus($course);

        $this->authorize('update', $course);

        return view('instructor.courses.materials.show', compact('course', 'material'));
    }

    /**
     * Reorder materials (AJAX request).
     */
    public function reorder(Request $request, Course $course)
    {
        // Check course status for AJAX
        if (auth()->user()->hasRole('instructor') && !$course->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'This course is inactive. Please contact an administrator to activate it first.'
            ], 403);
        }

        $this->authorize('update', $course);

        $request->validate([
            'materials' => 'required|array',
            'materials.*.id' => 'required|exists:course_materials,id',
            'materials.*.position' => 'required|integer'
        ]);

        foreach ($request->materials as $item) {
            CourseMaterial::where('id', $item['id'])
                ->where('course_id', $course->id)
                ->update(['order_position' => $item['position']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified material from storage.
     */
    public function destroy(Course $course, CourseMaterial $material)
    {
        // Check course status for AJAX
        if (auth()->user()->hasRole('instructor') && !$course->is_active) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This course is inactive. Please contact an administrator to activate it first.'
                ], 403);
            }
            return redirect()->back()
                ->with('error', 'This course is inactive. Please contact an administrator to activate it first.');
        }

        $this->authorize('update', $course);

        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Material deleted successfully',
                'redirect' => route('instructor.course.materials.index', $course)
            ]);
        }

        return redirect()->route('instructor.course.materials.index', $course)
            ->with('success', 'Material deleted successfully');
    }
}