<?php

namespace App\Traits;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

trait ChecksCourseStatus
{
    /**
     * Check if course is active and user has permission
     * Throws exception if access is denied
     */
    protected function checkCourseStatus(Course $course)
    {
        // If user is admin, they can access everything
        if (Auth::user() && Auth::user()->hasRole('admin')) {
            return;
        }

        // If course is inactive, throw exception
        if (!$course->is_active) {
            if (request()->ajax() || request()->wantsJson()) {
                throw new HttpException(403, 'This course is inactive. Please contact an administrator to activate it first.');
            }

            throw new HttpException(403, 'This course is inactive. Please contact an administrator to activate it first.');
        }
    }

    /**
     * Check and abort if course is inactive
     */
    protected function abortIfCourseInactive(Course $course)
    {
        // Admin bypass
        if (Auth::user() && Auth::user()->hasRole('admin')) {
            return;
        }

        if (!$course->is_active) {
            abort(403, 'This course is inactive. Please contact an administrator to activate it first.');
        }
    }
}