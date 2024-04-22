<?php

use Illuminate\Support\Facades\Route;
use Authentication\path\controllers\AuthController;

Route::middleware('web')->namespace('Auth')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('auth.admin.login');
    Route::post('login', [AuthController::class, 'loginPost'])
    // ->middleware('throttle:3,10')
    ->name('auth.admin.login.post');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.admin.logout');
});