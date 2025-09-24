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
        Schema::create('material_assignment', function (Blueprint $table) {
            $table->id();
            
            // Professional reference
            $table->foreignId('professional_id')->constrained('professional')->onDelete('cascade');
            
            // Material information
            $table->enum('material_type', ['uniforme', 'epi', 'equipamiento', 'otros'])->comment('Material type');
            $table->string('material_description', 255)->nullable()->comment('Material description');
            $table->string('size', 20)->nullable()->comment('Size (for uniforms)');
            
            // Assignment dates
            $table->date('assignment_date')->comment('Assignment date');
            $table->date('renewal_due_date')->nullable()->comment('Renewal due date');
            
            // Status and condition
            $table->enum('status', ['Activo', 'Renovado', 'Devuelto', 'Perdido'])->default('Activo')->comment('Assignment status');
            $table->enum('condition', ['Nuevo', 'Bueno', 'Regular', 'Malo'])->nullable()->comment('Material condition');
            
            // Assignment tracking
            $table->foreignId('assigned_by_professional_id')->nullable()->constrained('professional')->onDelete('set null')->comment('Professional who assigned');
            
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
        Schema::dropIfExists('material_assignment');
    }
};
