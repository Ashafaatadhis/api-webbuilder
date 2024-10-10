<?php

namespace App\Models;

use App\Models\Store\Store;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class StoreCategory extends Model
{
    use HasFactory, HasUuids,    Sluggable;
    protected $table = "store_category";
    protected $guarded = [
        "id"
    ];


    public function stores(): HasMany
    {
        return $this->hasMany(Store::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true
            ],

        ];
    }
}
