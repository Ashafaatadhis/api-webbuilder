<?php

namespace App\Models\Template;

use App\Models\Store\Store;
use App\Models\Template\Section\CalltoactionSection;
use App\Models\Template\Section\FooterSection;
use App\Models\Template\Section\HeroSection;
use App\Models\Template\Section\HistorySection;
use App\Models\Template\Section\StrengthSection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use HasFactory, HasUuids, SoftDeletes;
    protected $guarded = [
        "id"
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function strengthSection(): HasOne
    {
        return $this->hasOne(StrengthSection::class);
    }
    public function historySection(): HasOne
    {
        return $this->hasOne(HistorySection::class);
    }
    public function calltoactionSection(): HasOne
    {
        return $this->hasOne(CalltoactionSection::class);
    }
    public function heroSection(): HasOne
    {
        return $this->hasOne(HeroSection::class);
    }
    public function footerSection(): HasOne
    {
        return $this->hasOne(FooterSection::class);
    }
}
