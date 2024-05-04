<?php

namespace App\Models\SuperAdmin;

use App\Models\BaseModel;

/**
 * App\Models\SuperAdmin\SupportTicketType
 *
 * @property int $id
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketType query()
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketType whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SupportTicketType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SuperAdmin\SupportTicket[] $tickets
 * @property-read int|null $tickets_count
 */
class SupportTicketType extends BaseModel
{

    public function tickets()
    {
        return $this->hasMany(SupportTicket::class, 'support_ticket_type_id');
    }

}
