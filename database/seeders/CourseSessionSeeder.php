<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseSession;
use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CourseSessionSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        CourseSession::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $today = Carbon::now();

        $courses = Course::all();
        $instructors = User::role('instructor')->get();

        $sessionCount = 0;

        foreach ($courses as $course) {
            $instructor = $instructors->random();

            // Each course gets 12-24 sessions (4-8 per year)
            $numSessions = rand(12, 24);

            for ($i = 0; $i < $numSessions; $i++) {
                // Distribute evenly across 2024-2026
                $year = rand(2024, 2026);
                $month = rand(1, 12);
                $day = rand(1, 28); // Avoid invalid dates

                $sessionDate = Carbon::create($year, $month, $day, rand(9, 18), rand(0, 50), 0);

                $durationHours = rand(1, 3);
                $endTime = $sessionDate->copy()->addHours($durationHours);

                // Status based on date
                if ($sessionDate->lt($today)) {
                    // Past session
                    $statusRand = rand(1, 100);
                    if ($statusRand <= 80) {
                        $status = 'completed';
                    } elseif ($statusRand <= 95) {
                        $status = 'cancelled';
                    } else {
                        $status = 'ongoing';
                    }
                } else {
                    // Future session
                    $statusRand = rand(1, 100);
                    if ($statusRand <= 85) {
                        $status = 'scheduled';
                    } else {
                        $status = 'cancelled';
                    }
                }

                $hasRecording = $status == 'completed' && rand(0, 2) ? true : false;

                CourseSession::create([
                    'course_id' => $course->id,
                    'instructor_id' => $instructor->id,
                    'title' => "Session " . ($i + 1) . ": " . $this->getTopic($i),
                    'description' => "Course session covering key concepts and practical exercises.",
                    'meeting_url' => $status != 'cancelled' ? 'https://meet.google.com/abc-defg-hij' : null,
                    'recording_url' => $hasRecording ? 'https://drive.google.com/file/d/1234567890' : null,
                    'start_time' => $sessionDate,
                    'end_time' => $endTime,
                    'status' => $status,
                    'created_at' => $sessionDate->copy()->subDays(rand(1, 30)),
                    'updated_at' => $sessionDate,
                ]);

                $sessionCount++;
            }
        }

        $this->command->info("✅ {$sessionCount} Course sessions created successfully from 2024-01-01 to 2026-12-31!");

        // Show distribution
        $y2024 = CourseSession::whereYear('start_time', 2024)->count();
        $y2025 = CourseSession::whereYear('start_time', 2025)->count();
        $y2026 = CourseSession::whereYear('start_time', 2026)->count();

        $past = CourseSession::where('start_time', '<', $today)->count();
        $future = CourseSession::where('start_time', '>', $today)->count();

        $scheduled = CourseSession::where('status', 'scheduled')->count();
        $completed = CourseSession::where('status', 'completed')->count();
        $ongoing = CourseSession::where('status', 'ongoing')->count();
        $cancelled = CourseSession::where('status', 'cancelled')->count();

        $this->command->info("📊 Distribution:");
        $this->command->info("   By Year: 2024: {$y2024} | 2025: {$y2025} | 2026: {$y2026}");
        $this->command->info("   Past: {$past} | Future: {$future}");
        $this->command->info("   Status: Scheduled: {$scheduled} | Completed: {$completed} | Ongoing: {$ongoing} | Cancelled: {$cancelled}");
    }

    private function getTopic($index)
    {
        $topics = [
            'Introduction',
            'Core Concepts',
            'Hands-on Practice',
            'Q&A',
            'Project Work',
            'Review',
            'Advanced Topics',
            'Workshop',
            'Discussion',
            'Assignment Help',
            'Guest Lecture',
            'Revision'
        ];
        return $topics[$index % count($topics)];
    }
}