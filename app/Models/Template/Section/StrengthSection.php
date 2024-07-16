<?php

namespace App\Models\Template\Section;

use App\Models\Store\Store;
use App\Models\Template\Template;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StrengthSection extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $table = "strength_section";
    protected $guarded = [
        "id"
    ];

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }
}
