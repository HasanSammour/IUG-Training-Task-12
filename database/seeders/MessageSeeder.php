<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\User;
use App\Models\Course;
use Carbon\Carbon;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        $startDate = Carbon::parse('2024-01-01');
        $endDate = Carbon::parse('2026-02-15');
        
        $students = User::role('student')->get();
        $instructors = User::role('instructor')->get();
        $admin = User::role('admin')->first();
        $courses = Course::all();
        
        $messageCount = 0;
        
        // Student to Instructor messages
        foreach ($students as $student) {
            // Each student messages 2-5 different instructors
            $numInstructorContacts = rand(2, 5);
            $contactedInstructors = $instructors->random(min($numInstructorContacts, $instructors->count()));
            
            foreach ($contactedInstructors as $instructor) {
                // Number of message threads with this instructor
                $numThreads = rand(1, 3);
                
                for ($t = 0; $t < $numThreads; $t++) {
                    // Find a course this instructor teaches (or random)
                    $course = $courses->where('instructor_name', 'like', '%' . explode(' ', $instructor->name)[1] . '%')->first() 
                             ?? $courses->random();
                    
                    // Start of conversation
                    $conversationStart = $this->randomDate(
                        $student->created_at->copy()->addDays(rand(10, 60)),
                        $endDate->copy()->subDays(rand(5, 30))
                    );
                    
                    // Student's first message
                    $studentMessage = Message::create([
                        'sender_id' => $student->id,
                        'receiver_id' => $instructor->id,
                        'message' => $this->getStudentQuestion($course),
                        'is_read' => rand(0, 1),
                        'read_at' => rand(0, 1) ? $conversationStart->copy()->addHours(rand(1, 48)) : null,
                        'course_id' => $course->id,
                        'created_at' => $conversationStart,
                        'updated_at' => $conversationStart,
                    ]);
                    $messageCount++;
                    
                    // Instructor response (80% chance)
                    if (rand(1, 100) <= 80) {
                        $responseTime = $conversationStart->copy()->addHours(rand(1, 72));
                        
                        $instructorResponse = Message::create([
                            'sender_id' => $instructor->id,
                            'receiver_id' => $student->id,
                            'message' => $this->getInstructorResponse(),
                            'is_read' => rand(0, 1),
                            'read_at' => rand(0, 1) ? $responseTime->copy()->addHours(rand(1, 24)) : null,
                            'course_id' => $course->id,
                            'created_at' => $responseTime,
                            'updated_at' => $responseTime,
                        ]);
                        $messageCount++;
                        
                        // Follow-up from student (50% chance)
                        if (rand(1, 100) <= 50) {
                            $followUpTime = $responseTime->copy()->addDays(rand(1, 7));
                            
                            $followUp = Message::create([
                                'sender_id' => $student->id,
                                'receiver_id' => $instructor->id,
                                'message' => $this->getFollowUpQuestion(),
                                'is_read' => rand(0, 1),
                                'read_at' => rand(0, 1) ? $followUpTime->copy()->addHours(rand(1, 48)) : null,
                                'course_id' => $course->id,
                                'created_at' => $followUpTime,
                                'updated_at' => $followUpTime,
                            ]);
                            $messageCount++;
                        }
                    }
                }
            }
        }
        
        // Student to Admin messages (support queries)
        foreach ($students->random(30) as $student) {
            $numSupportMessages = rand(1, 3);
            
            for ($i = 0; $i < $numSupportMessages; $i++) {
                $messageTime = $this->randomDate(
                    $student->created_at->copy()->addDays(rand(5, 90)),
                    $endDate
                );
                
                $supportMessage = Message::create([
                    'sender_id' => $student->id,
                    'receiver_id' => $admin->id,
                    'message' => $this->getSupportQuestion(),
                    'is_read' => rand(0, 1),
                    'read_at' => rand(0, 1) ? $messageTime->copy()->addHours(rand(1, 24)) : null,
                    'course_id' => null,
                    'created_at' => $messageTime,
                    'updated_at' => $messageTime,
                ]);
                $messageCount++;
                
                // Admin response (90% chance)
                if (rand(1, 100) <= 90) {
                    $responseTime = $messageTime->copy()->addHours(rand(1, 48));
                    
                    $adminResponse = Message::create([
                        'sender_id' => $admin->id,
                        'receiver_id' => $student->id,
                        'message' => $this->getSupportResponse(),
                        'is_read' => rand(0, 1),
                        'read_at' => rand(0, 1) ? $responseTime->copy()->addHours(rand(1, 24)) : null,
                        'course_id' => null,
                        'created_at' => $responseTime,
                        'updated_at' => $responseTime,
                    ]);
                    $messageCount++;
                }
            }
        }
        
        $this->command->info("✅ {$messageCount} Messages created successfully!");
    }

    private function getStudentQuestion($course): string
    {
        $questions = [
            "I have a question about the {$course->title} course. Is it suitable for beginners?",
            "Hi, I'm interested in {$course->title}. How many hours per week should I dedicate?",
            "Does the {$course->title} course include practical projects?",
            "What are the prerequisites for {$course->title}?",
            "Will I get a certificate after completing {$course->title}?",
            "Is there any discount available for {$course->title}?",
            "I'm stuck on an exercise in {$course->title}. Can you help?",
            "When will the next cohort for {$course->title} start?",
            "Can I access {$course->title} materials after completion?",
            "I have a question about the assignment in module 3.",
        ];
        
        return $questions[array_rand($questions)];
    }

    private function getInstructorResponse(): string
    {
        $responses = [
            "Thank you for your question. The course is designed for all levels, including beginners. Feel free to start anytime!",
            "Great question! The course requires about 5-7 hours per week for optimal progress.",
            "Yes, the course includes 3 major practical projects that you can add to your portfolio.",
            "Basic computer skills are required. No prior programming experience needed.",
            "Absolutely! Upon completion, you'll receive a verified certificate.",
            "We occasionally have promotions. Keep an eye on your email for discount notifications.",
            "I'd be happy to help with the exercise. Could you share more details about what you're stuck on?",
            "The next cohort begins next month. Check the course page for exact dates.",
            "Yes, you'll have lifetime access to all course materials.",
            "Let me review the assignment and get back to you shortly.",
        ];
        
        return $responses[array_rand($responses)];
    }

    private function getFollowUpQuestion(): string
    {
        $questions = [
            "Thank you for the response! One more thing...",
            "That helps a lot. What about the certification process?",
            "Thanks! Is there a community forum where I can ask questions?",
            "I appreciate the help. Do you have any additional resources?",
            "Perfect! I'll enroll today. Any tips for success?",
            "Got it. Are there any group discounts for team training?",
            "Thanks! Can I switch to a different payment method?",
            "That clarifies everything. Looking forward to starting!",
        ];
        
        return $questions[array_rand($questions)];
    }

    private function getSupportQuestion(): string
    {
        $questions = [
            "I'm having trouble logging into my account.",
            "My payment was deducted but I can't access the course.",
            "How can I update my email address?",
            "I forgot my password and the reset link isn't working.",
            "The video lessons are buffering constantly.",
            "Can I get an invoice for my course purchase?",
            "I accidentally enrolled in the wrong course. Can I switch?",
            "The mobile app keeps crashing when I try to download videos.",
            "How do I delete my account?",
            "I'm not receiving notification emails.",
        ];
        
        return $questions[array_rand($questions)];
    }

    private function getSupportResponse(): string
    {
        $responses = [
            "I'm sorry you're having trouble. Let me help you resolve this issue.",
            "Thank you for reporting this. I've looked into your account and found the issue.",
            "I've reset your password. Please check your email for the new temporary password.",
            "Your payment has been verified and course access has been granted.",
            "I've updated your email address as requested. Please verify the new email.",
            "The video streaming issue has been fixed. Please try again.",
            "I've sent the invoice to your email address.",
            "I've processed your course transfer request. You now have access to the correct course.",
            "The app issue has been reported to our technical team.",
            "Your notification settings have been updated. You should receive emails now.",
        ];
        
        return $responses[array_rand($responses)];
    }

    private function randomDate(Carbon $start, Carbon $end): Carbon
    {
        $randomTimestamp = rand($start->timestamp, $end->timestamp);
        return Carbon::createFromTimestamp($randomTimestamp);
    }
}