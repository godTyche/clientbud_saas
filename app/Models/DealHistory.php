<?php

namespace App\Models;

use App\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes;

class DealHistory extends Model
{
    // use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'deal_id',
        'event_type',
        'created_by',
        'deal_stage_id',
        'file_id',
        'task_id',
        'follow_up_id',
        'note_id',
        'agent_id',
        'proposal_id'
    ];

    protected $with = ['user'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by')->withoutGlobalScope(ActiveScope::class);
    }
}
