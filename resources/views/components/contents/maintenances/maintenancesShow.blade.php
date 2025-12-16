@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Manteniments' => route('maintenances_list'),
    ]"
    :current="'Detalls'"
/>

<div class="max-w-4xl mx-auto bg-base-200 text-base-content p-6 rounded-lg shadow-xl/10 border border-gray-500/20">
    <div class="flex justify-end items-center mb-6">
        <div class="flex gap-2">
            <a href="{{ route('maintenance_edit', $maintenance) }}" class="btn btn-sm btn-info">Editar</a>

            <div class="relative">
                <x-partials.modal
                    id="modal_desactivate_maintenance_{{ $maintenance->id }}"
                    msj="Estàs segur que vols desactivar aquest manteniment?"
                    btnText="Desactivar"
                    class="btn-sm btn-warning"
                >
                    <form action="{{ route('maintenance_desactivate', $maintenance) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-warning">Acceptar</button>
                    </form>
                </x-partials.modal>
            </div>

            <div class="relative">
                <x-partials.modal 
                    id="modal_delete_maintenance_{{ $maintenance->id }}" 
                    msj="Estàs segur que vols eliminar aquest manteniment?" 
                    btnText="Eliminar" 
                    class="btn-sm btn-error"
                >
                    <form action="{{ route('maintenance_delete', $maintenance) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-error">Acceptar</button>
                    </form>
                </x-partials.modal>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Basic information -->
        <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació bàsica</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-bold text-md">Nom del Manteniment:</label>
                        <p class="text-sm text-base-content/50">{{ $maintenance->name_maintenance }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Maintenance details -->
        <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Detalls del manteniment</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-bold text-md">Descripció:</label>
                        <p class="text-sm text-base-content/50">{{ $maintenance->description ?: 'No especificada' }}</p>
                    </div>
                    <div>
                        <label class="font-bold text-md">Resposable del Manteniment:</label>
                        <p class="text-sm text-base-content/50">{{ $maintenance->responsible_maintenance ?: 'No assignat' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional information -->
    <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20 mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació addicional</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-bold text-md">Data d'inici</label>
                    <p class="text-sm text-base-content/50">{{ $maintenance->opening_date_maintenance ? \Carbon\Carbon::parse($maintenance->opening_date_maintenance)->format('d/m/Y') : 'No especificada' }}</p>
                </div>
                <div>
                    <label class="font-bold text-md">Data fi</label>
                    <p class="text-sm text-base-content/50">{{ $maintenance->ending_date_maintenance ? \Carbon\Carbon::parse($maintenance->ending_date_maintenance)->format('d/m/Y') : 'No especificada' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents -->
    <x-partials.documents-section
        :items="$maintenance->documents"
        title="Documents"
        uploadAction="{{ route('maintenance_document_add', $maintenance) }}"
        downloadRoute="maintenance_document_download"
        deleteRoute="maintenance_document_delete"
        uploadedByField="uploadedByProfessional"
    />

    <!-- Notes -->
    <x-partials.notes-section
        :items="$maintenance->notes"
        title="Notes"
        addAction="{{ route('maintenance_note_add', $maintenance) }}"
        deleteRoute="maintenance_note_delete"
        :editRoute="'maintenance_note_update'"
        createdByField="createdByProfessional"
    />

    @include('components.partials.mainToasts')
</div>

@endsection
