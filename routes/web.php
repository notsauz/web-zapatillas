<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;

// Página principal para autenticación
Route::get('/', function () {
    return auth()->check()
        ? view('home')
        : redirect()->route('login');
})->name('home');

// REGISTRO
Route::get('/register', [RegisterController::class, 'showForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// LOGIN
Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// LOGOUT
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');




