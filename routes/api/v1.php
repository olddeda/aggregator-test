<?php

use Illuminate\Support\Facades\Route;

use App\Modules\Auth\Http\Controllers\AuthController;
use App\Modules\Auth\Http\Controllers\AuthCodeController;
use App\Modules\News\Http\Controllers\NewsController;
use App\Modules\Users\Http\Controllers\UserController;

Route::controller(AuthController::class)->group(function () {
    Route::get('/auth', 'index')
        ->middleware('auth')
        ->name('auth.index');
    Route::post('/auth', 'auth')
        ->name('auth')
        ->middleware('throttle:'.config('auth.code.throttle_request').','.(config('auth.sms.throttle') / 60));
    Route::post('/auth/code', 'authCode')
        ->name('auth.code')
        ->middleware('throttle:'.config('auth.code.throttle_request').','.(config('auth.code.throttle') / 60));
    Route::get('/auth/me', 'me')
        ->middleware('auth')
        ->name('auth.me');
    Route::post('/auth/logout', 'logout')
        ->middleware('auth')
        ->name('auth.logout');
});

Route::controller(AuthCodeController::class)->group(function () {
    Route::get('/auth/codes', 'index')
        ->middleware('auth')
        ->name('auth.code.index');
    Route::get('/auth/codes/{authCode}', 'show')
        ->middleware('auth')
        ->name('auth.code.show')
        ->whereNumber('authCode');
});


Route::controller(NewsController::class)->group(function () {
    Route::get('/news', 'index')
        ->middleware('auth')
        ->name('news.index');
    Route::get('/news/{news}', 'show')
        ->middleware('auth')
        ->name('news.show')
        ->whereNumber('news');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/users', 'index')
        ->middleware('auth')
        ->name('users.index');
    Route::get('/users/{user}', 'show')
        ->middleware('auth')
        ->name('users.show')
        ->whereNumber('user');
});
