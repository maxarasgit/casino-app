<x-app-layout>
    <div style="padding: 40px; text-align: center;">
        <a href="{{ route('lobby') }}" class="nav-back">← LEAVE TABLE</a>

        <div class="game-table">
            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0.1; color: white; font-size: 5rem; font-weight: bold; pointer-events: none;">
                BLACKJACK
            </div>

            @if($game && isset($game['status']))
                
                <div style="margin-bottom: 40px;">
                    <div style="color: #86efac; font-size: 0.9rem; margin-bottom: 10px; letter-spacing: 1px;">DEALER</div>
                    <div style="display: flex; justify-content: center; height: 150px;">
                        @foreach($game['dealer_hand'] as $index => $card)
                            @if($index == 0 && $game['status'] == 'playing')
                                <div class="playing-card" style="background: repeating-linear-gradient(45deg, #ef4444, #ef4444 10px, #b91c1c 10px, #b91c1c 20px); border: 3px solid white;"></div>
                            @else
                                <div class="playing-card {{ in_array($card['s'], ['♥','♦']) ? 'card-red' : 'card-black' }}">
                                    <div class="card-rank">{{ $card['v'] }}</div>
                                    <div class="card-suit">{{ $card['s'] }}</div>
                                    <div class="card-rank" style="bottom: 5px; right: 8px; top: auto; left: auto; transform: rotate(180deg);">{{ $card['v'] }}</div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div style="min-height: 50px; margin: 20px 0;">
                    <span style="background: rgba(0,0,0,0.6); color: white; padding: 10px 30px; border-radius: 20px; font-weight: bold; font-size: 1.2rem; border: 1px solid rgba(255,255,255,0.2);">
                        {{ $game['message'] }}
                    </span>
                </div>

                <div>
                    <div style="display: flex; justify-content: center; height: 150px;">
                        @foreach($game['player_hand'] as $card)
                            <div class="playing-card {{ in_array($card['s'], ['♥','♦']) ? 'card-red' : 'card-black' }}">
                                <div class="card-rank">{{ $card['v'] }}</div>
                                <div class="card-suit">{{ $card['s'] }}</div>
                                <div class="card-rank" style="bottom: 5px; right: 8px; top: auto; left: auto; transform: rotate(180deg);">{{ $card['v'] }}</div>
                            </div>
                        @endforeach
                    </div>
                    <div style="color: #fca5a5; font-size: 0.9rem; margin-top: 10px; letter-spacing: 1px;">YOU</div>
                </div>

                <div style="margin-top: 40px; display: flex; justify-content: center; gap: 20px;">
                    <form action="{{ route('play.blackjack') }}" method="POST">
                        @csrf
                        @if($game['status'] == 'playing')
                            <button name="action" value="hit" class="btn-neon" style="border-color: #4ade80; color: #4ade80;">HIT</button>
                            <button name="action" value="stand" class="btn-neon" style="border-color: #ef4444; color: #ef4444;">STAND</button>
                        @else
                            <div style="margin-bottom: 20px;">
                                <input type="number" name="bet" value="50" style="background: rgba(0,0,0,0.5); border: 1px solid white; color: white; padding: 10px; border-radius: 5px; text-align: center; width: 100px;">
                            </div>
                            <button name="action" value="deal" class="btn-neon">DEAL NEW HAND</button>
                        @endif
                    </form>
                </div>

            @else
                <div style="padding-top: 150px;">
                    <h1 class="text-glow" style="color: white; font-size: 3rem;">VIP BLACKJACK</h1>
                    <form action="{{ route('play.blackjack') }}" method="POST">
                        @csrf
                        <button name="action" value="deal" class="btn-neon" style="margin-top: 20px;">SIT AT TABLE</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>