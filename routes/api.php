<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;

Route::get('/login', function (Request $request) {
    return response()->json(['message' => 'Unauthorized'], 401);
})->name('login');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('mahasiswa', MahasiswaController::class);
    Route::apiResource('matakuliah', MataKuliahController::class);
});