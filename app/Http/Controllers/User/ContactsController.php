<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->get('search');
        $role = $request->get('role');
        $perPage = 12;
        
        $unreadCount = auth()->user()->notifications()->where('is_read', false)->count();
        
        if ($user->hasRole('admin')) {
            // Admin sees all users except themselves
            $query = User::where('id', '!=', $user->id);
            
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
            
            if ($role && $role !== 'all') {
                $query->role($role);
            }
            
            $contacts = $query->paginate($perPage)->withQueryString();
            $allContacts = User::where('id', '!=', $user->id)->get();
            
        } elseif ($user->hasRole('instructor')) {
            // Instructor sees their students and admins
            $studentIds = Enrollment::whereIn('course_id', 
                    Course::where('instructor_name', $user->name)->pluck('id')
                )->pluck('user_id')->unique();
            
            // Get all possible contacts first
            $allStudents = User::whereIn('id', $studentIds)->get();
            $allAdmins = User::role('admin')->get();
            $allContacts = $allStudents->concat($allAdmins);
            
            // Build paginated query
            $studentQuery = User::whereIn('id', $studentIds);
            $adminQuery = User::role('admin');
            
            if ($search) {
                $studentQuery->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
                $adminQuery->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
            
            // Get filtered collections
            $students = $studentQuery->get();
            $admins = $adminQuery->get();
            
            // Combine and paginate manually
            $combined = $students->concat($admins);
            
            // Apply role filter if needed
            if ($role && $role !== 'all') {
                if ($role === 'student') {
                    $combined = $students;
                } elseif ($role === 'admin') {
                    $combined = $admins;
                }
            }
            
            // Manually paginate the collection
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentItems = $combined->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $contacts = new LengthAwarePaginator(
                $currentItems,
                $combined->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
            
        } else {
            // Student sees their instructors and admins
            $courseIds = Enrollment::where('user_id', $user->id)->pluck('course_id');
            $instructorNames = Course::whereIn('id', $courseIds)->pluck('instructor_name')->unique();
            
            // Get all possible contacts first
            $allInstructors = User::whereIn('name', $instructorNames)->get();
            $allAdmins = User::role('admin')->get();
            $allContacts = $allInstructors->concat($allAdmins);
            
            // Build paginated query
            $instructorQuery = User::whereIn('name', $instructorNames);
            $adminQuery = User::role('admin');
            
            if ($search) {
                $instructorQuery->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
                $adminQuery->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
            
            // Get filtered collections
            $instructors = $instructorQuery->get();
            $admins = $adminQuery->get();
            
            // Combine and paginate manually
            $combined = $instructors->concat($admins);
            
            // Apply role filter if needed
            if ($role && $role !== 'all') {
                if ($role === 'instructor') {
                    $combined = $instructors;
                } elseif ($role === 'admin') {
                    $combined = $admins;
                }
            }
            
            // Manually paginate the collection
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentItems = $combined->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $contacts = new LengthAwarePaginator(
                $currentItems,
                $combined->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }
        
        if ($request->ajax()) {
            return response()->json([
                'contacts' => $contacts,
                'count' => $contacts->total()
            ]);
        }
        
        return view('user.contacts.index', compact('contacts', 'unreadCount', 'search', 'role', 'allContacts'));
    }
    
    public function search(Request $request)
    {
        $user = Auth::user();
        $search = $request->get('search');
        $role = $request->get('role');
        $perPage = 12;
        
        if ($user->hasRole('admin')) {
            $query = User::where('id', '!=', $user->id);
            
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
            
            if ($role && $role !== 'all') {
                $query->role($role);
            }
            
            $contacts = $query->paginate($perPage);
            
        } elseif ($user->hasRole('instructor')) {
            $studentIds = Enrollment::whereIn('course_id', 
                    Course::where('instructor_name', $user->name)->pluck('id')
                )->pluck('user_id')->unique();
            
            $studentQuery = User::whereIn('id', $studentIds);
            $adminQuery = User::role('admin');
            
            if ($search) {
                $studentQuery->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
                $adminQuery->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
            
            $students = $studentQuery->get();
            $admins = $adminQuery->get();
            
            $combined = $students->concat($admins);
            
            if ($role && $role !== 'all') {
                if ($role === 'student') {
                    $combined = $students;
                } elseif ($role === 'admin') {
                    $combined = $admins;
                }
            }
            
            // Manually paginate
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentItems = $combined->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $contacts = new LengthAwarePaginator(
                $currentItems,
                $combined->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
            
        } else {
            $courseIds = Enrollment::where('user_id', $user->id)->pluck('course_id');
            $instructorNames = Course::whereIn('id', $courseIds)->pluck('instructor_name')->unique();
            
            $instructorQuery = User::whereIn('name', $instructorNames);
            $adminQuery = User::role('admin');
            
            if ($search) {
                $instructorQuery->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
                $adminQuery->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
            
            $instructors = $instructorQuery->get();
            $admins = $adminQuery->get();
            
            $combined = $instructors->concat($admins);
            
            if ($role && $role !== 'all') {
                if ($role === 'instructor') {
                    $combined = $instructors;
                } elseif ($role === 'admin') {
                    $combined = $admins;
                }
            }
            
            // Manually paginate
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentItems = $combined->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $contacts = new LengthAwarePaginator(
                $currentItems,
                $combined->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }
        
        return response()->json([
            'contacts' => $contacts,
            'count' => $contacts->total()
        ]);
    }
}