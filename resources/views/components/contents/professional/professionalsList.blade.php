@extends('app')

@section('content')
<div class="max-w-7xl mx-auto bg-white p-6 rounded shadow">
    <!-- Header con estadísticas -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Llista de professionals</h1>
            <p class="text-gray-600 mt-1">{{ $professionals->where('status', 1)->count() }} professionals actius</p>
        </div>
        
        @if($professionals->where('status', 1)->count() > 0)
        <div class="flex gap-3">
            <a href="{{ route('professionals.downloadCSV', 1) }}" class="btn btn-sm btn-outline">
                Descarregar Llista
            </a>
            <a href="{{ route('professionals.downloadCSV.materialAssignments') }}" class="btn btn-sm btn-outline">
                Descarregar Uniformitat
            </a>
            <a href="{{ route('professional_form') }}" class="btn btn-sm btn-primary">
                Afegir Professional
            </a>
        </div>
        @endif
    </div>

    @if($professionals->where('status', 1)->count() > 0)
        <!-- Controles de vista y filtros -->
        <div class="mb-6 flex flex-wrap gap-4 items-center justify-between">
            <!-- Filtros -->
            <div class="flex gap-2">
                <input type="text" id="searchInput" placeholder="Cercar professionals..." 
                       class="input input-bordered input-sm" onkeyup="filterContent()">
                
                <select id="roleFilter" class="select select-bordered select-sm" onchange="filterContent()">
                    <option value="">Tots els rols</option>
                    <option value="Directiu">Directiu</option>
                    <option value="Administració">Administració</option>
                    <option value="Tècnic">Tècnic</option>
                </select>
                
                <select id="statusFilter" class="select select-bordered select-sm" onchange="filterContent()">
                    <option value="">Tots els estats</option>
                    <option value="Actiu">Actiu</option>
                    <option value="Suplència">Suplència</option>
                    <option value="Baixa">Baixa</option>
                    <option value="No contractat">No contractat</option>
                </select>
            </div>
            
            <!-- Toggle de vista -->
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-gray-700">Vista:</span>
                <div class="btn-group">
                    <button id="tableViewBtn" class="btn btn-sm btn-active" onclick="switchView('table')">
                    ☰
                    </button>
                    <button id="cardViewBtn" class="btn btn-sm" onclick="switchView('cards')">
                    ■
                    </button>
                </div>
            </div>
        </div>

        <!-- Vista de tabla -->
        <div id="tableView" class="view-content" style="display: none;">
            <div class="overflow-x-auto">
                <table class="table table-hover w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="font-semibold">Professional</th>
                            <th class="font-semibold">Contacte</th>
                            <th class="font-semibold">Rol</th>
                            <th class="font-semibold">Estat</th>
                            <th class="font-semibold text-right">Accions</th>
                        </tr>
                    </thead>
                    <tbody id="professionalsTable">
                        @foreach ($professionals as $professional)
                            @if ($professional->status == 1)
                            <tr class="professional-row hover:bg-gray-50" 
                                data-name="{{ strtolower($professional->name . ' ' . $professional->surname1 . ' ' . $professional->surname2) }}"
                                data-email="{{ strtolower($professional->email) }}"
                                data-role="{{ $professional->role }}"
                                data-status="{{ $professional->employment_status }}">
                                
                                <td>
                                    <div class="flex items-center space-x-3">
                                        <div class="avatar placeholder">
                                            <div class="bg-primary text-primary-content rounded-full w-10">
                                                <span class="text-sm font-semibold">
                                                    {{ substr($professional->name, 0, 1) }}{{ substr($professional->surname1, 0, 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-semibold">{{ $professional->name }} {{ $professional->surname1 }}</div>
                                            @if($professional->surname2)
                                                <div class="text-sm text-gray-500">{{ $professional->surname2 }}</div>
                                            @endif
                                            <div class="text-xs text-gray-400">DNI: {{ $professional->dni }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td>
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-envelope text-gray-400 text-xs"></i>
                                            <span class="text-sm">{{ $professional->email }}</span>
                                        </div>
                                        @if($professional->phone)
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-phone text-gray-400 text-xs"></i>
                                            <span class="text-sm">{{ $professional->phone }}</span>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                
                                <td>
                                    <span class="badge badge-outline">{{ $professional->role ?: 'No assignat' }}</span>
                                </td>
                                
                                <td>
                                    <span class="badge {{ $professional->employment_status === 'Actiu' ? 'badge-success' : 'badge-warning' }}">
                                        {{ $professional->employment_status }}
                                    </span>
                                </td>
                                
                                <td class="text-right">
                                    <div class="flex justify-end gap-1">
                                        <a href="{{ route('professional_show', $professional->id) }}" 
                                           class="btn btn-xs btn-info" title="Veure">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('professional_edit', $professional->id) }}" 
                                           class="btn btn-xs btn-warning" title="Editar">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <a href="{{ route('professional_desactivate', $professional->id) }}" 
                                           class="btn btn-xs btn-error" title="Desactivar"
                                           onclick="return confirm('Estàs segur que vols desactivar aquest professional?')">
                                            <i class="fa-solid fa-user-slash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Vista de tarjetas -->
        <div id="cardsView" class="view-content" style="display: none;">
            <div id="professionalsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($professionals as $professional)
                    @if ($professional->status == 1)
                    <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow duration-300 professional-card" 
                         data-name="{{ strtolower($professional->name . ' ' . $professional->surname1 . ' ' . $professional->surname2) }}"
                         data-email="{{ strtolower($professional->email) }}"
                         data-role="{{ $professional->role }}"
                         data-status="{{ $professional->employment_status }}">
                        <div class="card-body">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="card-title text-lg">{{ $professional->name }} {{ $professional->surname1 }}</h3>
                                    @if($professional->surname2)
                                        <p class="text-sm text-gray-600">{{ $professional->surname2 }}</p>
                                    @endif
                                </div>
                                <div class="badge {{ $professional->employment_status === 'Actiu' ? 'badge-success' : 'badge-warning' }}">
                                    {{ $professional->employment_status }}
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-id-card text-gray-400 w-4"></i>
                                    <span class="text-sm">{{ $professional->dni }}</span>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-envelope text-gray-400 w-4"></i>
                                    <span class="text-sm">{{ $professional->email }}</span>
                                </div>
                                
                                @if($professional->phone)
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-phone text-gray-400 w-4"></i>
                                    <span class="text-sm">{{ $professional->phone }}</span>
                                </div>
                                @endif
                                
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-briefcase text-gray-400 w-4"></i>
                                    <span class="text-sm">{{ $professional->role ?: 'No assignat' }}</span>
                                </div>
                            </div>

                            <div class="card-actions justify-end mt-4 pt-4 border-t border-gray-200">
                                <a href="{{ route('professional_show', $professional->id) }}" 
                                   class="btn btn-sm btn-info">
                                    Veure
                                </a>
                                <a href="{{ route('professional_edit', $professional->id) }}" 
                                   class="btn btn-sm btn-warning">
                                    Editar
                                </a>
                                <a href="{{ route('professional_desactivate', $professional->id) }}" 
                                   class="btn btn-sm btn-error"
                                   onclick="return confirm('Estàs segur que vols desactivar aquest professional?')">
                                    Desactivar
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    @else
        <!-- Estado vacío -->
        <div class="text-center py-16">
            <div class="text-gray-400 text-lg mb-6">
                <svg class="w-20 h-20 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-semibold text-gray-600 mb-3">Encara no hi ha professionals registrats</h3>
            <p class="text-gray-500 mb-6">Comença afegint el primer professional a la base de dades.</p>
            <a href="{{ route('professional_form') }}" class="btn btn-primary btn-lg">
                Afegir Primer Professional
            </a>
        </div>
    @endif
</div>

<script>
// Obtener vista actual del localStorage o usar 'table' por defecto
let currentView = localStorage.getItem('professionalsListView') || 'table';

// Mostrar la vista correcta inmediatamente para evitar flash
(function() {
    const tableView = document.getElementById('tableView');
    const cardsView = document.getElementById('cardsView');
    
    if (currentView === 'table') {
        if (tableView) tableView.style.display = '';
        if (cardsView) cardsView.style.display = 'none';
    } else {
        if (tableView) tableView.style.display = 'none';
        if (cardsView) cardsView.style.display = '';
    }
})();

// Función para cambiar vista y guardar en localStorage
function switchView(view) {
    currentView = view;
    
    // Guardar preferencia en localStorage
    localStorage.setItem('professionalsListView', view);
    
    // Actualizar botones
    document.getElementById('tableViewBtn').classList.toggle('btn-active', view === 'table');
    document.getElementById('cardViewBtn').classList.toggle('btn-active', view === 'cards');
    
    // Mostrar/ocultar vistas
    document.getElementById('tableView').style.display = view === 'table' ? '' : 'none';
    document.getElementById('cardsView').style.display = view === 'cards' ? '' : 'none';
    
    // Aplicar filtros a la vista actual
    filterContent();
}

// Inicializar botones al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    // Actualizar estado de botones
    document.getElementById('tableViewBtn').classList.toggle('btn-active', currentView === 'table');
    document.getElementById('cardViewBtn').classList.toggle('btn-active', currentView === 'cards');
});

function filterContent() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const roleFilter = document.getElementById('roleFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    
    if (currentView === 'table') {
        const rows = document.querySelectorAll('.professional-row');
        rows.forEach(row => {
            const name = row.getAttribute('data-name');
            const email = row.getAttribute('data-email');
            const role = row.getAttribute('data-role');
            const status = row.getAttribute('data-status');
            
            const matchesSearch = name.includes(searchInput) || email.includes(searchInput);
            const matchesRole = !roleFilter || role === roleFilter;
            const matchesStatus = !statusFilter || status === statusFilter;
            
            if (matchesSearch && matchesRole && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    } else {
        const cards = document.querySelectorAll('.professional-card');
        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            const email = card.getAttribute('data-email');
            const role = card.getAttribute('data-role');
            const status = card.getAttribute('data-status');
            
            const matchesSearch = name.includes(searchInput) || email.includes(searchInput);
            const matchesRole = !roleFilter || role === roleFilter;
            const matchesStatus = !statusFilter || status === statusFilter;
            
            if (matchesSearch && matchesRole && matchesStatus) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }
}
</script>

@include('components.layout.mainToasts')
@endsection
