<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\CourseController as PublicCourseController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\LearningPathController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\MessageController;
use App\Http\Controllers\User\ContactsController;
use App\Http\Controllers\User\AssignmentController;
use App\Http\Controllers\User\CourseProgressController;
use App\Http\Controllers\User\SessionController as UserSessionController;
use App\Http\Controllers\User\CourseMaterialController as UserCourseMaterialController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Instructor\DashboardController as InstructorDashboardController;
use App\Http\Controllers\Instructor\CourseSessionController;
use App\Http\Controllers\Instructor\BulkActionController;
use App\Http\Controllers\Instructor\CourseAssignmentController;
use App\Http\Controllers\Instructor\CourseMaterialController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->middleware('essential.data')  // Check for essential Data in home page
    ->name('home');

Route::get('/courses', [PublicCourseController::class, 'index'])->name('courses.public');
Route::get('/courses/{course:slug}', [PublicCourseController::class, 'show'])->name('courses.show');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::post('/avatar', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
        Route::post('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
        Route::put('/settings', [ProfileController::class, 'updateSettings'])->name('settings.update');
    });

    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('read-all');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::delete('/', [NotificationController::class, 'clearAll'])->name('clear-all');
    });

    // Messages System
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/inbox', [MessageController::class, 'inbox'])->name('inbox');
        Route::get('/sent', [MessageController::class, 'sent'])->name('sent');
        Route::get('/compose/{otherUser?}', [MessageController::class, 'compose'])->name('compose');
        Route::post('/send', [MessageController::class, 'send'])->name('send');
        Route::get('/conversation/{otherUser}', [MessageController::class, 'conversation'])->name('conversation');
        Route::post('/conversation/{otherUser}/send', [MessageController::class, 'sendReply'])->name('send-reply');
        Route::get('/conversation/{otherUser}/new', [MessageController::class, 'getNewMessages'])->name('new-messages');
        Route::post('/{message}/read', [MessageController::class, 'markAsRead'])->name('read');
        Route::post('/send-to-admin', [MessageController::class, 'sendToAdmin'])->name('send-to-admin');
        Route::delete('/{message}', [MessageController::class, 'destroy'])->name('destroy');
    });

    // Contacts Page
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [ContactsController::class, 'index'])->name('index');
        Route::get('/search', [ContactsController::class, 'search'])->name('search');
    });
});

