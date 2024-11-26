<?php

namespace Database\Seeders;

use App\Models\NewsEventCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsEventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NewsEventCategory::factory()->count(10)->create();
    }
}
