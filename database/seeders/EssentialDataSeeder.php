<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Carbon\Carbon;

class EssentialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if we already have users (avoid duplicate seeding)
        if (User::count() > 0) {
            if ($this->command) {
                $this->command->info('Users already exist. Skipping essential data seeding.');
            }
            return;
        }

        if ($this->command) {
            $this->command->info('Starting essential data seeding...');
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Clear permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Create permissions
        $this->createPermissions();
        
        // Create roles
        $this->createRoles();
        
        // Create admin user
        $this->createAdminUser();
        
        // Create essential categories
        $this->createEssentialCategories();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        if ($this->command) {
            $this->command->info('✅ Essential data seeded successfully!');
            $this->command->info('📧 Admin Email: admin@edulink.com');
            $this->command->info('🔑 Admin Password: admin123');
        }
    }
    
    private function createPermissions()
    {
        $permissions = [
            // Dashboard permissions
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
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }
    }
    
    private function createRoles()
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $instructorRole = Role::firstOrCreate(['name' => 'instructor', 'guard_name' => 'web']);
        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'web']);
        
        // Assign all permissions to admin
        $adminRole->givePermissionTo(Permission::all());
        
        // Assign instructor permissions
        $instructorRole->givePermissionTo([
            'access_instructor_dashboard',
            'view_courses',
            'create_courses',
            'edit_courses',
            'view_enrollments',
            'view_learning_paths',
            'view_reviews',
        ]);
        
        // Assign student permissions
        $studentRole->givePermissionTo([
            'access_student_dashboard',
            'view_courses',
            'view_learning_paths',
            'view_notifications',
            'view_wishlists',
        ]);
    }
    
    private function createAdminUser()
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@edulink.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('admin123'),
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );
        
        $admin->assignRole('admin');
    }
    
    private function createEssentialCategories()
    {
        $categories = [
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'icon' => 'fa-code',
                'color' => '#3B82F6',
                'description' => 'Learn front-end and back-end web development.',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Data Science',
                'slug' => 'data-science',
                'icon' => 'fa-chart-line',
                'color' => '#10B981',
                'description' => 'Master data analysis and machine learning.',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Business & Marketing',
                'slug' => 'business-marketing',
                'icon' => 'fa-briefcase',
                'color' => '#8B5CF6',
                'description' => 'Develop business skills and marketing strategies.',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}