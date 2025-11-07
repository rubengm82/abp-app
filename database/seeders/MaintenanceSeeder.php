<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Maintenance;
use Carbon\Carbon;

class MaintenanceSeeder extends Seeder
{
    public function run(): void
    {
        $maintenances = [
            [
                'name_maintenance' => 'Reparación de fontanería en baño principal',
                'who_does_maintenance' => 'Fontanería Clínica SL',
                'description' => 'Se reparó una fuga de agua en el baño principal y se sustituyó una tubería dañada.',
            ],
            [
                'name_maintenance' => 'Sustitución de luminarias en pasillos',
                'who_does_maintenance' => 'Iluminaciones Médicas SA',
                'description' => 'Se reemplazaron 20 luminarias LED defectuosas en los pasillos del área de consultas.',
            ],
            [
                'name_maintenance' => 'Revisión del sistema de climatización',
                'who_does_maintenance' => 'ClimaPerfect SL',
                'description' => 'Mantenimiento preventivo de los equipos de aire acondicionado, limpieza de filtros y revisión de gases.',
            ],
            [
                'name_maintenance' => 'Arreglo de cerraduras en puertas internas',
                'who_does_maintenance' => 'Cerrajeros 24h SL',
                'description' => 'Reparación y engrase de 5 cerraduras de las puertas internas del edificio.',
            ],
            [
                'name_maintenance' => 'Limpieza profunda de quirófano 2',
                'who_does_maintenance' => 'Higiene Médica SA',
                'description' => 'Limpieza técnica y desinfección completa del quirófano 2 siguiendo protocolos sanitarios.',
            ],
            [
                'name_maintenance' => 'Mantenimiento de ascensor principal',
                'who_does_maintenance' => 'Elevadores Seguros SL',
                'description' => 'Revisión mensual del ascensor principal, lubricación de guías y control de sensores.',
            ],
            [
                'name_maintenance' => 'Reparación del sistema eléctrico del laboratorio',
                'who_does_maintenance' => 'ElectroServicios Barcelona SL',
                'description' => 'Sustitución de cables dañados y comprobación de tomas de corriente en el área del laboratorio.',
            ],
            [
                'name_maintenance' => 'Revisión del sistema contra incendios',
                'who_does_maintenance' => 'FireSafe Catalunya SA',
                'description' => 'Comprobación de los extintores, rociadores y alarmas en todo el edificio clínico.',
            ],
            [
                'name_maintenance' => 'Cambio de cristales rotos en ventanales',
                'who_does_maintenance' => 'Cristalería Médica SL',
                'description' => 'Sustitución de tres cristales dañados por impactos leves en la zona de recepción.',
            ],
            [
                'name_maintenance' => 'Pintura de la sala de espera principal',
                'who_does_maintenance' => 'Pinturas y Reformas Gómez SL',
                'description' => 'Se repintaron las paredes con pintura lavable antibacteriana color blanco hospital.',
            ],
            [
                'name_maintenance' => 'Revisión del generador eléctrico de emergencia',
                'who_does_maintenance' => 'Energía Total SA',
                'description' => 'Mantenimiento preventivo del generador, cambio de aceite y prueba de carga completa.',
            ],
            [
                'name_maintenance' => 'Mantenimiento del sistema informático de admisión',
                'who_does_maintenance' => 'TecnoSalud SL',
                'description' => 'Actualización de software y revisión de servidores de la recepción de pacientes.',
            ],
            [
                'name_maintenance' => 'Reparación del sistema de agua caliente',
                'who_does_maintenance' => 'TermoServicios SL',
                'description' => 'Cambio de válvula y revisión de presión en el circuito de agua caliente del área médica.',
            ],
            [
                'name_maintenance' => 'Revisión de cámaras frigoríficas de vacunas',
                'who_does_maintenance' => 'Frío Control SA',
                'description' => 'Verificación de temperatura, sensores y alarmas de las cámaras de refrigeración.',
            ],
            [
                'name_maintenance' => 'Mantenimiento del sistema de ventilación del sótano',
                'who_does_maintenance' => 'AirClinic SL',
                'description' => 'Limpieza de conductos y sustitución de filtros en el sistema de ventilación del sótano.',
            ],
        ];

        // Vaciar la tabla antes de insertar
        Maintenance::query()->delete();

        // Crear registros con center_id y fechas aleatorias
        foreach ($maintenances as $maintenance) {
            Maintenance::create([
                'name_maintenance' => $maintenance['name_maintenance'],
                'who_does_maintenance' => $maintenance['who_does_maintenance'],
                'description' => $maintenance['description'],
                'center_id' => rand(1, 10) <= 8 ? 1 : 2, // 80% centro 1, 20% centro 2
                'opening_date_maintenance' => Carbon::now()->subDays(rand(0, 7))->toDateString(),
            ]);
        }
    }
}
