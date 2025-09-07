<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\JenisKegiatanController;
use App\Http\Controllers\Api\UnitRuanganController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        Route::put('profile', [AuthController::class, 'updateProfile']);
    });
});

// Admin routes
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::get('users', [AdminController::class, 'getUsers']);
    Route::post('users', [AdminController::class, 'createUser']);
    Route::put('users/{id}', [AdminController::class, 'updateUser']);
    Route::delete('users/{id}', [AdminController::class, 'deleteUser']);
    Route::get('stats', [AdminController::class, 'getStats']);
});

// Jenis Kegiatan Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('jenis-kegiatan', JenisKegiatanController::class);
});

// Unit Ruangan Routes - Test tanpa auth dulu
Route::get('unit-ruangan/by-nip/{nip}', [UnitRuanganController::class, 'getByNip']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('unit-ruangan', UnitRuanganController::class);
    // Route::get('unit-ruangan/by-nip/{nip}', [UnitRuanganController::class, 'getByNip']); // Pindah ke atas
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Detail Jenis Kegiatan routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('detail-jenis-kegiatan', DetailJenisKegiatanController::class);
    // Route::get('detail-jenis-kegiatan-units', [DetailJenisKegiatanController::class, 'getUnits']);
});

