<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Spin; // Ensure you have this model, or remove Spin code if not using DB history
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class GameController extends Controller
{
    // ==========================================
    // 1. VIEW ROUTES (Show the game pages)
    // ==========================================
    public function showLobby() {
        return view('lobby', ['user' => Auth::user()]);
    }
    
    public function viewCoin() {
        return view('games.coin', ['user' => Auth::user()]);
    }

    public function viewSlots() {
        return view('games.slots', ['user' => Auth::user()]);
    }

    public function viewRoulette() {
        return view('games.roulette', ['user' => Auth::user()]);
    }
    
    public function viewBlackjack() {
        $game = Session::get('blackjack');
        return view('games.blackjack', ['user' => Auth::user(), 'game' => $game]);
    }

    // ==========================================
    // 2. DAILY REWARDS
    // ==========================================
    public function claimDaily() {
        $user = Auth::user();
        
        // Check if 24 hours have passed
        if ($user->last_daily_reward && Carbon::parse($user->last_daily_reward)->addHours(24)->isFuture()) {
            return back()->with('error', 'Come back tomorrow!');
        }

        $user->chips += 500;
        $user->last_daily_reward = now();
        $user->save();

        return back()->with('success', 'You claimed 500 Free Chips!');
    }

    // ==========================================
    // 3. BLACKJACK LOGIC (The Card Game)
    // ==========================================
    public function blackjackAction(Request $request) {
        $action = $request->input('action');
        $user = Auth::user();
        
        // A. DEAL NEW HAND
        if ($action == 'deal') {
            $bet = $request->input('bet', 50);
            if ($user->chips < $bet) return back()->with('error', 'Insufficient Funds');
            
            $user->chips -= $bet;
            $user->save();

            $deck = $this->createDeck();
            $playerHand = [$this->draw($deck), $this->draw($deck)];
            $dealerHand = [$this->draw($deck), $this->draw($deck)];

            Session::put('blackjack', [
                'deck' => $deck,
                'player_hand' => $playerHand,
                'dealer_hand' => $dealerHand,
                'bet' => $bet,
                'status' => 'playing', 
                'message' => 'Your Move: Hit or Stand?'
            ]);
            
            // Check for instant Blackjack
            if ($this->calcScore($playerHand) == 21) {
                return $this->endBlackjack($user, 2.5, "BLACKJACK! You win!");
            }
        }

        // B. HIT (Take card)
        if ($action == 'hit') {
            $game = Session::get('blackjack');
            $game['player_hand'][] = $this->draw($game['deck']);
            
            if ($this->calcScore($game['player_hand']) > 21) {
                $game['status'] = 'player_bust';
                $game['message'] = 'BUST! You went over 21.';
                Session::put('blackjack', $game);
                return back();
            }
            Session::put('blackjack', $game);
        }

        // C. STAND (End turn)
        if ($action == 'stand') {
            $game = Session::get('blackjack');
            
            // Dealer plays
            while ($this->calcScore($game['dealer_hand']) < 17) {
                $game['dealer_hand'][] = $this->draw($game['deck']);
            }

            $pScore = $this->calcScore($game['player_hand']);
            $dScore = $this->calcScore($game['dealer_hand']);

            if ($dScore > 21) {
                return $this->endBlackjack($user, 2, "Dealer Busts! You Win!");
            } elseif ($pScore > $dScore) {
                return $this->endBlackjack($user, 2, "You Win!");
            } elseif ($pScore == $dScore) {
                return $this->endBlackjack($user, 1, "Push (Tie). Money Back.");
            } else {
                $game['status'] = 'loss';
                $game['message'] = "Dealer Wins ($dScore vs $pScore)";
                Session::put('blackjack', $game);
            }
        }

        return back();
    }

    // Blackjack Helpers
    private function endBlackjack($user, $multiplier, $msg) {
        $game = Session::get('blackjack');
        $winAmount = $game['bet'] * $multiplier;
        $user->chips += $winAmount;
        $user->save();
        
        $game['status'] = 'over';
        $game['message'] = $msg . " (+$winAmount)";
        Session::put('blackjack', $game);
        return back();
    }

    private function createDeck() {
        $suits = ['♥', '♦', '♣', '♠'];
        $values = [2,3,4,5,6,7,8,9,10,'J','Q','K','A'];
        $deck = [];
        foreach($suits as $s) foreach($values as $v) $deck[] = ['s'=>$s, 'v'=>$v];
        shuffle($deck);
        return $deck;
    }

    private function draw(&$deck) { return array_pop($deck); }

    private function calcScore($hand) {
        $score = 0; $aces = 0;
        foreach($hand as $card) {
            $v = $card['v'];
            if (is_numeric($v)) $score += $v;
            elseif ($v == 'A') { $score += 11; $aces++; }
            else $score += 10;
        }
        while ($score > 21 && $aces > 0) { $score -= 10; $aces--; }
        return $score;
    }

    // ==========================================
    // 4. COIN FLIP (Pro Logic)
    // ==========================================
    public function playCoin(Request $request) {
        $user = Auth::user();
        $bet = $request->input('bet', 50);

        if ($user->chips < $bet) return back()->with('error', 'Insufficient Funds');
        $user->chips -= $bet;

        $win = rand(0, 1);
        $choice = $request->input('choice'); 
        $result = $win ? 'heads' : 'tails';
        
        $isWin = ($choice == $result);
        $payout = 0;

        // Streak Bonus
        $streak = Session::get('coin_streak', 0);

        if ($isWin) {
            $streak++;
            $multiplier = 2;
            if ($streak >= 3) { $multiplier = 2.5; } 
            $payout = $bet * $multiplier;
            $user->chips += $payout;
        } else {
            $streak = 0; 
        }
        
        Session::put('coin_streak', $streak);
        $user->save();
        $this->saveHistory($user, "Coin: " . ucfirst($result), $bet, $payout);

        return back()->with('result', [
            'win' => $isWin, 'val' => $result, 'payout' => $payout, 'streak' => $streak
        ]);
    }

    // ==========================================
    // 5. SLOTS (Pro Logic)
    // ==========================================
    public function playSlots() {
        $user = Auth::user();
        $bet = 100;
        if ($user->chips < $bet) return back()->with('error', 'Insufficient Funds');
        $user->chips -= $bet;

        // Weighted Reel
        $weights = ['🍋'=>40, '🍒'=>30, '🍇'=>15, '💎'=>10, '7️⃣'=>5];
        $r1 = $this->spinReel($weights);
        $r2 = $this->spinReel($weights);
        $r3 = $this->spinReel($weights);

        $payout = 0;
        $type = 'loss';

        if ($r1 == $r2 && $r2 == $r3) {
            if ($r1 == '7️⃣') { $payout = $bet * 50; $type = 'jackpot'; }
            elseif ($r1 == '💎') { $payout = $bet * 25; $type = 'big'; }
            else { $payout = $bet * 10; $type = 'win'; }
        } elseif ($r1 == $r2 || $r2 == $r3 || $r1 == $r3) {
            $payout = $bet * 0.5; $type = 'small';
        }

        if ($payout > 0) $user->chips += $payout;
        $user->save();
        $this->saveHistory($user, "Slots: $r1 $r2 $r3", $bet, $payout);

        return back()->with('result', [
            'r1' => $r1, 'r2' => $r2, 'r3' => $r3, 'payout' => $payout, 'type' => $type
        ]);
    }

    private function spinReel($weights) {
        $rand = rand(1, array_sum($weights));
        foreach ($weights as $symbol => $weight) {
            $rand -= $weight;
            if ($rand <= 0) return $symbol;
        }
        return '🍋';
    }

    // ==========================================
    // 6. ROULETTE (Pro Logic)
    // ==========================================
    public function playRoulette(Request $request) {
        $user = Auth::user();
        $bet = $request->input('amount');
        if ($user->chips < $bet) return back()->with('error', 'Insufficient Funds');
        $user->chips -= $bet;

        $num = rand(0, 36);
        $color = ($num == 0) ? 'green' : (in_array($num, [1,3,5,7,9,12,14,16,18,19,21,23,25,27,30,32,34,36]) ? 'red' : 'black');
        
        $choice = $request->input('color');
        $payout = 0;

        if ($choice == $color) {
            $payout = ($color == 'green') ? $bet * 14 : $bet * 2;
        }

        if ($payout > 0) $user->chips += $payout;
        $user->save();

        // History Bar Logic
        $history = Session::get('roulette_history', []);
        array_unshift($history, ['num' => $num, 'color' => $color]);
        Session::put('roulette_history', array_slice($history, 0, 10));

        $this->saveHistory($user, "Roulette: $num", $bet, $payout);

        return back()->with('result', ['num' => $num, 'color' => $color, 'win' => $payout > 0, 'payout' => $payout]);
    }

    // Simple history helper (fails gracefully if Spin model is missing)
    private function saveHistory($user, $res, $bet, $win) {
        try {
            if (class_exists('App\Models\Spin')) {
                Spin::create(['user_id'=>$user->id, 'result'=>$res, 'bet'=>$bet, 'payout'=>$win]);
            }
        } catch (\Exception $e) {
            // Do nothing if database fails, just keep playing
        }
    }
}