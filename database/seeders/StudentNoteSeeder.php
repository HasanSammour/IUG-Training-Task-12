<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StudentNote;
use Carbon\Carbon;

class StudentNoteSeeder extends Seeder
{
    public function run(): void
    {
        $startDate = Carbon::parse('2024-01-01');
        $endDate = Carbon::parse('2026-02-15');
        
        $admin = User::role('admin')->first();
        $instructors = User::role('instructor')->get();
        $students = User::role('student')->get();
        
        $noteCount = 0;
        
        // Notes from instructors about students
        foreach ($instructors as $instructor) {
            // Each instructor takes notes on 10-20 students
            $numStudents = rand(10, 20);
            $selectedStudents = $students->random(min($numStudents, $students->count()));
            
            foreach ($selectedStudents as $student) {
                // 1-3 notes per student
                $numNotes = rand(1, 3);
                
                for ($i = 0; $i < $numNotes; $i++) {
                    $createdAt = $this->randomDate(
                        $student->created_at->copy()->addDays(rand(10, 60)),
                        $endDate
                    );
                    
                    $isPrivate = rand(0, 2) ? false : true; // 1/3 are private
                    
                    StudentNote::create([
                        'user_id' => $student->id,
                        'created_by' => $instructor->id,
                        'content' => $this->getInstructorNote($student, $isPrivate),
                        'is_private' => $isPrivate,
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ]);
                    
                    $noteCount++;
                }
            }
        }
        
        // Notes from admin about students
        foreach ($students->random(30) as $student) {
            $numNotes = rand(1, 3);
            
            for ($i = 0; $i < $numNotes; $i++) {
                $createdAt = $this->randomDate(
                    $student->created_at->copy()->addDays(rand(5, 90)),
                    $endDate
                );
                
                StudentNote::create([
                    'user_id' => $student->id,
                    'created_by' => $admin->id,
                    'content' => $this->getAdminNote($student),
                    'is_private' => rand(0, 1) ? true : false,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
                
                $noteCount++;
            }
        }
        
        $this->command->info("✅ {$noteCount} Student notes created successfully!");
    }

    private function getInstructorNote($student, $isPrivate): string
    {
        $publicNotes = [
            "{$student->name} is doing exceptionally well in the course. Active participant in discussions.",
            "Shows great potential. Recommended for advanced courses.",
            "Struggling with basic concepts. May need additional support.",
            "Excellent project work. Creative approach to assignments.",
            "Very engaged student. Always asks thoughtful questions.",
            "Completed all assignments ahead of schedule.",
            "Good progress but needs to work on practical applications.",
            "Helps other students in the forum. Natural leader.",
            "Requested guidance on career path after course completion.",
            "Strong technical skills. Would make a good teaching assistant.",
        ];
        
        $privateNotes = [
            "Payment issue: late on second installment. Follow up.",
            "Possible refund request. Monitor progress.",
            "Discussed personal circumstances affecting study. Offered extension.",
            "Sensitive about feedback. Be gentle with criticism.",
            "High potential student. Consider for mentorship program.",
            "Complained about course difficulty. May need extra attention.",
            "Excellent feedback about instructor. Good for promotional material.",
            "Interested in partnership opportunities. Refer to admin.",
            "Asked about instructor positions. Keep in mind for future.",
            "VIP client (company-sponsored). Priority support.",
        ];
        
        return $isPrivate 
            ? $privateNotes[array_rand($privateNotes)]
            : $publicNotes[array_rand($publicNotes)];
    }

    private function getAdminNote($student): string
    {
        $notes = [
            "New student orientation completed.",
            "Verified student credentials.",
            "Approved for scholarship program.",
            "Flagged for unusual activity - multiple accounts from same IP.",
            "Requested data export for personal records.",
            "Reported technical issue - resolved.",
            "Upgraded to premium account.",
            "Requested account deletion - processed.",
            "LinkedIn recommendation request - approved.",
            "Partnership inquiry - forwarded to business development.",
            "Complimentary course access granted.",
            "Refund processed successfully.",
            "Certificate verification request from employer - confirmed.",
            "Student ambassador application received.",
            "Feedback survey completed - positive responses.",
        ];
        
        return $notes[array_rand($notes)];
    }

    private function randomDate(Carbon $start, Carbon $end): Carbon
    {
        $randomTimestamp = rand($start->timestamp, $end->timestamp);
        return Carbon::createFromTimestamp($randomTimestamp);
    }
}