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
        Schema::create('hr_issues', function (Blueprint $table) {
            $table->id();
            
            // Issue information
            $table->date('date')->comment('Issue date');
            
            // Professional references
            $table->foreignId('affected_professional_id')->constrained('professional')->onDelete('cascade')->comment('Affected professional');
            $table->foreignId('registering_professional_id')->constrained('professional')->onDelete('cascade')->comment('Professional who registered');
            
            // Issue details
            $table->string('referred_to', 255)->nullable()->comment('Referred to (free text)');
            $table->string('documents', 500)->nullable()->comment('Related documents');
            $table->date('end_date')->nullable()->comment('Issue resolution date');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_issues');
    }
};
