@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Professionals' => route('professionals_list'),
        'Avaluacions' => route('professional_evaluations_list'),
    ]"
    :current="'Detalls'"
/>

<div class="w-full mx-auto bg-base-100 text-base-content p-6 rounded shadow text-sm">
    <!-- Page Title -->
    <div class="flex justify-center items-center mb-6">
        <h1 class="text-2xl font-bold text-center">Resultat de la valoració del/la professional</h1>
    </div>
    
    <!-- Evaluation Show -->
    <div class="card bg-base-100 text-base-content shadow-xl mb-6 text-sm">
        <div class="card-body">
            <h2 class="card-title text-lg mb-2">
                Professional evaluat:
                <span class="text-primary">
                    {{ $professionalEvaluated->first()->name }}
                    {{ $professionalEvaluated->first()->surname1 }}
                    {{ $professionalEvaluated->first()->surname2 }}
                    {{ $professionalEvaluated->first()->evaluation_uuid }}
                </span>
            </h2>
            <p class="card-title text-sm">
                Professional evaluador:
                <span>
                    {{ $professionalEvaluator->first()->name }}
                    {{ $professionalEvaluator->first()->surname1 }}
                    {{ $professionalEvaluator->first()->surname2 }}
                </span>
            </p>
            <p>Data de l'Avaluació: {{ $answers->first()?->created_at?->format('d/m/Y H:i:s') ?? '' }}</p>

            <div class="flex justify-end gap-4 mt-4">
                <a href="{{ route('professional_evaluation_quiz_downloadCSV', $answers->first()->evaluation_uuid) }}" 
                   class="btn btn-sm btn-warning text-sm">
                   Descarregar Avaluació
                </a>
                <x-partials.modal 
                    id="deleteEvaluation{{ $professionalEvaluated->first()->id }}" 
                    msj="Estàs segur que vols eliminar aquesta avalució?" 
                    btnText="Eliminar" 
                    class="btn-sm btn-error text-sm" 
                    width="60">
                    
                    <form action="{{ route('professional_evaluations_delete') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="evaluation_uuid" value="{{ $answers->first()->evaluation_uuid }}">
                        <button type="submit" class="btn btn-sm btn-error text-sm">Acceptar</button>
                    </form>
                </x-partials.modal>
            </div>
        </div>
    </div>

    <div class="card bg-base-100 text-base-content shadow-xl text-sm">
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table w-full text-sm rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-primary text-white font-semibold text-sm rounded-t-lg">
                            <th class="w-1/2 px-3 py-2">Pregunta</th>
                            <th class="text-center px-3 py-2">Gens d'acord</th>
                            <th class="text-center px-3 py-2">Poc d'acord</th>
                            <th class="text-center px-3 py-2">Bastant d'acord</th>
                            <th class="text-center px-3 py-2">Molt d'acord</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $question)
                            <tr class="hover:bg-base-300">
                                <td class="font-medium text-xs px-3 py-2">{{ $question->question }}</td>
                                @for ($i = 0; $i < 4; $i++)
                                    <td class="text-center px-3 py-2">
                                        <input type="radio"
                                            name="questions[{{ $question->id }}]"
                                            value="{{ $i }}"
                                            class="radio radio-primary radio-xs disabled:opacity-100 disabled:cursor-default"
                                            @foreach($answers as $answer)
                                                @if($answer->question_id == $question->id && $answer->answer == $i)
                                                    checked
                                                @endif
                                            @endforeach
                                            disabled
                                        />
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 p-4 bg-base-200 rounded shadow text-center">
                <span class="font-semibold">Percentatge mitjà de l'avaluació:</span>
                <span class="text-primary text-lg">{{ $averagePercentage }}%</span>
            </div>

            <div class="flex justify-end gap-4 mt-4">
                <a href="{{ route('professional_evaluations_list') }}" class="btn btn-outline text-sm">Tornar</a>
            </div>
        </div>
    </div>

</div>

@include('components.partials.mainToasts')
@endsection
