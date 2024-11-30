<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['product_category_id', 'restaurant_id', 'image', 'name', 'slug', 'description', 'price', 'is_active'];


    public function productCategory(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class)->where('is_active', true);
    }

    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(Restaurant::class);
    }
}
