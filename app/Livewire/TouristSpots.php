<?php

namespace App\Livewire;

use App\Models\TouristSpot;
use Livewire\Component;
use Livewire\WithPagination;

class TouristSpots extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public function loadMore()
    {
        $this->perPage += 10;
    }

    public function render()
    {
        return view('livewire.tourist-spots', [
            'touristSpots' => TouristSpot::where('address', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage)
        ]);
    }
}
