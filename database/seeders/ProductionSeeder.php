<?php

// EXECUTE ONLY ONCE TO POPULATE THE DATABASE, NEVER AGAIN
// php artisan migrate:fresh
// php artisan db:seed --class=ProductionSeeder

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
         // Deactivate FKs → truncate safely and quickly
        Schema::disableForeignKeyConstraints();
        DB::table('general_services')->truncate();
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
                'permissions' => 'Gerència',
                'role' => 'Direcció',
                'name' => 'Zero',
                'surname1' => '',
                'surname2' => '',
                'dni' => '',
                'birth_date' => null,
                'first_hire_date' => null,
                'gender' => null,
                'education_level' => null,
                'phone' => '',
                'email' => null,
                'address' => null,
                'employment_status' => 'Fixe',
                'cvitae' => null,
                'cv_file_path' => null,
                'cv_file_original_name' => null,
                'user' => 'zero',
                'password' => 'zero', // automatic hash
                'locker_num' => null,
                'key_code' => null,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Hash passwords BEFORE inserting
        foreach ($professionals as &$professional) {
            // $p['password'] = Hash::make($p['password']);
            $professional['password'] = Hash::make($professional['password'], ['rounds' => 4]);
        }

        DB::table('centers')->insert($centers);

        // General Services (Kitchen, Cleaning, Laundry) for the center, like Center::created
        $now = now();
        $generalServices = [
            ['center_id' => 1, 'service_type' => 'Cuina',    'responsible' => null, 'responsible_info' => null, 'planning' => null, 'created_at' => $now, 'updated_at' => $now],
            ['center_id' => 1, 'service_type' => 'Neteja',   'responsible' => null, 'responsible_info' => null, 'planning' => null, 'created_at' => $now, 'updated_at' => $now],
            ['center_id' => 1, 'service_type' => 'Bugaderia','responsible' => null, 'responsible_info' => null, 'planning' => null, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('general_services')->insert($generalServices);

        DB::table('professionals')->insert($professionals);
    }
}
