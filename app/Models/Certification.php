<?php

namespace App\Models;

use App\Models\Store\Store;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certification extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = [
        "id"
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
