@extends('app')

@section('content')
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llista de centres</h1>

@if($centers->where('status', 1)->count() > 0)
<div class="flex justify-end gap-4">
    <a href="{{ route('centers.downloadCSV', ['status' => 1]) }}" class="btn btn-sm btn-warning">Descarregar Llista</a>
    <a href="{{ route('center_form') }}" class="btn btn-sm btn-primary">Afegir Centre</a>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($centers->where('status', 1)->count() > 0)
        <table class="table w-full table-xs table-zebra table-hover text-sm">
            <thead>
                <tr class="bg-base-300 text-base-content font-semibold">
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Nom</th>
                    <th class="px-4 py-2 text-left">Adreça</th>
                    <th class="px-4 py-2 text-left">Telèfon</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-right">Accions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($centers as $center)
                    @if($center->status == 1)
                        <tr class="hover:bg-base-200 transition-colors">
                            <td class="px-4 py-2">{{ $center->id }}</td>
                            <td class="px-4 py-2 font-medium">{{ $center->name }}</td>
                            <td class="px-4 py-2">{{ $center->address }}</td>
                            <td class="px-4 py-2">{{ $center->phone }}</td>
                            <td class="px-4 py-2">{{ $center->email }}</td>
                            <td class="px-4 py-2 text-right flex justify-end gap-2">
                                <a href="{{ route('center_show', $center) }}" class="btn btn-xs btn-info">Veure</a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center py-12">
            <h3 class="text-xl font-semibold text-base-content mb-2">Encara no hi ha centres registrats</h3>
            <p class="text-base-content/70 mb-4">Comença afegint el primer centre a la base de dades.</p>
            <a href="{{ route('center_form') }}" class="btn btn-primary">Afegir Primer Centre</a>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
