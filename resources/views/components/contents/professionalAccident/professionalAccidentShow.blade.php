@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Accidents professionals' => route('professional_accidents_list'),
    ]"
    :current="'Detalls'"
/>
<div class="max-w-4xl mx-auto bg-base-200 text-base-content p-6 rounded-lg shadow-xl/10 border border-gray-500/20">
    <div class="flex justify-end items-center mb-6">
        {{-- <h1 class="text-3xl font-bold">Accident professional #{{ $accident->id }}</h1> --}}
        <div class="flex gap-2">
            <a href="{{ route('professional_accident_edit', $accident) }}" class="btn btn-sm btn-info">Editar</a>
            @if($accident->type === 'Amb baixa')
                <div class="relative">
                    <x-partials.modal 
                        :id="'modal_end_leave_' . $accident->id" 
                        :msj="'Estàs segur que vols finalitzar aquesta baixa? El professional serà actualitzat al seu estat laboral anterior.'"  
                        :btnText="'Finalitzar Baixa'" 
                        class="btn-sm btn-success"
                    >
                        <form action="{{ route('professional_accident_end_leave', $accident->id) }}" method="POST" id="endLeaveForm{{ $accident->id }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                Acceptar
                            </button>
                        </form>
                    </x-partials.modal>
                </div>
            @endif
            <div class="relative">
                <x-partials.modal 
                    :id="'modal_delete_accident_' . $accident->id" 
                    :msj="'Estàs segur que vols eliminar aquest accident professional?'"  
                    :btnText="'Eliminar'" 
                    class="btn-sm btn-error"
                >
                    <form action="{{ route('professional_accident_delete', $accident->id) }}" method="POST" id="deleteAccidentForm{{ $accident->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-error">
                            Acceptar
                        </button>
                    </form>
                </x-partials.modal>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Accident Information -->
        <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació de l'accident</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-bold text-md">Tipus:</label>
                        <p class="text-sm text-base-content/50">
                            <span class="badge badge-dash {{ $accident->type === 'Baixa Finalitzada' ? 'badge-success' : ($accident->type === 'Amb baixa' ? 'badge-warning' : 'badge-info') }}">
                                {{ $accident->type }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="font-bold text-md">Data:</label>
                        <p class="text-sm text-base-content/50">{{ $accident->date->format('d/m/Y') }}</p>
                    </div>
                    @if($accident->type === 'Amb baixa' || $accident->type === 'Baixa Finalitzada')
                        <div>
                            <label class="font-bold text-md">Data d'inici de la baixa:</label>
                            <p class="text-sm text-base-content/50">{{ $accident->start_date ? $accident->start_date->format('d/m/Y') : '' }}</p>
                        </div>
                        <div>
                            <label class="font-bold text-md">Data de fi de la baixa:</label>
                            <p class="text-sm text-base-content/50">{{ $accident->end_date ? $accident->end_date->format('d/m/Y') : '' }}</p>
                        </div>
                        <div>
                            <label class="font-bold text-md">Durada (dies):</label>
                            <p class="text-sm text-base-content/50">{{ $accident->duration ?? '' }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Professionals Information -->
        <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Professionals</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-bold text-md">Professional afectat:</label>
                        <p class="text-sm text-base-content/50">
                            @if($accident->affectedProfessional)
                                {{ $accident->affectedProfessional->name }} {{ $accident->affectedProfessional->surname1 }} {{ $accident->affectedProfessional->surname2 }}
                            @else
                                <span class="text-gray-400">No assignat</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="font-bold text-md">Registrat per:</label>
                        <p class="text-sm text-base-content/50">
                            @if($accident->createdByProfessional)
                                {{ $accident->createdByProfessional->name }} {{ $accident->createdByProfessional->surname1 }} {{ $accident->createdByProfessional->surname2 }}
                            @else
                                <span class="text-gray-400">No assignat</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Context -->
    @if($accident->context)
    <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20 mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4 underline underline-offset-5">Context</h2>
            <p class="text-sm text-base-content/50 break-all whitespace-pre-wrap">{{ $accident->context }}</p>
        </div>
    </div>
    @endif

    <!-- Description -->
    @if($accident->description)
    <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20 mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4 underline underline-offset-5">Descripció</h2>
            <p class="text-sm text-base-content/50 break-all whitespace-pre-wrap">{{ $accident->description }}</p>
        </div>
    </div>
    @endif

    <!-- Additional information -->
    <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20 mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació addicional</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <label class="font-bold text-md">Data de creació:</label>
                    <p class="text-sm text-base-content/50">{{ $accident->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="font-bold text-md">Última actualització:</label>
                    <p class="text-sm text-base-content/50">{{ $accident->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents -->
    <x-partials.documents-section
        :items="$accident->documents"
        title="Documents"            
        uploadAction="{{ route('professional_accident_document_add', $accident) }}"
        downloadRoute="professional_accident_document_download"
        deleteRoute="professional_accident_document_delete"
        uploadedByField="uploadedByProfessional"
    />

    <!-- Notes -->
    <x-partials.notes-section
        :items="$accident->notes"
        title="Notes"
        addAction="{{ route('professional_accident_note_add', $accident) }}"
        deleteRoute="professional_accident_note_delete"
        :editRoute="'professional_accident_note_update'"
        createdByField="createdByProfessional"
    />

@include('components.partials.mainToasts')
@endsection

