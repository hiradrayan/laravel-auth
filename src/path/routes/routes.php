<?php

use Authentication\path\controllers\GeneralController;
use Illuminate\Support\Facades\Route;
use Authentication\path\nationalId\controllers\AuthController;

// ->middleware('throttle:3,10')

if (config('authentication.authentication') == 'national_id') {
    Route::middleware('web')->namespace('Auth')->group(function () {

        Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
        Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

        Route::group([
            'prefix'=>'auth',
            'as' => 'auth.'
        ],function () {
            Route::get('/national-id', [AuthController::class, 'getNationalId'])->name('national_id');
            Route::post('/national-id', [AuthController::class, 'postNationalId']);
        
            Route::get('/password', [AuthController::class, 'getPassword'])->name('password');
            Route::post('/password', [AuthController::class, 'postPassword']);
        
            Route::get('/mobile', [AuthController::class, 'getMobile'])->name('mobile');
            Route::post('/mobile',[AuthController::class, 'postMobile'] );
        
            Route::get('/otp', [AuthController::class, 'getOtp'])->name('otp');
            Route::post('/otp', [AuthController::class, 'postOtp']);
        
            Route::get('/info', [AuthController::class, 'getUserInfo'])->name('user_info');
            Route::post('/info',[AuthController::class, 'postUserInfo']);
        
            Route::get('/extra-info', [AuthController::class, 'getExtraInfo'])->name('user_extra_info')->middleware('auth');
            Route::post('/extra-info',[AuthController::class, 'postExtraInfo'])->middleware('auth');
        
        
            Route::get('/trusted-user/info', [AuthController::class, 'getTrustedUserInfo'])->name('trusted_user_info');
            Route::post('/trusted-user/info',[AuthController::class, 'postTrustedUserInfo']);
        
        
            Route::group([
                'prefix' => 'forget',
                'as' => 'forget.'
            ], function() {
                Route::get('/national-id',[ForgetPasswordController::class, 'getNationalId'])->name('national_id');
                Route::post('/national-id',[ForgetPasswordController::class, 'postNationalId']);
        
                Route::get('/otp',[ForgetPasswordController::class, 'getOtp'])->name('otp');
                Route::post('/otp',[ForgetPasswordController::class, 'postOtp']);
        
                Route::get('/password',[ForgetPasswordController::class, 'getPassword'])->name('password');
                Route::post('/password',[ForgetPasswordController::class, 'postPassword']);
        
            });
        });
    });

    Route::group([
        'prefix'=>'api',
        'as' => 'api.',
    ],function () {
    
        Route::group([
            'prefix'=>'auth',
            'as' => 'auth.',
        ],function () {
            Route::post('/otp-resend', [AuthController::class,'resendOtp'])->name('otp.resend');
        });
    });
}

$registerFields = config('authentication.database.registerFields');
if (is_array($registerFields) && array_key_exists('province_and_city', $registerFields)){
    Route::post('/general/province-cities', [GeneralController::class,'getProvinceCities'])->name('get_province_cities');
}
