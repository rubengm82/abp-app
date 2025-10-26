@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Uniformitat' => route('materialassignments_list'),
        'Detalls' => route('materialassignment_show', $materialAssignment->id),
    ]"
    :current="'Editar'"
    />
<div class="max-w-4xl mx-auto bg-base-100 p-6 rounded shadow">
    <h1 class="text-3xl font-bold text-base-content mb-6 text-center">Editar Assignació de Material</h1>
    
    <!-- Mostrar errores de validación -->
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
    
    <form action="{{ route('materialassignment_update', $materialAssignment) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Informació de l'Assignació -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació de l'Assignació</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Professional *</span></label>
                        <select name="professional_id" class="select select-bordered w-full" required>
                            <option value="">Selecciona un professional</option>
                            @foreach($professionals as $professional)
                                <option value="{{ $professional->id }}" {{ old('professional_id', $materialAssignment->professional_id) == $professional->id ? 'selected' : '' }}>
                                    {{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label"><span class="label-text">Data d'assignació *</span></label>
                        <input type="date" name="assignment_date" class="input input-bordered w-full" value="{{ old('assignment_date', $materialAssignment->assignment_date->format('Y-m-d')) }}" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Talles d'Uniforme -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Talles d'Uniforme</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Talla samarreta</span></label>
                        <select name="shirt_size" class="select select-bordered w-full">
                            <option value="">Selecciona talla</option>
                            @foreach(['XS','S','M','L','XL','2XL','3XL','4XL','36','38','40','42','44','46','48','50','52','54','56'] as $size)
                                <option value="{{ $size }}" {{ old('shirt_size', $materialAssignment->shirt_size) == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Talla pantaló</span></label>
                        <select name="pants_size" class="select select-bordered w-full">
                            <option value="">Selecciona talla</option>
                            @foreach(['XS','S','M','L','XL','2XL','3XL','4XL','36','38','40','42','44','46','48','50','52','54','56'] as $size)
                                <option value="{{ $size }}" {{ old('pants_size', $materialAssignment->pants_size) == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Talla sabata</span></label>
                        <select name="shoe_size" class="select select-bordered w-full">
                            <option value="">Selecciona talla</option>
                            @foreach(range(34, 56) as $size)
                                <option value="{{ $size }}" {{ old('shoe_size', $materialAssignment->shoe_size) == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalls de l'Assignació -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Detalls de l'Assignació</h2>
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Assignat per</span></label>
                        <select name="assigned_by_professional_id" class="select select-bordered w-full">
                            <option value="">Selecciona qui assigna</option>
                            @foreach($professionals as $professional)
                                <option value="{{ $professional->id }}" {{ old('assigned_by_professional_id', $materialAssignment->assigned_by_professional_id) == $professional->id ? 'selected' : '' }}>
                                    {{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-control">
                        <label class="label"><span class="label-text">Observacions</span></label>
                        <textarea name="observations" class="textarea textarea-bordered w-full" rows="3" placeholder="Ex: Uniforme nou, talles especials, notes sobre l'entrega...">{{ old('observations', $materialAssignment->observations) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de acción -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('materialassignments_list') }}" class="btn btn-outline">Cancel·lar</a>
            <button type="submit" class="btn btn-info">Actualitzar Assignació</button>
        </div>
    </form>
</div>

@include('components.partials.mainToasts')
@endsection
