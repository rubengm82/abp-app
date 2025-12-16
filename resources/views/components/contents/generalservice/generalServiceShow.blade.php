@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Serveis Generals' => null,
    ]"
    :current="'Detalls'"
    />
<div class="max-w-4xl mx-auto bg-base-200 text-base-content p-6 rounded-lg shadow-xl/10 border border-gray-500/20">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Servei de {{ $service->service_type }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('general_service_edit', $service) }}" class="btn btn-sm btn-info">Editar</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Manager information -->
        <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Responsable</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-bold">Nom del responsable:</label>
                        <p class="text-lg">{{ $service->responsible ?: 'No assignat' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact information -->
        <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació de contacte</h2>
                <div class="space-y-3">
                    <pre class="whitespace-pre-line font-sans">
                        {{ $service->responsible_info }}
                    </pre>
                </div>
            </div>
        </div>
    </div>

    <!-- Staff schedule board -->
    <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20 mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4 underline underline-offset-5">Quadre d'horaris del personal</h2>

            <div class="flex flex-wrap">
                <div class="w-full">
                    <pre class="whitespace-pre-line font-sans">
                        {{ $service->planning ?: 'No assignat' }}
                    </pre>
                </div>
            </div>
        </div>
    </div>

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
