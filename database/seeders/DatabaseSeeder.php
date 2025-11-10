<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Run our custom seeders
        $this->call([
            CenterSeeder::class,
            ProfessionalSeeder::class,
            HrIssueSeeder::class,
            ProjectCommissionSeeder::class,
            MaterialAssignmentSeeder::class,
            QuizSeeder::class,
            EvaluationsSeeder::class,
            ProjectCommissionAssignmentSeeder::class,
            CourseSeeder::class,
            CourseAssignmentSeeder::class,
            ExternalContactSeeder::class,
        ]);
    }
}
