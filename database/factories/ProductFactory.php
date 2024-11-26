<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ProductCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_category_id' => ProductCategory::factory(),
            'name' => fake()->name(),
            'slug' => Str::slug(fake()->name()),
            'description' => fake()->text(),
            'price' => fake()->randomFloat(2, 1, 100),
            'is_active' => true,
        ];
    }
}
