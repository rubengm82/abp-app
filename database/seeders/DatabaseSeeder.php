<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

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
