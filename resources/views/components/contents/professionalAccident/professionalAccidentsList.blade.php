@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Accidents professionals' => null,
    ]"
    :current="'Llistat'"
/>

<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llistat d'accidents professionals</h1>

@if($accidents->count() > 0)
<div class="flex justify-between items-center">
    <div>
        <x-partials.search-bar />
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg/10 overflow-x-auto border border-gray-500/20">
    @if($accidents->count() > 0)
        <div id="tableToSearch-container" data-url="/professional_accidents/list">
            @include('components.contents.professionalAccident.tables.professionalAccidentsListTable')
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-base-content/50 text-lg mb-4">
                <div class="flex justify-center mb-4">
                    <x-partials.icon name="exclamation-triangle" class="w-15 h-15 text-primary" />
                </div>
            </div>
            <h3 class="text-xl font-bold text-base-content mb-2">Encara no hi ha accidents registrats</h3>
            <p class="text-base-content/70 mb-4">Comença afegint el primer accident professional a la base de dades.</p>
            <a href="{{ route('professional_accident_form') }}" class="btn btn-primary">Afegir Primer Accident</a>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection

