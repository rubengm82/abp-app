<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Desactiva FKs → truncate seguro y rápido
        Schema::disableForeignKeyConstraints();
        DB::table('centers')->truncate();
        DB::table('professionals')->truncate();
        Schema::enableForeignKeyConstraints();

        $centers = [
            [
                'name' => 'Can Serra',
                'address' => 'Carretera Esplugues 18, 08906 Hospitalet del Llobregat, Barcelona',
                'phone' => '+34 93 437 34 09',
                'email' => 'rcanserra@fundaciovallparadis.cat',
                'status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        $professionals = [
            [
                'center_id' => 1,
                'role' => 'Gerent',
                'name' => 'Admin',
                'surname1' => 'Admin',
                'surname2' => 'Admin',
                'dni' => 'F9876543B',
                'phone' => '+34 600 000 000',
                'email' => 'admin@admin.cat',
                'address' => 'Carrer Admin, 2, Barcelona',
                'employment_status' => 'Actiu',
                'cvitae' => 'Es el Admin',
                'user' => 'admin',
                'password' => 'admin', // automatic hash
                'locker_num' => 'Z999',
                'key_code' => 'KEY999',
                'status' => 1,
            ],
        ];

        // Hash de passwords ANTES de insertar
        foreach ($professionals as &$professional) {
            // $p['password'] = Hash::make($p['password']);
            $professional['password'] = Hash::make($professional['password'], ['rounds' => 4]);
        }

        DB::table('centers')->insert($centers);
        DB::table('professionals')->insert($professionals);
    }
}
