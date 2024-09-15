<?php

namespace App\Models\Store\Image;

use App\Models\Store\Store;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class StoreImage extends Model
{
    use HasFactory, HasUuids;
    protected $table = "store_image";
    protected $fillable = [
        "url",
        "store_id"
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
