<?php

namespace App\Events;

use App\Models\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventStatusNoteEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $event;
    public $notifyUser;

    public function __construct(Event $event, $notifyUser)
    {
        $this->event = $event;
        $this->notifyUser = $notifyUser;
    }

}
