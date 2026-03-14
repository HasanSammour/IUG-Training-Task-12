<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_students' => User::role('student')->count(),
            'total_instructors' => User::role('instructor')->count(),
            'total_courses' => Course::count(),
            'active_courses' => Course::where('is_active', true)->count(),
            'total_enrollments' => Enrollment::count(),
            'pending_enrollments' => Enrollment::where('status', 'pending')->count(),
            'total_revenue' => Enrollment::sum('amount_paid'),
            'monthly_revenue' => Enrollment::whereMonth('created_at', now()->month)
                ->sum('amount_paid'),
        ];

        $recentEnrollments = Enrollment::with(['user', 'course'])
            ->latest()
            ->take(10)
            ->get();

        $popularCourses = Course::with('category')
            ->orderByDesc('total_students')
            ->take(3)
            ->get();

        $activeStudents = User::role('student')
            ->withCount([
                'enrollments' => function ($query) {
                    $query->where('status', 'active');
                }
            ])
            ->orderByDesc('enrollments_count')
            ->take(4)
            ->get();

        $revenueData = $this->getRevenueChartData();

        $enrollmentData = $this->getEnrollmentChartData();
        $categories = Category::all();
        $courses = Course::with('category')->latest()->paginate(10);

        return view('admin.dashboard', compact(
            'stats',
            'recentEnrollments',
            'popularCourses',
            'activeStudents',
            'revenueData',
            'enrollmentData',
            'categories',
            'courses'
        ));
    }

    public function menu(Request $request)
    {
        $query = Course::with('category')->latest();

        // Search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('full_description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('is_active') && $request->is_active !== null) {
            $query->where('is_active', $request->is_active == '1');
        }

        // Category filter
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Paginate with 6 items per page
        $courses = $query->paginate(6)->withQueryString();

        // Get stats
        $totalCourses = Course::count();
        $activeCourses = Course::where('is_active', true)->count();
        $draftCourses = Course::where('is_active', false)->count();
        $featuredCourses = Course::where('is_featured', true)->count();

        // Get categories for filter
        $categories = Category::all();

        return view('admin.menu', compact(
            'courses',
            'totalCourses',
            'activeCourses',
            'draftCourses',
            'featuredCourses',
            'categories'
        ));
    }

    private function getRevenueChartData()
    {
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $revenue = Enrollment::whereDate('created_at', $date)
                ->sum('amount_paid');

            $data[] = [
                'date' => $date->format('M d'),
                'revenue' => $revenue,
            ];
        }

        return $data;
    }

    private function getEnrollmentChartData()
    {
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $count = Enrollment::whereDate('created_at', $date)->count();

            $data[] = [
                'date' => $date->format('M d'),
                'enrollments' => $count,
            ];
        }

        return $data;
    }
}