<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Holiday;
use App\Events\HolidayEvent;

class HolidayObserver
{

    public function saving(Holiday $holiday)
    {
        if (!isRunningInConsoleOrSeeding()) {
            $holiday->last_updated_by = user()->id;
        }
    }

    public function creating(Holiday $holiday)
    {
        if (!isRunningInConsoleOrSeeding()) {
            $holiday->added_by = user()->id;
        }

        if (company()) {
            $holiday->company_id = company()->id;
        }
    }

    public function created(Holiday $holiday)
    {
        $notifyUser = User::allEmployees();
        event(new HolidayEvent($holiday, request()->date, request()->occassion, $notifyUser));
    }

}
