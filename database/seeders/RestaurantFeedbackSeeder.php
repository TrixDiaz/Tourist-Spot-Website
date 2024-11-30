<?php

namespace Database\Seeders;

use App\Models\RestaurantFeedback;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantFeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RestaurantFeedback::factory()->count(10)->create();
    }
}
