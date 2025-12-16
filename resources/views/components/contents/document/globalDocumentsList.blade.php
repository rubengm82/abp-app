@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Documents Globals' => null,
    ]"
    :current="'Llistat'"
/>

<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llistat de documents</h1>

@if($documents->count() > 0)
<div class="flex justify-between items-center">
    <div>
        <x-partials.search-bar />
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg/10 overflow-x-auto border border-gray-500/20">
    @if($documents->count() > 0)
        <div id="tableToSearch-container" data-url="/documents/list">
            @include('components.contents.document.tables.globalDocumentsListTable')
        </div>
    @else
        <div class="text-center py-12">
            <h3 class="text-xl font-bold text-base-content mb-2">Encara no hi ha documents registrats</h3>
            <p class="text-base-content/70 mb-4">Els documents apareixeran aquí quan siguin pujats.</p>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection

