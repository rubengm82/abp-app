<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ProfessionalAccidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all professional IDs that exist
        $professionalIds = DB::table('professionals')->where('status', 1)->pluck('id')->toArray();
        
        if (empty($professionalIds)) {
            $this->command->warn('No professionals found. Please run ProfessionalSeeder first.');
            return;
        }

        // Get professionals with Directiu or Administració role to use as creators
        $creatorIds = DB::table('professionals')
            ->whereIn('role', ['Directiu', 'Administració'])
            ->where('status', 1)
            ->pluck('id')
            ->toArray();

        if (empty($creatorIds)) {
            $this->command->warn('No Directiu or Administració professionals found. Using first professional as creator.');
            $creatorIds = [$professionalIds[0]];
        }

        // Sample contexts and descriptions
        $contexts = [
            'Accident durant l\'activitat laboral',
            'Caiguda a les instal·lacions',
            'Accident amb material de treball',
            'Accident de camí al treball',
            'Accident durant activitat física',
            'Accident amb vehicle',
            'Accident amb maquinària',
            'This one',
        ];

        $descriptions = [
            'Caiguda accidental mentre es realitzava una activitat amb els usuaris',
            'Lesió muscular durant el transport de material',
            'Accident amb una porta que es va tancar sobtadament',
            'Caiguda per un esglaó mal il·luminat',
            'Accident durant la neteja de les instal·lacions',
            'Lesió al genoll durant una activitat física',
            'Accident amb un objecte punxant',
            'Caiguda a causa dun terra mullat',
        ];

        $types = ['Sin baixa', 'Amb baixa', 'Baixa Finalitzada'];
        
        $accidents = [];
        
        // Generate 15 random professional accidents
        for ($i = 0; $i < 15; $i++) {
            $type = $types[array_rand($types)];
            $affectedProfessionalId = $professionalIds[array_rand($professionalIds)];
            $createdByProfessionalId = $creatorIds[array_rand($creatorIds)];
            
            // Random date within last 6 months
            $date = Carbon::now()->subMonths(rand(0, 6))->subDays(rand(0, 30));
            
            $accident = [
                'type' => $type,
                'date' => $date->toDateString(),
                'context' => $contexts[array_rand($contexts)],
                'description' => $descriptions[array_rand($descriptions)],
                'created_by_professional_id' => $createdByProfessionalId,
                'affected_professional_id' => $affectedProfessionalId,
                'duration' => null,
                'start_date' => null,
                'end_date' => null,
                'created_at' => $date->toDateTimeString(),
                'updated_at' => $date->toDateTimeString(),
            ];

            // Add leave information if type is "Amb baixa"
            if ($type === 'Amb baixa') {
                $startDate = $date->copy()->addDays(rand(0, 2));
                $duration = rand(5, 30);
                $endDate = $startDate->copy()->addDays($duration);
                
                $accident['start_date'] = $startDate->toDateString();
                $accident['end_date'] = $endDate->toDateString();
                $accident['duration'] = $duration;
            }

            $accidents[] = $accident;
        }
        // mainlog::log('Professional accidents seeded successfully!' . json_encode($accidents));   
        DB::table('professional_accidents')->insert($accidents);
        
        // $this->command->info('Professional accidents seeded successfully!');
    }
}
