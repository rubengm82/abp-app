<div class="h-16 bg-[#555555] flex items-center justify-between px-4 w-full fixed top-0 left-0 z-10">

    {{-- LEFT --}}
    <!-- Logo  -->
    <div class="flex items-center text-lg font-bold select-none">
        <a href="{{ route('home') }}" class="block px-4 py-2 no-underline">
            <span class="text-[#ff7500]">Técnic</span>
            <span class="text-[#fafafa]">- Can Serra</span>
        </a>
    </div>


    {{-- RIGHT --}}
    <!-- Dropdown usuario -->
    <div class="dropdown dropdown-end">
        <!-- Button dropdown - ICON USER -->
        <label tabindex="0" class="bg-orange-500 hover:bg-orange-400 text-white w-9 h-9 flex items-center justify-center rounded-full cursor-pointer">
            <i class="fa-solid fa-user text-xl"></i>
        </label>

        <!-- Menu -->
        <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 mt-2 z-20">
            <!-- Version APP -->
            <li class="text-gray-400 pointer-events-none">
                <span class="pl-2 pr-2 w-full block text-right cursor-default">Versió 0.1a</span>
            </li>

            <!-- Items - Menu -->
            <li>
                <a href="{{ route('login') }}" class="flex items-center justify-start gap-2">
                    <i class="fa-solid fa-arrow-right"></i> Sortir
                </a>
            </li>
        </ul>
    </div>

</div>
