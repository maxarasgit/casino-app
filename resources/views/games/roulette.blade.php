<x-app-layout>
    <style>
        /* === TABLE & ATMOSPHERE === */
        .game-container { padding: 40px 10px; text-align: center; min-height: 100vh; }
        
        .game-table {
            background: radial-gradient(circle at center, #0e5c35 0%, #0b4628 100%);
            border: 15px solid #2d1b0e;
            border-bottom: 25px solid #1a0f08;
            border-radius: 60px;
            box-shadow: inset 0 0 100px rgba(0,0,0,0.8), 0 30px 60px rgba(0,0,0,0.7);
            padding: 40px 20px;
            max-width: 900px;
            width: 95%;
            margin: 20px auto;
            position: relative;
        }

        /* === THE WHEEL === */
        .wheel-container {
            width: clamp(280px, 85vw, 360px);
            height: clamp(280px, 85vw, 360px);
            margin: 0 auto 40px;
            position: relative;
            border-radius: 50%;
            border: 12px solid #1a0f08;
            box-shadow: 0 15px 40px rgba(0,0,0,0.8);
            background: #111;
            overflow: hidden;
        }

        .wheel {
            width: 100%; height: 100%;
            border-radius: 50%;
            position: relative;
            /* Smooth physics-based transition */
            transition: transform 5s cubic-bezier(0.15, 0, 0.15, 1);
            background: conic-gradient(
                #22c55e 0deg 9.7deg, #ef4444 9.7deg 19.4deg, #111 19.4deg 29.1deg, #ef4444 29.1deg 38.8deg,
                #111 38.8deg 48.5deg, #ef4444 48.5deg 58.2deg, #111 58.2deg 67.9deg, #ef4444 67.9deg 77.6deg,
                #111 77.6deg 87.3deg, #ef4444 87.3deg 97deg, #111 97deg 106.7deg, #ef4444 106.7deg 116.4deg,
                #111 116.4deg 126.1deg, #ef4444 126.1deg 135.8deg, #111 135.8deg 145.5deg, #ef4444 145.5deg 155.2deg,
                #111 155.2deg 164.9deg, #ef4444 164.9deg 174.6deg, #111 174.6deg 184.3deg, #ef4444 184.3deg 194deg,
                #111 194deg 203.7deg, #ef4444 203.7deg 213.4deg, #111 213.4deg 223.1deg, #ef4444 223.1deg 232.8deg,
                #111 232.8deg 242.5deg, #ef4444 242.5deg 252.2deg, #111 252.2deg 261.9deg, #ef4444 261.9deg 271.6deg,
                #111 271.6deg 281.3deg, #ef4444 281.3deg 291deg, #111 291deg 300.7deg, #ef4444 300.7deg 310.4deg,
                #111 310.4deg 320.1deg, #ef4444 320.1deg 329.8deg, #111 329.8deg 339.5deg, #ef4444 339.5deg 349.2deg,
                #111 349.2deg 360deg
            );
        }

        .wheel-number {
            position: absolute; width: 100%; height: 100%;
            text-align: center; color: white; font-weight: 900; font-size: 0.75rem;
            padding-top: 8px; box-sizing: border-box;
        }

        .ball-pointer {
            position: absolute; top: 10px; left: 50%; transform: translateX(-50%);
            width: 14px; height: 14px; background: radial-gradient(circle at 30% 30%, #fff, #ccc);
            border-radius: 50%; box-shadow: 0 2px 10px rgba(0,0,0,0.8); z-index: 25;
        }

        .wood-center {
            position: absolute; top: 32%; left: 32%; width: 36%; height: 36%;
            background: radial-gradient(circle, #4a301d, #1a0f08);
            border-radius: 50%; border: 4px solid #d4af37; z-index: 10;
            display: flex; align-items: center; justify-content: center;
        }

        /* === UI & RESULTS === */
        .bet-input-alt {
            background: rgba(0,0,0,0.6); border: 2px solid #fbbf24; color: #fff;
            padding: 12px; width: 120px; text-align: center; border-radius: 10px;
            font-weight: 900; font-size: 1.2rem; outline: none;
        }

        .betting-layout {
            display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;
            max-width: 450px; margin: 25px auto 0;
        }

        .bet-spot {
            background: rgba(0,0,0,0.3); border: 2px solid rgba(255,255,255,0.1);
            border-radius: 12px; padding: 20px 10px; cursor: pointer;
            transition: 0.2s; text-decoration: none;
        }
        .bet-spot:hover { border-color: #fbbf24; background: rgba(0,0,0,0.5); }

        .label { display: block; font-weight: 900; color: #fff; font-size: 1rem; }
        .odds { font-size: 0.7rem; color: #fbbf24; }

        .result-overlay {
            opacity: 0; animation: fadeIn 0.5s forwards 4.8s;
            margin-bottom: 20px;
        }
        @keyframes fadeIn { to { opacity: 1; } }
    </style>

    <div class="game-container">
        <a href="{{ route('lobby') }}" style="color: #94a3b8; text-decoration: none; font-size: 0.8rem;">← LOBBY</a>

        <div class="game-table">
            <h1 style="color: #fbbf24; font-size: 2.8rem; font-weight: 900; margin-bottom: 30px;">ROYAL ROULETTE</h1>

            <div class="wheel-container">
                <div class="ball-pointer"></div>
                
                @php
                    // European sequence
                    $euroNumbers = [0, 32, 15, 19, 4, 21, 2, 25, 17, 34, 6, 27, 13, 36, 11, 30, 8, 23, 10, 5, 24, 16, 33, 1, 20, 14, 31, 9, 22, 18, 29, 7, 28, 12, 35, 3, 26];
                    
                    // Logic to find result and calculate spin
                    $resultIndex = session('result') ? array_search(session('result')['num'], $euroNumbers) : 0;
                    
                    // We add 2520 degrees (7 full laps) to the index rotation to ensure it always spins forward
                    $rotation = session('result') ? (2520 - ($resultIndex * (360/37))) : 0;
                @endphp

                <div class="wheel" style="transform: rotate({{ $rotation }}deg);">
                    @foreach($euroNumbers as $index => $num)
                        <div class="wheel-number" style="transform: rotate({{ $index * (360/37) }}deg)">
                            {{ $num }}
                        </div>
                    @endforeach
                </div>
                
                <div class="wood-center">
                    <span style="color: #fbbf24; font-weight: 900; font-size: 1.5rem;">
                        {{ session('result') ? session('result')['num'] : '?' }}
                    </span>
                </div>
            </div>

            @if(session('result'))
                <div class="result-overlay">
                    <h2 style="color: {{ session('result')['win'] ? '#fbbf24' : '#94a3b8' }}; font-size: 1.8rem; font-weight: 900;">
                        {{ session('result')['win'] ? '✨ YOU WON! ✨' : 'BET LOST' }}
                    </h2>
                </div>
            @endif

            <form action="{{ route('play.roulette') }}" method="POST">
                @csrf
                <input type="number" name="amount" value="100" min="10" class="bet-input-alt">
                
                <div class="betting-layout">
                    <button name="color" value="green" class="bet-spot" style="grid-column: span 2; border-color: #22c55e;">
                        <span class="label" style="color: #22c55e;">ZERO</span>
                        <span class="odds">14:1 PAYOUT</span>
                    </button>
                    <button name="color" value="red" class="bet-spot" style="border-color: #ef4444;">
                        <span class="label" style="color: #ef4444;">RED</span>
                        <span class="odds">2:1 PAYOUT</span>
                    </button>
                    <button name="color" value="black" class="bet-spot" style="border-color: #475569;">
                        <span class="label" style="color: #fff;">BLACK</span>
                        <span class="odds">2:1 PAYOUT</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>