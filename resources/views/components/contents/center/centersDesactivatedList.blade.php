@extends('app')

@section('content')
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llista de centres desactivats</h1>

@if($centers->where('status', 0)->count() > 0)
<div class="flex justify-end gap-4 mb-4">
    <a href="{{ route('centers.downloadCSV', ['status' => 0]) }}" class="btn btn-sm btn-warning">Descarregar Llista</a>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($centers->where('status', 0)->count() > 0)
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
                @foreach ($centers as $center)
                    @if ($center->status == 0)
                        <tr class="hover:bg-base-200 transition-colors">
                            <td class="px-4 py-2">{{ $center->id }}</td>
                            <td class="px-4 py-2 font-medium">{{ $center->name }}</td>
                            <td class="px-4 py-2">{{ $center->address }}</td>
                            <td class="px-4 py-2">{{ $center->phone }}</td>
                            <td class="px-4 py-2">{{ $center->email }}</td>
                            <td class="px-4 py-2 text-right flex justify-end gap-2">
                                <a href="{{ route('center_show', $center) }}" class="btn btn-xs btn-info">Veure</a>
                                <a href="{{ route('center_activate', $center) }}" class="btn btn-xs btn-success">Activar</a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center py-12">
            <div class="text-base-content/50 text-lg mb-4">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-base-content mb-2">No hi ha centres desactivats</h3>
            <p class="text-base-content/70 mb-4">Tots els centres estan actualment actius.</p>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
