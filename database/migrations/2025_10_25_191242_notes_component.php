<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notes_component', function (Blueprint $table) {
            $table->id();
            $table->text('notes')->nullable();
            
            // Polymorphic relation:
            $table->morphs('noteable'); // creates noteable_id and noteable_type
            
            // Foreign key to professionals
            $table->foreignId('created_by_professional_id')
            ->nullable()
            ->constrained('professionals')
            ->nullOnDelete()
            ->comment('Professional that created the note');
            
            $table->integer('restricted')->nullable()->comment('Restricted note flag by role');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes_component');
    }
};
