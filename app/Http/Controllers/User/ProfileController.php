<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Message;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();

        // Common data for all users
        $data = [
            'user' => $user,
            'recentActivities' => $this->getRecentActivities($user),
            'unreadMessages' => Message::where('receiver_id', $user->id)
                ->where('is_read', false)
                ->count(),
        ];

        // Role-specific data
        if ($user->hasRole('admin')) {
            $data['totalCourses'] = Course::count();
            $data['totalStudents'] = User::role('student')->count();
            $data['totalInstructors'] = User::role('instructor')->count();
            $data['totalEnrollments'] = Enrollment::count();
            $data['recentEnrollments'] = Enrollment::with(['user', 'course'])
                ->latest()
                ->take(5)
                ->get();

        } elseif ($user->hasRole('instructor')) {
            $data['courses'] = Course::where('instructor_name', $user->name)
                ->withCount('enrollments')
                ->get();
            $data['totalStudents'] = Enrollment::whereIn(
                'course_id',
                Course::where('instructor_name', $user->name)->pluck('id')
            )->count();
            $data['totalRevenue'] = Enrollment::whereIn(
                'course_id',
                Course::where('instructor_name', $user->name)->pluck('id')
            )->sum('amount_paid');
            $data['recentStudents'] = Enrollment::whereIn(
                'course_id',
                Course::where('instructor_name', $user->name)->pluck('id')
            )->with('user', 'course')->latest()->take(5)->get();
            $data['averageRating'] = round($data['courses']->avg('rating') ?? 0, 1);

            // Ensure these are set even if zero
            $data['totalStudents'] = $data['totalStudents'] ?? 0;
            $data['totalRevenue'] = $data['totalRevenue'] ?? 0;

        } else { // Student
            $data['enrollments'] = $user->enrollments()
                ->with('course')
                ->latest()
                ->take(5)
                ->get();
            $data['totalCourses'] = $user->enrollments()->count();
            $data['completedCourses'] = $user->enrollments()
                ->where('status', 'completed')
                ->count();
            $data['learningPath'] = $user->learningPaths()->first();
            $data['totalSpent'] = $user->enrollments()->sum('amount_paid');

            // Ensure these are set even if zero/null
            $data['learningPath'] = $data['learningPath'] ?? (object) ['title' => 'No learning path', 'progress_percentage' => 0];
            $data['totalSpent'] = $data['totalSpent'] ?? 0;
        }

        return view('profile.edit', $data);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:500'],
            'company' => ['nullable', 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:255'],
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'bio', 'company', 'job_title']));

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $path]);
        }

        return back()->with('success', 'Avatar updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = auth()->user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function settings()
    {
        $user = auth()->user();
        $settings = $user->settings ?? [
            'notifications' => true,
            'email_updates' => true,
            'dark_mode' => false,
            'language' => 'en',
        ];

        $unreadMessages = Message::where('receiver_id', $user->id)
            ->where('is_read', false)
            ->count();

        return view('profile.settings', compact('user', 'settings', 'unreadMessages'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'notifications' => ['boolean'],
            'email_updates' => ['boolean'],
            'dark_mode' => ['boolean'],
            'language' => ['in:en,ar'],
        ]);

        $user = auth()->user();
        $user->update([
            'settings' => $request->only(['notifications', 'email_updates', 'dark_mode', 'language']),
        ]);

        return back()->with('success', 'Settings updated successfully.');
    }

    private function getRecentActivities($user)
    {
        $activities = [];

        // Recent enrollments
        $enrollments = $user->enrollments()
            ->with('course')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($enrollment) {
                return [
                    'type' => 'enrollment',
                    'icon' => 'book-open',
                    'title' => 'Enrolled in ' . $enrollment->course->title,
                    'description' => 'Progress: ' . $enrollment->progress_percentage . '%',
                    'time' => $enrollment->enrolled_at->diffForHumans(),
                    'timestamp' => $enrollment->enrolled_at->timestamp,
                ];
            })
            ->toArray();

        // Recent completions
        $completions = $user->enrollments()
            ->where('status', 'completed')
            ->with('course')
            ->latest('completed_at')
            ->take(2)
            ->get()
            ->map(function ($enrollment) {
                return [
                    'type' => 'completion',
                    'icon' => 'check-circle',
                    'title' => 'Completed ' . $enrollment->course->title,
                    'description' => 'Congratulations!',
                    'time' => $enrollment->completed_at ? $enrollment->completed_at->diffForHumans() : 'Recently',
                    'timestamp' => $enrollment->completed_at ? $enrollment->completed_at->timestamp : $enrollment->updated_at->timestamp,
                ];
            })
            ->toArray();

        // Recent notifications
        $notifications = $user->notifications()
            ->latest()
            ->take(2)
            ->get()
            ->map(function ($notification) {
                return [
                    'type' => 'notification',
                    'icon' => $notification->type_icon ?? 'bell',
                    'title' => $notification->title,
                    'description' => $notification->message,
                    'time' => $notification->created_at->diffForHumans(),
                    'timestamp' => $notification->created_at->timestamp,
                ];
            })
            ->toArray();

        // Recent messages
        $messages = Message::where('receiver_id', $user->id)
            ->orWhere('sender_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->take(2)
            ->get()
            ->map(function ($message) use ($user) {
                $otherUser = ($message->sender_id == $user->id) ? $message->receiver : $message->sender;
                return [
                    'type' => 'message',
                    'icon' => 'envelope',
                    'title' => $message->sender_id == $user->id ? 'Message to ' . $otherUser->name : 'Message from ' . $otherUser->name,
                    'description' => substr($message->message, 0, 50) . (strlen($message->message) > 50 ? '...' : ''),
                    'time' => $message->created_at->diffForHumans(),
                    'timestamp' => $message->created_at->timestamp,
                ];
            })
            ->toArray();

        // Merge all activities into one array
        $activities = array_merge($enrollments, $completions, $notifications, $messages);

        // Sort by timestamp descending (newest first)
        usort($activities, function ($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });

        // Take first 8 and remove timestamps
        $activities = array_slice($activities, 0, 8);

        // Remove timestamp field before returning
        foreach ($activities as &$activity) {
            unset($activity['timestamp']);
        }

        return $activities;
    }
}