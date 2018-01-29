<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Topic;
use App\Models\Link;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        \Carbon\Carbon::setLocale('zh');

        User::observe(UserObserver::class);

        Topic::observe(TopicObserve::class);

        Link::observe(LinkObserve::class);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
   public function register()
    {
        if (app()->isLocal()) {
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }
    }

   
}
