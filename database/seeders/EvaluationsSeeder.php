<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EvaluationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('evaluations')->truncate();

        $evaluations = [];

        $evaluators = [2, 3, 4];             // Quienes evalúan
        $evaluatedProfessionals = [1, 2, 3]; // Evaluados

        foreach ($evaluatedProfessionals as $index => $evaluatedId) {

            $uuid_pre_generated = Str::uuid()->toString(); 
            $evaluator = $evaluators[$index];

            for ($question = 1; $question <= 20; $question++) {
                $evaluations[] = [
                    'evaluator_professional_id'   => $evaluator,
                    'evaluated_professional_id'   => $evaluatedId,
                    'question_id'                 => $question,
                    'answer'                      => rand(0, 3),
                    'evaluation_uuid'             => $uuid_pre_generated,
                    'created_at'                  => now(),
                    'updated_at'                  => now(),
                ];
            }
        }

        DB::table('evaluations')->insert($evaluations);
    }

}
