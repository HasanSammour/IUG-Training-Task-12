<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['required', 'accepted'],
        ]);
    
        $user = User::create([
            'name' => $request->name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'onboarding_completed' => false, // New user hasn't completed onboarding
        ]);
    
        $user->assignRole('student'); // Default role
    
        event(new Registered($user));
        Auth::login($user);

        // Set session flag for onboarding
        session(['show_onboarding' => true]);
    
        // Redirect new students to user dashboard
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'redirect' => route('verification.notice'), // Student only redirected to email verification Page when registered
                'show_onboarding' => true, // Always show for new users
            ]);
        }
    
        return redirect(route('verification.notice'));
    }
}