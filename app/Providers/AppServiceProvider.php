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
        \App\Models\Shop::observe(\App\Observers\ShopObserver::class);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
