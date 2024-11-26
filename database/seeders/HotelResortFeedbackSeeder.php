<?php

namespace Database\Seeders;

use App\Models\HotelResortFeedback;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelResortFeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HotelResortFeedback::factory()->count(10)->create();
    }
}
