<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Spin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function showHome()
    {
        // 1. Get the currently logged-in user
        $user = Auth::user();

        // 2. If nobody is logged in, redirect to login page
        if (!$user) {
            return redirect('/login');
        }

        // 3. Get last 5 spins for the logged-in user
        $history = Spin::where('user_id', $user->id)->latest()->take(5)->get();

        // 4. FIX: Get the top 5 players for the leaderboard
        $leaderboard = User::orderBy('chips', 'desc')->take(5)->get();

        // 5. Send ALL variables to the view
        return view('casino', [
            'chips' => $user->chips,
            'history' => $history,
            'leaderboard' => $leaderboard // This line stops the "Undefined variable" error
        ]);
    }

    public function flipCoin()
    {
        // Use the logged-in user
        $user = Auth::user();
        $bet = 50;

        if (!$user || $user->chips < $bet) {
            return redirect('/')->with('message', 'Not enough chips!');
        }

        // Game Logic
        $user->chips -= $bet;
        $win = rand(0, 1);
        $payout = $win ? 100 : 0;
        $resultText = $win ? "HEADS" : "TAILS";

        if ($win) { 
            $user->chips += $payout; 
        }
        
        $user->save();

        // Save to History
        Spin::create([
            'user_id' => $user->id,
            'result' => $resultText,
            'bet' => $bet,
            'payout' => $payout
        ]);

        $msg = $win ? "🔥 JACKPOT! It was $resultText (+50)" : "💀 Bummer! It was $resultText (-50)";
        return redirect('/')->with('message', $msg);
    }
}