<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeneralServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'center_id' => 1,
                'service_type' => 'Cuina',
                'responsible' => "Pedro Sánchez",
                'responsible_info' => "Calle: Sin nombre 133, 6-1\nTelf: 666-000-111\nCP: 088110",
                'planning' => "Manuel: Horario L-V 9:30 13:30h || S-D 8 a 16h\nMaria: Horario L-V 8:30 14:30h || S-D 19 a 13h",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'center_id' => 1,
                'service_type' => 'Neteja',
                'responsible' => "Mariano García",
                'responsible_info' => "Calle: Rosella 45, 2-3\nTelf: 655-111-222\nCP: 088120",
                'planning' => "Luis: Horario L-V 7:00 12:00h\nAna: Horario L-V 14:00 18:00h",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'center_id' => 1,
                'service_type' => 'Bugaderia',
                'responsible' => "Laura Martínez",
                'responsible_info' => "Calle: Verdi 23, 1-4\nTelf: 688-222-333\nCP: 088130",
                'planning' => "Sergio: Horario L-V 8:00 14:00h\nClara: Horario L-V 10:00 16:00h",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'center_id' => 2,
                'service_type' => 'Cuina',
                'responsible' => "Antonio López",
                'responsible_info' => "Calle: Pau 12, 3-2\nTelf: 677-333-444\nCP: 088140",
                'planning' => "Carlos: Horario L-V 9:00 13:00h\nElena: Horario L-V 8:00 14:00h",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'center_id' => 2,
                'service_type' => 'Neteja',
                'responsible' => "Isabel Torres",
                'responsible_info' => "Calle: Marina 77, 5-1\nTelf: 699-444-555\nCP: 088150",
                'planning' => "Miguel: Horario L-V 7:30 12:30h\nLaura: Horario L-V 14:00 18:00h",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'center_id' => 2,
                'service_type' => 'Bugaderia',
                'responsible' => "Javier Ruiz",
                'responsible_info' => "Calle: Balmes 10, 2-5\nTelf: 688-555-666\nCP: 088160",
                'planning' => "Raquel: Horario L-V 8:00 13:00h\nDavid: Horario L-V 12:00 18:00h",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Desactivar temporalmente las claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('general_services')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Insertar datos
        DB::table('general_services')->insert($services);
    }
}
