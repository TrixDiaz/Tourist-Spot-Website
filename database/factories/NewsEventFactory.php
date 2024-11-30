<?php

namespace Database\Factories;

use App\Models\HotelResort;
use App\Models\NewsEventCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class NewsEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'news_event_category_id' => NewsEventCategory::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
