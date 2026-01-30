<x-app-layout>
    <style>
        /* === DYNAMIC LAYOUT === */
        .bj-container {
            padding: 20px 10px;
            text-align: center;
            min-height: 100vh;
        }

        .bj-table {
            background: radial-gradient(circle at center, #0e5c35 0%, #0b4628 100%);
            border: 12px solid #2d1b0e;
            border-radius: 40px;
            box-shadow: inset 0 0 80px rgba(0,0,0,0.6), 0 20px 40px rgba(0,0,0,0.5);
            padding: 40px 10px;
            max-width: 800px;
            width: 95%;
            margin: 20px auto;
            position: relative;
            min-height: 480px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-sizing: border-box;
        }

        /* === RESPONSIVE CARDS === */
        .hand-container {
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
            min-height: 130px;
            align-items: center;
        }

        .bj-card {
            width: 85px;
            height: 125px;
            background: #fff;
            border-radius: 8px;
            position: relative;
            box-shadow: -3px 3px 10px rgba(0,0,0,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s ease;
            user-select: none;
        }

        .bj-card:hover { transform: translateY(-10px) rotate(2deg); z-index: 5; }

        .card-corner { 
            position: absolute; top: 5px; left: 8px; 
            font-size: 1.1rem; font-weight: 900; line-height: 1; 
        }
        .card-center { font-size: 2.8rem; }
        .suit-red { color: #e11d48; }
        .suit-black { color: #0f172a; }

        .card-back {
            background: repeating-linear-gradient(45deg, #b91c1c, #b91c1c 10px, #991b1b 10px, #991b1b 20px);
            border: 4px solid #fff;
        }

        /* === UI ELEMENTS === */
        .status-pill {
            background: rgba(0,0,0,0.7);
            color: #fbbf24;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 900;
            border: 1px solid rgba(255,255,255,0.2);
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
        }

        .bet-input-glass {
            background: rgba(0, 0, 0, 0.5);
            border: 2px solid #fbbf24;
            color: #fff;
            padding: 12px;
            width: 90px;
            text-align: center;
            border-radius: 10px;
            font-size: 1.2rem;
            font-weight: bold;
            outline: none;
            transition: 0.3s;
        }
        .bet-input-glass:focus { box-shadow: 0 0 15px rgba(251, 191, 36, 0.5); }

        /* === BUTTONS === */
        .btn-action {
            padding: 14px 28px;
            border-radius: 10px;
            font-weight: 900;
            border: none;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.2s;
            min-width: 110px;
        }

        .btn-hit { background: #10b981; color: #fff; box-shadow: 0 4px 0 #065f46; }
        .btn-stand { background: #ef4444; color: #fff; box-shadow: 0 4px 0 #991b1b; }
        .btn-deal { background: #fbbf24; color: #42200b; box-shadow: 0 4px 0 #b45309; }

        .btn-action:active { transform: translateY(3px); box-shadow: none; }

        /* === MOBILE OVERRIDES === */
        @media (max-width: 600px) {
            .bj-table { padding: 25px 5px; border-width: 8px; border-radius: 25px; min-height: 400px; }
            .bj-card { width: 58px; height: 85px; border-radius: 5px; }
            .card-corner { font-size: 0.8rem; }
            .card-center { font-size: 1.6rem; }
            .btn-action { padding: 12px 18px; min-width: 90px; font-size: 0.85rem; }
            .bet-input-glass { width: 70px; padding: 8px; font-size: 1rem; }
        }
    </style>

    <div class="bj-container">
        <a href="{{ route('lobby') }}" style="color: #94a3b8; text-decoration: none; font-weight: bold; font-size: 0.9rem;">
            ← BACK TO LOBBY
        </a>

        <div class="bj-table">
            
            <div class="dealer-area">
                <div style="color: #86efac; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 8px; opacity: 0.8;">Dealer</div>
                <div class="hand-container">
                    @if($game && isset($game['dealer_hand']))
                        @foreach($game['dealer_hand'] as $index => $card)
                            @if($index == 0 && $game['status'] == 'playing')
                                <div class="bj-card card-back"></div>
                            @else
                                <div class="bj-card {{ in_array($card['s'], ['♥','♦']) ? 'suit-red' : 'suit-black' }}">
                                    <div class="card-corner">{{ $card['v'] }}</div>
                                    <div class="card-center">{{ $card['s'] }}</div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div style="color: rgba(255,255,255,0.1); font-size: 4rem;">♠</div>
                    @endif
                </div>
            </div>

            <div class="status-area">
                @if($game && isset($game['message']))
                    <div class="status-pill">{{ $game['message'] }}</div>
                @else
                    <div style="color: rgba(255,255,255,0.2); font-weight: bold; letter-spacing: 2px;">PLACE YOUR BET</div>
                @endif
            </div>

            <div class="player-area">
                <div class="hand-container">
                    @if($game && isset($game['player_hand']))
                        @foreach($game['player_hand'] as $card)
                            <div class="bj-card {{ in_array($card['s'], ['♥','♦']) ? 'suit-red' : 'suit-black' }}">
                                <div class="card-corner">{{ $card['v'] }}</div>
                                <div class="card-center">{{ $card['s'] }}</div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div style="color: #fca5a5; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 2px; margin-top: 8px; opacity: 0.8;">You</div>
            </div>

            <div class="controls-area">
                <form action="{{ route('play.blackjack') }}" method="POST" style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; align-items: center;">
                    @csrf
                    @if($game && $game['status'] == 'playing')
                        <button name="action" value="hit" class="btn-action btn-hit">HIT</button>
                        <button name="action" value="stand" class="btn-action btn-stand">STAND</button>
                    @else
                        <input type="number" name="bet" value="50" min="10" class="bet-input-glass">
                        <button name="action" value="deal" class="btn-action btn-deal">DEAL HAND</button>
                    @endif
                </form>
            </div>
            
        </div>
    </div>
</x-app-layout>