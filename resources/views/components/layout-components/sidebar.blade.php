<div class="w-64 fixed top-16 bottom-0 left-0 flex flex-col justify-between shadow-md bg-[#b9bec1] text-gray-800">

    <!-- Navigation menu -->
    <nav class="flex-1 overflow-auto">
        <ul class="select-none">
            <li>
                <a href="{{ route('centers_list') }}" class="block px-4 py-2 hover:bg-[#a0a6af]">
                    Llistar de Centres
                </a>
            </li>
            <li>
                <a href="{{ route('professionals_list') }}" class="block px-4 py-2 hover:bg-[#a0a6af]">
                    Llistar Professionals
                </a>
            </li>
            <li>
                <a href="{{ route('projectcommissions_list') }}" class="block px-4 py-2 hover:bg-[#a0a6af]">
                    Llistar Projectes/Comissions
                </a>
            </li>
            <li>
                <a href="{{ route('materialassignments_list') }}" class="block px-4 py-2 hover:bg-[#a0a6af]">
                    Registre d'Uniformitat
                </a>
            </li>
            <li>
                <a href="" class="block px-4 py-2 cursor-default">
                    _____________________________
                </a>
            </li>
            <li>
                <a href="{{ route('centers_desactivated_list') }}" class="block px-4 py-2 hover:bg-[#a0a6af]">
                    Llistar de Centres <small>(Desactivats)</small>
                </a>
            </li>
            <li>
                <a href="{{ route('professionals_desactivated_list') }}" class="block px-4 py-2 hover:bg-[#a0a6af]">
                    Llistar Professionals <small>(Desactivats)</small>
                </a>
            </li>
            <li>
                <a href="{{ route('projectcommissions_desactivated_list') }}" class="block px-4 py-2 hover:bg-[#a0a6af]">
                    Llistar Projectes/Comissions <small>(Desactivats)</small>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Company logo below -->
    <div class="p-4">
        <img src="{{ asset('images/paradis-logo.svg') }}" alt="Paradis Logo" class="w-full">
    </div>

</div>
