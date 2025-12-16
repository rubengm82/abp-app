@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Projectes' => null,
    ]"
    :current="$isDeactivated ? 'Llistat Desactivats' : 'Llistat'"
    />
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">{{ $isDeactivated ? 'Llistat de projectes i comissions desactivats' : 'Llistat de projectes i comissions' }}</h1>

@if($projectCommissions->count() > 0)
<div class="flex justify-between items-center">
    <div>
        <x-partials.search-bar />
    </div>
    <div class="flex gap-4">
        <a href="{{ route('projectcommissions.downloadCSV', ['status' => $isDeactivated ? 'Inactiu' : 'Actiu']) }}" class="btn btn-sm btn-secondary">Descarregar Llistat</a>
        @if(!$isDeactivated)
            {{-- <a href="{{ route('projectcommission_form') }}" class="btn btn-sm btn-primary">Afegir Projecte/Comissió</a> --}}
        @endif
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg/10 overflow-x-auto border border-gray-500/20">
    @if($projectCommissions->count() > 0)
        <div id="tableToSearch-container" data-url="{{ $isDeactivated ? '/projectcommissions/desactivated/list' : '/projectcommissions/list' }}">
            @include('components.contents.projectcommission.tables.projectCommissionsListTable')
        </div>
    @else
        <div class="text-center py-12">
            @if($isDeactivated)
                <div class="text-base-content/50 text-lg mb-4">
                    <div class="flex justify-center mb-4">
                        <x-partials.icon name="rectangle-group" class="w-15 h-15 text-primary" />
                    </div>
                </div>
                <h3 class="text-xl font-bold text-base-content mb-2">No hi ha projectes/comissions desactivats</h3>
                <p class="text-base-content/70 mb-4">Tots els projectes i comissions estan actualment actius.</p>
            @else
                <div class="text-base-content/50 text-lg mb-4">
                    <div class="flex justify-center mb-4">
                        <x-partials.icon name="rectangle-group" class="w-15 h-15 text-primary" />
                    </div>
                </div>
                <h3 class="text-xl font-bold text-base-content mb-2">Encara no hi ha projectes/comissions registrats</h3>
                <p class="text-base-content/70 mb-4">Comença afegint el primer projecte o comissió a la base de dades.</p>
                <a href="{{ route('projectcommission_form') }}" class="btn btn-primary">Afegir Primer Projecte/Comissió</a>
            @endif
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
