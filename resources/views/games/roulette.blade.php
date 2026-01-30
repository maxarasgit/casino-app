<x-app-layout>
    <style>
        /* === THE WHEEL === */
        .wheel-container {
            width: 300px; height: 300px;
            margin: 0 auto 40px;
            position: relative;
            border-radius: 50%;
            border: 10px solid #573a27; /* Wood rim */
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            background: #222;
            overflow: hidden;
        }

        .wheel {
            width: 100%; height: 100%;
            border-radius: 50%;
            /* Creating the sectors using a conic gradient */
            background: conic-gradient(
                #22c55e 0deg 9.7deg,   /* 0 Green */
                #ef4444 9.7deg 19.4deg, /* Red */
                #111 19.4deg 29.1deg,   /* Black */
                #ef4444 29.1deg 38.8deg,
                #111 38.8deg 48.5deg,
                #ef4444 48.5deg 58.2deg,
                #111 58.2deg 67.9deg,
                #ef4444 67.9deg 77.6deg,
                #111 77.6deg 87.3deg,
                #ef4444 87.3deg 97deg,
                #111 97deg 106.7deg,
                #ef4444 106.7deg 116.4deg,
                #111 116.4deg 126.1deg,
                #ef4444 126.1deg 135.8deg,
                #111 135.8deg 145.5deg,
                #ef4444 145.5deg 155.2deg,
                #111 155.2deg 164.9deg,
                #ef4444 164.9deg 174.6deg,
                #111 174.6deg 184.3deg,
                #ef4444 184.3deg 194deg,
                #111 194deg 203.7deg,
                #ef4444 203.7deg 213.4deg,
                #111 213.4deg 223.1deg,
                #ef4444 223.1deg 232.8deg,
                #111 232.8deg 242.5deg,
                #ef4444 242.5deg 252.2deg,
                #111 252.2deg 261.9deg,
                #ef4444 261.9deg 271.6deg,
                #111 271.6deg 281.3deg,
                #ef4444 281.3deg 291deg,
                #111 291deg 300.7deg,
                #ef4444 300.7deg 310.4deg,
                #111 310.4deg 320.1deg,
                #ef4444 320.1deg 329.8deg,
                #111 329.8deg 339.5deg,
                #ef4444 339.5deg 349.2deg,
                #111 349.2deg 360deg
            );
            animation: {{ session('result') ? 'spinWheel 3s ease-out forwards' : 'rotateSlow 20s linear infinite' }};
        }

        .inner-rim {
            position: absolute; top: 20%; left: 20%; width: 60%; height: 60%;
            background: transparent; border: 2px solid rgba(255,255,255,0.2);
            border-radius: 50%;
        }

        .center-knob {
            position: absolute; top: 40%; left: 40%; width: 20%; height: 20%;
            background: radial-gradient(#d4af37, #8a6e05);
            border-radius: 50%;
            box-shadow: 0 0 10px black;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold; color: #42200b;
        }

        .ball {
            position: absolute; top: 0; left: 50%;
            width: 12px; height: 12px;
            background: white; border-radius: 50%;
            box-shadow: 0 0 5px white;
            transform-origin: 0 150px; /* Pivots around center of wheel */
            animation: {{ session('result') ? 'spinBall 3s ease-out forwards' : 'none' }};
        }

        /* === ANIMATIONS === */
        @keyframes rotateSlow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes spinWheel { 0% { transform: rotate(0); } 100% { transform: rotate(1080deg); } }
        @keyframes spinBall { 0% { transform: rotate(0); } 100% { transform: rotate(-1000deg); } }

        /* === BETTING BOARD === */
        .bet-board {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
            max-width: 500px;
            margin: 0 auto;
            background: rgba(0,0,0,0.3);
            padding: 20px;
            border-radius: 10px;
            border: 2px solid rgba(255,255,255,0.1);
        }

        .bet-spot {
            height: 100px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 5px;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            cursor: pointer; transition: 0.2s;
            position: relative;
        }
        .bet-spot:hover { background: rgba(255,255,255,0.1); border-color: white; transform: scale(1.05); }
        .spot-red { color: #ef4444; }
        .spot-black { color: #cbd5e1; }
        .spot-green { color: #22c55e; grid-column: span 3; height: 60px; }
        
        .chip-marker {
            width: 40px; height: 40px; border-radius: 50%;
            border: 4px dashed white;
            display: flex; align-items: center; justify-content: center;
            font-weight: bold; font-size: 0.8rem;
            box-shadow: 0 3px 5px rgba(0,0,0,0.5);
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            margin-bottom: 5px;
        }

    </style>

    <div style="padding: 40px; text-align: center;">
        <a href="{{ route('lobby') }}" class="nav-back">← LOBBY</a>
        
        <div class="game-table">
            
            <div style="margin-bottom: 20px;">
                <h1 class="text-glow" style="color: #fbbf24; font-size: 2.5rem; margin: 0;">ROYAL ROULETTE</h1>
                <p style="color: #94a3b8;">History: 
                    @if(Session::has('roulette_history'))
                        @foreach(Session::get('roulette_history') as $h)
                            <span style="color: {{ $h['color'] == 'red' ? '#ef4444' : ($h['color'] == 'green' ? '#22c55e' : 'white') }}">
                                {{ $h['num'] }}
                            </span>
                        @endforeach
                    @else
                        -
                    @endif
                </p>
            </div>

            <div class="wheel-container">
                <div class="wheel"></div>
                <div class="inner-rim"></div>
                <div class="center-knob">ROYAL</div>
                <div class="ball"></div>
            </div>

            @if(session('result'))
                <div style="margin-bottom: 30px;">
                    <div style="font-size: 3rem; font-weight: bold; color: {{ session('result')['color'] == 'red' ? '#ef4444' : (session('result')['color'] == 'green' ? '#22c55e' : 'white') }}">
                        {{ session('result')['num'] }} {{ strtoupper(session('result')['color']) }}
                    </div>
                    @if(session('result')['win'])
                        <div class="text-glow" style="color: #fbbf24; font-size: 1.5rem;">YOU WON {{ session('result')['payout'] }} CHIPS!</div>
                    @else
                        <div style="color: #94a3b8;">Try again...</div>
                    @endif
                </div>
            @endif

            <form action="{{ route('play.roulette') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 20px;">
                    <input type="number" name="amount" value="100" style="background: rgba(0,0,0,0.5); border: 1px solid white; color: white; padding: 10px; width: 100px; text-align: center; border-radius: 5px;">
                </div>

                <div class="bet-board">
                    <button name="color" value="green" class="bet-spot spot-green">
                        <div class="chip-marker" style="background: #22c55e;">0</div>
                        <span>ZERO (14x)</span>
                    </button>

                    <button name="color" value="red" class="bet-spot spot-red">
                        <div class="chip-marker" style="background: #ef4444;"></div>
                        <span>RED (2x)</span>
                    </button>

                    <button name="color" value="black" class="bet-spot spot-black">
                        <div class="chip-marker" style="background: #1e293b;"></div>
                        <span>BLACK (2x)</span>
                    </button>

                    <div style="grid-column: span 3; color: rgba(255,255,255,0.3); font-size: 0.8rem; margin-top: 10px;">
                        Specific Number betting coming soon...
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>