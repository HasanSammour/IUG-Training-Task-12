<?php
// database/factories/ContactMessageFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactMessage>
 */
class ContactMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['new', 'in_progress', 'responded', 'closed', 'spam']);
        
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->boolean(70) ? fake()->phoneNumber() : null,
            'subject' => fake()->sentence(),
            'message' => fake()->paragraphs(2, true),
            'status' => $status,
            'assigned_to' => null, // Can be set in specific cases
            'response' => $status === 'responded' ? fake()->paragraph() : null,
            'responded_at' => $status === 'responded' ? fake()->dateTimeBetween('-1 month', 'now') : null,
            'response_by' => null, // Can be set in specific cases
            'category' => fake()->randomElement(['general', 'course', 'technical', 'billing', 'feedback', 'other']),
            'priority' => fake()->randomElement(['low', 'normal', 'high', 'urgent']),
        ];
    }
}