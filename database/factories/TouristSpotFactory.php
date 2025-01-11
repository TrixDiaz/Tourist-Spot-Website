<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TouristSpot>
 */
class TouristSpotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'address' => fake()->address(),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 0, 2000),
            'accomodation' => fake()->sentence(),
            'amenities' => fake()->sentence(),
            'lat' => fake()->latitude(),
            'lng' => fake()->longitude(),
            'images' => json_encode(fake()->imageUrl()),
        ];
    }
}
