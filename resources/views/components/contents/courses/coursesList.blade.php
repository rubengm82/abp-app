@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Cursos' => null,
    ]"
    :current="'Llistat'"
/>

<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llistat de cursos</h1>

@if($courses->count() > 0)
<div class="flex justify-between items-center">
    <div>
        <x-partials.search-bar />
    </div>
    <div class="flex gap-4">
        <a href="{{ route('courses_downloadCSV') }}" class="btn btn-sm btn-secondary">Descarregar Llistat</a>
        {{-- <a href="{{ route('course_form') }}" class="btn btn-sm btn-primary">Afegir Curs</a> --}}
    </div>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg/10 overflow-x-auto border border-gray-500/20">
    @if($courses->count() > 0)
        <div id="tableToSearch-container" data-url="/courses/list">
            @include('components.contents.courses.tables.coursesListTable')
        </div>
    @else
        <div class="text-center py-12">
            <h3 class="text-xl font-bold text-base-content mb-2">Encara no hi ha cursos registrats</h3>
            <a href="{{ route('course_form') }}" class="btn btn-primary">Afegir Primer Curs</a>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
