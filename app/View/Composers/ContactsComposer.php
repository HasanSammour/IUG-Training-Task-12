<?php

namespace App\View\Composers;

use App\Models\User;
use App\Models\Message;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\View\View;
use Illuminate\Support\Facades\Cache;

class ContactsComposer
{
    // ! Note: View Composers are the Laravel way to move logic out of templates.
    // ! Now instead of load This contacts list logic in each page using app layout 
    // ! we make This composer to load it only when we need it       

    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        $user = auth()->user();
        $recentContacts = collect(); // Empty collection by default

        if ($user) {
            // Use simple cache key WITHOUT tags
            $recentContacts = Cache::remember('contacts_' . $user->id, 300, function () use ($user) {
                return $this->getContactsForUser($user);
            });
        }

        $view->with('recentContacts', $recentContacts);
    }

    /**
     * Get contacts based on user role
     */
    private function getContactsForUser($user)
    {
        if ($user->hasRole('admin')) {
            return $this->getAdminContacts($user);
        } elseif ($user->hasRole('instructor')) {
            return $this->getInstructorContacts($user);
        } else {
            return $this->getStudentContacts($user);
        }
    }

    /**
     * Get contacts for admin users
     */
    private function getAdminContacts($user)
    {
        // Get recent message contacts
        $recentContacts = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($msg) use ($user) {
                return $msg->sender_id == $user->id ? $msg->receiver : $msg->sender;
            })
            ->unique('id')
            ->take(5)
            ->values();

        // Fill with random users if needed
        if ($recentContacts->count() < 5) {
            $additionalContacts = User::where('id', '!=', $user->id)
                ->whereNotIn('id', $recentContacts->pluck('id'))
                ->inRandomOrder()
                ->take(5 - $recentContacts->count())
                ->get();

            $recentContacts = $recentContacts->concat($additionalContacts);
        }

        return $recentContacts;
    }

    /**
     * Get contacts for instructor users
     */
    private function getInstructorContacts($user)
    {
        // Get course IDs for this instructor
        $courseIds = Course::where('instructor_name', $user->name)->pluck('id');

        // Get student IDs from enrollments
        $studentIds = Enrollment::whereIn('course_id', $courseIds)
            ->pluck('user_id')
            ->unique();

        // Get recent message contacts
        $recentMessages = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $recentContacts = $recentMessages->map(function ($msg) use ($user) {
            return $msg->sender_id == $user->id ? $msg->receiver : $msg->sender;
        })->unique('id')->take(3)->values();

        // Add admins
        $recentAdmins = User::role('admin')
            ->whereNotIn('id', $recentContacts->pluck('id'))
            ->take(2)
            ->get();

        $recentContacts = $recentContacts->concat($recentAdmins);

        // Add more students if needed
        if ($recentContacts->count() < 5) {
            $moreStudents = User::whereIn('id', $studentIds)
                ->whereNotIn('id', $recentContacts->pluck('id'))
                ->take(5 - $recentContacts->count())
                ->get();

            $recentContacts = $recentContacts->concat($moreStudents);
        }

        return $recentContacts;
    }

    /**
     * Get contacts for student users
     */
    private function getStudentContacts($user)
    {
        // Get courses this student is enrolled in
        $courseIds = Enrollment::where('user_id', $user->id)->pluck('course_id');

        // Get instructor names from those courses
        $instructorNames = Course::whereIn('id', $courseIds)
            ->pluck('instructor_name')
            ->unique();

        // Get recent message contacts
        $recentMessages = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $recentContacts = $recentMessages->map(function ($msg) use ($user) {
            return $msg->sender_id == $user->id ? $msg->receiver : $msg->sender;
        })->unique('id')->take(3)->values();

        // Add admins
        $recentAdmins = User::role('admin')
            ->whereNotIn('id', $recentContacts->pluck('id'))
            ->take(2)
            ->get();

        $recentContacts = $recentContacts->concat($recentAdmins);

        // Add more instructors if needed
        if ($recentContacts->count() < 5) {
            $moreInstructors = User::whereIn('name', $instructorNames)
                ->whereNotIn('id', $recentContacts->pluck('id'))
                ->take(5 - $recentContacts->count())
                ->get();

            $recentContacts = $recentContacts->concat($moreInstructors);
        }

        return $recentContacts;
    }
}