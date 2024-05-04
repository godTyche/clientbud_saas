<?php

namespace App\Models\SuperAdmin;

use App\Models\BaseModel;
use App\Models\LanguageSetting;

/**
 * App\Models\SuperAdmin\Feature
 *
 * @property int $id
 * @property int|null $language_setting_id
 * @property string $title
 * @property string|null $description
 * @property string|null $image
 * @property string|null $icon
 * @property string $type
 * @property int|null $front_feature_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $image_url
 * @property-read LanguageSetting|null $language
 * @method static \Illuminate\Database\Eloquent\Builder|Feature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature query()
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereFrontFeatureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereLanguageSettingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Feature whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Feature extends BaseModel
{
    protected $appends = ['image_url'];

    public function language()
    {
        return $this->belongsTo(LanguageSetting::class, 'language_setting_id');
    }

    public function getImageUrlAttribute()
    {
        if ($this->type == 'image' && is_null($this->image)) {
            if ($this->title == 'Meet Your Business Needs') {
                return asset('saas/img/svg/mock-banner.svg');
            }

            if ($this->title == 'Analyse Your Workflow') {
                return asset('saas/img/svg/mock-2.svg');
            }

            if ($this->title == 'Manage your support tickets efficiently') {
                return asset('saas/img/svg/mock-1.svg');
            }
        }

        if ($this->type == 'apps') {
            if(!is_null($this->image)){
                return asset_url_local_s3('front/feature/' . $this->image);
            }

            if (strtolower($this->title) == 'onesignal') {
                return asset('saas/img/pages/onesignal.svg');
            }

            if (strtolower($this->title) == 'paypal') {
                return asset('saas/img/pages/paypal.svg');
            }

            if (strtolower($this->title) == 'slack') {
                return asset('saas/img/pages/slack-new-logo.svg');
            }

            if (strtolower($this->title) == 'pusher') {
                return asset('saas/img/pages/pusher.svg');
            }

            return asset('saas/img/pages/app-' . (($this->id) % 6) . '.png');
        }

        return ($this->image) ? asset_url_local_s3('front/feature/' . $this->image) : asset('front/img/tools.png');
    }

}
