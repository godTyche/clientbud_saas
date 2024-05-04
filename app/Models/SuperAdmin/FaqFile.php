<?php

namespace App\Models\SuperAdmin;

use App\Traits\IconTrait;
use App\Models\BaseModel;

/**
 * App\Models\SuperAdmin\FaqFile
 *
 * @property int $id
 * @property int $user_id
 * @property int $faq_id
 * @property string $filename
 * @property string|null $description
 * @property string|null $google_url
 * @property string|null $hashname
 * @property string|null $size
 * @property string|null $dropbox_link
 * @property string|null $external_link
 * @property string|null $external_link_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $file_url
 * @method static \Illuminate\Database\Eloquent\Builder|FaqFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FaqFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FaqFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|FaqFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqFile whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqFile whereDropboxLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqFile whereExternalLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqFile whereExternalLinkName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqFile whereFaqId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqFile whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqFile whereGoogleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqFile whereHashname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqFile whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FaqFile whereUserId($value)
 * @mixin \Eloquent
 * @property-read mixed $icon
 */
class FaqFile extends BaseModel
{
    use IconTrait;

    protected $appends = ['file_url'];

    public function getFileUrlAttribute()
    {
        return (!is_null($this->external_link)) ? $this->external_link : asset_url_local_s3('faq-files/'.$this->faq_id.'/'.$this->hashname);
    }

}
