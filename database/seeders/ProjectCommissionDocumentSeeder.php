<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectCommissionDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projectCommissionDocuments = [
            [
                'file_name' => 'memoria_projecte_integracio.pdf',
                'file_content' => null, // Null as specified in todo.txt
                'project_commission_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'file_name' => 'acta_comissio_qualitat.pdf',
                'file_content' => null,
                'project_commission_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'file_name' => 'plan_formacio_professional.docx',
                'file_content' => null,
                'project_commission_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'file_name' => 'protocol_seguretat.pdf',
                'file_content' => null,
                'project_commission_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'file_name' => 'guia_medi_ambient.pdf',
                'file_content' => null,
                'project_commission_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'file_name' => 'evaluacio_projecte_integracio.pdf',
                'file_content' => null,
                'project_commission_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'file_name' => 'reunio_comissio_qualitat.pdf',
                'file_content' => null,
                'project_commission_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Elimina toda la tabla primero antes de insertar datos
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('project_commission_documents')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        DB::table('project_commission_documents')->insert($projectCommissionDocuments);
    }
}
