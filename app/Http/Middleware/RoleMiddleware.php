<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Check if user has any of the required roles
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Unauthorized. You need one of these roles: ' . implode(', ', $roles)
            ], 403);
        }

        // Redirect based on user's dashboard permission
        if ($user->hasPermissionTo('access_admin_dashboard')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasPermissionTo('access_instructor_dashboard')) {
            return redirect()->route('instructor.dashboard');
        } elseif ($user->hasPermissionTo('access_student_dashboard')) {
            return redirect()->route('dashboard'); // Student dashboard
        }

        return redirect()->route('login');
    }
}
