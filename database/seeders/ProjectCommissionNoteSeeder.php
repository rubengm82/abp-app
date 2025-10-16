<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProjectCommissionNote;
use App\Models\ProjectCommission;
use App\Models\Professional;

class ProjectCommissionNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener algunos proyectos/comisiones existentes
        $projectCommissions = ProjectCommission::take(3)->get();
        
        // Obtener algunos profesionales existentes
        $professionals = Professional::where('status', 1)->take(3)->get();
        
        if ($projectCommissions->count() > 0 && $professionals->count() > 0) {
            $notes = [
                'Reunió inicial completada. Tots els objectius establerts.',
                'Progrés excel·lent. Equip molt motivat.',
                'Necessitem més recursos per accelerar el desenvolupament.',
                'Client satisfet amb els resultats fins ara.',
                'Revisió de codi programada per la propera setmana.',
                'Documentació actualitzada i revisada.',
                'Testos d\'integració passats correctament.',
                'Demora en la lliuració degut a canvis en els requisits.',
                'Equip treballant en horaris extres per complir deadlines.',
                'Presentació al client programada per demà.'
            ];
            
            foreach ($projectCommissions as $projectCommission) {
                // Create between 2-4 notes per project/commission
                $numNotes = rand(2, 4);
                
                for ($i = 0; $i < $numNotes; $i++) {
                    ProjectCommissionNote::create([
                        'project_commission_id' => $projectCommission->id,
                        'notes' => $notes[array_rand($notes)],
                        'professional_id' => $professionals->random()->id,
                        'created_at' => now()->subDays(rand(1, 30)),
                        'updated_at' => now()->subDays(rand(1, 30))
                    ]);
                }
            }
        }
    }
}