<div class="w-64 fixed top-16 bottom-0 left-0 flex flex-col justify-between shadow-md bg-base-200">

    <!-- Navigation menu -->
    <nav class="flex-1 overflow-auto">
        <ul class="menu bg-base-200 w-full text-xs text-base-100 dark:text-base-content">

            <!-- Submenu Centers -->
            <li>
                <details>
                    <summary>
                        <x-partials.icon name="building-office" class="w-7 h-7 text-primary" />
                        Centres
                    </summary>
                    <ul class="text-xs">
                        <li>
                            <a href="{{ route('centers_list') }}">
                                <x-partials.icon name="queue-list" class="w-5 h-5 text-info" />
                                Llistar
                            </a>
                        </li>
                    </ul>
                    <ul class="text-xs">
                        <li>
                            <a href="{{ route('center_form') }}">
                                <x-partials.icon name="plus-circle" class="w-5 h-5 text-info" />
                                Afegir
                            </a>
                        </li>
                    </ul>
                </details>
            </li>

            <!-- Submenu Professionals -->
            <li>
                <details>
                    <summary>
                        <x-partials.icon name="user-group" class="w-7 h-7 text-primary" />
                        Professionals
                    </summary>

                    <!-- List Professionals -->
                    <ul class="text-xs">
                        <li>
                            <a href="{{ route('professionals_list') }}">
                                <x-partials.icon name="queue-list" class="w-5 h-5 text-info" />
                                Llistar
                            </a>
                        </li>
                    </ul>

                    <!-- Add Professional -->
                    <ul class="text-xs">
                        <li>
                            <a href="{{ route('professional_form') }}">
                                <x-partials.icon name="plus-circle" class="w-5 h-5 text-info" />
                                Afegir
                            </a>
                        </li>
                    </ul>

                    <!-- Submenu Evaluations -->
                    <ul class="text-xs">
                        <li>
                            <details>
                                <summary>
                                    <x-partials.icon name="clipboard-document-check" class="w-7 h-7 text-primary" />
                                    Evaluations
                                </summary>

                                <!-- List Evaluations -->
                                <ul class="text-xs">
                                    <li>
                                        <a href="{{ route('professional_evaluations_list') }}">
                                            <x-partials.icon name="queue-list" class="w-5 h-5 text-info" />
                                            Llistar
                                        </a>
                                    </li>
                                </ul>

                                <!-- Add Evaluation -->
                                <ul class="text-xs">
                                    <li>
                                        <a href="{{ route('professional_evaluations_quiz_form') }}">
                                            <x-partials.icon name="plus-circle" class="w-5 h-5 text-info" />
                                            Afegir
                                        </a>
                                    </li>
                                </ul>
                            </details>
                        </li>
                    </ul>
                </details>
            </li>

            <!-- Submenu Project/Commissions -->
            <li>
                <details>
                    <summary>
                        <x-partials.icon name="rectangle-group" class="w-7 h-7 text-primary" />
                        Projectes/Comissions
                    </summary>
                    <ul class="text-xs">
                        <li>
                            <a href="{{ route('projectcommissions_list') }}">
                                <x-partials.icon name="queue-list" class="w-5 h-5 text-info" />
                                Llistar
                            </a>
                        </li>
                    </ul>
                    <ul class="text-xs">
                        <li>
                            <a href="{{ route('projectcommission_form') }}">
                                <x-partials.icon name="plus-circle" class="w-5 h-5 text-info" />
                                Afegir
                            </a>
                        </li>
                    </ul>
                </details>
            </li>

            <!-- Submenu Material-Assignments -->
            <li>
                <a href="{{ route('materialassignments_list') }}">
                    <x-partials.icon name="identification" class="w-7 h-7 text-primary" />
                    Registre de Uniformitat
                </a>
            </li>

            <!-- Submenu Courses -->
            <li>
                <details>
                    <summary>
                        <x-partials.icon name="academic-cap" class="w-7 h-7 text-primary" />
                        Cursos
                    </summary>
                    <ul class="text-xs">
                        <li>
                            <a href="{{ route('courses_list') }}">
                                <x-partials.icon name="queue-list" class="w-5 h-5 text-info" />
                                Llistar
                            </a>
                        </li>
                    </ul>
                    <ul class="text-xs">
                        <li>
                            <a href="{{ route('course_form') }}">
                                <x-partials.icon name="plus-circle" class="w-5 h-5 text-info" />
                                Afegir
                            </a>
                        </li>
                    </ul>
                </details>
            </li>

            <!-- Submenu Desactivations -->
            <li>
                <details>
                    <summary>
                        <x-partials.icon name="folder-open" class="w-7 h-7 text-gray-500" />
                        Desactivacions
                    </summary>
                    <ul class="text-xs">
                        <li>
                            <a href="{{ route('centers_desactivated_list') }}">
                                <x-partials.icon name="building-office" class="w-5 h-5 text-gray-500" />
                                Centres
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('professionals_desactivated_list') }}">
                                <x-partials.icon name="user-group" class="w-5 h-5 text-gray-500" />
                                Professionals
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('projectcommissions_desactivated_list') }}">
                                <x-partials.icon name="rectangle-group" class="w-5 h-5 text-gray-500" />
                                Projectes/Comissions
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
        </ul>
    </nav>


    <!-- Company logo below -->
    <div class="p-4">
        <img src="{{ asset('images/paradis-logo.svg') }}" alt="Paradis Logo" class="w-full">
    </div>

</div>
