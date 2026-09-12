<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GaleriController;

// Halaman Publik
Route::view('/', 'home')->name('home');

// Route AJAX Auto-Suggest (Harus di atas resource publikasi)
Route::get('/publikasi/hint', [PublikasiController::class, 'getHint'])->name('publikasi.hint');

Route::get('/publikasi', [PublikasiController::class, 'index'])->name('publikasi.index');
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');

// Halaman Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman Terproteksi (Admin)
Route::middleware('auth')->group(function () {
    Route::post('/publikasi/sync', [PublikasiController::class, 'syncApi'])->name('publikasi.sync');
    Route::resource('publikasi', PublikasiController::class)->except(['index', 'show']);
    Route::resource('galeri', GaleriController::class)->except(['index', 'show']);
});