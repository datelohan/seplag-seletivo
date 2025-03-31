<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\FotoPessoaController;

// Página inicial
Route::get('/', function () {
    return view('welcome');
});

// Rotas de autenticação (usando o guard 'web' com sessões)
Route::middleware(['guest:web'])->group(function () {
    Route::get('/login_session', function () {
        return view('auth.login'); // Certifique-se de que o arquivo está em resources/views/auth/login.blade.php
    })->name('login_session');

    Route::get('/register_session', function () {
        return view('auth.register'); // Certifique-se de que o arquivo está em resources/views/auth/register.blade.php
    })->name('register_session');
});

Route::post('/login_session', [AuthController::class, 'login_session'])->name('login_session');
Route::post('/register_session', [AuthController::class, 'register_session'])->name('register_session');
Route::post('/logout_session', [AuthController::class, 'logout_session'])->name('logout_session')->middleware('auth');

// Rotas SPA
Route::get('/login', function () {
    return view('spa.login');
})->name('login');

Route::get('/dashboard', function () {
    return view('spa.dashboard');
})->middleware('auth')->name('dashboard');


