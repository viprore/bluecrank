<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MarketEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $market;
    public $action;

    /**
     * Create a new event instance.
     *
     * @param \App\Market $market
     * @param string $action
     */
    public function __construct(\App\Market $market, $action = 'created')
    {
        $this->market = $market;
        $this->action = $action;
    }
}
