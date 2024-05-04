<?php

namespace App\Models\SuperAdmin;

use App\Models\LanguageSetting;
use App\Models\BaseModel;

/**
 * App\Models\SuperAdmin\FrontFaq
 *
 * @property int $id
 * @property string $question
 * @property string $answer
 * @property int|null $language_setting_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read LanguageSetting|null $language
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFaq newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFaq newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFaq query()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFaq whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFaq whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFaq whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFaq whereLanguageSettingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFaq whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontFaq whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FrontFaq extends BaseModel
{
    protected $guarded = ['id'];

    public function language()
    {
        return $this->belongsTo(LanguageSetting::class, 'language_setting_id');
    }

}
