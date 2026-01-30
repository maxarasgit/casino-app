<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () { return redirect()->route('lobby'); });

// 1. The Lobby (Main Menu)
Route::get('/', [GameController::class, 'showLobby'])
    ->middleware(['auth', 'verified'])
    ->name('lobby');

// 2. The Game Rooms (Visuals)
Route::middleware('auth')->group(function () {
    Route::get('/game/coin', [GameController::class, 'viewCoin'])->name('view.coin');
    Route::get('/game/slots', [GameController::class, 'viewSlots'])->name('view.slots');
    Route::get('/game/roulette', [GameController::class, 'viewRoulette'])->name('view.roulette');

    // 3. The Actions (Logic)
    Route::post('/play/coin', [GameController::class, 'playCoin'])->name('play.coin');
    Route::post('/play/slots', [GameController::class, 'playSlots'])->name('play.slots');
    Route::post('/play/roulette', [GameController::class, 'playRoulette'])->name('play.roulette');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Daily Reward
Route::post('/daily-reward', [GameController::class, 'claimDaily'])->name('daily.claim');

// Blackjack
Route::get('/game/blackjack', [GameController::class, 'viewBlackjack'])->name('view.blackjack');
Route::post('/play/blackjack', [GameController::class, 'blackjackAction'])->name('play.blackjack');
});

require __DIR__.'/auth.php';