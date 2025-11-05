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
    <a href="{{ route('professional_evaluations.downloadCSV') }}" class="btn btn-sm btn-warning">Descarregar Llistat</a>
    <a href="{{ route('professional_evaluations_quiz_form') }}" class="btn btn-sm btn-primary">Afegir Evaluació</a>
</div>
@endif

<div class="max-w-full mx-auto bg-base-100 mt-3 p-6 rounded-lg shadow-lg overflow-x-auto">
    @if($groupedEvaluations->count() > 0)
        <table class="table w-full table-xs table-hover text-sm">
            <thead>
                <tr class="bg-base-300 text-base-content font-semibold">
                    <th class="px-4 py-2 text-left">Avaluat</th>
                    <th class="px-4 py-2 text-left">Avaluador</th>
                    <th class="px-4 py-2 text-left">Data de l'Avaluació</th>
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
                        {{ $group->first()->created_at->toDateTimeString() }}
                    </td>

                    <td class="px-4 py-2 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('professional_evaluation_quiz_show', [$group->first()->evaluated_professional_id, $group->first()->evaluator_professional_id, $group->first()->evaluation_uuid]) }}" class="btn btn-xs btn-info">Veure</a>
                        </div>
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
