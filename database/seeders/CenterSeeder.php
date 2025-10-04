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
                'name' => 'Centre Principal',
                'address' => 'Carrer Principal, 123, Barcelona',
                'phone' => '+34 93 123 4567',
                'email' => 'principal@canserra.cat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Centre Secundari',
                'address' => 'Avinguda Secundària, 456, Barcelona',
                'phone' => '+34 93 234 5678',
                'email' => 'secundari@canserra.cat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Centre Terciari',
                'address' => 'Plaça Terciària, 789, Barcelona',
                'phone' => '+34 93 345 6789',
                'email' => 'terciari@canserra.cat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('centers')->insert($centers);
    }
}
