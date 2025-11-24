@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Serveis Generals' => null,    
    ]"
    :current="'Detalls'"
    />
<div class="max-w-4xl mx-auto bg-base-100 text-base-content p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Servei de {{ $service->service_type }}</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Manager information -->
        <div class="card bg-base-100 text-base-content shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Responsable</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold">Nom del responsable:</label>
                        <p class="text-lg">{{ $service->responsible ?: 'No assignat' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact information -->
        <div class="card bg-base-100 text-base-content shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació de contacte</h2>
                <div class="space-y-3">
                    <p class="text-gray-400">AÑADIR</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Staff schedule board -->
    <div class="card bg-base-100 text-base-content shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Quadre d'horaris del personal</h2>

            <div class="flex flex-wrap">
                <div class="w-full flex">
                    <button class="btn btn-sm btn-primary w-auto ml-auto" data-open-modal="addNoteModal">
                        Editar Horari
                    </button>
                </div>

                <div class="w-full">
                    <div class="overflow-x-auto mt-3">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Et odit, enim aperiam omnis provident laborum, distinctio nihil corrupti similique eaque id vel. Alias, eveniet quibusdam magni sapiente necessitatibus minus culpa?
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional information
    <div class="card bg-base-100 text-base-content shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Informació addicional</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="font-semibold">ID:</label>
                    <p class="text-lg">{{ $service->id }}</p>
                </div>
                <div>
                    <label class="font-semibold">Tipus de servei:</label>
                    <p class="text-lg">{{ $service->service_type }}</p>
                </div>
                <div>
                    <label class="font-semibold">Data de creació:</label>
                    <p class="text-lg">{{ $service->created_at ? $service->created_at->format('d/m/Y H:i') : 'No especificada' }}</p>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Documents -->
    <x-partials.documents-section
        :items="$service->documents"
        title="Documents"            
        uploadAction="{{ route('general_service_document_add', $service) }}"
        downloadRoute="general_service_document_download"
        deleteRoute="general_service_document_delete"
        uploadedByField="uploadedByProfessional"
    />

    <!-- Notes -->
    <x-partials.notes-section
        :items="$service->notes"
        title="Notes"
        addAction="{{ route('general_service_note_add', $service) }}"
        deleteRoute="general_service_note_delete"
        :editRoute="'general_service_note_update'"
        createdByField="createdByProfessional"
    />

@include('components.partials.mainToasts')
@endsection

