<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'service_type' => 'Cuina',
                'responsible' => "Pedro Sanchez",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_type' => 'Neteja',
                'responsible' => "Mariano García",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_type' => 'Bugadería',
                'responsible' => "El Ruibius",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Delete all records first before inserting data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('general_services')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('general_services')->insert($services);
    }
}

