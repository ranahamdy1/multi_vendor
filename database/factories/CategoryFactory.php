<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        //$name = $this->faker->words(2, true);
        $name = fake()->unique()->department;
        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 999999),
            'description' => $this->faker->sentence(6),
            'image' => $this->faker->imageUrl(),
            'status' => 'active',
        ];
    }
}
