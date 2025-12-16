@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Contactes Externs' => route('externalcontacts_list'),
    ]"
    :current="'Detalls'"
    />
<div class="max-w-4xl mx-auto bg-base-200 p-6 rounded-lg shadow-xl/10 border border-gray-500/20">
    <!-- Header: Name and actions -->
    <div class="flex justify-end items-center mb-6">
        {{-- <h1 class="text-3xl font-bold text-base-content">{{ $externalContact->company ?? 'Contacte Extern #' . $externalContact->id }}</h1> --}}
        <!-- Buttons -->
        @if((Auth::user()->role ?? null) !== 'Tècnic')
        <div class="flex gap-2">
            <a href="{{ route('externalcontact_edit', $externalContact) }}" class="btn btn-sm btn-info">Editar</a>
            <x-partials.modal 
                id="deleteExternalContact{{ $externalContact->id }}" 
                msj="Estàs segur que vols eliminar aquest contacte extern?" 
                btnText="Eliminar" 
                class="btn-sm btn-error"
            >
                <form action="{{ route('externalcontact_delete', $externalContact) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-error">Acceptar</button>
                </form>
            </x-partials.modal>
        </div>
        @endif
    </div>

    <!-- Basic Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació bàsica</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-bold">Tipus:</label>
                        <p class="text-sm text-base-content/50">{{ $externalContact->external_contact_type ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-bold">Motiu / Servei:</label>
                        <p class="text-sm text-base-content/50">{{ $externalContact->service_reason ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-bold">Empresa:</label>
                        <p class="text-sm text-base-content/50">{{ $externalContact->company ?: 'No especificada' }}</p>
                    </div>
                    <div>
                        <label class="font-bold">Departament:</label>
                        <p class="text-sm text-base-content/50">{{ $externalContact->department ?: 'No especificat' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Responsable Information -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació del responsable</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-bold">Responsable:</label>
                        <p class="text-sm text-base-content/50">
                            @if($externalContact->name || $externalContact->surname)
                                {{ trim(($externalContact->name ?? '') . ' ' . ($externalContact->surname ?? '')) }}
                            @else
                                No especificat
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="font-bold">Telèfon:</label>
                        <p class="text-sm text-base-content/50">{{ $externalContact->phone ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-bold">Correu:</label>
                        <p class="text-sm text-base-content/50">
                            @if($externalContact->email)
                                <a href="mailto:{{ $externalContact->email }}" class="text-primary font-bold hover:text-orange-600 transition-all duration-200">
                                    {{ $externalContact->email }}
                                </a>
                            @else
                                No especificat
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="font-bold">Enllaç:</label>
                        <p class="text-sm text-base-content/50">
                            @if($externalContact->link)
                                <a href="{{ $externalContact->link }}" target="_blank" class="text-primary font-bold hover:text-orange-600 transition-all duration-200">
                                    {{ $externalContact->link }}
                                </a>
                            @else
                                No especificat
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Observations -->
    @if($externalContact->observations)
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4 underline underline-offset-5">Observacions</h2>
            <div>
                <p class="text-sm break-all whitespace-pre-wrap">{{ $externalContact->observations }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Additional Information -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació addicional</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="font-bold">Data de creació:</label>
                    <p class="text-sm text-base-content/50">{{ $externalContact->created_at ?: 'No especificada' }}</p>
                </div>
                <div>
                    <label class="font-bold">Última actualització:</label>
                    <p class="text-sm text-base-content/50">{{ $externalContact->updated_at ?: 'No especificada' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents -->
    <x-partials.documents-section
        :items="$externalContact->documents"
        title="Documents"
        uploadAction="{{ route('externalcontact_document_add', $externalContact) }}"
        downloadRoute="externalcontact_document_download"
        deleteRoute="externalcontact_document_delete"
        uploadedByField="uploadedByProfessional"
    />

    <!-- Notes  -->
    <x-partials.notes-section
        :items="$externalContact->notes"
        title="Notes"
        addAction="{{ route('externalcontact_note_add', $externalContact) }}"
        deleteRoute="externalcontact_note_delete"
        :editRoute="'externalcontact_note_update'"
        createdByField="createdByProfessional"
    />

@include('components.partials.mainToasts')
@endsection

