@extends('app')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Llista d'Assignacions de Material</h1>
@if($materialAssignments->count() > 0)
<div class="flex justify-end gap-4 mb-4">
    <a href="{{ route('materialassignment_downloadCSV') }}" class="btn btn-sm btn-warning">Descarregar Llista</a>
    <a href="{{ route('materialassignment_form') }}" class="btn btn-sm btn-primary">Afegir Assignació</a>
</div>
@endif

<div class="max-w-full mx-auto bg-white p-6 rounded shadow overflow-x-auto">
    @if($materialAssignments->count() > 0)
        <table class="table table-xs">
        <thead>
            <tr>
                <th>ID</th>
                <th>Professional</th>
                <th class="text-center">Samarreta</th>
                <th class="text-center">Pantaló</th>
                <th class="text-center" >Sabata</th>
                <th>Data Assignació</th>
                <th>Assignat per</th>
                <th>Observacions</th>
                <th></th>
            </tr>
        </thead>
        @foreach ($materialAssignments as $assignment)
        <tbody>
            <tr class="hover:bg-base-300">
                <th>{{ $assignment->id }}</th>
                <td>
                    <a href="{{ route('professional_show', $assignment->professional->id) }}" 
                       class="text-primary font-semibold hover:text-orange-600 transition-all duration-200">
                        {{ $assignment->professional->name }} {{ $assignment->professional->surname1 }}
                    </a>
                </td>
                <td class="text-center">
                    @if($assignment->shirt_size)
                        <span class="badge badge-outline badge-info">{{ $assignment->shirt_size }}</span>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="text-center">
                    @if($assignment->pants_size)
                        <span class="badge badge-outline badge-info">{{ $assignment->pants_size }}</span>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="text-center">
                    @if($assignment->shoe_size)
                        <span class="badge badge-outline badge-info">{{ $assignment->shoe_size }}</span>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td>{{ $assignment->assignment_date->format('d/m/Y') }}</td>
                <td>
                    @if($assignment->assignedBy)
                        {{ $assignment->assignedBy->name }} {{ $assignment->assignedBy->surname1 }}
                    @else
                        <span class="text-gray-400">No especificat</span>
                    @endif
                </td>
                <td>
                    @if($assignment->observations)
                        <span class="text-sm" title="{{ $assignment->observations }}">
                            {{ Str::limit($assignment->observations, 30) }}
                        </span>
                    @else
                        <span class="text-gray-400">-</span>
                    @endif
                </td>
                <!-- TODO: REVIEW, if it was requested that these records could not be edited or deleted... -->
                <td class="flex justify-end gap-2">
                    <a href="{{ route('materialassignment_show', $assignment) }}" class="btn btn-xs btn-info">Veure</a>
                </td>
            </tr>
        </tbody>
        @endforeach
        </table>
    @else
        <div class="text-center py-12">
            <div class="text-gray-400 text-lg mb-4">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Encara no hi ha assignacions de material registrades</h3>
            <p class="text-gray-500 mb-4">Comença afegint la primera assignació de material a la base de dades.</p>
            <a href="{{ route('materialassignment_form') }}" class="btn btn-primary">Afegir Primera Assignació</a>
        </div>
    @endif
    
</div>

@include('components.layout.mainToasts')
@endsection
