<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TouristSpot extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'description',
        'price',
        'accommodation',
        'popular',
        'amenities',
        'latitude',
        'longitude',
        'images'
    ];

    protected $casts = [
        'images' => 'array',
        'popular' => 'boolean'
    ];

    public function getImagesAttribute($value)
    {
        return json_decode($value, true) ?: [];
    }

    public function reviews()
    {
        return $this->hasMany(TouristSpotReview::class);
    }
}
