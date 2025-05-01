<?php

use App\Http\Controllers\ChatController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    $users = User::whereNot('id', auth()->id())->get();

    return Inertia::render('Dashboard', [
        'users' => $users
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/chat/{user}', [ChatController::class, 'chatPage'])
    ->middleware(['auth', 'verified'])
    ->name('chat');

Route::post('/chat/{receiver}', [ChatController::class, 'sendMessage'])
    ->middleware(['auth', 'verified'])
    ->name('chat.send');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
