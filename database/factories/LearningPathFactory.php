<?php
// database/factories/LearningPathFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LearningPath>
 */
class LearningPathFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $totalCourses = fake()->numberBetween(3, 8);
        $completedCourses = fake()->numberBetween(0, $totalCourses);
        $progressPercentage = $totalCourses > 0 ? round(($completedCourses / $totalCourses) * 100) : 0;
        
        return [
            'user_id' => fn() => \App\Models\User::factory()->create()->id,
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'total_courses' => $totalCourses,
            'completed_courses' => $completedCourses,
            'total_weeks' => $totalCourses * 2,
            'progress_percentage' => $progressPercentage,
            'next_milestone' => fake()->sentence(),
            'is_ai_generated' => fake()->boolean(70),
            'goals' => json_encode(fake()->sentences(3)),
            'estimated_completion_date' => fake()->dateTimeBetween('now', '+1 year'),
        ];
    }
}