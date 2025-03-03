<?php

// use Illuminate\Support\Facades\Route;
// use Modules\User\Http\Controllers\API\UserController;

// /*
// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------
// |
// | Di sini Anda dapat mendaftarkan route API untuk aplikasi Anda.
// |
// */

// Route::prefix('api')->middleware('api')->group(function () {

//     // Route tanpa autentikasi
//     Route::post('login', [UserController::class, 'login']); // Login dan mendapatkan token

//     // Semua route di bawah ini memerlukan autentikasi
//     Route::middleware('auth:sanctum')->group(function () {
//         Route::get('users', [UserController::class, 'index']);    // Menampilkan daftar pengguna
//         Route::get('users/{id}', [UserController::class, 'show']); // Menampilkan detail pengguna
//         Route::post('users', [UserController::class, 'store']);   // Menyimpan pengguna baru
//         Route::put('users/{id}', [UserController::class, 'update']); // Memperbarui pengguna
//         Route::delete('users/{id}', [UserController::class, 'destroy']); // Menghapus pengguna
//     });
// });
