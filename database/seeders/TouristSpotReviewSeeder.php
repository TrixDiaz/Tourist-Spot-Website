<?php

namespace Database\Seeders;

use App\Models\TouristSpotReview;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TouristSpotReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TouristSpotReview::factory()->count(10)->create();
    }
}
