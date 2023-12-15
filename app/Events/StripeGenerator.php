<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StripeGenerator extends Event
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cmd;
    public $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($cmd, $data)
    {
        $this->cmd = $cmd;
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('stripe');
    }

}
