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
                    <th class="px-4 py-2 text-left">Centre de Formació</th>
                    <th class="px-4 py-2 text-left">Codi FORCEM</th>
                    <th class="px-4 py-2 text-left">Hores totals</th>
                    <th class="px-4 py-2 text-left">Tipus de curs</th>
                    <th class="px-4 py-2 text-left">Modalitat</th>
                    <th class="px-4 py-2 text-left">Nom del curs</th>
                    <th class="px-4 py-2 text-left">Taller</th>
                    <th class="px-4 py-2 text-left">Dia de conferència</th>
                    <th class="px-4 py-2 text-left">Congrés</th>
                    <th class="px-4 py-2 text-left">Assistents</th>
                    <th class="px-4 py-2 text-left">Data d’inici</th>
                    <th class="px-4 py-2 text-left">Data de finalització</th>
                    <th class="px-4 py-2 text-right">Acció</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                    <tr class="hover:bg-base-300 transition-colors">
                        <td class="px-4 py-2">{{ Str::limit($course->id, 12) }}</td>
                        <td class="px-4 py-2">{{ Str::limit($course->training_center, 20) }}</td>
                        <td class="px-4 py-2">{{ Str::limit($course->forcem_code, 12) }}</td>
                        <td class="px-4 py-2">{{ Str::limit($course->total_hours, 12) }}</td>
                        <td class="px-4 py-2">{{ Str::limit($course->type, 12) }}</td>
                        <td class="px-4 py-2">{{ Str::limit($course->attendance_type, 12) }}</td>
                        <td class="px-4 py-2 font-medium">{{ Str::limit($course->training_name, 20) }}</td>
                        <td class="px-4 py-2">{{ Str::limit($course->workshop, 20) }}</td>
                        <td class="px-4 py-2">{{ Str::limit($course->conference_day, 12) }}</td>
                        <td class="px-4 py-2">{{ Str::limit($course->congress, 20) }}</td>
                        <td class="px-4 py-2">{{ Str::limit($course->attendee, 20) }}</td>
                        <td class="px-4 py-2">{{ Str::limit(\Carbon\Carbon::parse($course->start_date)->format('d/m/Y'), 20) }}</td>
                        <td class="px-4 py-2">{{ Str::limit(\Carbon\Carbon::parse($course->end_date)->format('d/m/Y'), 20) }}</td>
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
