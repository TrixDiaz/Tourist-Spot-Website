<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NewsEventList extends Component
{
    public $newsCount = 2;

    public function loadMore()
    {
        $this->newsCount += 2;
    }

    // ... rest of your component code ...
}
