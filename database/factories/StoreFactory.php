<?php

namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StoreFactory extends Factory
{
    public function definition(): array
    {
        $name =$this->faker->unique()->words(2, true);
        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 99999),
            'description' => $this->faker->paragraph(1),
            'logo_image' => $this->faker->imageUrl(300,300),
            'cover_image' => $this->faker->imageUrl(800,600),
        ];
    }
}
