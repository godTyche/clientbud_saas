<?php

namespace App\Models\SuperAdmin;

use App\Models\LanguageSetting;
use App\Models\BaseModel;

/**
 * App\Models\SuperAdmin\SignUpSetting
 *
 * @property int $id
 * @property int|null $language_setting_id
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read LanguageSetting|null $language
 * @method static \Illuminate\Database\Eloquent\Builder|SignUpSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SignUpSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SignUpSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|SignUpSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SignUpSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SignUpSetting whereLanguageSettingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SignUpSetting whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SignUpSetting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SignUpSetting extends BaseModel
{

    public function language()
    {
        return $this->belongsTo(LanguageSetting::class, 'language_setting_id');
    }

}
