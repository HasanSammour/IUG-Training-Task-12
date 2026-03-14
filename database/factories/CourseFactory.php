<?php
// database/factories/CourseFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);
        $hasDiscount = fake()->boolean(30);
        
        return [
            'category_id' => fn() => \App\Models\Category::factory()->create()->id,
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(6),
            'description' => fake()->paragraphs(3, true),
            'short_description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 100, 500),
            'discounted_price' => $hasDiscount ? fake()->randomFloat(2, 50, 400) : null,
            'discount_percentage' => $hasDiscount ? fake()->numberBetween(10, 50) : null,
            'instructor_name' => fake()->name(),
            'duration' => fake()->randomElement(['4 weeks', '8 weeks', '12 weeks', '16 weeks']),
            'rating' => fake()->randomFloat(1, 3.0, 5.0),
            'total_students' => fake()->numberBetween(100, 5000),
            'level' => fake()->randomElement(['beginner', 'intermediate', 'advanced']),
            'format' => fake()->randomElement(['online', 'in-person', 'hybrid']),
            'image_path' => 'images/course-' . fake()->numberBetween(1, 10) . '.jpg',
            'tags' => json_encode(fake()->words(5)),
            'requirements' => json_encode(fake()->sentences(3)),
            'what_you_will_learn' => json_encode(fake()->sentences(5)),
            'meta_description' => fake()->sentence(),
            'is_featured' => fake()->boolean(20),
            'is_active' => true,
        ];
    }
}