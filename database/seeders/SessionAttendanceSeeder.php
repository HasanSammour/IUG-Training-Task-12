<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SessionAttendance;
use App\Models\CourseSession;
use App\Models\Enrollment;
use App\Models\User;
use Carbon\Carbon;

class SessionAttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $sessions = CourseSession::whereIn('status', ['completed', 'ongoing'])->get();
        $students = User::role('student')->get();
        
        $attendanceCount = 0;
        
        foreach ($sessions as $session) {
            // Get students enrolled in this course
            $enrolledStudents = Enrollment::where('course_id', $session->course_id)
                ->whereIn('status', ['active', 'completed'])
                ->pluck('user_id')
                ->toArray();
            
            if (empty($enrolledStudents)) continue;
            
            // Determine attendance rate based on session type/time
            $hour = $session->start_time->format('H');
            $isWeekend = $session->start_time->isWeekend();
            $isEarlyMorning = $hour < 10;
            $isLateEvening = $hour > 18;
            
            // Base attendance rate 70-90%
            $baseRate = 80;
            
            // Adjust based on factors
            if ($isWeekend) $baseRate -= 15;
            if ($isEarlyMorning) $baseRate -= 10;
            if ($isLateEvening) $baseRate -= 5;
            
            $baseRate = max(40, min(95, $baseRate));
            
            foreach ($enrolledStudents as $studentId) {
                // Random attendance based on rate
                $attended = rand(1, 100) <= $baseRate;
                
                // Add instructor notes for some attendees
                $hasNotes = $attended && rand(1, 100) <= 20;
                
                SessionAttendance::create([
                    'course_session_id' => $session->id,
                    'user_id' => $studentId,
                    'attended' => $attended,
                    'instructor_notes' => $hasNotes ? $this->getRandomNote() : null,
                    'created_at' => $session->start_time->copy()->addHours(rand(1, 24)),
                    'updated_at' => $session->start_time->copy()->addHours(rand(1, 48)),
                ]);
                
                $attendanceCount++;
            }
        }
        
        $this->command->info("✅ {$attendanceCount} Session attendance records created successfully!");
    }

    private function getRandomNote(): string
    {
        $notes = [
            'Active participant - asked great questions',
            'Excellent contribution to discussion',
            'Arrived 10 minutes late',
            'Left early after 1 hour',
            'Participated in group activity',
            'Needs to work on engagement',
            'Showed good understanding of concepts',
            'Helped other students during workshop',
            'Presented project work - excellent',
            'Had technical issues with audio',
        ];
        
        return $notes[array_rand($notes)];
    }

    private function randomDate(Carbon $start, Carbon $end): Carbon
    {
        $randomTimestamp = rand($start->timestamp, $end->timestamp);
        return Carbon::createFromTimestamp($randomTimestamp);
    }
}