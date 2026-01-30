<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController; // Don't forget this import!
use Illuminate\Support\Facades\Route;

// 1. The Home Route (Now points to your Casino)
Route::get('/', [GameController::class, 'showHome'])
    ->middleware(['auth', 'verified'])
    ->name('home');

// 2. Redirect Dashboard to Home 
// (If a user types /dashboard, it sends them to the casino instead)
Route::get('/dashboard', function () {
    return redirect()->route('home');
});

// 3. The Game Action
Route::get('/flip', [GameController::class, 'flipCoin'])
    ->middleware('auth')
    ->name('flip');

// 4. Profile Routes (Breeze Defaults)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';