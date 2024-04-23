<?php

namespace Authentication;

use Illuminate\Support\ServiceProvider;

class AuthenticationServiceProvider extends ServiceProvider
{
        /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadRoutesFrom(__DIR__.'/path/routes/routes.php');
        $this->loadViewsFrom(__DIR__.'/path/views', 'auth');

        // $this->publishes([
        //     __DIR__.'/path/views' => resource_path('views/vendor/courier'),
        // ]);

        $this->loadMigrationsFrom(__DIR__ . '/path/databases');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // $this->mergeConfigFrom(__DIR__.'/../config/authentication.php', 'authentication');

        // Register the service the package provides.
        $this->app->singleton('authentication', function ($app) {
            return new Authentication;
        });
    }
}