<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $startDate = Carbon::parse('2024-01-01');
        $endDate = Carbon::parse('2026-02-15');
        
        $categories = [
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'icon' => 'fa-code',
                'color' => '#3B82F6',
                'description' => 'Learn front-end and back-end web development technologies including HTML, CSS, JavaScript, React, Vue, Angular, Node.js, Python, PHP, and more.',
                'created_at' => $startDate->copy()->addDays(1),
                'updated_at' => $this->randomDate($startDate, $endDate),
            ],
            [
                'name' => 'Data Science',
                'slug' => 'data-science',
                'icon' => 'fa-chart-line',
                'color' => '#10B981',
                'description' => 'Master data analysis, machine learning, artificial intelligence, big data technologies, Python for data science, SQL, and data visualization.',
                'created_at' => $startDate->copy()->addDays(2),
                'updated_at' => $this->randomDate($startDate, $endDate),
            ],
            [
                'name' => 'Business & Marketing',
                'slug' => 'business-marketing',
                'icon' => 'fa-briefcase',
                'color' => '#8B5CF6',
                'description' => 'Develop business skills, digital marketing strategies, entrepreneurship, management techniques, SEO, social media marketing, and analytics.',
                'created_at' => $startDate->copy()->addDays(3),
                'updated_at' => $this->randomDate($startDate, $endDate),
            ],
            [
                'name' => 'Graphic Design',
                'slug' => 'graphic-design',
                'icon' => 'fa-palette',
                'color' => '#EF4444',
                'description' => 'Learn graphic design principles, UI/UX design, Adobe Creative Suite (Photoshop, Illustrator, InDesign), Figma, and visual communication.',
                'created_at' => $startDate->copy()->addDays(4),
                'updated_at' => $this->randomDate($startDate, $endDate),
            ],
            [
                'name' => 'Mobile Development',
                'slug' => 'mobile-development',
                'icon' => 'fa-mobile-alt',
                'color' => '#F59E0B',
                'description' => 'Build mobile applications for iOS and Android using native (Swift, Kotlin) and cross-platform (Flutter, React Native) technologies.',
                'created_at' => $startDate->copy()->addDays(5),
                'updated_at' => $this->randomDate($startDate, $endDate),
            ],
            [
                'name' => 'Cybersecurity',
                'slug' => 'cybersecurity',
                'icon' => 'fa-shield-alt',
                'color' => '#6366F1',
                'description' => 'Protect systems and networks from digital attacks. Learn ethical hacking, network security, cryptography, and security best practices.',
                'created_at' => $startDate->copy()->addDays(6),
                'updated_at' => $this->randomDate($startDate, $endDate),
            ],
            [
                'name' => 'Language Learning',
                'slug' => 'language-learning',
                'icon' => 'fa-language',
                'color' => '#EC4899',
                'description' => 'Improve language skills in English, Arabic, and other languages for personal and professional growth. Business English, IELTS, TOEFL preparation.',
                'created_at' => $startDate->copy()->addDays(7),
                'updated_at' => $this->randomDate($startDate, $endDate),
            ],
            [
                'name' => 'Personal Development',
                'slug' => 'personal-development',
                'icon' => 'fa-user-graduate',
                'color' => '#06B6D4',
                'description' => 'Enhance soft skills, leadership abilities, communication, time management, productivity, and emotional intelligence.',
                'created_at' => $startDate->copy()->addDays(8),
                'updated_at' => $this->randomDate($startDate, $endDate),
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ 8 Categories created successfully!');
    }

    private function randomDate(Carbon $start, Carbon $end): Carbon
    {
        $randomTimestamp = rand($start->timestamp, $end->timestamp);
        return Carbon::createFromTimestamp($randomTimestamp);
    }
}