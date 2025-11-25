@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Serveis Generals' => route('general_service_show', $service->service_type),
    ]"
    :current="'Editar'"
/>
<div class="max-w-4xl mx-auto bg-base-100 p-6 rounded shadow">
    <h1 class="text-3xl font-bold text-base-content mb-6 text-center">Editar Servei de {{ $service->service_type }}</h1>

    <form action="{{ route('general_service_update', $service) }}" method="post" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Service Information -->
        <div class="card shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació del Servei</h2>
                <div class="grid grid-cols-1 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Responsable</span>
                        </label>
                        <input type="text" name="responsible" id="id_responsible" placeholder="Ex: Nom del responsable" class="input input-bordered w-full" value="{{ old('responsible', $service->responsible) }}">
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Informació de contacte</span>
                        </label>
                        <textarea name="responsible_info" id="id_responsible_info" placeholder="Ex: Telèfon, email, etc." class="textarea textarea-bordered w-full" rows="4">{{ old('responsible_info', $service->responsible_info) }}</textarea>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Quadre d'horaris del personal</span>
                        </label>
                        <textarea name="planning" id="id_planning" placeholder="Ex: Horaris dels empleats" class="textarea textarea-bordered w-full" rows="6">{{ old('planning', $service->planning) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-4">
            <a href="{{ route('general_service_show', $service->service_type) }}" class="btn btn-outline">Cancel·lar</a>
            <input type="submit" value="Actualitzar Servei" class="btn btn-info">
        </div>
    </form>
</div>

@include('components.partials.mainToasts')
@endsection