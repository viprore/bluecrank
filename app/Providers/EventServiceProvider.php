<?php

namespace App\Providers;

use App\Events\UserCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Illuminate\Auth\Events\Login::class => [
            \App\Listeners\UserEventListener::class,
        ],
        \App\Events\ArticleEvent::class => [
            \App\Listeners\ArticleEventListener::class,
        ],
        \App\Events\MarketEvent::class => [
            \App\Listeners\MarketEventListener::class,
        ],
        \App\Events\ProductEvent::class => [
            \App\Listeners\ProductEventListener::class,
        ],
        \App\Events\CommentEvent::class => [
            \App\Listeners\CommentEventListener::class,
        ],
        \App\Events\ModelChanged::class => [
            \App\Listeners\CacheHandler::class,
        ],
//        \App\Events\CommentsEvent::class => [
//            \App\Listeners\CommentsEventListener::class,
//        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            'SocialiteProviders\Naver\NaverExtendSocialite@handle',
            'SocialiteProviders\Kakao\KakaoExtendSocialite@handle',
            'SocialiteProviders\Google\GoogleExtendSocialite@handle',
            'App\Providers\Facebook\FacebookExtendSocialite@handle',
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        \App\Listeners\UserEventListener::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
