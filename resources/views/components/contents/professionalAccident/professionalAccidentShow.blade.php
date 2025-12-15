@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Accidents professionals' => route('professional_accidents_list'),
    ]"
    :current="'Detalls'"
/>
<div class="max-w-4xl mx-auto bg-base-100 text-base-content p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Accident professional #{{ $accident->id }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('professional_accident_edit', $accident) }}" class="btn btn-sm btn-info">Editar</a>
            @if($accident->type === 'Amb baixa')
                <div class="relative">
                    <x-partials.modal 
                        :id="'modal_end_leave_' . $accident->id" 
                        :msj="'Estàs segur que vols finalitzar aquesta baixa? El professional serà actualitzat al seu estat laboral anterior.'"  
                        :btnText="'Finalitzar Baixa'" 
                        class="btn-sm btn-success"
                    >
                        <form action="{{ route('professional_accident_end_leave', $accident->id) }}" method="POST" id="endLeaveForm{{ $accident->id }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                Acceptar
                            </button>
                        </form>
                    </x-partials.modal>
                </div>
            @endif
            <div class="relative">
                <x-partials.modal 
                    :id="'modal_delete_accident_' . $accident->id" 
                    :msj="'Estàs segur que vols eliminar aquest accident professional?'"  
                    :btnText="'Eliminar'" 
                    class="btn-sm btn-error"
                >
                    <form action="{{ route('professional_accident_delete', $accident->id) }}" method="POST" id="deleteAccidentForm{{ $accident->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-error">
                            Acceptar
                        </button>
                    </form>
                </x-partials.modal>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Accident Information -->
        <div class="card bg-base-100 text-base-content shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació de l'accident</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold">Tipus:</label>
                        <p class="text-lg">
                            <span class="badge badge-dash {{ $accident->type === 'Baixa Finalitzada' ? 'badge-success' : ($accident->type === 'Amb baixa' ? 'badge-warning' : 'badge-info') }}">
                                {{ $accident->type }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="font-semibold">Data:</label>
                        <p class="text-lg">{{ $accident->date->format('d/m/Y') }}</p>
                    </div>
                    @if($accident->type === 'Amb baixa' || $accident->type === 'Baixa Finalitzada')
                        <div>
                            <label class="font-semibold">Data d'inici de la baixa:</label>
                            <p class="text-lg">{{ $accident->start_date ? $accident->start_date->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div>
                            <label class="font-semibold">Data de fi de la baixa:</label>
                            <p class="text-lg">{{ $accident->end_date ? $accident->end_date->format('d/m/Y') : '-' }}</p>
                        </div>
                        <div>
                            <label class="font-semibold">Durada (dies):</label>
                            <p class="text-lg">{{ $accident->duration ?? '-' }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Professionals Information -->
        <div class="card bg-base-100 text-base-content shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Professionals</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold">Professional afectat:</label>
                        <p class="text-lg">
                            @if($accident->affectedProfessional)
                                {{ $accident->affectedProfessional->name }} {{ $accident->affectedProfessional->surname1 }} {{ $accident->affectedProfessional->surname2 }}
                            @else
                                <span class="text-gray-400">No assignat</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="font-semibold">Registrat per:</label>
                        <p class="text-lg">
                            @if($accident->createdByProfessional)
                                {{ $accident->createdByProfessional->name }} {{ $accident->createdByProfessional->surname1 }} {{ $accident->createdByProfessional->surname2 }}
                            @else
                                <span class="text-gray-400">No assignat</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Context -->
    @if($accident->context)
    <div class="card bg-base-100 text-base-content shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Context</h2>
            <p class="text-lg break-all whitespace-pre-wrap">{{ $accident->context }}</p>
        </div>
    </div>
    @endif

    <!-- Description -->
    @if($accident->description)
    <div class="card bg-base-100 text-base-content shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Descripció</h2>
            <p class="text-lg break-all whitespace-pre-wrap">{{ $accident->description }}</p>
        </div>
    </div>
    @endif

    <!-- Additional information -->
    <div class="card bg-base-100 text-base-content shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Informació addicional</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <div>
                    <label class="font-semibold">Data de creació:</label>
                    <p class="text-lg">{{ $accident->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="font-semibold">Última actualització:</label>
                    <p class="text-lg">{{ $accident->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

@include('components.partials.mainToasts')
@endsection

