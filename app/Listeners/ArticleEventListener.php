<?php

namespace App\Listeners;

use App\Events\ArticleEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArticleEventListener
{
    /**
     * Handle the event.
     *
     * @param \App\Events\ArticleEvent $event
     */
    public function handle(\App\Events\ArticleEvent $event)
    {
        $article = $event->article;

        if ($event->action === 'created') {
            \Mail::send(
                'emails.articles.created',
                compact('article'),
                function ($message) {
                    $message->to(config('mail.from.address'));
                    $message->subject(sprintf('[%s] %s', config('app.name'), '새로운 포럼 글이 등록되었습니다.: :title'));
                }
            );
        }
    }
}
