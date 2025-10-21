@extends('app')

@section('content')
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llista de professionals desactivats</h1>

@if($professionals->where('status', 0)->count() > 0)
<div class="flex justify-end gap-4 mb-4">
    <a href="{{ route('professionals.downloadCSV', 0) }}" class="btn btn-sm btn-warning">Descarregar Llista</a>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($professionals->where('status', 0)->count() > 0)
        <table class="table w-full table-xs table-zebra table-hover text-sm">
            <thead>
                <tr class="bg-base-300 text-base-content font-semibold">
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Centre</th>
                    <th class="px-4 py-2 text-left">Codi</th>
                    <th class="px-4 py-2 text-left">Nom</th>
                    <th class="px-4 py-2 text-left">Primer cognom</th>
                    <th class="px-4 py-2 text-left">Segon cognom</th>
                    <th class="px-4 py-2 text-left">DNI</th>
                    <th class="px-4 py-2 text-left">Adreça</th>
                    <th class="px-4 py-2 text-left">Rol</th>
                    <th class="px-4 py-2 text-left">Telèfon</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Estat</th>
                    <th class="px-4 py-2 text-right">Accions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($professionals as $professional)
                    @if ($professional->status == 0)
                        <tr class="hover:bg-base-200 transition-colors">
                            <td class="px-4 py-2">{{ $professional->id }}</td>
                            <td class="px-4 py-2">
                                @if($professional->center)
                                    <a href="{{ route('center_show', $professional->center->id) }}" 
                                       class="text-primary font-semibold hover:text-primary-focus transition-all duration-200">
                                        {{ $professional->center->name }}
                                    </a>
                                @else
                                    <span class="text-base-content/50">No assignat</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $professional->key_code }}</td>
                            <td class="px-4 py-2">{{ $professional->name }}</td>
                            <td class="px-4 py-2">{{ $professional->surname1 }}</td>
                            <td class="px-4 py-2">{{ $professional->surname2 }}</td>
                            <td class="px-4 py-2">{{ $professional->dni }}</td>
                            <td class="px-4 py-2">{{ $professional->address }}</td>
                            <td class="px-4 py-2">{{ $professional->role }}</td>
                            <td class="px-4 py-2">{{ $professional->phone }}</td>
                            <td class="px-4 py-2">{{ $professional->email }}</td>
                            <td class="px-4 py-2">
                                <span class="badge {{ $professional->employment_status === 'Actiu' ? 'badge badge-outline badge-success' : 'badge badge-outline badge-warning' }}">
                                    {{ $professional->employment_status }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-right flex justify-end gap-2">
                                <a href="{{ route('professional_show', $professional->id) }}" class="btn btn-xs btn-info">Veure</a>
                                <a href="{{ route('professional_activate', $professional->id) }}" class="btn btn-xs btn-success">Activar</a>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-base-content mb-2">No hi ha professionals desactivats</h3>
            <p class="text-base-content/70 mb-4">Tots els professionals estan actualment actius.</p>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
