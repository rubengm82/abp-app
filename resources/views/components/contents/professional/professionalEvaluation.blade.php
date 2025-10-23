@extends('app')

@section('content')

<x-partials.breadcrumb
    :items="[
        'Professionals' => route('professionals_list'),
        'Llistat' => route('professionals_list'),
    ]"
    :current="'Qüestionari valoració'"
    />

<div class="max-w-6xl mx-auto bg-base-100 text-base-content p-6 rounded shadow">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Qüestionari valoració del/la professional</h1>
    </div>

    <!-- Professional Information -->
    <div class="card bg-base-100 text-base-content shadow-xl mb-6">
        <div class="card-body">
            <h2 class="card-title text-xl mb-4">Professional a avaluar: <span class="text-primary font-bold">Yoel Berjaga García</span></h2>
        </div>
    </div>

    <!-- Evaluation Form -->
    <form class="space-y-6">
        <div class="card bg-base-100 text-base-content shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-xl mb-6">Avaluació del professional</h2>

                <!-- EJEMPLO CON UN ARRAY HARDCODEADO, MODIFICAR A UTLIZAR RESPUESTAS DE BASE DE DATOS -->
                @php
                    $evaluationQuestions = [
                        'Realitza una correcta atenció a l\'usuari',
                        'Es preocupa per satisfer les seves necessitats dins dels recursos dels que disposa',
                        'S\'ha integrat dins l\'equip de treball i participa i coopera sense dificultats',
                        'Pot treballar amb altres equips diferents al seu si es necessita',
                        'Compleix amb les funcions establertes',
                        'Assoleix els objectius utilitzant els recursos disponibles per aconseguir els resultats esperats',
                        'És coherent amb el que diu i amb les seves actuacions',
                        'Les seves actuacions van alineades amb els valors de la nostra Entitat',
                        'Mostra capacitat i interès en entendre i aplicar la normativa i els procediments establerts',
                        'La seva actitud envers els seus responsables/comandaments és correcta',
                        'Té capacitat per a comprendre i acceptar i adequar-se als canvis',
                        'Desenvolupa amb autonomia les seves funcions, sense necessitat de recolzament immediat/constant',
                        'Fa suggeriments i propostes de millora',
                        'Assoleix els objectius, esforçant-se per aconseguir el resultat esperat',
                        'La quantitat de treball que desenvolupa en relació amb el treball encomanat és adequada',
                        'Realitza les tasques amb la qualitat esperada i/o necessària',
                        'Expressa amb claredat i ordre els aspectes rellevants de la informació',
                        'Disposa del coneixements necessaris per a desenvolupar les tasques requerides del lloc de treball',
                        'Mostra interès i motivació envers el seu lloc de treball',
                        'La seva entrada i permanència en el lloc de treball es duu a terme sense retards o absències no justificades'
                    ];
                @endphp
                
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead >
                            <tr class="bg-base-300 text-base-content font-semibold">
                                <th class="w-1/2">Pregunta</th>
                                <th class="text-center">Gens d'acord</th>
                                <th class="text-center">Poc d'acord</th>
                                <th class="text-center">Bastant d'acord</th>
                                <th class="text-center">Molt d'acord</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- EJEMPLO CON UN ARRAY HARDCODEADO, MODIFICAR A UTLIZAR RESPUESTAS DE BASE DE DATOS -->
                            @foreach($evaluationQuestions as $index => $question)
                                <tr>
                                    <td class="font-medium">{{ $index + 1 }}. {{ $question }}</td>
                                    @for($i = 0; $i < 4; $i++)
                                        <td class="text-center">
                                            <input type="radio" name="question_{{ $index + 1 }}" value="{{ $i }}" class="radio radio-primary">
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                            <!-- <tr>
                                <td class="font-medium">10. Satisfacció general amb el professional</td>
                                <td class="text-center">
                                    <input type="radio" name="question_10" value="0" class="radio radio-primary">
                                </td>
                                <td class="text-center">
                                    <input type="radio" name="question_10" value="1" class="radio radio-primary">
                                </td>
                                <td class="text-center">
                                    <input type="radio" name="question_10" value="2" class="radio radio-primary">
                                </td>
                                <td class="text-center">
                                    <input type="radio" name="question_10" value="3" class="radio radio-primary">
                                </td>
                            </tr> -->
                    </table>
                </div>

                <div class="flex justify-end mt-8">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <x-partials.icon name="check-circle" class="w-5 h-5 mr-2" />
                        Enviar avaluació
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@include('components.partials.mainToasts')
@endsection