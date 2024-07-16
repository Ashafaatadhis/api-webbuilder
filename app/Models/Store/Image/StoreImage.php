<?php

namespace App\Models\Store\Image;

use App\Models\Store\Store;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreImage extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = "store_image";
    protected $fillable = [
        "url", "store_id"
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
