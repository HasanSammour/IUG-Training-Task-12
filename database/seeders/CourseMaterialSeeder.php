<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseMaterial;
use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;

class CourseMaterialSeeder extends Seeder
{
    public function run(): void
    {
        $startDate = Carbon::parse('2024-01-01');
        $endDate = Carbon::parse('2026-02-15');
        
        $courses = Course::all();
        $instructors = User::role('instructor')->get();
        
        $materialCount = 0;
        
        foreach ($courses as $course) {
            // Find instructor for this course
            $instructor = $instructors->filter(function($instructor) use ($course) {
                return str_contains($course->instructor_name, explode(' ', $instructor->name)[1] ?? '');
            })->first() ?? $instructors->random();
            
            // Number of materials based on course duration
            $durationWeeks = $course->duration_in_weeks ?? 8;
            $numMaterials = rand(8, 20); // 8-20 materials per course
            
            for ($i = 0; $i < $numMaterials; $i++) {
                $type = $this->getWeightedMaterialType();
                $orderPosition = $i;
                
                // Creation date (spread throughout course)
                $createdAt = $this->randomDate(
                    $course->created_at,
                    min($endDate, $course->created_at->copy()->addWeeks($durationWeeks + rand(0, 4)))
                );
                
                $fileSize = $type == 'video' ? rand(50, 500) : ($type == 'document' ? rand(1, 20) : rand(0, 5));
                
                CourseMaterial::create([
                    'course_id' => $course->id,
                    'instructor_id' => $instructor->id,
                    'title' => $this->getMaterialTitle($i, $type),
                    'description' => rand(0, 2) ? $this->getMaterialDescription($type) : null,
                    'file_path' => in_array($type, ['document', 'presentation', 'video']) ? 'materials/' . $course->slug . '/' . $this->getFileName($type, $i) : null,
                    'file_type' => in_array($type, ['document', 'presentation', 'video']) ? $this->getFileExtension($type) : null,
                    'external_link' => $type == 'link' ? $this->getExternalLink() : null,
                    'file_size' => $fileSize,
                    'type' => $type,
                    'order_position' => $orderPosition,
                    'created_at' => $createdAt,
                    'updated_at' => $this->randomDate($createdAt, $endDate),
                ]);
                
                $materialCount++;
            }
        }
        
        $this->command->info("✅ {$materialCount} Course materials created successfully!");
    }

    private function getWeightedMaterialType(): string
    {
        $types = ['document', 'video', 'link', 'presentation', 'other'];
        $weights = [40, 25, 20, 10, 5]; // Percentages
        
        $rand = rand(1, 100);
        $cumulative = 0;
        
        foreach ($weights as $index => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return $types[$index];
            }
        }
        
        return 'document';
    }

    private function getMaterialTitle($index, $type): string
    {
        $titles = [
            'document' => [
                'Course Syllabus',
                'Lecture Notes - Chapter 1',
                'Lecture Notes - Chapter 2',
                'Lecture Notes - Chapter 3',
                'Reading Materials',
                'Cheat Sheet',
                'Glossary of Terms',
                'Additional Resources',
                'Practice Exercises',
                'Solutions Manual',
            ],
            'video' => [
                'Introduction Video',
                'Concept Explanation',
                'Live Demo',
                'Tutorial - Part 1',
                'Tutorial - Part 2',
                'Case Study Walkthrough',
                'Expert Interview',
                'Project Showcase',
                'Revision Session',
                'Bonus Content',
            ],
            'link' => [
                'Useful Article',
                'Online Tool',
                'Documentation',
                'Community Forum',
                'Practice Platform',
                'Reference Guide',
                'Industry News',
                'Open Source Project',
                'Video Tutorial',
                'Course Repository',
            ],
            'presentation' => [
                'Week 1 Slides',
                'Week 2 Slides',
                'Week 3 Slides',
                'Week 4 Slides',
                'Project Brief',
                'Case Study Deck',
                'Guest Lecture Slides',
                'Revision Deck',
                'Workshop Materials',
                'Final Presentation Template',
            ],
        ];
        
        $typeTitles = $titles[$type] ?? $titles['document'];
        return $typeTitles[$index % count($typeTitles)];
    }

    private function getMaterialDescription($type): string
    {
        $descriptions = [
            'document' => 'Comprehensive document covering key concepts with examples and exercises.',
            'video' => 'Video explanation with visual aids and practical demonstrations.',
            'link' => 'External resource to supplement your learning and provide additional context.',
            'presentation' => 'Slide deck with visual summaries of the key topics covered.',
            'other' => 'Supplementary material to enhance your learning experience.',
        ];
        
        return $descriptions[$type] ?? 'Learning material for this course.';
    }

    private function getFileName($type, $index): string
    {
        $names = [
            'document' => ['syllabus.pdf', 'chapter1.pdf', 'chapter2.pdf', 'exercises.pdf', 'cheatsheet.pdf'],
            'presentation' => ['week1.pptx', 'week2.pptx', 'week3.pptx', 'project.pptx', 'review.pptx'],
            'video' => ['intro.mp4', 'lesson1.mp4', 'lesson2.mp4', 'demo.mp4', 'tutorial.mp4'],
        ];
        
        $typeNames = $names[$type] ?? ['material.pdf'];
        return $typeNames[$index % count($typeNames)];
    }

    private function getFileExtension($type): string
    {
        $extensions = [
            'document' => 'pdf',
            'presentation' => 'pptx',
            'video' => 'mp4',
        ];
        
        return $extensions[$type] ?? 'pdf';
    }

    private function getExternalLink(): string
    {
        $links = [
            'https://developer.mozilla.org/en-US/',
            'https://www.w3schools.com/',
            'https://stackoverflow.com/',
            'https://github.com/',
            'https://www.youtube.com/',
            'https://www.figma.com/community',
            'https://www.freecodecamp.org/',
            'https://dev.to/',
            'https://medium.com/',
            'https://www.kaggle.com/',
        ];
        
        return $links[array_rand($links)];
    }

    private function randomDate(Carbon $start, Carbon $end): Carbon
    {
        $randomTimestamp = rand($start->timestamp, $end->timestamp);
        return Carbon::createFromTimestamp($randomTimestamp);
    }
}