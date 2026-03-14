<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wishlist;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use Carbon\Carbon;

class WishlistSeeder extends Seeder
{
    public function run(): void
    {
        $startDate = Carbon::parse('2024-01-01');
        $endDate = Carbon::parse('2026-02-15');
        
        $students = User::role('student')->get();
        $courses = Course::all();
        
        $wishlistCount = 0;
        
        foreach ($students as $student) {
            // Get courses the student is NOT enrolled in
            $enrolledCourseIds = Enrollment::where('user_id', $student->id)
                ->pluck('course_id')
                ->toArray();
            
            $availableCourses = $courses->whereNotIn('id', $enrolledCourseIds);
            
            if ($availableCourses->isEmpty()) continue;
            
            // Determine number of wishlist items based on student activity
            $studentAge = $student->created_at->diffInMonths($endDate);
            $maxWishlist = min(8, max(2, floor($studentAge / 3)));
            
            $numWishlist = rand(2, $maxWishlist);
            $numWishlist = min($numWishlist, $availableCourses->count());
            
            if ($numWishlist == 0) continue;
            
            $selectedCourses = $availableCourses->random($numWishlist);
            
            foreach ($selectedCourses as $course) {
                // Wishlist added after student joined
                $addedAt = $this->randomDate(
                    $student->created_at->copy()->addDays(rand(5, 60)),
                    $endDate->copy()->subDays(rand(0, 30))
                );
                
                // Some wishlist items have reminders
                $hasReminder = rand(0, 3) ? true : false; // 25% have reminder
                $reminderDate = $hasReminder ? 
                    $addedAt->copy()->addDays(rand(7, 90)) : 
                    null;
                
                // Priority distribution: 1=low(15%), 2=medium(40%), 3=high(30%), 4=urgent(15%)
                $priorityRand = rand(1, 100);
                if ($priorityRand <= 15) $priority = 1;
                elseif ($priorityRand <= 55) $priority = 2;
                elseif ($priorityRand <= 85) $priority = 3;
                else $priority = 4;
                
                Wishlist::create([
                    'user_id' => $student->id,
                    'course_id' => $course->id,
                    'priority' => $priority,
                    'reminder_date' => $reminderDate,
                    'notes' => rand(0, 2) ? $this->getRandomNote($priority) : null,
                    'created_at' => $addedAt,
                    'updated_at' => $this->randomDate($addedAt, $endDate),
                ]);
                
                $wishlistCount++;
            }
        }
        
        $this->command->info("✅ {$wishlistCount} Wishlist items created successfully!");
    }

    private function getRandomNote(int $priority): string
    {
        $notes = [
            1 => ['Maybe later', 'Just browsing', 'Not urgent', 'Will consider'],
            2 => ['Interested', 'Looks good', 'Want to learn this', 'Good course'],
            3 => ['Really want this', 'Important for work', 'Need this soon', 'Top choice'],
            4 => ['Must take ASAP!', 'Urgent for project', 'Need for promotion', 'Starting next week'],
        ];
        
        $priorityNotes = $notes[$priority] ?? $notes[2];
        return $priorityNotes[array_rand($priorityNotes)];
    }

    private function randomDate(Carbon $start, Carbon $end): Carbon
    {
        $randomTimestamp = rand($start->timestamp, $end->timestamp);
        return Carbon::createFromTimestamp($randomTimestamp);
    }
}