<?php

use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::get('/register', 'registerForm')->name('register.form');
    Route::post('/login', 'authenticate')->name('authenticate');
    Route::post('/register', 'register')->name('register');
    Route::middleware('auth')->group(function () {
        Route::post('/logout',  'logout')->name('logout');
    });
});
Route::middleware('auth')->group(function () {
    Route::resource('pegawai', PegawaiController::class);
});
