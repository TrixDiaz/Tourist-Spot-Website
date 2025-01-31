<?php

namespace Database\Factories;

use App\Models\HotelResort;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NewsEventCategory>
 */
class NewsEventCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hotel_resort_id' => HotelResort::factory(),
            'name' => fake()->sentence(),
            'slug' => fake()->slug(),
            'description' => fake()->sentence(),
            'images' => json_encode([fake()->imageUrl(), fake()->imageUrl()]),
            'is_active' => true,
        ];
    }
}
