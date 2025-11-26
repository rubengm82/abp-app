@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Serveis Complementaris' => route('complementaryservices_list'),
    ]"
    :current="'Detalls'"
/>

<div class="max-w-4xl mx-auto bg-base-100 text-base-content p-6 rounded shadow">

    <!-- Header -->
    <div class="flex justify-end items-center mb-6">
        <div class="flex gap-2">
            <a href="{{ route('complementaryservice_edit', $complementaryService) }}" class="btn btn-sm btn-info">Editar</a>

            <div class="relative">
                <x-partials.modal 
                    id="modal_desactivate_complementary_service_{{ $complementaryService->id }}" 
                    msj="Estàs segur que vols desactivar aquest servei complementari?" 
                    btnText="Desactivar" 
                    class="btn-sm btn-warning"
                    width="100"
                >
                    <form action="{{ route('complementaryservice_desactivate', $complementaryService) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-warning">Acceptar</button>
                    </form>
                </x-partials.modal>
            </div>

            <div class="relative">
                <x-partials.modal 
                    id="modal_delete_complementary_service_{{ $complementaryService->id }}" 
                    msj="Estàs segur que vols eliminar aquest servei complementari?" 
                    btnText="Eliminar" 
                    class="btn-sm btn-error"
                    width="100"
                >
                    <form action="{{ route('complementaryservice_delete', $complementaryService) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-error">Acceptar</button>
                    </form>
                </x-partials.modal>
            </div>
        </div>
    </div>

    <!-- Main info grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Responsable -->
        <div class="card bg-base-100 text-base-content shadow-xl">
            <div class="card-body">
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold">Tipus de Servei:</label>
                        <p class="text-lg">{{ $complementaryService->service_type ?? 'No especificat' }}</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold">Nom del responsable:</label>
                        <p class="text-lg">{{ $complementaryService->service_responsible ?? 'No assignat' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start Date -->
        <div class="card bg-base-100 text-base-content shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold" >Data d'inici:</label>
                        <p class="text-lg">
                            {{ $complementaryService->start_date ? \Carbon\Carbon::parse($complementaryService->start_date)->format('d/m/Y') : 'No especificada' }}
                        </p>
                    </div>
                    <div>
                        <label class="font-semibold" >Data fi:</label>
                        <p class="text-lg">
                            {{ $complementaryService->end_date ? \Carbon\Carbon::parse($complementaryService->end_date)->format('d/m/Y') : 'No especificada' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

   <!-- Documents -->
    @if(isset($complementaryService->documents))
        <x-partials.documents-section
            :items="$complementaryService->documents"
            title="Documents"
            uploadAction="{{ route('complementaryservices_document_add', $complementaryService) }}"
            downloadRoute="complementaryservices_document_download"
            deleteRoute="complementaryservices_document_delete"
            uploadedByField="uploadedByProfessional"
        />
    @endif

    <!-- Notes -->
    @if(isset($complementaryService->notes))
        <x-partials.notes-section
            :items="$complementaryService->notes"
            title="Notes"
            addAction="{{ route('complementaryservices_note_add', $complementaryService) }}"
            deleteRoute="complementaryservices_note_delete"
            :editRoute="'complementaryservices_note_update'"
            createdByField="createdByProfessional"
        />
    @endif

    @include('components.partials.mainToasts')

</div>
@endsection
