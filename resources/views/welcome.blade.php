<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Football League Tracker</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-green-600 to-green-900 text-white min-h-screen">

<!-- NAVBAR -->
<div class="flex justify-between items-center px-8 py-4">
    <h1 class="text-2xl font-bold">⚽ Football League Tracker</h1>

    <div class="space-x-4">
        @auth

        @else
            <a href="{{ route('login') }}" class="hover:underline">Login</a>
            <a href="{{ route('register') }}" class="hover:underline">Register</a>
        @endauth
    </div>
</div>

<!-- HERO SECTION -->
<div class="flex flex-col items-center justify-center text-center mt-20 px-4">

    <h2 class="text-5xl font-extrabold mb-6">
        Track Football Leagues <br> Like a Pro
    </h2>

    <p class="text-lg text-green-100 max-w-2xl mb-8">
        Follow your favorite competitions, check standings, explore matches and manage your favorite teams — all in one place.
    </p>

    <!-- CTA BUTTON -->
    @auth
        <div class="flex gap-4">
            <a href="{{ route('competitions.index') }}"
               class="bg-white text-green-700 px-8 py-3 rounded-xl font-semibold text-lg hover:bg-gray-100 transition shadow-lg">
                View Competitions
            </a>

            @auth
                <a href="{{ route('dashboard') }}"
                   class="border border-white px-8 py-3 rounded-xl font-semibold text-lg hover:bg-white hover:text-green-700 transition">
                    Go to Dashboard
                </a>
            @endauth
        </div>
    @else
        <p class="bg-white text-green-700 px-8 py-3 rounded-xl font-semibold text-lg hover:bg-gray-100 transition shadow-lg">
            Register and follow the latest results
        </p>
    @endauth

</div>

<!-- FEATURES -->
<div class="mt-24 px-8">
    <div class="grid md:grid-cols-3 gap-8 text-center">

        <div class="bg-white/10 p-6 rounded-2xl backdrop-blur">
            <h3 class="text-xl font-bold mb-2">📊 Standings</h3>
            <p class="text-green-100">
                View league tables and team rankings in real time.
            </p>
        </div>

        <div class="bg-white/10 p-6 rounded-2xl backdrop-blur">
            <h3 class="text-xl font-bold mb-2">⚽ Matches</h3>
            <p class="text-green-100">
                Check upcoming and finished matches with live status.
            </p>
        </div>

        <div class="bg-white/10 p-6 rounded-2xl backdrop-blur">
            <h3 class="text-xl font-bold mb-2">⭐ Favorites</h3>
            <p class="text-green-100">
                Save and manage your favorite teams easily.
            </p>
        </div>

    </div>
</div>

<!-- FOOTER -->
<div class="mt-20 text-center text-green-200 text-sm pb-6">
    © {{ date('Y') }} Football League Tracker
</div>

</body>
</html>
