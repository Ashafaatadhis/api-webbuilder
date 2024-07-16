<?php

namespace App\Models;

use App\Models\Store\Store;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $guarded = [
        "id"
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
