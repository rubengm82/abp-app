@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Centres' => null,
    ]"
    :current="$isDeactivated ? 'Llistat Desactivats' : 'Llistat'"
    />
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">{{ $isDeactivated ? 'Llistat de centres desactivats' : 'Llistat de centres' }}</h1>

@if($centers->count() > 0)
<div class="flex justify-between items-center">
    <div>
        <x-partials.search-bar />
    </div>
    <div class="flex gap-4">
        <a href="{{ route('centers.downloadCSV', ['status' => $isDeactivated ? 0 : 1]) }}" class="btn btn-sm btn-warning">Descarregar Llistat</a>
        @if(!$isDeactivated)
            {{-- <a href="{{ route('center_form') }}" class="btn btn-sm btn-primary">Afegir Centre</a> --}}
        @endif
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($centers->count() > 0)
        <div id="tableToSearch-container" data-url="{{ $isDeactivated ? '/centers/desactivated/list' : '/centers/list' }}">
            @include('components.contents.center.tables.centersListTable')
        </div>
    @else
        <div class="text-center py-12">
            @if($isDeactivated)
                <div class="text-base-content/50 text-lg mb-4">
                    <div class="flex justify-center mb-4">
                        <x-partials.icon name="building-office" class="w-15 h-15 text-primary" />
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-base-content mb-2">No hi ha centres desactivats</h3>
                <p class="text-base-content/70 mb-4">Tots els centres estan actualment actius.</p>
            @else
                <h3 class="text-xl font-semibold text-base-content mb-2">Encara no hi ha centres registrats</h3>
                <a href="{{ route('center_form') }}" class="btn btn-primary">Afegir Primer Centre</a>
            @endif
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
