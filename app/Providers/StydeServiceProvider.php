<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class StydeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('App\Interfaces\PizzaBuilderInterface', 'App\Repositories\MargarithaBuilder');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
