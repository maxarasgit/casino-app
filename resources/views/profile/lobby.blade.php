<x-app-layout>
    <div style="background: #1a472a; min-height: 100vh; padding: 50px; text-align: center; color: white;">
        <h1 style="font-size: 3em; margin-bottom: 10px;">🏰 Casino Lobby</h1>
        <p style="font-size: 1.5em; color: #ffd700;">Balance: 💰 {{ number_format($user->chips) }}</p>

        <div style="display: flex; justify-content: center; gap: 30px; margin-top: 50px; flex-wrap: wrap;">
            <a href="{{ route('view.coin') }}" style="text-decoration: none;">
                <div style="background: #e74c3c; width: 250px; padding: 30px; border-radius: 15px; border: 4px solid #c0392b; box-shadow: 0 10px 20px rgba(0,0,0,0.5); transition: 0.3s;">
                    <div style="font-size: 4em;">🪙</div>
                    <h2 style="color: white; margin: 10px 0;">Coin Flip</h2>
                    <p style="color: #ffd700;">Win 2x</p>
                </div>
            </a>

            <a href="{{ route('view.slots') }}" style="text-decoration: none;">
                <div style="background: #8e44ad; width: 250px; padding: 30px; border-radius: 15px; border: 4px solid #732d91; box-shadow: 0 10px 20px rgba(0,0,0,0.5); transition: 0.3s;">
                    <div style="font-size: 4em;">🎰</div>
                    <h2 style="color: white; margin: 10px 0;">Slots</h2>
                    <p style="color: #ffd700;">Win 10x</p>
                </div>
            </a>

            <a href="{{ route('view.roulette') }}" style="text-decoration: none;">
                <div style="background: #27ae60; width: 250px; padding: 30px; border-radius: 15px; border: 4px solid #1e8449; box-shadow: 0 10px 20px rgba(0,0,0,0.5); transition: 0.3s;">
                    <div style="font-size: 4em;">🎡</div>
                    <h2 style="color: white; margin: 10px 0;">Roulette</h2>
                    <p style="color: #ffd700;">Win 14x</p>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>