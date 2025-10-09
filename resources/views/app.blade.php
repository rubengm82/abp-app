<!DOCTYPE html>
<html lang="ca" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Valparadis App')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    <!-- TopBar full width -->
    <x-layout.topbar />

    <!-- Sidebar fijo a la izquierda -->
    <x-layout.sidebar />

    <!-- Contenido principal -->
    <main class="ml-64 mt-16 p-4 overflow-auto min-h-[calc(100vh-4rem)] bg-white rounded-tl-2xl shadow-inner">

        @hasSection('content')
            <div class="w-full">
                @yield('content')
            </div>
        @else
            <div class="flex items-center justify-center min-h-[calc(100vh-4rem)]">
                <img src="{{ asset('images/paradis-logo.svg') }}" alt="Paradis Logo" class="max-w-2xl w-full h-auto">
            </div>
        @endif

    </main>

<script src="{{ asset('js/components/individual/toast.js') }}"></script>
</body>
</html>
