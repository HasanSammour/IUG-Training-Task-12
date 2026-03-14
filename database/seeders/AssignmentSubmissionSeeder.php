<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssignmentSubmission;
use App\Models\CourseAssignment;
use App\Models\Enrollment;
use Carbon\Carbon;


class AssignmentSubmissionSeeder extends Seeder
{
    public function run(): void
    {
        $assignments = CourseAssignment::all();
        $endDate = Carbon::parse('2026-12-31'); // End date
        
        $submissionCount = 0;
        
        foreach ($assignments as $assignment) {
            // Get students enrolled in this course
            $enrolledStudents = Enrollment::where('course_id', $assignment->course_id)
                ->whereIn('status', ['active', 'completed'])
                ->get();
            
            if ($enrolledStudents->isEmpty()) continue;
            
            foreach ($enrolledStudents as $enrollment) {
                // Submission rate based on enrollment status
                $submissionRate = $enrollment->status == 'completed' ? 95 : 70;
                
                if (rand(1, 100) > $submissionRate) continue;
                
                //  Determine submission status based on due date
                $now = Carbon::now();
                $dueDate = $assignment->due_date;
                
                if ($dueDate->gt($endDate)) {
                    // Due date is after our range, adjust
                    $dueDate = $endDate->copy()->subDays(rand(1, 30));
                }
                
                if ($now->lt($dueDate)) {
                    // Future due date - not submitted yet
                    $status = 'pending';
                    $submittedAt = null;
                    $grade = null;
                    $feedback = null;
                } elseif ($now->between($dueDate, $dueDate->copy()->addDays(7))) {
                    // Recently due - some submitted, some pending
                    if (rand(1, 100) <= 80) {
                        $status = 'submitted';
                        $submittedAt = $this->randomDate($dueDate->copy()->subDays(rand(1, 5)), $now);
                        $grade = null;
                        $feedback = null;
                    } else {
                        $status = 'pending';
                        $submittedAt = null;
                        $grade = null;
                        $feedback = null;
                    }
                } else {
                    // Past due
                    $daysLate = $now->diffInDays($dueDate);
                    
                    if ($daysLate > 30 || rand(1, 100) <= 20) {
                        // Never submitted or very late
                        $status = 'pending';
                        $submittedAt = null;
                        $grade = null;
                        $feedback = null;
                    } else {
                        $status = rand(1, 100) <= 70 ? 'submitted' : 'late';
                        $submittedAt = $this->randomDate(
                            $dueDate,
                            min($dueDate->copy()->addDays(14), $now)
                        );
                        
                        // 40% chance of being graded
                        if (rand(1, 100) <= 40) {
                            $status = 'graded';
                            $grade = rand(60, 100);
                            $feedback = $this->getRandomFeedback($grade);
                        }
                    }
                }
                
                AssignmentSubmission::create([
                    'course_assignment_id' => $assignment->id,
                    'user_id' => $enrollment->user_id,
                    'submission_text' => in_array($status, ['submitted', 'late', 'graded']) ? $this->getRandomSubmission() : null,
                    'file_path' => in_array($status, ['submitted', 'late', 'graded']) && rand(0, 2) ? 'submissions/assignment_' . $assignment->id . '_user_' . $enrollment->user_id . '.pdf' : null,
                    'grade' => $grade,
                    'feedback' => $feedback,
                    'status' => $status,
                    'submitted_at' => $submittedAt,
                    'created_at' => $submittedAt ?? Carbon::now(),
                    'updated_at' => $grade ? $this->randomDate($submittedAt ?? Carbon::now(), Carbon::now()) : ($submittedAt ?? Carbon::now()),
                ]);
                
                $submissionCount++;
            }
        }
        
        $this->command->info("✅ {$submissionCount} Assignment submissions created successfully!");
    }

    private function getRandomSubmission(): string
    {
        $submissions = [
            "Here is my completed assignment. I've attached the files and screenshots as requested.",
            "I've completed all tasks. Please let me know if anything needs revision.",
            "This was challenging but I learned a lot. Looking forward to your feedback.",
            "I've attached my solution with detailed comments explaining my approach.",
            "Assignment completed. I particularly enjoyed the practical part.",
            "Please find my submission attached. I spent extra time on the bonus section.",
            "Here's my work. I had some difficulty with task 3 but did my best.",
            "Completed all exercises. The project was very helpful for understanding the concepts.",
            "Submission attached. I've included both the code and documentation.",
            "Final version attached. I incorporated feedback from the previous assignment.",
        ];
        
        return $submissions[array_rand($submissions)];
    }

    private function getRandomFeedback($grade): string
    {
        if ($grade >= 90) {
            $feedbacks = [
                "Excellent work! Your solution is well-structured and shows deep understanding.",
                "Outstanding submission. You went above and beyond the requirements.",
                "Perfect! This is exactly what we were looking for.",
                "Great job! Your approach to problem-solving is impressive.",
            ];
        } elseif ($grade >= 75) {
            $feedbacks = [
                "Good work. A few minor improvements could make it excellent.",
                "Solid submission. You understood the core concepts well.",
                "Well done. Consider adding more comments to explain your reasoning.",
                "Good job. Try to optimize the solution for better performance.",
            ];
        } else {
            $feedbacks = [
                "You're on the right track but need to review the core concepts.",
                "Some parts need revision. Please schedule a meeting to discuss.",
                "Make sure to follow the assignment requirements more closely.",
                "Let's review this together. Schedule time during office hours.",
            ];
        }
        
        return $feedbacks[array_rand($feedbacks)];
    }

    private function randomDate(Carbon $start, Carbon $end): Carbon
    {
        $randomTimestamp = rand($start->timestamp, $end->timestamp);
        return Carbon::createFromTimestamp($randomTimestamp);
    }
}