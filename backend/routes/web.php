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
// Route untuk Laporan Kinerja
Route::get('/laporan', [DetailJenisKegiatanController::class, 'showLaporanKinerja'])->name('laporan');
Route::get('/laporan/kinerja', [DetailJenisKegiatanController::class, 'showLaporanKinerja'])->name('laporan.kinerja');
Route::get('/laporan-kinerja', [DetailJenisKegiatanController::class, 'showLaporanKinerja'])->name('laporan-kinerja');

// Route untuk Rekap Bulanan
Route::get('/laporan/rekap-bulanan', [DetailJenisKegiatanController::class, 'showRekapBulanan'])->name('laporan.rekap-bulanan');
Route::get('/rekap-bulanan', [DetailJenisKegiatanController::class, 'showRekapBulanan'])->name('rekap-bulanan');

// Detail Jenis Kegiatan page - Updated route with server-side pre-population
Route::get('/jenis-kegiatan/detail', function (\Illuminate\Http\Request $request) {
    $dataParam = $request->query('data');
    $pageData = [];
    if ($dataParam) {
        $decoded = json_decode($dataParam, true);
        if (!$decoded) {
            $decoded = json_decode(urldecode($dataParam), true);
        }
        if (is_array($decoded)) {
            $pageData = $decoded;
        }
    }
    
    $prefilledJenisKegiatan = $pageData['jenis_kegiatan'] ?? $request->query('jenis_kegiatan', '');
    $prefilledNip = $pageData['nip'] ?? $request->query('nip', '');
    $prefilledUnit = $pageData['unit'] ?? $request->query('unit', '');
    $prefilledGolongan = $pageData['golongan'] ?? $request->query('golongan', '');
    $prefilledPetugas = $pageData['nama_pelaksana'] ?? $pageData['nama_petugas'] ?? '';
    $prefilledTanggal = now()->format('Y-m-d\TH:i');

    $nipUser = $prefilledNip ?: ($request->user()?->nip ?? auth()->user()?->nip ?? auth('web')->user()?->nip ?? '');
    $masterKegiatanList = [];
    if ($nipUser) {
        try {
            $masterKegiatanList = \App\Models\JenisKegiatan::where('nip', $nipUser)
                ->orderBy('created_at', 'desc')
                ->pluck('jenis_kegiatan')
                ->unique()
                ->values()
                ->toArray();
        } catch (\Throwable $e) {
            $masterKegiatanList = [];
        }
    }
    if ($prefilledJenisKegiatan && !in_array($prefilledJenisKegiatan, $masterKegiatanList)) {
        array_unshift($masterKegiatanList, $prefilledJenisKegiatan);
    }

    return view('jenis-kegiatan-detail', compact(
        'prefilledJenisKegiatan', 
        'prefilledNip', 
        'prefilledUnit', 
        'prefilledGolongan', 
        'prefilledPetugas', 
        'prefilledTanggal',
        'pageData',
        'masterKegiatanList'
    ));
})->name('jenis-kegiatan-detail');

// Fallback Route untuk melayani file gambar dokumentasi dari storage/app/public
Route::get('/storage/{path}', function ($path) {
    $disk = \Illuminate\Support\Facades\Storage::disk('public');
    if ($disk->exists($path)) {
        return $disk->response($path);
    }
    abort(404);
})->where('path', '.*');
