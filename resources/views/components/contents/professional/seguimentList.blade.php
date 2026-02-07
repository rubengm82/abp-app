@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Professionals' => route('professionals_list'),
    ]"
    :current="'Seguiment'"
    />

<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Seguiment</h1>

@if($professionals->count() > 0)
<div class="flex justify-between items-center mb-3">
    <div>
        <x-partials.search-bar />
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg/10 overflow-x-auto border border-gray-500/20">
    @if($professionals->count() > 0)
        <div id="tableToSearch-container" data-url="{{ route('seguiment_list') }}">
            @include('components.contents.professional.tables.seguimentListTable')
        </div>
    @else
    <div class="text-center py-12 text-base-content/50">
        <p>No hi ha professionals amb seguiment.</p>
    </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
