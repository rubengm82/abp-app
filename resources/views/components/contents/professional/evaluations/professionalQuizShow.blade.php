@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Professionals' => route('professionals_list'),
        'Avaluacions' => route('professional_evaluations_list'),
    ]"
    :current="'Detalls'"
/>

<div class="w-full mx-auto bg-base-100 text-base-content p-6 rounded shadow">
    <!-- Page Title -->
    <div class="flex justify-center items-center mb-6">
        <h1 class="text-2xl font-bold text-center">Resultat de la valoració del/la professional</h1>
    </div>
    
    <!-- Evaluation Show -->
    <!-- Evaluator | Evaluated -> Card -->  
    <div class="card bg-base-100 text-base-content shadow-xl mb-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">
                Professional evaluat:
                <span class="text-primary">
                    {{ $professionalEvaluated->first()->name }}
                    {{ $professionalEvaluated->first()->surname1 }}
                    {{ $professionalEvaluated->first()->surname2 }}
                </span>
            </h2>
            <p class="card-title text-base">
                Professional evaluador:
                <span>
                    {{ $professionalEvaluator->first()->name }}
                    {{ $professionalEvaluator->first()->surname1 }}
                    {{ $professionalEvaluator->first()->surname2 }}
                </span>
            </p>
            <p>Data de l'Avaluació: {{ $answers->first()?->created_at?->format('d/m/Y H:i:s') ?? '' }}</p>
            <div class="flex justify-end gap-4 mt-8">
                <a href="{{ route('professional_evaluation_quiz_downloadCSV', $answers->first()->evaluation_uuid) }}" 
                   class="btn btn-sm btn-warning">
                   Descarregar Avaluació
                </a>
            </div>
        </div>
    </div>


    <div class="card bg-base-100 text-base-content shadow-xl">
        <div class="card-body">
                
            <div class="overflow-x-auto">
                <table class="table table-hover w-full text-sm">
                    <thead >
                        <tr class="bg-primary text-black font-semibold">
                            <th class="w-1/2 text-lg">Pregunta</th>
                            <th class="text-center text-lg">Gens d'acord</th>
                            <th class="text-center text-lg">Poc d'acord</th>
                            <th class="text-center text-lg">Bastant d'acord</th>
                            <th class="text-center text-lg">Molt d'acord</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $index => $question)
                            <tr class="hover:bg-base-300">

                                <td class="font-medium">{{ $question->question }}</td>
                                
                                @for ($i = 0; $i < 4; $i++)
                                    <td class="text-center">
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
                    <tbody >
                        <tr class="bg-primary text-black font-semibold">
                            <th class="w-1/2 text-lg">Pregunta</th>
                            <th class="text-center text-lg">Gens d'acord</th>
                            <th class="text-center text-lg">Poc d'acord</th>
                            <th class="text-center text-lg">Bastant d'acord</th>
                            <th class="text-center text-lg">Molt d'acord</th>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-4 mt-8">
                <a href="{{ route('professional_evaluations_list') }}" class="btn btn-outline">Tornar</a>
            </div>
        </div>
    </div>

</div>

@include('components.partials.mainToasts')
@endsection
