<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvaluationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Test evaluation data
        $evaluations = [];

        // Evaluation 1 - Professional 1 evaluating Professional 2
        for ($question = 1; $question <= 20; $question++) {
            $evaluations[] = [
                'evaluator_professional_id' => 1,
                'evaluated_professional_id' => 2,
                'question_id' => $question,
                'answer' => rand(0, 3),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Evaluation 2 - Professional 2 evaluating Professional 3
        for ($question = 1; $question <= 20; $question++) {
            $evaluations[] = [
                'evaluator_professional_id' => 2,
                'evaluated_professional_id' => 3,
                'question_id' => $question,
                'answer' => rand(0, 3),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Evaluation 3 - Professional 3 evaluating Professional 1
        for ($question = 1; $question <= 20; $question++) {
            $evaluations[] = [
                'evaluator_professional_id' => 3,
                'evaluated_professional_id' => 1,
                'question_id' => $question,
                'answer' => rand(0, 3),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach ($evaluations as $evaluation) {
            DB::table('evaluations')->insert($evaluation);
        }
    }
}
