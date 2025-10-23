<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
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

        foreach ($questions as $question) {
            DB::table('quiz')->insert([
                'question' => $question,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
