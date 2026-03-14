<?php
// database/factories/WishlistFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wishlist>
 */
class WishlistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $reminderDate = fake()->boolean(40) ? fake()->dateTimeBetween('now', '+3 months') : null;
        
        return [
            'user_id' => fn() => \App\Models\User::factory()->create()->id,
            'course_id' => fn() => \App\Models\Course::factory()->create()->id,
            'notes' => fake()->boolean(30) ? fake()->sentence() : null,
            'priority' => fake()->randomElement([1, 2, 3, 4]), // 1=low, 2=medium, 3=high, 4=urgent
            'reminder_date' => $reminderDate,
        ];
    }
}