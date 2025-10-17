@extends('app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Afegir projecte/comissió</h1>
    
    <!-- Show validation errors -->
    @if ($errors->any())
        <div class="alert alert-error mb-6">
            <div>
                <div>
                    <h3 class="font-bold">Hi ha errors en el formulari:</h3>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('projectcommission_add') }}" method="post" class="space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació Bàsica</h2>
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nom/Títol del projecte/comissió *</span>
                        </label>
                        <input type="text" name="name" id="id_name" placeholder="Ex: Projecte de renovació de l'edifici principal" class="input input-bordered w-full" value="{{ old('name') }}" required>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Tipus *</span>
                        </label>
                        <select name="type" id="id_type" class="select select-bordered w-full" required>
                            <option value="">Selecciona el tipus</option>
                            <option value="Projecte" {{ old('type') == 'Projecte' ? 'selected' : '' }}>Projecte</option>
                            <option value="Comissió" {{ old('type') == 'Comissió' ? 'selected' : '' }}>Comissió</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dates and Timeline -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Dates i Cronograma</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Data d'inici</span>
                        </label>
                        <input type="date" name="start_date" id="id_start_date" class="input input-bordered w-full" value="{{ old('start_date', date('Y-m-d')) }}">
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Data estimada de finalització</span>
                        </label>
                        <input type="date" name="estimated_end_date" id="id_estimated_end_date" class="input input-bordered w-full" value="{{ old('estimated_end_date') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Details -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Detalls del Projecte/Comissió</h2>
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Professional responsable</span>
                        </label>
                        <select name="responsible_professional_id" id="id_responsible_professional_id" class="select select-bordered w-full">
                            <option value="">Selecciona un professional</option>
                            @foreach($professionals as $professional)
                                <option value="{{ $professional->id }}" {{ old('responsible_professional_id') == $professional->id ? 'selected' : '' }}>
                                    {{ $professional->name }} {{ $professional->surname1 }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Descripció</span>
                        </label>
                        <textarea name="description" id="id_description" placeholder="Descriu els objectius, abast i detalls del projecte/comissió..." class="textarea textarea-bordered w-full" rows="4">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('projectcommission_form') }}" class="btn btn-outline">Netejar</a>
            <input type="submit" value="Crear Projecte/Comissió" class="btn btn-info">
        </div>
    </form>
</div>

@include('components.layout.mainToasts')
@endsection
