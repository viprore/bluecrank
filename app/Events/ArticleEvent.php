<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ArticleEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $article;
    public $action;

    /**
     * Create a new event instance.
     *
     * @param \App\Article $article
     * @param string $action
     */
    public function __construct(\App\Article $article, $action = 'created')
    {
        $this->article = $article;
        $this->action = $action;
    }
}
