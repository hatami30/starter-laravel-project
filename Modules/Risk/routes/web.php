<?php

use Illuminate\Support\Facades\Route;
use Modules\Risk\Http\Controllers\Web\RiskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan route web untuk aplikasi Anda.
| Semua route ini dilindungi oleh middleware yang sesuai dan terkait dengan pengelolaan risiko.
|
*/

Route::prefix('admin')->middleware(['redirect.if.not.authenticated'])->group(function () {
    Route::prefix('risk')->group(function () {

        // Route untuk menampilkan daftar risiko.
        // Diperlukan izin 'view_risks' untuk mengakses rute ini.
        Route::get('/', [RiskController::class, 'index'])
            ->middleware('can:view_risks')
            ->name('risks.index');

        // Route untuk menampilkan form untuk menambah risiko baru.
        // Diperlukan izin 'create_risks' untuk mengakses rute ini.
        Route::get('create', [RiskController::class, 'create'])
            ->middleware('can:create_risks')
            ->name('risks.create');

        // Route untuk menyimpan data risiko baru.
        // Diperlukan izin 'create_risks' untuk mengakses rute ini.
        Route::post('/', [RiskController::class, 'store'])
            ->middleware('can:create_risks')
            ->name('risks.store');

        // Route untuk menampilkan form untuk mengedit risiko yang sudah ada.
        // Diperlukan izin 'edit_risks' untuk mengakses rute ini.
        Route::get('{risk}/edit', [RiskController::class, 'edit'])
            ->middleware('can:edit_risks')
            ->name('risks.edit');

        // Route untuk memperbarui data risiko.
        // Diperlukan izin 'edit_risks' untuk mengakses rute ini.
        Route::put('{risk}', [RiskController::class, 'update'])
            ->middleware('can:edit_risks')
            ->name('risks.update');

        // Route untuk menghapus risiko.
        // Diperlukan izin 'delete_risks' untuk mengakses rute ini.
        Route::delete('{risk}', [RiskController::class, 'destroy'])
            ->middleware('can:delete_risks')
            ->name('risks.destroy');

        // Route untuk menyimpan pengaturan tabel risiko (misalnya, kolom yang ditampilkan di tabel).
        // Diperlukan izin 'view_risks' untuk mengakses rute ini.
        Route::post('save-table-settings', [RiskController::class, 'saveTableSettings'])
            ->middleware('can:view_risks')
            ->name('risks.save.table.settings');
    });
});
