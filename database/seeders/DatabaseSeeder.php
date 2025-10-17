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
            ProjectCommissionDocumentSeeder::class,
            MaterialAssignmentSeeder::class,
            ProjectCommissionNoteSeeder::class,
            // New seeders for notes and documents
            ProfessionalNoteSeeder::class,
            ProfessionalDocumentSeeder::class,
            CenterNoteSeeder::class,
            CenterDocumentSeeder::class,
            MaterialAssignmentNoteSeeder::class,
            MaterialAssignmentDocumentSeeder::class,
        ]);
    }
}
