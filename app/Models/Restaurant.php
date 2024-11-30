<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'description', 'price', 'accomodation', 'amenities', 'latitude', 'longitude', 'images'];

    protected $casts = ['images' => 'array'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function restaurantFeedbacks()
    {
        return $this->hasMany(RestaurantFeedback::class);
    }
}
