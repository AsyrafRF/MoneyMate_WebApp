<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Kategori;
use App\Http\Controllers\Api\LoginApiController;
use App\Http\Controllers\Api\NotificationApiController;

// API Route Status
Route::get('/status', function () {
    return response()->json(['status' => 'API is running']);
});

// Tambahkan route API lainnya sesuai kebutuhan

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Semua route di sini otomatis diprefix dengan "/api" dan diproses tanpa
| session (stateless). Gunakan middleware 'auth:sanctum' untuk keamanan.
|
*/

Route::post('/login', [LoginApiController::class, 'apiLogin']);

// Default User API
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    // Authenticated API Routes
});

