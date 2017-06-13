<?php

namespace App\Listeners;

use App\Events\ProductEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductEventListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\ProductEvent $event
     */
    public function handle(\App\Events\ProductEvent $event)
    {
        $product = $event->product;

        if ($event->action === 'created') {
            \Mail::send(
                'emails.products.created',
                compact('product'),
                function ($message) {
                    $message->to(config('mail.from.address'));
                    $message->subject(sprintf('[%s] %s', config('app.name'), 'BC몰에 새 상품이 등록되었습니다.'));
                }
            );
        }
    }
}
