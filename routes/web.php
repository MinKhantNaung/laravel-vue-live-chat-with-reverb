<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/users', UserController::class)->name('users');

    Route::prefix('/chat')->group(function () {
        Route::get('/{user}', [ChatController::class, 'chatPage'])->name('chat');
        Route::post('/{receiver}', [ChatController::class, 'sendMessage'])->name('chat.send');
    });
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
