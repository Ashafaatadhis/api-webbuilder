<?php

namespace App\Models\Template\Section;


use App\Models\Template\TemplateLink;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ProductSection extends Model
{
    use HasFactory, HasUuids;
    protected $table = "product_section";
    protected $guarded = [
        "id"
    ];


    public function templateLink(): BelongsTo
    {
        return $this->belongsTo(TemplateLink::class);
    }
}
