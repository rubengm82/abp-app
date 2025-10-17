<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MaterialAssignmentDocument;
use App\Models\MaterialAssignment;
use App\Models\Professional;

class MaterialAssignmentDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some material assignments existing
        $materialAssignments = MaterialAssignment::take(3)->get();
        
        // Get some professionals existing
        $professionals = Professional::where('status', 1)->get();
        
        if ($materialAssignments->count() > 0 && $professionals->count() > 0) {
            $documents = [
                [
                    'file_name' => 'inventari_uniformes_1.pdf',
                    'original_name' => 'Dummy_Inventari_Uniformes_2024.pdf',
                    'mime_type' => 'application/pdf',
                    'file_size' => 456789
                ],
                [
                    'file_name' => 'foto_uniforme_2.jpg',
                    'original_name' => 'Dummy_Foto_Uniforme_Referencia.jpg',
                    'mime_type' => 'image/jpeg',
                    'file_size' => 234567
                ],
                [
                    'file_name' => 'manual_manteniment_3.pdf',
                    'original_name' => 'Dummy_Manual_Manteniment_Uniforme.pdf',
                    'mime_type' => 'application/pdf',
                    'file_size' => 678901
                ],
                [
                    'file_name' => 'certificat_qualitat_4.pdf',
                    'original_name' => 'Dummy_Certificat_Qualitat_Material.pdf',
                    'mime_type' => 'application/pdf',
                    'file_size' => 123456
                ],
                [
                    'file_name' => 'especificacions_talles_5.pdf',
                    'original_name' => 'Dummy_Especificacions_Talles_Uniforme.pdf',
                    'mime_type' => 'application/pdf',
                    'file_size' => 345678
                ]
            ];
            
            foreach ($materialAssignments as $materialAssignment) {
                // Create between 1-2 documents per assignment
                $numDocuments = rand(1, 2);
                
                for ($i = 0; $i < $numDocuments; $i++) {
                    $document = $documents[array_rand($documents)];
                    
                    MaterialAssignmentDocument::create([
                        'file_name' => $document['file_name'],
                        'original_name' => $document['original_name'],
                        'file_path' => 'documents/material-assignments/' . $document['file_name'],
                        'file_size' => $document['file_size'],
                        'mime_type' => $document['mime_type'],
                        'material_assignment_id' => $materialAssignment->id,
                        'uploaded_by_professional_id' => $professionals->random()->id,
                        'created_at' => now()->subDays(rand(1, 20)),
                        'updated_at' => now()->subDays(rand(1, 20))
                    ]);
                }
            }
        }
    }
}