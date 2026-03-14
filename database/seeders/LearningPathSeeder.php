<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LearningPath;
use App\Models\LearningPathItem;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Carbon\Carbon;

class LearningPathSeeder extends Seeder
{
    private $pathTemplates = [
        [
            'title' => 'Full Stack Developer Roadmap',
            'description' => 'Complete path to become a professional full-stack web developer. From HTML/CSS to advanced frameworks and deployment.',
            'goals' => ['Master front-end development', 'Learn back-end technologies', 'Build full-stack projects', 'Deploy to cloud'],
            'is_ai_generated' => true,
            'course_count' => 6,
        ],
        [
            'title' => 'Data Scientist Career Path',
            'description' => 'Step-by-step guide to master data science and machine learning. From Python basics to advanced AI models.',
            'goals' => ['Python programming', 'Statistics fundamentals', 'Machine learning', 'Deep learning', 'Big data analytics'],
            'is_ai_generated' => true,
            'course_count' => 5,
        ],
        [
            'title' => 'Digital Marketing Specialist',
            'description' => 'Complete digital marketing learning journey. Master SEO, social media, content marketing, and analytics.',
            'goals' => ['SEO mastery', 'Social media marketing', 'Content strategy', 'Email marketing', 'Analytics'],
            'is_ai_generated' => false,
            'course_count' => 5,
        ],
        [
            'title' => 'Mobile App Developer',
            'description' => 'Become a professional mobile app developer. Learn cross-platform and native development.',
            'goals' => ['Flutter/Dart', 'iOS development', 'Android development', 'API integration', 'App store deployment'],
            'is_ai_generated' => true,
            'course_count' => 5,
        ],
        [
            'title' => 'Cybersecurity Analyst',
            'description' => 'Master cybersecurity fundamentals and become a security professional.',
            'goals' => ['Network security', 'Ethical hacking', 'Penetration testing', 'Security operations', 'Incident response'],
            'is_ai_generated' => true,
            'course_count' => 5,
        ],
        [
            'title' => 'UI/UX Design Professional',
            'description' => 'Learn user experience design and create beautiful, functional interfaces.',
            'goals' => ['Design principles', 'User research', 'Wireframing', 'Prototyping', 'Usability testing'],
            'is_ai_generated' => false,
            'course_count' => 4,
        ],
    ];

