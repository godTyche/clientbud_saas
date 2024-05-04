<?php

namespace App\Listeners;

use App\Events\EventStatusNoteEvent;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\EventStatusNote;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EventStatusNoteListener
{

    /**
     * Handle the event.
     */
    public function handle(EventStatusNoteEvent $event)
    {
        $host = User::find($event->event->host);

        Notification::send($event->notifyUser, new EventStatusNote($event->event));

        if ($host) {
            Notification::send($host, new EventStatusNote($event->event));
        }
    }

}
