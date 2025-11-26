@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Temes pendents RRHH' => null,
    ]"
    :current="'Llistat'"
    />

    
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llistat de temes pendents RRHH</h1>


@if($hrIssues->count() > 0)
<div class="flex justify-between items-center">
    <div>
        <x-partials.search-bar />
    </div>
    <div class="flex gap-2">
        <a href="{{ route('hr_issue.downloadCSV') }}" class="btn btn-sm btn-warning">Descarregar Llistat</a>
        <a href="{{ route('hr_issue_form') }}" class="btn btn-sm btn-primary">Afegir Tema pendent</a>
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($hrIssues->count() > 0)
        <div id="tableToSearch-container" data-url="/hr_issues/list">
            @include('components.contents.hrIssue.tables.hrIssuesListTable')
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-base-content/50 text-lg mb-4">
                <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-base-content mb-2">Encara no hi ha temes pendents registrats</h3>
            <p class="text-base-content/70 mb-4">Comença afegint el primer tema pendent a la base de dades.</p>
            <a href="{{ route('hr_issue_form') }}" class="btn btn-primary">Afegir Primer Tema pendent</a>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection

