<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactMessage;
use App\Models\User;
use Carbon\Carbon;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        $startDate = Carbon::parse('2024-01-01');
        $endDate = Carbon::parse('2026-02-15');
        
        $admin = User::role('admin')->first();
        
        $messageCount = 0;
        
        // Generate 200+ contact messages spread over the 2+ year period
        $numMessages = rand(200, 250);
        
        for ($i = 0; $i < $numMessages; $i++) {
            $createdAt = $this->randomDate($startDate, $endDate->copy()->subDays(rand(0, 15)));
            
            $category = $this->getWeightedCategory();
            $priority = $this->getPriorityFromCategory($category);
            $status = $this->getWeightedStatus($createdAt);
            
            $assignedTo = in_array($status, ['in_progress', 'responded', 'closed']) ? $admin->id : null;
            $respondedAt = in_array($status, ['responded', 'closed']) 
                ? $createdAt->copy()->addHours(rand(1, 72)) 
                : null;
            
            $contactMessage = ContactMessage::create([
                'name' => $this->getRandomName(),
                'email' => $this->getRandomEmail(),
                'phone' => rand(0, 1) ? '+9665' . rand(50000000, 59999999) : null,
                'subject' => $this->getSubject($category),
                'message' => $this->getMessage($category),
                'status' => $status,
                'assigned_to' => $assignedTo,
                'response' => $respondedAt ? $this->getResponse($category) : null,
                'responded_at' => $respondedAt,
                'response_by' => $respondedAt ? $admin->id : null,
                'category' => $category,
                'priority' => $priority,
                'created_at' => $createdAt,
                'updated_at' => $respondedAt ?? $this->randomDate($createdAt, $endDate),
            ]);
            
            $messageCount++;
        }
        
        $this->command->info("✅ {$messageCount} Contact messages created successfully!");
    }

    private function getWeightedCategory(): string
    {
        $categories = ['general', 'course', 'technical', 'billing', 'feedback', 'other'];
        $weights = [25, 30, 20, 15, 8, 2]; // Percentages
        
        $rand = rand(1, 100);
        $cumulative = 0;
        
        foreach ($weights as $index => $weight) {
            $cumulative += $weight;
            if ($rand <= $cumulative) {
                return $categories[$index];
            }
        }
        
        return 'general';
    }

    private function getPriorityFromCategory(string $category): string
    {
        return match($category) {
            'technical' => rand(1, 100) <= 30 ? 'urgent' : (rand(1, 100) <= 50 ? 'high' : 'normal'),
            'billing' => rand(1, 100) <= 40 ? 'urgent' : (rand(1, 100) <= 60 ? 'high' : 'normal'),
            'course' => rand(1, 100) <= 10 ? 'high' : 'normal',
            default => rand(1, 100) <= 5 ? 'high' : (rand(1, 100) <= 20 ? 'normal' : 'low'),
        };
    }

    private function getWeightedStatus(Carbon $createdAt): string
    {
        $daysOld = $createdAt->diffInDays(now());
        
        if ($daysOld < 7) {
            // Recent messages
            $rand = rand(1, 100);
            if ($rand <= 40) return 'new';
            if ($rand <= 70) return 'in_progress';
            return 'responded';
        } elseif ($daysOld < 30) {
            // 1-4 weeks old
            $rand = rand(1, 100);
            if ($rand <= 10) return 'new';
            if ($rand <= 30) return 'in_progress';
            if ($rand <= 80) return 'responded';
            return 'closed';
        } else {
            // Older than 1 month
            $rand = rand(1, 100);
            if ($rand <= 5) return 'in_progress';
            if ($rand <= 40) return 'responded';
            return 'closed';
        }
    }

    private function getSubject(string $category): string
    {
        $subjects = [
            'general' => ['General Inquiry', 'Information Request', 'Question about Platform', 'Partnership Opportunity'],
            'course' => ['Course Content Question', 'Prerequisites Inquiry', 'Course Recommendation', 'Certificate Question'],
            'technical' => ['Login Issue', 'Video Playback Problem', 'App Crashing', 'Loading Error'],
            'billing' => ['Payment Failed', 'Refund Request', 'Invoice Question', 'Discount Inquiry'],
            'feedback' => ['Platform Feedback', 'Course Suggestion', 'Feature Request', 'User Experience'],
            'other' => ['Other Inquiry', 'Press Inquiry', 'Business Development'],
        ];
        
        return $subjects[$category][array_rand($subjects[$category])];
    }

    private function getMessage(string $category): string
    {
        $messages = [
            'general' => [
                "I'd like to learn more about your platform and course offerings.",
                "Can you provide information about corporate training options?",
                "I'm interested in partnering with your platform. Who should I contact?",
                "Do you offer any free trial periods?",
            ],
            'course' => [
                "I have a question about the course curriculum. Are the materials updated regularly?",
                "What's the typical time commitment for completing a course?",
                "Do I need any specific background knowledge before enrolling?",
                "Are the certificates recognized by employers?",
            ],
            'technical' => [
                "I can't log into my account. It says my password is incorrect.",
                "Videos keep buffering and won't play smoothly.",
                "The mobile app crashes when I try to download course materials.",
                "I'm not receiving email notifications from the platform.",
            ],
            'billing' => [
                "I was charged twice for the same course. Can you help?",
                "I'd like to request a refund as the course wasn't what I expected.",
                "Can I get an invoice with my company's VAT number?",
                "Is there a student discount available?",
            ],
            'feedback' => [
                "I really enjoy the platform! Here are some suggestions for improvement...",
                "The mobile app could use some UI improvements.",
                "I'd love to see more advanced courses in data science.",
                "Great experience overall! Keep up the good work.",
            ],
        ];
        
        $categoryMessages = $messages[$category] ?? $messages['general'];
        return $categoryMessages[array_rand($categoryMessages)] . " " . $this->getRandomDetail();
    }

    private function getRandomDetail(): string
    {
        $details = [
            "Please let me know as soon as possible.",
            "I look forward to hearing from you.",
            "Thank you for your assistance.",
            "This is urgent for my work.",
            "I've been waiting for a response.",
            "Greatly appreciate your help.",
            "This is my second time contacting about this issue.",
        ];
        
        return rand(0, 2) ? $details[array_rand($details)] : '';
    }

    private function getResponse(string $category): string
    {
        $responses = [
            'general' => "Thank you for contacting us. We've received your inquiry and will get back to you shortly.",
            'course' => "Thank you for your interest in our courses. I'd be happy to answer your questions about the curriculum.",
            'technical' => "I apologize for the technical difficulties you're experiencing. Let me help you resolve this issue.",
            'billing' => "Thank you for bringing this billing issue to our attention. I've looked into your account and...",
            'feedback' => "Thank you for your valuable feedback. We appreciate you taking the time to share your thoughts.",
        ];
        
        return $responses[$category] ?? "Thank you for your message. Our team will review and respond within 24-48 hours.";
    }

    private function getRandomName(): string
    {
        $firstNames = ['Mohammed', 'Ahmed', 'Ali', 'Omar', 'Khalid', 'Fatima', 'Noura', 'Sarah', 'Layla', 'Abdullah'];
        $lastNames = ['Al-Ghamdi', 'Al-Qahtani', 'Al-Shammari', 'Al-Otaibi', 'Al-Harbi', 'Al-Dossari', 'Al-Zahrani'];
        
        return $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
    }

    private function getRandomEmail(): string
    {
        $domains = ['gmail.com', 'hotmail.com', 'outlook.sa', 'yahoo.com', 'icloud.com'];
        $name = strtolower(str_replace(' ', '.', $this->getRandomName()));
        
        return $name . rand(1, 999) . '@' . $domains[array_rand($domains)];
    }

    private function randomDate(Carbon $start, Carbon $end): Carbon
    {
        $randomTimestamp = rand($start->timestamp, $end->timestamp);
        return Carbon::createFromTimestamp($randomTimestamp);
    }
}