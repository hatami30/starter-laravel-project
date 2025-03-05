<?php

use Illuminate\Support\Facades\Route;
use Modules\Division\Http\Controllers\Web\DivisionController;

Route::prefix('admin')->middleware(['redirect.if.not.authenticated'])->group(function () {
    Route::prefix('division')->as('divisions.')->group(function () {
        Route::get('/', [DivisionController::class, 'index'])
            ->middleware('can:view_divisions')
            ->name('index');

        Route::get('create', [DivisionController::class, 'create'])
            ->middleware('can:create_divisions')
            ->name('create');

        Route::post('/', [DivisionController::class, 'store'])
            ->middleware('can:create_divisions')
            ->name('store');

        Route::get('{division}/edit', [DivisionController::class, 'edit'])
            ->middleware('can:edit_divisions')
            ->name('edit');

        Route::put('{division}', [DivisionController::class, 'update'])
            ->middleware('can:edit_divisions')
            ->name('update');

        Route::delete('{division}', [DivisionController::class, 'destroy'])
            ->middleware('can:delete_divisions')
            ->name('destroy');

        Route::post('save-table-settings', [DivisionController::class, 'saveTableSettings'])
            ->middleware('can:view_divisions')
            ->name('save.table.settings');
    });
});
