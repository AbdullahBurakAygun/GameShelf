<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserGameController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    $user = auth()->user();

    if (! $user || $user->role !== 'admin') {
        abort(403);
    }

    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('admin.dashboard');

// Dashboard: rol bepaalt redirect
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('games.index'); // user page
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated routes (games + profile)
Route::middleware(['auth', 'verified'])->group(function () {

    // User games CRUD
    Route::resource('games', UserGameController::class)->except(['show']);

    // Profiel
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
