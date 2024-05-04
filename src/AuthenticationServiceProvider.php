<?php

namespace Authentication;

use Authentication\Interface\OtpSenderInterface;
use Illuminate\Support\ServiceProvider;

class AuthenticationServiceProvider extends ServiceProvider
{
    public function boot()
    {

        $this->loadRoutesFrom(__DIR__.'/path/routes/routes.php');

        $this->publishesMigrations([__DIR__ . '/path/databases' => database_path('migrations')], 'migration');
        $this->loadViewsFrom(__DIR__.'/path/nationalId/views', 'auth');
        // $this->publishes([__DIR__.'/../path/nationalId/views' => resource_path('views/auth')]);

        $this->publishes([__DIR__.'/../config/authentication.php' => config_path('authentication.php'), 'authentication-config']);

        $this->publishes([
            __DIR__.'/path/assets'                  => public_path('/assets'),
            __DIR__.'/path/nationalId/views'        => resource_path('views'),
            __DIR__.'/../config/authentication.php' => config_path('authentication.php'),
            __DIR__.'/path/OtpSender.php'           => app_path('Http/Services/Sms/OtpSender.php'),
            
        ], 'publisher-national-id');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/authentication.php', 'authentication');

        $this->app->bind(OtpSenderInterface::class, function ($app) {
            $customSmsSender = config('authentication.otp_sender');

            if ($customSmsSender) {
                return new $customSmsSender;
            }
        });
        

        // Register the service the package provides.
        $this->app->singleton('authentication', function ($app) {
            return new Authentication;
        });
    }
}