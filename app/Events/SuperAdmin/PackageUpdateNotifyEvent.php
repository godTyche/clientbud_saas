<?php

namespace App\Events\SuperAdmin;

use App\Models\PackageUpdateNotify;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PackageUpdateNotifyEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $packageUpdateNotify;

    /**
     * Create a new event instance.
     */
    public function __construct(PackageUpdateNotify $packageUpdateNotify)
    {
        $this->packageUpdateNotify = $packageUpdateNotify;
    }

}
