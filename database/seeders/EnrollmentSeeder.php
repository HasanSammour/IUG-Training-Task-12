<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\User;
use App\Models\Course;
use Carbon\Carbon;

class EnrollmentSeeder extends Seeder
{
    private $paymentMethods = ['credit_card', 'paypal', 'bank_transfer', 'apple_pay', 'mada', 'stc_pay'];
    private $statuses = ['active', 'completed', 'cancelled'];

    public function run(): void
    {
        $startDate = Carbon::parse('2024-01-01');
        $endDate = Carbon::parse('2026-02-15');
        
        $students = User::role('student')->get();
        $courses = Course::all();
        
        $enrollmentCount = 0;
        
        foreach ($students as $student) {
            // Determine how many courses this student enrolls in based on when they joined
            $studentAge = $student->created_at->diffInMonths($endDate);
            
            // Students who joined earlier have more enrollments
            if ($studentAge > 18) { // Joined in early 2024
                $enrollmentRange = [8, 15];
            } elseif ($studentAge > 10) { // Joined in mid-late 2024
                $enrollmentRange = [5, 10];
            } elseif ($studentAge > 4) { // Joined in 2025
                $enrollmentRange = [3, 7];
            } else { // Joined in 2026
                $enrollmentRange = [1, 3];
            }
            
            $numEnrollments = rand($enrollmentRange[0], $enrollmentRange[1]);
            
            // Get random courses, ensuring no duplicates for this student
            $enrolledCourseIds = [];
            for ($i = 0; $i < $numEnrollments; $i++) {
                $availableCourses = $courses->whereNotIn('id', $enrolledCourseIds);
                if ($availableCourses->isEmpty()) break;
                
                $course = $availableCourses->random();
                $enrolledCourseIds[] = $course->id;
                
                // Determine enrollment date (after student joined, before end date)
                $enrollmentDate = $this->randomDate(
                    $student->created_at->copy()->addDays(rand(0, 30)),
                    $endDate->copy()->subDays(rand(0, 30))
                );
                
                // Determine status based on enrollment date
                $daysSinceEnrollment = $endDate->diffInDays($enrollmentDate);
                $courseDurationWeeks = (int) filter_var($course->duration, FILTER_SANITIZE_NUMBER_INT) ?: 8;
                $courseDurationDays = $courseDurationWeeks * 7;
                
                if ($daysSinceEnrollment > $courseDurationDays + 30) {
                    // Enough time passed, likely completed
                    $status = 'completed';
                    $progress = 100;
                    $completedAt = $enrollmentDate->copy()->addDays($courseDurationDays + rand(-5, 10));
                } elseif ($daysSinceEnrollment > 7) {
                    // In progress
                    $status = 'active';
                    $progress = min(95, rand(15, 90));
                    $completedAt = null;
                } else {
                    // Just enrolled
                    $status = rand(0, 3) ? 'active' : 'pending'; // Mostly active
                    $progress = $status == 'active' ? rand(1, 10) : 0;
                    $completedAt = null;
                }
                
                // Small chance of cancellation
                if (rand(0, 10) == 0 && $status != 'completed') {
                    $status = 'cancelled';
                    $progress = rand(5, 40);
                }
                
                // Generate unique enrollment ID
                $enrollmentId = 'ENR-' . $enrollmentDate->format('Ymd') . '-' . 
                               strtoupper(substr(md5($student->id . $course->id . rand()), 0, 6));
                
                // Amount paid (could be discounted price or full price)
                $amountPaid = $course->discounted_price ?? $course->price;
                // Occasionally pay full price even if discount available
                if ($course->discounted_price && rand(0, 4) == 0) {
                    $amountPaid = $course->price;
                }
                
                Enrollment::create([
                    'user_id' => $student->id,
                    'course_id' => $course->id,
                    'enrollment_id' => $enrollmentId,
                    'amount_paid' => $amountPaid,
                    'payment_method' => $this->paymentMethods[array_rand($this->paymentMethods)],
                    'status' => $status,
                    'progress_percentage' => $progress,
                    'enrolled_at' => $enrollmentDate,
                    'completed_at' => $completedAt,
                    'notes' => rand(0, 3) ? null : $this->getRandomNote($status),
                    'created_at' => $enrollmentDate,
                    'updated_at' => $this->randomDate($enrollmentDate, $endDate),
                ]);
                
                $enrollmentCount++;
            }
        }
        
        // Update course total_students counts
        foreach ($courses as $course) {
            $count = Enrollment::where('course_id', $course->id)
                ->whereIn('status', ['active', 'completed'])
                ->count();
            $course->total_students = $count;
            $course->save();
        }
        
        $this->command->info("✅ {$enrollmentCount} Enrollments created successfully!");
    }

    private function getRandomNote($status): string
    {
        $notes = [
            'Enrolled during Ramadan promotion',
            'Used discount code: EDU50',
            'Corporate training enrollment',
            'Gift from employer',
            'Referred by friend',
            'Bought during Black Friday sale',
            'National Day special offer',
            'Bundle purchase with 3 other courses',
        ];
        
        $statusNotes = [
            'active' => ['Making good progress', 'Struggling with assignments', 'Very engaged in discussions'],
            'completed' => ['Excellent student', 'Completed ahead of schedule', 'Requested certificate'],
            'cancelled' => ['Requested refund', 'Too busy with work', 'Found course too basic'],
        ];
        
        if (rand(0, 1) && isset($statusNotes[$status])) {
            return $statusNotes[$status][array_rand($statusNotes[$status])];
        }
        
        return $notes[array_rand($notes)];
    }

    private function randomDate(Carbon $start, Carbon $end): Carbon
    {
        $randomTimestamp = rand($start->timestamp, $end->timestamp);
        return Carbon::createFromTimestamp($randomTimestamp);
    }
}