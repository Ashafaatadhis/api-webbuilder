<?php

namespace App\Models\Store;

use App\Models\Certification;
use App\Models\Employee;
use App\Models\Product\Product;
use App\Models\Store\Image\StoreImage;
use App\Models\Template\Template;
use App\Models\Testimonial;
use App\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, HasUuids, SoftDeletes, Sluggable;

    protected $dates = ['deleted_at'];
    protected $guarded = [
        "id"
    ];
    // protected $hidden = [
    //     'deleted_at',

    // ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function storeImages(): HasMany
    {
        return $this->hasMany(StoreImage::class);
    }
    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class);
    }
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
    public function template(): HasOne
    {
        return $this->hasOne(Template::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
