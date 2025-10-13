<!DOCTYPE html>
<html lang="ca" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Valparadis App</title>
    @vite('resources/css/app.css')
    <style>
        * {
            font-family: 'Source Sans Pro', Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body>
<div class="w-screen h-screen flex items-center justify-center bg-gradient-to-b from-gray-100 to-amber-500">
    <div class="w-[1000px] h-[500px] flex overflow-hidden rounded-2xl bg-orange-500 shadow-[0_0_30px_rgba(0,0,0,0.1)]">
        
        <!-- Left panel (hidden in small screens) -->
        <div class="w-1/2 p-6 bg-white hidden lg:block z-10 shadow-[8px_0_16px_rgba(0,0,0,0.06)]">
            <img src="{{ asset('images/paradis-logo.svg') }}" alt="vallparadis logo" class="w-1/2 mx-auto mb-6">
            <img src="{{ asset('images/desktop_login.png') }}" alt="desktop logo" class="w-full">
        </div>
        
        <!-- Right panel (login form) -->
        <div class="w-full lg:w-1/2 p-6 bg-gray-100 flex flex-col justify-center">
            <img src="{{ asset('images/user_login.png') }}" alt="dummy user" class="mb-10 mt-5 w-32 h-32 mx-auto">
            
            <form action="{{ route('login') }}" method="POST" class="space-y-4 mt-10">
                @csrf
                
                <!-- Usuario -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span>🥟</span>
                        <div class="ml-2 w-px h-6 bg-gray-300"></div>
                    </div>
                    <input type="text" name="user" value="{{ old('user') }}" placeholder="Usuari"
                        autocomplete="username"
                        class="w-full pl-12 pr-3 py-2 border-2 border-orange-300 rounded-full focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                    @error('user')
                        <p class="text-orange-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span>🥟</span>
                        <div class="ml-2 w-px h-6 bg-gray-300"></div>
                    </div>
                    <input type="password" name="password" placeholder="Password"
                        autocomplete="current-password"
                        class="w-full pl-12 pr-3 py-2 border-2 border-orange-300 rounded-full focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400">
                    @error('password')
                        <p class="text-orange-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Error de login -->
                @if(session('login_error'))
                    <p class="text-orange-400 text-sm mt-2 text-center">{{ session('login_error') }}</p>
                @endif

                <!-- Botón de acceso -->
                <div class="flex justify-center">
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-14 rounded-full transition-colors shadow-lg hover:shadow-xl">
                        Acceder
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
</body>
</html>
