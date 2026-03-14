<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
    
        $user = Auth::user();
    
        $user->update(['last_login_at' => now()]);
        
        // ONLY check email verification for STUDENTS
        // Admin and instructors don't need email verification
        if ($user->hasRole('student') && !$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        // Role-based redirection
        if ($user->hasRole('admin')) {
            $redirectRoute = 'admin.dashboard';
        } elseif ($user->hasRole('instructor')) {
            $redirectRoute = 'instructor.dashboard';
        } else {
            $redirectRoute = 'dashboard'; // Student dashboard
        }
    
        // Check if user needs onboarding (only students)
        $needsOnboarding = $user->hasRole('student') ? $user->needsOnboarding() : false;

        if ($needsOnboarding) {
            session(['show_onboarding' => true]);
            $user->update(['onboarding_shown_at' => now()]);
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'redirect' => route($redirectRoute),
                'show_onboarding' => $needsOnboarding,
            ]);
        }
    
        return redirect()->intended(route($redirectRoute, absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'redirect' => route('home')
            ]);
        }

        return redirect('/');
    }
}