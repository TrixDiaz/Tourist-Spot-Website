<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'description', 'price', 'accommodation', 'amenities', 'lat', 'lng', 'images','is_active', 'restaurant_id'];

    protected $casts = ['images' => 'array'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->where('is_active', true);
    }

    public function restaurantFeedbacks()
    {
        return $this->hasMany(RestaurantFeedback::class);
    }

    public function newsEventCategories(): HasMany
    {
        return $this->hasMany(NewsEventCategory::class, 'hotel_resort_id');
    }

    public function hotelResort(): BelongsTo
    {
        return $this->belongsTo(HotelResort::class);
    }
}
