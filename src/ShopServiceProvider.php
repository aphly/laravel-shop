<?php

namespace Aphly\LaravelShop;

use Illuminate\Support\ServiceProvider;

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
        $this->publishes([
            __DIR__.'/config/shop.php' => config_path('shop.php'),
            __DIR__.'/config/shop_init.sql' => storage_path('app/private/shop_init.sql'),
            __DIR__.'/public' => public_path('vendor/laravel-shop')
        ]);
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'laravel-shop');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
    }



}
