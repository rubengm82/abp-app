<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
            [
                'name' => 'Casa Badina',
                'address' => 'Calle Cervantes 193-197, 08912 Badalona, Barcelona',
                'phone' => '+34 93 235 94 00',
                'email' => 'casabadina@fundaciovallparadis.cat',
                'status' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Elimina toda la tabla primero antes de insertar datos
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('centers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('centers')->insert($centers);
    }
// public function run()
// {
//     // Elimina toda la tabla antes de insertar datos masivos
//     DB::statement('SET FOREIGN_KEY_CHECKS=0;');
//     DB::table('centers')->truncate();
//     DB::statement('SET FOREIGN_KEY_CHECKS=1;');

//     $centers = [];
//     for ($i = 1; $i <= 5000; $i++) {
//         $centers[] = [
//             'name' => 'Centro Repetido',
//             'address' => 'Generic address ' . $i,
//             'phone' => '+34 600 100 ' . sprintf('%03d', $i),
//             'email' => 'centro'.$i.'@generic.cat',
//             'status' => '1',
//             'created_at' => now(),
//             'updated_at' => now(),
//         ];
//     }
    
//     DB::table('centers')->insert($centers);
//     DB::table('centers')->insert($centers);
//     DB::table('centers')->insert($centers);
//     DB::table('centers')->insert($centers);
//     DB::table('centers')->insert($centers);
//     DB::table('centers')->insert($centers);
//     DB::table('centers')->insert($centers);
//     DB::table('centers')->insert($centers);
//     DB::table('centers')->insert($centers);
//     DB::table('centers')->insert($centers);
//     DB::table('centers')->insert($centers);
//     DB::table('centers')->insert($centers);
// }
}
