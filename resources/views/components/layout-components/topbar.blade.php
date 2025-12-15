<div class="h-16 bg-gray-800 flex items-center justify-between px-4 w-full fixed top-0 left-0 z-10 shadow-xl">

    {{-- LEFT --}}
    <!-- Logo  -->
    <div class="flex items-center text-lg font-bold select-none">
        <a href="{{ route('home') }}" class="block px-4 py-2 no-underline">
            <span class="text-primary text-3xl">{{ (Auth::user()->center)->name}}</span>
        </a>
    </div>

    {{-- RIGHT --}}
    <div class="flex items-center gap-6 text-gray-500">
        
        {{-- Time/Date --}}
        <span id="current-time">{{ \Carbon\Carbon::now()->format('m/d/Y H:i:s') }}</span>

        <div class="dropdown dropdown-end">
            <!-- Button dropdown - ICON USER -->
            <label tabindex="0" class="bg-orange-500 hover:bg-orange-400 text-white w-9 h-9 flex items-center justify-center rounded-full cursor-pointer">
                <x-partials.icon name="user" class="w-6 h-6 text-white" />
            </label>

            <!-- Menu -->
            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 mt-2 z-20">
                
                <!-- Version APP -->
                <li class="text-gray-400 pointer-events-none pr-2">
                    <span class=" w-full block text-right cursor-default">Sprint 4 | Versió 0.4.0</span>
                </li>

                <!-- Separator -->
                <span class="block border-t border-gray-400 my-2 w-full rounded-none"></span>
                
                <li class="text-gray-400 pointer-events-none flex flex-col items-center gap-1">
                    <span class="font-bold text-base-content text-center">
                        {{ (Auth::user()->name) . ' ' . (Auth::user()->surname1) . ' ' . (Auth::user()->surname2 ?? '') }}
                    </span>
                    <span class="text-primary font-bold text-center text-xl">
                        {{ Auth::user()->role ?? 'Sense Rol' }}
                    </span>
                </li>
                
                <!-- Separator -->
                <span class="block border-t border-gray-400 my-2 w-full rounded-none"></span>
                
                <!-- Dark/Light Mode Toggle -->
                <li class="p-2">
                    <div class="flex items-center justify-between w-full">
                        <span>Clar | Fosc</span>
                        <input
                            type="checkbox"
                            id="theme-toggle"
                            class="toggle toggle-sm"
                            title="Canviar Dark/Light"
                        />
                    </div>
                </li>

                <!-- Separator -->
                <span class="block border-t border-gray-400 my-2 w-full rounded-none"></span>

                <!-- About/Info -->
                <li>
                    <a href="{{ route('about_show') }}" class="flex items-center gap-2">
                        <x-partials.icon name="information-circle" class="w-5 h-5" />
                        <span>Info</span>
                    </a>
                </li>

                <!-- Separator -->
                <span class="block border-t border-gray-400 my-2 w-full rounded-none"></span>

                <!-- Logout -->
                <li>
                    <x-partials.modal 
                        id="logoutModal" 
                        msj="Estàs segur que vols sortir?" 
                        btnText="Tancar Sessió" 
                        class="btn-sm btn-error"
                    >
                        <form action="{{ route('logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-error w-full flex items-center gap-2">
                                <i class="fa-solid fa-arrow-right"></i>
                                <span>Sortir</span>
                            </button>
                        </form>
                    </x-partials.modal>
                </li>
            </ul>
        </div>
    </div>

</div>

@if (session('warning'))
    <div class="toast toast-end">
        <div class="alert alert-warning">
            <span>{{ session('warning') }}</span>
        </div>
    </div>
@endif


<script src="{{ asset('js/components/partials/hora-topbar.js') }}"></script>
