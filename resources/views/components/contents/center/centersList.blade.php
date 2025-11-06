@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Centres' => null,
    ]"
    :current="'Llistat'"
    />
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llistat de centres</h1>

@if($centers->count() > 0)
<div class="flex justify-between items-center">
    <div>
        <x-partials.search-bar />
    </div>
    <div class="flex gap-4">
        <a href="{{ route('centers.downloadCSV', ['status' => 1]) }}" class="btn btn-sm btn-warning">Descarregar Llistat</a>
        <a href="{{ route('center_form') }}" class="btn btn-sm btn-primary">Afegir Centre</a>
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($centers->count() > 0)
        <div id="tableToSearch-container" data-url="/centers/list">
            @include('components.contents.center.tables.centersListTable')
        </div>
    @else
        <div class="text-center py-12">
            <h3 class="text-xl font-semibold text-base-content mb-2">Encara no hi ha centres registrats</h3>
            <p class="text-base-content/70 mb-4">Comença afegint el primer centre a la base de dades.</p>
            <a href="{{ route('center_form') }}" class="btn btn-primary">Afegir Primer Centre</a>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
