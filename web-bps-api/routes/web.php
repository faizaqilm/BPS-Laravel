<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\AuthController;

Route::view('/', 'home')->name('home');

Route::resource('publikasi', PublikasiController::class);

Route::get('/galeri', function () {
    return 'Halaman galeri (belum dibuat)';
})->name('galeri.index');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');