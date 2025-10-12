<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProfessionalDocument;
use App\Models\Professional;

class ProfessionalDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener algunos profesionales existentes
        $professionals = Professional::where('status', 1)->get();
        
        if ($professionals->count() > 0) {
            $documents = [
                [
                    'file_name' => 'cv_professional_1.pdf',
                    'original_name' => 'CV_Joan_Garcia.pdf',
                    'mime_type' => 'application/pdf',
                    'file_size' => 245760
                ],
                [
                    'file_name' => 'certificat_formacio_2.pdf',
                    'original_name' => 'Certificat_Formacio_Seguretat.pdf',
                    'mime_type' => 'application/pdf',
                    'file_size' => 189440
                ],
                [
                    'file_name' => 'foto_professional_3.jpg',
                    'original_name' => 'Foto_Carnet_Professional.jpg',
                    'mime_type' => 'image/jpeg',
                    'file_size' => 156789
                ],
                [
                    'file_name' => 'contracte_treball_4.pdf',
                    'original_name' => 'Contracte_Treball_2024.pdf',
                    'mime_type' => 'application/pdf',
                    'file_size' => 312456
                ],
                [
                    'file_name' => 'evaluacio_rendiment_5.pdf',
                    'original_name' => 'Evaluacio_Rendiment_Trimestre.pdf',
                    'mime_type' => 'application/pdf',
                    'file_size' => 98765
                ]
            ];
            
            foreach ($professionals as $professional) {
                // Crear entre 1-2 documentos por profesional
                $numDocuments = rand(1, 2);
                
                for ($i = 0; $i < $numDocuments; $i++) {
                    $document = $documents[array_rand($documents)];
                    
                    ProfessionalDocument::create([
                        'file_name' => $document['file_name'],
                        'original_name' => $document['original_name'],
                        'file_content' => null, // TODO: Temporal null
                        'file_size' => $document['file_size'],
                        'mime_type' => $document['mime_type'],
                        'professional_id' => $professional->id,
                        'uploaded_by_professional_id' => $professionals->random()->id,
                        'created_at' => now()->subDays(rand(1, 30)),
                        'updated_at' => now()->subDays(rand(1, 30))
                    ]);
                }
            }
        }
    }
}