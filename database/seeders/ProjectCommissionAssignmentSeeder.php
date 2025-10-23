<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectCommissionAssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Test assignment data
        $assignments = [
            // Project 1 assignments
            [
                'project_commission_id' => 1,
                'professional_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_commission_id' => 1,
                'professional_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_commission_id' => 1,
                'professional_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Project 2 assignments
            [
                'project_commission_id' => 2,
                'professional_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_commission_id' => 2,
                'professional_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_commission_id' => 2,
                'professional_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Project 3 assignments
            [
                'project_commission_id' => 3,
                'professional_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_commission_id' => 3,
                'professional_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_commission_id' => 3,
                'professional_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_commission_id' => 3,
                'professional_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Commission 1 assignments
            [
                'project_commission_id' => 4,
                'professional_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_commission_id' => 4,
                'professional_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Commission 2 assignments
            [
                'project_commission_id' => 5,
                'professional_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_commission_id' => 5,
                'professional_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'project_commission_id' => 5,
                'professional_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($assignments as $assignment) {
            DB::table('project_commission_assignments')->insert($assignment);
        }
    }
}