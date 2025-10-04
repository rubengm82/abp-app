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
                'role' => 'Director',
                'name' => 'Joan',
                'surname1' => 'García',
                'surname2' => 'Martínez',
                'phone' => '+34 600 111 222',
                'email' => 'joan.garcia@canserra.cat',
                'address' => 'Carrer Director, 1, Barcelona',
                'employment_status' => 'Actiu',
                'cvitae' => 'Experiència en gestió de centres educatius',
                'login' => 'joan.garcia',
                'password' => bcrypt('password123'),
                'key_code' => 'KEY001',
                'shirt_size' => 'L',
                'pants_size' => 'L',
                'shoe_size' => '42',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'center_id' => 1,
                'role' => 'Coordinador',
                'name' => 'Maria',
                'surname1' => 'López',
                'surname2' => 'Fernández',
                'phone' => '+34 600 333 444',
                'email' => 'maria.lopez@canserra.cat',
                'address' => 'Carrer Coordinador, 2, Barcelona',
                'employment_status' => 'Actiu',
                'cvitae' => 'Especialista en coordinació pedagògica',
                'login' => 'maria.lopez',
                'password' => bcrypt('password123'),
                'key_code' => 'KEY002',
                'shirt_size' => 'M',
                'pants_size' => 'M',
                'shoe_size' => '38',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'center_id' => 2,
                'role' => 'Educador',
                'name' => 'Pere',
                'surname1' => 'Sánchez',
                'surname2' => 'Ruiz',
                'phone' => '+34 600 555 666',
                'email' => 'pere.sanchez@canserra.cat',
                'address' => 'Carrer Educador, 3, Barcelona',
                'employment_status' => 'Actiu',
                'cvitae' => 'Educador social amb experiència en joves',
                'login' => 'pere.sanchez',
                'password' => bcrypt('password123'),
                'key_code' => 'KEY003',
                'shirt_size' => 'XL',
                'pants_size' => 'XL',
                'shoe_size' => '44',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'center_id' => 2,
                'role' => 'Psicòleg',
                'name' => 'Anna',
                'surname1' => 'Torres',
                'surname2' => 'Vargas',
                'phone' => '+34 600 777 888',
                'email' => 'anna.torres@canserra.cat',
                'address' => 'Carrer Psicòleg, 4, Barcelona',
                'employment_status' => 'Suplència',
                'cvitae' => 'Psicòloga clínica especialitzada en adolescents',
                'login' => 'anna.torres',
                'password' => bcrypt('password123'),
                'key_code' => 'KEY004',
                'shirt_size' => 'S',
                'pants_size' => 'S',
                'shoe_size' => '36',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'center_id' => 3,
                'role' => 'Tècnic',
                'name' => 'Carles',
                'surname1' => 'Molina',
                'surname2' => 'González',
                'phone' => '+34 600 999 000',
                'email' => 'carles.molina@canserra.cat',
                'address' => 'Carrer Tècnic, 5, Barcelona',
                'employment_status' => 'Actiu',
                'cvitae' => 'Tècnic en integració social',
                'login' => 'carles.molina',
                'password' => bcrypt('password123'),
                'key_code' => 'KEY005',
                'shirt_size' => 'L',
                'pants_size' => 'L',
                'shoe_size' => '41',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('professionals')->insert($professionals);
    }
}
