<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HotelResortFeedback extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function hotelResort(): BelongsTo
    
    {
        return $this->belongsTo(HotelResort::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
