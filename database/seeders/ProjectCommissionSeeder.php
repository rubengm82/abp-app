<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectCommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projectCommissions = [
            [
                'center_id' => 1,
                'name' => 'Projecte Integració Social',
                'start_date' => '2025-01-01',
                'estimated_end_date' => '2025-12-31',
                'responsible_professional_id' => 1,
                'description' => 'Projecte per a la integració social de joves en risc d\'exclusió',
                'type' => 'Projecte',
                'status' => 'Actiu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'center_id' => 1,
                'name' => 'Comissió Qualitat',
                'start_date' => '2025-02-01',
                'estimated_end_date' => '2025-11-30',
                'responsible_professional_id' => 2,
                'description' => 'Comissió per a la millora de la qualitat educativa',
                'type' => 'Comissio',
                'status' => 'Actiu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'center_id' => 1,
                'name' => 'Projecte Formació Professional',
                'start_date' => '2025-03-01',
                'estimated_end_date' => '2025-10-31',
                'responsible_professional_id' => 3,
                'description' => 'Projecte de formació professional per a joves',
                'type' => 'Projecte',
                'status' => 'Actiu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'center_id' => 1,
                'name' => 'Comissió Seguretat',
                'start_date' => '2025-01-15',
                'estimated_end_date' => '2025-12-15',
                'responsible_professional_id' => 4,
                'description' => 'Comissió per a la seguretat i prevenció de riscos',
                'type' => 'Comissio',
                'status' => 'Actiu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'center_id' => 2,
                'name' => 'Projecte Medi Ambient',
                'start_date' => '2025-04-01',
                'estimated_end_date' => '2025-09-30',
                'responsible_professional_id' => 5,
                'description' => 'Projecte de conscienciació mediambiental',
                'type' => 'Projecte',
                'status' => 'Actiu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Delete all data from the table before inserting data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('project_commissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        DB::table('project_commissions')->insert($projectCommissions);
    }
}
