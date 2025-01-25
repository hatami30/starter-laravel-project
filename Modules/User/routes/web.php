<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Web\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')->middleware(['redirect.if.not.authenticated'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])
            ->middleware('can:view_users')
            ->name('user.index');
        Route::get('create', [UserController::class, 'create'])->name('user.create');
        Route::post('/', [UserController::class, 'store'])->name('user.store');
        Route::get('{user}', [UserController::class, 'show'])->name('user.show');
        Route::get('{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('{user}', [UserController::class, 'destroy'])->name('user.destroy');

        // Save table settings route within user prefix
        Route::post('save-table-settings', [UserController::class, 'saveTableSettings'])
            ->middleware('can:view_users')
            ->name('user.save.table.settings');
    });
});