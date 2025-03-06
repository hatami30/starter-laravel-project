<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AuthController;

Route::prefix('auth')->group(function () {
        Route::get('login', [AuthController::class, 'index'])
                ->middleware('redirect.if.authenticated')
                ->name('auth.index');

        Route::post('login', [AuthController::class, 'login'])
                ->middleware('redirect.if.authenticated')
                ->name('auth.login');

        Route::post('logout', [AuthController::class, 'logout'])
                ->middleware('redirect.if.not.authenticated')
                ->name('auth.logout');
});
