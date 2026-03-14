<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Category;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AnalyticsController extends Controller
{    
    public function index(Request $request)
    {
        $dateRange = $request->get('date_range', 30);
        $dateFilter = Carbon::now()->subDays($dateRange);

        return view('admin.analytics.index', [
            'stats' => $this->getGeneralStats($dateFilter),
            'popularCourses' => $this->getPopularCourses($dateFilter),
            'activeStudents' => $this->getActiveStudents($dateFilter),
            'enrollmentChart' => $this->getEnrollmentChartData($dateRange),
            'revenueChart' => $this->getRevenueChartData($dateRange),
            'categoryDistribution' => $this->getCategoryDistribution($dateFilter),
            'growthStats' => $this->calculateGrowthStats($dateRange),
            'dateRange' => $dateRange
        ]);
    }

    public function courses(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $search = $request->get('search', '');
        $dateFilter = $this->getDateFilter($filter);

        $query = Course::with(['category'])
            ->withCount(['enrollments', 'reviews'])
            ->withSum('enrollments', 'amount_paid');

        $query = $this->applyCourseFilters($query, $dateFilter, $filter, $search);
        $courses = $query->orderBy('total_students', 'desc')->paginate(20)->withQueryString();

        return view('admin.analytics.courses', [
            'courses' => $courses,
            'courseStats' => $this->getCourseStats($filter, $search),
            'filter' => $filter,
            'search' => $search,
            'ratingDistribution' => $this->getRatingDistribution($dateFilter),
            'enrollmentTrends' => $this->getEnrollmentTrends($dateFilter),
            'revenueByCategory' => $this->getRevenueByCategory($dateFilter)
        ]);
    }

    public function exportCoursesPdf(Request $request)
    {
        $filter = $request->input('filter', 'all');
        $search = $request->input('search', '');
        $dateFilter = $this->getDateFilter($filter);

        $query = Course::with(['category'])
            ->withCount(['enrollments', 'reviews'])
            ->withSum('enrollments', 'amount_paid');

        $query = $this->applyCourseFilters($query, $dateFilter, $filter, $search);
        $courses = $query->orderBy('total_students', 'desc')->get();

        $pdf = Pdf::loadView('admin.analytics.courses-pdf', [
            'courses' => $courses,
            'courseStats' => $this->getCourseStats($filter, $search),
            'ratingDistribution' => $this->getRatingDistribution($dateFilter),
            'enrollmentTrends' => $this->getEnrollmentTrends($dateFilter),
            'revenueByCategory' => $this->getRevenueByCategory($dateFilter),
            'search' => $search,
            'filter' => $filter
        ]);

        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('course-analytics-' . now()->format('Y-m-d') . '.pdf');
    }

    public function students(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $search = $request->get('search', '');
        $dateFilter = $this->getDateFilter($filter);

        $query = User::role('student')
            ->withCount(['enrollments', 'learningPaths', 'reviews'])
            ->withSum('enrollments', 'amount_paid');

        $query = $this->applyStudentFilters($query, $dateFilter, $filter, $search);
        $students = $query->orderByDesc('enrollments_count')->paginate(20)->withQueryString();

        $activeStudents = User::role('student')
            ->withCount(['enrollments'])
            ->withSum('enrollments', 'amount_paid')
            ->whereHas('enrollments', function ($q) use ($dateFilter, $filter, $search) {
                if ($filter !== 'all') $q->where('enrolled_at', '>=', $dateFilter['start']);
                if (!empty($search)) {
                    $q->whereHas('course', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%");
                    });
                }
            })
            ->orderByDesc('enrollments_count')
            ->take(8)
            ->get();

        return view('admin.analytics.students', [
            'students' => $students,
            'studentStats' => $this->getStudentStats($filter, $search),
            'filter' => $filter,
            'search' => $search,
            'activeStudents' => $activeStudents
        ]);
    }

    public function exportStudentsPdf(Request $request)
    {
        $filter = $request->input('filter', 'all');
        $search = $request->input('search', '');
        $dateFilter = $this->getDateFilter($filter);

        $query = User::role('student')
            ->withCount(['enrollments', 'learningPaths', 'reviews'])
            ->withSum('enrollments', 'amount_paid');

        $query = $this->applyStudentFilters($query, $dateFilter, $filter, $search);
        $students = $query->orderByDesc('enrollments_count')->get();

        $pdf = Pdf::loadView('admin.analytics.students-pdf', [
            'students' => $students,
            'studentStats' => $this->getStudentStats($filter, $search),
            'search' => $search,
            'filter' => $filter
        ]);

        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('students-analytics-' . now()->format('Y-m-d') . '.pdf');
    }

    public function revenue(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $search = $request->get('search', '');
        $dateFilter = $this->getDateFilter($filter);

        $monthlyRevenue = $this->getMonthlyRevenueData($dateFilter);
        
        if (!empty($search)) {
            $monthlyRevenue = $this->filterMonthlyRevenueBySearch($monthlyRevenue, $search, $dateFilter);
        }

        return view('admin.analytics.revenue', [
            'monthlyRevenue' => $monthlyRevenue,
            'revenueStats' => $this->getRevenueStats($monthlyRevenue, $dateFilter, $search),
            'paymentMethods' => $this->getPaymentMethodData($dateFilter, $search),
            'revenueByCategory' => $this->getRevenueByCategoryData($dateFilter, $search),
            'dailyRevenueTrend' => $this->getDailyRevenueTrend($dateFilter, $search),
            'filter' => $filter,
            'search' => $search
        ]);
    }

    public function exportRevenuePdf(Request $request)
    {
        $filter = $request->input('filter', 'all');
        $search = $request->input('search', '');
        $dateFilter = $this->getDateFilter($filter);

        $monthlyRevenue = $this->getMonthlyRevenueData($dateFilter);

        $pdf = Pdf::loadView('admin.analytics.revenue-pdf', [
            'monthlyRevenue' => $monthlyRevenue,
            'revenueStats' => $this->getRevenueStats($monthlyRevenue, $dateFilter),
            'paymentMethods' => $this->getPaymentMethodData($dateFilter),
            'revenueByCategory' => $this->getRevenueByCategoryData($dateFilter),
            'search' => $search,
            'filter' => $filter
        ]);

        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('revenue-analytics-' . now()->format('Y-m-d') . '.pdf');
    }

    public function enrollments(Request $request)
    {
        $search = $request->get('search', '');

        $query = Enrollment::with(['user', 'course', 'course.category'])->latest();
        $query = $this->applyEnrollmentSearch($query, $search);
        $enrollments = $query->paginate(20)->withQueryString();

        $statsQuery = Enrollment::query();
        if (!empty($search)) {
            $statsQuery = $this->applyEnrollmentSearch($statsQuery, $search);
        }

        return view('admin.analytics.enrollments', [
            'enrollments' => $enrollments,
            'enrollmentStats' => $this->getEnrollmentStats($statsQuery),
            'enrollmentsByStatus' => $this->getEnrollmentsByStatus($statsQuery),
            'dailyEnrollments' => $this->getDailyEnrollments($search),
            'search' => $search
        ]);
    }

    public function exportEnrollmentsPdf(Request $request)
    {
        $search = $request->input('search', '');

        $query = Enrollment::with(['user', 'course'])->latest();
        $query = $this->applyEnrollmentSearch($query, $search);
        $enrollments = $query->take(100)->get();

        $statsQuery = Enrollment::query();
        if ($search) {
            $statsQuery = $this->applyEnrollmentSearch($statsQuery, $search);
        }

        $pdf = Pdf::loadView('admin.analytics.enrollments-pdf', [
            'enrollments' => $enrollments,
            'enrollmentStats' => $this->getEnrollmentStats($statsQuery),
            'enrollmentsByStatus' => $this->getEnrollmentsByStatus($statsQuery),
            'dailyEnrollments' => $this->getDailyEnrollments($search),
            'search' => $search
        ]);

        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('enrollments-analytics-' . now()->format('Y-m-d') . '.pdf');
    }

    public function peakHours(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $dateFilter = $this->getDateFilter($filter);

        return view('admin.analytics.peak-hours', [
            'peakHoursCollection' => collect($this->getPeakHoursData($dateFilter)),
            'enrollmentsByDayCollection' => collect($this->getEnrollmentsByDayData($dateFilter)),
            'stats' => $this->getPeakHoursStats($dateFilter),
            'filter' => $filter,
            'courseFormatActivity' => $this->getCourseFormatActivity($dateFilter)
        ]);
    }

    public function exportPeakHoursPdf(Request $request)
    {
        $filter = $request->input('filter', 'all');
        $dateFilter = $this->getDateFilter($filter);

        $peakHours = $this->getPeakHoursData($dateFilter);
        $enrollmentsByDay = $this->getEnrollmentsByDayData($dateFilter);
        $courseFormatActivity = $this->getCourseFormatActivity($dateFilter);

        $peakHoursCollection = collect($peakHours);
        $enrollmentsByDayCollection = collect($enrollmentsByDay);

        $peakHourData = $peakHoursCollection->sortByDesc('count')->first();
        $peakDayData = $enrollmentsByDayCollection->sortByDesc('count')->first();
        $stats = $this->getPeakHoursStats($dateFilter);

        $peakHoursWithNumber = array_map(function($hour) {
            $hour['hour_number'] = (int) substr($hour['hour'], 0, 2);
            return $hour;
        }, $peakHours);

        $peakHour = $peakHourData ? [
            'hour' => $peakHourData['hour_12'] ?? '3:00 PM',
            'count' => $peakHourData['count'] ?? 0
        ] : ['hour' => '3:00 PM', 'count' => 0];

        $peakDay = $peakDayData ? [
            'day' => $peakDayData['day'] ?? 'Friday',
            'count' => $peakDayData['count'] ?? 0
        ] : ['day' => 'Friday', 'count' => 0];

        $totalEnrollments = array_sum(array_column($peakHours, 'count'));
        $stats['total_enrollments'] = $totalEnrollments;
        $stats['peak_hour_count'] = $peakHour['count'];
        $stats['peak_day_count'] = $peakDay['count'];

        try {
            $pdf = Pdf::loadView('admin.analytics.peak-hours-pdf', [
                'peakHours' => $peakHoursWithNumber,
                'enrollmentsByDay' => $enrollmentsByDay,
                'peakHour' => $peakHour,
                'peakDay' => $peakDay,
                'stats' => $stats,
                'courseFormatActivity' => $courseFormatActivity,
                'filter' => $filter,
                'generatedAt' => now()
            ]);

            $pdf->setPaper('A4', 'landscape');
            $pdf->setOption('defaultFont', 'Arial');
            return $pdf->download('peak-hours-analytics-' . now()->format('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }

    public function chartData(Request $request)
    {
        $dateRange = $request->get('days', 30);

        return response()->json([
            'enrollments' => $this->getEnrollmentChartData($dateRange),
            'revenue' => $this->getRevenueChartData($dateRange),
            'categories' => $this->getCategoryDistribution(Carbon::now()->subDays($dateRange))
        ]);
    }

    public function quickStats(Request $request)
    {
        $dateRange = $request->get('days', 30);
        $dateFilter = Carbon::now()->subDays($dateRange);

        $stats = $this->getGeneralStats($dateFilter);
        $growthStats = $this->calculateGrowthStats($dateRange);

        return response()->json(array_merge($stats, $growthStats));
    }

    public function filterData(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $type = $request->get('type', 'courses');
        $dateFilter = $this->getDateFilter($filter);

        if ($type === 'courses') {
            $data = $this->getPopularCourses($dateFilter['start'])->map(function ($course) {
                return [
                    'title' => $course->title,
                    'category' => $course->category->name ?? 'Uncategorized',
                    'students' => $course->total_students,
                    'rating' => $course->rating,
                ];
            });
        } else {
            $data = $this->getActiveStudents($dateFilter['start'])->map(function ($student) {
                return [
                    'name' => $student->name,
                    'email' => $student->email,
                    'enrollments' => $student->enrollments_count ?? 0,
                ];
            });
        }

        return response()->json($data);
    }

    // =================== PRIVATE HELPER METHODS ===================

    // Filter Methods
    private function applyCourseFilters($query, $dateFilter, $filter, $search)
    {
        if ($filter !== 'all') {
            $query->whereHas('enrollments', function ($q) use ($dateFilter) {
                $q->where('enrolled_at', '>=', $dateFilter['start']);
            });
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('instructor_name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        return $query;
    }

    private function applyStudentFilters($query, $dateFilter, $filter, $search)
    {
        if ($filter !== 'all') {
            $query->whereHas('enrollments', function ($q) use ($dateFilter) {
                $q->where('enrolled_at', '>=', $dateFilter['start']);
            });
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    private function applyEnrollmentSearch($query, $search)
    {
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('enrollment_id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('course', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%");
                    });
            });
        }

        return $query;
    }

    // Data Methods
    private function getGeneralStats($dateFilter = null)
    {
        $stats = [
            'total_students' => User::role('student')->count(),
            'total_instructors' => User::role('instructor')->count(),
            'total_courses' => Course::count(),
            'active_courses' => Course::where('is_active', true)->count(),
            'total_enrollments' => Enrollment::count(),
            'total_revenue' => Enrollment::sum('amount_paid') ?? 0,
            'monthly_revenue' => Enrollment::whereMonth('enrolled_at', now()->month)->sum('amount_paid') ?? 0,
            'monthly_enrollments' => Enrollment::whereMonth('enrolled_at', now()->month)->count()
        ];

        if ($dateFilter) {
            $stats['filtered_enrollments'] = Enrollment::where('enrolled_at', '>=', $dateFilter)->count();
            $stats['filtered_revenue'] = Enrollment::where('enrolled_at', '>=', $dateFilter)->sum('amount_paid') ?? 0;
        }

        return $stats;
    }

    private function getPopularCourses($dateFilter = null)
    {
        $query = Course::with('category')
            ->withCount([
                'enrollments' => function ($query) use ($dateFilter) {
                    if ($dateFilter) $query->where('enrolled_at', '>=', $dateFilter);
                }
            ])
            ->orderByDesc('enrollments_count');

        if ($dateFilter) {
            $query->whereHas('enrollments', function ($q) use ($dateFilter) {
                $q->where('enrolled_at', '>=', $dateFilter);
            });
        }

        return $query->take(10)->get();
    }

    private function getActiveStudents($dateFilter = null)
    {
        $query = User::role('student')
            ->withCount([
                'enrollments' => function ($query) use ($dateFilter) {
                    if ($dateFilter) $query->where('enrolled_at', '>=', $dateFilter);
                }
            ])
            ->whereHas('enrollments', function ($query) use ($dateFilter) {
                if ($dateFilter) $query->where('enrolled_at', '>=', $dateFilter);
            })
            ->orderByDesc('enrollments_count');

        return $query->take(8)->get();
    }

    private function getCategoryDistribution($dateFilter = null)
    {
        $query = Category::withCount([
            'courses' => function ($query) use ($dateFilter) {
                if ($dateFilter) {
                    $query->whereHas('enrollments', function ($q) use ($dateFilter) {
                        $q->where('enrolled_at', '>=', $dateFilter);
                    });
                }
            }
        ])->having('courses_count', '>', 0);

        return $query->get()->map(function ($category) {
            return ['name' => $category->name, 'count' => $category->courses_count];
        });
    }

    private function calculateGrowthStats($days)
    {
        $currentPeriodStart = Carbon::now()->subDays($days);
        $currentPeriodEnd = Carbon::now();
        $previousPeriodStart = Carbon::now()->subDays($days * 2);
        $previousPeriodEnd = $currentPeriodStart;

        $currentEnrollments = Enrollment::whereBetween('enrolled_at', [$currentPeriodStart, $currentPeriodEnd])->count();
        $previousEnrollments = Enrollment::whereBetween('enrolled_at', [$previousPeriodStart, $previousPeriodEnd])->count();
        $currentRevenue = Enrollment::whereBetween('enrolled_at', [$currentPeriodStart, $currentPeriodEnd])->sum('amount_paid') ?? 0;
        $previousRevenue = Enrollment::whereBetween('enrolled_at', [$previousPeriodStart, $previousPeriodEnd])->sum('amount_paid') ?? 0;

        $currentStudents = User::role('student')
            ->whereHas('enrollments', function ($q) use ($currentPeriodStart, $currentPeriodEnd) {
                $q->whereBetween('enrolled_at', [$currentPeriodStart, $currentPeriodEnd]);
            })
            ->count();
        $previousStudents = User::role('student')
            ->whereHas('enrollments', function ($q) use ($previousPeriodStart, $previousPeriodEnd) {
                $q->whereBetween('enrolled_at', [$previousPeriodStart, $previousPeriodEnd]);
            })
            ->count();

        $currentCourses = Course::whereHas('enrollments', function ($q) use ($currentPeriodStart, $currentPeriodEnd) {
                $q->whereBetween('enrolled_at', [$currentPeriodStart, $currentPeriodEnd]);
            })->count();
        $previousCourses = Course::whereHas('enrollments', function ($q) use ($previousPeriodStart, $previousPeriodEnd) {
                $q->whereBetween('enrolled_at', [$previousPeriodStart, $previousPeriodEnd]);
            })->count();

        return [
            'enrollment_growth' => $previousEnrollments > 0
                ? round((($currentEnrollments - $previousEnrollments) / $previousEnrollments) * 100, 1)
                : ($currentEnrollments > 0 ? 100 : 0),
            'revenue_growth' => $previousRevenue > 0
                ? round((($currentRevenue - $previousRevenue) / $previousRevenue) * 100, 1)
                : ($currentRevenue > 0 ? 100 : 0),
            'student_growth' => $previousStudents > 0
                ? round((($currentStudents - $previousStudents) / $previousStudents) * 100, 1)
                : ($currentStudents > 0 ? 100 : 0),
            'course_growth' => $previousCourses > 0
                ? round((($currentCourses - $previousCourses) / $previousCourses) * 100, 1)
                : ($currentCourses > 0 ? 100 : 0),
        ];
    }

    private function getDateFilter($filter)
    {
        $now = Carbon::now();
        $start = $now->copy();
        
        switch ($filter) {
            case 'week': $start->subWeek(); break;
            case 'month': $start->subMonth(); break;
            case 'year': $start->subYear(); break;
            case 'all':
            default:
                $firstEnrollment = Enrollment::orderBy('enrolled_at')->first();
                $start = $firstEnrollment ? $firstEnrollment->enrolled_at : $now->copy()->subYear();
                break;
        }
            
        return ['start' => $start, 'end' => $now];
    }

    private function getCourseStats($filter, $search = '')
    {
        $dateFilter = $this->getDateFilter($filter);
        $query = Course::query();

        if ($filter !== 'all') {
            $query->whereHas('enrollments', function ($q) use ($dateFilter) {
                $q->where('enrolled_at', '>=', $dateFilter['start']);
            });
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('instructor_name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $totalCourses = $query->count();
        $activeCourses = $query->clone()->where('is_active', true)->count();
        $featuredCourses = $query->clone()->where('is_featured', true)->count();
        $avgRating = $query->clone()->where('rating', '>', 0)->avg('rating');
        $avgPrice = $query->clone()->avg('price');
        $totalRevenue = $query->clone()->withSum('enrollments', 'amount_paid')->get()->sum('enrollments_sum_amount_paid');

        return [
            'total' => $totalCourses,
            'active' => $activeCourses,
            'featured' => $featuredCourses,
            'average_rating' => round($avgRating ?? 0, 1),
            'average_price' => round($avgPrice ?? 0, 2),
            'total_revenue' => round($totalRevenue ?? 0, 2),
        ];
    }

    private function getRatingDistribution($dateFilter = null)
    {
        $ranges = ['0-1' => [0, 1], '1-2' => [1, 2], '2-3' => [2, 3], '3-4' => [3, 4], '4-5' => [4, 5]];
        $distribution = [];

        foreach ($ranges as $label => $range) {
            $query = Course::query();
            if ($dateFilter) {
                $query->whereHas('enrollments', function ($q) use ($dateFilter) {
                    $q->where('enrolled_at', '>=', $dateFilter['start']);
                });
            }
            $count = $range[0] == 0
                ? $query->whereBetween('rating', $range)->count()
                : $query->whereBetween('rating', [$range[0] + 0.1, $range[1]])->count();
            $distribution[] = ['range' => $label, 'count' => $count];
        }

        return $distribution;
    }

    private function getEnrollmentTrends($dateFilter = null)
    {
        $trends = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $query = Enrollment::whereDate('enrolled_at', $date);
            
            if ($dateFilter) {
                $query->where('enrolled_at', '>=', $dateFilter['start']);
            }

            $trends[] = [
                'date' => $date->format('D'),
                'full_date' => $date->format('M d'),
                'enrollments' => $query->count(),
                'revenue' => $query->sum('amount_paid') ?? 0,
            ];
        }

        return $trends;
    }

    private function getRevenueByCategory($dateFilter = null)
    {
        $query = DB::table('categories')
            ->leftJoin('courses', 'categories.id', '=', 'courses.category_id')
            ->leftJoin('enrollments', 'courses.id', '=', 'enrollments.course_id')
            ->selectRaw('categories.name, 
                         SUM(enrollments.amount_paid) as revenue, 
                         COUNT(DISTINCT courses.id) as courses_count,
                         COUNT(DISTINCT enrollments.id) as enrollments_count');

        if ($dateFilter) {
            $query->where('enrollments.enrolled_at', '>=', $dateFilter['start']);
        }

        return $query->groupBy('categories.id', 'categories.name')
            ->orderByDesc('revenue')
            ->take(8)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->name,
                    'revenue' => $item->revenue ?? 0,
                    'courses' => $item->courses_count ?? 0,
                    'enrollments' => $item->enrollments_count ?? 0,
                ];
            });
    }

    private function getStudentStats($filter, $search = '')
    {
        $dateFilter = $this->getDateFilter($filter);
        $query = User::role('student');

        if ($filter !== 'all') {
            $query->whereHas('enrollments', function ($q) use ($dateFilter) {
                $q->where('enrolled_at', '>=', $dateFilter['start']);
            });
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            });
        }

        $totalStudents = $query->count();
        $activeStudents = $query->clone()
            ->whereHas('enrollments', function ($q) use ($dateFilter, $filter) {
                if ($filter !== 'all') $q->where('enrolled_at', '>=', $dateFilter['start']);
            })
            ->count();

        $completedCourses = $query->clone()
            ->withCount([
                'enrollments' => function ($q) use ($dateFilter, $filter) {
                    $q->where('status', 'completed');
                    if ($filter !== 'all') $q->where('enrolled_at', '>=', $dateFilter['start']);
                }
            ])
            ->get()
            ->sum('enrollments_count');

        $averageEnrollments = $query->clone()
            ->withCount([
                'enrollments' => function ($q) use ($dateFilter, $filter) {
                    if ($filter !== 'all') $q->where('enrolled_at', '>=', $dateFilter['start']);
                }
            ])
            ->get()
            ->avg('enrollments_count');

        $totalRevenue = $query->clone()
            ->withSum([
                'enrollments' => function ($q) use ($dateFilter, $filter) {
                    if ($filter !== 'all') $q->where('enrolled_at', '>=', $dateFilter['start']);
                }
            ], 'amount_paid')
            ->get()
            ->sum('enrollments_sum_amount_paid');

        return [
            'total' => $totalStudents,
            'active' => $activeStudents,
            'completed_courses' => $completedCourses,
            'average_enrollments' => round($averageEnrollments ?? 0, 1),
            'total_revenue' => round($totalRevenue ?? 0, 2),
            'average_revenue_per_student' => $totalStudents > 0 ? round($totalRevenue / $totalStudents, 2) : 0,
        ];
    }

    // Revenue Analytics Methods
    private function filterMonthlyRevenueBySearch($monthlyRevenue, $search, $dateFilter)
    {
        if (empty($search)) return $monthlyRevenue;

        foreach ($monthlyRevenue as &$month) {
            $query = Enrollment::whereYear('enrolled_at', $month['year'])
                ->whereMonth('enrolled_at', $month['month_num'])
                ->where(function ($q) use ($search) {
                    $q->whereHas('course', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%")->orWhere('instructor_name', 'like', "%{$search}%");
                    })->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                });

            if ($dateFilter) {
                $query->where('enrolled_at', '>=', $dateFilter['start']);
            }

            $month['revenue'] = $query->sum('amount_paid') ?? 0;
            $month['enrollments'] = $query->count();
        }

        return $monthlyRevenue;
    }

    private function getMonthlyRevenueData($dateFilter = null)
    {
        $monthlyRevenue = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $query = Enrollment::whereYear('enrolled_at', $date->year)
                ->whereMonth('enrolled_at', $date->month);

            if ($dateFilter) {
                $query->where('enrolled_at', '>=', $dateFilter['start']);
            }

            $revenue = $query->sum('amount_paid');
            $enrollments = $query->count();

            $monthlyRevenue[] = [
                'month' => $date->format('M Y'),
                'year' => $date->year,
                'month_num' => $date->month,
                'revenue' => $revenue ?? 0,
                'enrollments' => $enrollments,
                'date' => $date->format('Y-m'),
            ];
        }

        return $monthlyRevenue;
    }

    private function getRevenueStats($monthlyRevenue, $dateFilter = null, $search = '')
    {
        $totalRevenue = array_sum(array_column($monthlyRevenue, 'revenue'));
        $totalEnrollments = array_sum(array_column($monthlyRevenue, 'enrollments'));
        $currentMonthRevenue = end($monthlyRevenue)['revenue'] ?? 0;
        $currentMonthEnrollments = end($monthlyRevenue)['enrollments'] ?? 0;

        $lastMonthRevenue = $monthlyRevenue[count($monthlyRevenue) - 2]['revenue'] ?? 0;
        $growthRate = $lastMonthRevenue > 0
            ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
            : ($currentMonthRevenue > 0 ? 100 : 0);

        $averageTicketSize = $totalEnrollments > 0 ? $totalRevenue / $totalEnrollments : 0;

        $todayQuery = Enrollment::whereDate('enrolled_at', Carbon::today());
        $weekQuery = Enrollment::where('enrolled_at', '>=', Carbon::now()->startOfWeek());

        if (!empty($search)) {
            $searchCallback = function ($q) use ($search) {
                $q->whereHas('course', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")->orWhere('instructor_name', 'like', "%{$search}%");
                })->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            };
            $todayQuery->where($searchCallback);
            $weekQuery->where($searchCallback);
        }

        return [
            'total_revenue' => $totalRevenue,
            'total_enrollments' => $totalEnrollments,
            'current_month_revenue' => $currentMonthRevenue,
            'current_month_enrollments' => $currentMonthEnrollments,
            'average_ticket_size' => $averageTicketSize,
            'growth_rate' => $growthRate,
            'today_revenue' => $todayQuery->sum('amount_paid') ?? 0,
            'this_week_revenue' => $weekQuery->sum('amount_paid') ?? 0,
        ];
    }

    private function getPaymentMethodData($dateFilter = null, $search = '')
    {
        $query = Enrollment::selectRaw('payment_method, SUM(amount_paid) as total, COUNT(*) as count');

        if ($dateFilter) {
            $query->where('enrolled_at', '>=', $dateFilter['start']);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('course', function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")->orWhere('instructor_name', 'like', "%{$search}%");
                })->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            });
        }

        return $query->groupBy('payment_method')
            ->orderByDesc('total')
            ->get()
            ->map(function ($item) {
                return [
                    'payment_method' => $item->payment_method,
                    'total' => $item->total ?? 0,
                    'count' => $item->count,
                    'percentage' => 0
                ];
            });
    }

    private function getRevenueByCategoryData($dateFilter = null, $search = '')
    {
        $query = DB::table('categories')
            ->leftJoin('courses', 'categories.id', '=', 'courses.category_id')
            ->leftJoin('enrollments', 'courses.id', '=', 'enrollments.course_id')
            ->selectRaw('categories.name as category_name, 
                         SUM(enrollments.amount_paid) as revenue, 
                         COUNT(DISTINCT courses.id) as courses_count,
                         COUNT(DISTINCT enrollments.id) as enrollments_count');

        if ($dateFilter) {
            $query->where('enrollments.enrolled_at', '>=', $dateFilter['start']);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('courses.title', 'like', "%{$search}%")
                    ->orWhere('courses.instructor_name', 'like', "%{$search}%")
                    ->orWhere('categories.name', 'like', "%{$search}%");
            });
        }

        return $query->groupBy('categories.id', 'categories.name')
            ->orderByDesc('revenue')
            ->get()
            ->map(function ($item) {
                return [
                    'category' => $item->category_name ?? 'Uncategorized',
                    'revenue' => $item->revenue ?? 0,
                    'courses' => $item->courses_count ?? 0,
                    'enrollments' => $item->enrollments_count ?? 0,
                    'percentage' => 0
                ];
            });
    }

    private function getDailyRevenueTrend($dateFilter = null, $search = '')
    {
        $dailyTrend = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $query = Enrollment::whereDate('enrolled_at', $date);

            if ($dateFilter) {
                $query->where('enrolled_at', '>=', $dateFilter['start']);
            }

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('course', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%")->orWhere('instructor_name', 'like', "%{$search}%");
                    })->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
                });
            }

            $dailyTrend[] = [
                'date' => $date->format('M d'),
                'full_date' => $date->format('Y-m-d'),
                'day_name' => $date->format('D'),
                'revenue' => $query->sum('amount_paid') ?? 0,
                'enrollments' => $query->count(),
            ];
        }

        return $dailyTrend;
    }

    // Enrollment Analytics Methods
    private function getEnrollmentStats($statsQuery)
    {
        $clone = clone $statsQuery;
        $clone2 = clone $statsQuery;
        $clone3 = clone $statsQuery;
        $clone4 = clone $statsQuery;
        $clone5 = clone $statsQuery;

        return [
            'total' => $statsQuery->count(),
            'active' => $clone->where('status', 'active')->count(),
            'completed' => $clone2->where('status', 'completed')->count(),
            'pending' => $clone3->where('status', 'pending')->count(),
            'cancelled' => $clone4->where('status', 'cancelled')->count(),
            'average_progress' => round($clone5->avg('progress_percentage') ?? 0, 1),
        ];
    }

    private function getEnrollmentsByStatus($statsQuery)
    {
        return $statsQuery->clone()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->map(function ($item) {
                return (object) ['status' => $item->status, 'count' => $item->count];
            });
    }

    private function getDailyEnrollments($search = '')
    {
        $dailyEnrollments = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dayQuery = Enrollment::whereDate('enrolled_at', $date);

            if (!empty($search)) {
                $dayQuery = $this->applyEnrollmentSearch($dayQuery, $search);
            }

            $dailyEnrollments[] = [
                'date' => $date->format('M d'),
                'count' => $dayQuery->count(),
            ];
        }

        return $dailyEnrollments;
    }

    // Peak Hours Methods
    private function getPeakHoursData($dateFilter)
    {
        $peakHours = Enrollment::whereBetween('enrolled_at', [$dateFilter['start'], $dateFilter['end']])
            ->selectRaw('HOUR(enrolled_at) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();

        return $peakHours->map(function ($item) {
            return [
                'hour' => $item->hour . ':00',
                'hour_12' => date('h A', strtotime($item->hour . ':00')),
                'count' => $item->count,
            ];
        })->toArray();
    }

    private function getEnrollmentsByDayData($dateFilter)
    {
        $enrollmentsByDay = Enrollment::whereBetween('enrolled_at', [$dateFilter['start'], $dateFilter['end']])
            ->selectRaw('DAYNAME(enrolled_at) as day, COUNT(*) as count')
            ->groupBy('day')
            ->get();

        $dayOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                
        return $enrollmentsByDay->sortBy(function ($item) use ($dayOrder) {
            return array_search($item->day, $dayOrder);
        })->map(function ($item) {
            return [
                'day' => $item->day,
                'short_day' => substr($item->day, 0, 3),
                'count' => $item->count,
            ];
        })->toArray();
    }

    private function getPeakHoursStats($dateFilter)
    {
        $peakHourData = Enrollment::whereBetween('enrolled_at', [$dateFilter['start'], $dateFilter['end']])
            ->selectRaw('HOUR(enrolled_at) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->orderByDesc('count')
            ->first();

        $peakDayData = Enrollment::whereBetween('enrolled_at', [$dateFilter['start'], $dateFilter['end']])
            ->selectRaw('DAYNAME(enrolled_at) as day, COUNT(*) as count')
            ->groupBy('day')
            ->orderByDesc('count')
            ->first();

        $avgDailyLogins = Notification::whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']])
            ->where('type', 'system')
            ->distinct('user_id')
            ->count() / max(1, $dateFilter['start']->diffInDays($dateFilter['end']));

        $totalEnrollments = Enrollment::whereBetween('enrolled_at', [$dateFilter['start'], $dateFilter['end']])->count();
        $totalHours = $dateFilter['start']->diffInHours($dateFilter['end']);
        $avgEnrollmentsPerHour = $totalEnrollments / max(1, $totalHours);

        $previousEnd = $dateFilter['start']->copy()->subDay();
        $previousStart = $dateFilter['start']->copy()->subDays($dateFilter['start']->diffInDays($dateFilter['end']));
        $previousEnrollments = Enrollment::whereBetween('enrolled_at', [$previousStart, $previousEnd])->count();
        
        if ($previousEnrollments > 0) {
            $growthPercentage = (($totalEnrollments - $previousEnrollments) / $previousEnrollments) * 100;
            $activityGrowth = $growthPercentage >= 0 ? '+' . round($growthPercentage, 1) . '%' : round($growthPercentage, 1) . '%';
        } else {
            $activityGrowth = '+0%';
        }

        return [
            'peak_hour' => $peakHourData ? date('H:i', strtotime($peakHourData->hour . ':00')) : '15:00',
            'peak_day' => $peakDayData ? $peakDayData->day : 'Friday',
            'avg_daily_logins' => round($avgDailyLogins),
            'avg_enrollments_per_hour' => round($avgEnrollmentsPerHour, 1),
            'activity_growth' => $activityGrowth,
            'total_activity' => $totalEnrollments,
            'period_start' => $dateFilter['start']->format('M d, Y'),
            'period_end' => $dateFilter['end']->format('M d, Y'),
        ];
    }

    private function getCourseFormatActivity($dateFilter)
    {
        if (!$dateFilter) {
            return ['online' => 0, 'in-person' => 0, 'hybrid' => 0];
        }

        $courseFormats = Course::whereHas('enrollments', function ($query) use ($dateFilter) {
                $query->whereBetween('enrolled_at', [$dateFilter['start'], $dateFilter['end']]);
            })
            ->selectRaw('format, COUNT(*) as count')
            ->groupBy('format')
            ->get();

        $total = $courseFormats->sum('count');
        $activity = ['online' => 0, 'in-person' => 0, 'hybrid' => 0];

        foreach ($courseFormats as $format) {
            if (isset($activity[$format->format])) {
                $activity[$format->format] = $total > 0 ? round(($format->count / $total) * 100) : 0;
            }
        }

        return $activity;
    }

    // Chart Data Methods
    private function getEnrollmentChartData($days = 30)
    {
        $data = [];

        if ($days > 90) {
            $weeks = ceil($days / 7);
            for ($i = $weeks - 1; $i >= 0; $i--) {
                $startDate = Carbon::now()->subWeeks($i)->startOfWeek();
                $endDate = Carbon::now()->subWeeks($i - 1)->startOfWeek();
                $data[] = [
                    'date' => $startDate->format('M d'),
                    'count' => Enrollment::whereBetween('enrolled_at', [$startDate, $endDate])->count(),
                ];
            }
        } else {
            for ($i = $days - 1; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $data[] = [
                    'date' => $date->format($days <= 7 ? 'D' : 'M d'),
                    'count' => Enrollment::whereDate('enrolled_at', $date)->count(),
                ];
            }
        }

        return $data;
    }

    private function getRevenueChartData($days = 30)
    {
        $data = [];

        if ($days > 90) {
            $months = ceil($days / 30);
            for ($i = $months - 1; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $data[] = [
                    'date' => $date->format('M Y'),
                    'revenue' => Enrollment::whereYear('enrolled_at', $date->year)
                        ->whereMonth('enrolled_at', $date->month)
                        ->sum('amount_paid') ?? 0,
                ];
            }
        } else {
            for ($i = $days - 1; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $data[] = [
                    'date' => $date->format($days <= 7 ? 'D' : 'M d'),
                    'revenue' => Enrollment::whereDate('enrolled_at', $date)->sum('amount_paid') ?? 0,
                ];
            }
        }

        return $data;
    }
}