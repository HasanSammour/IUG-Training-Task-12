<?php
// database/factories/CourseReviewFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseReview>
 */
class CourseReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fn() => \App\Models\User::factory()->create()->id,
            'course_id' => fn() => \App\Models\Course::factory()->create()->id,
            'rating' => fake()->numberBetween(1, 5),
            'title' => fake()->boolean(70) ? fake()->sentence() : null,
            'comment' => fake()->paragraph(),
            'is_approved' => fake()->boolean(80),
            'helpful_count' => fake()->numberBetween(0, 50),
            'not_helpful_count' => fake()->numberBetween(0, 10),
        ];
    }
}