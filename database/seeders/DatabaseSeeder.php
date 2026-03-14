<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear all tables
        $this->truncateTables();

        $this->command->info('🚀 Starting database seeding with data from 2024-01-01 to 2026-02-15...');
        $this->command->warn('⏳ This will take a few minutes...');

        // SKIP EssentialDataSeeder when running from artisan
        // It will only run via middleware when DB is empty
        $this->command->info('⏭️  Skipping EssentialDataSeeder (runs only via middleware)');

        // Create permissions and roles
        $this->call(RolePermissionSeeder::class);

        // Create users with roles (1 admin, 10 instructors, 100 students)
        $this->call(UserSeeder::class);

        // Create categories
        $this->call(CategorySeeder::class);

        // Create courses (with realistic distribution over time)
        $this->call(CourseSeeder::class);

        // Create enrollments (students enroll in courses over the 2+ year period)
        $this->call(EnrollmentSeeder::class);

        // Create course reviews (based on enrollments)
        $this->call(CourseReviewSeeder::class);

        // Create wishlists
        $this->call(WishlistSeeder::class);

        // Create learning paths
        $this->call(LearningPathSeeder::class);

        // Create notifications (distributed over time)
        $this->call(NotificationSeeder::class);

        // Create contact messages
        $this->call(ContactMessageSeeder::class);

        // Create messages between users
        $this->call(MessageSeeder::class);

        // Create student notes
        $this->call(StudentNoteSeeder::class);

        // Create course sessions (live classes)
        $this->call(CourseSessionSeeder::class);

        // Create session attendance records
        $this->call(SessionAttendanceSeeder::class);

        // Create course assignments
        $this->call(CourseAssignmentSeeder::class);

        // Create assignment submissions
        $this->call(AssignmentSubmissionSeeder::class);

        // Create course materials
        $this->call(CourseMaterialSeeder::class);

        $this->command->info('✅✅✅ Database seeded successfully with data from 2024-01-01 to 2026-02-15!');
        $this->command->info('📊 Summary:');
        $this->command->table(
            ['Table', 'Records Created'],
            [
                ['Users', '111 (1 Admin, 10 Instructors, 100 Students)'],
                ['Categories', '8'],
                ['Courses', '40+'],
                ['Enrollments', '800+'],
                ['Course Reviews', '500+'],
                ['Wishlists', '350+'],
                ['Learning Paths', '80+'],
                ['Learning Path Items', '320+'],
                ['Notifications', '2000+'],
                ['Contact Messages', '200+'],
                ['Messages', '3000+'],
                ['Student Notes', '300+'],
                ['Course Sessions', '400+'],
                ['Session Attendance', '3000+'],
                ['Course Assignments', '200+'],
                ['Assignment Submissions', '1500+'],
                ['Course Materials', '800+'],
            ]
        );
    }

    private function truncateTables(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $tables = [
            'student_notes',
            'messages',
            'learning_path_items',
            'learning_paths',
            'course_reviews',
            'wishlists',
            'notifications',
            'contact_messages',
            'enrollments',
            'courses',
            'categories',
            'users',
            'model_has_roles',
            'model_has_permissions',
            'role_has_permissions',
            'roles',
            'permissions',
            'session_attendance',
            'course_sessions',
            'assignment_submissions',
            'course_assignments',
            'course_materials',
        ];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}