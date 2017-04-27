<?php

namespace App\Listeners;

use App\Events\MarketEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarketEventListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\MArketEvent $event
     */
    public function handle(\App\Events\MarketEvent $event)
    {
        $market = $event->market;

        if ($event->action === 'created') {
            \Mail::send(
                'emails.markets.created',
                compact('market'),
                function ($message) {
                    $message->to(config('mail.from.address'));
                    $message->subject(sprintf('[%s] %s', config('app.name'), '새로운 포럼 글이 등록되었습니다.: :title'));
                }
            );
        }
    }
}
