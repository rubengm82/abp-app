@extends('app')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Llista de professionals</h1>
@if($professionals->where('status', 1)->count() > 0)
<div class="flex justify-end gap-4">
    <a href="{{ route('professionals.downloadCSV', 1) }}" class="btn btn-sm btn-warning">Descarregar Llista</a>
    <a href="{{ route('professionals.downloadCSV.materialAssignments') }}" class="btn btn-sm btn-warning">Descarregar Uniformitat</a>
    <a href="{{ route('professional_form') }}" class="btn btn-sm btn-primary">Afegir Professional</a>
</div>
@endif

<div class="max-w-full mx-auto bg-white p-6 rounded shadow overflow-x-auto">
    @if($professionals->where('status', 1)->count() > 0)
        <table class="table table-xs">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Centre</th>
                    <th>Codi</th>
                    <th>Nom</th>
                    <th>Primer cognom</th>
                    <th>Segon cognom</th>
                    <th>DNI</th>
                    <th>Adreça</th>
                    <th>Rol</th>
                    <th>Telèfon</th>
                    <th>Email</th>
                    <th>Estat</th>
                    <th></th>
                </tr>
            </thead>
            @foreach ($professionals as $professional)
            <tbody>
                <!-- TODO: Añadir contorl de overflow-->
                @if ($professional->status == 1)
                <tr class="hover:bg-base-300">
                    <th>{{ $professional->id }}</th>
                    <td>{{ $professional->center_id }}</td>
                    <!-- TODO: Añadir hover a codi -->
                    <td>{{ $professional->key_code }}</td>
                    <td>{{ $professional->name }}</td>
                    <td>{{ $professional->surname1 }} </td>
                    <td>{{ $professional->surname2 }}</td>
                    <td>{{ $professional->dni }}</td>
                    <td>{{ $professional->address }}</td>
                    <td>{{ $professional->role }}</td>
                    <td>{{ $professional->phone }}</td>
                    <td>{{ $professional->email }}</td>
                    <td>
                        <span class="badge {{ $professional->employment_status === 'Actiu' ? 'badge-success' : 'badge-warning' }}">
                            {{ $professional->employment_status }}
                        </span>
                    </td>
                    <td class="flex justify-end gap-2">
                        <a href="{{ route('professional_show', $professional->id) }}" class="btn btn-sm btn-info">Veure</a>
                        <a href="{{ route('professional_edit', $professional->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <a href="{{ route('professional_desactivate', $professional->id) }}" class="btn btn-sm btn-error">Desactivar</a>
                    </td>
                    </tr>
                @endif
            </tbody>
            @endforeach
        </table>
    @else
    <!-- TODO: Mover el icono y utilizar el svg master -->
        <div class="text-center py-12">
            <div class="text-gray-400 text-lg mb-4">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Encara no hi ha professionals registrats</h3>
            <p class="text-gray-500 mb-4">Comença afegint el primer professional a la base de dades.</p>
            <a href="{{ route('professional_form') }}" class="btn btn-primary">Afegir Primer Professional</a>
        </div>
    @endif
    
</div>

@include('components.layout.mainToasts')
@endsection
