<?php

namespace App\Models\SuperAdmin;

use App\Models\LanguageSetting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

/**
 * App\Models\SuperAdmin\SeoDetail
 *
 * @property int $id
 * @property string $page_name
 * @property string|null $seo_title
 * @property string|null $seo_keywords
 * @property string|null $seo_description
 * @property string|null $seo_author
 * @property int|null $language_setting_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $og_image_url
 * @method static \Illuminate\Database\Eloquent\Builder|SeoDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeoDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SeoDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|SeoDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoDetail whereLanguageSettingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoDetail wherePageName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoDetail whereSeoAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoDetail whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoDetail whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoDetail whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SeoDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $og_image
 * @method static \Illuminate\Database\Eloquent\Builder|SeoDetail whereOgImage($value)
 */
class SeoDetail extends BaseModel
{
    protected $guarded = ['id'];

    protected $appends = ['og_image_url'];

    public function language()
    {
        return $this->belongsTo(LanguageSetting::class, 'language_setting_id');
    }

    public function getOgImageUrlAttribute()
    {
        return ($this->og_image) ? asset_url_local_s3('front/seo-detail/' . $this->og_image) : asset('img/home-crm.png');
    }

}
