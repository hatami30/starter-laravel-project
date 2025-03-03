<?php

use Illuminate\Support\Facades\Route;
use Modules\Division\Http\Controllers\Web\DivisionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan route web untuk aplikasi Anda.
| Semua route ini dilindungi oleh middleware yang sesuai dan terkait dengan pengelolaan divisi.
|
*/

Route::prefix('admin')->middleware(['redirect.if.not.authenticated'])->group(function () {
    Route::prefix('division')->as('divisions.')->group(function () {
        // Menampilkan daftar divisi
        // Diperlukan izin 'view_divisions' untuk mengakses rute ini
        Route::get('/', [DivisionController::class, 'index'])
            ->middleware('can:view_divisions')
            ->name('index');

        // Menampilkan form untuk membuat divisi baru
        // Diperlukan izin 'create_divisions' untuk mengakses rute ini
        Route::get('create', [DivisionController::class, 'create'])
            ->middleware('can:create_divisions')
            ->name('create');

        // Menyimpan divisi baru yang dibuat
        // Diperlukan izin 'create_divisions' untuk mengakses rute ini
        Route::post('/', [DivisionController::class, 'store'])
            ->middleware('can:create_divisions')
            ->name('store');

        // Menampilkan form untuk mengedit divisi berdasarkan ID
        // Diperlukan izin 'edit_divisions' untuk mengakses rute ini
        Route::get('{division}/edit', [DivisionController::class, 'edit'])
            ->middleware('can:edit_divisions')
            ->name('edit');

        // Memperbarui divisi berdasarkan ID
        // Diperlukan izin 'edit_divisions' untuk mengakses rute ini
        Route::put('{division}', [DivisionController::class, 'update'])
            ->middleware('can:edit_divisions')
            ->name('update');

        // Menghapus divisi berdasarkan ID
        // Diperlukan izin 'delete_divisions' untuk mengakses rute ini
        Route::delete('{division}', [DivisionController::class, 'destroy'])
            ->middleware('can:delete_divisions')
            ->name('destroy');

        // Menyimpan pengaturan tabel untuk pengguna
        // Diperlukan izin 'view_divisions' untuk mengakses rute ini
        Route::post('save-table-settings', [DivisionController::class, 'saveTableSettings'])
            ->middleware('can:view_divisions')
            ->name('save.table.settings');
    });
});
