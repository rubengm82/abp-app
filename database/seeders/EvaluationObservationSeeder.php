<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Evaluation;

class EvaluationObservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete all existing records
        DB::table('evaluation_observations')->truncate();

        // Get all unique evaluation UUIDs from existing evaluations
        $evaluationUuids = Evaluation::select('evaluation_uuid')
            ->distinct()
            ->pluck('evaluation_uuid')
            ->toArray();

        if (empty($evaluationUuids)) {
            $this->command->warn('No evaluations found. Please run EvaluationsSeeder first.');
            return;
        }

        // Sample observations
        $observations = [
            'Observació general sobre el rendiment del professional.',
            'Cal millorar la comunicació amb l\'equip.',
            'Excel·lent treball en equip i col·laboració.',
            'Necessita més formació en gestió de conflictes.',
            'Professional molt compromès amb el projecte.',
        ];

        // Create one observation per evaluation UUID (random observation)
        foreach ($evaluationUuids as $uuid) {
            // Only create observation for some evaluations (70% chance)
            if (rand(1, 10) <= 7) {
                DB::table('evaluation_observations')->insert([
                    'evaluation_uuid' => $uuid,
                    'observation' => $observations[array_rand($observations)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

