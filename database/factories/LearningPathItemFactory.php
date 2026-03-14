<?php
// database/factories/LearningPathItemFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LearningPathItem>
 */
class LearningPathItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['locked', 'active', 'completed']);
        
        return [
            'learning_path_id' => fn() => \App\Models\LearningPath::factory()->create()->id,
            'course_id' => fn() => \App\Models\Course::factory()->create()->id,
            'position' => fake()->numberBetween(1, 10),
            'status' => $status,
            'progress' => $status === 'completed' ? 100 : ($status === 'active' ? fake()->numberBetween(10, 90) : 0),
            'notes' => fake()->boolean(30) ? fake()->sentence() : null,
            'started_at' => $status !== 'locked' ? fake()->dateTimeBetween('-2 months', 'now') : null,
            'completed_at' => $status === 'completed' ? fake()->dateTimeBetween('-1 month', 'now') : null,
        ];
    }
}