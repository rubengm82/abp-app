<!DOCTYPE html>
<html lang="ca" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Valparadis App</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-login-animated overflow-hidden">

    <div class="w-screen h-screen flex items-center justify-center">
        <div class="h-[500px] flex overflow-hidden rounded-2xl bg-orange-500 shadow-[0_0_30px_rgba(0,0,0,0.1)]">
            
            <!-- Left panel (hidden in small screens) -->
            <div class="left w-1/2 p-6 bg-white hidden lg:block z-10 shadow-[8px_0_16px_rgba(0,0,0,0.06)]">
                <img src="{{ asset('images/desktop_login.png') }}" alt="desktop logo" class="w-full">
            </div>
            
            <!-- Right panel (login form) -->
            <div class="lg:w-1/2 w-[500px] p-6 bg-gray-100 mx-auto flex flex-col justify-center">
                <img src="{{ asset('images/paradis-logo.svg') }}" alt="vallparadis logo" class="w-2/3 mx-auto mt-1">
                <div>
                    <x-partials.icon name="user" class="w-38 h-38 text-white bg-amber-500 border rounded-full p-5 mx-auto mt-2 mb-5" />
                </div>
                
                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- User -->
                    <div class="flex items-center w-2/3 mx-auto border border-orange-300 rounded-full focus-within:ring-1 focus-within:ring-orange-400 focus-within:border-orange-400">
                        <!-- Icon y separator -->
                        <div class="flex items-center pl-4">
                            <span class="text-xl">
                                <x-partials.icon name="user" class="w-6 h-6 text-primary" />
                            </span>
                            <div class="ml-2 w-px h-6 bg-gray-300"></div>
                        </div>
                        <!-- Input -->
                        <input type="text" name="user" value="{{ old('user') }}" placeholder="Usuari"
                            autocomplete="username"
                            class="flex-1 pl-4 py-2 outline-none rounded-r-full"
                            required>
                    </div>

                    <!-- Password -->
                    <div class="flex items-center w-2/3 mx-auto border border-orange-300 rounded-full focus-within:ring-1 focus-within:ring-orange-400 focus-within:border-orange-400">
                        <!-- Icon y separator -->
                        <div class="flex items-center pl-4">
                            <span class="text-xl">
                                <x-partials.icon name="lock-closed" class="w-6 h-6 text-primary" />
                            </span>
                            <div class="ml-2 w-px h-6 bg-gray-300"></div>
                        </div>
                        <!-- Input -->
                        <input type="password" name="password" placeholder="Password"
                            autocomplete="current-password"
                            class="flex-1 pl-4 py-2 outline-none rounded-r-full"
                            required>
                    </div>

                    <!-- Button Access - Login -->
                    <div class="flex justify-center">
                        <button type="submit" class="bg-orange-400 hover:bg-orange-500 text-white font-bold py-3 px-14 rounded-full transition-colors shadow-lg hover:shadow-xl mt-3">
                            Acceder
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    {{-- TOAST: FAIL ERROR ENABLED --}}
    @if (session('login_error'))
        <div class="toast toast-end">
            <div class="alert alert-error">
                <span>{{ session('login_error') }}</span>
            </div>
        </div>
    @endif

    {{-- Modal for Center Selection --}}
    @if(isset($show_modal) && $show_modal)
    <input type="checkbox" id="centerModal" class="modal-toggle" checked />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Selecciona un centre</h3>

            <form action="{{ route('select_center') }}" method="POST">
                @csrf

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Centre</span>
                    </label>
                    <select name="center_id" class="select select-bordered ml-3" required>
                        <option value="">Selecciona un centre</option>
                        @foreach($centers as $center)
                            <option value="{{ $center->id }}">{{ $center->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-action">
                    <label for="centerModal" class="btn btn-outline">Cancel·lar</label>
                    <button type="submit" class="btn btn-primary">Acceder</button>
                </div>
            </form>
        </div>
    </div>
    @endif


<script src="{{ asset('js/components/partials/toast.js') }}"></script>
<script src="{{ asset('js/components/partials/menu-sidebar-reset.js') }}"></script>
</body>
</html>
@include('components.partials.mainToasts')