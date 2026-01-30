<x-app-layout>
    <style>
        .lobby-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            padding: 20px;
        }

        /* The High-End Card Design */
        .elite-card {
            background: rgba(0, 0, 0, 0.4); /* Dark Glass */
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            text-decoration: none;
            color: #fff;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(5px);
        }

        /* The "Hover" Effect - This makes it feel alive */
        .elite-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--neon-gold);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5), 
                        0 0 20px rgba(255, 204, 0, 0.2); /* Gold Glow */
        }

        .icon-large { font-size: 4rem; margin-bottom: 15px; display: block; }
        .card-title { font-size: 1.5rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--neon-gold); }
        .card-desc { font-size: 0.9rem; color: #94a3b8; margin-top: 5px; }

        /* Balance Display */
        .chip-balance {
            background: linear-gradient(135deg, #fce38a 0%, #f38181 100%); /* Metallic Gold */
            color: #42200b;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: 900;
            font-size: 1.5rem;
            display: inline-block;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            margin-bottom: 30px;
        }
    </style>

    <div style="text-align: center; padding: 40px 20px;">
        
        <h1 class="text-glow" style="font-size: 3rem; margin-bottom: 20px; font-weight: 900;">ROYAL CASINO</h1>
        
        <div class="chip-balance">
            💰 {{ number_format($user->chips) }}
        </div>

        <div style="margin-bottom: 40px;">
            @if(Auth::user()->last_daily_reward && \Carbon\Carbon::parse(Auth::user()->last_daily_reward)->addHours(24)->isFuture())
                <button disabled style="background: rgba(255,255,255,0.1); color: #94a3b8; padding: 10px 25px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1);">
                    ⏳ Reward available in {{ \Carbon\Carbon::parse(Auth::user()->last_daily_reward)->addHours(24)->diffForHumans() }}
                </button>
            @else
                <form action="{{ route('daily.claim') }}" method="POST">
                    @csrf
                    <button class="btn-gold" style="animation: pulse 2s infinite;">
                        🎁 CLAIM 500 FREE CHIPS
                    </button>
                </form>
            @endif
        </div>

        <div class="game-table" style="max-width: 1200px; padding: 10px;">
            <div class="lobby-grid">
                
                <a href="{{ route('view.blackjack') }}" class="elite-card">
                    <span class="icon-large">♠️</span>
                    <div class="card-title">Blackjack</div>
                    <div class="card-desc">Beat the Dealer</div>
                </a>

                <a href="{{ route('view.coin') }}" class="elite-card">
                    <span class="icon-large">🪙</span>
                    <div class="card-title">Coin Flip</div>
                    <div class="card-desc">Double or Nothing</div>
                </a>

                <a href="{{ route('view.slots') }}" class="elite-card">
                    <span class="icon-large">🎰</span>
                    <div class="card-title">Slots</div>
                    <div class="card-desc">Jackpot 50x</div>
                </a>

                <a href="{{ route('view.roulette') }}" class="elite-card">
                    <span class="icon-large">🎡</span>
                    <div class="card-title">Roulette</div>
                    <div class="card-desc">European Rules</div>
                </a>

            </div>
        </div>

        <div style="margin-top: 50px;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button style="background: transparent; border: none; color: #ef4444; font-weight: bold; cursor: pointer; letter-spacing: 1px; opacity: 0.8;">
                    LOGOUT
                </button>
            </form>
        </div>

    </div>
</x-app-layout>