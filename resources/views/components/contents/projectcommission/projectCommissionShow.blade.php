@extends('app')

@section('content')
<div class="max-w-4xl mx-auto bg-base-100 p-6 rounded shadow">
    <!-- Header: Nombre y acciones -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-base-content">{{ $projectCommission->name }}</h1>
        <div class="flex gap-2">
            @if($projectCommission->status == 'Actiu')
                <a href="{{ route('projectcommission_edit', $projectCommission) }}" class="btn btn-sm btn-info">Editar</a>
            @endif
            @if($projectCommission->status == 'Actiu')
                <x-partials.modal id="desactivateProjectCommission{{ $projectCommission->id }}" 
                    msj="Estàs segur que vols desactivar aquesta comissió?" 
                    btnText="Desactivar" class="btn-sm btn-error">
                    <a href="{{ route('projectcommission_desactivate', $projectCommission) }}" class="btn btn-sm btn-error">Acceptar</a>
                </x-partials.modal>
            @else
                <a href="{{ route('projectcommission_activate', $projectCommission) }}" class="btn btn-sm btn-success">Activar</a>
            @endif
        </div>
    </div>

    <!-- Información básica y descripción -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Información básica -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació bàsica</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold text-gray-600">Tipus:</label>
                        <p class="text-lg">{{ $projectCommission->type }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Data d'inici:</label>
                        <p class="text-lg">{{ $projectCommission->start_date ?: 'No especificada' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Data estimada de finalització:</label>
                        <p class="text-lg">{{ $projectCommission->estimated_end_date ?: 'No especificada' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Professional responsable:</label>
                        <p class="text-lg">
                            @if($projectCommission->responsibleProfessional)
                                <a href="{{ route('professional_show', $projectCommission->responsibleProfessional->id) }}" 
                                   class="text-primary font-semibold hover:text-orange-600 transition-all duration-200">
                                    {{ $projectCommission->responsibleProfessional->name }} {{ $projectCommission->responsibleProfessional->surname1 }}
                                </a>
                            @else
                                No assignat
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Centre:</label>
                        <p class="text-lg">
                            @if($projectCommission->responsibleProfessional && $projectCommission->responsibleProfessional->center)
                                <a href="{{ route('center_show', $projectCommission->responsibleProfessional->center->id) }}" 
                                   class="text-primary font-semibold hover:text-orange-600 transition-all duration-200">
                                    {{ $projectCommission->responsibleProfessional->center->name }}
                                </a>
                            @else
                                <span class="text-gray-400">No assignat</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Descripción -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Descripció</h2>
                <div>
                    <p class="text-lg break-words whitespace-pre-wrap">{{ $projectCommission->description ?: 'No hi ha descripció disponible' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Información adicional -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Informació addicional</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="font-semibold text-gray-600">ID:</label>
                    <p class="text-lg">{{ $projectCommission->id }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-600">Data de creació:</label>
                    <p class="text-lg">{{ $projectCommission->created_at ?: 'No especificada' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-600">Última actualització:</label>
                    <p class="text-lg">{{ $projectCommission->updated_at ?: 'No especificada' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents -->
    <x-partials.documents-section
        :items="$projectCommission->projectCommissionDocuments"
        title="Documents"
        uploadAction="{{ route('projectcommission_document_add', $projectCommission) }}"
        downloadRoute="projectcommission_document_download"
        deleteRoute="projectcommission_document_delete"
        uploadedByField="uploadedByProfessional"
    />

    <!-- Notes  -->
    <x-partials.notes-section
        :items="$projectCommission->projectNotes"
        title="Notes"
        addAction="{{ route('projectcommission_note_add', $projectCommission) }}"
        deleteRoute="projectcommission_note_delete"
        :editRoute="'projectcommission_note_update'"
        createdByField="createdByProfessional"
    />


@include('components.partials.mainToasts')
@endsection
