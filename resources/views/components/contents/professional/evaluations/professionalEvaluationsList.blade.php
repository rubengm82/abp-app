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
<div class="flex justify-end gap-4">
    <a href="{{ route('professional_evaluations.downloadCSV') }}" class="btn btn-sm btn-warning">Descarregar Llista</a>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($groupedEvaluations->count() > 0)
        <table class="table w-full table-xs table-hover text-sm">
            <thead>
                <tr class="bg-base-300 text-base-content font-semibold">
                    <th class="px-4 py-2 text-left">Avaluat</th>
                    <th class="px-4 py-2 text-left">Avaluador</th>
                    <th class="px-4 py-2 text-left">Data de Creació</th>
                    <th class="px-4 py-2 text-right">Acció</th>
                </tr>
            </thead>
            <tbody>
                @foreach($groupedEvaluations as $evaluatedId => $group)
                <tr class="hover:bg-base-300 transition-colors">
                    <td class="px-4 py-2">
                        {{ optional($group->first()->evaluatedProfessional)->name }}
                        {{ optional($group->first()->evaluatedProfessional)->surname1 }}
                        {{ optional($group->first()->evaluatedProfessional)->surname2 }}
                    </td>

                   <td class="px-4 py-2">
                        {{ optional($group->first()->evaluatorProfessional)->name }}
                        {{ optional($group->first()->evaluatorProfessional)->surname1 }}
                        {{ optional($group->first()->evaluatorProfessional)->surname2 }}
                    </td>

                    <td class="px-4 py-2">
                        {{ $group->first()->created_at->toDateString() }}
                    </td>

                    <td class="px-4 py-2 text-right">
                        <a href="" class="btn btn-xs btn-info">Veure</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center py-12">
            <h3 class="text-xl font-semibold text-base-content mb-2">Encara no hi ha avaluacions registrades</h3>
            <p class="text-base-content/70 mb-4">Comença afegint la primera avaluació a la base de dades.</p>
        </div>
    @endif
</div>

@include('components.partials.mainToasts')
@endsection
