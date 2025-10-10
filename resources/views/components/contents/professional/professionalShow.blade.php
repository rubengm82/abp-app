@extends('app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">{{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('professionals_list') }}" class="btn btn-sm btn-outline">Tornar a la llista</a>
            <a href="{{ route('professional_edit', $professional) }}" class="btn btn-sm btn-info">Editar</a>
            <a href="{{ route('professional_desactivate', $professional) }}" class="btn btn-sm btn-error">Desactivar</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Informació personal -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació personal</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold text-gray-600">Nom complet:</label>
                        <p class="text-lg">{{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">DNI:</label>
                        <p class="text-lg">{{ $professional->dni }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Rol:</label>
                        <p class="text-lg">{{ $professional->role ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Estat laboral:</label>
                        <p class="text-lg">
                            <span class="badge {{ $professional->employment_status === 'Actiu' ? 'badge-success' : 'badge-warning' }}">
                                {{ $professional->employment_status ?: 'No especificat' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informació de contacte -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació de contacte</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold text-gray-600">Telèfon:</label>
                        <p class="text-lg">{{ $professional->phone ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Email:</label>
                        <p class="text-lg">{{ $professional->email ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Adreça:</label>
                        <p class="text-lg">{{ $professional->address ?: 'No especificada' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Codi de clau:</label>
                        <p class="text-lg">{{ $professional->key_code ?: 'No especificat' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Currículum Vitae -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Currículum Vitae</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-lg break-words whitespace-pre-wrap">{{ $professional->cvitae ?: 'No hi ha currículum disponible' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Informació addicional -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Informació addicional</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="font-semibold text-gray-600">ID:</label>
                    <p class="text-lg">{{ $professional->id }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-600">Usuari de login:</label>
                    <p class="text-lg">{{ $professional->login ?: 'No especificat' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-600">Estat:</label>
                    <p class="text-lg">
                        <span class="badge {{ $professional->status == 1 ? 'badge-success' : 'badge-error' }}">
                            {{ $professional->status == 1 ? 'Actiu' : 'Inactiu' }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Assignacions de material -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Assignacions de Material</h2>
            @php
                $shirtSize = \App\Models\MaterialAssignment::getLatestShirtSize($professional->id);
                $pantsSize = \App\Models\MaterialAssignment::getLatestPantsSize($professional->id);
                $shoeSize = \App\Models\MaterialAssignment::getLatestShoeSize($professional->id);
            @endphp
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="text-center">
                    <label class="font-semibold text-gray-600">Samarreta:</label>
                    @if($shirtSize)
                        <p class="text-2xl font-bold text-blue-600">{{ $shirtSize }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
                <div class="text-center">
                    <label class="font-semibold text-gray-600">Pantaló:</label>
                    @if($pantsSize)
                        <p class="text-2xl font-bold text-green-600">{{ $pantsSize }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
                <div class="text-center">
                    <label class="font-semibold text-gray-600">Sabata:</label>
                    @if($shoeSize)
                        <p class="text-2xl font-bold text-purple-600">{{ $shoeSize }}</p>
                    @else
                        <p class="text-lg text-gray-400">No assignat</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
