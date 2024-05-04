<?php

namespace App\Listeners\SuperAdmin;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\SuperAdmin\EmailVerificationEvent;
use App\Notifications\SuperAdmin\EmailVerification;

class EmailVerificationListener
{

    /**
     * Handle the event.
     *
     * @param  \App\Events\SuperAdmin\EmailVerificationEvent  $event
     * @return void
     */
    public function handle(EmailVerificationEvent $event)
    {
        $event->user->notify(new EmailVerification($event->user));
    }

}
