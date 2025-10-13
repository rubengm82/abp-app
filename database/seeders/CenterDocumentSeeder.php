<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CenterDocument;
use App\Models\Center;
use App\Models\Professional;

class CenterDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener algunos centros y profesionales para crear documentos
        $centers = Center::take(3)->get();
        $professionals = Professional::take(2)->get();

        if ($centers->isEmpty() || $professionals->isEmpty()) {
            $this->command->warn('No hay centros o profesionales disponibles para crear documentos.');
            return;
        }

        $documentTypes = [
            'Dummy_Contrato_de_arrendamiento.pdf',
            'Certificado de seguridad',
            'Dummy_Manual_de_procedimientos.pdf',
            'Dummy_Reglamento_interno.pdf',
            'Dummy_Certificado_de_inspección.pdf'
        ];

        foreach ($centers as $center) {
            // Crear 2-3 documentos por centro
            $numDocuments = rand(2, 3);
            
            for ($i = 0; $i < $numDocuments; $i++) {
                $professional = $professionals->random();
                $documentType = $documentTypes[array_rand($documentTypes)];
                
                CenterDocument::create([
                    'file_name' => 'center_' . $center->id . '_doc_' . ($i + 1) . '.pdf',
                    'original_name' => $documentType . '.pdf',
                    'file_path' => 'documents/centers/' . 'center_' . $center->id . '_doc_' . ($i + 1) . '.pdf',
                    'file_size' => rand(50000, 500000), // Entre 50KB y 500KB
                    'mime_type' => 'application/pdf',
                    'center_id' => $center->id,
                    'uploaded_by_professional_id' => $professional->id,
                ]);
            }
        }

        $this->command->info('Center documents seeded successfully.');
    }
}
