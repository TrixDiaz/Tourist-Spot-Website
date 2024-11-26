<?php

namespace Database\Factories;

use App\Models\HotelResort;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HotelResortFeedback>
 */
class HotelResortFeedbackFactory extends Factory
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
            'user_id' => User::factory(),
            'comment' => fake()->sentence(),
            'rating' => fake()->numberBetween(1, 5),
        ];
    }
}
