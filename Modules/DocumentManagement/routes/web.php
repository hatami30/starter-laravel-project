<?php

use Illuminate\Support\Facades\Route;
use Modules\DocumentManagement\Http\Controllers\Web\DocumentManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan route web untuk aplikasi Anda.
| Semua route ini dilindungi oleh middleware yang sesuai dan terkait dengan pengelolaan dokumen.
|
*/

// Admin Routes (Secured routes with middleware)
Route::prefix('admin')->middleware(['redirect.if.not.authenticated'])->group(function () {
    Route::prefix('document')->group(function () {

        // Route untuk menampilkan daftar dokumen.
// Diperlukan izin 'view_documents' untuk mengakses rute ini.
        Route::get('/', [DocumentManagementController::class, 'index'])
            ->middleware('can:view_documents')
            ->name('documents.index');

        // Route untuk menampilkan form untuk menambah dokumen baru.
// Diperlukan izin 'create_documents' untuk mengakses rute ini.
        Route::get('create', [DocumentManagementController::class, 'create'])
            ->middleware('can:create_documents')
            ->name('documents.create');

        // Route untuk menyimpan data dokumen baru.
// Diperlukan izin 'create_documents' untuk mengakses rute ini.
        Route::post('/', [DocumentManagementController::class, 'store'])
            ->middleware('can:create_documents')
            ->name('documents.store');

        // Route untuk menampilkan form untuk mengedit dokumen yang sudah ada.
// Diperlukan izin 'edit_documents' untuk mengakses rute ini.
        Route::get('{document}/edit', [DocumentManagementController::class, 'edit'])
            ->middleware('can:edit_documents')
            ->name('documents.edit');

        // Route untuk memperbarui data dokumen.
// Diperlukan izin 'edit_documents' untuk mengakses rute ini.
        Route::put('{document}', [DocumentManagementController::class, 'update'])
            ->middleware('can:edit_documents')
            ->name('documents.update');

        // Route untuk menghapus dokumen.
// Diperlukan izin 'delete_documents' untuk mengakses rute ini.
        Route::delete('{document}', [DocumentManagementController::class, 'destroy'])
            ->middleware('can:delete_documents')
            ->name('documents.destroy');

        // Route untuk menyimpan pengaturan tabel dokumen (misalnya, kolom yang ditampilkan di tabel).
// Diperlukan izin 'view_documents' untuk mengakses rute ini.
        Route::post('save-table-settings', [DocumentManagementController::class, 'saveTableSettings'])
            ->middleware('can:view_documents')
            ->name('documents.save.table.settings');

        // Route untuk mengekspor data Dokumen ke Excel
        Route::get('export/excel', [DocumentManagementController::class, 'exportToExcel'])
            ->middleware('can:view_documents')
            ->name('documents.export.excel');

        // Route untuk mengekspor data Dokumen ke PDF
        Route::get('export/pdf', [DocumentManagementController::class, 'exportToPDF'])
            ->middleware('can:view_documents')
            ->name('documents.export.pdf');

        // Route untuk melihat detail Dokumen dalam bentuk PDF
        Route::get('{document}/view-pdf', [DocumentManagementController::class, 'viewPdf'])
            ->middleware('can:view_documents')
            ->name('documents.view.pdf');
    });
});

// Public Routes
// Route::prefix('documents')->group(function () {
//     // Route to show all divisions and categories
//     Route::get('/', [DocumentManagementController::class, 'publicIndex'])
//         ->name('documents.public.index');

//     // Route to show documents by division and category
//     Route::get('/{division}/{category}', [DocumentManagementController::class, 'publicDivisionCategory'])
//         ->name('documents.public.division.category');

//     // Route to show document details
//     Route::get('/document/{document}', [DocumentManagementController::class, 'publicShow'])
//         ->name('documents.public.show');
// });

Route::prefix('documents')->group(function () {
    // Route for displaying the public documents page (accessible without login)
    Route::get('/', [DocumentManagementController::class, 'publicIndex'])->name('documents.public.index');

    // Route to fetch categories for a specific division
    Route::get('/categories/{divisionId}', [DocumentManagementController::class, 'fetchCategories'])->name('documents.fetchCategories');

    // Route to fetch document details for a specific category
    Route::get('/details/{categoryId}', [DocumentManagementController::class, 'fetchDocumentDetails'])->name('documents.fetchDocumentDetails');

    // Route to download individual document
    Route::get('/documents/download/{documentId}/{fileName}', [DocumentManagementController::class, 'downloadFile'])->name('documents.download');

    // Route to view individual document file
    Route::get('/documents/view/{documentId}/{fileName}', [DocumentManagementController::class, 'viewFile'])->name('documents.view');

    // Route to download multiple documents (bulk download)
    Route::get('/documents/download-multiple', [DocumentManagementController::class, 'downloadMultiple'])->name('documents.downloadMultiple');
});

