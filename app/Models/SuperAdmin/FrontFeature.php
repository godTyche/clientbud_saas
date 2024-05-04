<?php

namespace App\Models\SuperAdmin;

use App\Models\LanguageSetting;
use App\Models\BaseModel;

/**
 * App\Models\SuperAdmin\FrontFeature
 *
 * @property int $id
 * @property int|null $language_setting_id
 * @property string|null $title
 * @property string|null $description
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SuperAdmin\Feature[] $features
 * @property-read int|null $features_count
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFeature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFeature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFeature query()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFeature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFeature whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFeature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFeature whereLanguageSettingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFeature whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFeature whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFeature whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read LanguageSetting|null $language
 */
class FrontFeature extends BaseModel
{

    public function features()
    {
        return $this->hasMany(Feature::class, 'front_feature_id');
    }

    public function language()
    {
        return $this->belongsTo(LanguageSetting::class, 'language_setting_id');
    }

}
