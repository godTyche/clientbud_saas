<?php

namespace App\Observers;

use App\Models\Deal;
use App\Models\User;
use App\Events\DealEvent;
use App\Events\LeadEvent;
use App\Models\DealHistory;
use App\View\Components\Auth;
use App\Models\UniversalSearch;
use App\Notifications\LeadAgentAssigned;
use Illuminate\Support\Facades\Notification;
use App\Traits\DealHistoryTrait;

class DealObserver
{

    use DealHistoryTrait;

    public function saving(Deal $deal)
    {
        if (!isRunningInConsoleOrSeeding()) {
            $userID = (!is_null(user())) ? user()->id : null;
            $deal->last_updated_by = $userID;
        }

        if (!isRunningInConsoleOrSeeding()) {
            if (request()->has('added_by')) {
                $deal->added_by = request('added_by');

            }
            else {
                $userID = (!is_null(user())) ? user()->id : null;
                $deal->added_by = $userID;
            }
        }


        $deal->next_follow_up = 'yes';
    }

    public function creating(Deal $deal)
    {
        $deal->hash = md5(microtime());

        if (!isRunningInConsoleOrSeeding()) {
            if (request()->has('added_by')) {
                $deal->added_by = request('added_by');

            }
            else {
                $userID = (!is_null(user())) ? user()->id : null;
                $deal->added_by = $userID;
            }
        }

        if (company()) {
            $deal->company_id = company()->id;
        }
    }

    public function updated(Deal $deal)
    {
        if (!isRunningInConsoleOrSeeding()) {
            self::createDealHistory($deal->id, 'stage-updated', agentId: $deal->agent_id);


            if ($deal->isDirty('agent_id')) {
                event(new DealEvent($deal, $deal->leadAgent, 'LeadAgentAssigned'));
            }

            if ($deal->isDirty('pipeline_stage_id') || $deal->isDirty('lead_pipeline_id')) {
                event(new DealEvent($deal, $deal->leadAgent, 'StageUpdated'));
            }
        }
    }

    public function created(Deal $deal)
    {

        if (!isRunningInConsoleOrSeeding()) {
            if (request('agent_id') != '') {
                event(new DealEvent($deal, $deal->leadAgent, 'LeadAgentAssigned'));
                self::createDealHistory($deal->id, 'agent-assigned', agentId: $deal->agent_id);

            }
            else {
                Notification::send(User::allAdmins($deal->company->id), new LeadAgentAssigned($deal));
            }
        }
    }

    public function deleting(Deal $deal)
    {
        $notifyData = ['App\Notifications\LeadAgentAssigned'];
        \App\Models\Notification::deleteNotification($notifyData, $deal->id);

    }

    public function deleted(Deal $deal)
    {
        UniversalSearch::where('searchable_id', $deal->id)->where('module_type', 'lead')->delete();
    }

}
