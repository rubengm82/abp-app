@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Professionals' => route('professionals_list'),
    ]"
    :current="'Fitxa'"
    />
<div class="max-w-4xl mx-auto bg-base-200 text-base-content p-6 rounded-lg shadow-xl/10 border border-gray-500/20">
    <div class="flex justify-end items-center mb-6">
        {{-- <h1 class="text-3xl font-bold">{{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}</h1> --}}
        <!-- Buttons -->
        @if((Auth::user()->permissions ?? null) !== 'Tècnic')
        <div class="flex gap-2">
            @if($professional->status == 1)
                <a href="{{ route('professional_edit', $professional) }}" class="btn btn-sm btn-info">Editar</a>
            @endif
            @if(in_array(Auth::user()->permissions ?? null, ['Direcció', 'Gerència']))
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
            @endif
        </div>
        @endif
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Personal information -->
        <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl underline underline-offset-5 mb-4">Informació personal</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-bold text-md">Nom complet:</label>
                        <p class="text-sm text-base-content/50">{{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}</p>
                    </div>
                    <div>
                        <label class="font-bold text-md">Permisos:</label>
                        <p class="text-sm text-base-content/50">{{ $professional->permissions ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-bold text-md">Rol:</label>
                        <p class="text-sm text-base-content/50">{{ $professional->role ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-bold text-md">Estat laboral:</label>
                        <p class="text-sm text-base-content/50 mt-1">
                            <span class="badge badge-dash
                                @if($professional->employment_status === 'Fixe') badge-info
                                @elseif($professional->employment_status === 'Eventual') badge-success
                                @elseif($professional->employment_status === 'Suplent habitual') badge-warning
                                @else badge-error
                                @endif">
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
    <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20 mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl underline underline-offset-5 mb-4">Currículum Vitae</h2>
            <p class="text-sm text-base-content/50 break-all whitespace-pre-wrap">{{ $professional->cvitae ?: 'No hi ha nota del currículum.' }}</p>
            <p class="mt-4 flex items-center gap-2 flex-wrap">
                @if($professional->cv_file_path)
                    <span class="text-sm text-base-content/60">Descarregar currículum</span>
                    <a href="{{ route('professional_cv_download', $professional) }}" class="link link-info font-medium">{{ $professional->cv_file_original_name ?? basename($professional->cv_file_path) }}</a>
                @else
                    <span class="text-sm text-base-content/50">No hi ha fitxer disponible</span>
                @endif
            </p>
        </div>
    </div>

    <!-- Material Assignments -->
    <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20 mt-6">
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
                                    class="font-bold text-md link link-hover text-info text-info">
                                    {{ $project->name }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No hi ha projectes asignats.</p>
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
                                <a href="{{ route('course_show', $course->id) }}" class="font-bold text-md link link-hover text-info text-info">
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

    <!-- Seguiment (restricted notes only visible to Direcció/Gerència; last note in block respects this) -->
    <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20 mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl underline underline-offset-5 mb-4">
                <a href="{{ route('seguiment_show', $professional) }}" class="link link-info underline decoration-info hover:decoration-info">Veure seguiment complet</a>
            </h2>
            @if($lastNote ?? null)
                <div class="bg-base-200 p-4 rounded-lg border-l-4 {{ !empty($lastNote->restricted) ? 'border-primary' : 'border-info' }}">
                    <div class="text-sm text-base-content/70 mb-2">
                        <strong>
                            {{ $lastNote->createdByProfessional?->name ?? 'Usuari desconegut' }}
                            {{ $lastNote->createdByProfessional?->surname1 ?? '' }}
                        </strong>
                        <span class="ml-2">{{ $lastNote->created_at?->format('d/m/Y H:i') ?? '' }}</span>
                    </div>
                    <p class="text-sm text-base-content break-all whitespace-pre-wrap">{{ $lastNote->notes ?? $lastNote->text ?? '' }}</p>
                </div>
            @else
                <p class="text-sm text-base-content/50">No hi ha notes de seguiment.</p>
            @endif
        </div>
    </div>

    <!-- Avaluacions -->
    <div class="card bg-base-100 text-base-content shadow-xl/10 mt-6 border border-gray-500/20">
        <div class="card-body">
            <h2 class="card-title text-xl underline underline-offset-5 mb-2">Avaluacions</h2>
            @if($evaluationAverage !== null || ($lastEvaluationRow && $lastEvaluationAverage !== null))
                <div class="space-y-4">
                    @if($lastEvaluationRow && $lastEvaluationAverage !== null)
                        <div>
                            <a href="{{ route('professional_evaluation_quiz_show', [
                                $professional->id,
                                $lastEvaluationRow->evaluator_professional_id,
                                $lastEvaluationRow->evaluation_uuid,
                            ]) }}" class="font-bold text-md link link-info hover:decoration-info">Promig última avaluació:</a>
                            <p class="mt-1 font-bold text-lg
                                @if(($lastEvaluationAverage ?? 0) <= 25) text-error
                                @elseif(($lastEvaluationAverage ?? 0) <= 50) text-warning
                                @elseif(($lastEvaluationAverage ?? 0) <= 75) text-info
                                @else text-success
                                @endif">
                                @if(($lastEvaluationAverage ?? 0) <= 25)
                                    Gens d'acord
                                @elseif(($lastEvaluationAverage ?? 0) <= 50)
                                    Poc d'acord
                                @elseif(($lastEvaluationAverage ?? 0) <= 75)
                                    Bastant d'acord
                                @else
                                    Molt d'acord
                                @endif
                                ({{ $lastEvaluationAverage }}%)
                            </p>
                        </div>
                    @endif
                    @if($evaluationAverage !== null)
                        <div>
                            <label class="font-bold text-md">Promig de totes les avaluacions:</label>
                            <p class="mt-1 font-bold text-lg
                                @if(($evaluationAverage ?? 0) <= 25) text-error
                                @elseif(($evaluationAverage ?? 0) <= 50) text-warning
                                @elseif(($evaluationAverage ?? 0) <= 75) text-info
                                @else text-success
                                @endif">
                                @if(($evaluationAverage ?? 0) <= 25)
                                    Gens d'acord
                                @elseif(($evaluationAverage ?? 0) <= 50)
                                    Poc d'acord
                                @elseif(($evaluationAverage ?? 0) <= 75)
                                    Bastant d'acord
                                @else
                                    Molt d'acord
                                @endif
                                ({{ $evaluationAverage }}%)
                            </p>
                        </div>
                    @endif
                </div>
            @else
                <p class="text-base-content/50">No hi ha avaluacions.</p>
            @endif
        </div>
    </div>

    <!-- Informació addicional -->
    <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20 mt-6">
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
                <div>
                    <label class="font-bold text-md">DNI:</label>
                    <p class="text-sm text-base-content/50">{{ $professional->dni ?: 'No especificat' }}</p>
                </div>
                <div>
                    <label class="font-bold text-md">Data de naixement</label>
                    <p class="text-sm text-base-content/50">
                        @if($professional->birth_date)
                            {{ $professional->birth_date->format('d/m/Y') }}
                            ({{ $professional->birth_date->age }} anys)
                        @else
                            No especificat
                        @endif
                    </p>
                </div>
                <div>
                    <label class="font-bold text-md">Antiguitat:</label>
                    <p class="text-sm text-base-content/50">
                        @if($professional->first_hire_date)
                            {{ $professional->first_hire_date->format('d/m/Y') }}
                            ({{ round($professional->first_hire_date->diffInYears(now())) }} anys)
                        @else
                            No especificat
                        @endif
                    </p>
                </div>
                <div>
                    <label class="font-bold text-md">Gènere:</label>
                    <p class="text-sm text-base-content/50">{{ $professional->gender ?: 'No especificat' }}</p>
                </div>
                <div>
                    <label class="font-bold text-md">Nivell de formació:</label>
                    <p class="text-sm text-base-content/50">{{ $professional->education_level ?: 'No especificat' }}</p>
                </div>
            </div>
        </div>
    </div>

@include('components.partials.mainToasts')
@endsection
