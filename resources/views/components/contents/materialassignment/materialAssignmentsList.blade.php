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
            <h3 class="text-xl font-semibold text-base-content mb-2">Encara no hi ha assignacions de material registrades</h3>
            <a href="{{ route('materialassignment_form') }}" class="btn btn-primary">Afegir Primera Assignació</a>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
