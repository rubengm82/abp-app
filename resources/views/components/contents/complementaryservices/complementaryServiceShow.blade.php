@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Serveis Complementaris' => route('complementaryservices_list'),
    ]"
    :current="'Fitxa'"
    />

<div class="max-w-4xl mx-auto bg-base-200 text-base-content p-6 rounded-lg shadow-xl/10 border border-gray-500/20">

    <!-- Header -->
    <div class="flex justify-end items-center mb-6">
        <!-- Buttons -->
        @if((Auth::user()->permissions ?? null) !== 'Tècnic')
        <div class="flex gap-2">
            <a href="{{ route('complementaryservice_edit', $complementaryService) }}" class="btn btn-sm btn-info">Editar</a>

            @if(in_array(Auth::user()->permissions ?? null, ['Direcció', 'Gerència']))
                <div class="relative">
                    @if(($complementaryService->active_status ?? 1) == 1)
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
                                <button type="submit" class="btn btn-sm btn-warning">Sí, desactivar</button>
                            </form>
                        </x-partials.modal>
                    @else
                        <form action="{{ route('complementaryservice_activate', $complementaryService) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success">Activar</button>
                        </form>
                    @endif
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
                            <button type="submit" class="btn btn-sm btn-error">Sí, eliminar</button>
                        </form>
                    </x-partials.modal>
                </div>
            @endif
        </div>
        @endif
    </div>

    <!-- Main info grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Responsable -->
        <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20 md:col-span-2">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació bàsica</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-start-1 md:row-start-1">
                        <label class="font-bold">Tipus de Servei:</label>
                        <p class="text-sm text-base-content/50">{{ $complementaryService->service_type ?? 'No especificat' }}</p>
                    </div>

                    <div class="md:col-start-1 md:row-start-2">
                        <label class="font-bold">Nom del responsable:</label>
                        <p class="text-sm text-base-content/50">{{ $complementaryService->service_responsible ?? 'No assignat' }}</p>
                    </div>

                    <div class="md:col-start-1 md:row-start-3">
                        <label class="font-bold">Estat:</label>
                        <p class="text-sm text-base-content/50">
                            @if(($complementaryService->status ?? '') === 'Obert')
                                <span class="badge badge-dash badge-warning">{{ $complementaryService->status }}</span>
                            @elseif(($complementaryService->status ?? '') === 'Tancat')
                                <span class="badge badge-dash badge-success">{{ $complementaryService->status }}</span>
                            @else
                                <span class="badge badge-dash badge-ghost">{{ $complementaryService->status ?? 'No especificat' }}</span>
                            @endif
                        </p>
                    </div>

                    <div class="md:col-start-2 md:row-start-1">
                        <label class="font-bold">Data d'inici:</label>
                        <p class="text-sm text-base-content/50">
                            {{ $complementaryService->start_date ? \Carbon\Carbon::parse($complementaryService->start_date)->format('d/m/Y') : 'No especificada' }}
                        </p>
                    </div>

                    <div class="md:col-start-2 md:row-start-2">
                        <label class="font-bold">Data fi:</label>
                        <p class="text-sm text-base-content/50">
                            {{ $complementaryService->end_date ? \Carbon\Carbon::parse($complementaryService->end_date)->format('d/m/Y') : 'No especificada' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
    
    <!-- Description -->
    <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20 mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4 underline underline-offset-5">Descripció</h2>
            <p class="text-sm text-base-content/50 break-all whitespace-pre-wrap">{{ $complementaryService->description ?: 'No hi ha descripció disponible' }}</p>
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
