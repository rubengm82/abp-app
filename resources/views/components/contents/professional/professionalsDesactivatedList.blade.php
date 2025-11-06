@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Professionals' => null,
    ]"
    :current="'Llistat Desactivats'"
    />
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llistat de professionals desactivats</h1>

@if($professionals->count() > 0)
<div class="flex justify-between items-center">
    <div>
        <x-partials.search-bar />
    </div>
    <div class="flex gap-4">
        <a href="{{ route('professionals.downloadCSV', 0) }}" class="btn btn-sm btn-warning">Descarregar Llistat</a>
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($professionals->count() > 0)
        <div id="tableToSearch-container" data-url="/professionals/desactivated/list">
            @include('components.contents.professional.tables.professionalsDesactivatedListTable')
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-base-content/50 text-lg mb-4">
                <div class="flex justify-center mb-4">
                    <x-partials.icon name="user-group" class="w-15 h-15 text-primary" />
                </div>
            </div>
            <h3 class="text-xl font-semibold text-base-content mb-2">No hi ha professionals desactivats</h3>
            <p class="text-base-content/70 mb-4">Tots els professionals estan actualment actius.</p>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
