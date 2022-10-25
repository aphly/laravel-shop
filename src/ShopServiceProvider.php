<?php

namespace Aphly\LaravelShop;

use Aphly\Laravel\Providers\ServiceProvider;
use Aphly\LaravelShop\Middleware\Guest;

class ShopServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/public' => public_path('static/shop')
        ]);
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'laravel-shop');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->addRouteMiddleware('guest', Guest::class);
    }

}
