<x-app-layout>
    <style>
        /* Focused Game Container */
        .coin-box {
            background: radial-gradient(circle at center, #0e5c35 0%, #0b4628 100%);
            border: 8px solid #2d1b0e;
            border-radius: 40px;
            box-shadow: inset 0 0 80px rgba(0,0,0,0.6), 0 20px 50px rgba(0,0,0,0.8);
            padding: 40px 20px;
            max-width: 450px; /* Reduced width for a tighter look */
            width: 90%; 
            margin: 40px auto;
            text-align: center;
            position: relative;
        }

        .coin-scene {
            width: 150px; height: 150px;
            margin: 30px auto;
            perspective: 1000px;
        }

        .coin-body {
            width: 100%; height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 1s ease-in-out;
            animation: {{ session('result') ? 'none' : 'coin-float 3s infinite ease-in-out' }};
        }

        .coin-side {
            position: absolute; width: 100%; height: 100%;
            border-radius: 50%;
            backface-visibility: hidden;
            display: flex; align-items: center; justify-content: center;
            font-size: 3.5rem; font-weight: 900;
            border: 6px solid #b8860b;
        }

        .side-heads { background: radial-gradient(circle, #fcd34d, #d97706); color: #78350f; }
        .side-tails { background: radial-gradient(circle, #e2e8f0, #94a3b8); color: #334155; transform: rotateY(180deg); }

        @keyframes coin-float {
            0%, 100% { transform: translateY(0) rotateY(0deg); }
            50% { transform: translateY(-15px) rotateY(15deg); }
        }

        .coin-result-anim {
            animation: flip-result 1.2s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        @keyframes flip-result {
            0% { transform: rotateY(0) scale(1); }
            50% { transform: rotateY(900deg) scale(1.3); }
            100% { transform: rotateY({{ session('result') && session('result')['val'] == 'tails' ? '1980deg' : '1800deg' }}) scale(1); }
        }

        /* Betting Controls */
        .bet-input-alt {
            background: rgba(0,0,0,0.5);
            border: 2px solid #fbbf24;
            color: white;
            padding: 12px;
            width: 100px;
            text-align: center;
            border-radius: 12px;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .btn-group {
            display: flex; gap: 15px; justify-content: center;
        }

        .btn-coin {
            flex: 1;
            padding: 15px;
            border-radius: 12px;
            border: none;
            font-weight: 900;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.2s;
        }
        .btn-heads { background: #fbbf24; color: #42200b; }
        .btn-tails { background: #94a3b8; color: #1e293b; }
        .btn-coin:hover { filter: brightness(1.1); transform: translateY(-2px); }

        @media (max-width: 480px) {
            .coin-box { padding: 30px 15px; }
            .coin-scene { width: 120px; height: 120px; }
        }
    </style>

    <div style="padding: 20px 10px; text-align: center;">
        <a href="{{ route('lobby') }}" class="nav-back">← BACK TO LOBBY</a>

        <div class="coin-box">
            <h1 class="text-glow" style="color: #fbbf24; margin: 0; font-size: 2rem;">COIN FLIP</h1>
            <p style="color: #86efac; font-size: 0.8rem; letter-spacing: 1px; margin-bottom: 10px;">PROBABLY FAIR</p>
            
            <div class="coin-scene">
                <div class="coin-body {{ session('result') ? 'coin-result-anim' : '' }}">
                    <div class="coin-side side-heads">H</div>
                    <div class="coin-side side-tails">T</div>
                </div>
            </div>

            @if(session('result'))
                <div style="margin: 20px 0; animation: fadeIn 0.5s;">
                    <h2 style="color: {{ session('result')['win'] ? '#4ade80' : '#f87171' }}; margin: 0;">
                        {{ session('result')['win'] ? 'WINNER!' : 'LOST' }}
                    </h2>
                    <p style="color: rgba(255,255,255,0.6); margin-top: 5px;">Landed on {{ strtoupper(session('result')['val']) }}</p>
                </div>
            @endif

            <form action="{{ route('play.coin') }}" method="POST">
                @csrf
                <input type="number" name="bet" value="50" class="bet-input-alt">
                
                <div class="btn-group">
                    <button name="choice" value="heads" class="btn-coin btn-heads">HEADS</button>
                    <button name="choice" value="tails" class="btn-coin btn-tails">TAILS</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>