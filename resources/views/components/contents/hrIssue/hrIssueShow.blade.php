@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Temes pendents RRHH' => route('hr_issues_list'),
    ]"
    :current="'Detalls'"
    />
<div class="max-w-4xl mx-auto bg-base-100 text-base-content p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Tema pendent RRHH #{{ $hrIssue->id }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('hr_issue_edit', $hrIssue) }}" class="btn btn-sm btn-info">Editar</a>
            <x-partials.modal 
                id="deleteHrIssue{{ $hrIssue->id }}" 
                msj="Estàs segur que vols eliminar aquest tema pendent?"  
                btnText="Eliminar" 
                class="btn-sm btn-error"
            >
                <form action="{{ route('hr_issue_delete', $hrIssue) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-error">
                        Acceptar
                    </button>
                </form>
            </x-partials.modal>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Issue Information -->
        <div class="card bg-base-100 text-base-content shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació del tema pendent</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold">Data d'obertura:</label>
                        <p class="text-lg">{{ $hrIssue->opening_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Data de tancament:</label>
                        <p class="text-lg">{{ $hrIssue->closing_date ? $hrIssue->closing_date->format('d/m/Y') : 'No tancada' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Estat:</label>
                        <p class="text-lg">
                            <span class="badge badge-dash {{ $hrIssue->status === 'Tancat' ? 'badge-success' : 'badge-warning' }}">
                                {{ $hrIssue->status }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professionals Information -->
        <div class="card bg-base-100 text-base-content shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Professionals</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold">Professional afectat:</label>
                        <p class="text-lg">
                            @if($hrIssue->affectedProfessional)
                                {{ $hrIssue->affectedProfessional->name }} {{ $hrIssue->affectedProfessional->surname1 }} {{ $hrIssue->affectedProfessional->surname2 }}
                            @else
                                <span class="text-gray-400">No assignat</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="font-semibold">Registrat per:</label>
                        <p class="text-lg">
                            @if($hrIssue->registeringProfessional)
                                {{ $hrIssue->registeringProfessional->name }} {{ $hrIssue->registeringProfessional->surname1 }} {{ $hrIssue->registeringProfessional->surname2 }}
                            @else
                                <span class="text-gray-400">No assignat</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="font-semibold">Derivat a:</label>
                        <p class="text-lg">
                            @if($hrIssue->referredToProfessional)
                                {{ $hrIssue->referredToProfessional->name }} {{ $hrIssue->referredToProfessional->surname1 }} {{ $hrIssue->referredToProfessional->surname2 }}
                            @else
                                <span class="text-gray-400">No derivat</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="card bg-base-100 text-base-content shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Descripció</h2>
            <p class="text-lg break-all whitespace-pre-wrap">{{ $hrIssue->description ?: 'No hi ha descripció disponible' }}</p>
        </div>
    </div>

    <!-- Additional information -->
    <div class="card bg-base-100 text-base-content shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Informació addicional</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <label class="font-semibold">Data de creació:</label>
                    <p class="text-lg">{{ $hrIssue->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="font-semibold">Última actualització:</label>
                    <p class="text-lg">{{ $hrIssue->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents -->
    <x-partials.documents-section
        :items="$hrIssue->documents"
        title="Documents"            
        uploadAction="{{ route('hr_issue_document_add', $hrIssue) }}"
        downloadRoute="hr_issue_document_download"
        deleteRoute="hr_issue_document_delete"
        uploadedByField="uploadedByProfessional"
    />

    <!-- Notes -->
    <x-partials.notes-section
        :items="$hrIssue->notes"
        title="Notes"
        addAction="{{ route('hr_issue_note_add', $hrIssue) }}"
        deleteRoute="hr_issue_note_delete"
        :editRoute="'hr_issue_note_update'"
        createdByField="createdByProfessional"
    />

@include('components.partials.mainToasts')
@endsection

