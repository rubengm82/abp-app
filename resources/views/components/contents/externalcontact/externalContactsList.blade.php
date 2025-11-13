@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Contactes Externs' => null,
    ]"
    :current="'Llistat'"
    />
<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llistat de contactes externs</h1>

@if($externalContacts->count() > 0)
<div class="flex justify-between items-center mb-3">
    <div>
        <x-partials.search-bar />
    </div>
    <div class="flex gap-4">
        <a href="{{ route('externalcontacts.downloadCSV') }}" class="btn btn-sm btn-warning">Descarregar Llistat</a>
        <a href="{{ route('externalcontact_form') }}" class="btn btn-sm btn-primary">Afegir Contacte Extern</a>
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($externalContacts->count() > 0)
        <div id="tableToSearch-container" data-url="/externalcontacts/list">
            @include('components.contents.externalcontact.tables.externalContactsListTable')
        </div>
    @else
        <div class="text-center py-12">
            <h3 class="text-xl font-semibold text-base-content mb-2">Encara no hi ha contactes externs registrats</h3>
            <a href="{{ route('externalcontact_form') }}" class="btn btn-primary">Afegir Primer Contacte Extern</a>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection

