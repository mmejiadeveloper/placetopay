<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('GuzzleHttp\Client', function (){
            return new Client([
                'base_uri' => 'https://test.placetopay.com/',
                'timeout'  => 2.0,
            ]);
        });
        $this->app->bind('App\Interfaces\PizzaBuilderInterface', 'App\Repositories\MargarithaBuilder', 'App\Repositories\PizzaBuilder');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
