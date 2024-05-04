<?php

namespace App\Events\SuperAdmin;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use App\Models\SuperAdmin\SupportTicket;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SupportTicketRequesterEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;
    public $notifyUser;

    public function __construct(SupportTicket $ticket, $notifyUser)
    {
        $this->ticket = $ticket;
        $this->notifyUser = $notifyUser;
    }

}
