<div class="w-64 bg-[#d0d0d0] fixed top-16 bottom-0 left-0 flex flex-col justify-between shadow-md">

    <!-- Menú de navegación -->
    <nav class="flex-1 overflow-auto">
        <ul class="text-[#555555]">
            <li>
                <a href="{{ route('centers_list') }}" class="block px-4 py-2 hover:bg-[#fafafa] select-none">
                    Llistar Centres
                </a>
            </li>
            <li>
                <a href="{{ route('centers_desactivated_list') }}" class="block px-4 py-2 hover:bg-[#fafafa] select-none">
                    Llistar Centres <small>(Desactivats)</small>
                </a>
            </li>
            <li>
                <a href="{{ route('center_form') }}" class="block px-4 py-2 hover:bg-[#fafafa] select-none">
                    Afegir Centre
                </a>
            </li>
            <li>
                <a href="{{ route('professionals_list') }}" class="block px-4 py-2 hover:bg-[#fafafa] select-none">
                    Llistar Professionals
                </a>
            </li>
            <li>
                <a href="{{ route('professionals_desactivated_list') }}" class="block px-4 py-2 hover:bg-[#fafafa] select-none">
                    Llistar Professionals <small>(Desactivats)</small>
                </a>
            </li>
            <li>
                <a href="{{ route('professional_form') }}" class="block px-4 py-2 hover:bg-[#fafafa] select-none">
                    Afegir Professional
                </a>
            </li>
        </ul>
    </nav>

    <!-- Logo de la empresa abajo -->
    <div class="p-4">
        <img src="{{ asset('images/paradis-logo.svg') }}" alt="Paradis Logo" class="w-full">
    </div>

</div>
