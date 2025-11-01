<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>@yield('code', '') - @yield('title', 'Hi ha hagut un problema')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-base-100 flex items-center justify-center min-h-screen">

    <div class="text-center p-6">
        <!-- Logo de Paradis -->
        <img src="{{ asset('images/paradis-logo.svg') }}" alt="Paradis Logo" class="mx-auto max-w-2xl w-full h-auto mb-12">

        <h1 class="text-5xl font-bold mb-4">@yield('code') - @yield('title', 'Ups!')</h1>
        <p class="mb-6">@yield('message', 'Sembla que hi ha hagut un problema amb aquesta pàgina.')</p>

        <a href="{{ route('home') }}" class="btn btn-warning btn-lg">
            Torna a l'inici
        </a>
    </div>

</body>
</html>
