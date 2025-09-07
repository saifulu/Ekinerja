<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

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

// Detail Jenis Kegiatan page - Updated route
Route::get('/jenis-kegiatan/detail', function () {
    return view('jenis-kegiatan-detail');
})->name('jenis-kegiatan-detail');
