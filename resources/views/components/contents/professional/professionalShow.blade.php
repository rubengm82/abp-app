@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Professionals' => route('professionals_list'),
    ]"
    :current="'Detalls'"
    />
<div class="max-w-4xl mx-auto bg-base-200 text-base-content p-6 rounded-lg shadow-xl/10 border border-gray-500/20">
    <div class="flex justify-end items-center mb-6">
        {{-- <h1 class="text-3xl font-bold text-md">{{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}</h1> --}}
        <!-- Buttons -->
        @if((Auth::user()->role ?? null) !== 'Tècnic')
        <div class="flex gap-2">
            @if($professional->status == 1)
                <a href="{{ route('professional_edit', $professional) }}" class="btn btn-sm btn-secondary">Editar</a>
            @endif
            @if($professional->status == 1)
                <x-partials.modal 
                    id="desactivateProfessional{{ $professional->id }}" 
                    msj="Estàs segur que vols desactivar aquest professional?"  
                    btnText="Desactivar" 
                    class="btn-sm btn-error"
                >
                    <form action="{{ route('professional_desactivate', $professional) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-error">
                            Acceptar
                        </button>
                    </form>
                </x-partials.modal>
            @else
                <form action="{{ route('professional_activate', $professional->id) }}" method="POST" style="display:inline;">
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
        <!-- Personal information -->
        <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl underline underline-offset-5 mb-4">Informació Personal</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-bold text-md">Nom complet:</label>
                        <p class="text-sm text-base-content/50">{{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}</p>
                    </div>
                    <div>
                        <label class="font-bold text-md">DNI:</label>
                        <p class="text-sm text-base-content/50">{{ $professional->dni }}</p>
                    </div>
                    <div>
                        <label class="font-bold text-md">Rol:</label>
                        <p class="text-sm text-base-content/50">{{ $professional->role ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-bold text-md">Estat laboral:</label>
                        <p class="text-sm text-base-content/50 mt-1">
                            <span class="badge badge-dash {{ $professional->employment_status === 'Actiu' ? 'badge-success' : 'badge-warning' }}">
                                {{ $professional->employment_status ?: 'No especificat' }}
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
                        <label class="font-bold text-md">Telèfon:</label>
                        <p class="text-sm text-base-content/50">{{ $professional->phone ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-bold text-md">Email:</label>
                        <p class="text-sm text-base-content/50">{{ $professional->email ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-bold text-md">Adreça:</label>
                        <p class="text-sm text-base-content/50">{{ $professional->address ?: 'No especificada' }}</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Curriculum Vitae -->
    <div class="card bg-base-100 text-base-content shadow-xl/10 mt-6 border border-gray-500/20">
        <div class="card-body">
            <h2 class="card-title text-xl underline underline-offset-5 mb-4">Currículum Vitae</h2>
            <p class="text-sm text-base-content/50 break-all whitespace-pre-wrap">{{ $professional->cvitae ?: 'No hi ha currículum disponible' }}</p>
        </div>
    </div>

    <!-- Additional information -->
    <div class="card bg-base-100 text-base-content shadow-xl/10 mt-6 border border-gray-500/20">
        <div class="card-body">
            <h2 class="card-title text-xl underline underline-offset-5 mb-4">Informació addicional</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <label class="font-bold text-md">Usuari de login:</label>
                    <p class="text-sm text-base-content/50">{{ $professional->user ?: 'No especificat' }}</p>
                </div>
                <div>
                    <label class="font-bold text-md">Taquilla:</label>
                    <p class="text-sm text-base-content/50">{{ $professional->locker_num ?: 'No especificat' }}</p>
                </div>
                <div>
                    <label class="font-bold text-md">Clau Codi:</label>
                    <p class="text-sm text-base-content/50">{{ $professional->key_code ?: 'No especificat' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Material Assignments -->
    <div class="card bg-base-100 text-base-content shadow-xl/10 mt-6 border border-gray-500/20">
        <div class="card-body">
            <h2 class="card-title text-xl underline underline-offset-5 mb-4">Uniformitat Assignada</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center">
                    <label class="font-bold text-md">Samarreta:</label>
                    @if($shirtSize)
                        <p class="text-2xl font-bold text-md text-primary">{{ $shirtSize }}</p>
                    @else
                        <p class="text-sm text-base-content/50">No assignat</p>
                    @endif
                </div>
                <div class="text-center">
                    <label class="font-bold text-md">Pantaló:</label>
                    @if($pantsSize)
                        <p class="text-2xl font-bold text-md text-secondary">{{ $pantsSize }}</p>
                    @else
                        <p class="text-sm text-base-content/50">No assignat</p>
                    @endif
                </div>
                <div class="text-center">
                    <label class="font-bold text-md">Sabata:</label>
                    @if($shoeSize)
                        <p class="text-2xl font-bold text-md text-error">{{ $shoeSize }}</p>
                    @else
                        <p class="text-sm text-base-content/50">No assignat</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Projects Assigned -->
    <div class="card bg-base-100 shadow-xl/10 mt-6 border border-gray-500/20">
        <div class="card-body">
            <h2 class="card-title text-xl underline underline-offset-5 mb-4">Projectes asignats</h2>
            
            @if($professional->assignedProjects->count() > 0)
                <div class="space-y-3">
                    @foreach($professional->assignedProjects as $project)
                        <div class="p-3 bg-base-200 rounded-lg">
                            <div>
                                <a href="{{ route('projectcommission_show', $project->id) }}" 
                                   class="font-semibold text-md link link-hover text-info">
                                    {{ $project->name }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-base-content/50">
                    <i class="fas fa-folder text-4xl mb-4"></i>
                    <p class="text-sm text-base-content/50">No hi ha projectes asignats</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Courses Assigned -->
    <div class="card bg-base-100 shadow-xl/10 mt-6 border border-gray-500/20">
        <div class="card-body">
            <h2 class="card-title text-xl underline underline-offset-5 mb-4">Cursos asignats</h2>
            
            @if($professional->assignedCourses->count() > 0)
                <div class="space-y-3">
                    @foreach($professional->assignedCourses as $course)
                        <div class="p-3 bg-base-200 rounded-lg flex items-center justify-between">
                            <div>
                                <a href="{{ route('course_show', $course->id) }}" class="font-semibold text-md link link-hover text-info">
                                    {{ $course->training_name }}
                                </a>
                            </div>

                            <div class="flex items-center gap-2">
                                <span class="badge badge-dash {{ $course->pivot->certificate === 'Entregat' ? 'badge-success' : 'badge-warning' }}">
                                    {{ $course->pivot->certificate ?? 'Pendent' }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                </div>
            @else
                <p class="text-gray-500">No hi ha cursos asignats.</p>
            @endif
            
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
