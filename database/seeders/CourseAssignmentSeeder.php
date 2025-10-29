<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Test assignment data
        $assignments = [
            // Course 1 assignments
            [
                'course_id' => 1,
                'professional_id' => 2,
                'certificate' => 'Pendent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 1,
                'professional_id' => 3,
                'certificate' => 'Pendent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 1,
                'professional_id' => 4,
                'certificate' => 'Entregat',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Course 2 assignments
            [
                'course_id' => 2,
                'professional_id' => 1,
                'certificate' => 'Pendent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 2,
                'professional_id' => 5,
                'certificate' => 'Pendent',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Course 3 assignments
            [
                'course_id' => 3,
                'professional_id' => 2,
                'certificate' => 'Entregat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 3,
                'professional_id' => 6,
                'certificate' => 'Pendent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 3,
                'professional_id' => 7,
                'certificate' => 'Pendent',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Course 4 assignments
            [
                'course_id' => 4,
                'professional_id' => 3,
                'certificate' => 'Pendent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 4,
                'professional_id' => 8,
                'certificate' => 'Pendent',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($assignments as $assignment) {
            DB::table('course_assignments')->insert($assignment);
        }
    }
}

