<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $professionals = [
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
                'login' => 'joan.garcia',
                'password' => 'password123',
                'key_code' => 'KEY001',
                'status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'center_id' => 1,
                'role' => 'Administració',
                'name' => 'Maria',
                'surname1' => 'López',
                'surname2' => 'Fernández',
                'dni' => 'F9876543B',
                'phone' => '+34 600 333 444',
                'email' => 'maria.lopez@canserra.cat',
                'address' => 'Carrer Coordinador, 2, Barcelona',
                'employment_status' => 'Actiu',
                'cvitae' => 'Especialista en coordinació pedagògica',
                'login' => 'maria.lopez',
                'password' => 'password123',
                'key_code' => 'KEY002',
                'status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
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
                'login' => 'pere.sanchez',
                'password' => 'password123',
                'key_code' => 'KEY003',
                'status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
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
                'login' => 'anna.torres',
                'password' => 'password123',
                'key_code' => 'KEY004',
                'status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
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
                'login' => 'carles.molina',
                'password' => 'password123',
                'key_code' => 'KEY005',
                'status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        
        // Elimina toda la tabla primero antes de insertar datos
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('professionals')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('professionals')->insert($professionals);
    }
}
