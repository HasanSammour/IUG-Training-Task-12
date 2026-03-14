<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\Enrollment;
use App\Models\LearningPathItem;
use App\Models\Notification;
use App\Models\CourseSession;
use App\Models\CourseAssignment;
use App\Models\CourseMaterial;
use App\Models\CourseReview;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use App\Models\Wishlist;
use Carbon\Carbon;

class CourseController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of public courses.
     */
    public function index(Request $request)
    {
        $query = Course::where('is_active', true)
            ->with('category')
            ->withCount('enrollments');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('instructor_name', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by level
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // Filter by format
        if ($request->filled('format')) {
            $query->where('format', $request->format);
        }

        // Filter by status (for admin/instructor)
        if (Auth::check() && (Auth::user()->hasRole('admin') || Auth::user()->hasRole('instructor'))) {
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
        } else {
            // For students/guests, only show active courses
            $query->where('is_active', true);
        }

        // Sort
        switch ($request->sort) {
            case 'popular':
                $query->orderByDesc('enrollments_count');
                break;
            case 'price_low':
                $query->orderBy('price');
                break;
            case 'price_high':
                $query->orderByDesc('price');
                break;
            case 'rating':
                $query->orderByDesc('rating');
                break;
            case 'newest':
                $query->latest();
                break;
            default:
                $query->orderBy('title');
                break;
        }
            
        $courses = $query->paginate(12)->withQueryString();
            
        // Load counts for each course
        foreach ($courses as $course) {
            $course->sessions_count = CourseSession::where('course_id', $course->id)->count();
            $course->assignments_count = CourseAssignment::where('course_id', $course->id)->count();
            $course->materials_count = CourseMaterial::where('course_id', $course->id)->count();
        }
            
        $categories = Category::all();
        $levels = ['beginner', 'intermediate', 'advanced'];
        $formats = ['online', 'in-person', 'hybrid'];
            
        // Get wishlist count for authenticated user
        $wishlistCount = 0;
        $wishlistItems = [];
        if (Auth::check() && !Auth::user()->hasRole('admin') && !Auth::user()->hasRole('instructor')) {
            $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
            
            // Also get the IDs of courses in wishlist for heart icons
            $wishlistItems = Wishlist::where('user_id', Auth::id())
                ->pluck('course_id')
                ->toArray();
        }
            
        return view('public.courses', compact(
            'courses', 
            'categories', 
            'levels', 
            'formats', 
            'wishlistCount', 
            'wishlistItems'
        ));
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course)
    {
        if (!$course->is_active) {
            abort(404);
        }

        $course->load('category');
        
        // Load counts
        $course->sessions_count = CourseSession::where('course_id', $course->id)->count();
        $course->assignments_count = CourseAssignment::where('course_id', $course->id)->count();
        $course->materials_count = CourseMaterial::where('course_id', $course->id)->count();
        
        // Get approved reviews for this course
        $reviews = CourseReview::where('course_id', $course->id)
            ->where('is_approved', true)
            ->with('user')
            ->latest()
            ->paginate(10);
        
        // Calculate rating stats
        $ratingStats = [
            'average' => CourseReview::where('course_id', $course->id)->where('is_approved', true)->avg('rating') ?? 0,
            'total' => CourseReview::where('course_id', $course->id)->where('is_approved', true)->count(),
            'distribution' => CourseReview::where('course_id', $course->id)
                ->where('is_approved', true)
                ->selectRaw('rating, COUNT(*) as count')
                ->groupBy('rating')
                ->orderBy('rating', 'desc')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->rating => $item->count];
                }),
        ];
        
        // Check if user can review (enrolled and completed)
        $canReview = false;
        $userReview = null;
        
        if (Auth::check()) {
            $enrollment = Auth::user()->enrollments()
                ->where('course_id', $course->id)
                ->first();
            
            $canReview = $enrollment && $enrollment->status == 'completed';
            
            $userReview = CourseReview::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->first();
        }

        // Check if user is enrolled
        $isEnrolled = false;
        $enrollment = null;
        
        if (Auth::check()) {
            $enrollment = Auth::user()->enrollments()
                ->where('course_id', $course->id)
                ->first();
            $isEnrolled = $enrollment !== null;
        }

        // Get related courses
        $relatedCourses = Course::where('is_active', true)
            ->where('id', '!=', $course->id)
            ->where('category_id', $course->category_id)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('public.course-details', compact(
            'course', 
            'isEnrolled', 
            'enrollment', 
            'relatedCourses',
            'reviews',
            'ratingStats',
            'canReview',
            'userReview'
        ));
    }

    /**
     * Show course registration page.
     */
    public function registration(Course $course)
    {
        if (!$course->is_active) {
            abort(404);
        }

        // Check if already enrolled
        $enrollment = Auth::user()->enrollments()
            ->where('course_id', $course->id)
            ->first();

        if ($enrollment) {
            return redirect()->route('courses.progress', $enrollment->id)->with('info', 'You are already enrolled in this course.');
        }

        return view('public.registration', compact('course'));
    }
            
    /**
     * Process course registration.
     */
    public function processRegistration(Request $request, Course $course)
    {
        if (!$course->is_active) {
            abort(404);
        }

        $user = Auth::user();

        // Check if already enrolled
        $existingEnrollment = $user->enrollments()
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return redirect()->route('courses.progress', $existingEnrollment->id)->with('info', 'You are already enrolled in this course.');
        }

        // Validate registration data
        $request->validate([
            'payment_method' => 'required|in:card,paypal',
            'terms' => 'required|accepted',
        ]);

        // Calculate amount paid (random between price and discounted price)
        $fullPrice = $course->price;
        $discountedPrice = $course->discounted_price ?? $course->price;
        $amountPaid = rand(min($discountedPrice, $fullPrice) * 100, max($discountedPrice, $fullPrice) * 100) / 100;

        // Create enrollment
        $enrollmentId = 'ENR-' . strtoupper(substr(uniqid(), -8));
                
        $enrollment = Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'enrollment_id' => $enrollmentId,
            'amount_paid' => $amountPaid,
            'payment_method' => $request->payment_method,
            'status' => Enrollment::STATUS_PENDING,
            'progress_percentage' => 0,
            'enrolled_at' => now(),
        ]);

        // Update learning path if exists
        $this->updateLearningPathOnEnrollment($user, $course);

        // Create notification
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Enrollment Confirmed',
            'message' => "You're now enrolled in '{$course->title}'. Start learning today!",
            'type' => 'enrollment',
            'data' => ['course_id' => $course->id],
            'action_url' => route('courses.progress', $enrollment->id),
            'action_text' => 'Start Learning',
            'is_read' => false,
        ]);

        return redirect()->route('courses.progress', $enrollment->id)
            ->with('success', 'Enrollment successful! Start your learning journey now.');
    }

    
    /**
     * Quick free enrollment (for free courses).
     */
    public function freeEnrollment(Request $request, Course $course)
    {
        if (!$course->is_active) {
            abort(404);
        }

        // Check if course is actually free
        if ($course->price > 0 && ($course->discounted_price ?? $course->price) > 0) {
            return response()->json(['error' => 'This course is not free'], 400);
        }

        $user = Auth::user();

        // Check if already enrolled
        $existingEnrollment = $user->enrollments()
            ->where('course_id', $course->id)
            ->first();

        if ($existingEnrollment) {
            return response()->json([
                'success' => false,
                'message' => 'Already enrolled',
                'redirect' => route('courses.progress', $existingEnrollment->id)
            ]);
        }

        // Create enrollment
        $enrollmentId = 'ENR-' . strtoupper(substr(uniqid(), -8));
                
        $enrollment = Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'enrollment_id' => $enrollmentId,
            'amount_paid' => 0,
            'payment_method' => 'free',
            'status' => 'active',
            'progress_percentage' => 0,
            'enrolled_at' => now(),
        ]);

        // Update learning path
        $this->updateLearningPathOnEnrollment($user, $course);

        // Create notification
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Course Started',
            'message' => "You've started '{$course->title}'. Good luck!",
            'type' => 'enrollment',
            'data' => ['course_id' => $course->id],
            'action_url' => route('courses.progress', $enrollment->id),
            'action_text' => 'Continue',
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Course started successfully',
            'redirect' => route('courses.progress', $enrollment->id)
        ]);
    }   

    /**
     * Display user's enrolled courses.
     */
    public function myCourses()
    {
        $user = Auth::user();
                
        $enrollments = $user->enrollments()
            ->with([
                'course' => function($q) {
                    $q->with('category')
                      ->withCount('sessions')
                      ->withCount('assignments')
                      ->withCount(['reviews' => function($r) {
                          $r->where('user_id', Auth::id());
                      }]);
                }
            ])
            ->latest('enrolled_at')
            ->paginate(9);
                
        // Updated stats with all statuses
        $stats = [
            'total' => $user->enrollments()->count(),
            'active' => $user->enrollments()->where('status', Enrollment::STATUS_ACTIVE)->count(),
            'completed' => $user->enrollments()->where('status', Enrollment::STATUS_COMPLETED)->count(),
            'pending' => $user->enrollments()->where('status', Enrollment::STATUS_PENDING)->count(),
            'cancelled' => $user->enrollments()->where('status', Enrollment::STATUS_CANCELLED)->count(),
            'total_hours' => $user->enrollments()->with('course')->get()->sum(function($e) {
                return intval(preg_replace('/[^0-9]/', '', $e->course->duration ?? '0')) ?: 0;
            }),
        ];
                
        return view('user.my-courses', compact('enrollments', 'stats'));
    }
    /**
     * Get all reviews for a course.
     */
    public function reviews(Course $course)
    {
        if (Auth::check()) {
            $enrollment = Auth::user()->enrollments()
                ->where('course_id', $course->id)
                ->first();
            
            $canReview = $enrollment && $enrollment->status == 'completed';
            $userReview = CourseReview::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->first();
        } else {
            $canReview = false;
            $userReview = null;
        }

        $reviews = CourseReview::where('course_id', $course->id)
            ->where('is_approved', true)
            ->with('user')
            ->latest()
            ->paginate(20);

        $ratingStats = [
            'average' => CourseReview::where('course_id', $course->id)->where('is_approved', true)->avg('rating') ?? 0,
            'total' => CourseReview::where('course_id', $course->id)->where('is_approved', true)->count(),
            'distribution' => CourseReview::where('course_id', $course->id)
                ->where('is_approved', true)
                ->selectRaw('rating, COUNT(*) as count')
                ->groupBy('rating')
                ->orderBy('rating', 'desc')
                ->get()
                ->mapWithKeys(function ($item) {
                    return [$item->rating => $item->count];
                }),
        ];

        return view('public.reviews', compact('course', 'reviews', 'ratingStats', 'canReview', 'userReview'));
    }

    /**
     * Store a new review.
     */
    public function storeReview(Request $request, Course $course)
    {
        $user = Auth::user();

        // Check if enrolled and completed
        $enrollment = $user->enrollments()
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment || $enrollment->status != 'completed') {
            return response()->json(['error' => 'You must complete the course before reviewing'], 403);
        }

        // Check if already reviewed
        $existingReview = CourseReview::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingReview) {
            return response()->json(['error' => 'You have already reviewed this course'], 400);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|min:10|max:2000',
        ]);

        $review = CourseReview::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'is_approved' => false, // Requires admin approval
        ]);

        // Notify instructor and admin
        $instructor = User::where('name', $course->instructor_name)->first();
        
        if ($instructor) {
            Notification::create([
                'user_id' => $instructor->id,
                'title' => 'New Course Review',
                'message' => "{$user->name} reviewed '{$course->title}' with {$request->rating} stars",
                'type' => 'review',
                'data' => [
                    'review_id' => $review->id,
                    'course_id' => $course->id,
                    'rating' => $request->rating,
                ],
                'action_url' => route('instructor.course-students', $course->id),
                'action_text' => 'View Review',
                'is_read' => false,
            ]);
        }

        // Notify admins
        $admins = User::role('admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'New Review Needs Approval',
                'message' => "{$user->name} reviewed '{$course->title}'. Review pending approval.",
                'type' => 'review',
                'data' => [
                    'review_id' => $review->id,
                    'course_id' => $course->id,
                ],
                'action_url' => route('admin.reviews.show', $review->id),
                'action_text' => 'Approve Review',
                'is_read' => false,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully! It will be visible after admin approval.',
            'review' => $review
       ]);
   }
           
   /**
     * Update a review.
     */
    public function updateReview(Request $request, Course $course, CourseReview $review)
    {
        if ($review->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: You do not own this review'
            ], 403);
        }

        if ($review->is_approved) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot edit approved review. Please contact admin.'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|min:10|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $review->update([
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review updated successfully',
            'review' => $review
        ]);
    }

    /**
     * Delete a review.
     */
    public function destroyReview(Course $course, CourseReview $review)
    {
        if ($review->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully'
        ]);
    }

    /**
     * Mark a review as helpful.
     */
    public function markHelpful(Course $course, CourseReview $review)
    {
        $review->markHelpful();
        
        return response()->json([
            'success' => true,
            'helpful_count' => $review->helpful_count
        ]);
    }

    /**
     * Mark a review as not helpful.
     */
    public function markNotHelpful(Course $course, CourseReview $review)
    {
        $review->markNotHelpful();
        
        return response()->json([
            'success' => true,
            'not_helpful_count' => $review->not_helpful_count
        ]);
    }

    /**
     * Get user's wishlist.
     */
    public function wishlist()
    {
        $user = Auth::user();
                
        $wishlistItems = Wishlist::where('user_id', $user->id)
            ->with('course')
            ->orderByDesc('priority')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
                
        // Load counts for each course
        foreach ($wishlistItems as $item) {
            $course = $item->course;
            $course->sessions_count = CourseSession::where('course_id', $course->id)->count();
            $course->assignments_count = CourseAssignment::where('course_id', $course->id)->count();
            $course->materials_count = CourseMaterial::where('course_id', $course->id)->count();
        }
                
        $stats = [
            'total' => Wishlist::where('user_id', $user->id)->count(),
            'high_priority' => Wishlist::where('user_id', $user->id)->where('priority', '>=', 3)->count(),
            'with_reminders' => Wishlist::where('user_id', $user->id)->whereNotNull('reminder_date')->count(),
            'due_reminders' => Wishlist::where('user_id', $user->id)
                ->whereNotNull('reminder_date')
                ->where('reminder_date', '<=', now()->addDays(3))
                ->count(),
        ];
                
        return view('user.wishlist', compact('wishlistItems', 'stats'));
    }

    /**
     * Add course to wishlist.
     */
    public function addToWishlist(Course $course)
    {
        $user = Auth::user();
                
        // Check if already in wishlist
        $exists = Wishlist::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->exists();
                
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Course already in your wishlist'
            ], 400);
        }
                
        // Add to wishlist
        $wishlist = Wishlist::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'priority' => 2, // Default medium priority
            'created_at' => now(),
        ]);
                
        // Get updated wishlist count
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();
                
        return response()->json([
            'success' => true,
            'message' => 'Course added to wishlist',
            'wishlist' => $wishlist,
            'wishlist_count' => $wishlistCount
        ]);
    }

    /**
     * Remove course from wishlist.
     */
    public function removeFromWishlist(Course $course)
    {
        $user = Auth::user();
                
        $deleted = Wishlist::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->delete();
                
        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Course not found in wishlist'
            ], 404);
        }
                
        $wishlistCount = Wishlist::where('user_id', $user->id)->count();
                
        return response()->json([
            'success' => true,
            'message' => 'Course removed from wishlist',
            'wishlist_count' => $wishlistCount
        ]);
    }

    /**
     * Update wishlist item priority.
     */
    public function updatePriority(Request $request, Wishlist $wishlist)
    {
        if ($wishlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
                
        $request->validate([
            'priority' => 'required|integer|min:1|max:4'
        ]);
                
        $wishlist->update(['priority' => $request->priority]);
                
        return response()->json([
            'success' => true,
            'message' => 'Priority updated',
            'priority_text' => $wishlist->priority_text
        ]);
    }

    /**
     * Set reminder for wishlist item.
     */
    public function setReminder(Request $request, Wishlist $wishlist)
    {
        if ($wishlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
                
        $request->validate([
            'reminder_date' => 'required|date|after:today'
        ]);
                
        $wishlist->update(['reminder_date' => Carbon::parse($request->reminder_date)]);
                
        return response()->json([
            'success' => true,
            'message' => 'Reminder set for ' . Carbon::parse($request->reminder_date)->format('M d, Y'),
            'reminder_date' => $wishlist->reminder_date->format('Y-m-d')
        ]);
    }

    /**
     * Clear reminder from wishlist.
     */
    public function clearReminder(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
                
        $wishlist->update(['reminder_date' => null]);
                
        return response()->json([
            'success' => true,
            'message' => 'Reminder cleared'
        ]);
    }

    /**
     * Move wishlist item to enrollment.
     */
    public function wishlistToEnrollment(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
                
        $course = $wishlist->course;
                
        // Check if already enrolled
        $existingEnrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->first();
                
        if ($existingEnrollment) {
            $wishlist->delete();
            return response()->json([
                'success' => true,
                'redirect' => route('courses.progress', $existingEnrollment->id),
                'message' => 'You are already enrolled in this course'
            ]);
        }
                
        // Create enrollment (pending payment)
        $enrollmentId = 'ENR-' . strtoupper(substr(uniqid(), -8));
                
        $enrollment = Enrollment::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'enrollment_id' => $enrollmentId,
            'amount_paid' => $course->final_price,
            'payment_method' => 'pending',
            'status' => 'pending',
            'progress_percentage' => 0,
            'enrolled_at' => now(),
        ]);
                
        // Remove from wishlist
        $wishlist->delete();
                
        return response()->json([
            'success' => true,
            'message' => 'Redirecting to registration...',
            'redirect' => route('courses.registration', $course->slug)
        ]);
    }

    /**
     * Check if course is in user's wishlist (AJAX helper).
     */
    public function checkWishlist(Course $course)
    {
        if (!Auth::check()) {
            return response()->json(['in_wishlist' => false]);
        }
                
        $inWishlist = Wishlist::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->exists();
                
        return response()->json(['in_wishlist' => $inWishlist]);
    }

    /**
     * Request certificate (NEW)
     */
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

    /**
     * Get course suggestions.
     */
    // public function getSuggestions(Request $request)
    // {
    //     $query = Course::where('is_active', true)
    //         ->with('category');

    //     if ($request->filled('category')) {
    //         $query->where('category_id', $request->category);
    //     }

    //     if ($request->filled('level')) {
    //         $query->where('level', $request->level);
    //     }

    //     if ($request->filled('search')) {
    //         $search = $request->search;
    //         $query->where(function($q) use ($search) {
    //             $q->where('title', 'like', "%{$search}%")
    //               ->orWhere('description', 'like', "%{$search}%");
    //         });
    //     }

    //     $courses = $query->inRandomOrder()->limit(6)->get();

    //     return response()->json([
    //         'courses' => $courses->map(function($course) {
    //             return [
    //                 'id' => $course->id,
    //                 'title' => $course->title,
    //                 'slug' => $course->slug,
    //                 'level' => $course->level,
    //                 'duration' => $course->duration,
    //                 'image' => $course->image_url,
    //                 'price' => $course->formatted_price,
    //                 'category' => $course->category?->name,
    //             ];
    //         })
    //     ]);
    // }

    /**
     * Filter courses.
     */
    // public function filter(Request $request)
    // {
    //     $query = Course::where('is_active', true)->with('category');

    //     if ($request->filled('category')) {
    //         $query->where('category_id', $request->category);
    //     }

    //     if ($request->filled('level')) {
    //         $query->where('level', $request->level);
    //     }

    //     if ($request->filled('format')) {
    //         $query->where('format', $request->format);
    //     }

    //     if ($request->filled('price_min')) {
    //         $query->where('price', '>=', $request->price_min);
    //     }

    //     if ($request->filled('price_max')) {
    //         $query->where('price', '<=', $request->price_max);
    //     }

    //     if ($request->filled('search')) {
    //         $search = $request->search;
    //         $query->where(function($q) use ($search) {
    //             $q->where('title', 'like', "%{$search}%")
    //               ->orWhere('description', 'like', "%{$search}%");
    //         });
    //     }

    //     $courses = $query->paginate(12);

    //     return response()->json([
    //         'courses' => $courses->items(),
    //         'pagination' => [
    //             'current_page' => $courses->currentPage(),
    //             'last_page' => $courses->lastPage(),
    //             'per_page' => $courses->perPage(),
    //             'total' => $courses->total(),
    //         ]
    //     ]);
    // }

    // Get Admin Users for Modal In Course Details
    public function getAdmins()
    {
        $admins = User::role('admin')->get(['id', 'name', 'avatar']);
                
        return response()->json([
            'success' => true,
            'admins' => $admins
        ]);
    }

    /**
     * Private helper methods
     */
    private function updateLearningPathOnEnrollment($user, $course)
    {
        $learningPath = $user->learningPaths()->first();
        
        if ($learningPath) {
            $item = $learningPath->items()->where('course_id', $course->id)->first();
            
            if (!$item) {
                // Add to learning path if not exists
                $maxPosition = $learningPath->items()->max('position') ?? 0;
                LearningPathItem::create([
                    'learning_path_id' => $learningPath->id,
                    'course_id' => $course->id,
                    'position' => $maxPosition + 1,
                    'status' => 'active',
                    'progress' => 0,
                    'estimated_hours' => intval(preg_replace('/[^0-9]/', '', $course->duration ?? '0')) ?: 10,
                ]);
                
                $learningPath->increment('total_courses');
            } else if ($item->status === 'locked') {
                $item->update(['status' => 'active']);
            }
        }
    }
}