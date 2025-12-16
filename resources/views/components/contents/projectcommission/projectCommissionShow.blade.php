@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Projectes' => route('projectcommissions_list'),
    ]"
    :current="'Detalls'"
    />
<div class="max-w-4xl mx-auto bg-base-200 text-base-content p-6 rounded-lg shadow-xl/10 border border-gray-500/20">
    <!-- Header: Nombre y acciones -->
    <div class="flex justify-end items-center mb-6">
        {{-- <h1 class="text-3xl font-bold text-base-content">{{ $projectCommission->name }}</h1> --}}
        <!-- Buttons -->
        @if((Auth::user()->role ?? null) !== 'Tècnic')
        <div class="flex gap-2">
            @if($projectCommission->status == 'Actiu')
                <a href="{{ route('projectcommission_edit', $projectCommission) }}" class="btn btn-sm btn-info">Editar</a>
            @endif
            @if($projectCommission->status == 'Actiu')
                <x-partials.modal id="desactivateProjectCommission{{ $projectCommission->id }}" 
                    msj="Estàs segur que vols desactivar aquesta comissió?" 
                    btnText="Desactivar" class="btn-sm btn-error">
                    <form action="{{ route('projectcommission_desactivate', $projectCommission) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-error">
                            Acceptar
                        </button>
                    </form>
                </x-partials.modal>
            @else
                <form action="{{ route('projectcommission_activate', $projectCommission) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-success">
                        Activar
                    </button>
                </form>
            @endif
        </div>
        @endif
    </div>

    <!-- Información básica y descripción -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Información básica -->
        <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació bàsica</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-bold text-md">Nom:</label>
                        <p class="text-sm text-base-content/50">{{ $projectCommission->name }}</p>
                    </div>
                    <div>
                        <label class="font-bold text-md">Tipus:</label>
                        <p class="text-sm text-base-content/50">{{ $projectCommission->type }}</p>
                    </div>
                    <div>
                        <label class="font-bold text-md">Data d'inici:</label>
                        <p class="text-sm text-base-content/50">{{ $projectCommission->start_date ?: 'No especificada' }}</p>
                    </div>
                    <div>
                        <label class="font-bold text-md">Data estimada de finalització:</label>
                        <p class="text-sm text-base-content/50">{{ $projectCommission->estimated_end_date ?: 'No especificada' }}</p>
                    </div>
                    <div>
                        <label class="font-bold text-md">Professional responsable:</label>
                        <p class="text-sm text-base-content/50">
                            @if($projectCommission->responsibleProfessional)
                                <a href="{{ route('professional_show', $projectCommission->responsibleProfessional->id) }}"
                                   class="text-primary font-bold hover:text-orange-600 transition-all duration-200">
                                    {{ $projectCommission->responsibleProfessional->name }} {{ $projectCommission->responsibleProfessional->surname1 }}
                                </a>
                            @else
                                No assignat
                            @endif
                        </p>
                    </div>

                    <div>
                        <label class="font-bold text-md">Estat:</label>
                        <p class="text-sm text-base-content/50">
                            <span class="badge badge-dash {{ $projectCommission->status === 'Actiu' ? 'badge-success' : 'badge-error' }}">
                                {{ $projectCommission->status }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Descripción -->
        <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Descripció</h2>
                <div>
                    <p class="text-sm text-base-content/50 break-all whitespace-pre-wrap">{{ $projectCommission->description ?: 'No hi ha descripció disponible' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Información adicional -->
    <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20 mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació addicional</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="font-bold text-md">Data de creació:</label>
                    <p class="text-sm text-base-content/50">{{ $projectCommission->created_at ?: 'No especificada' }}</p>
                </div>
                <div>
                    <label class="font-bold text-md">Última actualització:</label>
                    <p class="text-sm text-base-content/50">{{ $projectCommission->updated_at ?: 'No especificada' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents -->
    <x-partials.documents-section
        :items="$projectCommission->documents"
        title="Documents"
        uploadAction="{{ route('projectcommission_document_add', $projectCommission) }}"
        downloadRoute="projectcommission_document_download"
        deleteRoute="projectcommission_document_delete"
        uploadedByField="uploadedByProfessional"
    />

    <!-- Notes  -->
    <x-partials.notes-section
        :items="$projectCommission->notes"
        title="Notes"
        addAction="{{ route('projectcommission_note_add', $projectCommission) }}"
        deleteRoute="projectcommission_note_delete"
        :editRoute="'projectcommission_note_update'"
        createdByField="createdByProfessional"
    />

    <!-- Professionals Assigned -->
    <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20 mt-6">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-xl">Equip del Projecte</h2>
                <div class="flex gap-2">
                    @if($projectCommission->assignments->count() > 0)
                        <a href="{{ route('projectcommission_downloadCSV_professionals', $projectCommission) }}" class="btn btn-sm btn-secondary">Descarregar Llistat</a>
                    @endif
                    <a href="{{ route('projectcommission_assign_professionals', $projectCommission) }}" class="btn btn-sm btn-primary">
                        Assignar professionals
                    </a>
                </div>
            </div>
            
            @if($projectCommission->assignments->count() > 0)
                <div class="space-y-3">
                    @foreach($projectCommission->assignments as $assignment)
                        <div class="p-3 bg-base-200 rounded-lg">
                            <div>
                                <a href="{{ route('professional_show', $assignment->professional->id) }}" 
                                   class="font-bold link link-hover text-info">
                                    {{ $assignment->professional->name }} {{ $assignment->professional->surname1 }} {{ $assignment->professional->surname2 }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-base-content/50">
                    <i class="fas fa-users text-4xl mb-4"></i>
                    <p class="text-sm text-base-content/50">No hi ha professionals assignats al projecte</p>
                </div>
            @endif
        </div>
    </div>

@include('components.partials.mainToasts')
@endsection
