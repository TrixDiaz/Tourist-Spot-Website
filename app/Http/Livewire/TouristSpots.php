<?php

namespace App\Http\Livewire;

use App\Models\TouristSpot;
use Livewire\Component;
use Livewire\WithPagination;

class TouristSpots extends Component
{
    use WithPagination;

    public $rating = null;
    public $priceRange = null;
    public $search = '';

    public function getTouristSpotsProperty()
    {
        return TouristSpot::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('address', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->rating, function ($query) {
                $query->whereHas('reviews', function ($q) {
                    $q->havingRaw('AVG(rating) >= ?', [$this->rating]);
                });
            })
            ->when($this->priceRange, function ($query) {
                [$min, $max] = explode('-', $this->priceRange);
                $query->whereBetween('price', [$min, $max]);
            })
            ->paginate(10);
    }

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->rating = null;
        $this->priceRange = null;
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.tourist-spots');
    }
} 