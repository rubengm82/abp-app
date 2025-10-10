@extends('app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Detalls de l'Assignació de Material</h1>
        <div class="flex gap-2">
            <a href="{{ route('materialassignments_list') }}" class="btn btn-sm btn-outline">Tornar a la llista</a>
            <a href="{{ route('materialassignment_edit', $materialAssignment) }}" class="btn btn-sm btn-warning">Editar</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Informació de l'assignació -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació de l'Assignació</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold text-gray-600">ID:</label>
                        <p class="text-lg">{{ $materialAssignment->id }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Data d'assignació:</label>
                        <p class="text-lg">{{ $materialAssignment->assignment_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Assignat per:</label>
                        <p class="text-lg">
                            @if($materialAssignment->assignedBy)
                                {{ $materialAssignment->assignedBy->name }} {{ $materialAssignment->assignedBy->surname1 }}
                            @else
                                No especificat
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Information about the professional -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Professional</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold text-gray-600">Nom:</label>
                        <p class="text-lg">{{ $materialAssignment->professional->name }} {{ $materialAssignment->professional->surname1 }} {{ $materialAssignment->professional->surname2 }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">DNI:</label>
                        <p class="text-lg">{{ $materialAssignment->professional->dni }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Rol:</label>
                        <p class="text-lg">{{ $materialAssignment->professional->role }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assigned sizes -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Talles Assignades</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center">
                    <label class="font-semibold text-gray-600">Samarreta:</label>
                    @if($materialAssignment->shirt_size)
                        <p class="text-2xl font-bold text-blue-600">{{ $materialAssignment->shirt_size }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
                <div class="text-center">
                    <label class="font-semibold text-gray-600">Pantaló:</label>
                    @if($materialAssignment->pants_size)
                        <p class="text-2xl font-bold text-green-600">{{ $materialAssignment->pants_size }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
                <div class="text-center">
                    <label class="font-semibold text-gray-600">Sabata:</label>
                    @if($materialAssignment->shoe_size)
                        <p class="text-2xl font-bold text-purple-600">{{ $materialAssignment->shoe_size }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- TODO: Revisar tema de documentos -->
    <!-- Observations and documents -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Informació Addicional</h2>
            <div class="space-y-4">
                <div>
                    <label class="font-semibold text-gray-600">Observacions:</label>
                    <p class="text-lg mt-2">{{ $materialAssignment->observations ?: 'No hi ha observacions' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-600">Documents relacionats:</label>
                    <p class="text-lg mt-2">{{ $materialAssignment->documents ?: 'No hi ha documents' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-600">Data de creació:</label>
                    <p class="text-lg">{{ $materialAssignment->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-600">Última actualització:</label>
                    <p class="text-lg">{{ $materialAssignment->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
