<?php

namespace App\Models\Template;

use App\Models\Store\Store;
use App\Models\Template\Section\CalltoactionSection;
use App\Models\Template\Section\FooterSection;
use App\Models\Template\Section\HeroAboutUsSection;
use App\Models\Template\Section\HeroSection;
use App\Models\Template\Section\HistorySection;
use App\Models\Template\Section\ProductSection;
use App\Models\Template\Section\StoreLocationSection;
use App\Models\Template\Section\StrengthSection;
use App\Models\Template\Section\TeamSection;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class TemplateLink extends Model
{
    use HasFactory, HasUuids;
    protected $table = "template_link";
    protected $guarded = [
        "id"
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function strengthSection(): HasMany
    {
        return $this->hasMany(StrengthSection::class, "templateLink_id");
    }
    public function historySection(): HasOne
    {
        return $this->hasOne(HistorySection::class, "templateLink_id");
    }
    public function calltoactionSection(): HasOne
    {
        return $this->hasOne(CalltoactionSection::class, "templateLink_id");
    }
    public function heroSection(): HasOne
    {
        return $this->hasOne(HeroSection::class, "templateLink_id");
    }
    public function footerSection(): HasOne
    {
        return $this->hasOne(FooterSection::class, "templateLink_id");
    }
    public function heroAboutUsSection(): HasOne
    {
        return $this->hasOne(HeroAboutUsSection::class, "templateLink_id");
    }
    public function productSection(): HasOne
    {
        return $this->hasOne(ProductSection::class, "templateLink_id");
    }
    public function storeLocationSection(): HasOne
    {
        return $this->hasOne(StoreLocationSection::class, "templateLink_id");
    }
    public function teamSection(): HasOne
    {
        return $this->hasOne(TeamSection::class, "templateLink_id");
    }
}
