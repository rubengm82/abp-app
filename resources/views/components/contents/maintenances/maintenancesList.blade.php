@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Manteniments' => null,
    ]"
    :current="$isDeactivated ? 'Llistat Desactivats' : 'Llistat'"
/>

<h1 class="text-3xl font-bold text-base-content mb-6 text-center">{{ $isDeactivated ? 'Llistat de Manteniments desactivats' : 'Llistat de Manteniments' }}</h1>

@if($maintenances->count() > 0)
<div class="flex justify-between items-center">
    <div>
        <x-partials.search-bar />
    </div>
    <div class="flex gap-4">
        <a href="{{ route('maintenances_downloadCSV') }}" class="btn btn-sm btn-warning">Descarregar Llistat</a>
        @if(!$isDeactivated)
            {{-- <a href="{{ route('maintenance_form') }}" class="btn btn-sm btn-primary">Afegir Manteniment</a> --}}
        @endif
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($maintenances->count() > 0)
        <div id="tableToSearch-container" data-url="{{ $isDeactivated ? '/maintenances/desactivated/list' : '/maintenances/list' }}">
            @include('components.contents.maintenances.tables.maintenancesListTable')
        </div>
    @else
        <div class="text-center py-12">
            @if($isDeactivated)
                <div class="flex justify-center mb-4">
                    <x-partials.icon name="wrench" class="w-15 h-15 text-primary" />
                </div>
                <h3 class="text-xl font-semibold text-base-content mb-2">No hi ha manteniments desactivats</h3>
                <p class="text-base-content/70 mb-4">Tots els manteniments estan actualment actius.</p>
            @else
                <h3 class="text-xl font-semibold text-base-content mb-2">Encara no hi ha manteniments registrats</h3>
                <a href="{{ route('maintenance_form') }}" class="btn btn-primary">Afegir Primer Manteniment</a>
            @endif
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
