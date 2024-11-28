<?php

namespace App\Livewire;

use App\Models\TouristSpot;
use Livewire\Component;
use Livewire\WithPagination;

class TouristSpots extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 6;
    public $rating = null;
    public $priceRange = null;

    public function loadMore()
    {
        $this->perPage += 4;
    }

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
                    $q->select('tourist_spot_id')
                        ->groupBy('tourist_spot_id')
                        ->havingRaw('AVG(rating) >= ?', [$this->rating]);
                });
            })
            ->when($this->priceRange, function ($query) {
                [$min, $max] = explode('-', $this->priceRange);
                $query->whereBetween('price', [$min, $max]);
            })
            ->withAvg('reviews', 'rating')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
    }

    public function applyFilters()
    {
        $this->resetPage();
        $this->dispatch('filters-applied');
    }

    public function clearFilters()
    {
        $this->rating = null;
        $this->priceRange = null;
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.tourist-spots', [
            'touristSpots' => $this->touristSpots
        ]);
    }
}
