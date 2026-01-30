<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
    /* === CASINO GRAPHICS ENGINE (DESKTOP DEFAULT) === */
    :root {
        --felt-green: #0b4628;
        --felt-gradient: radial-gradient(circle, #0e5c35 0%, #0b4628 60%, #041f11 100%);
        --neon-blue: #00f2ff;
        --card-shadow: 0 5px 15px rgba(0,0,0,0.5);
    }

    body {
        background-color: #0f172a !important;
        font-family: 'Inter', system-ui, sans-serif;
        color: white;
        margin: 0; padding: 0; overflow-x: hidden; /* Prevent horizontal scroll */
    }

    /* THE TABLE (Responsive) */
    .game-table {
        background: var(--felt-gradient);
        border: 15px solid #2d1b0e;
        border-radius: 30px; /* Reduced radius for mobile */
        box-shadow: inset 0 0 50px rgba(0,0,0,0.8);
        padding: 20px; /* Less padding */
        min-height: 400px;
        position: relative;
        max-width: 100%; /* Ensure it fits screen */
        width: 95%; /* Leave tiny margins */
        margin: 10px auto;
        box-sizing: border-box; /* Crucial for padding calculation */
    }

    /* 3D PLAYING CARD (Base) */
    .playing-card {
        width: 90px; height: 130px; /* Slightly smaller default */
        background: white; border-radius: 8px;
        position: relative; display: inline-block;
        box-shadow: -2px 2px 5px rgba(0,0,0,0.3);
        margin: 0 4px;
        transition: transform 0.3s;
        animation: dealCard 0.5s ease-out forwards;
    }
    .card-rank { font-size: 1.2rem; font-weight: bold; position: absolute; top: 4px; left: 6px; color: black; }
    .card-suit { font-size: 2.5rem; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }
    .card-red { color: #e11d48; }
    .card-black { color: #0f172a; }

    /* NEON BUTTONS */
    .btn-neon {
        background: rgba(0,0,0,0.3); color: white; border: 2px solid white;
        padding: 12px 30px; font-size: 1rem; text-transform: uppercase;
        letter-spacing: 1px; cursor: pointer; border-radius: 8px;
        transition: 0.2s; width: auto; max-width: 100%;
    }
    .btn-neon:hover { background: white; color: black; box-shadow: 0 0 15px var(--neon-blue); }

    .nav-back { color: #94a3b8; text-decoration: none; font-size: 0.9rem; margin-bottom: 15px; display: inline-block; }

    /* === MOBILE RESPONSIVE OVERRIDES === */
    @media (max-width: 768px) {
        /* Shrink the Table */
        .game-table {
            border-width: 8px; /* Thinner border */
            padding: 10px;
            border-radius: 20px;
        }

        /* Shrink Cards */
        .playing-card {
            width: 55px; height: 80px; /* Much smaller cards */
            margin: 0 2px;
        }
        .card-rank { font-size: 0.8rem; top: 2px; left: 4px; }
        .card-suit { font-size: 1.5rem; }

        /* Shrink Slot Machine Reels */
        .slot-machine-body { padding: 20px !important; border-width: 3px !important; }
        .reel-window { padding: 10px !important; gap: 5px !important; }
        .reel-box { 
            width: 60px !important; 
            height: 80px !important; 
            font-size: 2.5rem !important; 
        }

        /* Shrink Roulette Wheel */
        .wheel-container {
            width: 240px !important; height: 240px !important;
            border-width: 5px !important;
        }
        
        /* Adjust Font Sizes */
        h1 { font-size: 2rem !important; }
        .btn-neon { padding: 10px 20px; font-size: 0.9rem; }
    }
</style>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-900">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>