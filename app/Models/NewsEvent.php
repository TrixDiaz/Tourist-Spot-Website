<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsEvent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'news_event_category_id',
        'title',
        'description',
        'images',
        'is_active',
    ];

    public function newsEventCategory(): BelongsTo
    {
        return $this->belongsTo(NewsEventCategory::class);
    }

    public function hotelResort(): BelongsTo
    {
        return $this->belongsTo(HotelResort::class);
    }
}
