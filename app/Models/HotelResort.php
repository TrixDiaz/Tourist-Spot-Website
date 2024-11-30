<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelResort extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
        'amenities' => 'array',
        'price' => 'decimal:2'
    ];

    const TYPE_OPTIONS = [
        'hotel' => 'Hotel',
        'resort' => 'Resort',
    ];

    public function reviews(): HasMany
    {
        return $this->hasMany(HotelResortFeedback::class, 'hotel_resort_id');
    }

    public function newsEventCategories(): HasMany
    {
        return $this->hasMany(NewsEventCategory::class, 'hotel_resort_id');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
