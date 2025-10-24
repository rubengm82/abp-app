@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Cursos' => null,
    ]"
    :current="'Llistat'"
/>

<h1 class="text-3xl font-bold text-base-content mb-6 text-center">Llista de cursos</h1>

@if($courses->where('status', 1)->count() > 0)
<div class="flex justify-end gap-4">
    {{-- <a href="{{ route('courses.downloadCSV', ['status' => 1]) }}" class="btn btn-sm btn-warning">Descarregar Llista</a> --}}
    {{-- <a href="{{ route('course_form') }}" class="btn btn-sm btn-primary">Afegir Curs</a> --}}
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($courses->where('status', 1)->count() > 0)
        <table class="table w-full table-xs table-hover text-sm">
            <thead>
                <tr class="bg-base-300 text-base-content font-semibold">
                    <th class="px-4 py-2 text-left">ID</th>
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
                    @if($course->status == 1)
                        <tr class="hover:bg-base-300 transition-colors">
                            <td class="px-4 py-2">{{ $course->id }}</td>
                            <td class="px-4 py-2">{{ $course->forcem_code }}</td>
                            <td class="px-4 py-2">{{ $course->total_hours }}</td>
                            <td class="px-4 py-2">{{ $course->type }}</td>
                            <td class="px-4 py-2">{{ $course->attendance_type }}</td>
                            <td class="px-4 py-2 font-medium">{{ $course->training_name }}</td>
                            <td class="px-4 py-2">{{ $course->workshop }}</td>
                            <td class="px-4 py-2">{{ $course->conference_day }}</td>
                            <td class="px-4 py-2">{{ $course->congress }}</td>
                            <td class="px-4 py-2">{{ $course->attendee }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($course->start_date)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($course->end_date)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-right flex justify-end gap-2">
                                {{-- <a href="{{ route('course_show', $course) }}" class="btn btn-xs btn-info">Veure</a> --}}
                            </td>
                        </tr>
                    @endif
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
