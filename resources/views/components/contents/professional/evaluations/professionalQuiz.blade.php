@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Professionals' => route('professionals_list'),
        'Avaluacions' => route('professional_evaluations_list'),
    ]"
    :current="'Qüestionari valoració'"
/>

<div class="w-full mx-auto bg-base-100 text-base-content p-6 rounded shadow text-sm">
    <!-- Page Title -->
    <div class="flex justify-center items-center mb-6">
        <h1 class="text-2xl font-bold text-center">Qüestionari de la valoració del/la professional</h1>
    </div>
    
    <!-- Evaluation Form -->
    <form action="{{ route('professional_evaluations_add') }}" method="post" class="space-y-6 text-sm">
        @csrf
        
        <!-- Evaluator | Evaluated -> Card -->  
        <div class="card bg-base-100 text-base-content shadow-xl mb-6 text-sm">
            <div class="card-body">
                <h2 class="card-title text-lg mb-2">Selecciona els professionals</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Avaluat -->
                    <div>
                        <label for="avaluat" class="block font-semibold mb-1 text-primary">(*) Professional a Avaluar:</label>
                        <select id="avaluat" name="avaluat" class="select select-bordered w-full text-sm" required>
                            <option value="">Selecciona un professional</option>
                            @foreach($professionals as $professional)
                                <option value="{{ $professional->id }}">
                                    {{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Evaluador -->
                    <div>
                        <label for="evaluador" class="block font-medium mb-1">(*) Professional Avaluador:</label>
                        <select id="evaluador" name="evaluador" class="select select-bordered w-full text-sm" required>
                            <option value="">Selecciona un professional</option>
                            @foreach($professionals as $professional)
                                <option value="{{ $professional->id }}">
                                    {{ $professional->name }} {{ $professional->surname1 }} {{ $professional->surname2 }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Questions Table -->
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
                                    <td class="font-medium text-xs px-3 py-2">
                                        {{ $question->question }}

                                        <div class="text-xs text-gray-500 mt-1">
                                            Mitjana: <span class="font-semibold">{{ $questionAverages[$question->id] ?? 0 }}%</span> —
                                            @if (($questionAverages[$question->id] ?? 0) <= 25)
                                                Gens d'acord
                                            @elseif (($questionAverages[$question->id] ?? 0) <= 50)
                                                Poc d'acord
                                            @elseif (($questionAverages[$question->id] ?? 0) <= 75)
                                                Bastant d'acord
                                            @else
                                                Molt d'acord
                                            @endif
                                        </div>
                                    </td>
                                    @for ($i = 0; $i < 4; $i++)
                                        <td class="text-center px-3 py-2">
                                            <input 
                                                type="radio" 
                                                name="questions[{{ $question->id }}]" 
                                                value="{{ $i }}" 
                                                class="radio radio-primary radio-xs"
                                                {{ old("questions.{$question->id}") === (string) $i ? 'checked' : '' }}
                                                required
                                            />
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Observation -->
        <div class="card bg-base-100 text-base-content shadow-xl text-sm">
            <div class="card-body">
                <h2 class="card-title text-lg mb-2">Observació</h2>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Observació (opcional)</span>
                    </label>
                    <textarea name="observation" id="id_observation" rows="4" placeholder="Afegeix una observació o comentari sobre l'avaluació..." class="textarea textarea-bordered w-full">{{ old('observation') }}</textarea>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end gap-4 mt-4">
            <a href="{{ route('professional_evaluations_list') }}" class="btn btn-outline">Cancel·lar</a>
            <button type="submit" class="btn btn-info">
                Crear Avaluació
            </button>
        </div>
    </form>
</div>

@include('components.partials.mainToasts')
@endsection
