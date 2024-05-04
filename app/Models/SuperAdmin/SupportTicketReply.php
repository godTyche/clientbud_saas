<?php

namespace App\Models\SuperAdmin;

use App\Models\User;
use App\Scopes\CompanyScope;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Observers\SuperAdmin\SupportTicketReplyObserver;

/**
 * App\Models\SuperAdmin\SupportTicketReply
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SuperAdmin\SupportTicketFile[] $files
 * @property-read int|null $files_count
 * @property-read \App\Models\SuperAdmin\SupportTicket|null $ticket
 * @property-read User $user
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketReply newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketReply newQuery()
 * @method static \Illuminate\Database\Query\Builder|SupportTicketReply onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketReply query()
 * @method static \Illuminate\Database\Query\Builder|SupportTicketReply withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SupportTicketReply withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property int $support_ticket_id
 * @property int $user_id
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketReply whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketReply whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketReply whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketReply whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketReply whereSupportTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketReply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketReply whereUserId($value)
 */
class SupportTicketReply extends BaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $casts = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::observe(SupportTicketReplyObserver::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withoutGlobalScopes(['active', CompanyScope::class,]);
    }

    public function files()
    {
        return $this->hasMany(SupportTicketFile::class, 'support_ticket_reply_id');
    }

    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'support_ticket_id')->withTrashed();
    }

}
