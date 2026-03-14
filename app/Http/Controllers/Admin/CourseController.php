<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Enrollment;
use App\Models\CourseSession;
use App\Models\CourseAssignment;
use App\Models\CourseMaterial;
use App\Models\SessionAttendance;
use App\Models\CourseReview;
use App\Traits\ChecksCourseStatus;

class CourseController extends Controller
{
    use ChecksCourseStatus;

    public function index(Request $request)
    {
        $query = Course::with('category');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('instructor_name', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('is_active', true);
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'featured':
                    $query->where('is_featured', true);
                    break;
            }
        }

        // Sorting
        switch ($request->sort) {
            case 'popular':
                $query->orderByDesc('total_students');
                break;
            case 'price_low':
                $query->orderBy('price');
                break;
            case 'price_high':
                $query->orderByDesc('price');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $courses = $query->paginate(20);
        $categories = Category::all();

        return view('admin.courses.index', compact('courses', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();

        // For instructor, show only their own create form
        if (auth()->user()->hasRole('instructor')) {
            return view('instructor.courses.create', compact('categories'));
        }

        // Admin sees all instructors
        $instructors = User::whereHas('roles', function ($query) {
            $query->where('name', 'instructor');
        })->get();

        return view('admin.courses.create', compact('categories', 'instructors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'short_description' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'format' => 'required|in:online,in-person,hybrid',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $slug = Str::slug($request->title) . '-' . Str::random(6);

        // Set instructor name based on role
        if (auth()->user()->hasRole('instructor')) {
            $instructorName = auth()->user()->name;
        } else {
            // Admin must select instructor
            $request->validate(['instructor_id' => 'required|exists:users,id']);
            $instructor = User::findOrFail($request->instructor_id);
            $instructorName = $instructor->name;
        }

        $courseData = [
            'title' => $request->title,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'price' => $request->price,
            'discounted_price' => $request->discounted_price ?? null,
            'discount_percentage' => $request->discount_percentage ?? null,
            'instructor_name' => $instructorName,
            'duration' => $request->duration,
            'level' => $request->level,
            'format' => $request->format,
            'tags' => $request->tags ? $this->processTags($request->tags) : null,
            'requirements' => $request->requirements ? $this->processList($request->requirements) : null,
            'what_you_will_learn' => $request->what_you_will_learn ? $this->processList($request->what_you_will_learn) : null,
            'meta_description' => $request->meta_description,
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active'),
            'total_students' => 0,
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/courses', 'public');
            $courseData['image_path'] = $imagePath;
        } else {
            $courseData['image_path'] = 'images/course-placeholder.jpg';
        }

        Course::create($courseData);

        // Redirect based on user role
        if (auth()->user()->hasRole('instructor')) {
            return redirect()->route('instructor.courses')
                ->with('success', 'Course created successfully.');
        }

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        $categories = Category::all();

        // Check if user is instructor and owns this course
        if (auth()->user()->hasRole('instructor')) {
            // Check course status - will throw exception if inactive
            $this->checkCourseStatus($course);

            if ($course->instructor_name !== auth()->user()->name) {
                abort(403, 'You do not own this course');
            }

            return view('instructor.courses.edit', compact('course', 'categories'));
        }

        $instructors = User::whereHas('roles', function ($query) {
            $query->where('name', 'instructor');
        })->get();

        // Try to find the instructor by name (not ID since we don't store ID)
        $currentInstructor = null;
        if ($course->instructor_name) {
            $currentInstructor = User::where('name', $course->instructor_name)
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'instructor');
                })
                ->first();
        }

        return view('admin.courses.edit', compact(
            'course',
            'categories',
            'instructors',
            'currentInstructor'
        ));
    }

    public function update(Request $request, Course $course)
    {
        // Check ownership for instructor
        if (auth()->user()->hasRole('instructor') && $course->instructor_name !== auth()->user()->name) {
            abort(403, 'You do not own this course');
        }

        // Check course status for instructors
        if (auth()->user()->hasRole('instructor') && !$course->is_active) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This course is inactive. Please contact an administrator to activate it first.'
                ], 403);
            }
            return redirect()->back()->with('error', 'This course is inactive. Please contact an administrator to activate it first.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'short_description' => 'required|string|max:500',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'format' => 'required|in:online,in-person,hybrid',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'tags' => 'nullable|string',
            'requirements' => 'nullable|string',
            'what_you_will_learn' => 'nullable|string',
            'meta_description' => 'nullable|string|max:160',
        ]);

        // Prepare update data
        $updateData = [
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'price' => $request->price,
            'discounted_price' => $request->discounted_price ?? null,
            'discount_percentage' => $request->discount_percentage ?? null,
            'duration' => $request->duration,
            'level' => $request->level,
            'format' => $request->format,
            'tags' => $request->tags ? $this->processTags($request->tags) : null,
            'requirements' => $request->requirements ? $this->processList($request->requirements) : null,
            'what_you_will_learn' => $request->what_you_will_learn ? $this->processList($request->what_you_will_learn) : null,
            'meta_description' => $request->meta_description,
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active'),
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it's not the default placeholder
            if ($course->image_path && $course->image_path !== 'images/course-placeholder.jpg') {
                if (!filter_var($course->image_path, FILTER_VALIDATE_URL)) {
                    Storage::delete('public/' . $course->image_path);
                }
            }

            // Store new image
            $imagePath = $request->file('image')->store('images/courses', 'public');
            $updateData['image_path'] = $imagePath;
        }

        $course->update($updateData);

        // Redirect based on user role
        if (auth()->user()->hasRole('instructor')) {
            return redirect()->route('instructor.courses')
                ->with('success', 'Course updated successfully.');
        }

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        if (auth()->user()->hasRole('instructor') && $course->instructor_name !== auth()->user()->name) {
            abort(403, 'You do not own this course');
        }

        // Check course status for instructors
        if (auth()->user()->hasRole('instructor') && !$course->is_active) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This course is inactive. Please contact an administrator to activate it first.'
                ], 403);
            }
            return redirect()->back()->with('error', 'This course is inactive. Please contact an administrator to activate it first.');
        }

        // Delete course image from storage if it's not the default placeholder
        if ($course->image_path && $course->image_path !== 'images/course-placeholder.jpg') {
            // Check if it's a full URL (skip deletion) or a storage path
            if (!filter_var($course->image_path, FILTER_VALIDATE_URL)) {
                Storage::delete('public/' . $course->image_path);
            }
        }

        $course->delete();

        $redirectRoute = auth()->user()->hasRole('instructor') ? 'instructor.courses' : 'admin.courses.index';

        return redirect()->route($redirectRoute)->with('success', 'Course deleted successfully.');
    }

    public function toggleFeatured(Course $course)
    {
        // Check course status for instructors
        if (auth()->user()->hasRole('instructor') && !$course->is_active) {
            return back()->with('error', 'This course is inactive. Please contact an administrator to activate it first.');
        }

        $course->update([
            'is_featured' => !$course->is_featured,
        ]);

        return back()->with('success', 'Course featured status updated.');
    }

    public function toggleActive(Course $course)
    {
        // Only admin can toggle active status
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Only administrators can change course active status.');
        }

        $course->update([
            'is_active' => !$course->is_active,
        ]);

        return back()->with('success', 'Course active status updated.');
    }

    public function enrollments(Course $course, Request $request)
    {
        // Check course status for instructors
        if (auth()->user()->hasRole('instructor') && !$course->is_active) {
            return back()->with('error', 'This course is inactive. Please contact an administrator to activate it first.');
        }

        $query = $course->enrollments()
            ->with('user')
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by student name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('enrolled_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('enrolled_at', '<=', $request->date_to);
        }

        $enrollments = $query->paginate(20);

        // Calculate stats
        $totalEnrollments = $course->enrollments()->count();
        $activeEnrollments = $course->enrollments()->where('status', 'active')->count();
        $completedEnrollments = $course->enrollments()->where('status', 'completed')->count();
        $averageProgress = round($course->enrollments()->avg('progress_percentage') ?? 0);

        return view('admin.courses.enrollments', compact(
            'course',
            'enrollments',
            'totalEnrollments',
            'activeEnrollments',
            'completedEnrollments',
            'averageProgress'
        ));
    }

    // For Instructors
    public function instructorCourses(Request $request)
    {
        $user = auth()->user();

        // Get courses where instructor_name matches the authenticated user's name
        $query = Course::where('instructor_name', $user->name)
            ->with(['category', 'enrollments.user']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'active':
                    $query->where('is_active', true);
                    break;
                case 'inactive':
                    $query->where('is_active', false);
                    break;
                case 'featured':
                    $query->where('is_featured', true);
                    break;
            }
        }

        // Default sorting
        $query->latest();

        $courses = $query->paginate(20)->withQueryString();

        // Calculate stats for this instructor's courses
        $courseIds = Course::where('instructor_name', $user->name)->pluck('id');

        $stats = [
            'active_courses' => Course::where('instructor_name', $user->name)
                ->where('is_active', true)
                ->count(),
            'total_students' => Enrollment::whereIn('course_id', $courseIds)
                ->where('status', 'active')
                ->count(),
            'avg_progress' => round(Enrollment::whereIn('course_id', $courseIds)
                ->avg('progress_percentage') ?? 0),
        ];

        return view('instructor.courses', compact('courses', 'stats'));
    }

    public function courseStudents(Request $request, Course $course)
    {
        // Verify instructor owns this course
        if (auth()->user()->hasRole('instructor') && $course->instructor_name !== auth()->user()->name) {
            abort(403, 'You do not have permission to view this course.');
        }

        // Check course status for instructors
        if (auth()->user()->hasRole('instructor') && !$course->is_active) {
            return back()->with('error', 'This course is inactive. Please contact an administrator to activate it first.');
        }

        // Get sessions
        $sessions = CourseSession::where('course_id', $course->id)
            ->orderBy('start_time', 'desc')
            ->get();

        // Get assignments
        $assignments = CourseAssignment::where('course_id', $course->id)
            ->withCount('submissions')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get materials
        $materials = CourseMaterial::where('course_id', $course->id)
            ->orderBy('order_position')
            ->get();

        // Counts for tabs
        $sessionsCount = $sessions->count();
        $assignmentsCount = $assignments->count();
        $materialsCount = $materials->count();

        // Get enrollments with filters
        $query = $course->enrollments()
            ->with([
                'user' => function ($q) {
                    $q->select('id', 'name', 'email', 'avatar', 'created_at');
                }
            ])
            ->latest('enrolled_at');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by student name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('enrolled_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('enrolled_at', '<=', $request->date_to);
        }

        // Filter by progress range
        if ($request->filled('progress_min')) {
            $query->where('progress_percentage', '>=', $request->progress_min);
        }

        if ($request->filled('progress_max')) {
            $query->where('progress_percentage', '<=', $request->progress_max);
        }

        $enrollments = $query->paginate(20)->withQueryString();

        // Calculate comprehensive stats
        $activeCount = $course->enrollments()->where('status', 'active')->count();
        $completedCount = $course->enrollments()->where('status', 'completed')->count();
        $pendingCount = $course->enrollments()->where('status', 'pending')->count();
        $cancelledCount = $course->enrollments()->where('status', 'cancelled')->count();

        $averageProgress = round($course->enrollments()->avg('progress_percentage') ?? 0);

        $totalRevenue = $course->enrollments()
            ->whereIn('status', ['active', 'completed'])
            ->sum('amount_paid');

        // Calculate recent activity (last 7 days)
        $recentEnrollments = $course->enrollments()
            ->where('enrolled_at', '>=', now()->subDays(7))
            ->count();

        $recentCompletions = $course->enrollments()
            ->where('completed_at', '>=', now()->subDays(7))
            ->count();

        // Calculate retention rate (students who progressed beyond 25%)
        $totalActiveEnrollments = $course->enrollments()->count();
        $retainedStudents = $course->enrollments()
            ->where('progress_percentage', '>', 25)
            ->count();
        $retentionRate = $totalActiveEnrollments > 0
            ? round(($retainedStudents / $totalActiveEnrollments) * 100)
            : 0;

        $stats = [
            'total' => $enrollments->total(),
            'active' => $activeCount,
            'completed' => $completedCount,
            'pending' => $pendingCount,
            'cancelled' => $cancelledCount,
            'average_progress' => $averageProgress,
            'total_revenue' => $totalRevenue,
            'recent_enrollments' => $recentEnrollments,
            'recent_completions' => $recentCompletions,
            'retention_rate' => $retentionRate,
        ];

        return view('instructor.course-students', compact(
            'course',
            'enrollments',
            'stats',
            'sessions',
            'assignments',
            'materials',
            'sessionsCount',
            'assignmentsCount',
            'materialsCount'
        ));
    }

    public function exportStudentReport(Request $request, Course $course)
    {
        // Verify instructor owns this course
        if (auth()->user()->hasRole('instructor') && $course->instructor_name !== auth()->user()->name) {
            abort(403, 'You do not have permission to view this course.');
        }

        // Check course status for instructors
        if (auth()->user()->hasRole('instructor') && !$course->is_active) {
            return back()->with('error', 'This course is inactive. Please contact an administrator to activate it first.');
        }

        $query = $course->enrollments()->with('user');

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('enrolled_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('enrolled_at', '<=', $request->date_to);
        }

        if ($request->filled('progress_min')) {
            $query->where('progress_percentage', '>=', $request->progress_min);
        }

        if ($request->filled('progress_max')) {
            $query->where('progress_percentage', '<=', $request->progress_max);
        }

        $enrollments = $query->get();

        // Calculate stats
        $stats = [
            'total' => $enrollments->count(),
            'active' => $enrollments->where('status', 'active')->count(),
            'completed' => $enrollments->where('status', 'completed')->count(),
            'pending' => $enrollments->where('status', 'pending')->count(),
            'cancelled' => $enrollments->where('status', 'cancelled')->count(),
            'average_progress' => round($enrollments->avg('progress_percentage') ?? 0),
            'total_revenue' => $enrollments->whereIn('status', ['active', 'completed'])->sum('amount_paid'),
            'recent_enrollments' => $enrollments->where('enrolled_at', '>=', now()->subDays(7))->count(),
            'retention_rate' => $enrollments->count() > 0
                ? round(($enrollments->where('progress_percentage', '>', 25)->count() / $enrollments->count()) * 100)
                : 0,
        ];

        $includeStats = $request->boolean('stats', true);
        $includeStudents = $request->boolean('students', true);
        $includeProgress = $request->boolean('progress', true);

        $pdf = PDF::loadView('instructor.students-report', compact(
            'course',
            'enrollments',
            'stats',
            'includeStats',
            'includeStudents',
            'includeProgress'
        ));

        return $pdf->download('course-students-report-' . $course->id . '-' . now()->format('Y-m-d') . '.pdf');
    }

    public function generateCertificate(Enrollment $enrollment)
    {
        $course = $enrollment->course;
        $user = $enrollment->user;

        // Verify instructor owns this course
        if (auth()->user()->hasRole('instructor') && $course->instructor_name !== auth()->user()->name) {
            abort(403, 'You do not have permission to view this course.');
        }

        // Check course status for instructors
        if (auth()->user()->hasRole('instructor') && !$course->is_active) {
            return back()->with('error', 'This course is inactive. Please contact an administrator to activate it first.');
        }

        // Check if course is completed
        if ($enrollment->status !== 'completed' && $enrollment->progress_percentage < 100) {
            abort(403, 'Course not completed yet');
        }

        // Check if view exists
        if (!view()->exists('instructor.certificate')) {
            return response()->json(['error' => 'View not found: instructor.certificate'], 500);
        }

        $pdf = PDF::loadView('instructor.certificate', compact('enrollment', 'course', 'user'));
        return $pdf->download('certificate-' . $user->name . '-' . $course->id . '.pdf');
    }

    public function studentProgressDetail(Enrollment $enrollment)
    {
        // Verify instructor owns this course
        $course = $enrollment->course;
        if (auth()->user()->hasRole('instructor') && $course->instructor_name !== auth()->user()->name) {
            abort(403, 'You do not have permission to view this student.');
        }

        // Check course status for instructors
        if (auth()->user()->hasRole('instructor') && !$course->is_active) {
            return back()->with('error', 'This course is inactive. Please contact an administrator to activate it first.');
        }

        $student = $enrollment->user;

        // Get ALL sessions for this course (for the table)
        $sessions = CourseSession::where('course_id', $course->id)
            ->orderBy('start_time', 'desc')
            ->get();

        // Get attendance records for this student
        $attendance = SessionAttendance::where('user_id', $student->id)
            ->whereHas('session', function ($q) use ($course) {
                $q->where('course_id', $course->id);
            })
            ->with('session')
            ->get();

        $totalSessions = $sessions->count();
        $attendedSessions = $attendance->where('attended', true)->count();
        $attendanceRate = $totalSessions > 0 ? round(($attendedSessions / $totalSessions) * 100) : 0;

        // Get assignments submissions
        $assignments = CourseAssignment::where('course_id', $course->id)
            ->with([
                'submissions' => function ($q) use ($student) {
                    $q->where('user_id', $student->id);
                }
            ])
            ->get();

        $totalAssignments = $assignments->count();
        $submittedAssignments = $assignments->filter(function ($assignment) {
            return $assignment->submissions->isNotEmpty();
        })->count();

        $submissionRate = $totalAssignments > 0 ? round(($submittedAssignments / $totalAssignments) * 100) : 0;

        // Calculate average grade
        $grades = $assignments->flatMap(function ($assignment) {
            return $assignment->submissions->pluck('grade');
        })->filter();

        $averageGrade = $grades->isNotEmpty() ? round($grades->avg()) : 0;

        // Activity timeline (last 30 days)
        $activities = collect();

        // Add session attendance
        foreach ($attendance as $record) {
            $activities->push([
                'type' => 'attendance',
                'title' => 'Attended session: ' . $record->session->title,
                'date' => $record->session->start_time,
                'icon' => 'fas fa-check-circle',
                'color' => 'green'
            ]);
        }

        // Add assignment submissions
        foreach ($assignments as $assignment) {
            foreach ($assignment->submissions as $submission) {
                $activities->push([
                    'type' => 'submission',
                    'title' => 'Submitted: ' . $assignment->title,
                    'date' => $submission->submitted_at,
                    'icon' => 'fas fa-file-upload',
                    'color' => 'blue',
                    'grade' => $submission->grade
                ]);
            }
        }

        // Sort by date descending
        $activities = $activities->sortByDesc('date')->take(20);

        return view('instructor.student-progress', compact(
            'enrollment',
            'course',
            'student',
            'sessions',
            'attendance',
            'totalSessions',
            'attendedSessions',
            'attendanceRate',
            'assignments',
            'totalAssignments',
            'submittedAssignments',
            'submissionRate',
            'averageGrade',
            'activities'
        ));
    }

    /**
     * Check course status via AJAX
     */
    public function checkCourseStatus(Course $course)
    {
        if (auth()->user()->hasRole('instructor') && !$course->is_active) {
            return response()->json([
                'active' => false,
                'message' => 'This course is inactive. Please contact an administrator to activate it first.'
            ]);
        }

        return response()->json(['active' => true]);
    }
            
    /**
     * Display all reviews with filtering and pagination.
     */
    public function reviews(Request $request)
    {
        $query = CourseReview::with(['user', 'course'])
            ->latest();

        // Filter by approval status
        if ($request->filled('status')) {
            if ($request->status === 'approved') {
                $query->where('is_approved', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_approved', false);
            }
        }

        // Filter by course
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Search by user name or review content
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })->orWhere('comment', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->paginate(20)->withQueryString();

        // Get stats
        $stats = [
            'total' => CourseReview::count(),
            'approved' => CourseReview::where('is_approved', true)->count(),
            'pending' => CourseReview::where('is_approved', false)->count(),
            'avg_rating' => round(CourseReview::where('is_approved', true)->avg('rating') ?? 0, 1),
        ];

        // Get all courses for filter dropdown
        $courses = Course::orderBy('title')->get(['id', 'title']);

        return view('admin.reviews.index', compact('reviews', 'stats', 'courses'));
    }

    /**
     * Show single review details.
     */
    public function showReview(CourseReview $review)
    {
        $review->load(['user', 'course']);
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Toggle review approval status.
     */
    public function toggleApproval(CourseReview $review)
    {
        $review->update([
            'is_approved' => !$review->is_approved
        ]);

        $status = $review->is_approved ? 'approved' : 'pending';

        // Send notification to user if approved
        if ($review->is_approved) {
            \App\Models\Notification::create([
                'user_id' => $review->user_id,
                'title' => '✅ Your Review is Live!',
                'message' => "Your review for '{$review->course->title}' has been approved and is now public.",
                'type' => 'review',
                'data' => [
                    'review_id' => $review->id,
                    'course_id' => $review->course_id,
                ],
                'action_url' => route('courses.show', $review->course->slug),
                'action_text' => 'View Course',
                'is_read' => false,
            ]);
        }

        return redirect()->back()->with('success', "Review {$status} successfully.");
    }

    /**
     * Bulk approve selected reviews.
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'review_ids' => 'required|array',
            'review_ids.*' => 'exists:course_reviews,id'
        ]);

        CourseReview::whereIn('id', $request->review_ids)
            ->update(['is_approved' => true]);

        // Notify users
        $reviews = CourseReview::whereIn('id', $request->review_ids)
            ->with('course')
            ->get();

        foreach ($reviews as $review) {
            \App\Models\Notification::create([
                'user_id' => $review->user_id,
                'title' => '✅ Your Review is Live!',
                'message' => "Your review for '{$review->course->title}' has been approved and is now public.",
                'type' => 'review',
                'data' => [
                    'review_id' => $review->id,
                    'course_id' => $review->course_id,
                ],
                'action_url' => route('courses.show', $review->course->slug),
                'action_text' => 'View Course',
                'is_read' => false,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => count($request->review_ids) . ' reviews approved successfully.'
        ]);
    }

    /**
     * Delete a review.
     */
    public function destroyReview(CourseReview $review)
    {
        $review->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Review deleted successfully.'
            ]);
        }

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }

    /**
     * Get course reviews for a specific course (AJAX).
     */
    public function getCourseReviews(Course $course)
    {
        $reviews = CourseReview::where('course_id', $course->id)
            ->with('user')
            ->latest()
            ->paginate(10);

        return response()->json($reviews);
    }

    // Helper methods
    private function processTags($tags)
    {
        $tagsArray = array_map('trim', explode(',', $tags));
        return json_encode($tagsArray);
    }

    private function processList($text)
    {
        $items = array_filter(array_map('trim', explode("\n", $text)));
        return json_encode($items);
    }
}