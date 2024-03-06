<?php

namespace Aphly\LaravelShop;

use Aphly\Laravel\Models\Comm;
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
        $this->mergeConfigFrom(
            __DIR__.'/config/shop.php', 'shop'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $comm_module= (new Comm)->moduleClass();
        if(in_array('Aphly\LaravelShop',$comm_module)){
            $this->publishes([
                __DIR__.'/public' => public_path('static/shop'),
                __DIR__.'/config/shop_init.sql' => storage_path('app/private/shop_init.sql'),
            ]);
            //$this->loadMigrationsFrom(__DIR__.'/migrations');
            $this->loadViewsFrom(__DIR__.'/views', 'laravel-shop');
            $this->loadViewsFrom(__DIR__.'/views/front', config('base.view_namespace_front'));
            $this->loadRoutesFrom(__DIR__.'/routes/web.php');
            $this->addRouteMiddleware('guest', Guest::class);
        }
    }

}
