<?php

namespace App\Models\SuperAdmin;

use App\Traits\IconTrait;
use App\Models\BaseModel;

/**
 * App\Models\SuperAdmin\SupportTicketFile
 *
 * @property-read mixed $file_url
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketFile query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property int $support_ticket_reply_id
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
 * @property-read mixed $icon
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketFile whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketFile whereDropboxLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketFile whereExternalLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketFile whereExternalLinkName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketFile whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketFile whereGoogleUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketFile whereHashname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketFile whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketFile whereSupportTicketReplyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketFile whereUserId($value)
 */
class SupportTicketFile extends BaseModel
{
    use IconTrait;

    const FILE_PATH = 'support-ticket-files';

    protected $appends = ['file_url', 'icon'];

    public function getFileUrlAttribute()
    {
        return (!is_null($this->external_link)) ? $this->external_link : asset_url_local_s3('support-ticket-files/' . $this->support_ticket_reply_id . '/' . $this->hashname);
    }

}
