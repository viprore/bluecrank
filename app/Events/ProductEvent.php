<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ProductEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $product;
    public $action;

    /**
     * Create a new event instance.
     *
     * @param \App\Product $product
     * @param string $action
     */
    public function __construct(\App\Product $product, $action = 'created')
    {
        $this->product = $product;
        $this->action = $action;
    }
}
