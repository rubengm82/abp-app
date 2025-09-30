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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            
            // Maintenance information
            $table->date('opening_date')->comment('Maintenance opening date');
            $table->text('description')->nullable()->comment('Maintenance description');
            
            // Professional reference
            $table->foreignId('assigned_to_professional_id')->nullable()->constrained('professionals')->onDelete('set null')->comment('Assigned professional');
            
            // Documents and dates
            $table->string('documents', 500)->nullable()->comment('Related documents');
            $table->date('end_date')->nullable()->comment('Maintenance end date');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
