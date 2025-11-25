<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Valparadis App')</title>
    <script src="{{ asset('js/components/partials/themeswitch-antiflickering.js') }}"></script>
    
    @vite('resources/css/app.css')
</head>
<body class="bg-base-200 min-w-[700px]">

    <!-- Full-width TopBar -->
    <x-layout-components.topbar />

    <!-- Fixed Sidebar on the left -->
    <x-layout-components.sidebar />

    <!-- Main content -->
    <main class="ml-64 mt-16 p-4 overflow-auto min-h-[calc(100vh-4rem)] bg-base-300 shadow-inner">

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

    @vite('resources/js/app.js')
    <script src="{{ asset('js/components/partials/toast.js') }}"></script>
    <script src="{{ asset('js/components/partials/themeswitch.js') }}"></script>
    <script src="{{ asset('js/components/partials/modal.js') }}"></script>
    <script src="{{ asset('js/components/partials/menu-sidebar.js') }}"></script>
    <script src="{{ asset('js/components/partials/forms_one_click.js') }}"></script>
</body>
</html>
