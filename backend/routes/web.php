<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetailJenisKegiatanController;
use App\Http\Controllers\SocialLoginController;

Route::get('/', function () {
    return redirect('/login');
});

// Google Socialite Routes
Route::get('/auth/google', [SocialLoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [SocialLoginController::class, 'handleGoogleCallback']);

Route::get('/register', function () {
    return view('register');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/user-dashboard', function () {
    return view('user-dashboard');
})->name('user-dashboard');

// Route untuk Master Data
Route::get('/master-data', function () {
    return view('master-data');
})->name('master-data');

// Route untuk Laporan
Route::get('/laporan', [DetailJenisKegiatanController::class, 'showLaporan'])->name('laporan');

// Detail Jenis Kegiatan page - Updated route
Route::get('/jenis-kegiatan/detail', function () {
    return view('jenis-kegiatan-detail');
})->name('jenis-kegiatan-detail');

// Fallback Route untuk melayani file gambar dokumentasi dari storage/app/public
Route::get('/storage/{path}', function ($path) {
    $disk = \Illuminate\Support\Facades\Storage::disk('public');
    if ($disk->exists($path)) {
        return $disk->response($path);
    }
    abort(404);
})->where('path', '.*');
