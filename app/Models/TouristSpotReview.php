<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class TouristSpotReview extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'tourist_spot_id', 'comment', 'rating'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function touristSpot()
    {
        return $this->belongsTo(TouristSpot::class);
    }
}
