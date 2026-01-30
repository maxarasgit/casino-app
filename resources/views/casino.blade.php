<x-app-layout>
    <style>
        .casino-body { background: #1a472a; color: white; text-align: center; padding: 40px 10px; min-height: 100vh; }
        .card { background: #0e2a18; border: 2px solid #ffd700; border-radius: 15px; padding: 30px; display: inline-block; min-width: 320px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .balance { font-size: 2.5em; color: #ffd700; margin: 15px 0; font-weight: bold; }
        .btn { background: #c0392b; color: white; border: none; padding: 15px 40px; font-size: 1.1em; border-radius: 50px; cursor: pointer; transition: 0.3s; font-weight: bold; }
        .btn:hover { background: #e74c3c; transform: scale(1.05); }
        .c-table { margin: 30px auto; width: 90%; max-width: 800px; border-collapse: collapse; background: rgba(0,0,0,0.3); }
        .c-table th { background: #0a2112; padding: 12px; color: #ffd700; }
        .c-table td { border-bottom: 1px solid #2d5a3c; padding: 10px; }
        .win { color: #2ecc71; font-weight: bold; }
        .loss { color: #e74c3c; }
    </style>

    <div class="casino-body">
        <div class="card">
            <h1 style="font-size: 1.5em;">🎰 {{ Auth::user()->name }}'s Casino</h1>
            <div class="balance">💰 {{ number_format($chips) }}</div>
            
            <form action="{{ route('flip') }}" method="GET">
                <button type="submit" class="btn">FLIP COIN (50)</button>
            </form>

            @if(session('message'))
                <p style="margin-top: 20px; color: #ffd700; font-weight: bold;">{{ session('message') }}</p>
            @endif
        </div>

        <div style="margin-top: 40px; display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;">
            <div>
                <h3>📜 Recent Activity</h3>
                <table class="c-table">
                    <tr><th>Result</th><th>Bet</th><th>Payout</th><th>When</th></tr>
                    @forelse($history as $spin)
                        <tr>
                            <td class="{{ $spin->payout > 0 ? 'win' : 'loss' }}">{{ $spin->result }}</td>
                            <td>{{ $spin->bet }}</td>
                            <td>{{ $spin->payout }}</td>
                            <td>{{ $spin->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4">No games yet!</td></tr>
                    @endforelse
                </table>
            </div>

            <div>
                <h3>🏆 Leaderboard</h3>
                <table class="c-table">
                    <tr><th>Player</th><th>Chips</th></tr>
                    @foreach($leaderboard as $player)
                        <tr style="{{ $player->id == Auth::id() ? 'background: rgba(255,215,0,0.1);' : '' }}">
                            <td>{{ $player->name }}</td>
                            <td style="color: #ffd700;">{{ number_format($player->chips) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</x-app-layout>