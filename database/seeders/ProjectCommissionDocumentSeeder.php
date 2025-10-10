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
                'file_name' => 'uuid-1-memoria_projecte_integracio.pdf',
                'original_name' => 'memoria_projecte_integracio.pdf',
                'file_content' => null, 
                'file_size' => 1024000, // 1MB
                'mime_type' => 'application/pdf',
                'project_commission_id' => 1,
                'professional_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'file_name' => 'uuid-2-acta_comissio_qualitat.pdf',
                'original_name' => 'acta_comissio_qualitat.pdf',
                'file_content' => null,
                'file_size' => 512000, // 512KB
                'mime_type' => 'application/pdf',
                'project_commission_id' => 2,
                'professional_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'file_name' => 'uuid-3-plan_formacio_professional.docx',
                'original_name' => 'plan_formacio_professional.docx',
                'file_content' => null,
                'file_size' => 2048000, // 2MB
                'mime_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'project_commission_id' => 3,
                'professional_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'file_name' => 'uuid-4-protocol_seguretat.pdf',
                'original_name' => 'protocol_seguretat.pdf',
                'file_content' => null,
                'file_size' => 768000, // 768KB
                'mime_type' => 'application/pdf',
                'project_commission_id' => 4,
                'professional_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'file_name' => 'uuid-5-guia_medi_ambient.pdf',
                'original_name' => 'guia_medi_ambient.pdf',
                'file_content' => null,
                'file_size' => 1536000, // 1.5MB
                'mime_type' => 'application/pdf',
                'project_commission_id' => 5,
                'professional_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'file_name' => 'uuid-6-evaluacio_projecte_integracio.pdf',
                'original_name' => 'evaluacio_projecte_integracio.pdf',
                'file_content' => null,
                'file_size' => 896000, // 896KB
                'mime_type' => 'application/pdf',
                'project_commission_id' => 1,
                'professional_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'file_name' => 'uuid-7-reunio_comissio_qualitat.pdf',
                'original_name' => 'reunio_comissio_qualitat.pdf',
                'file_content' => null,
                'file_size' => 640000, // 640KB
                'mime_type' => 'application/pdf',
                'project_commission_id' => 2,
                'professional_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('project_commission_documents')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        DB::table('project_commission_documents')->insert($projectCommissionDocuments);
    }
}
