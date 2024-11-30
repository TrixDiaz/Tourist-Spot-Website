<?php

namespace App\Livewire;

use App\Models\NewsEvent;
use App\Models\NewsEventCategory;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class NewsEventList extends Component
{
    public $newsEvents;
    public $newsEventCategories;
    public $limit = 2;
    public $showMore = false;

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->newsEventCategories = NewsEventCategory::where('is_active', true)
            ->with(['newsEvents' => function ($query) {
                $query->where('is_active', true)
                    ->orderBy('created_at', 'desc');
            }])
            ->limit($this->limit)
            ->get();
    }

    public function loadMore()
    {
        $this->limit += 2;
        $this->loadCategories();
    }

    public function render()
    {
        return view('livewire.news-event-list');
    }
}
