<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        $this->call([
            RestaurantSeeder::class,
            RestaurantFeedbackSeeder::class,
            ProductCategorySeeder::class,
            ProductSeeder::class,
            NewsEventCategorySeeder::class,
            NewsEventSeeder::class,
            HotelResortSeeder::class,
            HotelResortFeedbackSeeder::class,
            TouristSpotSeeder::class,
            TouristSpotReviewSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
    }
}
