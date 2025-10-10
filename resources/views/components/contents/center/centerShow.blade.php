@extends('app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">{{ $center->name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('centers_list') }}" class="btn btn-sm btn-outline">Tornar a la llista</a>
            <a href="{{ route('center_edit', $center) }}" class="btn btn-sm btn-info">Editar</a>
            <a href="{{ route('center_desactivate', $center) }}" class="btn btn-sm btn-error">Desactivar</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Informació bàsica -->
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-4">Informació bàsica</h2>
                <div class="space-y-3">
                    <div>
                        <label class="font-semibold text-gray-600">Nom del centre:</label>
                        <p class="text-lg">{{ $center->name }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">ID:</label>
                        <p class="text-lg">{{ $center->id }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Estat:</label>
                        <p class="text-lg">
                            <span class="badge {{ $center->status == 1 ? 'badge-success' : 'badge-error' }}">
                                {{ $center->status == 1 ? 'Actiu' : 'Inactiu' }}
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
                        <label class="font-semibold text-gray-600">Adreça:</label>
                        <p class="text-lg">{{ $center->address ?: 'No especificada' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Telèfon:</label>
                        <p class="text-lg">{{ $center->phone ?: 'No especificat' }}</p>
                    </div>
                    <div>
                        <label class="font-semibold text-gray-600">Email:</label>
                        <p class="text-lg">{{ $center->email ?: 'No especificat' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informació addicional -->
    <div class="card bg-base-100 shadow-xl mt-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Informació addicional</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-600">Data de creació:</label>
                    <p class="text-lg">{{ $center->created_at ? $center->created_at->format('d/m/Y H:i') : 'No especificada' }}</p>
                </div>
                <div>
                    <label class="font-semibold text-gray-600">Última actualització:</label>
                    <p class="text-lg">{{ $center->updated_at ? $center->updated_at->format('d/m/Y H:i') : 'No especificada' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