    public function run(): void
    {
        $startDate = Carbon::parse('2024-01-01');
        $endDate = Carbon::parse('2026-02-15');
        
        $students = User::role('student')->get();
        $courses = Course::all();
        
        $pathCount = 0;
        $itemCount = 0;
        
        foreach ($students as $student) {
            // 70% of students have learning paths
            if (rand(1, 100) > 70) continue;
            
            // Students can have 1-3 learning paths
            $numPaths = rand(1, 3);
            
            for ($p = 0; $p < $numPaths; $p++) {
                $template = $this->pathTemplates[array_rand($this->pathTemplates)];
                
                // Path created after student joined
                $createdAt = $this->randomDate(
                    $student->created_at->copy()->addDays(rand(5, 90)),
                    $endDate->copy()->subMonths(rand(1, 6))
                );
                
                // Get courses for this path (random, but try to match category)
                $categoryMap = [
                    'Full Stack Developer Roadmap' => 'web-development',
                    'Data Scientist Career Path' => 'data-science',
                    'Digital Marketing Specialist' => 'business-marketing',
                    'Mobile App Developer' => 'mobile-development',
                    'Cybersecurity Analyst' => 'cybersecurity',
                    'UI/UX Design Professional' => 'graphic-design',
                ];
                
                $targetCategory = $categoryMap[$template['title']] ?? null;
                $availableCourses = $courses;
                
                if ($targetCategory) {
                    // Prioritize courses from the target category
                    $categoryCourses = $courses->filter(function($course) use ($targetCategory) {
                        return $course->category->slug == $targetCategory;
                    });
                    
                    if ($categoryCourses->count() >= $template['course_count']) {
                        $availableCourses = $categoryCourses;
                    }
                }
                
                if ($availableCourses->count() < $template['course_count']) {
                    continue; // Skip if not enough courses
                }
                
                $pathCourses = $availableCourses->random($template['course_count']);
                
                // Calculate progress based on enrollments
                $enrolledCourses = Enrollment::where('user_id', $student->id)
                    ->whereIn('course_id', $pathCourses->pluck('id'))
                    ->get()
                    ->keyBy('course_id');
                
                $completedCount = 0;
                $inProgressCount = 0;
                
                foreach ($pathCourses as $course) {
                    $enrollment = $enrolledCourses->get($course->id);
                    if ($enrollment && $enrollment->status == 'completed') {
                        $completedCount++;
                    } elseif ($enrollment && $enrollment->status == 'active') {
                        $inProgressCount++;
                    }
                }
                
                $totalProgress = $completedCount + $inProgressCount;
                $progressPercentage = $template['course_count'] > 0 
                    ? round(($completedCount * 100 + $inProgressCount * rand(20, 80)) / $template['course_count'])
                    : 0;
                
                $learningPath = LearningPath::create([
                    'user_id' => $student->id,
                    'title' => $template['title'],
                    'description' => $template['description'],
                    'total_courses' => $template['course_count'],
                    'completed_courses' => $completedCount,
                    'total_weeks' => $template['course_count'] * rand(3, 6),
                    'progress_percentage' => $progressPercentage,
                    'next_milestone' => $this->getNextMilestone($completedCount, $template['course_count']),
                    'is_ai_generated' => $template['is_ai_generated'],
                    'goals' => json_encode($template['goals']),
                    'estimated_completion_date' => $createdAt->copy()->addWeeks($template['course_count'] * rand(4, 8)),
                    'created_at' => $createdAt,
                    'updated_at' => $this->randomDate($createdAt, $endDate),
                ]);
                
                $pathCount++;
                
                // Add courses to learning path
                $position = 1;
                foreach ($pathCourses as $course) {
                    $enrollment = $enrolledCourses->get($course->id);
                    
                    if ($enrollment && $enrollment->status == 'completed') {
                        $status = 'completed';
                        $progress = 100;
                        $startedAt = $enrollment->enrolled_at;
                        $completedAt = $enrollment->completed_at;
                    } elseif ($enrollment && $enrollment->status == 'active') {
                        $status = 'active';
                        $progress = $enrollment->progress_percentage;
                        $startedAt = $enrollment->enrolled_at;
                        $completedAt = null;
                    } else {
                        // Not started yet
                        $status = 'locked';
                        $progress = 0;
                        $startedAt = null;
                        $completedAt = null;
                    }
                    
                    // Unlock if previous courses are completed
                    if ($status == 'locked' && $position > 1) {
                        $previousItem = LearningPathItem::where('learning_path_id', $learningPath->id)
                            ->where('position', $position - 1)
                            ->first();
                        
                        if ($previousItem && $previousItem->status == 'completed') {
                            $status = 'active';
                        }
                    }
                    
                    LearningPathItem::create([
                        'learning_path_id' => $learningPath->id,
                        'course_id' => $course->id,
                        'position' => $position,
                        'status' => $status,
                        'progress' => $progress,
                        'notes' => rand(0, 3) ? null : 'Key course in this path',
                        'started_at' => $startedAt,
                        'completed_at' => $completedAt,
                        'created_at' => $learningPath->created_at,
                        'updated_at' => $this->randomDate($learningPath->created_at, $endDate),
                    ]);
                    
                    $itemCount++;
                    $position++;
                }
            }
        }
        
        $this->command->info("✅ {$pathCount} Learning paths created with {$itemCount} items!");
    }

    private function getNextMilestone(int $completed, int $total): string
    {
        if ($completed == 0) {
            return 'Start with the first course';
        } elseif ($completed < $total / 2) {
            return 'Complete ' . ($completed + 1) . ' of ' . $total . ' courses';
        } elseif ($completed < $total) {
            return 'Finish the remaining ' . ($total - $completed) . ' courses';
        } else {
            return 'Path completed - start building portfolio';
        }
    }

    private function randomDate(Carbon $start, Carbon $end): Carbon
    {
        $randomTimestamp = rand($start->timestamp, $end->timestamp);
        return Carbon::createFromTimestamp($randomTimestamp);
    }
}