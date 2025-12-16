@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Professionals' => route('professionals_list'),
        'Avaluacions' => null,
    ]"
    :current="'Llistat'"
/>

<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llistat d'Avaluacions</h1>

@if($groupedEvaluations->count() > 0)
<div class="flex justify-between items-center">
    <div>
        <x-partials.search-bar />
    </div>
    <div class="flex gap-4">
        <a href="{{ route('professional_evaluations.downloadCSV') }}" class="btn btn-sm btn-secondary">Descarregar Llistat</a>
        {{-- <a href="{{ route('professional_evaluations_quiz_form') }}" class="btn btn-sm btn-primary">Afegir Evaluació</a> --}}
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg/10 overflow-x-auto border border-gray-500/20">
    @if($groupedEvaluations->count() > 0)
        <div id="tableToSearch-container" data-url="/professionals/evaluations/list">
            @include('components.contents.professional.evaluations.tables.professionalEvaluationsListTable')
        </div>
    @else
        <div class="text-center py-12">
            <h3 class="text-xl font-bold text-base-content mb-2">Encara no hi ha avaluacions registrades</h3>
            <a href="{{ route('professional_evaluations_quiz_form') }}" class="btn btn-primary">Afegir Primera Avaluació</a>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
