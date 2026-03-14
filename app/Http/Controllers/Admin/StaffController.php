<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;

class StaffController extends Controller
{
    /**
     * Display a listing of staff (Admins & Instructors)
     */
    public function index(Request $request)
    {
        // Exclude current logged in user
        $query = User::whereIn('id', function ($q) {
            $q->select('model_id')
                ->from('model_has_roles')
                ->whereIn('role_id', function ($q2) {
                    $q2->select('id')
                        ->from('roles')
                        ->whereIn('name', ['admin', 'instructor']);
                });
        })->where('id', '!=', auth()->id());

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status == 'inactive') {
                $query->whereNull('email_verified_at');
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
        $staff = $query->with('roles')->paginate($perPage)->withQueryString();

        // Statistics
        $stats = [
            'total_admins' => User::role('admin')->where('id', '!=', auth()->id())->count(),
            'total_instructors' => User::role('instructor')->count(),
            'active_today' => User::whereIn('id', function ($q) {
                $q->select('model_id')
                    ->from('model_has_roles')
                    ->whereIn('role_id', function ($q2) {
                        $q2->select('id')->from('roles')->whereIn('name', ['admin', 'instructor']);
                    });
            })->where('updated_at', '>=', now()->startOfDay())->count(),
            'pending_verification' => User::whereIn('id', function ($q) {
                $q->select('model_id')
                    ->from('model_has_roles')
                    ->whereIn('role_id', function ($q2) {
                        $q2->select('id')->from('roles')->whereIn('name', ['admin', 'instructor']);
                    });
            })->whereNull('email_verified_at')->count(),
        ];

        $roles = Role::whereIn('name', ['admin', 'instructor'])->get();

        return view('admin.staff.index', compact('staff', 'stats', 'roles'));
    }

    /**
     * Show form for creating new staff
     */
    public function create()
    {
        $roles = Role::whereIn('name', ['admin', 'instructor'])->get();
        return view('admin.staff.create', compact('roles'));
    }

    /**
     * Store a newly created staff member
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|exists:roles,name',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'bio' => $request->bio,
            'email_verified_at' => Carbon::now(),
        ];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('images/avatars', $filename, 'public');
            $data['avatar'] = $path;
        }

        $staff = User::create($data);
        $staff->assignRole($request->role);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member created successfully.');
    }

    /**
     * Show staff details
     */
    public function show(User $staff)
    {
        // Prevent viewing current user
        if ($staff->id == auth()->id()) {
            return redirect()->route('admin.staff.index')
                ->with('error', 'You cannot view your own profile here. Use Profile Settings instead.');
        }

        // Ensure user has admin/instructor role
        if (!$staff->hasAnyRole(['admin', 'instructor'])) {
            abort(404);
        }

        $staff->load(['roles']);

        // Get additional data based on role
        if ($staff->hasRole('instructor')) {
            // Get courses where this user is the instructor
            $instructorCourses = Course::where('instructor_name', $staff->name)->get();
                    
            $stats = [
                'total_courses' => $instructorCourses->count(),
                'active_courses' => $instructorCourses->where('is_active', true)->count(),
                'total_students' => Enrollment::whereIn('course_id', $instructorCourses->pluck('id'))->count(),
                'avg_rating' => round($instructorCourses->avg('rating') ?? 0, 1),
            ];
        } else {
            // Admin stats
            $stats = [
                'total_students' => User::role('student')->count(),
                'total_courses' => Course::count(),
                'total_enrollments' => Enrollment::count(),
                'total_instructors' => User::role('instructor')->count(),
            ];
        }

        // Get recent activity
        $recentActivity = collect();
                    
        // Add course creations if instructor
        if ($staff->hasRole('instructor')) {
            $instructorCourses = Course::where('instructor_name', $staff->name)
                ->latest()
                ->take(5)
                ->get()
                ->map(function($course) {
                    return [
                        'title' => 'Course Created',
                        'description' => "Created course: {$course->title}",
                        'icon' => 'fa-book',
                        'color' => 'purple',
                        'date' => $course->created_at
                    ];
                });
            $recentActivity = $recentActivity->concat($instructorCourses);
        }

        // Get instructor's courses for the view
        $instructorCourses = $staff->hasRole('instructor') 
            ? Course::where('instructor_name', $staff->name)->latest()->get()
            : collect();

        return view('admin.staff.show', compact('staff', 'stats', 'recentActivity', 'instructorCourses'));
    }    

    /**
     * Show form for editing staff
     */
    public function edit(User $staff)
    {
        // Prevent editing current user
        if ($staff->id == auth()->id()) {
            return redirect()->route('admin.staff.index')
                ->with('error', 'You cannot edit your own profile here. Use Profile Settings instead.');
        }

        if (!$staff->hasAnyRole(['admin', 'instructor'])) {
            abort(404);
        }

        $roles = Role::whereIn('name', ['admin', 'instructor'])->get();
        $currentRole = $staff->roles->first()->name ?? '';

        return view('admin.staff.edit', compact('staff', 'roles', 'currentRole'));
    }

