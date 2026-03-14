<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\StudentNote;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Support\Facades\Storage;
use App\Models\LearningPath;
use App\Models\LearningPathItem;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::role('student')->with([
            'enrollments' => function ($q) {
                $q->select('id', 'user_id', 'course_id', 'status', 'progress_percentage');
            }
        ]);

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->whereHas('enrollments', function ($q) {
                    $q->where('status', 'active');
                });
            } elseif ($request->status == 'inactive') {
                $query->whereDoesntHave('enrollments', function ($q) {
                    $q->where('status', 'active');
                });
            }
        }

        // Enrollments filter
        if ($request->filled('enrollments')) {
            if ($request->enrollments == '1+') {
                $query->has('enrollments', '>=', 1);
            } elseif ($request->enrollments == '0') {
                $query->doesntHave('enrollments');
            }
        }

        // Sort
        $sortField = 'created_at';
        $sortDirection = 'desc';

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'oldest':
                    $sortField = 'created_at';
                    $sortDirection = 'asc';
                    break;
                case 'name_asc':
                    $sortField = 'name';
                    $sortDirection = 'asc';
                    break;
                case 'name_desc':
                    $sortField = 'name';
                    $sortDirection = 'desc';
                    break;
                case 'newest':
                default:
                    $sortField = 'created_at';
                    $sortDirection = 'desc';
                    break;
            }
        }

        $query->orderBy($sortField, $sortDirection);

        // Pagination
        $perPage = $request->get('per_page', 20);
        $students = $query->paginate($perPage)->withQueryString();

        // Statistics
        $stats = [
            'total_students' => User::role('student')->count(),
            'active_enrollments' => Enrollment::where('status', 'active')->count(),
            'completed_courses' => Enrollment::where('status', 'completed')->count(),
            'new_this_month' => User::role('student')
                ->where('created_at', '>=', now()->startOfMonth())
                ->count(),
        ];

        return view('admin.students.index', compact('students', 'stats'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'company' => $request->company,
            'job_title' => $request->job_title,
            'bio' => $request->bio,
            'email_verified_at' => now(),
        ];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('images/avatars', $filename, 'public');
            $data['avatar'] = $path;
        }

        $student = User::create($data);
        $student->assignRole('student'); // Always assign student role

        return redirect()->route('admin.students.index')
            ->with('success', 'Student created successfully.');
    }

    public function edit(User $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, User $student)
    {

        if ($request->has('remove_avatar')) {
            if ($student->avatar) {
                \Storage::disk('public')->delete($student->avatar);
                $student->update(['avatar' => null]);
            }
            return redirect()->route('admin.students.edit', $student)
                ->with('success', 'Avatar removed successfully.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only([
            'name',
            'email',
            'phone',
            'company',
            'job_title',
            'bio'
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($student->avatar) {
                \Storage::disk('public')->delete($student->avatar);
            }

            // Generate safe filename
            $file = $request->file('avatar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('images/avatars', $filename, 'public');
            $data['avatar'] = $path;
        }

        // Handle password update if provided
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $student->update($data);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(User $student)
    {
        // Delete avatar file if exists
        if ($student->avatar && file_exists(public_path('storage/' . $student->avatar))) {
            unlink(public_path('storage/' . $student->avatar));
        }

        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully.');
    }

    public function show(User $student)
    {
        // Ensure we're working with a student role
        if (!$student->hasRole('student')) {
            $student->assignRole('student');
        }

        // Eager load relationships for efficiency
        $student->load([
            'enrollments.course',
            'learningPaths' => function ($q) {
                $q->with(['items.course']);
            },
            'wishlists.course',
            'notes' => function ($q) {
                $q->with('creator')
                    ->visibleTo(auth()->id())
                    ->latest();
            }
        ]);

        // Get recent enrollments (last 5)
        $recentEnrollments = $student->enrollments()
            ->with('course')
            ->latest('enrolled_at')
            ->take(5)
            ->get();

        // Get active learning path (most recent)
        $activeLearningPath = $student->learningPaths()
            ->with(['items.course'])
            ->latest()
            ->first();

        // Calculate statistics
        $stats = [
            'total_enrollments' => $student->enrollments()->count(),
            'active_enrollments' => $student->enrollments()->where('status', 'active')->count(),
            'completed_courses' => $student->enrollments()->where('status', 'completed')->count(),
            'total_spent' => $student->enrollments()->sum('amount_paid') ?? 0,
            'total_learning_hours' => $student->enrollments()->sum('progress_percentage') * 0.5, // Approximate
            'average_progress' => round($student->enrollments()->avg('progress_percentage') ?? 0),
            'courses_in_wishlist' => $student->wishlists()->count(),
            'reviews_written' => $student->reviews()->count(),
        ];

        // Get course recommendations based on enrolled courses
        $recommendedCourses = collect([]);
        if ($student->enrollments()->count() > 0) {
            $enrolledCategoryIds = $student->enrollments()
                ->with('course.category')
                ->get()
                ->pluck('course.category_id')
                ->unique()
                ->filter() // Remove null values
                ->toArray();

            $recommendedCourses = Course::where('is_active', true)
                ->whereNotIn('id', $student->enrollments()->pluck('course_id'))
                ->when(!empty($enrolledCategoryIds), function ($q) use ($enrolledCategoryIds) {
                    $q->whereIn('category_id', $enrolledCategoryIds);
                })
                ->with('category')
                ->limit(4)
                ->get();
        }

        // Get recent activity (combined timeline)
        $recentActivity = collect();

        // Add enrollments to activity
        $student->enrollments()
            ->with('course')
            ->latest('enrolled_at')
            ->take(3)
            ->get()
            ->each(function ($enrollment) use ($recentActivity) {
                $recentActivity->push([
                    'type' => 'enrollment',
                    'title' => 'Enrolled in course',
                    'description' => $enrollment->course->title,
                    'date' => $enrollment->enrolled_at,
                    'icon' => 'fa-book-open',
                    'color' => 'blue'
                ]);
            });

        // Add progress updates to activity
        $student->enrollments()
            ->where('progress_percentage', '>', 0)
            ->latest('updated_at')
            ->take(3)
            ->get()
            ->each(function ($enrollment) use ($recentActivity) {
                $recentActivity->push([
                    'type' => 'progress',
                    'title' => 'Progress updated',
                    'description' => "{$enrollment->course->title}: {$enrollment->progress_percentage}% complete",
                    'date' => $enrollment->updated_at,
                    'icon' => 'fa-chart-line',
                    'color' => 'green'
                ]);
            });

        // Add completions to activity
        $student->enrollments()
            ->where('status', 'completed')
            ->latest('completed_at')
            ->take(3)
            ->get()
            ->each(function ($enrollment) use ($recentActivity) {
                $recentActivity->push([
                    'type' => 'completion',
                    'title' => 'Course completed',
                    'description' => $enrollment->course->title,
                    'date' => $enrollment->completed_at,
                    'icon' => 'fa-trophy',
                    'color' => 'purple'
                ]);
            });

        // Sort activity by date (newest first) and take 5
        $recentActivity = $recentActivity->sortByDesc('date')->take(5);

        return view('admin.students.show', compact(
            'student',
            'recentEnrollments',
            'activeLearningPath',
            'stats',
            'recommendedCourses',
            'recentActivity'
        ));
    }

    public function sendMessage(Request $request, User $student)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'subject' => 'nullable|string|max:255'
        ]);

        $admin = auth()->user();

        // Create message
        $message = Message::create([
            'sender_id' => $admin->id,
            'receiver_id' => $student->id,
            'subject' => $request->subject ?? 'Message from Admin',
            'message' => $request->message,
            'is_read' => false
        ]);

        // Create notification for student
        Notification::create([
            'user_id' => $student->id,
            'title' => '📩 New Message from Admin',
            'message' => $request->subject ?? 'You have received a new message from the administrator.',
            'type' => 'message',
            'data' => [
                'message_id' => $message->id,
                'sender_id' => $admin->id,
                'sender_name' => $admin->name
            ],
            'action_url' => route('messages.conversation', $admin->id),
            'action_text' => 'View Message',
            'is_read' => false
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully'
            ]);
        }

        return back()->with('success', 'Message sent successfully');
    }

    /**
     * Store a new note for a student
     */
    public function storeNote(Request $request, User $student)
    {
        $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        // FIXED: Properly detect checkbox value
        $isPrivate = $request->has('is_private') ? true : false;

        $note = StudentNote::create([
            'user_id' => $student->id,
            'created_by' => auth()->id(),
            'content' => $request->content,
            'is_private' => $isPrivate, // Use the fixed variable
        ]);

        return redirect()->route('admin.students.show', $student)
            ->with('success', 'Note added successfully.');
    }

    /**
     * Show form to edit a note
     */
    public function editNote(User $student, StudentNote $note)
    {
        // Check permission
        if ($note->created_by !== auth()->id()) {
            return redirect()->route('admin.students.show', $student)
                ->with('error', 'You can only edit your own notes.');
        }

        // Load student with all data for the view
        $student->load([
            'enrollments.course',
            'learningPaths' => function ($q) {
                $q->with(['items.course']);
            },
            'wishlists.course',
            'notes' => function ($q) {
                $q->with('creator')
                    ->visibleTo(auth()->id())
                    ->latest();
            }
        ]);

        $recentEnrollments = $student->enrollments()->with('course')->latest('enrolled_at')->take(5)->get();
        $activeLearningPath = $student->learningPaths()->with(['items.course'])->latest()->first();

        $stats = [
            'total_enrollments' => $student->enrollments()->count(),
            'active_enrollments' => $student->enrollments()->where('status', 'active')->count(),
            'completed_courses' => $student->enrollments()->where('status', 'completed')->count(),
            'total_spent' => $student->enrollments()->sum('amount_paid') ?? 0,
            'total_learning_hours' => $student->enrollments()->sum('progress_percentage') * 0.5,
            'average_progress' => round($student->enrollments()->avg('progress_percentage') ?? 0),
            'courses_in_wishlist' => $student->wishlists()->count(),
            'reviews_written' => $student->reviews()->count(),
        ];

        $recommendedCourses = collect([]);
        if ($student->enrollments()->count() > 0) {
            $enrolledCategoryIds = $student->enrollments()
                ->with('course.category')
                ->get()
                ->pluck('course.category_id')
                ->unique()
                ->filter()
                ->toArray();

            $recommendedCourses = Course::where('is_active', true)
                ->whereNotIn('id', $student->enrollments()->pluck('course_id'))
                ->when(!empty($enrolledCategoryIds), function ($q) use ($enrolledCategoryIds) {
                    $q->whereIn('category_id', $enrolledCategoryIds);
                })
                ->with('category')
                ->limit(4)
                ->get();
        }

        $recentActivity = collect();
        // ... activity collection logic (same as in show method) ...
        $student->enrollments()->with('course')->latest('enrolled_at')->take(3)->get()->each(function ($enrollment) use ($recentActivity) {
            $recentActivity->push(['type' => 'enrollment', 'title' => 'Enrolled in course', 'description' => $enrollment->course->title, 'date' => $enrollment->enrolled_at, 'icon' => 'fa-book-open', 'color' => 'blue']);
        });
        $student->enrollments()->where('progress_percentage', '>', 0)->latest('updated_at')->take(3)->get()->each(function ($enrollment) use ($recentActivity) {
            $recentActivity->push(['type' => 'progress', 'title' => 'Progress updated', 'description' => "{$enrollment->course->title}: {$enrollment->progress_percentage}% complete", 'date' => $enrollment->updated_at, 'icon' => 'fa-chart-line', 'color' => 'green']);
        });
        $student->enrollments()->where('status', 'completed')->latest('completed_at')->take(3)->get()->each(function ($enrollment) use ($recentActivity) {
            $recentActivity->push(['type' => 'completion', 'title' => 'Course completed', 'description' => $enrollment->course->title, 'date' => $enrollment->completed_at, 'icon' => 'fa-trophy', 'color' => 'purple']);
        });
        $recentActivity = $recentActivity->sortByDesc('date')->take(5);

        $editNote = $note;

        return view('admin.students.show', compact(
            'student',
            'recentEnrollments',
            'activeLearningPath',
            'stats',
            'recommendedCourses',
            'recentActivity',
            'editNote'
        ));
    }

    /**
     * Update a note
     */
    public function updateNote(Request $request, User $student, StudentNote $note)
    {
        if ($note->created_by !== auth()->id()) {
            return redirect()->route('admin.students.show', $student)
                ->with('error', 'You can only edit your own notes.');
        }

        $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        // FIXED: Properly detect checkbox value
        $isPrivate = $request->has('is_private') ? true : false;

        $note->update([
            'content' => $request->content,
            'is_private' => $isPrivate, // Use the fixed variable
        ]);

        return redirect()->route('admin.students.show', $student)
            ->with('success', 'Note updated successfully.');
    }

    /**
     * Delete a note
     */
    public function destroyNote(User $student, StudentNote $note)
    {
        if ($note->created_by !== auth()->id()) {
            return redirect()->route('admin.students.show', $student)
                ->with('error', 'You can only delete your own notes.');
        }

        $note->delete();

        return redirect()->route('admin.students.show', $student)
            ->with('success', 'Note deleted successfully.');
    }

    /**
     * Display student enrollments page
     */
    public function enrollments(Request $request, User $student)
    {
        // Ensure we're working with a student
        if (!$student->hasRole('student')) {
            $student->assignRole('student');
        }

        // Build query with search
        $query = $student->enrollments()
            ->with('course')
            ->latest('enrolled_at');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('enrollment_id', 'like', "%{$search}%")
                    ->orWhereHas('course', function ($cq) use ($search) {
                        $cq->where('title', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pagination
        $perPage = $request->get('per_page', 20);
        $enrollments = $query->paginate($perPage)->withQueryString();

        // Calculate statistics
        $stats = [
            'total' => $student->enrollments()->count(),
            'completed' => $student->enrollments()->where('status', 'completed')->count(),
            'active' => $student->enrollments()->where('status', 'active')->count(),
            'pending' => $student->enrollments()->where('status', 'pending')->count(),
            'cancelled' => $student->enrollments()->where('status', 'cancelled')->count(),
            'total_spent' => $student->enrollments()->sum('amount_paid'),
            'avg_progress' => round($student->enrollments()->avg('progress_percentage') ?? 0),
        ];

        return view('admin.students.enrollments', compact('student', 'enrollments', 'stats'));
    }

    /**
     * Enroll student in a course
     */
    public function enrollToCourse(Request $request, User $student)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'amount_paid' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string',
            'status' => 'nullable|in:pending,active,completed,cancelled',
        ]);

        $course = Course::findOrFail($request->course_id);

        // Check if already enrolled
        if ($student->enrollments()->where('course_id', $course->id)->exists()) {
            return back()->with('error', 'Student is already enrolled in this course.');
        }

        // Generate unique enrollment ID
        $enrollmentId = 'ENR-' . strtoupper(uniqid());

        $enrollment = $student->enrollments()->create([
            'course_id' => $course->id,
            'enrollment_id' => $enrollmentId,
            'amount_paid' => $request->amount_paid ?? ($course->discounted_price ?? $course->price),
            'payment_method' => $request->payment_method ?? 'manual',
            'status' => $request->status ?? 'active',
            'progress_percentage' => 0,
            'enrolled_at' => now(),
        ]);

        // Create notification for student
        Notification::createEnrollmentNotification($student->id, $course->title);

        return redirect()->route('admin.students.enrollments', $student)
            ->with('success', 'Student enrolled successfully in "' . $course->title . '".');
    }

    /**
     * Remove enrollment (delete)
     */
    public function destroyEnrollment(User $student, Enrollment $enrollment)
    {
        // Verify this enrollment belongs to the student
        if ($enrollment->user_id !== $student->id) {
            return back()->with('error', 'This enrollment does not belong to this student.');
        }

        $courseTitle = $enrollment->course->title;
        $enrollment->delete();

        return redirect()->route('admin.students.enrollments', $student)
            ->with('success', 'Enrollment for "' . $courseTitle . '" has been removed successfully.');
    }

    /**
     * Update enrollment status
     */
    public function updateEnrollmentStatus(Request $request, User $student, Enrollment $enrollment)
    {
        if ($enrollment->user_id !== $student->id) {
            return back()->with('error', 'This enrollment does not belong to this student.');
        }

        $request->validate([
            'status' => 'required|in:pending,active,completed,cancelled',
        ]);

        $enrollment->update([
            'status' => $request->status,
            'completed_at' => $request->status === 'completed' ? now() : null,
        ]);

        return redirect()->route('admin.students.enrollments', $student)
            ->with('success', 'Enrollment status updated successfully.');
    }

    /**
     * Generate AI-powered learning path for student
     */
    public function generateLearningPath(Request $request, User $student)
    {
        try {
            DB::beginTransaction();

            // 1. Get student's enrolled courses and interests
            $enrolledCourseIds = $student->enrollments()
                ->where('status', 'active')
                ->pluck('course_id')
                ->toArray();

            $completedCourseIds = $student->enrollments()
                ->where('status', 'completed')
                ->pluck('course_id')
                ->toArray();

            // 2. Get categories from enrolled/completed courses
            $interestedCategories = Course::whereIn('id', array_merge($enrolledCourseIds, $completedCourseIds))
                ->pluck('category_id')
                ->unique()
                ->toArray();

            // 3. Get courses from wishlist (high priority)
            $wishlistCourseIds = $student->wishlists()
                ->where('priority', '>=', 2)
                ->pluck('course_id')
                ->toArray();

            // 4. AI Algorithm: Find recommended courses
            $recommendedCourses = collect();

            // Priority 1: Courses from wishlist
            if (!empty($wishlistCourseIds)) {
                $wishlistCourses = Course::whereIn('id', $wishlistCourseIds)
                    ->where('is_active', true)
                    ->whereNotIn('id', array_merge($enrolledCourseIds, $completedCourseIds))
                    ->limit(3)
                    ->get();
                $recommendedCourses = $recommendedCourses->merge($wishlistCourses);
            }

            // Priority 2: Courses from same categories
            if ($recommendedCourses->count() < 5 && !empty($interestedCategories)) {
                $categoryCourses = Course::whereIn('category_id', $interestedCategories)
                    ->where('is_active', true)
                    ->whereNotIn('id', array_merge($enrolledCourseIds, $completedCourseIds, $wishlistCourseIds))
                    ->inRandomOrder()
                    ->limit(5 - $recommendedCourses->count())
                    ->get();
                $recommendedCourses = $recommendedCourses->merge($categoryCourses);
            }

            // Priority 3: Popular/Featured courses
            if ($recommendedCourses->count() < 5) {
                $popularCourses = Course::where('is_active', true)
                    ->where('is_featured', true)
                    ->whereNotIn('id', array_merge($enrolledCourseIds, $completedCourseIds, $wishlistCourseIds, $recommendedCourses->pluck('id')->toArray()))
                    ->orderBy('total_students', 'desc')
                    ->limit(5 - $recommendedCourses->count())
                    ->get();
                $recommendedCourses = $recommendedCourses->merge($popularCourses);
            }

            // Priority 4: Beginner level courses
            if ($recommendedCourses->count() < 5) {
                $beginnerCourses = Course::where('is_active', true)
                    ->where('level', 'beginner')
                    ->whereNotIn('id', array_merge($enrolledCourseIds, $completedCourseIds, $recommendedCourses->pluck('id')->toArray()))
                    ->limit(5 - $recommendedCourses->count())
                    ->get();
                $recommendedCourses = $recommendedCourses->merge($beginnerCourses);
            }

            // 5. Create Learning Path
            $pathTitle = 'AI Personalized Path - ' . now()->format('M d, Y');

            // Deactivate old active paths
            $student->learningPaths()
                ->where('is_ai_generated', true)
                ->where('progress_percentage', '<', 100)
                ->update(['progress_percentage' => -1]); // Mark as archived

            $learningPath = LearningPath::create([
                'user_id' => $student->id,
                'title' => $pathTitle,
                'description' => 'AI-generated learning path based on student interests and progress',
                'total_courses' => $recommendedCourses->count(),
                'completed_courses' => 0,
                'total_weeks' => $recommendedCourses->sum('duration_in_weeks') ?? $recommendedCourses->count() * 4,
                'progress_percentage' => 0,
                'next_milestone' => $recommendedCourses->first()->title ?? null,
                'is_ai_generated' => true,
                'goals' => [
                    'interested_categories' => $interestedCategories,
                    'generated_at' => now()->toDateTimeString(),
                    'recommended_based_on' => [
                        'enrolled' => count($enrolledCourseIds),
                        'completed' => count($completedCourseIds),
                        'wishlist' => count($wishlistCourseIds)
                    ]
                ],
                'estimated_completion_date' => now()->addWeeks($recommendedCourses->sum('duration_in_weeks') ?? $recommendedCourses->count() * 4),
            ]);

            // 6. Add courses to learning path
            foreach ($recommendedCourses as $index => $course) {
                $isFirstCourse = ($index === 0);

                LearningPathItem::create([
                    'learning_path_id' => $learningPath->id,
                    'course_id' => $course->id,
                    'position' => $index + 1,
                    'status' => $isFirstCourse ? 'active' : 'locked',
                    'progress' => 0,
                    'started_at' => $isFirstCourse ? now() : null,
                ]);
            }

            // 7. Create notification for student
            if ($student->id != auth()->id()) {
                Notification::create([
                    'user_id' => $student->id,
                    'title' => 'New AI Learning Path',
                    'message' => "An AI-powered learning path has been created for you with {$recommendedCourses->count()} recommended courses.",
                    'type' => 'system',
                    'action_url' => route('learning-path.show', $learningPath->id),
                    'action_text' => 'View Your Path',
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Learning path generated successfully!',
                'path_id' => $learningPath->id,
                'courses_count' => $recommendedCourses->count()
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate learning path: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk actions for students
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate',
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id'
        ]);

        $count = 0;
        $errors = [];

        foreach ($request->ids as $id) {
            $user = User::find($id);

            // Only affect students
            if (!$user->hasRole('student')) {
                continue;
            }

            if ($request->action == 'delete') {
                // Delete avatar if exists
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $user->delete();
                $count++;

            } elseif ($request->action == 'activate') {
                $user->update(['email_verified_at' => now()]);
                $count++;

            } elseif ($request->action == 'deactivate') {
                $user->update(['email_verified_at' => null]);
                $count++;
            }
        }

        $message = "{$count} student(s) updated successfully.";
        if (!empty($errors)) {
            $message .= " " . implode('. ', $errors);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'count' => $count
        ]);
    }
}