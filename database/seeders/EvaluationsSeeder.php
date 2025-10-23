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
        $evaluations = [
            // Evaluation 1 - Professional 1 evaluating Professional 2
            [
                'evaluation_id' => 'EVAL-001-2024',
                'evaluator_professional_id' => 1,
                'evaluated_professional_id' => 2,
                'question_id' => 1,
                'answer' => 3,
                'evaluation_date' => '2024-01-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'evaluation_id' => 'EVAL-001-2024',
                'evaluator_professional_id' => 1,
                'evaluated_professional_id' => 2,
                'question_id' => 2,
                'answer' => 2,
                'evaluation_date' => '2024-01-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'evaluation_id' => 'EVAL-001-2024',
                'evaluator_professional_id' => 1,
                'evaluated_professional_id' => 2,
                'question_id' => 3,
                'answer' => 3,
                'evaluation_date' => '2024-01-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'evaluation_id' => 'EVAL-001-2024',
                'evaluator_professional_id' => 1,
                'evaluated_professional_id' => 2,
                'question_id' => 4,
                'answer' => 2,
                'evaluation_date' => '2024-01-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'evaluation_id' => 'EVAL-001-2024',
                'evaluator_professional_id' => 1,
                'evaluated_professional_id' => 2,
                'question_id' => 5,
                'answer' => 3,
                'evaluation_date' => '2024-01-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Evaluation 2 - Professional 2 evaluating Professional 3
            [
                'evaluation_id' => 'EVAL-002-2024',
                'evaluator_professional_id' => 2,
                'evaluated_professional_id' => 3,
                'question_id' => 1,
                'answer' => 2,
                'evaluation_date' => '2024-01-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'evaluation_id' => 'EVAL-002-2024',
                'evaluator_professional_id' => 2,
                'evaluated_professional_id' => 3,
                'question_id' => 2,
                'answer' => 3,
                'evaluation_date' => '2024-01-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'evaluation_id' => 'EVAL-002-2024',
                'evaluator_professional_id' => 2,
                'evaluated_professional_id' => 3,
                'question_id' => 3,
                'answer' => 2,
                'evaluation_date' => '2024-01-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'evaluation_id' => 'EVAL-002-2024',
                'evaluator_professional_id' => 2,
                'evaluated_professional_id' => 3,
                'question_id' => 4,
                'answer' => 3,
                'evaluation_date' => '2024-01-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'evaluation_id' => 'EVAL-002-2024',
                'evaluator_professional_id' => 2,
                'evaluated_professional_id' => 3,
                'question_id' => 5,
                'answer' => 2,
                'evaluation_date' => '2024-01-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Evaluation 3 - Professional 3 evaluating Professional 1
            [
                'evaluation_id' => 'EVAL-003-2024',
                'evaluator_professional_id' => 3,
                'evaluated_professional_id' => 1,
                'question_id' => 1,
                'answer' => 3,
                'evaluation_date' => '2024-01-25',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'evaluation_id' => 'EVAL-003-2024',
                'evaluator_professional_id' => 3,
                'evaluated_professional_id' => 1,
                'question_id' => 2,
                'answer' => 3,
                'evaluation_date' => '2024-01-25',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'evaluation_id' => 'EVAL-003-2024',
                'evaluator_professional_id' => 3,
                'evaluated_professional_id' => 1,
                'question_id' => 3,
                'answer' => 2,
                'evaluation_date' => '2024-01-25',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'evaluation_id' => 'EVAL-003-2024',
                'evaluator_professional_id' => 3,
                'evaluated_professional_id' => 1,
                'question_id' => 4,
                'answer' => 3,
                'evaluation_date' => '2024-01-25',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'evaluation_id' => 'EVAL-003-2024',
                'evaluator_professional_id' => 3,
                'evaluated_professional_id' => 1,
                'question_id' => 5,
                'answer' => 3,
                'evaluation_date' => '2024-01-25',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($evaluations as $evaluation) {
            DB::table('evaluations')->insert($evaluation);
        }
    }
}
