<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MaterialAssignmentNote;
use App\Models\MaterialAssignment;
use App\Models\Professional;

class MaterialAssignmentNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener algunas asignaciones de material existentes
        $materialAssignments = MaterialAssignment::take(5)->get();
        
        // Obtener algunos profesionales existentes
        $professionals = Professional::where('status', 1)->get();
        
        if ($materialAssignments->count() > 0 && $professionals->count() > 0) {
            $notes = [
                'Uniforme lliurat correctament i verificat.',
                'Necessita canvi de talla per incomoditat.',
                'Material en perfecte estat i ben conservat.',
                'Revisió periòdica completada satisfactòriament.',
                'Uniforme personalitzat segons especificacions.',
                'Necessita reparació menor en la roba.',
                'Equipament complet i funcional.',
                'Lliurament puntual segons calendari.',
                'Qualitat del material excel·lent.',
                'Necessita reposició per desgast normal.',
                'Uniforme adaptat a les necessitats del treball.',
                'Revisió de seguretat del material completada.',
                'Professional satisfet amb l\'equipament.',
                'Material net i ben organitzat.',
                'Necessita actualització del equipament.'
            ];
            
            foreach ($materialAssignments as $materialAssignment) {
                // Create between 1-2 notes per assignment
                $numNotes = rand(1, 2);
                
                for ($i = 0; $i < $numNotes; $i++) {
                    MaterialAssignmentNote::create([
                        'material_assignment_id' => $materialAssignment->id,
                        'notes' => $notes[array_rand($notes)],
                        'created_by_professional_id' => $professionals->random()->id,
                        'created_at' => now()->subDays(rand(1, 30)),
                        'updated_at' => now()->subDays(rand(1, 30))
                    ]);
                }
            }
        }
    }
}