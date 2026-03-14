<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Dashboard permissions - SEPARATE for each role!
            'access_student_dashboard',
            'access_instructor_dashboard',
            'access_admin_dashboard',

            // User permissions
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',

            // Course permissions
            'view_courses',
            'create_courses',
            'edit_courses',
            'delete_courses',
            'publish_courses',

            // Category permissions
            'view_categories',
            'create_categories',
            'edit_categories',
            'delete_categories',

            // Enrollment permissions
            'view_enrollments',
            'create_enrollments',
            'edit_enrollments',
            'delete_enrollments',

            // Review permissions
            'view_reviews',
            'approve_reviews',
            'delete_reviews',

            // Learning path permissions
            'view_learning_paths',
            'create_learning_paths',
            'edit_learning_paths',
            'delete_learning_paths',

            // Notification permissions
            'view_notifications',
            'send_notifications',
            'manage_notifications',

            // Contact message permissions
            'view_contact_messages',
            'respond_contact_messages',
            'delete_contact_messages',

            // Wishlist permissions
            'view_wishlists',
            'manage_wishlists',

            // System permissions
            'manage_settings',
            'view_reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo([
            'access_admin_dashboard',
            // Admin can view everything
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'view_courses',
            'create_courses',
            'edit_courses',
            'delete_courses',
            'publish_courses',
            'view_categories',
            'create_categories',
            'edit_categories',
            'delete_categories',
            'view_enrollments',
            'create_enrollments',
            'edit_enrollments',
            'delete_enrollments',
            'view_reviews',
            'approve_reviews',
            'delete_reviews',
            'view_learning_paths',
            'create_learning_paths',
            'edit_learning_paths',
            'delete_learning_paths',
            'view_notifications',
            'send_notifications',
            'manage_notifications',
            'view_contact_messages',
            'respond_contact_messages',
            'delete_contact_messages',
            'view_wishlists',
            'manage_wishlists',
            'manage_settings',
            'view_reports',
        ]);

        $instructorRole = Role::create(['name' => 'instructor', 'guard_name' => 'web']);
        $instructorRole->givePermissionTo([
            'access_instructor_dashboard',
            'view_courses',           // Only view their own courses
            'create_courses',         // Only create their own courses
            'edit_courses',           // Only edit their own courses
            'view_enrollments',       // Only view enrollments for their courses
            'view_learning_paths',    // Only view student learning paths in their courses
            'view_reviews',           // Only view reviews for their courses
        ]);

        $studentRole = Role::create(['name' => 'student', 'guard_name' => 'web']);
        $studentRole->givePermissionTo([
            'access_student_dashboard',
            'view_courses',
            'view_learning_paths',    // Only their own learning path
            'view_notifications',     // Only their own notifications
            'view_wishlists',         // Only their own wishlist
        ]);

        $this->command->info('✅ Roles and permissions created successfully!');
    }
}