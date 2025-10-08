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
        <div class="w-[1000px] lg:w-[1000px] w-auto h-[500px] flex overflow-hidden rounded-2xl bg-orange-500" style="box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);">
            <!-- /*hidden lg:block para esconderlo en pantallas pequeñas */-->
            <div class="left w-1/2 p-6 bg-white hidden lg:block z-1" style="box-shadow: 8px 0 16px rgba(0,0,0,0.06);">
                <!-- Check if is the correct way to do it -->
                <img src="{{ asset('images/paradis-logo.svg') }}" alt="vallparadis logo" class="w-1/2 mx-auto">
                <img src="{{ asset('images/desktop_login.png') }}" alt="desktop logo" class="w-full">
            </div>
            <!--/*
              lg:w-1/2 para que ocupe el 50% de la pantalla en pantallas grandes 
              w-[500px] Ancho fijo en pantallas pequeñas
              mx-auto para que se centre en la pantalla
            */-->
            <div class="right w-1/2 lg:w-1/2 w-[500px] p-6 bg-gray-100 mx-auto">
                <img src="{{ asset('images/user_login.png') }}" alt="dummy user" class="mb-10 mt-5 w-30 h-30 mx-auto">
                <div class="flex flex-col items-center">
                    
                    <form class="space-y-4 mt-10">
                        <div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span>🥟</span>
                                    <div class="ml-2 w-px h-6 bg-gray-300"></div>
                                </div>
                                <input type="text" class="w-full pl-12 pr-3 py-2 border-2 border-orange-300 rounded-full focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400" placeholder="Usuari">
                            </div>
                        </div>
                        <div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span>🥟</span>
                                    <div class="ml-2 w-px h-6 bg-gray-300"></div>
                                </div>
                                <input type="password" class="w-full pl-12 pr-3 py-2 border-2 border-orange-300 rounded-full focus:outline-none focus:ring-2 focus:ring-orange-400 focus:border-orange-400" placeholder="Password">
                            </div>
                        </div>
                    @if(session('login_error'))
                    <p class="text-orange-400 text-sm mt-2 text-center">Usuario o contraseña erróneo</p>
                    @endif
                    </form>
                    <!-- TODO: Review this code, about the position of the button -->
                    <div class="flex justify-center relative"> 
                        <a href="{{ url('/home') }}">
                            <button type="submit" class="absolute top-20 left-1/2 transform -translate-x-1/2 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-14 rounded-full transition-colors shadow-lg hover:shadow-xl">
                                Acceder
                            </button>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>