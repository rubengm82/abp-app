@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Cursos' => route('courses_list'),
        'Llistat' => route('courses_list'),
    ]"
    :current="'Detalls'"
/>

<div class="max-w-4xl mx-auto bg-base-100 p-6 rounded shadow">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-base-content">{{ $course->training_name }}</h1>
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
    </div>

    <!-- Basic Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="card bg-base-100 shadow-xl md:col-span-2">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació bàsica</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-gray-600">Codi FORCEM:</label>
                        <p class="text-lg">{{ $course->forcem_code ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Centre de Formació:</label>
                        <p class="text-lg">{{ $course->training_center ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Nom del curs:</label>
                        <p class="text-lg">{{ $course->training_name ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Tipus de curs:</label>
                        <p class="text-lg">{{ $course->type ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Modalitat:</label>
                        <p class="text-lg">{{ $course->attendance_type ?: 'No especificada' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Hores totals:</label>
                        <p class="text-lg">{{ $course->total_hours ?: 'No especificades' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Taller:</label>
                        <p class="text-lg">{{ $course->workshop ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Dia de conferència:</label>
                        <p class="text-lg">{{ $course->conference_day ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Congrés:</label>
                        <p class="text-lg">{{ $course->congress ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Assistents:</label>
                        <p class="text-lg">{{ $course->attendee ?: 'No especificats' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additinal Info -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Informació addicional</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-600">ID:</label>
                    <p class="text-lg">{{ $course->id }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-600">Data d’inici:</label>
                    <p class="text-lg">
                        {{ $course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('d/m/Y') : 'No especificada' }}
                    </p>
                </div>
                <div>
                    <label class="font-semibold text-gray-600">Data de finalització:</label>
                    <p class="text-lg">
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
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-xl">Profesionals apuntats al curs</h2>
                <div class="flex gap-2">
                    @if($course->assignments->count() > 0)
                        <a href="{{ route('course_downloadCSV_professionals', $course) }}" class="btn btn-sm btn-warning">Descarregar Llista</a>
                    @endif
                    <a href="{{ route('course_assign_professionals', $course) }}" class="btn btn-sm btn-primary">
                        Assignar professionals
                    </a>
                </div>
            </div>
            
            @if($course->assignments->count() > 0)
                <div class="space-y-3">
                    @foreach($course->assignments as $assignment)
                        <div class="p-3 bg-base-200 rounded-lg">
                            <div>
                                <a href="{{ route('professional_show', $assignment->professional->id) }}" 
                                   class="font-semibold text-black hover:text-gray-700 transition-all duration-200">
                                    {{ $assignment->professional->name }} {{ $assignment->professional->surname1 }} {{ $assignment->professional->surname2 }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-base-content/50">
                    <i class="fas fa-users text-4xl mb-4"></i>
                    <p class="text-lg">No hi ha professionals assignats al curs</p>
                </div>
            @endif
        </div>
    </div>

@include('components.partials.mainToasts')
@endsection
