@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Projectes' => null,
    ]"
    :current="'Llistat Desactivats'"
    />
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llistat de projectes i comissions desactivats</h1>

@if($projectCommissions->count() > 0)
<div class="flex justify-between items-center">
    <div>
        <x-partials.search-bar />
    </div>
    <div class="flex gap-4">
        <a href="{{ route('projectcommissions.downloadCSV', ['status' => 'Inactiu']) }}" class="btn btn-sm btn-warning">Descarregar Llistat</a>
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($projectCommissions->count() > 0)
        <div id="tableToSearch-container" data-url="/projectcommissions/desactivated/list">
            @include('components.contents.projectcommission.tables.projectCommissionsDesactivatedListTable')
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-base-content/50 text-lg mb-4">
                <div class="flex justify-center mb-4">
                    <x-partials.icon name="rectangle-group" class="w-15 h-15 text-primary" />
                </div>
            </div>
            <h3 class="text-xl font-semibold text-base-content mb-2">No hi ha projectes/comissions desactivats</h3>
            <p class="text-base-content/70 mb-4">Tots els projectes i comissions estan actualment actius.</p>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
