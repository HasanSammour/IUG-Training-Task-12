<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view courses list
        return true;
    }

    /**
     * Determine if the user can view the course.
     */
    public function view(User $user, Course $course): bool
    {
        // Everyone (including guests) can view active courses
        if ($course->is_active) {
            return true;
        }
        
        // Only admins and instructors can view inactive courses
        return $user->hasAnyRole(['admin', 'instructor']);
    }

    /**
     * Determine whether the user can create courses.
     */
    public function create(User $user): bool
    {
        // Only admins and instructors can create courses
        return $user->hasAnyRole(['admin', 'instructor']);
    }

    /**
     * Determine if the user can update the course.
     */
    public function update(User $user, Course $course): bool
    {
        // Admin can update any course
        if ($user->hasRole('admin')) {
            return true;
        }
        
        // Instructor can update only their own courses
        if ($user->hasRole('instructor') && $course->instructor_name == $user->name) {
            return true;
        }
        
        // Students cannot update courses
        return false;
    }

    /**
     * Determine whether the user can delete the course.
     */
    public function delete(User $user, Course $course): bool
    {
        // Only admin can delete courses
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Course $course): bool
    {
        // Only admin can restore courses
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Course $course): bool
    {
        // Only admin can force delete courses
        return $user->hasRole('admin');
    }

    /**
     * Determine if the user can enroll in the course.
     */
    public function enroll(User $user, Course $course): bool
    {
        // Check if course is active
        if (!$course->is_active) {
            return false;
        }
        
        // Check if user is already enrolled
        $alreadyEnrolled = $user->enrollments()
            ->where('course_id', $course->id)
            ->exists();
            
        return !$alreadyEnrolled;
    }

    /**
     * Determine if the user can view the course dashboard.
     */
    public function viewDashboard(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'instructor', 'student']);
    }

    /**
     * Determine if the user can manage courses (admin/instructor only).
     */
    public function manage(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'instructor']);
    }

    /**
     * Determine if the user can view course students (instructors only).
     */
    public function viewStudents(User $user, Course $course): bool
    {
        // Admin can view any course students
        if ($user->hasRole('admin')) {
            return true;
        }
        
        // Instructor can view only their own course students
        if ($user->hasRole('instructor') && $course->instructor_name == $user->name) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine if the user can manage course content (sessions, assignments, materials).
     */
    public function manageContent(User $user, Course $course): bool
    {
        // Admin can manage any course content
        if ($user->hasRole('admin')) {
            return true;
        }
        
        // Instructor can manage only their own course content
        if ($user->hasRole('instructor') && $course->instructor_name == $user->name) {
            return true;
        }
        
        return false;
    }
}