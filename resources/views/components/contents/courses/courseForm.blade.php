@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Cursos' => route('courses_list'),
        'Llistat' => route('courses_list'),
    ]"
    :current="'Afegir Curs'"
/>

<div class="max-w-4xl mx-auto bg-base-200 p-6 rounded-lg shadow-xl/10 border border-gray-500/20">
    <h1 class="text-3xl font-bold text-base-content mb-6 text-center">
        {{ isset($course) ? 'Editar curs' : 'Afegir curs' }}
    </h1>
    
    <!-- Show validation errors -->
    @if ($errors->any())
        <div class="alert alert-error mb-6">
            <div>
                <h3 class="font-bold text-base-content mb-1">Hi ha errors en el formulari:</h3>
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
        <div class="card bg-base-100 shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació Bàsica</h2>
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Nom del curs *</span>
                        </label>
                        <input type="text" name="training_name" id="id_training_name" placeholder="Ex: Curs de programació en Java" 
                               class="input input-bordered w-full" 
                               value="{{ old('training_name', optional($course)->training_name ?? '') }}" required>
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Codi FORCEM</span>
                        </label>
                        <input type="text" name="forcem_code" id="id_forcem_code" placeholder="Ex: FRC-2025-01" 
                               class="input input-bordered w-full" 
                               value="{{ old('forcem_code', optional($course)->forcem_code ?? '') }}">
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Centre de Formació</span>
                        </label>
                        <input type="text" name="training_center" id="id_training_center" placeholder="Ex: Ins la Poma"
                               class="input input-bordered w-full"
                               value="{{ old('training_center', optional($course)->training_center ?? '') }}">
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Tipus de curs</span>
                        </label>
                        <select name="type" id="id_type" class="select select-bordered w-full">
                            <option value="">Selecciona tipus</option>
                            <option value="Formació Interna" {{ old('type', optional($course)->type ?? '') == 'Formació Interna' ? 'selected' : '' }}>Formació Interna</option>
                            <option value="Formació Externa" {{ old('type', optional($course)->type ?? '') == 'Formació Externa' ? 'selected' : '' }}>Formació Externa</option>
                            <option value="Formació Salut Laboral" {{ old('type', optional($course)->type ?? '') == 'Formació Salut Laboral' ? 'selected' : '' }}>Formació Salut Laboral</option>
                            <option value="Jorn" {{ old('type', optional($course)->type ?? '') == 'Jorn' ? 'selected' : '' }}>Jorn</option>
                            <option value="Taller" {{ old('type', optional($course)->type ?? '') == 'Taller' ? 'selected' : '' }}>Taller</option>
                            <option value="Seminari" {{ old('type', optional($course)->type ?? '') == 'Seminari' ? 'selected' : '' }}>Seminari</option>
                            <option value="Congrés" {{ old('type', optional($course)->type ?? '') == 'Congrés' ? 'selected' : '' }}>Congrés</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Modalitat</span>
                        </label>
                        <select name="attendance_type" id="id_attendance_type" class="select select-bordered w-full">
                            <option value="">Selecciona modalitat</option>
                            <option value="Presencial" {{ old('attendance_type', optional($course)->attendance_type ?? '') == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                            <option value="Online" {{ old('attendance_type', optional($course)->attendance_type ?? '') == 'Online' ? 'selected' : '' }}>Online</option>
                            <option value="Mixto" {{ old('attendance_type', optional($course)->attendance_type ?? '') == 'Mixto' ? 'selected' : '' }}>Mixto</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dates and Duration -->
        <div class="card bg-base-100 shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Dates i Durada</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Data d'inici *</span>
                        </label>
                        <input type="date" name="start_date" id="id_start_date" class="input input-bordered w-full" 
                               value="{{ old('start_date', optional($course)->start_date ? optional($course)->start_date->format('Y-m-d') : '') }}" required>
                    </div>
                    
                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Data de finalització</span>
                        </label>
                        <input type="date" name="end_date" id="id_end_date" class="input input-bordered w-full" 
                               value="{{ old('end_date', optional($course)->end_date ? optional($course)->end_date->format('Y-m-d') : '') }}">
                    </div>
                </div>

                <div class="form-control mt-4">
                    <label class="label font-bold text-base-content mb-1">
                        <span class="label-text">Hores totals</span>
                    </label>
                    
                    <input type="number" name="total_hours" id="id_total_hours" placeholder="Ex: 30" 
                           class="input input-bordered w-full" 
                           min="0"
                           value="{{ old('total_hours', optional($course)->total_hours ?? '') }}">
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
