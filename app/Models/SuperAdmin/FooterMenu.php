<?php

namespace App\Models\SuperAdmin;

use App\Models\BaseModel;
use App\Models\LanguageSetting;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\SuperAdmin\FooterMenu
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $video_link
 * @property string|null $video_embed
 * @property string|null $file_name
 * @property string|null $hash_name
 * @property string|null $external_link
 * @property string|null $type
 * @property string|null $status
 * @property int|null $language_setting_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $video_url
 * @property-read LanguageSetting|null $language
 * @method static \Illuminate\Database\Eloquent\Builder|FooterMenu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterMenu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterMenu query()
 * @method static \Illuminate\Database\Eloquent\Builder|FooterMenu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterMenu whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterMenu whereExternalLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterMenu whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterMenu whereHashName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterMenu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterMenu whereLanguageSettingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterMenu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterMenu whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterMenu whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterMenu whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterMenu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterMenu whereVideoEmbed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FooterMenu whereVideoLink($value)
 * @mixin \Eloquent
 */
class FooterMenu extends BaseModel
{
    protected $table = 'footer_menu';

    public function language()
    {
        return $this->belongsTo(LanguageSetting::class, 'language_setting_id');
    }

    public function getVideoUrlAttribute()
    {
        return ($this->file_name) ? asset_url('footer-files/' . $this->file_name) : '';
    }

}
