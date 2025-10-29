@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Cursos' => route('courses_list'),
        'Llistat' => route('courses_list'),
    ]"
    :current="'Afegir Curs'"
/>

<div class="max-w-4xl mx-auto bg-base-100 p-6 rounded shadow">
    <h1 class="text-3xl font-bold text-base-content mb-6 text-center">
        {{ isset($course) ? 'Editar curs' : 'Afegir curs' }}
    </h1>
    
    <!-- Show validation errors -->
    @if ($errors->any())
        <div class="alert alert-error mb-6">
            <div>
                <h3 class="font-bold">Hi ha errors en el formulari:</h3>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('course_add') }}" method="post" class="space-y-6">
        @csrf
        @if(isset($course))
            @method('PUT')
        @endif

        <!-- Basic Information -->
        <div class="card shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació Bàsica</h2>
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nom del curs *</span>
                        </label>
                        <input type="text" name="training_name" id="id_training_name" placeholder="Ex: Curs de programació en Java" 
                               class="input input-bordered w-full" 
                               value="{{ old('training_name', $course->training_name ?? '') }}" required>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Codi FORCEM *</span>
                        </label>
                        <input type="text" name="forcem_code" id="id_forcem_code" placeholder="Ex: FRC-2025-01" 
                               class="input input-bordered w-full" 
                               value="{{ old('forcem_code', $course->forcem_code ?? '') }}" required>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Tipus de curs</span>
                        </label>
                        <input type="text" name="type" id="id_type" placeholder="Ex: Formació interna, Taller, etc." 
                               class="input input-bordered w-full" 
                               value="{{ old('type', $course->type ?? '') }}">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Modalitat *</span>
                        </label>
                        <select name="attendance_type" id="id_attendance_type" class="select select-bordered w-full" required>
                            <option value="">Selecciona modalitat</option>
                            <option value="Presencial" {{ old('attendance_type', $course->attendance_type ?? '') == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                            <option value="Online" {{ old('attendance_type', $course->attendance_type ?? '') == 'Online' ? 'selected' : '' }}>Online</option>
                            <option value="Mixto" {{ old('attendance_type', $course->attendance_type ?? '') == 'Mixto' ? 'selected' : '' }}>Mixto</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dates and Duration -->
        <div class="card shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Dates i Durada</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Data d'inici *</span>
                        </label>
                        <input type="date" name="start_date" id="id_start_date" class="input input-bordered w-full" 
                               value="{{ old('start_date', isset($course->start_date) ? $course->start_date->format('Y-m-d') : '') }}" required>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Data de finalització</span>
                        </label>
                        <input type="date" name="end_date" id="id_end_date" class="input input-bordered w-full" 
                               value="{{ old('end_date', isset($course->end_date) ? $course->end_date->format('Y-m-d') : '') }}">
                    </div>
                </div>

                <div class="form-control mt-4">
                    <label class="label">
                        <span class="label-text">Hores totals</span>
                    </label>
                    
                    <input type="number" name="total_hours" id="id_total_hours" placeholder="Ex: 30" 
                           class="input input-bordered w-full" 
                           min="0"
                           value="{{ old('total_hours', $course->total_hours ?? '') }}">
                </div>
            </div>
        </div>

        <!-- Other Details -->
        <div class="card shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Altres Detalls</h2>
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Taller</span>
                        </label>
                        <input type="text" name="workshop" id="id_workshop" placeholder="Ex: Taller pràctic de fusteria" 
                               class="input input-bordered w-full" 
                               value="{{ old('workshop', $course->workshop ?? '') }}">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Dia de conferència</span>
                        </label>
                        <input type="text" name="conference_day" id="id_conference_day" placeholder="Ex: 03/04/2025, Dimecres" 
                               class="input input-bordered w-full" 
                               value="{{ old('conference_day', $course->conference_day ?? '') }}">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Congrés</span>
                        </label>
                        <input type="text" name="congress" id="id_congress" placeholder="Ex: Congrés de Formació 2025" 
                               class="input input-bordered w-full" 
                               value="{{ old('congress', $course->congress ?? '') }}">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Assistents</span>
                        </label>
                        <input type="text" name="attendee" id="id_attendee" placeholder="Ex: Professionals del centre" 
                               class="input input-bordered w-full" 
                               value="{{ old('attendee', $course->attendee ?? '') }}">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Centre de Formació</span>
                        </label>
                        <input type="text" name="training_center" id="id_training_center" placeholder="Ex: Ins la Poma" 
                               class="input input-bordered w-full" 
                               value="{{ old('training_center', $course->training_center ?? '') }}">
                    </div>

                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('courses_list') }}" class="btn btn-outline">Netejar</a>
            <input type="submit" value="{{ isset($course) ? 'Actualitzar Curs' : 'Crear Curs' }}" class="btn btn-info">
        </div>
    </form>
</div>

@include('components.partials.mainToasts')
@endsection
