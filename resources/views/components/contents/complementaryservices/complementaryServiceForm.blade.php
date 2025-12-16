@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Serveis Complementaris' => route('complementaryservices_list'),
    ]"
    :current="'Afegir Servei Complementari'"
    />

<div class="max-w-4xl mx-auto bg-base-200 p-6 rounded-lg shadow-xl/10 border border-gray-500/20">
    <h1 class="text-3xl font-bold text-base-content mb-6 text-center">
        {{ isset($complementaryservice) ? 'Editar Servei Complementari' : 'Afegir Servei Complementari' }}
    </h1>

    <!-- Mostrar errores de validación -->
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

    <form 
        action="{{ isset($complementaryService) ? route('complementaryservice_update', $complementaryService) : route('complementaryservice_add') }}" 
        method="POST" 
        class="space-y-6"
    >
        @csrf
        @if(isset($complementaryService))
            @method('PUT')
        @endif

        <!-- Información del servicio -->
        <div class="card bg-base-100 shadow-xl/10 border border-gray-500/20">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4 underline underline-offset-5">Informació del Servei</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Tipus de Servei *</span>
                        </label>
                        <input
                            type="text"
                            name="service_type"
                            id="id_service_type"
                            placeholder="Ex: Taller de mindfulness"
                            class="input input-bordered w-full"
                            value="{{ old('service_type', $complementaryservice->service_type ?? '') }}"
                            required
                        >
                    </div>

                    <div class="form-control">
                        <label class="label font-bold text-base-content mb-1">
                            <span class="label-text">Responsable *</span>
                        </label>
                        <input
                            type="text"
                            name="service_responsible"
                            id="id_service_responsible"
                            placeholder="Ex: Psicòleg Jordi Roca"
                            class="input input-bordered w-full"
                            value="{{ old('service_responsible', $complementaryservice->service_responsible ?? '') }}"
                            required
                        >
                    </div>

                    <div class="form-control md:col-span-2">
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="w-full">
                                <label class="label font-bold text-base-content mb-1">
                                    <span class="label-text">Data d'inici *</span>
                                </label>
                                <input
                                    type="date"
                                    name="start_date"
                                    id="id_start_date"
                                    class="input input-bordered w-full"
                                    value="{{ old('start_date') }}"
                                    required
                                >
                            </div>
                            <div class="w-full">
                                <label class="label font-bold text-base-content mb-1">
                                    <span class="label-text">Data fi</span>
                                </label>
                                <input
                                    type="date"
                                    name="end_date"
                                    id="id_end_date"
                                    class="input input-bordered w-full"
                                    value="{{ old('end_date') }}"
                                >
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('complementaryservices_list') }}" class="btn btn-outline">Cancel·lar</a>
            <input 
                type="submit" 
                value="{{ isset($complementaryservice) ? 'Actualitzar Servei' : 'Crear Servei' }}" 
                class="btn btn-info"
            >
        </div>
    </form>
</div>

@include('components.partials.mainToasts')

@endsection
