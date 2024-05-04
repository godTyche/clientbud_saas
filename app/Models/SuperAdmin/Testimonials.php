<?php

namespace App\Models\SuperAdmin;

use App\Models\LanguageSetting;
use App\Models\BaseModel;

/**
 * App\Models\SuperAdmin\Testimonials
 *
 * @property int $id
 * @property string $name
 * @property string|null $comment
 * @property float|null $rating
 * @property int|null $language_setting_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read LanguageSetting|null $language
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonials newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonials newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonials query()
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonials whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonials whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonials whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonials whereLanguageSettingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonials whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonials whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonials whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Testimonials extends BaseModel
{
    protected $guarded = ['id'];

    public function language()
    {
        return $this->belongsTo(LanguageSetting::class, 'language_setting_id');
    }

}
