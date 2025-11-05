@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Uniformitat' => null,
    ]"
    :current="'Llistat'"
    />
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llistat d'Assignacions de Material</h1>

@if($materialAssignments->count() > 0)
<div class="flex justify-between items-center">
    <div>
        <x-partials.search-bar />
    </div>
    <div class="flex gap-4">
        <a href="{{ route('materialassignment_downloadCSV') }}" class="btn btn-sm btn-warning">Descarregar Llistat</a>
        <a href="{{ route('materialassignment_form') }}" class="btn btn-sm btn-primary">Afegir Assignació</a>
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($materialAssignments->count() > 0)
        <div id="tableToSearch-container" data-url="/materialassignments/list">
            @include('components.contents.materialassignment.tables.materialAssignmentsListTable')
        </div>
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