/*
|--------------------------------------------------------------------------
| Students Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:student'])->group(function () {
    // Student Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware(['auth', 'verified', 'permission:access_student_dashboard']);

    // Learning Path
    Route::prefix('learning-path')->name('learning-path.')->group(function () {
        Route::get('/', [LearningPathController::class, 'index'])->name('index');
        Route::get('/{learningPath}', [LearningPathController::class, 'show'])->name('show');
        Route::delete('/{learningPath}', [LearningPathController::class, 'destroy'])->name('delete');
        Route::post('/{course}/start', [LearningPathController::class, 'startCourse'])->name('start');
        Route::post('/generate', [LearningPathController::class, 'generate'])->name('generate');
        Route::get('/sessions/upcoming', [LearningPathController::class, 'upcomingSessions'])->name('sessions.upcoming');
        Route::get('/sessions/past', [LearningPathController::class, 'pastSessions'])->name('sessions.past');
    });

    // Student Courses
    Route::prefix('my-courses')->name('courses.')->group(function () {
        Route::get('/', [PublicCourseController::class, 'myCourses'])->name('my-courses');
        Route::get('/{enrollment}', [CourseProgressController::class, 'show'])->name('progress');
    });

    // Course Registration/Enrollment
    Route::prefix('courses')->name('courses.')->group(function () {
        Route::get('/{course:slug}/register', [PublicCourseController::class, 'registration'])->name('registration');
        Route::post('/{course}/register', [PublicCourseController::class, 'processRegistration'])->name('register.process');
        Route::post('/{course}/free-enroll', [PublicCourseController::class, 'freeEnrollment'])->name('free-enroll');
    });

    // Certificate Request Route
    Route::post('/courses/{enrollment}/request-certificate', [CourseProgressController::class, 'requestCertificate'])->name('courses.request-certificate');

    // Student Sessions Routes
    Route::prefix('courses/{course}/sessions')->name('courses.sessions.')->group(function () {
        Route::get('/', [UserSessionController::class, 'index'])->name('index');
        Route::get('/{session}', [UserSessionController::class, 'show'])->name('show');
        Route::get('/{session}/join', [UserSessionController::class, 'join'])->name('join');
    });

    // Student Materials Routes
    Route::prefix('courses/{course}/materials')->name('courses.materials.')->group(function () {
        Route::get('/', [UserCourseMaterialController::class, 'index'])->name('index');
        Route::get('/{material}', [UserCourseMaterialController::class, 'show'])->name('show'); // Add this
        Route::get('/{material}/download', [UserCourseMaterialController::class, 'download'])->name('download');
    });

    // Student Assignments Routes
    Route::prefix('courses/{course}/assignments')->name('courses.assignments.')->group(function () {
        Route::get('/', [AssignmentController::class, 'index'])->name('index');
        Route::get('/{assignment}', [AssignmentController::class, 'show'])->name('show'); // Add this
        Route::post('/{assignment}/submit', [AssignmentController::class, 'submit'])->name('submit');
        Route::get('/submission/{submission}/download', [AssignmentController::class, 'downloadFile'])->name('download');
    });

    // Course Reviews Routes
    Route::prefix('courses/{course}/reviews')->name('courses.reviews.')->group(function () {
        Route::get('/', [PublicCourseController::class, 'reviews'])->name('index');
        Route::post('/', [PublicCourseController::class, 'storeReview'])->name('store');
        Route::get('/{review}/edit', [PublicCourseController::class, 'editReview'])->name('edit');
        Route::put('/{review}', [PublicCourseController::class, 'updateReview'])->name('update');
        Route::delete('/{review}', [PublicCourseController::class, 'destroyReview'])->name('destroy');
        Route::post('/{review}/helpful', [PublicCourseController::class, 'markHelpful'])->name('helpful');
        Route::post('/{review}/not-helpful', [PublicCourseController::class, 'markNotHelpful'])->name('not-helpful');
    });

    // Wishlist Routes
    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [PublicCourseController::class, 'wishlist'])->name('index');
        Route::post('/add/{course}', [PublicCourseController::class, 'addToWishlist'])->name('add');
        Route::delete('/remove/{course}', [PublicCourseController::class, 'removeFromWishlist'])->name('remove');
        Route::patch('/{wishlist}/priority', [PublicCourseController::class, 'updatePriority'])->name('priority');
        Route::post('/{wishlist}/reminder', [PublicCourseController::class, 'setReminder'])->name('reminder');
        Route::delete('/{wishlist}/reminder', [PublicCourseController::class, 'clearReminder'])->name('clear-reminder');
        Route::post('/{wishlist}/enroll', [PublicCourseController::class, 'wishlistToEnrollment'])->name('enroll');
    });

    // Complete onboarding route
    Route::post('/complete-onboarding', function () {
        $user = Auth::user();
        if ($user) {
            $user->update([
                'onboarding_completed' => true,
                'onboarding_shown_at' => now(),
            ]);

            // Clear ALL session flags
            session()->forget('show_onboarding');
            session()->forget('show_onboarding_dashboard');
            session()->forget('onboarding_shown_in_session');

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 401);
    })->middleware('auth')->name('onboarding.complete');

    Route::get('/admins-list', [CourseController::class, 'getAdmins'])->name('admins.list');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware(['auth', 'verified', 'permission:access_admin_dashboard']);

    Route::get('/menu', [AdminDashboardController::class, 'menu'])->name('menu');

    // Courses Management
    Route::prefix('courses')->name('courses.')->group(function () {
        Route::get('/', [AdminCourseController::class, 'index'])->name('index');
        Route::get('/create', [AdminCourseController::class, 'create'])->name('create');
        Route::post('/', [AdminCourseController::class, 'store'])->name('store');
        Route::get('/{course}/edit', [AdminCourseController::class, 'edit'])->name('edit');
        Route::put('/{course}', [AdminCourseController::class, 'update'])->name('update');
        Route::delete('/{course}', [AdminCourseController::class, 'destroy'])->name('destroy');
        Route::post('/{course}/toggle-featured', [AdminCourseController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::post('/{course}/toggle-active', [AdminCourseController::class, 'toggleActive'])->name('toggle-active');
        Route::get('/{course}/enrollments', [AdminCourseController::class, 'enrollments'])->name('enrollments');
    });

    // Reviews Management
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [AdminCourseController::class, 'reviews'])->name('index');
        Route::get('/{review}', [AdminCourseController::class, 'showReview'])->name('show');
        Route::post('/{review}/toggle-approval', [AdminCourseController::class, 'toggleApproval'])->name('toggle-approval');
        Route::delete('/{review}', [AdminCourseController::class, 'destroyReview'])->name('destroy');
        Route::post('/bulk-approve', [AdminCourseController::class, 'bulkApprove'])->name('bulk-approve');
        Route::get('/course/{course}', [AdminCourseController::class, 'getCourseReviews'])->name('course');
    });

    // Students Management
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [AdminStudentController::class, 'index'])->name('index');
        Route::get('/create', [AdminStudentController::class, 'create'])->name('create');
        Route::post('/', [AdminStudentController::class, 'store'])->name('store');
        Route::get('/{student}', [AdminStudentController::class, 'show'])->name('show');
        Route::get('/{student}/edit', [AdminStudentController::class, 'edit'])->name('edit');
        Route::put('/{student}', [AdminStudentController::class, 'update'])->name('update');
        Route::delete('/{student}', [AdminStudentController::class, 'destroy'])->name('destroy');
        Route::post('/{student}/notes', [AdminStudentController::class, 'storeNote'])->name('notes.store');
        Route::get('/{student}/notes', [AdminStudentController::class, 'getNotes'])->name('notes.index');
        Route::get('/{student}/notes/{note}/edit', [AdminStudentController::class, 'editNote'])->name('notes.edit');
        Route::put('/{student}/notes/{note}', [AdminStudentController::class, 'updateNote'])->name('notes.update');
        Route::delete('/{student}/notes/{note}', [AdminStudentController::class, 'destroyNote'])->name('notes.destroy');
        Route::get('/{student}/enrollments', [AdminStudentController::class, 'enrollments'])->name('enrollments');
        Route::post('/{student}/enroll', [AdminStudentController::class, 'enrollToCourse'])->name('enroll-to-course');
        Route::delete('/{student}/enrollments/{enrollment}', [AdminStudentController::class, 'destroyEnrollment'])->name('enrollments.destroy');
        Route::patch('/{student}/enrollments/{enrollment}/status', [AdminStudentController::class, 'updateEnrollmentStatus'])->name('enrollments.status');
        Route::post('/{student}/learning-path/generate', [AdminStudentController::class, 'generateLearningPath'])->name('learning-path.generate');
        Route::post('/bulk-action', [AdminStudentController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/{student}/send-message', [AdminStudentController::class, 'sendMessage'])->name('send-message');
    });

    // Staff Management
    Route::prefix('staff')->name('staff.')->group(function () {
        Route::get('/', [StaffController::class, 'index'])->name('index');
        Route::get('/create', [StaffController::class, 'create'])->name('create');
        Route::post('/', [StaffController::class, 'store'])->name('store');
        Route::get('/{staff}', [StaffController::class, 'show'])->name('show');
        Route::get('/{staff}/edit', [StaffController::class, 'edit'])->name('edit');
        Route::put('/{staff}', [StaffController::class, 'update'])->name('update');
        Route::delete('/{staff}', [StaffController::class, 'destroy'])->name('destroy');
        Route::post('/{staff}/verify-email', [StaffController::class, 'verifyEmail'])->name('verify-email');
        Route::post('/{staff}/reset-password', [StaffController::class, 'sendResetLink'])->name('reset-password');
        Route::post('/{staff}/toggle-status', [StaffController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/bulk-action', [StaffController::class, 'bulkAction'])->name('bulk-action');
    });

    // Enrollments Management
    Route::prefix('enrollments')->name('enrollments.')->group(function () {
        Route::get('/', [EnrollmentController::class, 'index'])->name('index');
        Route::get('/create', [EnrollmentController::class, 'create'])->name('create');
        Route::post('/', [EnrollmentController::class, 'store'])->name('store');
        Route::get('/{enrollment}', [EnrollmentController::class, 'show'])->name('show');
        Route::get('/{enrollment}/edit', [EnrollmentController::class, 'edit'])->name('edit');
        Route::put('/{enrollment}', [EnrollmentController::class, 'update'])->name('update');
        Route::delete('/{enrollment}', [EnrollmentController::class, 'destroy'])->name('destroy');
        Route::post('/{enrollment}/update-status', [EnrollmentController::class, 'updateStatus'])->name('update-status');
        Route::post('/{enrollment}/update-progress', [EnrollmentController::class, 'updateProgress'])->name('update-progress');
        Route::post('/{enrollment}/approve', [EnrollmentController::class, 'approve'])->name('approve');
        Route::post('/{enrollment}/reject', [EnrollmentController::class, 'reject'])->name('reject');
        Route::post('/bulk-action', [EnrollmentController::class, 'bulkAction'])->name('bulk-action');
    });

    // Analytics
    Route::prefix('analytics')->name('analytics.')->group(function () {
        Route::get('/', [AnalyticsController::class, 'index'])->name('index');
        Route::get('/courses', [AnalyticsController::class, 'courses'])->name('courses');
        Route::post('/courses/export', [AnalyticsController::class, 'exportCoursesPdf'])->name('export-courses');
        Route::get('/students', [AnalyticsController::class, 'students'])->name('students');
        Route::post('/students/export', [AnalyticsController::class, 'exportStudentsPdf'])->name('export-students');
        Route::get('/revenue', [AnalyticsController::class, 'revenue'])->name('revenue');
        Route::post('/revenue/export', [AnalyticsController::class, 'exportRevenuePdf'])->name('export-revenue');
        Route::get('/enrollments', [AnalyticsController::class, 'enrollments'])->name('enrollments');
        Route::post('/enrollments/export', [AnalyticsController::class, 'exportEnrollmentsPdf'])->name('export-enrollments');
        Route::get('/peak-hours', [AnalyticsController::class, 'peakHours'])->name('peak-hours');
        Route::post('/peak-hours/export', [AnalyticsController::class, 'exportPeakHoursPdf'])->name('export-peak-hours');
    });

    // Categories Management
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('index');
        Route::post('/', [CategoriesController::class, 'store'])->name('store');
        Route::put('/{category}', [CategoriesController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoriesController::class, 'destroy'])->name('destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Instructor Routes (المدربين)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [InstructorDashboardController::class, 'index'])
        ->name('dashboard')
        ->middleware(['auth', 'verified', 'permission:access_instructor_dashboard']);

    // My Courses
    Route::get('/my-courses', [AdminCourseController::class, 'instructorCourses'])->name('courses');

    // Course Status Check
    Route::get('/course/{course}/check-status', [AdminCourseController::class, 'checkCourseStatus'])->name('course.check-status');

    // Course Students Management
    Route::get('/course/{course}/students', [AdminCourseController::class, 'courseStudents'])->name('course-students');
    Route::get('/course/{course}/students/report', [AdminCourseController::class, 'exportStudentReport'])->name('course-students.report');

    // Course CRUD
    Route::prefix('courses')->name('courses.')->group(function () {
        Route::get('/create', [AdminCourseController::class, 'create'])->name('create');
        Route::post('/', [AdminCourseController::class, 'store'])->name('store');
        Route::get('/{course}/edit', [AdminCourseController::class, 'edit'])->name('edit');
        Route::put('/{course}', [AdminCourseController::class, 'update'])->name('update');
        Route::delete('/{course}', [AdminCourseController::class, 'destroy'])->name('destroy');
    });

    // Certificate & Progress
    Route::get('/certificate/{enrollment}', [AdminCourseController::class, 'generateCertificate'])->name('certificate');
    Route::get('/student/{enrollment}/progress', [AdminCourseController::class, 'studentProgressDetail'])->name('student.progress');
    Route::get('/course/{course}/analytics', [AdminCourseController::class, 'courseAnalytics'])->name('course.analytics');
    Route::post('/course/{course}/students/bulk-email', [AdminCourseController::class, 'bulkEmail'])->name('students.bulk-email');

    // Course Sessions Management
    Route::prefix('course/{course}/sessions')->name('course.sessions.')->group(function () {
        Route::put('/{session}/ajax-update', [CourseSessionController::class, 'ajaxUpdate'])->name('ajax-update'); // This is for Dashboard Calender Update
        Route::get('/', [CourseSessionController::class, 'index'])->name('index');
        Route::post('/', [CourseSessionController::class, 'store'])->name('store');
        Route::put('/{session}', [CourseSessionController::class, 'update'])->name('update');
        Route::delete('/{session}', [CourseSessionController::class, 'destroy'])->name('destroy');
        Route::post('/{session}/share-meeting', [CourseSessionController::class, 'shareMeetingLink'])->name('share-meeting');
        Route::post('/{session}/share-recording', [CourseSessionController::class, 'shareRecording'])->name('share-recording');
        Route::post('/{session}/attendance', [CourseSessionController::class, 'markAttendance'])->name('attendance');
    });

    // Bulk Actions
    Route::prefix('course/{course}/bulk')->name('course.bulk.')->group(function () {
        Route::post('/progress', [BulkActionController::class, 'updateProgress'])->name('progress');
        Route::post('/attendance', [BulkActionController::class, 'markSessionAttendance'])->name('attendance');
        Route::post('/message', [BulkActionController::class, 'sendBulkMessage'])->name('message');
        Route::post('/share-material', [BulkActionController::class, 'shareMaterial'])->name('share-material');
    });

    // Course Assignments Management  :: Done
    Route::prefix('course/{course}/assignments')->name('course.assignments.')->group(function () {
        Route::get('/', [CourseAssignmentController::class, 'index'])->name('index');
        Route::get('/create', [CourseAssignmentController::class, 'create'])->name('create');
        Route::post('/', [CourseAssignmentController::class, 'store'])->name('store');
        Route::get('/{assignment}/edit', [CourseAssignmentController::class, 'edit'])->name('edit');
        Route::put('/{assignment}', [CourseAssignmentController::class, 'update'])->name('update');
        Route::delete('/{assignment}', [CourseAssignmentController::class, 'destroy'])->name('destroy');
        Route::get('/{assignment}/submissions', [CourseAssignmentController::class, 'showSubmissions'])->name('submissions');
        Route::post('/{assignment}/submissions/{submission}/grade', [CourseAssignmentController::class, 'gradeSubmission'])->name('grade');
    });

    // Course Materials Management
    Route::prefix('course/{course}/materials')->name('course.materials.')->group(function () {
        Route::get('/', [CourseMaterialController::class, 'index'])->name('index');
        Route::get('/create', [CourseMaterialController::class, 'create'])->name('create');
        Route::post('/', [CourseMaterialController::class, 'store'])->name('store');
        Route::get('/{material}/edit', [CourseMaterialController::class, 'edit'])->name('edit');
        Route::put('/{material}', [CourseMaterialController::class, 'update'])->name('update');
        Route::delete('/{material}', [CourseMaterialController::class, 'destroy'])->name('destroy');
        Route::get('/{material}', [CourseMaterialController::class, 'show'])->name('show');
        Route::post('/reorder', [CourseMaterialController::class, 'reorder'])->name('reorder');
    });

    // Calendar Event Updates
    Route::post('/calendar/session/update', [InstructorDashboardController::class, 'updateSessionDate'])->name('calendar.session.update');
    Route::post('/calendar/assignment/update', [InstructorDashboardController::class, 'updateAssignmentDate'])->name('calendar.assignment.update');
    Route::get('/calendar/events', [InstructorDashboardController::class, 'getCalendarEvents'])->name('calendar.events');
});

/*
|--------------------------------------------------------------------------
| API Routes للـ AJAX والميزات الديناميكية
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->prefix('api')->name('api.')->group(function () {
    // ================================================
    // NOTE: The following API routes are intentionally commented out
    // because they cause some problem i cannot solve so the application 
    // now uses traditional server-rendered pages with form submissions 
    // and page reloads rather than AJAX/API calls.
    // 
    // However, AJAX IS used elsewhere in the application and works 100% for:
    // - Real-time messaging (polling for new messages)
    // - Wishlist toggling (add/remove without page reload)
    // - Review submission/editing (SweetAlert + fetch)
    // - Notification polling (unread count updates)
    // - Bulk actions in instructor/admin panels
    // - Session drag & drop in calendar
    // 
    // These specific routes were replaced with server-side implementations:
    // ================================================

    // REPLACED BY: Traditional paginated view in LearningPathController@index
    // The learning path progress is loaded directly in the Blade view
    // using $learningPath->progress_percentage and displayed via server-side rendering
    // Route::get('/learning-path/progress', [LearningPathController::class, 'getProgress'])->name('learning-path.progress');

    // REPLACED BY: Server-rendered recommendations in LearningPathController@index
    // Course suggestions are pre-loaded in the controller and passed to the view
    // as $recommendedCourses collection, rendered directly in the Blade template
    // Route::get('/learning-path/suggestions', [LearningPathController::class, 'getSuggestions'])->name('learning-path.suggestions');

    // REPLACED BY: Traditional form submission with query parameters
    // Course filtering uses GET parameters in the URL and server-side pagination
    // Example: /courses?category=1&level=beginner&sort=popular
    // Route::get('/courses/suggestions', [PublicCourseController::class, 'getSuggestions'])->name('courses.suggestions');

    // REPLACED BY: Server-side filtering with URL parameters
    // The courses page uses standard Laravel pagination with filter persistence
    // Filters are applied via query builder in the controller, not AJAX
    // Route::get('/courses/filter', [PublicCourseController::class, 'filter'])->name('courses.filter');
    // ================================================
    
    // // Learning Path
    // Route::get('/learning-path/progress', [LearningPathController::class, 'getProgress'])->name('learning-path.progress');
    // Route::get('/learning-path/suggestions', [LearningPathController::class, 'getSuggestions'])->name('learning-path.suggestions');

    // // Courses
    // Route::get('/courses/suggestions', [PublicCourseController::class, 'getSuggestions'])->name('courses.suggestions');
    // Route::get('/courses/filter', [PublicCourseController::class, 'filter'])->name('courses.filter');

    // ================================================
    // Notifications (For All Users Roles)
    Route::get('/notifications/count', [NotificationController::class, 'unreadCount'])->name('notifications.count');
    Route::get('/notifications/latest', [NotificationController::class, 'latest'])->name('notifications.latest');

    // Analytics (For Admin User Only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/analytics/chart-data', [AnalyticsController::class, 'chartData'])->name('analytics.chart-data');
        Route::get('/analytics/quick-stats', [AnalyticsController::class, 'quickStats'])->name('analytics.quick-stats');
        Route::get('/analytics/filter-data', [AnalyticsController::class, 'filterData'])->name('analytics.filter-data');
    });
    // ================================================
});