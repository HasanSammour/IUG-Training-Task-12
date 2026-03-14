<?php
// database/factories/NotificationFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['course', 'system', 'enrollment', 'progress', 'achievement', 'reminder']);
        
        return [
            'user_id' => fn() => \App\Models\User::factory()->create()->id,
            'title' => fake()->sentence(),
            'message' => fake()->paragraph(),
            'type' => $type,
            'is_read' => fake()->boolean(60),
            'data' => json_encode([
                'type' => $type,
                'action' => fake()->word(),
                'timestamp' => now()->toISOString(),
            ]),
            'action_url' => fake()->boolean(70) ? fake()->url() : null,
            'action_text' => fake()->boolean(70) ? fake()->words(2, true) : null,
        ];
    }
}