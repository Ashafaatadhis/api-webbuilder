<?php

namespace App\Models\Product;

use App\Models\Product\Image\ProductImage;
use App\Models\Store\Store;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = [
        "id"
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }
}
