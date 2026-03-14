<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CourseReview;
use App\Models\Enrollment;
use App\Models\Course;
use Carbon\Carbon;

class CourseReviewSeeder extends Seeder
{
    private $reviewTitles = [
        'Excellent Course!',
        'Very Helpful',
        'Great Learning Experience',
        'Well Structured',
        'Recommended for Beginners',
        'Advanced Content',
        'Practical Examples',
        'Good Instructor',
        'Worth the Money',
        'Comprehensive Material',
        'Best course on this topic',
        'Instructor is amazing',
        'Loved the projects',
        'Very practical',
        'Clear explanations',
        'Perfect for my career',
        'Highly recommended',
        'Exceeded expectations',
        'Great value for money',
        'Learned a lot',
    ];

    private $reviewComments = [
        'positive' => [
            'This course exceeded my expectations. The content is well-organized and the instructor explains complex topics in an easy-to-understand way.',
            'As a beginner, I found this course very helpful. The step-by-step approach made learning enjoyable.',
            'Practical projects were the best part. I could immediately apply what I learned to real-world scenarios.',
            'The instructor is knowledgeable and responsive to questions. The community support is excellent.',
            'Worth every penny! The course materials are comprehensive and up-to-date with industry standards.',
            'Perfect balance between theory and practice. The assignments challenged me to think critically.',
            'The course structure helped me stay motivated throughout. The milestones kept me on track.',
            'I appreciated the downloadable resources and code examples. Made learning much easier.',
            'The instructor\'s teaching style is engaging. Complex topics are broken down perfectly.',
            'This course helped me land my first job in the field. Forever grateful!',
            'The hands-on projects were incredibly valuable. Built a great portfolio.',
            'Clear, concise, and practical. Exactly what I needed to advance my career.',
        ],
        'neutral' => [
            'Good course overall, but some sections could be more detailed.',
            'Decent content, but the pace was a bit slow for me.',
            'Informative, though I wish there were more advanced topics.',
            'Solid foundation, but needs more real-world examples.',
            'Good for beginners, but intermediate learners might find it basic.',
            'The instructor knows their stuff, but the delivery could be more engaging.',
        ],
        'negative' => [
            'The course felt outdated in some sections.',
            'I expected more hands-on projects.',
            'The audio quality could be better in some lectures.',
            'Too theoretical, not enough practical application.',
            'Difficult to follow at times. Could use better organization.',
            'The price is a bit high compared to similar courses.',
        ],
    ];

    public function run(): void
    {
        $startDate = Carbon::parse('2024-01-01');
        $endDate = Carbon::parse('2026-02-15');

        // Get all completed or active enrollments that could have reviews
        $enrollments = Enrollment::whereIn('status', ['completed', 'active'])
            ->get();

        $reviewCount = 0;

        foreach ($enrollments as $enrollment) {
            // 70% chance of leaving a review if completed, 40% if active
            $reviewChance = $enrollment->status == 'completed' ? 70 : 40;

            if (rand(1, 100) <= $reviewChance) {
                // Determine rating based on course quality and randomness
                // Most reviews are positive (4-5 stars)
                $ratingRand = rand(1, 100);
                if ($ratingRand <= 60) {
                    $rating = 5;
                    $sentiment = 'positive';
                } elseif ($ratingRand <= 85) {
                    $rating = 4;
                    $sentiment = 'positive';
                } elseif ($ratingRand <= 95) {
                    $rating = 3;
                    $sentiment = 'neutral';
                } else {
                    $rating = rand(1, 2);
                    $sentiment = 'negative';
                }

                // Review date is after enrollment, before now
                $reviewDate = $this->randomDate(
                    $enrollment->enrolled_at->copy()->addDays(rand(7, 60)),
                    min($endDate, Carbon::now())
                );

                // 90% of reviews are approved
                $isApproved = rand(1, 100) <= 90;

                CourseReview::create([
                    'user_id' => $enrollment->user_id,
                    'course_id' => $enrollment->course_id,
                    'rating' => $rating,
                    'title' => $this->reviewTitles[array_rand($this->reviewTitles)],
                    'comment' => $this->reviewComments[$sentiment][array_rand($this->reviewComments[$sentiment])],
                    'is_approved' => $isApproved,
                    'helpful_count' => $isApproved ? rand(0, 30) : 0,
                    'not_helpful_count' => $isApproved ? rand(0, 5) : 0,
                    'created_at' => $reviewDate,
                    'updated_at' => $reviewDate,
                ]);

                $reviewCount++;
            }
        }

        // Update course ratings based on approved reviews
        $courses = Course::all();
        foreach ($courses as $course) {
            $avgRating = CourseReview::where('course_id', $course->id)
                ->where('is_approved', true)
                ->avg('rating');

            if ($avgRating) {
                $course->rating = round($avgRating, 1);
                $course->save();
            }
        }

        $this->command->info("✅ {$reviewCount} Course reviews created successfully!");
    }

    private function randomDate(Carbon $start, Carbon $end): Carbon
    {
        $randomTimestamp = rand($start->timestamp, $end->timestamp);
        return Carbon::createFromTimestamp($randomTimestamp);
    }
}