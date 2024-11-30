<?php

namespace App\Livewire;

use App\Models\Restaurant;
use Livewire\Component;
use Livewire\WithPagination;

class RestaurantList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 6;
    public $rating = null;
    public $priceRange = null;
    public $newReviewComment = '';
    public $newReviewRating = 0;

    public function loadMore()
    {
        $this->perPage += 4;
    }

    public function getRestaurantsProperty()
    {
        return Restaurant::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('address', 'like', '%' . $this->search . '%');
            })
            ->when($this->rating, function ($query) {
                $query->whereHas('restaurantFeedbacks', function ($q) {
                    $q->where('is_active', true)
                        ->groupBy('restaurant_id')
                        ->havingRaw('AVG(rating) >= ?', [$this->rating]);
                });
            })
            ->withAvg(['restaurantFeedbacks' => function ($query) {
                $query->where('is_active', true);
            }], 'rating')
            ->with(['restaurantFeedbacks' => function ($query) {
                $query->where('is_active', true);
            }])
            ->with('products')
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
        return view('livewire.restaurant-list', [
            'restaurants' => $this->restaurants
        ]);
    }
}
