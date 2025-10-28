@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Professionals' => route('professionals_list'),
        'Avaluacions' => route('professional_evaluations_list'),
    ]"
    :current="'Qüestionari valoració'"
/>

<div class="w-full mx-auto bg-base-100 text-base-content p-6 rounded shadow">
    <!-- Page Title -->
    <div class="flex justify-center items-center mb-6">
        <h1 class="text-2xl font-bold text-center">Qüestionari valoració del/la professional</h1>
    </div>
    
    <!-- Evaluation Form -->
    <form action="{{ route('professional_evaluations_add') }}" method="post" class="space-y-6">
        @csrf
        
        <!-- Evaluator | Evaluated -> Card -->  
        <div class="card bg-base-100 text-base-content shadow-xl mb-6">
            <div class="card-body">
                <h2 class="card-title text-lg mb-4">Selecciona els professionals</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Avaluat -->
                    <div>
                        <label for="avaluat" class="block font-semibold mb-2 text-primary">(*) Professional a Avaluar:</label>
                        <select id="avaluat" name="avaluat" class="select select-bordered w-full" required>
                            <option value="">Selecciona un professional</option>
                            <option value="6">Carles Molina González</option>
                            <option value="5">Anna Torres Vargas</option>
                        </select>
                    </div>
                    
                    <!-- Evaluador -->
                    <div>
                        <label for="evaluador" class="block font-medium mb-2">(*) Professional Avaluador: <i>(Directiu o Administració)</i></label>
                        <select id="evaluador" name="evaluador" class="select select-bordered w-full" required>
                            <option value="">Selecciona un professional</option>
                            <option value="2">Joan García Martínez</option>
                            <option value="3">Maria López Fernández</option>
                        </select>
                    </div>
                    
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
                                    {{-- The Question --}}
                                    <td class="font-medium">{{ $question->question }}</td>
                                    
                                    {{-- Radio Buttons --}}
                                    @for ($i = 0; $i < 4; $i++)
                                        <td class="text-center">
                                            <input type="radio" 
                                                name="questions[{{ $question->id }}]" 
                                                value="{{ $i }}" 
                                                class="radio radio-primary radio-xs" 
                                                {{ $i === 0 ? 'checked' : '' }} {{-- DEFAULT OPTION --}}
                                                required>
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
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
                    <a href="{{ route('professional_evaluations_list') }}" class="btn btn-outline">Cancel·lar</a>
                    <button type="submit" class="btn btn-info ">
                        Crear Avaluació
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>

@include('components.partials.mainToasts')
@endsection
