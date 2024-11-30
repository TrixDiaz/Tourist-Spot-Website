<?php

namespace App\Livewire;

use App\Models\HotelResort;
use App\Models\HotelResortFeedback;
use Livewire\Component;
use Livewire\WithPagination;


class HotelResortList extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 6;
    public $rating = null;
    public $priceRange = null;
    public $newReviewComment = '';
    public $newReviewRating = 0;
    public $type = null;

    public function loadMore()
    {
        $this->perPage += 4;
    }

    public function getHotelResortsProperty()
    {
        return HotelResort::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('address', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->rating, function ($query) {
                $query->whereHas('reviews', function ($q) {
                    $q->select('hotel_resort_id')
                        ->groupBy('hotel_resort_id')
                        ->havingRaw('AVG(rating) >= ?', [$this->rating]);
                });
            })
            ->when($this->priceRange, function ($query) {
                [$min, $max] = explode('-', $this->priceRange);
                $query->whereBetween('price', [$min, $max]);
            })
            ->when($this->type, function ($query) {
                $query->where('type', $this->type);
            })
            ->with(['reviews.user'])
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
        $this->type = null;
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.hotel-resort-list', [
            'hotelResorts' => $this->hotelResorts
        ]);
    }

    public function setRating($rating)
    {
        $this->newReviewRating = $rating;
    }

    public function addReview($spotId)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->validate([
            'newReviewComment' => 'required|min:3',
            'newReviewRating' => 'required|integer|min:1|max:5',
        ]);

        HotelResortFeedback::create([
            'hotel_resort_id' => $spotId,
            'user_id' => auth()->id(),
            'comment' => $this->newReviewComment,
            'rating' => $this->newReviewRating,
        ]);

        $this->newReviewComment = '';
        $this->newReviewRating = 0;

        $this->dispatch('review-added');
    }
}
