<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseAssignment;
use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;

class CourseAssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $endDate = Carbon::parse('2026-12-31'); // End on Dec 31, 2026
        
        $courses = Course::all();
        $instructors = User::role('instructor')->get();
        
        $assignmentCount = 0;
        
        foreach ($courses as $course) {
            // Find instructor for this course
            $instructor = $instructors->filter(function($instructor) use ($course) {
                return str_contains($course->instructor_name, explode(' ', $instructor->name)[1] ?? '');
            })->first() ?? $instructors->random();
            
            // Number of assignments based on course duration
            $durationWeeks = $course->duration_in_weeks ?? 8;
            $numAssignments = min(6, max(2, floor($durationWeeks / 2))); // 2-6 assignments
            
            for ($i = 1; $i <= $numAssignments; $i++) {
                // Generate due dates between now and Dec 31, 2026
                $weekNumber = floor(($i / $numAssignments) * $durationWeeks);
                
                // Create date between today and end of 2026
                $daysFromNow = rand(7, 90); // Random days from 1 week to 3 months
                $dueDate = Carbon::now()->addDays($daysFromNow);
                
                // Ensure due date is not after end date
                if ($dueDate->gt($endDate)) {
                    $dueDate = Carbon::parse('2026-12-15'); // Default to mid-December
                }
                
                $points = [50, 100, 100, 150, 200, 250][min($i - 1, 5)];
                
                CourseAssignment::create([
                    'course_id' => $course->id,
                    'instructor_id' => $instructor->id,
                    'title' => $this->getAssignmentTitle($i, $course->title),
                    'description' => $this->getAssignmentDescription($i),
                    'file_path' => rand(0, 3) ? 'assignments/' . strtolower(str_replace(' ', '_', $course->title)) . '_assignment_' . $i . '.pdf' : null,
                    'due_date' => $dueDate,
                    'points' => $points,
                    'created_at' => Carbon::now(), // Created now
                    'updated_at' => Carbon::now(),
                ]);
                
                $assignmentCount++;
            }
        }
        
        $this->command->info("✅ {$assignmentCount} Course assignments created successfully with dates until 2026-12-31!");
    }

    private function getAssignmentTitle($index, $courseTitle): string
    {
        $titles = [
            'Assignment 1: Basic Concepts',
            'Assignment 2: Practical Application',
            'Assignment 3: Mini-Project',
            'Assignment 4: Advanced Problems',
            'Assignment 5: Integration Project',
            'Final Assignment: Capstone Project',
        ];
        
        return $titles[$index - 1] ?? "Assignment {$index}";
    }

    private function getAssignmentDescription($index): string
    {
        $descriptions = [
            "Complete the exercises covering fundamental concepts. Submit your solutions as a single PDF or Word document.",
            "Apply the concepts learned to solve practical problems. Include code, screenshots, and explanations.",
            "Build a mini-project that demonstrates your understanding of the core concepts covered so far.",
            "Solve advanced problems that require critical thinking and integration of multiple concepts.",
            "Create an integration project that combines all skills learned. Document your approach and decisions.",
            "Complete the capstone project that showcases mastery of all course objectives. Include documentation and presentation.",
        ];
        
        return $descriptions[$index - 1] ?? "Complete the assignment tasks and submit before the due date.";
    }

    private function randomDate(Carbon $start, Carbon $end): Carbon
    {
        $randomTimestamp = rand($start->timestamp, $end->timestamp);
        return Carbon::createFromTimestamp($randomTimestamp);
    }
}