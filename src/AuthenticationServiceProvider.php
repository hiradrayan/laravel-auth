<?php

namespace Authentication;

use Illuminate\Support\ServiceProvider;

class AuthenticationServiceProvider extends ServiceProvider
{
    public function boot()
    {

        $this->loadRoutesFrom(__DIR__.'/path/routes/routes.php');

        $this->publishesMigrations([__DIR__ . '/path/databases' => database_path('migrations')], 'migration');
        $this->loadViewsFrom(__DIR__.'/path/views', 'auth');
        $this->publishes([__DIR__.'/../path/views/login' => resource_path('views/auth'), 'login-form']);

        $this->publishes([
            __DIR__.'/../config/authentication.php' => config_path('authentication.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/authentication.php', 'authentication');
        

        // Register the service the package provides.
        $this->app->singleton('authentication', function ($app) {
            return new Authentication;
        });
    }
}