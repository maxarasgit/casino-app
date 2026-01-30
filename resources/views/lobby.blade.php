<x-app-layout>
    <style>
        /* Dark Theme Background */
        .casino-lobby {
            background-color: #0f172a;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        /* Balance Display */
        .balance-box {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid #334155;
            padding: 15px 30px;
            border-radius: 50px;
            display: inline-block;
            margin-bottom: 30px;
            font-size: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        .gold { color: #fbbf24; font-weight: bold; }

        /* Daily Reward Button */
        .reward-area { margin-bottom: 50px; }
        .btn-claim {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white; border: none; padding: 15px 40px;
            border-radius: 12px; font-weight: bold; cursor: pointer;
            font-size: 1.1rem; box-shadow: 0 0 20px rgba(16, 185, 129, 0.4);
            animation: pulse 2s infinite; transition: 0.3s;
        }
        .btn-claim:hover { transform: scale(1.05); }
        .btn-wait {
            background: #1e293b; color: #94a3b8; border: 1px solid #334155;
            padding: 12px 24px; border-radius: 12px; cursor: not-allowed;
        }
        
        @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); } 70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); } 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); } }

        /* Game Grid Layout */
        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Game Cards */
        .game-card {
            background: rgba(30, 41, 59, 0.6);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(255,255,255,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            text-decoration: none;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .game-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        
        /* Card Colors */
        .card-bj { border-bottom: 5px solid #60a5fa; }
        .card-coin { border-bottom: 5px solid #f87171; }
        .card-slots { border-bottom: 5px solid #c084fc; }
        .card-roul { border-bottom: 5px solid #4ade80; }

        .game-icon { font-size: 4rem; margin-bottom: 10px; display: block; }
        .game-title { font-size: 1.5rem; font-weight: bold; margin: 10px 0; }
        .game-desc { font-size: 0.9rem; color: #94a3b8; }

        /* Exit Button */
        .exit-btn {
            margin-top: 60px;
            background: transparent; border: 1px solid #ef4444;
            color: #ef4444; padding: 10px 25px; border-radius: 8px;
            cursor: pointer; transition: 0.2s;
        }
        .exit-btn:hover { background: #ef4444; color: white; }
    </style>

    <div class="casino-lobby">
        
        <h1 style="font-size: 3rem; margin-bottom: 10px; text-shadow: 0 0 20px rgba(255,255,255,0.2);">
            🏰 CASINO ROYAL
        </h1>
        
        <div class="balance-box">
            Balance: <span class="gold">{{ number_format($user->chips) }} Chips</span>
        </div>

        <div class="reward-area">
            @if(Auth::user()->last_daily_reward && \Carbon\Carbon::parse(Auth::user()->last_daily_reward)->addHours(24)->isFuture())
                <button class="btn-wait" disabled>
                    ⏳ Next Reward: {{ \Carbon\Carbon::parse(Auth::user()->last_daily_reward)->addHours(24)->diffForHumans() }}
                </button>
            @else
                <form action="{{ route('daily.claim') }}" method="POST">
                    @csrf
                    <button class="btn-claim">🎁 CLAIM 500 FREE CHIPS</button>
                </form>
            @endif
        </div>

        <div class="games-grid">
            
            <a href="{{ route('view.blackjack') }}" class="game-card card-bj">
                <span class="game-icon">♠️</span>
                <div class="game-title">Blackjack 21</div>
                <div class="game-desc">Skill & Strategy</div>
            </a>

            <a href="{{ route('view.coin') }}" class="game-card card-coin">
                <span class="game-icon">🪙</span>
                <div class="game-title">Coin Flip</div>
                <div class="game-desc">Double or Nothing</div>
            </a>

            <a href="{{ route('view.slots') }}" class="game-card card-slots">
                <span class="game-icon">🎰</span>
                <div class="game-title">Cyber Slots</div>
                <div class="game-desc">Jackpot: 50x Bet</div>
            </a>

            <a href="{{ route('view.roulette') }}" class="game-card card-roul">
                <span class="game-icon">🎡</span>
                <div class="game-title">Roulette</div>
                <div class="game-desc">European Rules</div>
            </a>

        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="exit-btn">🚪 EXIT CASINO</button>
        </form>

    </div>
</x-app-layout>