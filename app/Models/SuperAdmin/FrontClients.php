<?php

namespace App\Models\SuperAdmin;

use App\Models\LanguageSetting;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\SuperAdmin\FrontClients
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $image
 * @property int|null $language_setting_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $image_url
 * @property-read LanguageSetting|null $language
 * @method static \Illuminate\Database\Eloquent\Builder|FrontClients newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontClients newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontClients query()
 * @method static \Illuminate\Database\Eloquent\Builder|FrontClients whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontClients whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontClients whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontClients whereLanguageSettingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontClients whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FrontClients whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FrontClients extends BaseModel
{
    protected $guarded = ['id'];
    protected $appends = ['image_url'];

    public function language()
    {
        return $this->belongsTo(LanguageSetting::class, 'language_setting_id');
    }

    public function getImageUrlAttribute()
    {
        return ($this->image) ? asset_url_local_s3('front/client/' . $this->image) : asset('saas/img/home/client-'.($this->id).'.png');
    }

}
