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
            :root {
                --felt-green: #0b4628;
                --felt-gradient: radial-gradient(circle, #0e5c35 0%, #0b4628 60%, #041f11 100%);
                --gold-metallic: linear-gradient(135deg, #fce38a 0%, #f38181 100%);
                --neon-blue: #00f2ff;
                --neon-pink: #ff00de;
                --card-shadow: 0 5px 15px rgba(0,0,0,0.5);
                --chip-shadow: 0 4px 6px rgba(0,0,0,0.3);
            }
        
            body {
                background-color: #0f172a !important;
                font-family: 'Inter', system-ui, sans-serif;
                color: white;
            }
        
            /* THE TABLE (Realistic Felt) */
            .game-table {
                background: var(--felt-gradient);
                border: 15px solid #2d1b0e; /* Wood border */
                border-radius: 50px;
                box-shadow: inset 0 0 100px rgba(0,0,0,0.8), 0 20px 50px rgba(0,0,0,0.5);
                padding: 40px;
                min-height: 500px;
                position: relative;
                max-width: 1000px;
                margin: 20px auto;
                border-bottom: 15px solid #1a0f08; /* 3D depth */
            }
        
            /* 3D PLAYING CARD */
            .playing-card {
                width: 100px; height: 140px;
                background: white;
                border-radius: 10px;
                position: relative;
                display: inline-block;
                box-shadow: -5px 5px 10px rgba(0,0,0,0.3);
                margin: 0 5px;
                transition: transform 0.3s;
                animation: dealCard 0.5s ease-out forwards;
            }
            .playing-card:hover { transform: translateY(-10px) rotate(2deg); z-index: 10; }
            .card-rank { font-size: 1.5rem; font-weight: bold; position: absolute; top: 5px; left: 8px; color: black; }
            .card-suit { font-size: 3rem; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }
            .card-red { color: #e11d48; }
            .card-black { color: #0f172a; }
            
            @keyframes dealCard { from { opacity: 0; transform: translateY(-100px) scale(0.5); } to { opacity: 1; transform: translateY(0) scale(1); } }
        
            /* NEON BUTTONS */
            .btn-neon {
                background: transparent;
                color: white;
                border: 2px solid white;
                padding: 15px 40px;
                font-size: 1.2rem;
                text-transform: uppercase;
                letter-spacing: 2px;
                cursor: pointer;
                position: relative;
                overflow: hidden;
                transition: 0.3s;
                box-shadow: 0 0 10px rgba(255,255,255,0.1);
            }
            .btn-neon:hover {
                background: white; color: black;
                box-shadow: 0 0 20px white, 0 0 40px var(--neon-blue);
            }
            
            /* UTILS */
            .text-glow { text-shadow: 0 0 10px rgba(255,255,255,0.8); }
            .nav-back { color: rgba(255,255,255,0.5); text-decoration: none; font-weight: bold; display: inline-block; margin-bottom: 20px; }
            .nav-back:hover { color: white; }
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