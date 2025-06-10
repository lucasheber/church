<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => inertia('Test', [
    'message' => 'Hello, Inertia!',
]))->name('test');
