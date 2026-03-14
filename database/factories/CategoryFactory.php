<?php
// database/factories/CategoryFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->word();
        
        return [
            'name' => ucfirst($name),
            'slug' => str($name)->slug(),
            'icon' => 'fa-' . fake()->word(),
            'description' => fake()->paragraph(),
            'color' => fake()->hexColor(),
            'is_active' => true,
        ];
    }
}