<?php

namespace App\Models\Template\Section;


use App\Models\Template\Template;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class CalltoactionSection extends Model
{
    use HasFactory, HasUuids;
    protected $table = "calltoaction_section";
    protected $guarded = [
        "id"
    ];


    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }
}
