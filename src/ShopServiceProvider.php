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
        ]);
        $this->publishes([__DIR__.'/public' => public_path('vendor/laravel-shop')]);
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'laravel-shop');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
//        $this->addMiddlewareAlias('managerAuth', ManagerAuth::class);
//        $this->addMiddlewareAlias('rbac', Rbac::class);
    }

    protected function addMiddlewareAlias($name, $class)
    {
        $router = $this->app['router'];
        if (method_exists($router, 'aliasMiddleware')) {
            return $router->aliasMiddleware($name, $class);
        }
        return $router->middleware($name, $class);
    }

}
