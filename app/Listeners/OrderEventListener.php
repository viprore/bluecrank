<?php

namespace App\Listeners;

use App\Events\OrderEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderEventListener
{
    /**
     * Handle the event.
     *
     * @param  OrderEvent  $event
     * @return void
     */
    public function handle(OrderEvent $event)
    {
        $order = $event->order;

        if ($event->action === 'created') {
            \Mail::send(
                'emails.orders.created',
                compact('order'),
                function ($message) {
                    $message->to(config('mail.from.address'));
                    $message->subject(sprintf('[%s] %s', config('app.name'), '주문이 들어왔습니다.'));
                }
            );
        }
    }
}
