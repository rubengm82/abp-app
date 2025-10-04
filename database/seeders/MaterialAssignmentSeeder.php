<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materialAssignments = [
            [
                'professional_id' => 1,
                'shirt_size' => 'L',
                'shoe_size' => '42',
                'pants_size' => 'L',
                'assignment_date' => '2025-01-15',
                'assigned_by_professional_id' => 2,
                'observations' => 'Uniforme complet assignat',
                'documents' => 'contracte_uniforme.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'professional_id' => 2,
                'shirt_size' => 'M',
                'shoe_size' => '38',
                'pants_size' => 'M',
                'assignment_date' => '2025-01-20',
                'assigned_by_professional_id' => 1,
                'observations' => 'Uniforme de coordinació',
                'documents' => 'assignacio_coordinador.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'professional_id' => 3,
                'shirt_size' => 'XL',
                'shoe_size' => '44',
                'pants_size' => 'XL',
                'assignment_date' => '2025-02-01',
                'assigned_by_professional_id' => 1,
                'observations' => 'Uniforme per activitats exteriors',
                'documents' => 'uniforme_exterior.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'professional_id' => 4,
                'shirt_size' => 'S',
                'shoe_size' => '36',
                'pants_size' => 'S',
                'assignment_date' => '2025-02-10',
                'assigned_by_professional_id' => 2,
                'observations' => 'Uniforme per sessions psicològiques',
                'documents' => 'uniforme_psicologia.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'professional_id' => 5,
                'shirt_size' => 'L',
                'shoe_size' => '41',
                'pants_size' => 'L',
                'assignment_date' => '2025-02-15',
                'assigned_by_professional_id' => 1,
                'observations' => 'Uniforme tècnic especialitzat',
                'documents' => 'uniforme_tecnic.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'professional_id' => 1,
                'shirt_size' => null,
                'shoe_size' => null,
                'pants_size' => null,
                'assignment_date' => '2025-03-01',
                'assigned_by_professional_id' => 2,
                'observations' => 'EPI de seguretat',
                'documents' => 'epi_seguretat.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('material_assignments')->insert($materialAssignments);
    }
}
