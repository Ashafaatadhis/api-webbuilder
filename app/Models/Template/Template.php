<?php

namespace App\Models\Template;


use App\Models\TemplateCategory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Template extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = [
        "id"
    ];

    public function templateCategory(): BelongsTo
    {
        return $this->belongsTo(TemplateCategory::class, "templateCategory_id");
    }

    public function templateLinks(): HasMany
    {
        return $this->hasMany(TemplateLink::class);
    }
}
