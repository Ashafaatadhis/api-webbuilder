<?php

namespace App\Models\Product\Image;

use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = "product_image";
    protected $fillable = [
        "url", "product_id"
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
