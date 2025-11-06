@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Projectes' => null,
    ]"
    :current="'Llistat'"
    />
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llistat de projectes i comissions</h1>

@if($projectCommissions->count() > 0)
<div class="flex justify-between items-center">
    <div>
        <x-partials.search-bar />
    </div>
    <div class="flex gap-4">
        <a href="{{ route('projectcommissions.downloadCSV', ['status' => 'Actiu']) }}" class="btn btn-sm btn-warning">Descarregar Llistat</a>
        <a href="{{ route('projectcommission_form') }}" class="btn btn-sm btn-primary">Afegir Projecte/Comissió</a>
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($projectCommissions->count() > 0)
        <div id="tableToSearch-container" data-url="/projectcommissions/list">
            @include('components.contents.projectcommission.tables.projectCommissionsListTable')
        </div>
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
