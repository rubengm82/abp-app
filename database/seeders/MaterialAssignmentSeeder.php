<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MaterialAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materialAssignments = [
            // Joan García - Assignació inicial
            [
                'professional_id' => 1,
                'shirt_size' => 'L',
                'pants_size' => 'L',
                'shoe_size' => '42',
                'assignment_date' => Carbon::now()->subMonths(6),
                'assigned_by_professional_id' => 2,
                'observations' => 'Uniforme inicial assignat al nou directiu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Joan García - Renovació uniforme
            [
                'professional_id' => 1,
                'shirt_size' => 'XL',
                'pants_size' => 'XL',
                'shoe_size' => '43',
                'assignment_date' => Carbon::now()->subMonths(2),
                'assigned_by_professional_id' => 2,
                'observations' => 'Renovació uniforme per canvi de talla',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Maria López - Assignació inicial
            [
                'professional_id' => 2,
                'shirt_size' => 'M',
                'pants_size' => 'M',
                'shoe_size' => '38',
                'assignment_date' => Carbon::now()->subMonths(8),
                'assigned_by_professional_id' => 1,
                'observations' => 'Uniforme administratiu assignat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Pere Sánchez - Assignació inicial
            [
                'professional_id' => 3,
                'shirt_size' => 'XL',
                'pants_size' => 'XL',
                'shoe_size' => '44',
                'assignment_date' => Carbon::now()->subMonths(4),
                'assigned_by_professional_id' => 1,
                'observations' => 'Uniforme tècnic assignat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Anna Torres - Assignació inicial
            [
                'professional_id' => 4,
                'shirt_size' => 'S',
                'pants_size' => 'S',
                'shoe_size' => '36',
                'assignment_date' => Carbon::now()->subMonths(3),
                'assigned_by_professional_id' => 2,
                'observations' => 'Uniforme psicològic assignat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Carles Molina - Assignació inicial
            [
                'professional_id' => 5,
                'shirt_size' => 'L',
                'pants_size' => 'L',
                'shoe_size' => '41',
                'assignment_date' => Carbon::now()->subMonths(5),
                'assigned_by_professional_id' => 1,
                'observations' => 'Uniforme tècnic integració social',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Assignacions parcials (només samarreta)
            [
                'professional_id' => 1,
                'shirt_size' => 'L',
                'pants_size' => null,
                'shoe_size' => null,
                'assignment_date' => Carbon::now()->subWeeks(2),
                'assigned_by_professional_id' => 2,
                'observations' => 'Renovació només samarreta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Assignacions parcials (només sabates)
            [
                'professional_id' => 3,
                'shirt_size' => null,
                'pants_size' => null,
                'shoe_size' => '45',
                'assignment_date' => Carbon::now()->subWeeks(1),
                'assigned_by_professional_id' => 1,
                'observations' => 'Renovació només sabates',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Assignacions antigues (per mostrar històric)
            [
                'professional_id' => 2,
                'shirt_size' => 'S',
                'pants_size' => 'S',
                'shoe_size' => '37',
                'assignment_date' => Carbon::now()->subMonths(12),
                'assigned_by_professional_id' => 1,
                'observations' => 'Uniforme anterior (ja no vàlid)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Assignació recent per demostrar funcionalitat
            [
                'professional_id' => 4,
                'shirt_size' => 'M',
                'pants_size' => 'M',
                'shoe_size' => '37',
                'assignment_date' => Carbon::now()->subDays(5),
                'assigned_by_professional_id' => 2,
                'observations' => 'Actualització talla després de consulta mèdica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        // Elimina toda la tabla primero antes de insertar datos
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('material_assignments')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        DB::table('material_assignments')->insert($materialAssignments);
    }
}