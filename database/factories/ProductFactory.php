<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        //$name = $this->faker->words(2, true);
        $name = fake()->productName;
        return [
            'name' => $name,
            'slug' => Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1, 99999),
            'description' => $this->faker->sentence(8),
            'image' => $this->faker->imageUrl(600, 600),
            'price' => $this->faker->randomFloat(2, 50, 499),
            'compare_price' => $this->faker->randomFloat(2, 500, 999),
            'category_id' => Category::factory(),
            'store_id' => Store::factory(),
            'featured' => $this->faker->boolean(),
        ];
    }
}
