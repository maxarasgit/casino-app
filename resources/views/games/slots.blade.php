<x-app-layout>
    <style>
        .slot-machine-body {
            background: linear-gradient(to bottom, #2d3436, #000000);
            border: 5px solid #a855f7;
            border-radius: 20px;
            padding: 50px;
            display: inline-block;
            box-shadow: 0 0 50px rgba(168, 85, 247, 0.3);
            position: relative;
        }
        .reel-window {
            background: black;
            border: 2px solid #555;
            padding: 20px;
            border-radius: 10px;
            display: flex; gap: 10px;
            margin-bottom: 30px;
            box-shadow: inset 0 0 30px rgba(0,0,0,0.9);
        }
        .reel-box {
            width: 100px; height: 120px;
            background: white;
            border-radius: 5px;
            display: flex; align-items: center; justify-content: center;
            font-size: 4rem;
            /* Simulates curved glass reflection */
            background: linear-gradient(to bottom, #e2e8f0 0%, #fff 50%, #cbd5e1 100%);
        }
    </style>

    <div style="padding: 40px; text-align: center;">
        <a href="{{ route('lobby') }}" class="nav-back">← LOBBY</a>

        <div class="slot-machine-body">
            <h1 style="color: #a855f7; margin-bottom: 20px; font-family: 'Courier New', monospace; font-weight: bold; text-shadow: 0 0 10px #a855f7;">CYBER SLOTS 777</h1>

            <div class="reel-window">
                <div class="reel-box">{{ session('result') ? session('result')['r1'] : '7️⃣' }}</div>
                <div class="reel-box">{{ session('result') ? session('result')['r2'] : '7️⃣' }}</div>
                <div class="reel-box">{{ session('result') ? session('result')['r3'] : '7️⃣' }}</div>
            </div>

            @if(session('result'))
                <div style="color: {{ session('result')['payout'] > 0 ? '#4ade80' : '#ef4444' }} ; font-size: 1.5rem; font-weight: bold; margin-bottom: 20px;">
                    {{ session('result')['payout'] > 0 ? 'WINNER! +'.session('result')['payout'] : 'TRY AGAIN' }}
                </div>
            @endif

            <form action="{{ route('play.slots') }}" method="POST">
                @csrf
                <button class="btn-neon" style="border-color: #a855f7; color: #a855f7; width: 100%;">SPIN (100)</button>
            </form>
        </div>
    </div>
</x-app-layout>