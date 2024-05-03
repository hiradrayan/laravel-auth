<?php

use Illuminate\Support\Facades\Route;
use Authentication\path\controllers\AuthController;

// ->middleware('throttle:3,10')

Route::middleware('web')->namespace('Auth')->group(function () {
    Route::get('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('register', [AuthController::class, 'postRegister'])->name('auth.register');
    Route::get('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('login', [AuthController::class, 'postLogin'])->name('auth.login');
    Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');
});