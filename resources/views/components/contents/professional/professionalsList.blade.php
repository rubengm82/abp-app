@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Professionals' => null,
    ]"
    :current="'Llistat'"
    />

    
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llistat de professionals</h1>


@if($professionals->count() > 0)
<div class="flex justify-between items-center">
    <div>
        <x-partials.search-bar />
    </div>
    <div class="flex gap-2">
        <a href="{{ route('professionals.downloadCSV', 1) }}" class="btn btn-sm btn-warning">Descarregar Llistat</a>
        <a href="{{ route('professionals.downloadCSV.materialAssignments') }}" class="btn btn-sm btn-warning">Descarregar Uniformitat</a>
        <a href="{{ route('professional_form') }}" class="btn btn-sm btn-primary">Afegir Professional</a>
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($professionals->count() > 0)
        <div id="tableToSearch-container" data-url="/professionals/list">
            @include('components.contents.professional.tables.professionalsListTable')
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-base-content/50 text-lg mb-4">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-base-content mb-2">Encara no hi ha professionals registrats</h3>
            <p class="text-base-content/70 mb-4">Comença afegint el primer professional a la base de dades.</p>
            <a href="{{ route('professional_form') }}" class="btn btn-primary">Afegir Primer Professional</a>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
