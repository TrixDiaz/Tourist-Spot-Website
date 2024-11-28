<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TouristSpot extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'address', 'description', 'price', 'accomodation', 'amenities', 'latitude', 'longitude', 'images'];

    protected $casts = [
        'images' => 'array'
    ];

    public function reviews()
    {
        return $this->hasMany(TouristSpotReview::class);
    }
}
