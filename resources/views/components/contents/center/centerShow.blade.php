@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Centres' => route('centers_list'),
    ]"
    :current="'Detalls'"
    />
<div class="max-w-4xl mx-auto bg-base-100 text-base-content p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ $center->name }}</h1>
        <div class="flex gap-2">
            @if($center->status == 1)
                <a href="{{ route('center_edit', $center) }}" class="btn btn-sm btn-info">Editar</a>
            @endif
            @if($center->status == 1)
                <x-partials.modal 
                    id="desactivateCenter{{ $center->id }}" 
                    msj="Estàs segur que vols desactivar aquest centre?" 
                    btnText="Desactivar" 
                    class="btn-sm btn-error"
                >
                    <form action="{{ route('center_desactivate', $center) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-error">
                            Acceptar
                        </button>
                    </form>
                </x-partials.modal>
            @else
                <form action="{{ route('center_activate', $center) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-xs btn-success">
                        Activar
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Basic information -->
        <div class="card shadow-xl bg-base-100 text-base-content">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació bàsica</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold">Nom del centre:</label>
                        <p>{{ $center->name }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">ID:</label>
                        <p>{{ $center->id }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Estat:</label>
                        <p>
                            <span class="badge badge-dash {{ $center->status == 1 ? 'badge-success' : 'badge-error' }}">
                                {{ $center->status == 1 ? 'Actiu' : 'Inactiu' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact information -->
        <div class="card shadow-xl bg-base-100 text-base-content">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació de contacte</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold">Adreça:</label>
                        <p>{{ $center->address ?: 'No especificada' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Telèfon:</label>
                        <p>{{ $center->phone ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Email:</label>
                        <p>{{ $center->email ?: 'No especificat' }}</p>
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
                    <label class="font-semibold">Data de creació:</label>
                    <p>{{ $center->created_at ? $center->created_at->format('d/m/Y H:i') : 'No especificada' }}</p>
                </div>
                <div>
                    <label class="font-semibold">Última actualització:</label>
                    <p>{{ $center->updated_at ? $center->updated_at->format('d/m/Y H:i') : 'No especificada' }}</p>
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
