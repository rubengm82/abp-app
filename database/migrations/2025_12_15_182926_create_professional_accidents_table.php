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
        Schema::create('professional_accidents', function (Blueprint $table) {
            $table->id();
            
            // Type: Sin baja, Con baja, or Baja Finalitzada
            $table->enum('type', ['Sin baja', 'Con baja', 'Baja Finalitzada'])->comment('Accident type: with or without leave, or ended leave');
            
            // Date of the accident
            $table->date('date')->comment('Accident date');
            
            // Context and description
            $table->text('context')->nullable()->comment('Accident context');
            $table->text('description')->nullable()->comment('Accident description');
            
            // Professional who fills the form (logged user)
            $table->foreignId('created_by_professional_id')->constrained('professionals')->onDelete('cascade')->comment('Professional who created the record');
            
            // Affected professional
            $table->foreignId('affected_professional_id')->constrained('professionals')->onDelete('cascade')->comment('Affected professional');
            
            // Fields for "Con baja" type
            $table->integer('duration')->nullable()->comment('Leave duration in days');
            $table->date('start_date')->nullable()->comment('Leave start date');
            $table->date('end_date')->nullable()->comment('Leave end date');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_accidents');
    }
};
