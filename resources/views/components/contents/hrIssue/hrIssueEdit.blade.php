@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Incidències RRHH' => route('hr_issues_list'),
        'Detalls' => route('hr_issue_show', $hrIssue),
    ]"
    :current="'Editar Incidència'"
    />
<div class="max-w-4xl mx-auto bg-base-100 p-6 rounded shadow">
    <h1 class="text-3xl font-bold text-base-content mb-6 text-center">Editar incidència RRHH</h1>
    
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

    <form action="{{ route('hr_issue_update', $hrIssue) }}" method="post" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Issue Information -->
        <div class="card shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació de la incidència</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Centre</span>
                        </label>
                        <select name="center_id" id="id_center_id" class="select select-bordered w-full">
                            <option value="">Selecciona un centre</option>
                            @foreach(\App\Models\Center::where('status', 1)->get() as $center)
                                <option value="{{ $center->id }}" {{ old('center_id', $hrIssue->center_id) == $center->id ? 'selected' : '' }}>
                                    {{ $center->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Data d'obertura *</span>
                        </label>
                        <input type="date" name="opening_date" id="id_opening_date" class="input input-bordered w-full" value="{{ old('opening_date', $hrIssue->opening_date->format('Y-m-d')) }}" required>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Data de tancament</span>
                        </label>
                        <input type="date" name="closing_date" id="id_closing_date" class="input input-bordered w-full" value="{{ old('closing_date', $hrIssue->closing_date ? $hrIssue->closing_date->format('Y-m-d') : '') }}">
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Estat *</span>
                        </label>
                        <select name="status" id="id_status" class="select select-bordered w-full" required>
                            <option value="Obert" {{ old('status', $hrIssue->status) == 'Obert' ? 'selected' : '' }}>Obert</option>
                            <option value="Tancat" {{ old('status', $hrIssue->status) == 'Tancat' ? 'selected' : '' }}>Tancat</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professionals Selection -->
        <div class="card shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Professionals</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Professional afectat *</span>
                        </label>
                        <select name="affected_professional_id" id="id_affected_professional_id" class="select select-bordered w-full" required>
                            <option value="">Selecciona un professional</option>
                            @foreach(\App\Models\Professional::where('status', 1)->orderBy('name')->get() as $professional)
                                <option value="{{ $professional->id }}" {{ old('affected_professional_id', $hrIssue->affected_professional_id) == $professional->id ? 'selected' : '' }}>
                                    {{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Registrat per *</span>
                        </label>
                        <select name="registering_professional_id" id="id_registering_professional_id" class="select select-bordered w-full" required>
                            <option value="">Selecciona un professional</option>
                            @foreach(\App\Models\Professional::where('status', 1)->orderBy('name')->get() as $professional)
                                <option value="{{ $professional->id }}" {{ old('registering_professional_id', $hrIssue->registering_professional_id) == $professional->id ? 'selected' : '' }}>
                                    {{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-control md:col-span-2">
                        <label class="label">
                            <span class="label-text">Derivat a</span>
                        </label>
                        <select name="referred_to_professional_id" id="id_referred_to_professional_id" class="select select-bordered w-full">
                            <option value="">No derivat</option>
                            @foreach(\App\Models\Professional::where('status', 1)->orderBy('name')->get() as $professional)
                                <option value="{{ $professional->id }}" {{ old('referred_to_professional_id', $hrIssue->referred_to_professional_id) == $professional->id ? 'selected' : '' }}>
                                    {{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="card shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Descripció</h2>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Descripció de la incidència *</span>
                    </label>
                    <textarea name="description" id="id_description" rows="6" placeholder="Descriu la incidència RRHH..." class="textarea textarea-bordered w-full" required>{{ old('description', $hrIssue->description) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('hr_issue_show', $hrIssue) }}" class="btn btn-outline">Cancel·lar</a>
            <input type="submit" value="Actualitzar Incidència" class="btn btn-info">
        </div>
    </form>
</div>

@include('components.partials.mainToasts')
@endsection

