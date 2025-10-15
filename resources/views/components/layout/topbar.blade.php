<div class="h-16 bg-[#555555] flex items-center justify-between px-4 w-full fixed top-0 left-0 z-10 shadow-xl ">

    {{-- LEFT --}}
    <!-- Logo  -->
    <div class="flex items-center text-lg font-bold select-none">
        <a href="{{ route('home') }}" class="block px-4 py-2 no-underline">
            <span class="text-[#ff7500]">{{ Auth::user()->role }}</span>
            <span class="text-[#fafafa]">- {{ (Auth::user()->center)->name }}</span>
            <span class="text-[#fafafa]">({{ Auth::user()->name . ' ' . Auth::user()->surname1 . ' ' . Auth::user()->surname2 }})</span>
        </a>
    </div>


    {{-- RIGHT --}}
    <!-- Dropdown usuario -->
    <div class="dropdown dropdown-end">
        
        <!-- Button dropdown - ICON USER -->
        <label tabindex="0" class="bg-orange-500 hover:bg-orange-400 text-white w-9 h-9 flex items-center justify-center rounded-full cursor-pointer">
            <span>X</span>
        </label>

        <!-- Menu -->
        <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 mt-2 z-20">
            <!-- Version APP -->
            <li class="text-gray-400 pointer-events-none">
                <span class="pl-2 pr-2 w-full block text-right cursor-default">Versió 0.2.1</span>
            </li>

            <!-- Items - Menu -->
            <li>
            <li>
                <a href="{{ route('logout') }}" class="flex items-center justify-start gap-2 w-full text-left">
                    <i class="fa-solid fa-arrow-right"></i> Sortir
                </a>
            </li>
        </ul>
    </div>

</div>

@if (session('warning'))
    <div class="toast toast-end">
        <div class="alert alert-warning">
            <span>{{ session('warning') }}</span>
        </div>
    </div>
@endif