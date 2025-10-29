@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Cursos' => null,
    ]"
    :current="'Llistat'"
/>

<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llista de cursos</h1>

@if($courses->count() > 0)
<div class="flex justify-end gap-4">
    <a href="{{ route('courses_downloadCSV') }}" class="btn btn-sm btn-warning">Descarregar Llista</a>
    <a href="{{ route('course_form') }}" class="btn btn-sm btn-primary">Afegir Curs</a>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($courses->count() > 0)
        <table class="table w-full table-xs table-hover text-sm">
            <thead>
                <tr class="bg-base-300 text-base-content font-semibold">
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Nom del curs</th>
                    <th class="px-4 py-2 text-left">Centre de Formació</th>
                    <th class="px-4 py-2 text-left">Codi FORCEM</th>
                    <th class="px-4 py-2 text-left">Modalitat</th>
                    <th class="px-4 py-2 text-left">Data d'inici</th>
                    <th class="px-4 py-2 text-right">Acció</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                    <tr class="hover:bg-base-300 transition-colors">
                        <td class="px-4 py-2">{{ $course->id }}</td>
                        <td class="px-4 py-2 font-medium">{{ Str::limit($course->training_name, 30) }}</td>
                        <td class="px-4 py-2">{{ Str::limit($course->training_center, 25) }}</td>
                        <td class="px-4 py-2">{{ Str::limit($course->forcem_code, 15) }}</td>
                        <td class="px-4 py-2">{{ $course->attendance_type ?? 'No especificada' }}</td>
                        <td class="px-4 py-2">{{ $course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('d/m/Y') : 'No especificada' }}</td>
                        <td class="px-4 py-2 text-right flex justify-end gap-2">
                            <a href="{{ route('course_show', $course) }}" class="btn btn-xs btn-info">Veure</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center py-12">
            <h3 class="text-xl font-semibold text-base-content mb-2">Encara no hi ha cursos registrats</h3>
            <p class="text-base-content/70 mb-4">Comença afegint el primer curs a la base de dades.</p>
            {{-- <a href="{{ route('course_form') }}" class="btn btn-primary">Afegir Primer Curs</a> --}}
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
