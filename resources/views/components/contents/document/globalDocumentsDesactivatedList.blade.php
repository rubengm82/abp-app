@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Desactivacions' => null,
    ]"
    :current="'Documents desactivats'"
/>

<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llistat de documents desactivats</h1>

@if($documents->count() > 0)
<div class="flex justify-between items-center">
    <div>
        <x-partials.search-bar placeholder="Cercar per nom del document..." />
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-0 rounded-lg shadow-lg/10 scrollable-list-container border border-gray-500/20">
    @if($documents->count() > 0)
        <div id="tableToSearch-container" data-url="/documents/desactivated/list">
            @include('components.contents.document.tables.globalDocumentsDesactivatedListTable')
        </div>
    @else
        <div class="text-center py-12">
            <h3 class="text-xl font-bold text-base-content mb-2">No hi ha documents desactivats</h3>
            <p class="text-base-content/70 mb-4">Els documents desactivats apareixeran aquí.</p>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
