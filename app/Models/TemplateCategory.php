<?php

namespace App\Models;

use App\Models\Template\Template;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class TemplateCategory extends Model
{
    use HasFactory, HasUuids,    Sluggable;
    protected $table = "template_category";
    protected $guarded = [
        "id"
    ];


    public function templates(): HasMany
    {
        return $this->hasMany(Template::class);
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
