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
                'responsible_maintenance' => 'Fontanería Clínica SL',
                'description' => 'Se reparó una fuga de agua en el baño principal y se sustituyó una tubería dañada.',
            ],
            [
                'name_maintenance' => 'Sustitución de luminarias en pasillos',
                'responsible_maintenance' => 'Iluminaciones Médicas SA',
                'description' => 'Se reemplazaron 20 luminarias LED defectuosas en los pasillos del área de consultas.',
            ],
            [
                'name_maintenance' => 'Revisión del sistema de climatización',
                'responsible_maintenance' => 'ClimaPerfect SL',
                'description' => 'Mantenimiento preventivo de los equipos de aire acondicionado, limpieza de filtros y revisión de gases.',
            ],
            [
                'name_maintenance' => 'Arreglo de cerraduras en puertas internas',
                'responsible_maintenance' => 'Cerrajeros 24h SL',
                'description' => 'Reparación y engrase de 5 cerraduras de las puertas internas del edificio.',
            ],
            [
                'name_maintenance' => 'Limpieza profunda de quirófano 2',
                'responsible_maintenance' => 'Higiene Médica SA',
                'description' => 'Limpieza técnica y desinfección completa del quirófano 2 siguiendo protocolos sanitarios.',
            ],
            [
                'name_maintenance' => 'Mantenimiento de ascensor principal',
                'responsible_maintenance' => 'Elevadores Seguros SL',
                'description' => 'Revisión mensual del ascensor principal, lubricación de guías y control de sensores.',
            ],
            [
                'name_maintenance' => 'Reparación del sistema eléctrico del laboratorio',
                'responsible_maintenance' => 'ElectroServicios Barcelona SL',
                'description' => 'Sustitución de cables dañados y comprobación de tomas de corriente en el área del laboratorio.',
            ],
            [
                'name_maintenance' => 'Revisión del sistema contra incendios',
                'responsible_maintenance' => 'FireSafe Catalunya SA',
                'description' => 'Comprobación de los extintores, rociadores y alarmas en todo el edificio clínico.',
            ],
            [
                'name_maintenance' => 'Cambio de cristales rotos en ventanales',
                'responsible_maintenance' => 'Cristalería Médica SL',
                'description' => 'Sustitución de tres cristales dañados por impactos leves en la zona de recepción.',
            ],
            [
                'name_maintenance' => 'Pintura de la sala de espera principal',
                'responsible_maintenance' => 'Pinturas y Reformas Gómez SL',
                'description' => 'Se repintaron las paredes con pintura lavable antibacteriana color blanco hospital.',
            ],
            [
                'name_maintenance' => 'Revisión del generador eléctrico de emergencia',
                'responsible_maintenance' => 'Energía Total SA',
                'description' => 'Mantenimiento preventivo del generador, cambio de aceite y prueba de carga completa.',
            ],
            [
                'name_maintenance' => 'Mantenimiento del sistema informático de admisión',
                'responsible_maintenance' => 'TecnoSalud SL',
                'description' => 'Actualización de software y revisión de servidores de la recepción de pacientes.',
            ],
            [
                'name_maintenance' => 'Reparación del sistema de agua caliente',
                'responsible_maintenance' => 'TermoServicios SL',
                'description' => 'Cambio de válvula y revisión de presión en el circuito de agua caliente del área médica.',
            ],
            [
                'name_maintenance' => 'Revisión de cámaras frigoríficas de vacunas',
                'responsible_maintenance' => 'Frío Control SA',
                'description' => 'Verificación de temperatura, sensores y alarmas de las cámaras de refrigeración.',
            ],
            [
                'name_maintenance' => 'Mantenimiento del sistema de ventilación del sótano',
                'responsible_maintenance' => 'AirClinic SL',
                'description' => 'Limpieza de conductos y sustitución de filtros en el sistema de ventilación del sótano.',
            ],
        ];

        // Vaciar la tabla antes de insertar
        Maintenance::query()->delete();

        // Crear registros con center_id y fechas aleatorias
        foreach ($maintenances as $maintenance) {
            Maintenance::create([
                'name_maintenance' => $maintenance['name_maintenance'],
                'responsible_maintenance' => $maintenance['responsible_maintenance'],
                'description' => $maintenance['description'],
                'center_id' => rand(1, 10) <= 8 ? 1 : 2, // 80% centro 1, 20% centro 2
                'opening_date_maintenance' => Carbon::now()->subDays(rand(0, 7))->toDateString(),
            ]);
        }
    }
}
