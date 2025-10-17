<div class="w-64 bg-base-200 dark:bg-base-300 fixed top-16 bottom-0 left-0 flex flex-col justify-between shadow-md">

    <!-- Navigation menu -->
    <nav class="flex-1 overflow-auto">
        <ul class="text-base-content dark:text-base-content">
            <li>
                <a href="{{ route('centers_list') }}" class="block px-4 py-2 hover:bg-base-100 dark:hover:bg-base-200 select-none">
                    Llistar de Centres
                </a>
            </li>
            <li>
                <a href="{{ route('professionals_list') }}" class="block px-4 py-2 hover:bg-base-100 dark:hover:bg-base-200 select-none">
                    Llistar Professionals
                </a>
            </li>
            <li>
                <a href="{{ route('projectcommissions_list') }}" class="block px-4 py-2 hover:bg-base-100 dark:hover:bg-base-200 select-none">
                    Llistar Projectes/Comissions
                </a>
            </li>
            <li>
                <a href="{{ route('materialassignments_list') }}" class="block px-4 py-2 hover:bg-base-100 dark:hover:bg-base-200 select-none">
                    Registre de Uniformitat
                </a>
            </li>
            <li>
                <a href="" class="block px-4 py-2 cursor-default">
                    _____________________________
                </a>
            </li>
            <li>
                <a href="{{ route('centers_desactivated_list') }}" class="block px-4 py-2 hover:bg-base-100 dark:hover:bg-base-200 select-none">
                    Llistar de Centres <small>(Desactivats)</small>
                </a>
            </li>
            <li>
                <a href="{{ route('professionals_desactivated_list') }}" class="block px-4 py-2 hover:bg-base-100 dark:hover:bg-base-200 select-none">
                    Llistar Professionals <small>(Desactivats)</small>
                </a>
            </li>
            <li>
                <a href="{{ route('projectcommissions_desactivated_list') }}" class="block px-4 py-2 hover:bg-base-100 dark:hover:bg-base-200 select-none">
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
