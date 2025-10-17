<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CenterNote;
use App\Models\Center;
use App\Models\Professional;

class CenterNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some centers existing
        $centers = Center::where('status', 1)->get();
        
        // Get some professionals existing
        $professionals = Professional::where('status', 1)->get();
        
        if ($centers->count() > 0 && $professionals->count() > 0) {
            $notes = [
                'Centre amb excel·lent infraestructura i equipaments.',
                'Necessita renovació de les instal·lacions.',
                'Personal molt professional i compromès.',
                'Client satisfet amb els serveis oferts.',
                'Revisió de seguretat completada satisfactòriament.',
                'Millores necessàries en l\'accessibilitat.',
                'Centre de referència en la zona.',
                'Formació del personal actualitzada.',
                'Equipaments tecnològics modernitzats.',
                'Relacions amb la comunitat molt positives.',
                'Necessita ampliació per cobrir la demanda.',
                'Qualitat dels serveis en constant millora.',
                'Centre sostenible i respectuós amb el medi ambient.',
                'Col·laboració estreta amb altres centres.',
                'Innovació constant en metodologies educatives.'
            ];
            
            foreach ($centers as $center) {
                // Create between 2-4 notes per center
                $numNotes = rand(2, 4);
                
                for ($i = 0; $i < $numNotes; $i++) {
                    CenterNote::create([
                        'center_id' => $center->id,
                        'notes' => $notes[array_rand($notes)],
                        'created_by_professional_id' => $professionals->random()->id,
                        'created_at' => now()->subDays(rand(1, 45)),
                        'updated_at' => now()->subDays(rand(1, 45))
                    ]);
                }
            }
        }
    }
}