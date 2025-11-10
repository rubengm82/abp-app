@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Manteniments' => route('maintenances_list'),
    ]"
    :current="'Detalls'"
/>

<div class="max-w-4xl mx-auto bg-base-100 text-base-content p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ $maintenance->title }}</h1>
        <div class="flex gap-2">
            {{-- @if($maintenance->status == 1)
                <a href="{{ route('maintenance_edit', $maintenance) }}" class="btn btn-sm btn-info">Editar</a>
            @endif --}}
            {{-- @if($maintenance->status == 1)
                <x-partials.modal 
                    id="desactivateMaintenance{{ $maintenance->id }}" 
                    msj="Estàs segur que vols desactivar aquest manteniment?" 
                    btnText="Desactivar" 
                    class="btn-sm btn-error"
                >
                    <form action="{{ route('maintenance_desactivate', $maintenance) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-error">
                            Acceptar
                        </button>
                    </form>
                </x-partials.modal>
            @else
                <form action="{{ route('maintenance_activate', $maintenance) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-xs btn-success">
                        Activar
                    </button>
                </form>
            @endif --}}
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Basic information -->
        <div class="card shadow-xl bg-base-100 text-base-content">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació bàsica</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold">Títol:</label>
                        <p>{{ $maintenance->name_maintenance }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Centre:</label>
                        <p>
                            @if($maintenance->center)
                                <a href="{{ route('center_show', $maintenance->center) }}" class="link link-primary">
                                    {{ $maintenance->center->name }}
                                </a>
                            @else
                                No assignat
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Maintenance details -->
        <div class="card shadow-xl bg-base-100 text-base-content">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Detalls del manteniment</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold">Descripció:</label>
                        <p>{{ $maintenance->description ?: 'No especificada' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Responsable:</label>
                        <p>{{ $maintenance->responsible_maintenance ?: 'No assignat' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional information -->
    <div class="card shadow-xl bg-base-100 text-base-content mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Informació addicional</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold">Data d'inici</label>
                    <p>{{ $maintenance->opening_date_maintenance ? \Carbon\Carbon::parse($maintenance->opening_date_maintenance)->format('d/m/Y') : 'No especificada' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents -->
    {{-- <x-partials.documents-section
        :items="$maintenance->documents"
        title="Documents del manteniment"
        uploadAction="{{ route('maintenance_document_add', $maintenance) }}"
        downloadRoute="maintenance_document_download"
        deleteRoute="maintenance_document_delete"
        uploadedByField="uploadedByProfessional"
    /> --}}

    <!-- Notes -->
    {{-- <x-partials.notes-section
        :items="$maintenance->notes"
        title="Notes del manteniment"
        addAction="{{ route('maintenance_note_add', $maintenance) }}"
        deleteRoute="maintenance_note_delete"
        :editRoute="'maintenance_note_update'"
        createdByField="createdByProfessional"
    /> --}}

    @include('components.partials.mainToasts')
</div>

@endsection
