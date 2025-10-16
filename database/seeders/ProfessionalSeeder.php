<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Professional;
use Illuminate\Support\Facades\Schema;

class ProfessionalSeeder extends Seeder
{
    public function run(): void
    {
        $professionals = [
            [
                'center_id' => 1,
                'role' => 'Administració',
                'name' => 'Root',
                'surname1' => 'Toor',
                'surname2' => 'Toor',
                'dni' => 'F9876543B',
                'phone' => '+34 600 333 444',
                'email' => 'root@canserra.cat',
                'address' => 'Carrer Coordinador, 2, Barcelona',
                'employment_status' => 'Actiu',
                'cvitae' => 'Es el root',
                'user' => 'admin',
                'password' => 'admin', // automatic hash
                'key_code' => 'KEY000',
                'status' => 1,
            ],
            [
                'center_id' => 1,
                'role' => 'Directiu',
                'name' => 'Joan',
                'surname1' => 'García',
                'surname2' => 'Martínez',
                'dni' => 'A3427812C',
                'phone' => '+34 600 111 222',
                'email' => 'joan.garcia@canserra.cat',
                'address' => 'Carrer Director, 1, Barcelona',
                'employment_status' => 'Actiu',
                'cvitae' => 'Experiència en gestió de centres educatius',
                'user' => 'joan.garcia',
                'password' => 'password123',
                'key_code' => 'KEY001',
                'status' => 1,
            ],
            [
                'center_id' => 1,
                'role' => 'Administració',
                'name' => 'Maria',
                'surname1' => 'López',
                'surname2' => 'Fernández',
                'dni' => 'F9876544C',
                'phone' => '+34 600 333 445',
                'email' => 'maria.lopez@canserra.cat',
                'address' => 'Carrer Coordinador, 2, Barcelona',
                'employment_status' => 'Actiu',
                'cvitae' => 'Especialista en coordinació pedagògica',
                'user' => 'maria.lopez',
                'password' => 'password123',
                'key_code' => 'KEY002',
                'status' => 1,
            ],
            [
                'center_id' => 2,
                'role' => 'Tècnic',
                'name' => 'Pere',
                'surname1' => 'Sánchez',
                'surname2' => 'Ruiz',
                'dni' => 'D1234567X',
                'phone' => '+34 600 555 666',
                'email' => 'pere.sanchez@canserra.cat',
                'address' => 'Carrer Educador, 3, Barcelona',
                'employment_status' => 'Actiu',
                'cvitae' => 'Educador social amb experiència en joves',
                'user' => 'pere.sanchez',
                'password' => 'password123',
                'key_code' => 'KEY003',
                'status' => 1,
            ],
            [
                'center_id' => 1,
                'role' => 'Tècnic',
                'name' => 'Anna',
                'surname1' => 'Torres',
                'surname2' => 'Vargas',
                'dni' => 'B8765432Z',
                'phone' => '+34 600 777 888',
                'email' => 'anna.torres@canserra.cat',
                'address' => 'Carrer Psicòleg, 4, Barcelona',
                'employment_status' => 'Suplència',
                'cvitae' => 'Psicòloga clínica especialitzada en adolescents',
                'user' => 'anna.torres',
                'password' => 'password123',
                'key_code' => 'KEY004',
                'status' => 1,
            ],
            [
                'center_id' => 1,
                'role' => 'Tècnic',
                'name' => 'Carles',
                'surname1' => 'Molina',
                'surname2' => 'González',
                'dni' => 'C4567891Y',
                'phone' => '+34 600 999 000',
                'email' => 'carles.molina@canserra.cat',
                'address' => 'Carrer Tècnic, 5, Barcelona',
                'employment_status' => 'Actiu',
                'cvitae' => 'Tècnic en integració social',
                'user' => 'carles.molina',
                'password' => 'password123',
                'key_code' => 'KEY005',
                'status' => 1,
            ],
            [
                'center_id' => 1,
                'role' => 'Administració',
                'name' => 'Ruben',
                'surname1' => 'Gallardo',
                'surname2' => 'Mancha',
                'dni' => 'G1234567C',
                'phone' => '+34 600 111 222',
                'email' => 'ruben.gallardo@canserra.cat',
                'address' => 'Carrer Coordinador, 10, Barcelona',
                'employment_status' => 'Actiu',
                'cvitae' => 'Responsable de projectes',
                'user' => 'ruben.gallardo',
                'password' => 'admin', // automatic hash
                'key_code' => 'KEY006',
                'status' => 1,
            ],
            [
                'center_id' => 1,
                'role' => 'Administració',
                'name' => 'Yoel',
                'surname1' => 'Berjaga',
                'surname2' => 'Garcia',
                'dni' => 'H2345678D',
                'phone' => '+34 600 222 333',
                'email' => 'yoel.berjaga@canserra.cat',
                'address' => 'Carrer Coordinador, 12, Barcelona',
                'employment_status' => 'Actiu',
                'cvitae' => 'Tècnic administratiu',
                'user' => 'yoel.berjaga',
                'password' => 'admin', // automatic hash
                'key_code' => 'KEY007',
                'status' => 1,
            ],
        ];

        // Elimina todos los registros sin usar truncate para respetar FK
        Professional::query()->delete();

        // Crear profesionales usando Eloquent para que se aplique el mutator
        foreach ($professionals as $p) {
            // Si la columna 'user' no existe en 'professionals', la quitamos
            if (!Schema::hasColumn('professionals', 'user')) {
                unset($p['user']);
            }

            Professional::create($p);
        }
    }
}
