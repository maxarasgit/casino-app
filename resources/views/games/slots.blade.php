<x-app-layout>
    <style>
        /* Table-Matched Slot Machine */
        .slot-body {
            /* Matches your Green Felt radial gradient */
            background: radial-gradient(circle at center, #0e5c35 0%, #0b4628 100%);
            /* Matches your Wood border */
            border: 10px solid #2d1b0e;
            border-bottom-width: 18px; /* Adds 3D depth to the bottom */
            border-radius: 40px;
            padding: 40px 20px;
            display: inline-block;
            max-width: 450px; /* Slimmed down to match the Coin Flip look */
            width: 90%;
            box-shadow: inset 0 0 60px rgba(0,0,0,0.7), 0 20px 50px rgba(0,0,0,0.6);
            position: relative;
            box-sizing: border-box;
        }

        /* Screen Area for the Reels */
        .reel-container {
            background: #000;
            padding: 15px;
            border-radius: 15px;
            border: 4px solid #1a0f08; /* Darker wood/metal finish */
            display: flex; 
            gap: 12px;
            margin-bottom: 25px;
            box-shadow: inset 0 0 30px rgba(0,0,0,1), 0 5px 15px rgba(0,0,0,0.5);
        }

        .reel {
            flex: 1;
            aspect-ratio: 3/4;
            /* Metallic/Glass reflection effect */
            background: linear-gradient(to bottom, #d1d5db 0%, #ffffff 50%, #9ca3af 100%);
            border-radius: 8px;
            display: flex; 
            align-items: center; 
            justify-content: center;
            font-size: 3.5rem;
            color: #000;
            border: 1px solid #4b5563;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        /* Glassmorphism Win Display */
        .win-display {
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(5px);
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 25px;
            min-height: 60px;
            display: flex; 
            align-items: center; 
            justify-content: center;
            border: 1px solid rgba(255,255,255,0.1);
        }

        /* Gold Action Button */
        .spin-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
            border: none;
            color: #42200b;
            font-weight: 900;
            font-size: 1.4rem;
            border-radius: 15px;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 2px;
            box-shadow: 0 6px 0 #78350f, 0 10px 20px rgba(0,0,0,0.4);
            transition: 0.1s;
        }

        .spin-btn:hover {
            filter: brightness(1.1);
        }

        .spin-btn:active {
            transform: translateY(4px);
            box-shadow: 0 2px 0 #78350f;
        }

        @media (max-width: 600px) {
            .slot-body { padding: 30px 15px; border-width: 8px; border-radius: 30px; }
            .reel-container { padding: 10px; gap: 8px; }
            .reel { font-size: 2.5rem; }
            .spin-btn { font-size: 1.1rem; padding: 15px; }
        }
    </style>

    <div style="padding: 20px 10px; text-align: center;">
        <a href="{{ route('lobby') }}" class="nav-back">← LEAVE MACHINE</a>
        <br><br>

        <div class="slot-body">
            <h1 class="text-glow" style="color: #fbbf24; margin: 0 0 5px 0; font-weight: 900; letter-spacing: 2px;">
                GOLDEN SLOTS
            </h1>
            <p style="color: #86efac; font-size: 0.7rem; letter-spacing: 3px; margin-bottom: 20px; opacity: 0.8; text-transform: uppercase;">
                Cyber-Mechanical 777
            </p>

            <div class="reel-container">
                <div class="reel">{{ session('result') ? session('result')['r1'] : '🎰' }}</div>
                <div class="reel">{{ session('result') ? session('result')['r2'] : '🎰' }}</div>
                <div class="reel">{{ session('result') ? session('result')['r3'] : '🎰' }}</div>
            </div>

            <div class="win-display">
                @if(session('result'))
                    <div style="text-align: center; animation: fadeIn 0.4s;">
                        <div style="color: {{ session('result')['payout'] > 0 ? '#4ade80' : '#f87171' }}; font-weight: 900; font-size: 1.4rem;">
                            {{ session('result')['payout'] > 0 ? 'JACKPOT! +' . session('result')['payout'] : 'BUSTED' }}
                        </div>
                    </div>
                @else
                    <div style="color: rgba(255,255,255,0.5); font-weight: bold; letter-spacing: 1px;">INSERT COINS</div>
                @endif
            </div>

            <form action="{{ route('play.slots') }}" method="POST">
                @csrf
                <button class="spin-btn">SPIN WHEEL</button>
            </form>
        </div>
    </div>
</x-app-layout>