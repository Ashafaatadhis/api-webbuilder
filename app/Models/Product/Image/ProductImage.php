<?php

namespace App\Models\Product\Image;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ProductImage extends Model
{
    use HasFactory, HasUuids;
    protected $table = "product_image";
    protected $fillable = [
        "url",
        "product_id"
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
