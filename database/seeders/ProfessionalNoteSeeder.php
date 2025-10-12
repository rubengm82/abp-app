<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProfessionalNote;
use App\Models\Professional;

class ProfessionalNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener algunos profesionales existentes
        $professionals = Professional::where('status', 1)->get();
        
        if ($professionals->count() > 0) {
            $notes = [
                'Professional molt competent i amb gran experiència.',
                'Necessita formació addicional en les noves tecnologies.',
                'Excel·lent treball en equip i comunicació.',
                'Proactiu i sempre disposat a ajudar els companys.',
                'Revisió de rendiment positiva aquest trimestre.',
                'Participació activa en les reunions d\'equip.',
                'Millores necessàries en la gestió del temps.',
                'Client molt satisfet amb el seu treball.',
                'Formació completada en seguretat laboral.',
                'Recomanat per promoció interna.',
                'Necessita suport addicional en projectes complexos.',
                'Excel·lent mentor per als nous professionals.',
                'Puntualitat i assistència exemplars.',
                'Creativitat destacada en la resolució de problemes.',
                'Col·laboració estreta amb altres departaments.'
            ];
            
            foreach ($professionals as $professional) {
                // Crear entre 1-3 notas por profesional
                $numNotes = rand(1, 3);
                
                for ($i = 0; $i < $numNotes; $i++) {
                    ProfessionalNote::create([
                        'professional_id' => $professional->id,
                        'notes' => $notes[array_rand($notes)],
                        'created_by_professional_id' => $professionals->random()->id,
                        'created_at' => now()->subDays(rand(1, 60)),
                        'updated_at' => now()->subDays(rand(1, 60))
                    ]);
                }
            }
        }
    }
}