<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Log the verification email
        Log::info('EMAIL VERIFICATION:', [
            'to' => $request->user()->email,
            'user_id' => $request->user()->id,
            'user_name' => $request->user()->name,
            'type' => 'email_verification',
            'verification_url' => 'http://127.0.0.1:8000/verify-email/' . $request->user()->id . '/' . sha1($request->user()->email),
            'message' => 'Click the link below to verify your email:'
        ]);

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}