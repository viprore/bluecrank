<?php

namespace App\Listeners;

use App\Events\CommentEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentEventListener
{
    /**
     * Handle the event.
     *
     * @param  CommentEvent  $event
     * @return void
     */
    public function handle(CommentEvent $event)
    {
        $comment = $event->comment; $comment->load('commentable');
        $to = $this->recipients($comment);

        if (! $to) {
            return;
        }

        $view = 'emails.comments.created';

        \Mail::send(
            $view,
            compact('comment'),
            function ($message) use($to) {
                $message->to($to);
                $message->subject(trans('emails.comments.created'));
            }
        );
    }

    /**
     * Recursively find email address from the given comment
     * and push them to recipients list.
     *
     * @param \App\Comment $comment
     * @return array
     */
    private function recipients(\App\Comment $comment)
    {
        static $to = [];

        if ($comment->parent) {
            $to[] = $comment->parent->user->email;
            $this->recipients($comment->parent);
        }

        if ($comment->commentable->notification) {
            $to[] = $comment->commentable->user->email;
        }

        return array_unique($to);
    }
}
