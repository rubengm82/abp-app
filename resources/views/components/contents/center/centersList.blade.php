@extends('app')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Llista de centres</h1>

@if($centers->where('status', 1)->count() > 0)
<div class="flex justify-end gap-4">
    <a href="{{ route('centers.downloadCSV', ['status' => 1]) }}" class="btn btn-sm btn-warning">Descarregar Llista</a>
    <a href="{{ route('center_form') }}" class="btn btn-sm btn-primary">Afegir Centre</a>
</div>
@endif

<div class="max-w-full mx-auto bg-white p-6 rounded shadow overflow-x-auto">
    @if($centers->where('status', 1)->count() > 0)
        <table class="table table-xs">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Adreça</th>
                    <th>Telèfon</th>
                <th>Email</th>
                <th></th>
                </tr>
            </thead>
            @foreach ($centers as $center)
                @if ($center->status == 1)
                    <tbody>
                    <tr class="hover:bg-base-300">
                        <th>{{ $center->id }}</th>
                        <td>{{ $center->name }}</td>
                        <td>{{ $center->address }}</td>
                        <td>{{ $center->phone }}</td>
                        <td>{{ $center->email }}</td>
                        <td class="flex justify-end gap-2">
                            <a href="{{ route('center_show', $center) }}" class="btn btn-xs btn-info">Veure</a>
                        </td>
                    </tr>
                </tbody>
                @endif
            @endforeach
        </table>
    @else
    <!-- TODO: Mover el icono y utilizar el svg master -->
        <div class="text-center py-12">
            <div class="text-gray-400 text-lg mb-4">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Encara no hi ha centres registrats</h3>
            <p class="text-gray-500 mb-4">Comença afegint el primer centre a la base de dades.</p>
            <a href="{{ route('center_form') }}" class="btn btn-primary">Afegir Primer Centre</a>
        </div>
    @endif
    
</div>

@include('components.layout.mainToasts')
@endsection
