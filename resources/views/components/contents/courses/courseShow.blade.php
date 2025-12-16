@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Cursos' => route('courses_list'),
        'Llistat' => route('courses_list'),
    ]"
    :current="'Detalls'"
/>

<div class="max-w-4xl mx-auto bg-base-200 text-base-content p-6 rounded-lg shadow-xl/10 border border-gray-500/20">

    <div class="flex justify-end items-center mb-6">
        {{-- <h1 class="text-3xl font-bold text-base-content">{{ $course->training_name }}</h1> --}}
        <!-- Buttons -->
        @if((Auth::user()->role ?? null) !== 'Tècnic')
        <div class="flex gap-2">
            <a href="{{ route('course_edit', $course->id) }}" class="btn btn-sm btn-info">Editar</a>
            <x-partials.modal id="deleteCourse{{ $course->id }}" 
                msj="Estàs segur que vols eliminar aquest curs?" 
                btnText="Eliminar" class="btn-sm btn-error">

                <form action="{{ route('course_delete', $course->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-error">Acceptar</button>
                </form>
            </x-partials.modal>
        </div>
        @endif
    </div>

    <!-- Basic Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20 md:col-span-2">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació bàsica</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-bold">Codi FORCEM:</label>
                        <p class="text-sm text-base-content/50">{{ $course->forcem_code ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-bold">Centre de Formació:</label>
                        <p class="text-sm text-base-content/50">{{ $course->training_center ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-bold">Nom del curs:</label>
                        <p class="text-sm text-base-content/50">{{ $course->training_name ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-bold">Tipus de curs:</label>
                        <p class="text-sm text-base-content/50">{{ $course->type ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-bold">Modalitat:</label>
                        <p class="text-sm text-base-content/50">{{ $course->attendance_type ?: 'No especificada' }}</p>
                    </div>
                    <div>
                        <label class="font-bold">Hores totals:</label>
                        <p class="text-sm text-base-content/50">{{ $course->total_hours ?: 'No especificades' }}</p>
                    </div>
                    <div>
                        <label class="font-bold">Taller:</label>
                        <p class="text-sm text-base-content/50">{{ $course->workshop ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-bold">Dia de conferència:</label>
                        <p class="text-sm text-base-content/50">{{ $course->conference_day ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-bold">Congrés:</label>
                        <p class="text-sm text-base-content/50">{{ $course->congress ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-bold">Assistents:</label>
                        <p class="text-sm text-base-content/50">{{ $course->attendee ?: 'No especificats' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additinal Info -->
    <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20 mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació addicional</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-bold">Data d’inici:</label>
                    <p class="text-sm text-base-content/50">
                        {{ $course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('d/m/Y') : 'No especificada' }}
                    </p>
                </div>
                <div>
                    <label class="font-bold">Data de finalització:</label>
                    <p class="text-sm text-base-content/50">
                        {{ $course->end_date ? \Carbon\Carbon::parse($course->end_date)->format('d/m/Y') : 'No especificada' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents -->
    <x-partials.documents-section
        :items="$course->documents"
        title="Documents"
        uploadAction="{{ route('course_document_add', $course) }}"
        downloadRoute="course_document_download"
        deleteRoute="course_document_delete"
        uploadedByField="uploadedByProfessional"
    />

    <!-- Notes -->
    <x-partials.notes-section
        :items="$course->notes"
        title="Notes"
        addAction="{{ route('course_note_add', $course) }}"
        deleteRoute="course_note_delete"
        :editRoute="'course_note_update'"
        createdByField="createdByProfessional"
    />

    <!-- Professionals Assigned -->
    <div class="card bg-base-100 text-base-content shadow-xl/10 border border-gray-500/20 mt-6">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-xl">Profesionals apuntats al curs</h2>
                <div class="flex gap-2">
                    @if($course->assignments->count() > 0)
                        <a href="{{ route('course_downloadCSV_professionals', $course) }}" class="btn btn-sm btn-secondary">Descarregar Llistat</a>
                    @endif
                    <a href="{{ route('course_assign_professionals', $course) }}" class="btn btn-sm btn-primary">
                        Assignar professionals
                    </a>
                </div>
            </div>
            
            @if($course->assignments->count() > 0)
                <div class="space-y-3">
                   @foreach($course->assignments as $assignment)
                    <div class="p-3 bg-base-200 rounded-lg flex items-center justify-between">
                        
                        <a href="{{ route('professional_show', $assignment->professional->id) }}" 
                        class="font-bold link link-hover text-info">
                            {{ $assignment->professional->name }} {{ $assignment->professional->surname1 }} {{ $assignment->professional->surname2 }}
                        </a>

                        <div class="flex items-center gap-2">
                            <span class="badge badge-dash {{ $assignment->certificate === 'Entregat' ? 'badge-success' : 'badge-warning' }}">
                                {{ $assignment->certificate ?? 'Pendent' }}
                            </span>

                            <!-- Button open modal -->
                            <x-partials.modal
                                id="certificateModal{{ $assignment->id }}"
                                msj="Canviar l'estat del certificat a {{ $assignment->certificate === 'Entregat' ? 'Pendent' : 'Entregat' }}?"
                                btnText="Canviar"
                                class="btn btn-xs btn-info"
                            >
                                <form method="POST" action="{{ route('course_assignment_update_certificate', $assignment->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <input type="hidden" name="certificate" value="{{ $assignment->certificate === 'Entregat' ? 'Pendent' : 'Entregat' }}">

                                    <button type="submit" class="btn btn-sm btn-info">Acceptar</button>
                                </form>
                            </x-partials.modal>
                        </div>
                    </div>
                @endforeach

                </div>
            @else
                <div class="text-center py-8 text-base-content/50">
                    <i class="fas fa-users text-4xl mb-4"></i>
                    <p class="text-sm text-base-content/50">No hi ha professionals assignats al curs</p>
                </div>
            @endif
        </div>
    </div>

@include('components.partials.mainToasts')
@endsection
