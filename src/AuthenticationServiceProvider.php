<?php

namespace Authentication;

use Illuminate\Support\ServiceProvider;

class AuthenticationServiceProvider extends ServiceProvider
{
    public function boot()
    {

        $this->loadRoutesFrom(__DIR__.'/path/routes/routes.php');

        $this->publishes([
            __DIR__.'/../config/authentication.php' => config_path('authentication.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/authentication.php', 'authentication');

        if (config('authentication.authentication') == 'national_id')
        {
            $this->publishesMigrations([__DIR__ . '/path/natinalId/databases' => database_path('migrations')], 'migration');
            $this->loadViewsFrom(__DIR__.'/path/nationalId/views', 'auth');
            $this->publishes([__DIR__.'/../path/nationalId/views/login' => resource_path('views/auth'), 'login-form']);

        }
        

        // Register the service the package provides.
        $this->app->singleton('authentication', function ($app) {
            return new Authentication;
        });
    }
}