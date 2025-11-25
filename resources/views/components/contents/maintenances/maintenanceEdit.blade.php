@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Manteniments' => route('maintenances_list'),
    ]"
    :current="'Editar Manteniment'"
/>

<div class="max-w-4xl mx-auto bg-base-100 p-6 rounded shadow">
    <h1 class="text-3xl font-bold text-base-content mb-6 text-center">Editar Manteniment</h1>
    
    <!-- Mostra errors de validació -->
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

    <form action="{{ route('maintenance_update', $maintenance) }}" method="post" class="space-y-6">
        @csrf
        @method('PUT') <!-- Método PUT para actualizar -->

        <!-- Maintenance Information -->
        <div class="card shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació del Manteniment</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nom del manteniment *</span>
                        </label>
                        <input 
                            type="text" 
                            name="name_maintenance" 
                            id="id_name_maintenance" 
                            placeholder="Ex: Revisió anual de caldera" 
                            class="input input-bordered w-full" 
                            value="{{ old('name_maintenance', $maintenance->name_maintenance) }}" 
                            required
                        >
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Responsable *</span>
                        </label>
                        <input 
                            type="text" 
                            name="responsible_maintenance" 
                            id="id_responsible_maintenance" 
                            placeholder="Ex: Joan Pérez" 
                            class="input input-bordered w-full" 
                            value="{{ old('responsible_maintenance', $maintenance->responsible_maintenance) }}" 
                            required
                        >
                    </div>

                    <div class="form-control md:col-span-2">
                        <label class="label">
                            <span class="label-text">Descripció</span>
                        </label>
                        <textarea 
                            name="description" 
                            id="id_description" 
                            rows="4" 
                            placeholder="Detalla el tipus de manteniment, tasques a realitzar, observacions..."
                            class="textarea textarea-bordered w-full"
                        >{{ old('description', $maintenance->description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Opening Date -->
        <div class="card shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Data</h2>
                <div class="form-control w-full md:w-1/2">
                    <label class="label">
                        <span class="label-text">Data d'obertura *</span>
                    </label>
                    <input 
                        type="date" 
                        name="opening_date_maintenance" 
                        id="id_opening_date_maintenance" 
                        class="input input-bordered w-full" 
                        value="{{ old('opening_date_maintenance', \Carbon\Carbon::parse($maintenance->opening_date_maintenance)->format('Y-m-d')) }}"
                        required
                    >
                </div>
            </div>
        </div>

        <!-- Botons d'acció -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('maintenances_list') }}" class="btn btn-outline">Cancelar</a>
            <input type="submit" value="Actualitzar Manteniment" class="btn btn-info">
        </div>
    </form>
</div>

@include('components.partials.mainToasts')

@endsection
