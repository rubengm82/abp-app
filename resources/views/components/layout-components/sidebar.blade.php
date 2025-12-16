<div class="w-64 fixed top-16 bottom-0 left-0 flex flex-col justify-between shadow-md bg-base-200">

    <!-- Navigation menu -->
    <nav class="flex-1 overflow-auto">
        <ul class="menu bg-base-200 w-full text-xs text-base-content">

            <!-- Submenu Centers (gerent only) -->
            @if((Auth::user()->role ?? null) === 'Gerent')
            <li>
                <details>
                    <summary class="font-normal">
                        <x-partials.icon name="building-office" class="w-6 h-6 text-primary" />
                        Centres
                    </summary>
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{ route('centers_list') }}">
                                <x-partials.icon name="queue-list" class="w-4 h-4 text-info" />
                                Llistar
                            </a>
                        </li>
                    </ul>
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{ route('center_form') }}">
                                <x-partials.icon name="plus" class="w-4 h-4 text-info" />
                                Afegir
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
            @else
            <li>
                <a href="{{ route('center_show', ['id' => Auth::user()->center_id]) }}">
                    <x-partials.icon name="building-office" class="w-6 h-6 text-primary" />
                    Centre
                </a>
            </li>
            @endif

            <!-- Submenu External Contacts -->
            <li>
                <details>
                    <summary class="font-normal">
                        <x-partials.icon name="phone" class="w-6 h-6 text-primary" />
                        Contactes Externs
                    </summary>
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{ route('externalcontacts_list') }}">
                                <x-partials.icon name="queue-list" class="w-4 h-4 text-info" />
                                Llistar
                            </a>
                        </li>
                    </ul>
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{ route('externalcontact_form') }}">
                                <x-partials.icon name="plus" class="w-4 h-4 text-info" />
                                Afegir
                            </a>
                        </li>
                    </ul>
                </details>
            </li>

            <!-- Submenu Global Documents -->
            @if(in_array(Auth::user()->role ?? null, ['Directiu', 'Gerent']))
            <li class="font-normal">
                <a href="{{ route('global_documents_list') }}">
                    <x-partials.icon name="document-text" class="w-6 h-6 text-primary" />
                    Documents Globals
                </a>
            </li>
            @endif

            <!-- Submenu HR Issues (Directiu and Gerent only) -->
            @if((Auth::user()->role ?? null) === 'Directiu' || (Auth::user()->role ?? null) === 'Gerent')
            <li>
                <details>
                    <summary class="font-normal">
                        <x-partials.icon name="exclamation-triangle" class="w-6 h-6 text-primary" />
                        Temes pendents RRHH
                    </summary>
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{ route('hr_issues_list') }}">
                                <x-partials.icon name="queue-list" class="w-4 h-4 text-info" />
                                Llistar
                            </a>
                        </li>
                    </ul>
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{ route('hr_issue_form') }}">
                                <x-partials.icon name="plus" class="w-4 h-4 text-info" />
                                Afegir
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
            @endif

            <!-- Submenu Maintenances -->
            @if(in_array(Auth::user()->role ?? null, ['Directiu', 'Administració', 'Gerent']))
            <li>
                <details>
                    <summary class="font-normal">
                        <x-partials.icon name="wrench" class="w-6 h-6 text-primary" />
                        Manteniments
                    </summary>
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{ route('maintenances_list') }}">
                                <x-partials.icon name="queue-list" class="w-4 h-4 text-info" />
                                Llistar
                            </a>
                        </li>
                    </ul>
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{  route('maintenance_form') }}">
                                <x-partials.icon name="plus" class="w-4 h-4 text-info" />
                                Afegir
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
            @endif
            <!-- Submenu Professionals -->
            <li>
                <details>
                    <summary class="font-normal">
                        <x-partials.icon name="user-group" class="w-6 h-6 text-primary" />
                        Professionals
                    </summary>

                    <!-- List Professionals -->
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{ route('professionals_list') }}">
                                <x-partials.icon name="queue-list" class="w-4 h-4 text-info" />
                                Llistar
                            </a>
                        </li>
                    </ul>

                    <!-- Add Professional -->
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{ route('professional_form') }}">
                                <x-partials.icon name="plus" class="w-4 h-4 text-info" />
                                Afegir
                            </a>
                        </li>
                    </ul>
                    <!-- Submenu Professional Accidents (Directiu and Administració only) -->
                    @if(in_array(Auth::user()->role ?? null, ['Directiu', 'Administració', 'Gerent']))
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <details>
                                <summary class="font-normal text-base-content">
                                    <x-partials.icon name="clipboard-document" class="w-6 h-6 text-primary" />
                                    Accidents
                                </summary>
                                <ul class="text-xs text-base-content/65">
                                    <li>
                                        <a href="{{ route('professional_accidents_list') }}">
                                            <x-partials.icon name="queue-list" class="w-4 h-4 text-info" />
                                            Llistar
                                        </a>
                                    </li>
                                </ul>
                                <ul class="text-xs text-base-content/65">
                                    <li>
                                        <a href="{{ route('professional_accident_form') }}">
                                            <x-partials.icon name="plus" class="w-4 h-4 text-info" />
                                            Afegir
                                        </a>
                                    </li>
                                </ul>
                            </details>
                        </li>
                    </ul>
                    @endif
                    <!-- Submenu Cursos -->
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <details>
                                <summary class="font-normal text-base-content">
                                    <x-partials.icon name="academic-cap" class="w-6 h-6 text-primary" />
                                    Cursos
                                </summary>
                                <ul class="text-xs text-base-content/65">
                                    <li>
                                        <a href="{{ route('courses_list') }}">
                                            <x-partials.icon name="queue-list" class="w-4 h-4 text-info" />
                                            Llistar
                                        </a>
                                    </li>
                                </ul>
                                <ul class="text-xs text-base-content/65">
                                    <li>
                                        <a href="{{ route('course_form') }}">
                                            <x-partials.icon name="plus" class="w-4 h-4 text-info" />
                                            Afegir
                                        </a>
                                    </li>
                                </ul>
                            </details>
                        </li>
                    </ul>

                    <!-- Submenu Evaluations -->
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <details>
                                <summary class="font-normal text-base-content">
                                    <x-partials.icon name="clipboard-document-check" class="w-6 h-6 text-primary" />
                                    Avaluacions
                                </summary>

                                <!-- List Evaluations -->
                                <ul class="text-xs text-base-content/65">
                                    <li>
                                        <a href="{{ route('professional_evaluations_list') }}">
                                            <x-partials.icon name="queue-list" class="w-4 h-4 text-info" />
                                            Llistar
                                        </a>
                                    </li>
                                </ul>

                                <!-- Add Evaluation -->
                                <ul class="text-xs text-base-content/65">
                                    <li>
                                        <a href="{{ route('professional_evaluations_quiz_form') }}">
                                            <x-partials.icon name="plus" class="w-4 h-4 text-info" />
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
                    <summary class="font-normal">
                        <x-partials.icon name="rectangle-group" class="w-6 h-6 text-primary" />
                        Projectes/Comissions
                    </summary>
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{ route('projectcommissions_list') }}">
                                <x-partials.icon name="queue-list" class="w-4 h-4 text-info" />
                                Llistar
                            </a>
                        </li>
                    </ul>
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{ route('projectcommission_form') }}">
                                <x-partials.icon name="plus" class="w-4 h-4 text-info" />
                                Afegir
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
            <!-- Submenu Material-Assignments -->
            @if(in_array(Auth::user()->role ?? null, ['Directiu', 'Administració', 'Gerent']))
            <li>
                <details>
                    <summary class="font-normal">
                        <x-partials.icon name="identification" class="w-6 h-6 text-primary" />
                        Registre de Uniformitat
                    </summary>
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{ route('materialassignments_list') }}">
                                <x-partials.icon name="queue-list" class="w-4 h-4 text-info" />
                                Llistar
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('materialassignment_form') }}">
                                <x-partials.icon name="plus" class="w-4 h-4 text-info" />
                                Afegir
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
            @endif
            <!-- Submenu Complementary Services -->
            <li>
                <details>
                    <summary class="font-normal">
                        <x-partials.icon name="wrench-screwdriver" class="w-6 h-6 text-primary" />
                        Serveis Complementaris
                    </summary>
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{ route('complementaryservices_list') }}">
                                <x-partials.icon name="queue-list" class="w-4 h-4 text-info" />
                                Llistar
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('complementaryservice_form') }}">
                                <x-partials.icon name="plus" class="w-4 h-4 text-info" />
                                Afegir
                            </a>
                        </li>
                    </ul>
                </details>
            </li>

            <!-- Submenu General Services (Directiu and Administratiu only) -->
            @if(in_array(Auth::user()->role ?? null, ['Directiu', 'Administració', 'Gerent']))
            <li>
                <details>
                    <summary class="font-normal">
                        <x-partials.icon name="wrench-screwdriver" class="w-6 h-6 text-primary" />
                        Serveis Generals
                    </summary>
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{ route('general_service_show', ['service_type' => 'Cuina']) }}">
                                <x-partials.icon name="minus" class="w-4 h-4 text-info" />
                                Cuina
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('general_service_show', ['service_type' => 'Neteja']) }}">
                                <x-partials.icon name="minus" class="w-4 h-4 text-info" />
                                Neteja
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('general_service_show', ['service_type' => 'Bugaderia']) }}">
                                <x-partials.icon name="minus" class="w-4 h-4 text-info" />
                                Bugadería
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
            @endif

            <!-- Submenu Desactivations -->
            <li>
                <details>
                    <summary class="font-normal">
                        <x-partials.icon name="folder-open" class="w-6 h-6 text-gray-400" />
                        Desactivacions
                    </summary>
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{ route('centers_desactivated_list') }}">
                                <x-partials.icon name="building-office" class="w-4 h-4 text-gray-400" />
                                Centres
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('professionals_desactivated_list') }}">
                                <x-partials.icon name="user-group" class="w-4 h-4 text-gray-400" />
                                Professionals
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('projectcommissions_desactivated_list') }}">
                                <x-partials.icon name="rectangle-group" class="w-4 h-4 text-gray-400" />
                                Projectes/Comissions
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('maintenances_desactivated_list') }}">
                                <x-partials.icon name="wrench" class="w-4 h-4 text-gray-400" />
                                Mateniments
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('complementaryservices_desactivated_list') }}">
                                <x-partials.icon name="wrench-screwdriver" class="w-4 h-4 text-gray-400" />
                                Serveis Complementaris
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
