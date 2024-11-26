<?php

namespace Database\Factories;

use App\Models\TouristSpot;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TouristSpotReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'tourist_spot_id' => TouristSpot::factory(),
            'comment' => fake()->sentence(),
            'rating' => fake()->numberBetween(1, 5),
        ];
    }
}
