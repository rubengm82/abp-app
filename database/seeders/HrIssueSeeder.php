<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HrIssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all professional IDs
        $professionalIds = DB::table('professionals')->pluck('id')->toArray();
        
        if (empty($professionalIds)) {
            $this->command->warn('No professionals found. Please run ProfessionalSeeder first.');
            return;
        }

        // Sample issue descriptions
        $descriptions = [
            'Problema de comunicació amb l\'equip de treball',
            'Necessitat de formació addicional en gestió de conflictes',
            'Qüestions relacionades amb la càrrega de treball',
            'Problemes de coordinació entre departaments',
            'Necessitat de suport psicològic',
            'Qüestions sobre horaris i flexibilitat laboral',
            'Problemes de relació amb usuaris',
            'Necessitat de millora en processos interns',
            'Qüestions sobre desenvolupament professional',
            'Problemes de salut laboral',
            'Necessitat de recursos addicionals',
            'Qüestions sobre avaluació i feedback',
            'Problemes de motivació i compromís',
            'Necessitat de clarificació de rols i responsabilitats',
            'Qüestions sobre igualtat i diversitat',
        ];

        $statuses = ['Obert', 'Tancat'];
        
        $hrIssues = [];
        
        // Generate 20 random HR issues
        for ($i = 0; $i < 20; $i++) {
            $openingDate = Carbon::now()->subDays(rand(0, 180)); // Random date within last 6 months
            $status = $statuses[array_rand($statuses)];
            
            // If status is 'Cerrado', add a closing date
            $closingDate = null;
            if ($status === 'Cerrado') {
                $closingDate = $openingDate->copy()->addDays(rand(1, 60)); // Closed within 1-60 days
            }
            
            // Get random professionals (ensure they're different)
            $affectedId = $professionalIds[array_rand($professionalIds)];
            $registeringId = $professionalIds[array_rand($professionalIds)];
            
            // Get a different professional for referred_to (or null)
            $referredToId = null;
            if (rand(0, 1) === 1 && count($professionalIds) > 2) {
                $availableIds = array_diff($professionalIds, [$affectedId, $registeringId]);
                if (!empty($availableIds)) {
                    $referredToId = $availableIds[array_rand($availableIds)];
                }
            }
            
            $hrIssues[] = [
                'opening_date' => $openingDate->format('Y-m-d'),
                'closing_date' => $closingDate ? $closingDate->format('Y-m-d') : null,
                'affected_professional_id' => $affectedId,
                'registering_professional_id' => $registeringId,
                'referred_to_professional_id' => $referredToId,
                'description' => $descriptions[array_rand($descriptions)],
                'status' => $status,
                'created_at' => $openingDate,
                'updated_at' => $closingDate ? $closingDate : now(),
            ];
        }

        // Delete all data from the table before inserting data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('hr_issues')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        DB::table('hr_issues')->insert($hrIssues);
    }
}

