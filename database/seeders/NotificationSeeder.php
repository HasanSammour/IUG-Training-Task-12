<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Carbon\Carbon;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $startDate = Carbon::parse('2024-01-01');
        $endDate = Carbon::parse('2026-02-15');
        
        $students = User::role('student')->get();
        $instructors = User::role('instructor')->get();
        $courses = Course::all();
        
        $notificationCount = 0;
        
        // Notifications for students
        foreach ($students as $student) {
            // Calculate number of notifications based on student activity
            $studentAge = $student->created_at->diffInMonths($endDate);
            $baseNotifications = min(50, max(10, $studentAge * 3));
            
            // Add some randomness
            $numNotifications = rand($baseNotifications - 5, $baseNotifications + 10);
            
            for ($i = 0; $i < $numNotifications; $i++) {
                $createdAt = $this->randomDate(
                    $student->created_at->copy()->addDays(rand(1, 30)),
                    $endDate
                );
                
                $type = $this->getWeightedNotificationType();
                $notification = $this->generateNotification($student, $type, $courses, $createdAt);
                
                if ($notification) {
                    Notification::create($notification);
                    $notificationCount++;
                }
            }
        }
        
        // Notifications for instructors (fewer)
        foreach ($instructors as $instructor) {
            $numNotifications = rand(20, 50);
            
            for ($i = 0; $i < $numNotifications; $i++) {
                $createdAt = $this->randomDate(
                    $instructor->created_at->copy()->addDays(rand(1, 30)),
                    $endDate
                );
                
                $type = $this->getWeightedNotificationType('instructor');
                $notification = $this->generateNotification($instructor, $type, $courses, $createdAt, true);
                
                if ($notification) {
                    Notification::create($notification);
                    $notificationCount++;
                }
            }
        }
        
        $this->command->info("✅ {$notificationCount} Notifications created successfully!");
    }

    private function getWeightedNotificationType($role = 'student'): string
    {
        if ($role == 'student') {
            $types = ['progress', 'achievement', 'reminder', 'course', 'enrollment', 'system'];
            $weights = [35, 15, 20, 15, 10, 5]; // Progress notifications are most common
        } else {
            $types = ['enrollment', 'system', 'reminder', 'course'];
            $weights = [40, 30, 20, 10];
        }
        
        $totalWeight = array_sum($weights);
        $rand = rand(1, $totalWeight);
        
        $currentWeight = 0;
        foreach ($weights as $index => $weight) {
            $currentWeight += $weight;
            if ($rand <= $currentWeight) {
                return $types[$index];
            }
        }
        
        return 'progress';
    }

    private function generateNotification($user, $type, $courses, $createdAt, $isInstructor = false)
    {
        $course = $courses->random();
        $isRead = rand(1, 100) <= 60; // 60% are read
        
        switch ($type) {
            case 'progress':
                if ($isInstructor) return null;
                
                $progress = rand(25, 100);
                $titles = [
                    'Great Progress!',
                    'Keep It Up!',
                    'You\'re Making Progress',
                    'Almost There!',
                    'Milestone Achieved',
                ];
                
                return [
                    'user_id' => $user->id,
                    'title' => $titles[array_rand($titles)],
                    'message' => "You've completed {$progress}% of '{$course->title}'. Keep going!",
                    'type' => 'progress',
                    'is_read' => $isRead,
                    'data' => json_encode(['course_id' => $course->id, 'progress' => $progress]),
                    'action_url' => '/courses/' . $course->id . '/continue',
                    'action_text' => 'Continue Learning',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];
                
            case 'achievement':
                if ($isInstructor) return null;
                
                $achievements = [
                    'First Course Completed',
                    '7-Day Streak',
                    '30-Day Streak',
                    'Perfect Quiz Score',
                    'Early Bird',
                    'Night Owl',
                    'Fast Learner',
                    'Top Performer',
                    'Course Collector',
                ];
                
                $achievement = $achievements[array_rand($achievements)];
                
                return [
                    'user_id' => $user->id,
                    'title' => '🏆 Achievement Unlocked!',
                    'message' => "Congratulations! You've earned the '{$achievement}' badge.",
                    'type' => 'achievement',
                    'is_read' => $isRead,
                    'data' => json_encode(['achievement' => $achievement]),
                    'action_url' => '/profile/achievements',
                    'action_text' => 'View Badge',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];
                
            case 'reminder':
                $titles = [
                    'Don\'t Forget to Learn!',
                    'Your Courses Await',
                    'Learning Reminder',
                    'Stay on Track',
                    'Daily Reminder',
                ];
                
                return [
                    'user_id' => $user->id,
                    'title' => $titles[array_rand($titles)],
                    'message' => $isInstructor 
                        ? 'You have pending messages from students.' 
                        : "You haven't studied in a while. Continue your learning journey!",
                    'type' => 'reminder',
                    'is_read' => $isRead,
                    'data' => null,
                    'action_url' => $isInstructor ? '/instructor/dashboard' : '/dashboard',
                    'action_text' => 'Go to Dashboard',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];
                
            case 'course':
                $titles = [
                    'New Course Alert!',
                    'Recommended For You',
                    'Course Update',
                    'New Content Available',
                ];
                
                return [
                    'user_id' => $user->id,
                    'title' => $titles[array_rand($titles)],
                    'message' => $isInstructor
                        ? "New enrollment in your course '{$course->title}'"
                        : "New course added: '{$course->title}'. Check it out!",
                    'type' => 'course',
                    'is_read' => $isRead,
                    'data' => json_encode(['course_id' => $course->id]),
                    'action_url' => '/courses/' . $course->slug,
                    'action_text' => 'View Course',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];
                
            case 'enrollment':
                if ($isInstructor) {
                    return [
                        'user_id' => $user->id,
                        'title' => 'New Student Enrolled',
                        'message' => "A new student has enrolled in your course '{$course->title}'",
                        'type' => 'enrollment',
                        'is_read' => $isRead,
                        'data' => json_encode(['course_id' => $course->id]),
                        'action_url' => '/instructor/courses/' . $course->id . '/students',
                        'action_text' => 'View Students',
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ];
                } else {
                    return [
                        'user_id' => $user->id,
                        'title' => 'Enrollment Confirmed',
                        'message' => "You're now enrolled in '{$course->title}'. Start learning today!",
                        'type' => 'enrollment',
                        'is_read' => $isRead,
                        'data' => json_encode(['course_id' => $course->id]),
                        'action_url' => '/my-courses/' . $course->id,
                        'action_text' => 'Start Learning',
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ];
                }
                
            case 'system':
                $systemMessages = [
                    'Platform Update: New features available!',
                    'Maintenance scheduled for tomorrow',
                    'Ramadan hours announcement',
                    'New payment methods added',
                    'Download your certificates now',
                    'Course creation workshop next week',
                ];
                
                return [
                    'user_id' => $user->id,
                    'title' => '📢 System Update',
                    'message' => $systemMessages[array_rand($systemMessages)],
                    'type' => 'system',
                    'is_read' => $isRead,
                    'data' => null,
                    'action_url' => '/announcements',
                    'action_text' => 'Learn More',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ];
        }
        
        return null;
    }

    private function randomDate(Carbon $start, Carbon $end): Carbon
    {
        $randomTimestamp = rand($start->timestamp, $end->timestamp);
        return Carbon::createFromTimestamp($randomTimestamp);
    }
}