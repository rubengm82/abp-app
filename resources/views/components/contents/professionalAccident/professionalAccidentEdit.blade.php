@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Accidents professionals' => route('professional_accidents_list'),
        'Detalls' => route('professional_accident_show', $accident->id),
    ]"
    :current="'Editar'"
/>
<div class="max-w-4xl mx-auto bg-base-100 p-6 rounded shadow">
    <h1 class="text-3xl font-bold text-base-content mb-6 text-center">Editar accident professional</h1>
    
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

    <form action="{{ route('professional_accident_update', $accident->id) }}" method="post" class="space-y-6" id="accidentForm">
        @csrf
        @method('PUT')

        <!-- Accident Information -->
        <div class="card shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació de l'accident</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Tipus *</span>
                        </label>
                        <select name="type" id="id_type" class="select select-bordered w-full" required>
                            <option value="">Selecciona un tipus</option>
                            <option value="Sin baixa" {{ old('type', $accident->type) == 'Sin baixa' ? 'selected' : '' }}>Sin baixa</option>
                            <option value="Amb baixa" {{ old('type', $accident->type) == 'Amb baixa' ? 'selected' : '' }}>Amb baixa</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Data *</span>
                        </label>
                        <input type="date" name="date" id="id_date" class="input input-bordered w-full" value="{{ old('date', $accident->date->format('Y-m-d')) }}" required>
                    </div>
                    
                    <div class="form-control md:col-span-2">
                        <label class="label">
                            <span class="label-text">Context</span>
                        </label>
                        <textarea name="context" id="id_context" rows="3" placeholder="Context de l'accident..." class="textarea textarea-bordered w-full">{{ old('context', $accident->context) }}</textarea>
                    </div>
                    
                    <div class="form-control md:col-span-2">
                        <label class="label">
                            <span class="label-text">Descripció</span>
                        </label>
                        <textarea name="description" id="id_description" rows="4" placeholder="Descripció de l'accident..." class="textarea textarea-bordered w-full">{{ old('description', $accident->description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional Selection -->
        <div class="card shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Professional afectat</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Professional afectat</span>
                        </label>
                        @if($accident->affectedProfessional)
                            <input type="text" class="input input-bordered w-full" value="{{ $accident->affectedProfessional->name }} {{ $accident->affectedProfessional->surname1 }} {{ $accident->affectedProfessional->surname2 }}" readonly disabled>
                            <input type="hidden" name="affected_professional_id" value="{{ $accident->affected_professional_id }}">
                        @else
                            <input type="text" class="input input-bordered w-full" value="No assignat" readonly disabled>
                            <input type="hidden" name="affected_professional_id" value="{{ $accident->affected_professional_id }}">
                        @endif
                        <label class="label">
                            <span class="label-text-alt text-base-content/70">El professional afectat no es pot modificar</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leave Information (only for "Amb baixa" type) -->
        @php
            $currentType = old('type', $accident->type);
        @endphp
        <div class="card shadow-xl" id="leaveInfoSection" @if($currentType != 'Amb baixa') style="display: none;" @endif>
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació de la baixa</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Data d'inici</span>
                        </label>
                        <input type="date" name="start_date" id="id_start_date" class="input input-bordered w-full" value="{{ old('start_date', $accident->start_date ? $accident->start_date->format('Y-m-d') : '') }}">
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Data de fi</span>
                        </label>
                        <input type="date" name="end_date" id="id_end_date" class="input input-bordered w-full" value="{{ old('end_date', $accident->end_date ? $accident->end_date->format('Y-m-d') : '') }}">
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Durada (dies)</span>
                        </label>
                        <input type="number" name="duration" id="id_duration" class="input input-bordered w-full" min="0" value="{{ old('duration', $accident->duration) }}" placeholder="Ex: 15">
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('professional_accident_show', $accident->id) }}" class="btn btn-outline">Cancel·lar</a>
            <input type="submit" value="Actualitzar Accident" class="btn btn-info">
        </div>
    </form>
</div>

@php
    $editInitialType = old('type', $accident->type);
@endphp

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('id_type');
        const leaveSection = document.getElementById('leaveInfoSection');
        
        function toggleLeaveSection() {
            const type = typeSelect.value;
            if (type === 'Amb baixa') {
                leaveSection.style.display = 'block';
            } else {
                leaveSection.style.display = 'none';
            }
        }
        
        typeSelect.addEventListener('change', toggleLeaveSection);
    });
</script>

@include('components.partials.mainToasts')
@endsection

