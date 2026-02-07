<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'training_center' => 'Casa Vapor Gran',
                'forcem_code' => 'CVG001',
                'center_id' => 1,
                'total_hours' => 40,
                'type' => 'Formació Interna',
                'attendance_type' => 'Presencial',
                'training_name' => 'Atenció integral a la gent gran',
                'start_date' => Carbon::parse('2025-11-01'),
                'end_date' => Carbon::parse('2025-11-05'),
            ],
            [
                'training_center' => 'Casa Marquès',
                'forcem_code' => 'CM002',
                'center_id' => 1,
                'total_hours' => 35,
                'type' => 'Formació Salut Laboral',
                'attendance_type' => 'Mixto',
                'training_name' => 'Estratègies de suport a persones amb trastorns mentals',
                'start_date' => Carbon::parse('2025-10-15'),
                'end_date' => Carbon::parse('2025-10-20'),
            ],
            [
                'training_center' => 'Centre Ocupacional Vallparadís',
                'forcem_code' => 'COV003',
                'center_id' => 1,
                'total_hours' => 30,
                'type' => 'Taller',
                'attendance_type' => 'Presencial',
                'training_name' => 'Taller d’habilitats laborals',
                'start_date' => Carbon::parse('2025-09-10'),
                'end_date' => Carbon::parse('2025-09-14'),
            ],
            [
                'training_center' => 'Residència La Muntanya',
                'forcem_code' => 'RLM004',
                'center_id' => 1,
                'total_hours' => 25,
                'type' => 'Formació Externa',
                'attendance_type' => 'Online',
                'training_name' => 'Atenció a persones amb mobilitat reduïda',
                'start_date' => Carbon::parse('2025-11-20'),
                'end_date' => Carbon::parse('2025-11-23'),
            ],
            [
                'training_center' => 'Centre de Rehabilitació Vallparadís',
                'forcem_code' => 'CRV005',
                'center_id' => 1,
                'total_hours' => 28,
                'type' => 'Seminari',
                'attendance_type' => 'Mixto',
                'training_name' => 'Rehabilitació física i ocupacional',
                'start_date' => Carbon::parse('2025-12-01'),
                'end_date' => Carbon::parse('2025-12-05'),
            ],
            [
                'training_center' => 'Centre Sociosanitari Terrassa',
                'forcem_code' => 'CST006',
                'center_id' => 1,
                'total_hours' => 32,
                'type' => 'Jorn',
                'attendance_type' => 'Presencial',
                'training_name' => 'Suport a famílies i cuidadors',
                'start_date' => Carbon::parse('2025-10-05'),
                'end_date' => Carbon::parse('2025-10-09'),
            ],
            [
                'training_center' => 'Escola d’Habilitats Vallparadís',
                'forcem_code' => 'EHV007',
                'center_id' => 1,
                'total_hours' => 36,
                'type' => 'Formació Interna',
                'attendance_type' => 'Online',
                'training_name' => 'Tècniques de comunicació i treball en equip',
                'start_date' => Carbon::parse('2025-11-10'),
                'end_date' => Carbon::parse('2025-11-15'),
            ],
            [
                'training_center' => 'Centre Terapèutic Vallparadís',
                'forcem_code' => 'CTV008',
                'center_id' => 2,
                'total_hours' => 40,
                'type' => 'Congrés',
                'attendance_type' => 'Mixto',
                'training_name' => 'Estratègies terapèutiques i ocupacionals',
                'start_date' => Carbon::parse('2025-12-10'),
                'end_date' => Carbon::parse('2025-12-15'),
            ],
        ];

        // Delete all data from the table before inserting data
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('courses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
