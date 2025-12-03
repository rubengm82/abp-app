@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Uniformitat' => route('materialassignments_list'),
    ]"
    :current="'Detalls'"
    />
<div class="max-w-4xl mx-auto bg-base-100 text-base-content p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Detalls de l'Assignació de Material</h1>
        <div class="flex gap-2">
            <a href="{{ route('materialassignment_edit', $materialAssignment) }}" class="btn btn-sm btn-info">Editar</a>
            <x-partials.modal id="deleteAssignment{{ $materialAssignment->id }}" msj="Estàs segur que vols eliminar aquesta assignació?" btnText="Eliminar" class="btn-sm btn-error">
                <form action="{{ route('materialassignment_delete', $materialAssignment) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-error">Acceptar</button>
                </form>
            </x-partials.modal>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Assignment information -->
        <div class="card bg-base-100 text-base-content shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació de l'Assignació</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold">Data d'assignació:</label>
                        <p>{{ $materialAssignment->assignment_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Assignat per:</label>
                        <p>
                            @if($materialAssignment->assignedBy)
                                {{ $materialAssignment->assignedBy->name }} {{ $materialAssignment->assignedBy->surname1 }}
                            @else
                                No especificat
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Information about the professional -->
        <div class="card bg-base-100 text-base-content shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Professional</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold">Nom:</label>
                        <p>{{ $materialAssignment->professional->name }} {{ $materialAssignment->professional->surname1 }} {{ $materialAssignment->professional->surname2 }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">DNI:</label>
                        <p>{{ $materialAssignment->professional->dni }}</p>
                    </div>
                    <div>
                        <label class="font-semibold">Rol:</label>
                        <p>{{ $materialAssignment->professional->role }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assigned sizes -->
    <div class="card bg-base-100 text-base-content shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Talles Assignades</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center">
                    <label class="font-semibold">Samarreta:</label>
                    @if($materialAssignment->shirt_size)
                        <p class="text-2xl font-bold text-blue-600">{{ $materialAssignment->shirt_size }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
                <div class="text-center">
                    <label class="font-semibold">Pantaló:</label>
                    @if($materialAssignment->pants_size)
                        <p class="text-2xl font-bold text-green-600">{{ $materialAssignment->pants_size }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
                <div class="text-center">
                    <label class="font-semibold">Sabata:</label>
                    @if($materialAssignment->shoe_size)
                        <p class="text-2xl font-bold text-purple-600">{{ $materialAssignment->shoe_size }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Observations and documents -->
    <div class="card bg-base-100 text-base-content shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Informació Addicional</h2>
            <div class="space-y-4">
                <div>
                    <label class="font-semibold">Observacions:</label>
                    <p class="mt-2 break-all overflow-wrap-anywhere">{{ $materialAssignment->observations ?: 'No hi ha observacions' }}</p>
                </div>
                <div>
                    <label class="font-semibold">Data de creació:</label>
                    <p>{{ $materialAssignment->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="font-semibold">Última actualització:</label>
                    <p>{{ $materialAssignment->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div>
        @if ($materialAssignment->signature)
            <div class="card bg-base-100 text-base-content shadow-xl mt-6">
                <div class="card-body">
                    <div class="flex justify-between items-center">
                        <h2 class="card-title text-xl">Signatura del professional del material assignat</h2>
                        <div class="relative">
                            <x-partials.modal 
                                id="deleteSignature{{ $materialAssignment->id }}" 
                                msj="Estàs segur que vols eliminar aquesta signatura?" 
                                btnText="Eliminar Signatura" 
                                class="btn-sm btn-error"
                            >
                                <form action="{{ route('materialassignment_delete_signature', $materialAssignment->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-error">Acceptar</button>
                                </form>
                            </x-partials.modal>
                        </div>
                    </div>
                    <div class="flex justify-center w-full">
                        <img src="{{ route('materialassignment_show_signature', $materialAssignment) }}" alt="signatura_material">
                    </div>
                </div>
            </div>
        @else
            <div class="card bg-base-100 text-base-content shadow-xl mt-6">
                <div class="card-body">
                    <div class="flex justify-between items-center">
                        <h2 class="card-title text-xl">Signatura del professional del material assignat</h2>
                        <a href="{{ route('materialassignment_edit', ['materialAssignment' => $materialAssignment, 'signatura' => 1]) }}" class="btn btn-sm btn-warning">Afegir Signatura</a>
                    </div>
                    <div class="space-y-4">
                        <p>Aquesta assignació del material no té cap signatura</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

   <!-- Documents -->
    <x-partials.documents-section
        :items="$materialAssignment->documents"
        title="Documents"                                   
        uploadAction="{{ route('materialassignment_document_add', $materialAssignment) }}"
        downloadRoute="materialassignment_document_download"
        deleteRoute="materialassignment_document_delete"                      
        uploadedByField="uploadedByProfessional"                          
    />

    <!-- Notes  -->
    <x-partials.notes-section
        :items="$materialAssignment->notes"
        title="Notes"
        addAction="{{ route('materialassignment_note_add', $materialAssignment) }}"
        deleteRoute="materialassignment_note_delete"
        :editRoute="'materialassignment_note_update'"
        createdByField="createdByProfessional"
    />


@include('components.partials.mainToasts')
@endsection
