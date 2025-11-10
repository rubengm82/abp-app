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
            $table->date('opening_date')->comment('Opening date');
            $table->date('closing_date')->nullable()->comment('Closing date');
            
            // Professional references
            $table->foreignId('affected_professional_id')->constrained('professionals')->onDelete('cascade')->comment('Affected professional');
            $table->foreignId('registering_professional_id')->constrained('professionals')->onDelete('cascade')->comment('Professional who registered');
            $table->foreignId('referred_to_professional_id')->nullable()->constrained('professionals')->onDelete('set null')->comment('Professional referred to');
            
            // Issue details
            $table->text('description')->comment('Issue description');
            $table->enum('status', ['Obert', 'Tancat'])->default('Obert')->comment('Issue status');
            
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
