<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseMaterialController extends Controller
{
    public function index(Course $course)
    {
        $user = Auth::user();

        // Check if enrolled
        $enrollment = $user->enrollments()->where('course_id', $course->id)->first();
        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course');
        }

        $materials = $course->materials()
            ->orderBy('order_position')
            ->paginate(12);

        return view('user.materials.index', compact('course', 'materials', 'enrollment'));
    }

    public function show(Course $course, CourseMaterial $material)
    {
        $user = Auth::user();

        // Check if enrolled
        $enrollment = $user->enrollments()->where('course_id', $course->id)->first();
        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course');
        }

        return view('user.materials.show', compact('course', 'material'));
    }

    public function download(Course $course, CourseMaterial $material)
    {
        $user = Auth::user();

        // Check if enrolled
        $enrollment = $user->enrollments()->where('course_id', $course->id)->first();
        if (!$enrollment) {
            abort(403);
        }

        if (!$material->file_path) {
            abort(404);
        }

        return Storage::disk('public')->download($material->file_path);
    }
}