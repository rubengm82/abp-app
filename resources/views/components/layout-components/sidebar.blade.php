<div class="w-64 fixed top-16 bottom-0 left-0 flex flex-col justify-between shadow-md bg-base-200">

    <!-- Navigation menu -->
    <nav class="flex-1 overflow-auto">
        <ul class="menu bg-base-200 w-full text-xs text-base-content">

            <!-- 1. Professionals -->
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
                    <!-- Seguiment (visible per a tots, inclòs Tècnic; les notes restringides es filtren a les pàgines) -->
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{ route('seguiment_list') }}">
                                <x-partials.icon name="clipboard-document" class="w-4 h-4 text-info" />
                                Seguiment
                            </a>
                        </li>
                    </ul>
                    <!-- Submenu Professional Accidents (Direcció and Administració only) -->
                    @if(in_array(Auth::user()->permissions ?? null, ['Direcció', 'Administració', 'Gerència']))
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

            <!-- 2. Cursos -->
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

            <!-- 3. Projectes/Comissions -->
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

            <!-- 4. Registre uniformitat -->
            @if(in_array(Auth::user()->permissions ?? null, ['Direcció', 'Administració', 'Gerència']))
            <li>
                <details>
                    <summary class="font-normal">
                        <x-partials.icon name="identification" class="w-6 h-6 text-primary" />
                        Registre uniformitat
                    </summary>
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{ route('materialassignments_list') }}">
                                <x-partials.icon name="queue-list" class="w-4 h-4 text-info" />
                                Llistar
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('materialassignments_existencies_roba_list') }}">
                                <x-partials.icon name="tag" class="w-4 h-4 text-info" />
                                Existencies Roba
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

            <!-- 5. Temes pendents amb RRHH -->
            @if((Auth::user()->permissions ?? null) === 'Direcció' || (Auth::user()->permissions ?? null) === 'Gerència')
            <li>
                <details>
                    <summary class="font-normal">
                        <x-partials.icon name="exclamation-triangle" class="w-6 h-6 text-primary" />
                        Temes pendents amb RRHH
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

            <!-- 6. Contactes Externs -->
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

            <!-- 7. Serveis complementaris -->
            <li>
                <details>
                    <summary class="font-normal">
                        <x-partials.icon name="wrench-screwdriver" class="w-6 h-6 text-primary" />
                        Serveis complementaris
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

            <!-- 8. Serveis Generals -->
            @if(in_array(Auth::user()->permissions ?? null, ['Direcció', 'Administració', 'Gerència']))
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
                                Bugaderia
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
            @endif

            <!-- 9. Estoc de Material -->
            @if(in_array(Auth::user()->permissions ?? null, ['Direcció', 'Administració', 'Gerència']))
            <li>
                <details>
                    <summary class="font-normal">
                        <x-partials.icon name="cube" class="w-6 h-6 text-primary" />
                        Estoc de Material
                    </summary>
                    <ul class="text-xs text-base-content/65">
                        <li>
                            <a href="{{ route('material_stock_items_list') }}">
                                <x-partials.icon name="queue-list" class="w-4 h-4 text-info" />
                                Llistar items
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('material_stock_movements_list') }}">
                                <x-partials.icon name="clipboard-document" class="w-4 h-4 text-info" />
                                Registre de moviments
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('material_stock_movement_form') }}">
                                <x-partials.icon name="arrow-path" class="w-4 h-4 text-info" />
                                Fer moviment
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('material_stock_item_form') }}">
                                <x-partials.icon name="plus" class="w-4 h-4 text-info" />
                                Nou Item
                            </a>
                        </li>
                    </ul>
                </details>
            </li>
            @endif

            <!-- 10. Manteniments -->
            @if(in_array(Auth::user()->permissions ?? null, ['Direcció', 'Administració', 'Gerència']))
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

            <!-- 11. Centre -->
            @if((Auth::user()->permissions ?? null) === 'Gerència')
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

            <!-- 12. Documents Globals -->
            @if(in_array(Auth::user()->permissions ?? null, ['Direcció', 'Gerència']))
            <li class="font-normal">
                <a href="{{ route('global_documents_list') }}">
                    <x-partials.icon name="document-text" class="w-6 h-6 text-primary" />
                    Documents Globals
                </a>
            </li>
            @endif

            <!-- 13. Desactivacions -->
            <li>
                <details>
                    <summary class="font-normal">
                        <x-partials.icon name="folder-open" class="w-6 h-6 text-gray-400" />
                        Desactivacions
                    </summary>
                    <ul class="text-xs text-base-content/65">
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
                            <a href="{{ route('complementaryservices_desactivated_list') }}">
                                <x-partials.icon name="wrench-screwdriver" class="w-4 h-4 text-gray-400" />
                                Serveis Complementaris
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('maintenances_desactivated_list') }}">
                                <x-partials.icon name="wrench" class="w-4 h-4 text-gray-400" />
                                Manteniments
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('centers_desactivated_list') }}">
                                <x-partials.icon name="building-office" class="w-4 h-4 text-gray-400" />
                                Centres
                            </a>
                        </li>
                        @if(in_array(Auth::user()->permissions ?? null, ['Direcció', 'Gerència']))
                        <li>
                            <a href="{{ route('documents_desactivated_list') }}">
                                <x-partials.icon name="document" class="w-4 h-4 text-gray-400" />
                                Documents
                            </a>
                        </li>
                        @endif
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
