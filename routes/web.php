<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserGameController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;
use App\Models\Game;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard'); 
    }

    return redirect()->route('games.index');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware(['auth', 'verified'])->group(function () {

    
    Route::middleware('can:admin-only')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

           
            Route::get('/', function () {
               return view('admin.users.dashboard', [
                'totalUsers'  => User::count(),
                'totalAdmins' => User::where('role', 'admin')->count(),
                'totalGames'  => Game::count(),
                'latestUsers' => User::latest()->take(5)->get(),
                ]);
            })->name('dashboard');

            
            Route::resource('users', AdminUserController::class)->except(['show']);
        });

    
    Route::resource('games', UserGameController::class)->except(['show']);

    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
