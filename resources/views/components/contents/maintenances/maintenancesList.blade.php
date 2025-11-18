@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Manteniments' => null,
    ]"
    :current="'Llistat'"
/>

<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llistat de Manteniments</h1>

@if($maintenances->count() > 0)
<div class="flex justify-between items-center">
    <div>
        <x-partials.search-bar />
    </div>
    <div class="flex gap-4">
        <a href="{{ route('maintenances_downloadCSV') }}" class="btn btn-sm btn-warning">Descarregar Llistat</a>
        <a href="{{ route('maintenance_form') }}" class="btn btn-sm btn-primary">Afegir Manteniment</a>
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($maintenances->count() > 0)
        <div id="tableToSearch-container" data-url="/maintenances/list">
            @include('components.contents.maintenances.tables.maintenancesListTable')
        </div>
    @else
        <div class="text-center py-12">
            <h3 class="text-xl font-semibold text-base-content mb-2">Encara no hi ha manteniments registrats</h3>
            <a href="{{ route('maintenance_form') }}" class="btn btn-primary">Afegir Primer Manteniment</a>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