    /**
     * Update staff information
     */
    public function update(Request $request, User $staff)
    {
        // Prevent updating current user
        if ($staff->id == auth()->id()) {
            return redirect()->route('admin.staff.index')
                ->with('error', 'You cannot update your own profile here. Use Profile Settings instead.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($staff->id)],
            'role' => 'required|exists:roles,name',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'bio']);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($staff->avatar) {
                Storage::disk('public')->delete($staff->avatar);
            }
            $file = $request->file('avatar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('images/avatars', $filename, 'public');
            $data['avatar'] = $path;
        }

        // Handle remove avatar
        if ($request->has('remove_avatar')) {
            if ($staff->avatar) {
                Storage::disk('public')->delete($staff->avatar);
                $data['avatar'] = null;
            }
        }

        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $staff->update($data);

        // Update role
        $staff->syncRoles([$request->role]);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member updated successfully.');
    }

    /**
     * Remove staff member
     */
    public function destroy(User $staff)
    {
        // Prevent deleting current user
        if ($staff->id == auth()->id()) {
            return redirect()->route('admin.staff.index')
                ->with('error', 'You cannot delete your own account here. Use Profile Settings instead.');
        }

        // Prevent deleting last admin
        if ($staff->hasRole('admin') && User::role('admin')->count() <= 1) {
            return redirect()->route('admin.staff.index')
                ->with('error', 'Cannot delete the last admin user.');
        }

        // Delete avatar
        if ($staff->avatar) {
            Storage::disk('public')->delete($staff->avatar);
        }

        $staff->delete();

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member deleted successfully.');
    }

    /**
     * Send password reset link to staff
     */
    public function sendResetLink(User $staff)
    {
        if ($staff->id == auth()->id()) {
            return response()->json([
                'success' => false,
                'error' => 'Cannot reset your own password here'
            ], 403);
        }

        $status = Password::sendResetLink(
            ['email' => $staff->email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => true,
                'message' => 'Password reset link sent to ' . $staff->email
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => 'Failed to send reset link'
        ], 500);
    }

    /**
     * Toggle staff status (active/inactive)
     */
    public function toggleStatus(User $staff)
    {
        if ($staff->id == auth()->id()) {
            return response()->json([
                'success' => false,
                'error' => 'Cannot change your own status'
            ], 403);
        }

        // Prevent deactivating last admin
        if ($staff->hasRole('admin') && User::role('admin')->count() <= 1) {
            return response()->json([
                'success' => false,
                'error' => 'Cannot deactivate the last admin'
            ], 403);
        }

        $status = $staff->email_verified_at ? null : now();
        $staff->update(['email_verified_at' => $status]);

        return response()->json([
            'success' => true,
            'message' => $status ? 'Staff activated successfully' : 'Staff deactivated successfully',
            'status' => $status ? 'active' : 'inactive'
        ]);
    }

    /**
     * Verify email manually
     */
    public function verifyEmail(User $staff)
    {
        if ($staff->id == auth()->id()) {
            return response()->json([
                'success' => false,
                'error' => 'Cannot verify yourself'
            ], 403);
        }

        $staff->update(['email_verified_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully'
        ]);
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,verify,activate,deactivate',
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id'
        ]);

        // Don't allow actions on current user
        if (in_array(auth()->id(), $request->ids)) {
            return response()->json([
                'success' => false,
                'error' => 'Cannot perform action on yourself'
            ], 403);
        }

        $count = 0;
        $errors = [];

        foreach ($request->ids as $id) {
            $user = User::find($id);

            if (!$user->hasAnyRole(['admin', 'instructor'])) {
                continue;
            }

            if ($request->action == 'delete') {
                // Skip if last admin
                if ($user->hasRole('admin') && User::role('admin')->count() <= 1) {
                    $errors[] = "Cannot delete last admin: {$user->name}";
                    continue;
                }

                // Delete avatar
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }

                $user->delete();
                $count++;

            } elseif ($request->action == 'verify') {
                $user->update(['email_verified_at' => now()]);
                $count++;

            } elseif ($request->action == 'activate') {
                $user->update(['email_verified_at' => now()]);
                $count++;

            } elseif ($request->action == 'deactivate') {
                // Skip if last admin
                if ($user->hasRole('admin') && User::role('admin')->count() <= 1) {
                    $errors[] = "Cannot deactivate last admin: {$user->name}";
                    continue;
                }
                $user->update(['email_verified_at' => null]);
                $count++;
            }
        }

        $message = "{$count} staff member(s) updated successfully.";
        if (!empty($errors)) {
            $message .= " " . implode('. ', $errors);
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'count' => $count,
            'errors' => $errors
        ]);
    }

    /**
     * Get staff statistics for dashboard
     */
    public function getStats()
    {
        return response()->json([
            'total_admins' => User::role('admin')->where('id', '!=', auth()->id())->count(),
            'total_instructors' => User::role('instructor')->count(),
            'active_today' => User::whereIn('id', function ($q) {
                $q->select('model_id')
                    ->from('model_has_roles')
                    ->whereIn('role_id', function ($q2) {
                        $q2->select('id')->from('roles')->whereIn('name', ['admin', 'instructor']);
                    });
            })->where('updated_at', '>=', now()->startOfDay())->count(),
            'pending_verification' => User::whereIn('id', function ($q) {
                $q->select('model_id')
                    ->from('model_has_roles')
                    ->whereIn('role_id', function ($q2) {
                        $q2->select('id')->from('roles')->whereIn('name', ['admin', 'instructor']);
                    });
            })->whereNull('email_verified_at')->count(),
        ]);
    }
}