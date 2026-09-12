<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\PublikasiController;

Route::view('/', 'home')->name('home');

// sementara, nanti diganti Route::resource() pas bikin CRUD beneran
Route::resource('publikasi', PublikasiController::class);
Route::get('/galeri', function () {
    return 'Halaman galeri (belum dibuat)';
})->name('galeri.index');

use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');