@extends('app')

@section('content')

@if((Auth::user()->role ?? null) === 'Gerent')
<x-partials.breadcrumb
    :items="[
        'Centres' => route('centers_list'),
    ]"
    :current="'Detalls'"
    />
@endif
<div class="max-w-4xl mx-auto bg-base-200 text-base-content p-6 rounded-lg shadow-xl/10 border border-gray-500/20">
    <div class="flex justify-end items-center mb-6">
        {{-- <h1 class="text-3xl font-bold">{{ $center->name }}</h1> --}}
        <!-- Buttons -->
        @if((Auth::user()->role ?? null) !== 'Tècnic')
        <div class="flex gap-2">
            <!-- Edit Center -->
            @if($center->status == 1)
                <a href="{{ route('center_edit', $center) }}" class="btn btn-sm btn-info">Editar</a>
            @endif
            @if($center->status == 1)
            <!-- Desactivate Center -->
                <div class="relative">
                    <x-partials.modal 
                        id="desactivateCenter{{ $center->id }}" 
                        msj="Estàs segur que vols desactivar aquest centre?" 
                        btnText="Desactivar" 
                        class="btn-sm btn-warning"
                    >
                        <form action="{{ route('center_desactivate', $center) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-warning">
                                Acceptar
                            </button>
                        </form>
                    </x-partials.modal>
                </div>
                <!-- Delete Center -->
                <div class="relative">
                    <x-partials.modal 
                        id="deleteCenter{{ $center->id }}" 
                        msj="Estàs segur que vols eliminar aquest centre?" 
                        btnText="Eliminar" 
                        class="btn-sm btn-error"
                    >
                        <form action="{{ route('center_delete', $center->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-error">
                                Acceptar
                            </button>
                        </form>
                    </x-partials.modal>
                </div>
            @else
                <!-- Activate Center -->
                <form action="{{ route('center_activate', $center) }}" method="POST" style="display:inline;">
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

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Basic information -->
        <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl underline underline-offset-5 mb-4">Informació bàsica</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-bold text-md">Nom del centre:</label>
                        <p class="text-base-content/50">{{ $center->name }}</p>
                    </div>
                    <div>
                        <label class="font-bold text-md">Estat:</label>
                        <p class="text-base-content/50">
                            <span class="badge badge-dash {{ $center->status == 1 ? 'badge-success' : 'badge-error' }}">
                                {{ $center->status == 1 ? 'Actiu' : 'Inactiu' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact information -->
        <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl underline underline-offset-5 mb-4">Informació de contacte</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-bold text-md">Adreça:</label>
                        <p class="text-base-content/50">{{ $center->address ?: 'No especificada' }}</p>
                    </div>
                    <div>
                        <label class="font-bold text-md">Telèfon:</label>
                        <p class="text-base-content/50">{{ $center->phone ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-bold text-md">Email:</label>
                        <p class="text-base-content/50">{{ $center->email ?: 'No especificat' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional information -->
    <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20 mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl underline underline-offset-5 mb-4">Informació addicional</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-bold text-md">Data de creació:</label>
                    <p class="text-base-content/50">{{ $center->created_at ? $center->created_at->format('d/m/Y H:i') : 'No especificada' }}</p>
                </div>
                <div>
                    <label class="font-bold text-md">Última actualització:</label>
                    <p class="text-base-content/50">{{ $center->updated_at ? $center->updated_at->format('d/m/Y H:i') : 'No especificada' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents -->
    <x-partials.documents-section
        :items="$center->documents"                                     {{-- Collection Documents --}}
        title="Documents"                                               {{-- Title --}}
        uploadAction="{{ route('center_document_add', $center) }}"      {{-- Route Add --}}
        downloadRoute="center_document_download"                        {{-- Route Download --}}
        deleteRoute="center_document_delete"                            {{-- Route Delete --}}
        uploadedByField="uploadedByProfessional"                        {{-- FK --}}
    />

    <!-- Notes  -->
    <x-partials.notes-section
        :items="$center->notes"                             {{-- Collection Notes --}}
        title="Notes"                                       {{-- Title --}}
        addAction="{{ route('center_note_add', $center) }}" {{-- Route Add --}}
        deleteRoute="center_note_delete"                    {{-- Route Delete --}}
        :editRoute="'center_note_update'"                   {{-- Route Update --}}
        createdByField="createdByProfessional"              {{-- FK --}}
    />


@include('components.partials.mainToasts')
@endsection
