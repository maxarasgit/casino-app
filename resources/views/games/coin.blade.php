<x-app-layout>
    <style>
        .coin-container {
            width: 200px; height: 200px;
            margin: 50px auto;
            perspective: 1000px;
        }
        .coin-3d {
            width: 100%; height: 100%;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 1s ease-in-out;
            animation: {{ session('result') ? 'flip 1s ease-out forwards' : 'float 3s infinite ease-in-out' }};
        }
        .face {
            position: absolute; width: 100%; height: 100%;
            border-radius: 50%;
            backface-visibility: hidden;
            display: flex; align-items: center; justify-content: center;
            font-size: 3rem; font-weight: bold;
            box-shadow: inset 0 0 20px rgba(0,0,0,0.5);
            border: 10px solid #d4af37; /* Gold rim */
        }
        .heads { background: radial-gradient(circle, #ffd700, #daa520); color: #8a6e05; }
        .tails { background: radial-gradient(circle, #c0c0c0, #a9a9a9); color: #505050; transform: rotateY(180deg); }

        @keyframes flip {
            0% { transform: rotateY(0); }
            100% { transform: rotateY({{ session('result') && session('result')['val'] == 'tails' ? '1980deg' : '1800deg' }}); } 
            /* 1800 = 5 full spins. 1980 = 5.5 spins (lands on tails) */
        }
        @keyframes float { 0% { transform: translateY(0); } 50% { transform: translateY(-20px); } 100% { transform: translateY(0); } }
    </style>

    <div style="padding: 40px; text-align: center;">
        <a href="{{ route('lobby') }}" class="nav-back">← LOBBY</a>
        
        <h1 class="text-glow" style="color: #fbbf24; font-size: 3rem; margin-bottom: 20px;">HIGH STAKES COIN</h1>
        
        <div class="coin-container">
            <div class="coin-3d">
                <div class="face heads">H</div>
                <div class="face tails">T</div>
            </div>
        </div>

        @if(session('result'))
            <h2 style="color: {{ session('result')['win'] ? '#4ade80' : '#f87171' }}; font-size: 2rem; margin: 30px 0;">
                {{ session('result')['win'] ? 'YOU WON!' : 'YOU LOST' }}
            </h2>
        @else
            <p style="color: #94a3b8; margin: 30px 0;">Select your side...</p>
        @endif

        <form action="{{ route('play.coin') }}" method="POST">
            @csrf
            <div style="margin-bottom: 30px;">
                <input type="number" name="bet" value="50" style="background: transparent; border: 1px solid #fbbf24; color: white; padding: 10px; width: 100px; text-align: center; border-radius: 5px;">
            </div>
            <div style="display: flex; justify-content: center; gap: 20px;">
                <button name="choice" value="heads" class="btn-neon" style="border-color: #fbbf24; color: #fbbf24;">HEADS</button>
                <button name="choice" value="tails" class="btn-neon" style="border-color: #9ca3af; color: #9ca3af;">TAILS</button>
            </div>
        </form>
    </div>
</x-app-layout>