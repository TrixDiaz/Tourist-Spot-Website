<?php

namespace Database\Seeders;

use App\Models\NewsEvent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NewsEvent::factory()->count(10)->create();
    }
}
