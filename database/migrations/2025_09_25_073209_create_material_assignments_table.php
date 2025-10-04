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
        Schema::create('material_assignments', function (Blueprint $table) {
            $table->id();
            
            // Professional reference
            $table->foreignId('professional_id')->constrained('professionals')->onDelete('cascade');
            
            // Size information (simplified structure)
            $table->string('shirt_size', 10)->nullable()->comment('Shirt size');
            $table->string('shoe_size', 10)->nullable()->comment('Shoe size');
            $table->string('pants_size', 10)->nullable()->comment('Pants size');
            
            // Assignment dates
            $table->date('assignment_date')->comment('Assignment date');
            
            // Assignment tracking
            $table->foreignId('assigned_by_professional_id')->nullable()->constrained('professionals')->onDelete('set null')->comment('Professional who assigned');
            
            // Additional information
            $table->text('observations')->nullable()->comment('Observations about material');
            $table->string('documents', 500)->nullable()->comment('Related documents');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_assignments');
    }
};
