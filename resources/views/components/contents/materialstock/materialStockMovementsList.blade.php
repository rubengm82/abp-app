@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Estoc de Material' => route('material_stock_items_list'),
    ]"
    :current="'Registre de moviments'"
/>

<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Registre de moviments</h1>

@if($movements->count() > 0)
<div class="flex justify-between items-center">
    <div>
        <x-partials.search-bar />
    </div>
    <div class="flex gap-2">
        <a href="{{ route('material_stock_movements_downloadCSV') }}" class="btn btn-sm btn-secondary">Descarregar Llistat</a>
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg/10 scrollable-list-container border border-gray-500/20">
    @if($movements->count() > 0)
        <div id="tableToSearch-container" data-url="/material-stock/movements/list">
            @include('components.contents.materialstock.tables.materialStockMovementsListTable')
        </div>
    @else
        <div class="text-center py-12">
            <h3 class="text-xl font-bold text-base-content mb-2">Encara no hi ha moviments</h3>
            <p class="text-base-content/70 mb-4">Registreu una entrada o sortida per començar.</p>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
