<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ComplementaryService;
use Illuminate\Support\Facades\DB;

class ComplementaryServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Truncate table (borra todo y reinicia IDs)
        DB::table('complementary_services')->truncate();

        $services = [

            // ===== CENTER 1 =====
            [
                'center_id' => 1,
                'service_type' => 'Taller de gestió de l’estrès i mindfulness',
                'service_responsible' => 'Psicòleg Jordi Roca',
                'start_date' => '2024-01-15',
                'end_date' => '2024-02-15',
                'status' => 1,
            ],
            [
                'center_id' => 1,
                'service_type' => 'Taller d’habilitats socials per a adolescents',
                'service_responsible' => 'Psicòloga Marta Soler',
                'start_date' => '2024-02-05',
                'end_date' => '2024-03-05',
                'status' => 1,
            ],
            [
                'center_id' => 1,
                'service_type' => 'Taller de memòria i estimulació cognitiva per a gent gran',
                'service_responsible' => 'Psicòloga Laura Cortès',
                'start_date' => '2024-03-10',
                'end_date' => '2024-04-10',
                'status' => 1,
            ],
            [
                'center_id' => 1,
                'service_type' => 'Grup de suport emocional per a famílies',
                'service_responsible' => 'Psicòloga Anna Puig',
                'start_date' => '2024-04-01',
                'end_date' => '2024-05-01',
                'status' => 1,
            ],
            [
                'center_id' => 1,
                'service_type' => 'Taller d’autoestima i creixement personal',
                'service_responsible' => 'Psicòloga Irene Mas',
                'start_date' => '2024-05-20',
                'end_date' => '2024-06-20',
                'status' => 1,
            ],
            [
                'center_id' => 1,
                'service_type' => 'Assessorament i suport a cuidadors',
                'service_responsible' => 'Treballadora social Silvia Dalmau',
                'start_date' => '2024-06-15',
                'end_date' => '2024-07-15',
                'status' => 1,
            ],
            [
                'center_id' => 1,
                'service_type' => 'Sessions d’artteràpia',
                'service_responsible' => 'Terapeuta Júlia Mariné',
                'start_date' => '2024-07-10',
                'end_date' => '2024-08-10',
                'status' => 1,
            ],

            // ===== CENTER 2 =====
            [
                'center_id' => 2,
                'service_type' => 'Programa de regulació emocional',
                'service_responsible' => 'Psicòloga Maria Genís',
                'start_date' => '2024-02-18',
                'end_date' => '2024-03-18',
                'status' => 1,
            ],
            [
                'center_id' => 2,
                'service_type' => 'Grup de teràpia breu estratègica',
                'service_responsible' => 'Dra. Clara Rovira',
                'start_date' => '2024-03-25',
                'end_date' => '2024-04-25',
                'status' => 1,
            ],
            [
                'center_id' => 2,
                'service_type' => 'Sessions psicoeducatives per a famílies',
                'service_responsible' => 'Psicòloga Júlia Mariné',
                'start_date' => '2024-04-12',
                'end_date' => '2024-05-12',
                'status' => 1,
            ],
            [
                'center_id' => 2,
                'service_type' => 'Tallers d’orientació laboral per a joves',
                'service_responsible' => 'Educadora Laura Torres',
                'start_date' => '2024-05-05',
                'end_date' => '2024-06-05',
                'status' => 1,
            ],
            [
                'center_id' => 2,
                'service_type' => 'Activitats de lleure i esport adaptat',
                'service_responsible' => 'Coordinador Oriol Prats',
                'start_date' => '2024-06-01',
                'end_date' => '2024-07-01',
                'status' => 1,
            ],
            [
                'center_id' => 2,
                'service_type' => 'Suport nutricional i saludable',
                'service_responsible' => 'Dietista Clara Vilaseca',
                'start_date' => '2024-06-20',
                'end_date' => '2024-07-20',
                'status' => 1,
            ],
            [
                'center_id' => 2,
                'service_type' => 'Coordinació amb serveis sanitaris externs',
                'service_responsible' => 'Treballadora social Marta Domènech',
                'start_date' => '2024-07-08',
                'end_date' => '2024-08-08',
                'status' => 1,
            ],
            [
                'center_id' => 2,
                'service_type' => 'Taller de relaxació i respiració',
                'service_responsible' => 'Psicòleg Marc Ferrer',
                'start_date' => '2024-07-22',
                'end_date' => '2024-08-22',
                'status' => 1,
            ],
        ];

        // Insert services
        foreach ($services as $service) {
            ComplementaryService::create($service);
        }
    }
}
