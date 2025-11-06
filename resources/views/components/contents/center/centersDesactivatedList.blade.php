@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Centres' => null,
    ]"
    :current="'Llistat Desactivats'"
    />
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llistat de centres desactivats</h1>

@if($centers->count() > 0)
<div class="flex justify-between items-center">
    <div>
        <x-partials.search-bar />
    </div>
    <div class="flex gap-4">
        <a href="{{ route('centers.downloadCSV', ['status' => 0]) }}" class="btn btn-sm btn-warning">Descarregar Llistat</a>
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($centers->count() > 0)
        <div id="tableToSearch-container" data-url="/centers/desactivated/list">
            @include('components.contents.center.tables.centersDesactivatedListTable')
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-base-content/50 text-lg mb-4">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-base-content mb-2">No hi ha centres desactivats</h3>
            <p class="text-base-content/70 mb-4">Tots els centres estan actualment actius.</p>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
