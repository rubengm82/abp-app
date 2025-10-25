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
            ProjectCommissionSeeder::class,
            MaterialAssignmentSeeder::class,
            ProjectCommissionNoteSeeder::class,
            ProfessionalNoteSeeder::class,
            CenterNoteSeeder::class,
            MaterialAssignmentNoteSeeder::class,
            QuizSeeder::class,
            EvaluationsSeeder::class,
            ProjectCommissionAssignmentSeeder::class,
        ]);
    }
}
