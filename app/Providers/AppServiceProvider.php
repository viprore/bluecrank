<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Carbon\Carbon::setLocale(config('app.locale'));

        view()->composer('*', function($view) {
            $articleTags = \Cache::rememberForever('tags.list.articles', function() {
                return \App\Tag::whereType('articles')->get();
            });
            $oldTags = \Cache::rememberForever('tags.list.olds', function() {
                return \App\Tag::whereType('olds')->get();
            });
            $productTags = \Cache::rememberForever('tags.list.products', function() {
                return \App\Tag::whereType('products')->get();
            });
            $categories = \Cache::rememberForever('categories.list', function() {
                return config('project.categories');
            });
            $statusList = \Cache::rememberForever('status.list', function() {
                return config('project.order_status');
            });

            $currentUser = auth()->user();
            $currentRouteName = \Route::currentRouteName();
            $currentLocale = app()->getLocale();
            $currentUrl = current_url();

            $view->with(compact('articleTags', 'oldTags', 'productTags', 'currentUser', 'currentRouteName', 'currentLocale', 'currentUrl', 'categories', 'statusList'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }
}
