<?php
// database/factories/EnrollmentFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'active', 'completed', 'cancelled']);
        
        return [
            'user_id' => fn() => \App\Models\User::factory()->create()->id,
            'course_id' => fn() => \App\Models\Course::factory()->create()->id,
            'enrollment_id' => 'ENR-' . strtoupper(fake()->unique()->bothify('??##??##')),
            'amount_paid' => fn(array $attributes) => \App\Models\Course::find($attributes['course_id'])->discounted_price ?? \App\Models\Course::find($attributes['course_id'])->price,
            'payment_method' => fake()->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'status' => $status,
            'progress_percentage' => $status === 'completed' ? 100 : ($status === 'active' ? fake()->numberBetween(10, 90) : 0),
            'notes' => fake()->boolean(20) ? fake()->sentence() : null,
            'enrolled_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'completed_at' => $status === 'completed' ? fake()->dateTimeBetween('-3 months', 'now') : null,
        ];
    }
}