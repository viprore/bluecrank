<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OrderEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $action;

    /**
     * Create a new event instance.
     *
     * @param \App\Order $order
     * @return void
     */
    public function __construct(\App\Order $order, $action = 'created')
    {
        $this->order = $order;
        $this->action = $action;
    }

}
