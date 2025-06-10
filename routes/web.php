<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// AuthController routes
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'index'])->name('register');
Route::post('/register', [AuthController::class, 'index'])->name('register.post');

// Dashboard route
Route::get('/dashboard', fn() => response()->json(['message' => 'Welcome to the Dashboard!']))
    ->name('dashboard.index')
    ->middleware(['auth']);
