<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class HotelResortFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address' => fake()->address(),
            'name' => fake()->name(),
            'description' => fake()->sentence(),
            'accommodation' => fake()->sentence(),
            'type' => fake()->randomElement(['hotel', 'resort']),
            'lat' => fake()->latitude(),
            'lng' => fake()->longitude(),
            'price' => fake()->numberBetween(100, 1000),
            'amenities' => json_encode([fake()->sentence(), fake()->sentence(), fake()->sentence()]),
            'images' => json_encode([fake()->imageUrl(), fake()->imageUrl(), fake()->imageUrl()]),
            'restaurant_id' => Restaurant::factory(),
        ];
    }
}
