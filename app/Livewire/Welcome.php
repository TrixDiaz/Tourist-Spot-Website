<?php

namespace App\Livewire;

use App\Models\TouristSpot;
use Livewire\Component;

class Welcome extends Component
{
    public $popularSpots;

    public function mount()
    {
        $this->popularSpot();
    }

    public function popularSpot()
    {
        $this->popularSpots = TouristSpot::where('popular', true)
            ->whereNotNull('images')
            ->where('images', '!=', '[]')
            ->get();
    }

    public function render()
    {
        return view('livewire.welcome');
    }
}
