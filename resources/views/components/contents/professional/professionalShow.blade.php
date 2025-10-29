@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Professionals' => route('professionals_list'),
    ]"
    :current="'Detalls'"
    />
<div class="max-w-4xl mx-auto bg-base-100 text-base-content p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}</h1>
        <div class="flex gap-2">
            @if($professional->status == 1)
                <a href="{{ route('professional_edit', $professional) }}" class="btn btn-sm btn-info">Editar</a>
            @endif
            @if($professional->status == 1)
                <x-partials.modal id="desactivateProfessional{{ $professional->id }}" msj="Estàs segur que vols desactivar aquest professional?"  btnText="Desactivar" class="btn-sm btn-error">
                    <a href="{{ route('professional_desactivate', $professional) }}" class="btn btn-sm btn-error">
                        Acceptar
                    </a>
                </x-partials.modal>
            @else
                <a href="{{ route('professional_activate', $professional) }}" class="btn btn-sm btn-success">Activar</a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Personal information -->
        <div class="card bg-base-100 text-base-content shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació personal</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold">Nom complet:</label>
                        <p class="text-lg">{{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">DNI:</label>
                        <p class="text-lg">{{ $professional->dni }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Centre:</label>
                        <p class="text-lg">
                            @if($professional->center)
                                <a href="{{ route('center_show', $professional->center->id) }}" class="text-primary font-semibold hover:text-orange-600 transition-all duration-200">
                                    {{ $professional->center->name }}
                                </a>
                            @else
                                <span class="text-gray-400">No assignat</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="font-semibold">Rol:</label>
                        <p class="text-lg">{{ $professional->role ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Estat laboral:</label>
                        <p class="text-lg">
                            <span class="badge {{ $professional->employment_status === 'Actiu' ? 'badge-success' : 'badge-warning' }}">
                                {{ $professional->employment_status ?: 'No especificat' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact information -->
        <div class="card bg-base-100 text-base-content shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació de contacte</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold">Telèfon:</label>
                        <p class="text-lg">{{ $professional->phone ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Email:</label>
                        <p class="text-lg">{{ $professional->email ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Adreça:</label>
                        <p class="text-lg">{{ $professional->address ?: 'No especificada' }}</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Curriculum Vitae -->
    <div class="card bg-base-100 text-base-content shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Currículum Vitae</h2>
            <p class="text-lg break-words whitespace-pre-wrap">{{ $professional->cvitae ?: 'No hi ha currículum disponible' }}</p>
        </div>
    </div>

    <!-- Additional information -->
    <div class="card bg-base-100 text-base-content shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Informació addicional</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <label class="font-semibold">ID:</label>
                    <p class="text-lg">{{ $professional->id }}</p>
                </div>
                <div>
                    <label class="font-semibold">Usuari de login:</label>
                    <p class="text-lg">{{ $professional->user ?: 'No especificat' }}</p>
                </div>
                <div>
                    <label class="font-semibold">Taquilla:</label>
                    <p class="text-lg">{{ $professional->locker_num ?: 'No especificat' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Material Assignments -->
    <div class="card bg-base-100 text-base-content shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Uniformitat Assignada</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center">
                    <label class="font-semibold">Samarreta:</label>
                    @if($shirtSize)
                        <p class="text-2xl font-bold text-blue-600">{{ $shirtSize }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
                <div class="text-center">
                    <label class="font-semibold">Pantaló:</label>
                    @if($pantsSize)
                        <p class="text-2xl font-bold text-green-600">{{ $pantsSize }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
                <div class="text-center">
                    <label class="font-semibold">Sabata:</label>
                    @if($shoeSize)
                        <p class="text-2xl font-bold text-purple-600">{{ $shoeSize }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Documents -->
    <x-partials.documents-section
        :items="$professional->documents"
        title="Documents"            
        uploadAction="{{ route('professional_document_add', $professional) }}"
        downloadRoute="professional_document_download"
        deleteRoute="professional_document_delete"
        uploadedByField="uploadedByProfessional"
    />

    <!-- Notes -->
    <x-partials.notes-section
    :items="$professional->notes"
    title="Notes"
    addAction="{{ route('professional_note_add', $professional) }}"
    deleteRoute="professional_note_delete"
    :editRoute="'professional_note_update'"
    createdByField="createdByProfessional"
    />


@include('components.partials.mainToasts')
@endsection
