@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Uniformitat' => null,
    ]"
    :current="'Llistat'"
    />
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llista d'Assignacions de Material</h1>

@if($materialAssignments->count() > 0)
<div class="flex justify-end gap-4 mb-4">
    <a href="{{ route('materialassignment_downloadCSV') }}" class="btn btn-sm btn-warning">Descarregar Llista</a>
    <a href="{{ route('materialassignment_form') }}" class="btn btn-sm btn-primary">Afegir Assignació</a>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($materialAssignments->count() > 0)
        <table class="table w-full table-xs table-hover text-sm">
            <thead>
                <tr class="bg-base-300 text-base-content font-semibold">
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Professional</th>
                    <th class="px-4 py-2 text-center">Samarreta</th>
                    <th class="px-4 py-2 text-center">Pantaló</th>
                    <th class="px-4 py-2 text-center">Sabata</th>
                    <th class="px-4 py-2 text-left">Data Assignació</th>
                    <th class="px-4 py-2 text-left">Assignat per</th>
                    <th class="px-4 py-2 text-left">Observacions</th>
                    <th class="px-4 py-2 text-right">Accions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($materialAssignments as $assignment)
                    <tr class="hover:bg-base-300 transition-colors">
                        <td class="px-4 py-2">{{ $assignment->id }}</td>
                        <td class="px-4 py-2 font-medium">
                            <a href="{{ route('professional_show', $assignment->professional->id) }}" 
                               class="text-primary font-semibold hover:text-primary-focus transition-all duration-200">
                                {{ $assignment->professional->name }} {{ $assignment->professional->surname1 }}
                            </a>
                        </td>
                        <td class="px-4 py-2 text-center">
                            @if($assignment->shirt_size)
                                <span class="badge badge-outline badge-info">{{ $assignment->shirt_size }}</span>
                            @else
                                <span class="text-base-content/50">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            @if($assignment->pants_size)
                                <span class="badge badge-outline badge-info">{{ $assignment->pants_size }}</span>
                            @else
                                <span class="text-base-content/50">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            @if($assignment->shoe_size)
                                <span class="badge badge-outline badge-info">{{ $assignment->shoe_size }}</span>
                            @else
                                <span class="text-base-content/50">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $assignment->assignment_date->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">
                            @if($assignment->assignedBy)
                                {{ $assignment->assignedBy->name }} {{ $assignment->assignedBy->surname1 }}
                            @else
                                <span class="text-base-content/50">No especificat</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if($assignment->observations)
                                <span class="text-sm" title="{{ $assignment->observations }}">
                                    {{ Str::limit($assignment->observations, 30) }}
                                </span>
                            @else
                                <span class="text-base-content/50">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-right flex justify-end gap-2">
                            <a href="{{ route('materialassignment_show', $assignment) }}" class="btn btn-xs btn-info">Veure</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center py-12">
            <div class="text-base-content/50 text-lg mb-4">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-base-content mb-2">Encara no hi ha assignacions de material registrades</h3>
            <p class="text-base-content/70 mb-4">Comença afegint la primera assignació de material a la base de dades.</p>
            <a href="{{ route('materialassignment_form') }}" class="btn btn-primary">Afegir Primera Assignació</a>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
