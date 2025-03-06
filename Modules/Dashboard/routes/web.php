<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\Http\Controllers\DashboardController;
use Modules\Permissions\Enums\PermissionEnum;

Route::prefix('admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])
        ->middleware(['redirect.if.not.authenticated', 'can:view_dashboard'])
        ->name('dashboard.index');
});
