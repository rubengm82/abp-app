@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Projectes' => null,
    ]"
    :current="'Llistat'"
    />
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llista de projectes i comissions</h1>

@if($projectCommissions->where('status', 'Actiu')->count() > 0)
<div class="flex justify-end gap-4 mb-4">
    <a href="{{ route('projectcommissions.downloadCSV', ['status' => 'Actiu']) }}" class="btn btn-sm btn-warning">Descarregar Llista</a>
    <a href="{{ route('projectcommission_form') }}" class="btn btn-sm btn-primary">Afegir Projecte/Comissió</a>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($projectCommissions->where('status', 'Actiu')->count() > 0)
        <table class="table w-full table-xs table-hover text-sm">
            <thead>
                <tr class="bg-base-300 text-base-content font-semibold">
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Nom/Títol</th>
                    <th class="px-4 py-2 text-left">Estat</th>
                    <th class="px-4 py-2 text-left">Professional responsable</th>
                    <th class="px-4 py-2 text-left">Tipus</th>
                    <th class="px-4 py-2 text-left">Data d'inici</th>
                    <th class="px-4 py-2 text-right">Accions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projectCommissions as $projectCommission)
                    @if ($projectCommission->status == 'Actiu')
                        <tr class="hover:bg-base-300 transition-colors">
                            <td class="px-4 py-2">{{ $projectCommission->id }}</td>
                            <td class="px-4 py-2 font-medium">{{ $projectCommission->name }}</td>
                            <td class="px-4 py-2">
                                <span class="badge {{ $projectCommission->status === 'Actiu' ? 'badge-success' : 'badge-warning' }}">
                                    {{ $projectCommission->status }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                @if($projectCommission->responsibleProfessional)
                                    <a href="{{ route('professional_show', $projectCommission->responsibleProfessional->id) }}" 
                                       class="link link-hover link-info">
                                        {{ $projectCommission->responsibleProfessional->name . ' ' . $projectCommission->responsibleProfessional->surname1 }}
                                    </a>
                                @else
                                    <span class="text-base-content/50">No assignat</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $projectCommission->type }}</td>
                            <td class="px-4 py-2">{{ $projectCommission->start_date }}</td>
                            <td class="px-4 py-2 text-right flex justify-end gap-2">
                                <a href="{{ route('projectcommission_show', $projectCommission) }}" class="btn btn-xs btn-info">Veure</a>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-base-content mb-2">Encara no hi ha projectes/comissions registrats</h3>
            <p class="text-base-content/70 mb-4">Comença afegint el primer projecte o comissió a la base de dades.</p>
            <a href="{{ route('projectcommission_form') }}" class="btn btn-primary">Afegir Primer Projecte/Comissió</a>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
